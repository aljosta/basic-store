<?php

declare(strict_types=1);

namespace Src\Order\Domain;

use Exception;

final class OrderRequestId {
    
    private $value;

    public function __construct(string $value){
        $this->value = $value;
    }

    public function getValue(): string {
        return $this->value;
    }

    private function setRequestId(string $requestId): void {
        if(empty($requestId)){
            throw new Exception("el requestId es requerido");
        }

        $this->value = $requestId;
    }


}
