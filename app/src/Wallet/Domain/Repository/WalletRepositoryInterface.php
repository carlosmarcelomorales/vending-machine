<?php

namespace App\Wallet\Domain\Repository;

use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Domain\ValueObject\WalletId;

interface WalletRepositoryInterface
{
    public function findById(WalletId $walletId): ?Wallet;
}