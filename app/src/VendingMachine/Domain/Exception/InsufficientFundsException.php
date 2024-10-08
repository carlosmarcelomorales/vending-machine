<?php

namespace App\VendingMachine\Domain\Exception;

use Exception;

class InsufficientFundsException extends Exception
{

    public function __construct()
    {
        $message = "Insufficient funds to purchase the item.";
        parent::__construct($message);
    }
}