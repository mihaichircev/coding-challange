<?php

namespace App\Discount\Dto\Output;

class DiscountOutput
{
    public function __construct(
        private readonly string $type,
        private readonly float $value
    ) {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
