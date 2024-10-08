<?php

namespace App\VendingMachine\Domain\ValueObject;

class ItemPrice
{

    private float $price;

    public function __construct(float $price)
    {
        $this->price = $price;
    }

    public function price(): float
    {
        return $this->price;
    }
}