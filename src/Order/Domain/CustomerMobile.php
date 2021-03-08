<?php

declare(strict_types=1);

namespace Src\Order\Domain;

use Exception;

final class CustomerMobile {
    
    private $value;

    public function __construct(int $value){
        $this->value = $value;
    }

    public function getValue(): int{
        return $this->value;
    }

    private function setMobile(string $mobile): void {
        if(empty($mobile)){
            throw new Exception("el télefono es requerido");
        }

        $this->value = $mobile;
    }

}