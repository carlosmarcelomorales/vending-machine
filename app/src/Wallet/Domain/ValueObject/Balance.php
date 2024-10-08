<?php

namespace App\Wallet\Domain\ValueObject;

use InvalidArgumentException;

class Balance
{
    private float $amount;

    public function __construct(float $amount)
    {
        if ($amount < 0) {
            throw new InvalidArgumentException('Balance cannot be negative.');
        }

        $this->amount = $amount;
    }

    public function add(Money $money): Balance
    {
        return new self($this->amount + $money->amount());
    }

    public function subtract(float $amount): Balance
    {
        $newAmount = $this->amount - $amount;

        if ($newAmount < 0) {
            throw new InvalidArgumentException('Insufficient balance.');
        }

        return new self($newAmount);
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function __toString(): string
    {
        return (string)$this->amount;
    }
}