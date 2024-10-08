<?php

namespace App\VendingMachine\Domain\Repository;

use App\VendingMachine\Domain\Entity\Item;
use App\VendingMachine\Domain\ValueObject\ItemName;

interface VendingMachineRepositoryInterface
{
    public function findItemByName(ItemName $itemName): Item;
    public function update(Item $item): void;
}