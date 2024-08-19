<?php

namespace App\Discount\DataTransformer;

use App\Discount\Dto\Output\OrderOutput;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class OrderDataTransformer
{
    public function __construct(
        private readonly NormalizerInterface $normalizer,
    ) {}

    public function transform(OrderOutput $output): array
    {
        return $this->normalizer->normalize($output, 'json');
    }
}
