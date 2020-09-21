<?php


namespace App\Services;



use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

class PaypalPayment
{
    private $apiContext;
    private $payment;
    private $redirectUrls;
    private $payPalAmount;
    private $transaction;
    private $approvalUrl;

    private $router;

    public function __construct( RouterInterface $router)
    {
        $this->router = $router;
    }

    public function initPayPal($clientId, $clientSecret)
    {
        $this->apiContext= new ApiContext(
            new OAuthTokenCredential(
                $clientId,
                $clientSecret
            )
        );
    }

    public function definePayment($amount ,$baseUrl){
        $payer = new Payer();

        $payer->setPaymentMethod("paypal");
        $this->redirectUrls = new RedirectUrls();
        $this->redirectUrls->setReturnUrl($baseUrl.'/paypal-response')
            ->setCancelUrl($baseUrl.'/paypal_cancel');
        $this->payPalAmount= new Amount();
        $this->payPalAmount->setCurrency("MXN")
            ->setTotal($amount);
        $this->transaction= new Transaction();
        $this->transaction->setAmount($this->payPalAmount)
            ->setDescription("Payment description");
        $this->payment = new Payment();
        $this->payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($this->redirectUrls)
            ->setTransactions(array( $this->transaction));


    }
    public function createPayment(){
        try {
            $this->payment->create($this->apiContext);

            $this->approvalUrl = $this->payment->getApprovalLink();

            return ['url'=> $this->approvalUrl,'id'=>$this->payment->id ];

        }catch (PayPalConnectionException $ex){

            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        }catch (\Exception $ex){
            die($ex);
        }
    }

    public function paymentExecution($paymentId, $payerId)
    {

        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            return $payment->execute($execution, $this->apiContext);
        }
        catch (PayPalConnectionException $ex){
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        }
        catch (\Exception $ex){
            die($ex);
        }

    }
}