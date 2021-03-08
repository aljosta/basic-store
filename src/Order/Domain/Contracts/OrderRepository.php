<?php

namespace Src\Order\Domain\Contracts;

use Src\Order\Domain\OrderEntity;
use Src\Order\Domain\OrderId;

interface OrderRepository {
    public function search(OrderId $orderId): array;
    public function save(OrderEntity $orderEntity): void;
    public function update(OrderEntity $orderEntity, OrderId $orderId): void;
    public function getAll(): array;
    public function getSaveId(): int;
}