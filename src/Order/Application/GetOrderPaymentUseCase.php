<?php

declare(strict_types=1);

namespace Src\Order\Application;

use Src\Order\Domain\Contracts\OrderRepository;
use Src\Order\Domain\Contracts\PaymentService;
use Src\Order\Domain\OrderEntity;
use Src\Order\Domain\OrderId;
use Src\Order\Domain\OrderStatus;

final class GetOrderPaymentUseCase {

    private $paymentService;
    private $orderRepository;

    public function __construct(PaymentService $paymentService, OrderRepository $orderRepository) {
        $this->paymentService = $paymentService;
        $this->orderRepository = $orderRepository;
        $this->findOrder = new FindOrderUseCase($this->orderRepository);
        $this->updateOrder = new UpdateOrderUseCase($this->orderRepository);
    }

    public function execute(int $orderId): array {
        $orderArray = $this->findOrder->execute($orderId);
        $order = OrderEntity::createOrderWithIdFromArray($orderArray);

        if ($order->getStatus()->isPending()) {
            $response = $this->paymentService->getRequestInformation($order->getRequestId());
            
            $order->setStatus(new OrderStatus($response['status']));
            $this->updateOrder->execute($order, new OrderId($orderId));
        }

        return $order->toArray();
    }
}
