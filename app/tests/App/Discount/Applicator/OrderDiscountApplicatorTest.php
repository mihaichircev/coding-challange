<?php

namespace App\Tests\Discount\Applicator;

use App\Customer\Model\Customer;
use App\Customer\Repository\CustomerRepository;
use App\Discount\Applicator\OrderDiscountApplicator;
use App\Discount\Dto\Input\OrderInput;
use App\Discount\Dto\Output\OrderOutput;
use PHPUnit\Framework\TestCase;

class OrderDiscountApplicatorTest extends TestCase
{

    /**
     * @dataProvider supportsDataProvider
     */
    public function testSupports(float $totalOrders, bool $expectedSupports): void
    {
        $customerMock = $this->createConfiguredMock(
            Customer::class,
            ['getTotalOrders' => $totalOrders]
        );
        $customerRepsitoryMock = $this->createConfiguredMock(
            CustomerRepository::class,
            ['find' => $customerMock]
        );

        $applicator = new OrderDiscountApplicator($customerRepsitoryMock);
        $orderInputMock = $this->createConfiguredMock(
            OrderInput::class,
            ['getCustomerId' => 1]
        );

        $supports = $applicator->supports($orderInputMock);

        self::assertEquals($expectedSupports, $supports);
    }

    public function supportsDataProvider(): \Generator
    {
        yield 'Case 1: Client has orders for more than 1000' => [
            'totalOrders' => 2000.0,
            'expectedSupports' => true
        ];

        yield 'Case 2: Client has orders for les than 1000' => [
            'totalOrders' => 200.0,
            'expectedSupports' => false
        ];
    }

    public function testApply(): void
    {
        $customerRepsitoryMock = $this->createMock(CustomerRepository::class);
        $orderOutput = new OrderOutput(1, 1, [], 55.0, 55.0, []);

        $applicator = new OrderDiscountApplicator($customerRepsitoryMock);
        $applicator->apply($orderOutput);

        self::assertEquals(49.5, $orderOutput->getTotalWithDiscount());
        self::assertCount(1, $orderOutput->getDiscounts());
        $discounts = $orderOutput->getDiscounts();
        self::assertEquals('order_discount', $discounts[0]->getType());
        self::assertEquals(5.5, $discounts[0]->getValue());
    }
}
