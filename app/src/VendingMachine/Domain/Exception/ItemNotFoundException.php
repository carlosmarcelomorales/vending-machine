<?php

namespace App\VendingMachine\Domain\Exception;

use Exception;

class ItemNotFoundException extends Exception
{

    public function __construct(string $item)
    {
        $message = "Item not found: '{$item}'";
        parent::__construct($message);
    }
}