<?php

namespace App\Discount\Applicator;

use App\Discount\Dto\Input\OrderInput;
use App\Discount\Dto\Output\OrderOutput;

class CategoryDiscountApplicator implements DiscountApplicatorInterface
{
    public function supports(OrderInput $orderInput): bool
    {
        return false;
    }

    public function apply(OrderOutput $orderOutput): void {}

    public function getType(): string
    {
        return self::TYPE_CATEGORY_DISCOUNT;
    }

    public static function getDefaultPriority(): int
    {
        return self::PRIORITY_CATEGORY_DISCOUNT;
    }
}
