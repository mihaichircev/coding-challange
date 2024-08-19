<?php

namespace App\Discount\Factory;

use App\Discount\Dto\Input\ItemInput;
use App\Discount\Dto\Input\OrderInput;
use App\Discount\Dto\Output\ItemOutput;
use App\Discount\Dto\Output\OrderOutput;

class OrderOutputFactory
{

    public function __construct(
        private readonly ItemOutputFactory $itemOutputFactory
    ) {}

    public function create(OrderInput $input): OrderOutput
    {
        return new OrderOutput(
            $input->getId(),
            $input->getCustomerId(),
            $input->getItems(),
            $input->getTotal(),
            $input->getTotal()
        );
    }

    /**
     * @param ItemInput[] $items
     * @return ItemOutput[]
     */
    protected function buildItems(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            $result[] = $this->itemOutputFactory->create($item);
        }

        return $result;
    }
}
