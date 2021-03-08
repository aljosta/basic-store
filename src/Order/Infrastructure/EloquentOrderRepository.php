<?php

declare(strict_types=1);

namespace Src\Order\Infrastructure;

use App\Models\Order;
use Src\Order\Domain\Contracts\OrderRepository;
use Src\Order\Domain\OrderEntity;
use Src\Order\Domain\OrderId;

final class EloquentOrderRepository implements OrderRepository {

    private $model;
    private $saveId;

    public function __construct() {
        
        $this->model = new Order();
    }

    public function search(OrderId $orderId): array {
        return $this->model->findOrFail($orderId->getValue())->toArray();
    }

    public function save(OrderEntity $orderEntity): void {
        $this->model->fill($orderEntity->toArray());
        $this->model->save();
        $this->saveId = $this->model->id;
    }

    public function update(OrderEntity $orderEntity, OrderId $orderId): void{
        $this->model->where('id', $orderId->getValue())->update($orderEntity->toArray());
    }

    public function getAll(): array {
        return $this->model->get()->toArray();
    }

    public function getSaveId(): int {
        return $this->saveId;
    }

}