<?php

declare(strict_types=1);

namespace Src\Order\Domain;

use Exception;

final class OrderStatus {
    
    public static $CREATED = 'CREATED';
    public static $PENDING = 'PENDING';
    public static $REJECTED = 'REJECTED';
    public static $APPROVED = 'APPROVED';

    private $value;

    public function __construct(string $value){
        $this->value = $value;
    }

    public function getValue(): string {
        return $this->value;
    }

    private function setStatus(string $status): void {
        if(empty($status)){
            throw new Exception("el Estado es requerido");
        }

        $this->value = $status;
    }

    public function isCreated(): bool {
        return $this->value == self::$CREATED;
    }

    public function isPending(): bool {
        return $this->value == self::$PENDING;
    }
}
