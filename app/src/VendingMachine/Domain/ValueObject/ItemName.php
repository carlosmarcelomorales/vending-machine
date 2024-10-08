<?php

namespace App\VendingMachine\Domain\ValueObject;

use App\VendingMachine\Domain\Exception\InvalidItemNameException;

class ItemName
{
    private const VALID_NAMES = [
        'Water',
        'Juice',
        'Soda',
    ];

    private string $name;

    /**
     * @throws InvalidItemNameException
     */
    public function __construct(string $name)
    {
        if (!in_array($name, self::VALID_NAMES)) {
            throw new InvalidItemNameException("Invalid item name: $name");
        }

        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}