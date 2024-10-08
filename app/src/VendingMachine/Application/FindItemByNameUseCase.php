<?php

namespace App\VendingMachine\Application;

use App\VendingMachine\Domain\Entity\Item;
use App\VendingMachine\Domain\Repository\VendingMachineRepositoryInterface;
use App\VendingMachine\Domain\ValueObject\ItemName;

class FindItemByNameUseCase
{
    private VendingMachineRepositoryInterface $vendingMachineRepository;

    public function __construct(VendingMachineRepositoryInterface $vendingMachineRepository)
    {
        $this->vendingMachineRepository = $vendingMachineRepository;
    }

    public function __invoke(ItemName $itemName): Item
    {
        return $this->vendingMachineRepository->findItemByName($itemName);
    }
}