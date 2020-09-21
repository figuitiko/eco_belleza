<?php


namespace App\Services;


use MercadoPago\Item;
use MercadoPago\Preference;
use MercadoPago\SDK;
use MercadoPago\Payment;


class MercadoPago
{

    private $mercadopago;


    public function setAccessToken($token){
        SDK::setAccessToken($token);
    }
    public function paymentMethod($amount, $token, $description,$installments, $payment_method_id, $payer){
        $payment= new Payment();

        $payment->transaction_amount = $amount;
        $payment->token = $token;
        $payment->description = $description;
        $payment->installments = $installments;
        $payment->payment_method_id = $payment_method_id;
        $payment->payer = $payer;


        $payment->save();


       // dd($payment->status);
        return $payment->status;
    }
    public function preferenceMethod($amount, $price, $baseUrl){

        $preference = new Preference();
        $preference->back_urls = array(
            "success" => "$baseUrl/mercado-response",
            "failure" => "$baseUrl/mercado-response-cancel",
            "pending" => "$baseUrl/mercado-response-pending"
        );
        $preference->auto_return = "approved";
        $item= new Item();
        $item->title = 'courses';
        $item->quantity = $amount;
        $item->unit_price = $price;
        $preference->items = array($item);
        $preference->save();

       // dd($preference->id);
        return ['url'=> $preference->init_point,
                'id'=>$preference->id];



    }
    public function  testUser(){


        $body = array(
            "json_data" => array(
                "site_id" => "MLM"
            )
        );

        $result = SDK::post('/users/test_user', $body);
        dd($result);

    }

}