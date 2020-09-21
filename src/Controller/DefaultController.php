<?php

namespace App\Controller;


use App\Entity\Order;
use App\Entity\UserCourse;
use App\Repository\OrderRepository;
use App\Repository\UserCourseRepository;
use App\Services\Curl;
use App\Services\MercadoPago;
use App\Services\PaypalPayment;
use MercadoPago\MercadopagoSdkTest;
use MercadoPago\SDK;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;



class DefaultController extends AbstractController
{

    private $curl;
    private $result;
    /**
     * @var MercadoPago
     */
    private $mercadoPago;
    /**
     * @var PaypalPayment
     */
    private $paypalPayment;

    private $isApproved;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var UserCourseRepository
     */
    private $userCourseRepository;


    public function __construct(Curl $curl,
                                MercadoPago $mercadoPago,
                                PaypalPayment $paypalPayment,
                                RouterInterface $router,
                                OrderRepository $orderRepository,
                                UserCourseRepository $userCourseRepository )
    {

        $this->curl = $curl;
        $this->mercadoPago = $mercadoPago;
        $this->paypalPayment = $paypalPayment;
        $this->isApproved =  false;
        $this->router = $router;
        $this->orderRepository = $orderRepository;
        $this->userCourseRepository = $userCourseRepository;
    }

    /**
     * @Route("/{wildcard}", name="default", requirements={"wildcard"="/?.*"}, priority=-2)
     */
    public function index(SerializerInterface $serializer )

    {


        $this->mercadoPago->setAccessToken($this->getParameter('mercado_pago_api'));

        setcookie('_d2id', '13529453-597e-4399-ad32-8a72388ab593-n', ['samesite' => 'None', 'secure' => true]);
        return $this->render('default/index.html.twig',[
         'user'=>$serializer->serialize($this->getUser(), 'json'),
            'isApproved' => $this->isApproved

        ]);
    }

    /**
     * @Route("/payment", name="payment", methods={"POST"})
     *
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function mercadoPago(Request $request, MercadoPago $mercadoPago ,HttpClientInterface $httpClient){

        $data = json_decode($request->getContent(), true);

        $mercadoPago->setAccessToken($this->getParameter('mercado_pago_api'));
        $payer= ["email"=> $data['email']];
        $amount= (float)$data['transaction_amount'];
        $installments= (int)$data['installments'];

        //$mercadoPago->testUser();

       $response =$mercadoPago->paymentMethod($amount, $data['token'],$data['description'],


           $installments,$data['payment_method_id'], $payer);




       /*$curlData = ['token'=>$data['token'],
                 'installments'=> $installments,
                    'transaction_amount'=> $amount,
                    'description'=>$data['description'],

                    'payment_method_id'=>$data['payment_method_id'],
                    'payer'=>$payer
        ];





        $mercadoPagoUrl= $this->getParameter('mercado_pago_url');
        $accessToken = $this->getParameter('mercado_pago_api');
        $apiUrl= $mercadoPagoUrl.'?access_token='.$accessToken;






    $jsonCurlData = json_encode($curlData);
     $this->mercadopagoRequest($apiUrl, $jsonCurlData);*/




