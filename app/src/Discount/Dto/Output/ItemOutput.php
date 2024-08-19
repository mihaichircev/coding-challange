<?php

namespace App\Discount\Dto\Output;

use App\Discount\Dto\ItemInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;

class ItemOutput implements ItemInterface
{
    public function __construct(
        private readonly string $productId,
        private readonly int $quantity,
        private readonly float $unitPrice,
        private readonly float $total,
        private float $totalWithDiscount
    ) {}

    #[SerializedName("product-id")]
    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    #[SerializedName("unit-price")]
    public function getUnitPrice(): float
    {
        return (float) $this->unitPrice;
    }

    public function getTotal(): float
    {
        return (float) $this->total;
    }

    public function setTotalWithDiscount(float $totalWithDiscount): self
    {
        $this->totalWithDiscount = $totalWithDiscount;

        return $this;
    }

    public function getTotalWithDiscount(): float
    {
        return (float) $this->totalWithDiscount;
    }
}
