<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Pay;
use Illuminate\Http\Request;
use App\Models\Order;
use DateTime;
use Illuminate\Support\Facades\Http;

class PayController extends Controller
{
    private $url = 'https://dev.placetopay.com/redirection/';
    private $login = "6dd490faf9cb87a9862245da41170ff2";
    private $secretKey = "024h1IlD";
    private $client;

    public function __construct(Client $client)
    {
        $this->client= $client;
    }


    public function createRequest(Order $order) {
        
        $fullPath = $this->url."api/session/";

        $body = [
            "auth" => $this->getAuth(),
            "locale" => "en_CO",
            "buyer" => [
                "name" => $order->customer_name,
                "email" => $order->customer_email,
                "mobile" => $order->customer_mobile
            ],
            "payment" => [
                "reference" => $order->id,
                 "description" => "Pago Test",
                "amount" => [
                    "currency" => "COP",
                    "total" => "10000"
                ],
                "allowPartial" => false
            ],
            "expiration" => $this->getDateIso8601("expiration"), 
            "returnUrl" => "http://basic-store.test/order/".$order->id, 
            "ipAddress" => "127.0.0.1",
            "userAgent" => "PlacetoPay Sandbox"
        ];
       
        $response = Http::post($fullPath, $body);
        $responseBody = json_decode($response->getBody());

        return array(
            'status' => $responseBody->status->status, 
            'requestId' => $responseBody->requestId, 
            'processUrl' => $responseBody->processUrl
        );
    }

    public function getRequestInformation($requestId) {

        $fullPath = $this->url."api/session/".$requestId;

        $body = [
            "auth" => $this->getAuth(),
        ];
       
        $response = Http::post($fullPath, $body);
        $responseBody = json_decode($response->getBody());
        $infoPayment['status'] = $responseBody->status->status;
    
        return $infoPayment;
    }

    private function getAuth() {
        $nonce = bin2hex(random_bytes(10));
        $seed = $this->getDateIso8601();
        $tranKey = base64_encode(sha1($nonce.$seed.$this->secretKey, true));

        $auth = [
            "login" => $this->login,
            "tranKey" => $tranKey,
            "nonce" => base64_encode($nonce),
            "seed" => $seed
        ];

        return $auth;
    }

    private function getDateIso8601($type = ""){
        $dateTime = new DateTime('NOW');
        
        if ($type == "expiration") {
            $dateTime->modify("+1 hour");
        } 

        return $dateTime->format('c');
    }
}
