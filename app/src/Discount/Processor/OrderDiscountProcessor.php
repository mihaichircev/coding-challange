<?php

namespace App\Discount\Processor;

use App\Discount\Dto\Input\OrderInput;
use App\Discount\Dto\Output\OrderOutput;
use App\Discount\Factory\OrderOutputFactory;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class OrderDiscountProcessor
{
    public function __construct(
        #[AutowireIterator('app.order.discount.applicator')] private readonly iterable $applicators,
        private readonly OrderOutputFactory $orderOutputFactory
    ) {}


    public function process(OrderInput $input): OrderOutput
    {
        $output = $this->orderOutputFactory->create($input);

        foreach ($this->applicators as $applicator) {
            if ($applicator->supports($input)) {
                $applicator->apply($input, $output);
            }
        }

        return $output;
    }
}
