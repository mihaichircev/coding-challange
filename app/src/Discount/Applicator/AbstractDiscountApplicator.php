<?php

namespace App\Discount\Applicator;

use App\Discount\Dto\Output\DiscountOutput;
use App\Discount\Dto\Output\ItemOutput;
use App\Discount\Dto\Output\OrderOutput;

abstract class AbstractDiscountApplicator implements DiscountApplicatorInterface
{
    protected function applyOrderDiscount(OrderOutput $order, float $discountValue): void
    {
        $orderTotalWithDiscount = round($order->getTotalWithDiscount() - $discountValue, 2);
        $order->setTotalWithDiscount($orderTotalWithDiscount);

        $discount = new DiscountOutput($this->getType(), $discountValue);
        $order->addDiscount($discount);
    }

    protected function applyItemDiscount(ItemOutput $item, float $discountValue): void
    {
        $itemTotalWithDiscount = round($item->getTotalWithDiscount() - $discountValue, 2);
        $item->setTotalWithDiscount($itemTotalWithDiscount);
    }
}
