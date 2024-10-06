<?php

namespace App\Wallet\Domain\Entity;

use App\Wallet\Domain\ValueObject\Balance;
use App\Wallet\Domain\ValueObject\Money;
use App\Wallet\Domain\ValueObject\WalletId;

class Wallet
{
    private WalletId $walletId;
    private Balance $balance;

    private function __construct(WalletId $walletId, Balance $balance) {
        $this->walletId = $walletId;
        $this->balance = $balance;
    }

    public function addMoney(Money $money): void {
        $this->balance = $this->balance->add($money);
    }

    public function balance(): Balance {
        return $this->balance;
    }

    public function walletId(): WalletId {
        return $this->walletId;
    }

}