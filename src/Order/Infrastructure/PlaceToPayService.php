<?php

declare(strict_types=1);

namespace Src\Order\Infrastructure;

use DateTime;
use Illuminate\Support\Facades\Http;
use Src\Order\Domain\Contracts\PaymentService;
use Src\Order\Domain\OrderEntity;
use Src\Order\Domain\OrderRequestId;

final class PlaceToPayService implements PaymentService {

    private $url = 'https://dev.placetopay.com/redirection/';
    private $login = "6dd490faf9cb87a9862245da41170ff2";
    private $secretKey = "024h1IlD";

    public function __construct() {

    }

    public function createRequest(OrderEntity $order): array {
        $fullPath = $this->url."api/session/";

        $body = [
            "auth" => $this->getAuth(),
            "locale" => "en_CO",
            "buyer" => [
                "name" => $order->getName()->getValue(),
                "email" => $order->getEmail()->getValue(),
                "mobile" => $order->getMobile()->getValue()
            ],
            "payment" => [
                "reference" => $order->getId()->getValue(),
                 "description" => "Pago Test",
                "amount" => [
                    "currency" => "COP",
                    "total" => "10000"
                ],
                "allowPartial" => false
            ],
            "expiration" => $this->getDateIso8601("expiration"), 
            "returnUrl" => "http://basic-store.test/order/".$order->getId()->getValue(), 
            "ipAddress" => "127.0.0.1",
            "userAgent" => "PlacetoPay Sandbox"
        ];

        $response = Http::post($fullPath, $body);
    
        $responseBody = json_decode($response->body());

        return array(
            'status' => $responseBody->status->status, 
            'requestId' => $responseBody->requestId, 
            'processUrl' => $responseBody->processUrl
        );
    }
    
    public function getRequestInformation(OrderRequestId $requestId): array {
        $fullPath = $this->url."api/session/".$requestId->getValue();

        $body = [
            "auth" => $this->getAuth(),
        ];
       
        $response = Http::post($fullPath, $body);
       
        $responseBody = json_decode($response->body());

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