<?php

namespace App\Wallet\Domain\ValueObject;

use App\Wallet\Domain\Exception\InvalidMoneyAmountException;

class Money
{
    private const ACCEPTED_VALUES = [0.05, 0.10, 0.25, 1.00];

    private float $amount;

    public function __construct(float $amount)
    {
        if (!in_array($amount, self::ACCEPTED_VALUES, true)) {
            throw new InvalidMoneyAmountException('Invalid money amount. Accepted values are 0.05, 0.10, 0.25, and 1.');
        }

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