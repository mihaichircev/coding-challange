<?php

namespace App\Discount\Applicator;

use App\Discount\Dto\Input\OrderInput;
use App\Discount\Dto\Output\OrderOutput;

class MultiQuantityDiscountApplicator implements DiscountApplicatorInterface
{
    public function supports(OrderInput $orderInput): bool
    {
        return false;
    }

    public function apply(OrderOutput $orderOutput): void {}

    public function getType(): string
    {
        return self::TYPE_MULTI_QUANTITY_DISCOUNT;
    }

    public static function getDefaultPriority(): int
    {
        return self::PRIORITY_MULTI_QUANTITY_DISCOUNT;
    }
}
