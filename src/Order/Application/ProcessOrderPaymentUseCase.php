<?php

declare(strict_types=1);

namespace Src\Order\Application;

use Src\Order\Domain\Contracts\OrderRepository;
use Src\Order\Domain\Contracts\PaymentService;
use Src\Order\Domain\OrderEntity;
use Src\Order\Domain\OrderId;
use Src\Order\Domain\OrderRequestId;
use Src\Order\Domain\OrderStatus;

final class ProcessOrderPaymentUseCase {

    private $paymentService;
    private $orderRepository;
    private $findOrder;

    public function __construct(PaymentService $paymentService, OrderRepository $orderRepository) {
        $this->paymentService = $paymentService;
        $this->orderRepository = $orderRepository;
        $this->findOrder = new FindOrderUseCase($this->orderRepository);
        $this->updateOrder = new UpdateOrderUseCase($this->orderRepository);
    }

    public function execute(int $orderId): string {
        $orderArray = $this->findOrder->execute($orderId);
        $order = OrderEntity::createOrderWithIdFromArray($orderArray);

        $order->validateIfStatusIsCreated();
        
        $response = $this->paymentService->createRequest($order);
        
        $order->setRequestId(new OrderRequestId((string) $response['requestId']));
        $order->setStatus(new OrderStatus(OrderStatus::$PENDING));
        $this->updateOrder->execute($order, new OrderId($orderId));

        return $response['processUrl'];

    }
}
