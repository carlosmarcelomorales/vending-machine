<?php

namespace App\VendingMachine\Domain\Entity;

use App\VendingMachine\Domain\Exception\OutOfStockException;
use App\VendingMachine\Domain\ValueObject\ItemId;
use App\VendingMachine\Domain\ValueObject\ItemName;
use App\VendingMachine\Domain\ValueObject\ItemPrice;
use App\VendingMachine\Domain\ValueObject\ItemStock;

class Item
{
    private ItemId $id;
    private ItemName $name;
    private ItemPrice $price;
    private ItemStock $stock;

    public function __construct(ItemId $id, ItemName $name, ItemPrice $price, ItemStock $stock)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function id(): ItemId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name->name();
    }

    public function price(): float
    {
        return $this->price->price();
    }

    public function itemStock(): ItemStock
    {
        return $this->stock;
    }

    public function totalStock(): int
    {
        return $this->stock->stock();
    }


    /**
     * @throws OutOfStockException
     */
    public function reduceStock(): Item
    {
        $newStock = $this->stock->reduce(1);
        return new self($this->id(), $this->name, $this->price, $newStock);

    }
}