<?php

namespace App\Discount\Dto;

trait CategoryAwareTrait
{
    public function getCategory(): string {
        return substr($this->productId, 0, 2);
    }

    public function hasCategory(string $category): bool {
        return $category === $this->getCategory();
    }

}
