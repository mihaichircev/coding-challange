<?php

namespace App\Discount\Dto\Input;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class OrderInput
{
    #[Assert\NotBlank]
    private ?int $id;
    #[Assert\NotBlank]
    private ?int $customerId;
    #[Assert\NotBlank]
    /**
     * @var ItemInput[] $items
     */
    private array $items;
    #[Assert\NotBlank]
    private ?float $total;

    /**
     * @param ItemInput[] $items
     */
    public function __construct(
        ?int $id,
        ?int $customerId,
        array $items,
        ?float $total
    ) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->items = $items;
        $this->total = $total;
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
     * @return ItemInput[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): float
    {
        return $this->total;
    }
}
