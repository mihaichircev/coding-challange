<?php

namespace App\Discount\Applicator;

use App\Customer\Repository\CustomerRepository;
use App\Discount\Dto\Input\OrderInput;
use App\Discount\Dto\Output\OrderOutput;
use Webmozart\Assert\Assert;

/**
 * This applicator will give a 10% discount if the customer has orders for more than € 1000
 */
class OrderDiscountApplicator extends AbstractDiscountApplicator
{
    private const DISCOUNT_VALUE = 0.1;

    public function __construct(
        private readonly CustomerRepository $customerRepository
    ) {
    }

    public function supports(OrderInput $order): bool
    {
        $customer = $this->customerRepository->find($order->getCustomerId());
        Assert::notNull($customer, 'The customer could not be found');

        return $customer->getTotalOrders() > 1000;
    }

    public function apply(OrderOutput $order): void
    {
        $discountValue = round($order->getTotal() * self::DISCOUNT_VALUE, 2);

        $this->applyOrderDiscount($order, $discountValue);
    }

    public function getType(): string
    {
        return self::TYPE_ORDER_DISCOUNT;
    }

    public static function getDefaultPriority(): int
    {
        return self::PRIORITY_ORDER_DISCOUNT;
    }
}
