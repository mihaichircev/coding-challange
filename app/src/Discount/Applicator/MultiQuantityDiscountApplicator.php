<?php

namespace App\Discount\Applicator;

use App\Discount\Dto\CategoryAwareInterface;
use App\Discount\Dto\Input\OrderInput;
use App\Discount\Dto\ItemInterface;
use App\Discount\Dto\Output\ItemOutput;
use App\Discount\Dto\Output\OrderOutput;

class MultiQuantityDiscountApplicator extends AbstractDiscountApplicator
{
    private const DISCOUNT_CATEGORY_NAME = 'B1';
    private const DISCOUNT_CATEGORY_THRESHOLD = 2;
    private const DISCOUNT_VALUE = 0.2;

    public function supports(OrderInput $order): bool
    {
        $items = $this->getItemsForDiscountedCategory($order->getItems());

        return $this->hasItemCountAboveThreshold($items);
    }

    public function apply(OrderOutput $order): void
    {
        /** @var ItemOutput[] $items */
        $items = $this->getItemsForDiscountedCategory($order->getItems());
        $item = $this->getItemWithMinimumPrice($items);

        $discountValue = round($item->getUnitPrice() * self::DISCOUNT_VALUE, 2);

        $this->applyItemDiscount($item, $discountValue);
        $this->applyOrderDiscount($order, $discountValue);
    }

    public function getType(): string
    {
        return self::TYPE_MULTI_QUANTITY_DISCOUNT;
    }

    public static function getDefaultPriority(): int
    {
        return self::PRIORITY_MULTI_QUANTITY_DISCOUNT;
    }

    /**
     * @param ItemInterface[] $items
     * @return ItemInterface[]
     */
    private function getItemsForDiscountedCategory(array $items): array
    {
        return array_filter($items, function ($item) {
            /** @var CategoryAwareInterface $item */
            return $item->hasCategory(self::DISCOUNT_CATEGORY_NAME);
        });
    }

    /**
     * @param ItemOutput[] $items
     */
    private function getItemWithMinimumPrice(array $items): ItemOutput
    {
        for ($i = 1, $min = $items[0]; $i < count($items); $i++) {
            if ($items[$i]->getUnitPrice() < $min->getUnitPrice()) {
                $min = $items[$i];
            }
        }

        return $min;
    }

    /**
     * @param ItemInterface[] $items
     */
    private function hasItemCountAboveThreshold(array $items): bool
    {
        return count($items) >= self::DISCOUNT_CATEGORY_THRESHOLD;
    }
}
