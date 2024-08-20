<?php

namespace App\Tests\Discount\Applicator;

use App\Discount\Applicator\CategoryDiscountApplicator;
use App\Discount\Dto\Input\ItemInput;
use App\Discount\Dto\Input\OrderInput;
use App\Discount\Dto\Output\ItemOutput;
use App\Discount\Dto\Output\OrderOutput;
use PHPUnit\Framework\TestCase;

class CategoryDiscountApplicatorTest extends TestCase
{

    /**
     * @dataProvider supportsDataProvider
     */
    public function testSupports(string $productId, int $quantity, bool $expectedSupports): void
    {
        $itemMock = $this->createConfiguredMock(
            ItemInput::class,
            [
                'getProductId' => $productId,
                'getQuantity' => $quantity
            ]
        );

        $applicator = new CategoryDiscountApplicator();
        $orderInputMock = $this->createConfiguredMock(
            OrderInput::class,
            ['getItems' => [$itemMock]]
        );

        $supports = $applicator->supports($orderInputMock);

        self::assertEquals($expectedSupports, $supports);
    }

    public function supportsDataProvider(): \Generator
    {
        yield 'Case 1: Client has more than 5 units and B1 category' => [
            'productId' => 'B101',
            'quantity' => 6,
            'expectedSupports' => true
        ];

        yield 'Case 2: Client has less than 6 units and B1 category' => [
            'productId' => 'B101',
            'quantity' => 5,
            'expectedSupports' => false
        ];

        yield 'Case 3: Client has more than 5 units and B2 category' => [
            'productId' => 'B201',
            'quantity' => 5,
            'expectedSupports' => false
        ];

        yield 'Case 3: Client has less than 6 units and B2 category' => [
            'productId' => 'B201',
            'quantity' => 5,
            'expectedSupports' => false
        ];
    }

    /**
     * @dataProvider applyDataProvider
     */
    public function testApply(
        string $productId,
        int $quantity,
        float $unitPrice,
        float $total,
        float $expectedOrderTotalWithDiscount,
        float $expectedItemDiscount,
        float $expectedItemTotalWithDiscount
    ): void {
        $items = [new ItemOutput($productId, $quantity, $unitPrice, $total, $total)];
        $orderOutput = new OrderOutput(1, 1, $items, $total, $total, []);

        $applicator = new CategoryDiscountApplicator();
        $applicator->apply($orderOutput);

        self::assertEquals($expectedOrderTotalWithDiscount, $orderOutput->getTotalWithDiscount());
        self::assertCount(1, $orderOutput->getDiscounts());
        $discounts = $orderOutput->getDiscounts();
        self::assertEquals('category_discount', $discounts[0]->getType());
        self::assertEquals($expectedItemDiscount, $discounts[0]->getValue());
        $items = $orderOutput->getItems();
        self::assertEquals($expectedItemTotalWithDiscount, $items[0]->getTotalWithDiscount());
    }

    public function applyDataProvider(): \Generator
    {
        yield 'Case 1: Client has 6 units, each 2.99' => [
            'productId' => 'B101',
            'quantity' => 6,
            'unitPrice' => 2.99,
            'total' => 17.94,
            'expectedOrderTotalWithDiscount' => 14.95,
            'expectedItemDiscount' => 2.99,
            'expectedItemTotalWithDiscount' => 14.95
        ];

        yield 'Case 2: Client has 12 units, each 2.99' => [
            'productId' => 'B101',
            'quantity' => 12,
            'unitPrice' => 2.99,
            'total' => 35.88,
            'expectedOrderTotalWithDiscount' => 32.89,
            'expectedItemDiscount' => 2.99,
            'expectedItemTotalWithDiscount' => 32.89
        ];
    }
}
