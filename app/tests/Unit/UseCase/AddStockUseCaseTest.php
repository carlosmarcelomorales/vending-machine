<?php

namespace Unit\UseCase;

use App\VendingMachine\Application\AddStockUseCase;
use App\VendingMachine\Domain\Entity\Item;
use App\VendingMachine\Domain\Repository\VendingMachineRepositoryInterface;
use PHPUnit\Framework\TestCase;

class AddStockUseCaseTest extends TestCase
{
    public function testAddItemStockSuccessfully()
    {
        $item = $this->createMock(Item::class);
        $item->method('addStock')->with(5)->willReturnSelf();

        $vendingMachineRepository = $this->createMock(VendingMachineRepositoryInterface::class);
        $vendingMachineRepository->expects($this->once())
            ->method('update')
            ->with($item);

        $addStockUseCase = new AddStockUseCase($vendingMachineRepository);

        $addStockUseCase($item, 5);

        $this->assertTrue(true);
    }
}