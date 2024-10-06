<?php

namespace App\Wallet\Application;

use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Domain\Repository\WalletRepositoryInterface;
use App\Wallet\Domain\ValueObject\WalletId;

class FindWalletUseCase
{
    private WalletRepositoryInterface $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function __invoke(WalletId $walletId): ?Wallet
    {
        return $this->walletRepository->findById($walletId);
    }
}