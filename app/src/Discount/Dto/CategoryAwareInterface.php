<?php

namespace App\Discount\Dto;

interface CategoryAwareInterface
{
    public function getCategory(): string;

    public function hasCategory(string $category): bool;
}
