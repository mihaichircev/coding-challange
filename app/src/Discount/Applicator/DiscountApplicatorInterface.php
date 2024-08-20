<?php

namespace App\Discount\Applicator;

use App\Discount\Dto\Input\OrderInput;
use App\Discount\Dto\Output\OrderOutput;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.order.discount.applicator')]
interface DiscountApplicatorInterface
{
    const TYPE_ORDER_DISCOUNT = 'order_discount';
    const TYPE_CATEGORY_DISCOUNT = 'category_discount';
    const TYPE_MULTI_QUANTITY_DISCOUNT = 'multi_discount';

    const PRIORITY_ORDER_DISCOUNT = 30;
    const PRIORITY_CATEGORY_DISCOUNT = 20;
    const PRIORITY_MULTI_QUANTITY_DISCOUNT = 10;


    public function supports(OrderInput $order): bool;

    public function apply(OrderOutput $order): void;

    public function getType(): string;

    public static function getDefaultPriority(): int;
}
