<?php

declare(strict_types=1);

namespace Src\Order\Application;

use Src\Order\Domain\Contracts\OrderRepository;
use Src\Order\Domain\OrderId;

final class FindOrderUseCase {

    private $orderRepository;

    public function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
        
    }

    public function execute(int $orderId): array {
        return $dataOrder = $this->orderRepository->search(new OrderId($orderId));
    }

}