       return new JsonResponse(["data"=>$response]);


    }

    /**
     * @Route("/payment-pro", name="payment-pro", methods={"POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     *
     */
    public function checkoutPro(  Request $request){

        $baseUrl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();

        $data = json_decode($request->getContent(), true);
        $this->mercadoPago->setAccessToken($this->getParameter('mercado_pago_api'));
      //  $this->mercadoPago->testUser();
        $price= (float)$data['transaction_amount'];
        $amount= $data['amount'];
        $response=  $this->mercadoPago->preferenceMethod($amount, $price, $baseUrl);


        return new JsonResponse(['url'=>$response['url'], 'id'=>$response['id']]);



    }
    private  function mercadopagoRequest($urlEndpoint, $data){



        try {
            $this->curl->setDebug(true);
            $this->curl->setUrl($urlEndpoint);
            $this->curl->setMethod('POST');
            $this->curl->setContentType("application/json");
            $this->curl->setData($data);
           // $this->curl->setHttpHeader('x-api-secret: '. $api_wish_secret);
            $this->curl->returnRequest(true);
            $results = $this->curl->execute();
            $this->result= $results;
            $this->curl->reset();

        }
        catch (\Exception $e){


            return $this->json([
                'message' => 'Curl error---'. $e->getMessage(),

            ],400);
        }

    }


    /**
     * @Route("/paypal-pro", name="paypal-pro", methods={"POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     *
     */
    public function payPalRequest(Request $request){
        $baseUrl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();

        $data = json_decode($request->getContent(), true);
        $price= (float)$data['transaction_amount'];
       $clientId=  $this->getParameter('paypal_client_id');
       $clientSecret=  $this->getParameter('paypal_client_secret');
         $this->paypalPayment->initPayPal($clientId, $clientSecret );
         $this->paypalPayment->definePayment($price,$baseUrl);
            $response  = $this->paypalPayment->createPayment();
        return new JsonResponse(['url'=>$response['url'], 'id'=>$response['id']]);
         //dd($this->paypalPayment->createPayment());


    }
    /**
     * @Route("/mercado-response", name="mercado_response", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     *
     */
    public function mercadoPagoResponse(Request $request){


        $preferenceId = $request->query->get('preference_id');
        $order = $this->orderRepository->findOneBy(['refIdMercado'=>$preferenceId]);
        if($order){
           $this->updateOrderUserCourse($order, true, false, true);
        }


        return $this->redirect('/');
    }
    /**
     * @Route("/mercado-response-cancel", name="mercado_response_cancel", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     *
     */
    public function mercadoPagoResponseCancel(Request $request){



        $preferenceId = $request->query->get('preference_id');
        $order = $this->orderRepository->findOneBy(['refIdMercado'=>$preferenceId]);
        if($order){
            $this->updateOrderUserCourse($order, false, false, false);
        }


        return $this->redirect('/');
    }
    /**
     * @Route("/mercado-response-pending", name="mercado_response_pending", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     *
     */
    public function mercadoPagoResponsePending(Request $request){

        $preferenceId = $request->query->get('preference_id');
        $order = $this->orderRepository->findOneBy(['refIdMercado'=>$preferenceId]);
        if($order){
            $this->updateOrderUserCourse($order, false, true, false);
        }


        return $this->redirect('/');
    }

    /**
     * @Route("/paypal-response", name="paypal_response", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     *
     */
     public function paypalResponse(Request $request){


         $paymentId =  $request->get('paymentId');
         $payerId = $request->get('PayerID');


         $clientId=  $this->getParameter('paypal_client_id');
         $clientSecret=  $this->getParameter('paypal_client_secret');
         $this->paypalPayment->initPayPal($clientId, $clientSecret );
         $response =$this->paypalPayment->paymentExecution($paymentId, $payerId);
         if($response){
             $order = $this->orderRepository->findOneBy(['tokenPayPal'=>$paymentId]);
             if($order){
                 $this->updateOrderUserCourse($order, true, false, true);
             }

         }





         return $this->redirect('/');



     }
    /**
     * @Route("/paypal-cancel", name="paypal_cancel", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     *
     */
    public function paypalCancel(Request $request){

        $paymentId =  $request->get('paymentId');
        $order = $this->orderRepository->findOneBy(['tokenPayPal'=>$paymentId]);
        if($order){
            $this->updateOrderUserCourse($order, false, false, false);
        }
        return $this->redirect('/');
    }
    private function updateOrderUserCourse(Order $order, $approved, $pending, $isPayed ){
        $order->setIsApproved($approved);
        $order->setIsPending($pending);
        $order= $this->orderRepository->updateOrder($order);
        $usersCourses= $order->getUsersCourses()->toArray();
        /**
         * @var UserCourse $userCourse
         */
        foreach ($usersCourses as  $userCourse){
            $userCourse->setIsPayed($isPayed);
            $this->userCourseRepository->updateUserCourse($userCourse);
        }
    }
}
