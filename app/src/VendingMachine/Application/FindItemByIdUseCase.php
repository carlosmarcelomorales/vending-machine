<?php

namespace App\VendingMachine\Application;

use App\VendingMachine\Domain\Entity\Item;
use App\VendingMachine\Domain\Repository\VendingMachineRepositoryInterface;
use App\VendingMachine\Domain\ValueObject\ItemId;

class FindItemByIdUseCase
{
    private VendingMachineRepositoryInterface $vendingMachineRepository;

    public function __construct(VendingMachineRepositoryInterface $vendingMachineRepository)
    {
        $this->vendingMachineRepository = $vendingMachineRepository;
    }

    public function __invoke(ItemId $itemId): Item
    {
        return $this->vendingMachineRepository->findItemById($itemId);
    }
}