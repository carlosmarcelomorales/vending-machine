<?php

namespace App\Wallet\Application;

use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Domain\ValueObject\Money;
use App\Wallet\Infrastructure\Repository\WalletRepository;

class AddMoneyUseCase
{
    private WalletRepository $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function __invoke(Wallet $wallet, Money $money): void
    {
        $wallet->addMoney($money);
        $this->walletRepository->update($wallet);
    }
}