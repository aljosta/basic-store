<?php

declare(strict_types=1);

namespace Src\Order\Application;

use Src\Order\Domain\Contracts\OrderRepository;
use Src\Order\Domain\OrderEntity;
use Src\Order\Domain\OrderId;

final class UpdateOrderUseCase {

    private $orderRepository;

    public function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;

    } 

    public function execute(OrderEntity $order, OrderId $orderId) {
        $this->orderRepository->update($order, $orderId);
    } 

}