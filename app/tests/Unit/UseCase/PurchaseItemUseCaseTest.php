<?php

namespace Unit\UseCase;

use App\VendingMachine\Application\PurchaseItemUseCase;
use App\VendingMachine\Domain\Entity\Item;
use App\VendingMachine\Domain\Exception\InsufficientFundsException;
use App\VendingMachine\Domain\Exception\OutOfStockException;
use App\VendingMachine\Domain\Repository\VendingMachineRepositoryInterface;
use App\VendingMachine\Domain\ValueObject\ItemId;
use App\VendingMachine\Domain\ValueObject\ItemName;
use App\VendingMachine\Domain\ValueObject\ItemPrice;
use App\VendingMachine\Domain\ValueObject\ItemStock;
use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Domain\Repository\WalletRepositoryInterface;
use PHPUnit\Framework\TestCase;

class PurchaseItemUseCaseTest extends TestCase
{
    public function testPurchaseItemSuccessfully()
    {

        $wallet = $this->createMock(Wallet::class);
        $wallet->method('totalAmount')->willReturn(10.00);
        $wallet->method('subtract')->willReturnSelf();


        $item = $this->getMockBuilder(Item::class)
            ->setConstructorArgs(
                [
                    new ItemId(1),
                    new ItemName('Water'),
                    new ItemPrice(0.65),
                    new ItemStock(10)
                ]
            )
            ->onlyMethods(['reduceStock'])
            ->getMock();


        $item->expects($this->once())
            ->method('reduceStock')
            ->willReturn(
                new Item(
                    new ItemId(1),
                    new ItemName('Water'),
                    new ItemPrice(0.65),
                    new ItemStock(9)
                )
            );

        $walletRepository = $this->createMock(WalletRepositoryInterface::class);
        $vendingMachineRepository = $this->createMock(VendingMachineRepositoryInterface::class);

        $purchaseItemUseCase = new PurchaseItemUseCase($walletRepository, $vendingMachineRepository);

        $purchasedItem = $purchaseItemUseCase($wallet, $item);

        $this->assertEquals(9, $purchasedItem->totalStock());
    }

    public function testPurchaseItemWithInsufficientFundsShouldThrowException()
    {

        $wallet = $this->createMock(Wallet::class);
        $wallet->method('totalAmount')->willReturn(0.50);

        $item = $this->createMock(Item::class);
        $item->method('price')->willReturn(0.65);

        $walletRepository = $this->createMock(WalletRepositoryInterface::class);
        $vendingMachineRepository = $this->createMock(VendingMachineRepositoryInterface::class);

        $purchaseItemUseCase = new PurchaseItemUseCase($walletRepository, $vendingMachineRepository);

        $this->expectException(InsufficientFundsException::class);

        $purchaseItemUseCase($wallet, $item);
    }


    public function testPurchaseItemWithOutOfStockShouldThrowsException()
    {
        $wallet = $this->createMock(Wallet::class);
        $wallet->method('totalAmount')->willReturn(10.00);

        $itemStock = $this->createMock(ItemStock::class);
        $itemStock->method('reduce')->willThrowException(new OutOfStockException());

        $item = new Item(
            new ItemId(1),
            new ItemName('Water'),
            new ItemPrice(0.65),
            $itemStock
        );

        $walletRepository = $this->createMock(WalletRepositoryInterface::class);
        $vendingMachineRepository = $this->createMock(VendingMachineRepositoryInterface::class);

        $purchaseItemUseCase = new PurchaseItemUseCase($walletRepository, $vendingMachineRepository);

        $this->expectException(OutOfStockException::class);

        $purchaseItemUseCase($wallet, $item);
    }




}