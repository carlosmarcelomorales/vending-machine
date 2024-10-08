<?php

namespace App\VendingMachine\Domain\ValueObject;

use App\VendingMachine\Domain\Exception\OutOfStockException;

class ItemStock
{
    private int $stock;

    public function __construct(int $stock)
    {
        $this->stock = $stock;
    }

    public function stock(): int
    {
        return $this->stock;
    }

    /**
     * @throws OutOfStockException
     */
    public function reduce(int $amount): ItemStock
    {
        $newStock = $this->stock - $amount;

        if ($newStock < 0) {
            throw new OutOfStockException();
        }

        return new self($newStock);
    }
}