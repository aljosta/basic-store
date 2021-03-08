<?php

declare(strict_types=1);

namespace Src\Order\Application;

use Src\Order\Domain\Contracts\OrderRepository;
use Src\Order\Domain\CustomerEmail;
use Src\Order\Domain\CustomerMobile;
use Src\Order\Domain\CustomerName;
use Src\Order\Domain\OrderEntity;
use Src\Order\Domain\OrderStatus;

final class CreateOrderUseCase {

    private $orderRepository;

    public function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;

    } 

    public function execute(string $name, string $email, int $mobile, string $status) {

         $order = new OrderEntity(
            new CustomerName($name),
            new CustomerEmail($email),
            new CustomerMobile($mobile),
            new OrderStatus($status)    
         );

         $this->orderRepository->save($order);
        
    } 

}