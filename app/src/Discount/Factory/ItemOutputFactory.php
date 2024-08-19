<?php

namespace App\Discount\Factory;

use App\Discount\Dto\Input\ItemInput;
use App\Discount\Dto\Output\ItemOutput;

class ItemOutputFactory
{

    public function create(ItemInput $input): ItemOutput
    {
        return new ItemOutput(
            $input->getProductId(),
            $input->getQuantity(),
            $input->getUnitPrice(),
            $input->getTotal(),
            $input->getTotal()
        );
    }
}
