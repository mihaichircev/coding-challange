<?php

namespace App\Discount\Dto;

interface ItemInterface
{
    public function getProductId(): string;

    public function getQuantity(): int;

    public function getUnitPrice(): float;

    public function getTotal(): float;
}
