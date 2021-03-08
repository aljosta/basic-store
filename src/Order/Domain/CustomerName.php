<?php

declare(strict_types=1);

namespace Src\Order\Domain;

use Exception;

final class CustomerName {
    
    private $value;

    public function __construct(string $value){
        $this->setName($value);
    }

    public function getValue(): string{
        return $this->value;
    }

    private function setName(string $name): void {
        if(empty($name)){
            throw new Exception("el nombre es requerido");
        }

        $this->value = $name;
    }


}
