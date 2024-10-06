<?php

namespace App\Wallet\Domain\ValueObject;

use App\Wallet\Domain\Exception\InvalidMoneyAmountException;

class Money
{
    private float $amount;

    public function __construct(float $amount)
    {
        if ($amount < 0) {
            throw new InvalidMoneyAmountException('Amount cannot be negative.');
        }
        $this->amount = $amount;
    }

    public function amount(): float
    {
        return $this->amount;
    }

}