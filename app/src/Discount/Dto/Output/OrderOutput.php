<?php

namespace App\Discount\Dto\Output;

use Symfony\Component\Serializer\Annotation\SerializedName;

class OrderOutput
{
    /**
     * @param ItemOutput[] $items
     * @param DiscountOutput[] $discounts
     */
    public function __construct(
        private readonly int $id,
        private readonly int $customerId,
        private readonly array $items,
        private readonly float $total,
        private float $totalWithDiscount,
        private array $discounts = []
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    #[SerializedName("customer-id")]
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @return ItemOutput[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotalWithDiscount(float $totalWithDiscount): self
    {
        $this->totalWithDiscount = $totalWithDiscount;

        return $this;
    }

    public function getTotalWithDiscount(): float
    {
        return $this->totalWithDiscount;
    }

    public function addDiscount(DiscountOutput $discount): self
    {
        $this->discounts[] = $discount;

        return $this;
    }

    /**
     * @return DiscountOutput[]
     */
    public function getDiscounts(): array
    {
        return $this->discounts;
    }
}
