<?php

namespace Src\Order\Domain\Contracts;

use Src\Order\Domain\OrderEntity;
use Src\Order\Domain\OrderRequestId;

interface PaymentService {
    public function createRequest(OrderEntity $order): array;
    public function getRequestInformation(OrderRequestId $requesId): array;
}