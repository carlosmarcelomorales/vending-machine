<?php

namespace App\VendingMachine\Domain\Exception;

use Exception;

class InvalidItemNameException extends Exception
{
    public function __construct($name)
    {
        $message = "Invalid item name '{$name}'";
        parent::__construct($message);
    }
}