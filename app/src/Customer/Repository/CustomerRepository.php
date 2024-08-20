<?php

namespace App\Customer\Repository;

use App\Customer\Model\Customer;

/**
 * This class is only for testing purposes,
 */
class CustomerRepository
{
    private const CUSTOMERS = [
        1 => ['totalOrders' => 2000.0],
        2 => ['totalOrders' => 1000.0],
        3 => ['totalOrders' => 1000.0],
    ];

    public function find(int $id): ?Customer
    {
        if (false === isset(self::CUSTOMERS[$id])) {
            return null;
        }

        return new Customer($id, self::CUSTOMERS[$id]['totalOrders']);
    }
}
