<?php

namespace App\Wallet\Application;

use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Domain\Repository\WalletRepositoryInterface;
use App\Wallet\Domain\ValueObject\Balance;
use App\Wallet\Domain\ValueObject\Money;
use App\Wallet\Domain\ValueObject\WalletId;

class CreateNewWalletUseCase
{
    private WalletRepositoryInterface $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function __invoke(Money $money): Wallet
    {
        $walletId = WalletId::generate();
        $balance = new Balance($money->amount());
        $wallet = new Wallet($walletId, $balance);

        return $this->walletRepository->create($wallet);
    }
}