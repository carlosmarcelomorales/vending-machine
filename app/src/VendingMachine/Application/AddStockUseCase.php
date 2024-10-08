<?php

namespace App\VendingMachine\Application;

use App\VendingMachine\Domain\Entity\Item;
use App\VendingMachine\Domain\Repository\VendingMachineRepositoryInterface;

class AddStockUseCase
{
    private VendingMachineRepositoryInterface $vendingMachineRepository;

    public function __construct(VendingMachineRepositoryInterface $vendingMachineRepository)
    {
        $this->vendingMachineRepository = $vendingMachineRepository;
    }

    public function __invoke(Item $item, int $amount): Item
    {

        $newItem = $item->addStock($amount);

        $this->vendingMachineRepository->update($newItem);

        return $newItem;
    }
}