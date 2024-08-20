<?php

namespace App\Discount\Applicator;

use App\Discount\Dto\Input\OrderInput;
use App\Discount\Dto\ItemInterface;
use App\Discount\Dto\Output\OrderOutput;

class CategoryDiscountApplicator extends AbstractDiscountApplicator
{
    private const DISCOUNT_CATEGORY_NAME = 'B1';
    private const DISCOUNT_MIN_QUANTITY = 5;

    public function supports(OrderInput $order): bool
    {
        foreach ($order->getItems() as $item) {
            if ($item->hasCategory(self::DISCOUNT_CATEGORY_NAME) && $this->hasMinQuantity($item)) {
                return true;
            }
        }

        return false;
    }

    public function apply(OrderOutput $order): void
    {
        foreach ($order->getItems() as $item) {
            if (false === ($item->hasCategory(self::DISCOUNT_CATEGORY_NAME) && $this->hasMinQuantity($item))) {
                continue;
            }

            $discountValue = $item->getUnitPrice();

            $this->applyItemDiscount($item, $discountValue);
            $this->applyOrderDiscount($order, $discountValue);
        }
    }

    public function getType(): string
    {
        return self::TYPE_CATEGORY_DISCOUNT;
    }

    public static function getDefaultPriority(): int
    {
        return self::PRIORITY_CATEGORY_DISCOUNT;
    }

    private function hasMinQuantity(ItemInterface $item): bool
    {
        return self::DISCOUNT_MIN_QUANTITY < $item->getQuantity();
    }
}
