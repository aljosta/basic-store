<?php

declare(strict_types=1);

namespace Src\Order\Application;

use Src\Order\Domain\Contracts\OrderRepository;

final class GetAllOrdersUseCase {

    private $orderRepository;

    public function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
        
    }

    public function execute(): array {
        return $dataOrders = $this->orderRepository->getAll();
    }
}
