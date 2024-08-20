<?php

namespace App\Discount\Applicator;

use App\Discount\Dto\Input\OrderInput;
use App\Discount\Dto\Output\OrderOutput;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.order.discount.applicator')]
interface DiscountApplicatorInterface
{
    public const TYPE_ORDER_DISCOUNT = 'order_discount';
    public const TYPE_CATEGORY_DISCOUNT = 'category_discount';
    public const TYPE_MULTI_QUANTITY_DISCOUNT = 'multi_discount';

    public const PRIORITY_ORDER_DISCOUNT = 30;
    public const PRIORITY_CATEGORY_DISCOUNT = 20;
    public const PRIORITY_MULTI_QUANTITY_DISCOUNT = 10;


    public function supports(OrderInput $order): bool;

    public function apply(OrderOutput $order): void;

    public function getType(): string;

    public static function getDefaultPriority(): int;
}
