<?php

declare(strict_types=1);

namespace Src\Order\Domain;

use Exception;
use Src\Order\Domain\Exceptions\IncorrectEmail;

final class CustomerEmail {
    
    private $value;

    public function __construct(string $value){
        $this->setEmail($value);
    }

    public function getValue(): string {
        return $this->value;
    }

    private function setEmail(string $email){

        if (empty($email)) {
            throw new Exception("El email es requerido");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new IncorrectEmail("");
        }

        $this->value = $email;
    }

                 
}