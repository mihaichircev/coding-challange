<?php

namespace App\Discount\Applicator;

use App\Discount\Dto\Input\OrderInput;
use App\Discount\Dto\ItemInterface;
use App\Discount\Dto\Output\DiscountOutput;
use App\Discount\Dto\Output\OrderOutput;

class CategoryDiscountApplicator implements DiscountApplicatorInterface
{
    private const DISCOUNT_CATEGORY_NAME = 'B1';
    private const DISCOUNT_MIN_QUANTITY = 5;

    public function supports(OrderInput $orderInput): bool
    {
        foreach ($orderInput->getItems() as $item) {
            if ($this->hasDiscountedCategory($item) && $this->hasMinQuantity($item)) {
                return true;
            }
        }

        return false;
    }

    public function apply(OrderOutput $orderOutput): void
    {
        foreach ($orderOutput->getItems() as $item) {
            if (false === ($this->hasDiscountedCategory($item) && $this->hasMinQuantity($item))) {
                continue;
            }

            $discountValue = $item->getUnitPrice();
            $itemTotalWithDiscount = round($item->getTotalWithDiscount() - $discountValue, 2);
            $item->setTotalWithDiscount($itemTotalWithDiscount);

            $orderTotalWithDiscount = round($orderOutput->getTotalWithDiscount() - $discountValue, 2);
            $orderOutput->setTotalWithDiscount($orderTotalWithDiscount);

            $discount = new DiscountOutput($this->getType(), $discountValue);
            $orderOutput->addDiscount($discount);
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

    private function hasDiscountedCategory(ItemInterface $item): bool
    {
        return self::DISCOUNT_CATEGORY_NAME === substr($item->getProductId(), 0, 2);
    }

    private function hasMinQuantity(ItemInterface $item): bool
    {
        return self::DISCOUNT_MIN_QUANTITY < $item->getQuantity();
    }
}
