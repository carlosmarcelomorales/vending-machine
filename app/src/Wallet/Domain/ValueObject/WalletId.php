<?php

namespace App\Wallet\Domain\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class WalletId
{
    private string $id;

    public function __construct(string $id)
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidArgumentException('Invalid WalletId format.');
        }
        $this->id = $id;
    }

    public static function generate(): WalletId
    {
        return new self(self::generateUUID());
    }

    public function __toString(): string
    {
        return $this->id;
    }

    private static function generateUUID(): string
    {
        return Uuid::uuid4()->toString();
    }
}