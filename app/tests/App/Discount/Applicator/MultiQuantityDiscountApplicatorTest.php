<?php

namespace App\Tests\Discount\Applicator;

use App\Discount\Applicator\MultiQuantityDiscountApplicator;
use App\Discount\Dto\Input\OrderInput;
use App\Discount\Dto\Output\ItemOutput;
use App\Discount\Dto\Output\OrderOutput;
use PHPUnit\Framework\TestCase;

class MultiQuantityDiscountApplicatorTest extends TestCase
{
    /**
     * @dataProvider supportsDataProvider
     * @param mixed[] $items
     */
    public function testSupports(array $items, bool $expectedSupports): void
    {
        $itemMocks = [];
        foreach ($items as $item) {
            $itemMocks[] = $this->createConfiguredMock(
                ItemOutput::class,
                ['hasCategory' => $item['hasCategory']]
            );
        }

        $orderInputMock = $this->createConfiguredMock(
            OrderInput::class,
            ['getItems' => $itemMocks]
        );

        $applicator = new MultiQuantityDiscountApplicator();
        $supports = $applicator->supports($orderInputMock);

        self::assertEquals($expectedSupports, $supports);
    }

    public function supportsDataProvider(): \Generator
    {
        yield 'Case 1: Order has 2 items of the same category' => [
            'items' => [
                ['hasCategory' => true],
                ['hasCategory' => true],
            ],
            'expectedSupports' => true
        ];

        yield 'Case 2: Client has 2 items of different category' => [
            'items' => [
                ['hasCategory' => true],
                ['hasCategory' => false],
            ],
            'expectedSupports' => false
        ];
    }


    /**
     * @dataProvider applyDataProvider
     * @param mixed[] $itemConfigs
     */
    public function testApply(
        array $itemConfigs,
        float $total,
        int $discountItemIndex,
        float $expectedOrderTotalWithDiscount,
        float $expectedItemDiscount,
        float $expectedItemTotalWithDiscount
    ): void {
        $items = [];
        foreach ($itemConfigs as $item) {
            $items[] = new ItemOutput(
                $item['productId'],
                $item['quantity'],
                $item['unitPrice'],
                $item['total'],
                $item['total']
            );
        }

        $orderOutput = new OrderOutput(1, 1, $items, $total, $total, []);

        $applicator = new MultiQuantityDiscountApplicator();
        $applicator->apply($orderOutput);

        self::assertEquals($expectedOrderTotalWithDiscount, $orderOutput->getTotalWithDiscount());
        self::assertCount(1, $orderOutput->getDiscounts());
        $discounts = $orderOutput->getDiscounts();
        self::assertEquals('multi_discount', $discounts[0]->getType());
        self::assertEquals($expectedItemDiscount, $discounts[0]->getValue());
        $items = $orderOutput->getItems();
        self::assertEquals($expectedItemTotalWithDiscount, $items[$discountItemIndex]->getTotalWithDiscount());
    }

    public function applyDataProvider(): \Generator
    {
        yield 'Case 1: Order has 2 items of the same category with different prices' => [
            'items' => [
                [
                    'productId' => 'B101',
                    'quantity' => 2,
                    'unitPrice' => 10.45,
                    'total' => 20.90,
                ],
                [
                    'productId' => 'B102',
                    'quantity' => 1,
                    'unitPrice' => 2.5,
                    'total' => 2.5,
                ],
            ],
            'total' => 23.40,
            'discountItemIndex' => 1,
            'expectedOrderTotalWithDiscount' => 22.90,
            'expectedItemDiscount' => 0.5,
            'expectedItemTotalWithDiscount' => 2.0
        ];
    }
}
