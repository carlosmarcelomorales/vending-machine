<?php

namespace App\Wallet\Application;

use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Domain\Repository\WalletRepositoryInterface;
use App\Wallet\Domain\ValueObject\Money;

class AddMoneyUseCase
{
    private WalletRepositoryInterface $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function __invoke(Wallet $wallet, Money $money): void
    {
        $wallet->addMoney($money);
        $this->walletRepository->update($wallet);
    }
}