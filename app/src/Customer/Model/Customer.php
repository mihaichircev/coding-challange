<?php

namespace App\Customer\Model;

class Customer
{
    public function __construct(
        private int $id,
        private float $totalOrders
    ) {
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setTotalOrders(float $totalOrders): self
    {
        $this->totalOrders = $totalOrders;

        return $this;
    }

    public function getTotalOrders(): float
    {
        return $this->totalOrders;
    }
}
