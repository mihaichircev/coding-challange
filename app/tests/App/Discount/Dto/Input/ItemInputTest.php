<?php

namespace App\Tests\Discount\Dto\Input;

use App\Discount\Dto\Input\ItemInput;
use PHPUnit\Framework\TestCase;

class ItemInputTest extends TestCase
{
    /**
     * @dataProvider getCategoryDataProvider
     */
    public function testGetCategory(string $productId, string $expectedCategory): void
    {
        $input = new ItemInput($productId, 1, 2.25, 2.25);

        self::assertEquals($expectedCategory, $input->getCategory());
    }

    public function getCategoryDataProvider(): \Generator
    {
        yield 'Case 1: Product of category B1' => [
            'productId' => 'B101',
            'expectedCategory' => 'B1'
        ];

        yield 'Case 2: Product of category A1' => [
            'productId' => 'A102',
            'expectedCategory' => 'A1'
        ];
    }

    /**
     * @dataProvider hasCategoryDataProvider
     */
    public function testHasCategory(string $productId, bool $expectedResult): void
    {
        $input = new ItemInput($productId, 1, 2.25, 2.25);

        self::assertEquals($expectedResult, $input->hasCategory('B1'));
    }

    public function hasCategoryDataProvider(): \Generator
    {
        yield 'Case 1: Product of category B1' => [
            'productId' => 'B101',
            'expectedResult' => true
        ];

        yield 'Case 2: Product of category A1' => [
            'productId' => 'A102',
            'expectedCategory' => false
        ];
    }
}
