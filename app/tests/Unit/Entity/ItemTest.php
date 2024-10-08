<?php

namespace Unit\Entity;

use App\VendingMachine\Domain\Entity\Item;
use App\VendingMachine\Domain\Exception\OutOfStockException;
use App\VendingMachine\Domain\ValueObject\ItemId;
use App\VendingMachine\Domain\ValueObject\ItemName;
use App\VendingMachine\Domain\ValueObject\ItemPrice;
use App\VendingMachine\Domain\ValueObject\ItemStock;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{

    public function testReduceStockSuccessfully()
    {
        $item = new Item(new ItemId(1), new ItemName('Water'), new ItemPrice(0.65), new ItemStock(10));

        $item = $item->reduceStock();

        $this->assertEquals(9, $item->totalStock());
    }

    public function testReduceStockThrowsOutOfStockException()
    {
        $item = new Item(new ItemId(1), new ItemName('Water'), new ItemPrice(0.65), new ItemStock(0));

        $this->expectException(OutOfStockException::class);
        $this->expectExceptionMessage('Item is out of stock.');

        $item->reduceStock();
    }
}