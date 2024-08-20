<?php

namespace App\Discount\DataProvider;

use App\Discount\Dto\Input\OrderInput;
use Symfony\Component\Serializer\SerializerInterface;

class OrderDataProvider
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function provide(string $data): OrderInput
    {
        return $this->serializer->deserialize($data, OrderInput::class, 'json');
    }
}
