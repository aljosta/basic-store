<?php

declare(strict_types=1);

namespace Src\Order\Domain;

use Exception;

final class OrderId {
    
    private int $value;

    public function __construct(int $value){
        $this->value = $value;
    }

    public function getValue(): int {
        return $this->value;
    }

    private function setId(int $id): void {
        if(empty($id)){
            throw new Exception("el Id es requerido");
        }

        if($id <= 0){
            throw new Exception("el Id es invalido");
        }

        $this->value = $id;
    }


}
