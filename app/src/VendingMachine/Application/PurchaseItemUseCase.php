<?php

namespace App\VendingMachine\Application;

use App\VendingMachine\Domain\Entity\Item;
use App\VendingMachine\Domain\Exception\InsufficientFundsException;
use App\VendingMachine\Domain\Exception\OutOfStockException;
use App\VendingMachine\Domain\Repository\VendingMachineRepositoryInterface;
use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Domain\Repository\WalletRepositoryInterface;

class PurchaseItemUseCase
{

    private WalletRepositoryInterface $walletRepository;
    private VendingMachineRepositoryInterface $vendingMachineRepository;

    public function __construct(
        WalletRepositoryInterface $walletRepository,
        VendingMachineRepositoryInterface $vendingMachineRepository
    ) {
        $this->walletRepository = $walletRepository;
        $this->vendingMachineRepository = $vendingMachineRepository;
    }

    /**
     * @throws InsufficientFundsException
     * @throws OutOfStockException
     */
    public function __invoke(Wallet $wallet, Item $item): Item
    {
        if ($wallet->totalAmount() < $item->price()) {
            throw new InsufficientFundsException();
        }

        $wallet = $wallet->subtract($item->price());
        $item = $item->reduceStock();

        $this->walletRepository->update($wallet);
        $this->vendingMachineRepository->update($item);

        return $item;
    }
}