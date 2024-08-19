<?php

namespace App\Discount\Applicator;

use App\Customer\Repository\CustomerRepository;
use App\Discount\Dto\Input\OrderInput;
use App\Discount\Dto\Output\DiscountOutput;
use App\Discount\Dto\Output\OrderOutput;
use Webmozart\Assert\Assert;

/**
 * This applicator will give a 10% discount if the customer has orders for more than € 1000
 */
class OrderDiscountApplicator implements DiscountApplicatorInterface
{
    public function __construct(
        private readonly CustomerRepository $customerRepository
    ) {}

    public function supports(OrderInput $orderInput): bool
    {
        $customer = $this->customerRepository->find($orderInput->getCustomerId());
        Assert::notNull($customer, 'The customer could not be found');

        return $customer->getTotalOrders() > 1000;
    }

    public function apply(OrderOutput $orderOutput): void
    {
        $discountValue = round($orderOutput->getTotal() * 0.1, 2);
        $orderOutput->setTotalWithDiscount($orderOutput->getTotalWithDiscount() - $discountValue);

        $discount = new DiscountOutput($this->getType(), $discountValue);
        $orderOutput->addDiscount($discount);
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
