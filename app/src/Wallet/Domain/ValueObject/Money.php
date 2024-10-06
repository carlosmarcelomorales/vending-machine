<?php

namespace App\Wallet\Domain\ValueObject;

use InvalidArgumentException;

class Money
{
    private float $amount;

    public function __construct(float $amount)
    {
        if ($amount < 0) {
            throw new InvalidArgumentException('Amount cannot be negative.');
        }
        $this->amount = $amount;
    }

    public function amount(): float
    {
        return $this->amount;
    }

}