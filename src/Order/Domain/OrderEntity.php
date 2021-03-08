<?php

declare(strict_types=1);

namespace Src\Order\Domain;

use Src\Order\Domain\Exceptions\OrderIsNotStatusCreated;

final class OrderEntity {

    private $id;
    private $name;
    private $email;
    private $mobile;
    private $status;
    private $requestId;
    private $createdAt;
    private $updatedAt;
    
    public function __construct(CustomerName $name, CustomerEmail $email, CustomerMobile $mobile, OrderStatus $status) {
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->status = $status;
    }

    public static function createOrderWithId(OrderId $id, CustomerName $name, CustomerEmail $email, CustomerMobile $mobile, OrderStatus $status) {
        $order = new self($name, $email, $mobile, $status);
        $order->setId($id);
        return $order;
    }

    public static function createOrderWithIdFromArray(array $dataOrder): self {
        $order = new self(
            new CustomerName($dataOrder['customer_name']),
            new CustomerEmail($dataOrder['customer_email']),
            new CustomerMobile((int) $dataOrder['customer_mobile']),
            new OrderStatus($dataOrder['status'])
        );
        $order->setId(new OrderId($dataOrder['id']));
        
        if(!empty($dataOrder['request_id'])){
            $order->setRequestId(new OrderRequestId($dataOrder['request_id']));
        }
        
        $order->setCreatedAt($dataOrder['created_at']);
        $order->setUpdatedAt($dataOrder['updated_at']);
        return $order;
    }

    public function getId() {
        return $this->id;
    }

    public function setId(OrderId $id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName(CustomerName $name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail(CustomerEmail $email) {
        $this->email = $email;
    }

    public function getMobile() {
        return $this->mobile;
    }

    public function setMobile(CustomerMobile $mobile) {
        $this->mobile = $mobile;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus(OrderStatus $status) {
        $this->status = $status;
    }

    public function getRequestId() {
        return $this->requestId;
    }

    public function setRequestId(OrderRequestId $requestId) {
        $this->requestId = $requestId;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = date('Y-m-d H:i:s', strtotime($createdAt));
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = date('Y-m-d H:i:s', strtotime($updatedAt));  
    }

    public function toArray(): array {
        $orderArray = [         
            'customer_name' => $this->name->getValue(),
            'customer_email' => $this->email->getValue(),
            'customer_mobile' => $this->mobile->getValue(),
            'status' => $this->status->getValue(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
        ];

        if(!empty($this->id)) {
            $orderArray['id'] = $this->id->getValue();
        }

        if(!empty($this->requestId)) {
            $orderArray['request_id'] = $this->requestId->getValue();
        }

        return $orderArray;
    }

    public function validateIfStatusIsCreated(): void {
        if (!$this->status->isCreated()) {
            throw new OrderIsNotStatusCreated('La orden tiene un estado diferente a creada');
        }
    }

    public function isPending(): bool {
        return $this->status->isPending();
    }
}