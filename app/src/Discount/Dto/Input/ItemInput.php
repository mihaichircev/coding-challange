<?php

namespace App\Discount\Dto\Input;

use App\Discount\Dto\ItemInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class ItemInput implements ItemInterface
{
    #[Assert\NotBlank]
    private string $productId;
    #[Assert\NotBlank]
    private int $quantity;
    #[Assert\NotBlank]
    private float $unitPrice;
    #[Assert\NotBlank]
    private float $total;

    public function __construct(
        string $productId,
        int $quantity,
        float $unitPrice,
        float $total
    ) {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->total = $total;
    }

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
}
