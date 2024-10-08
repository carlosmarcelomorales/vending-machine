<?php

namespace App\VendingMachine\Domain\Exception;

use Exception;

class InvalidItemPriceException extends Exception
{
    public function __construct(float $price)
    {
        $message = "No price found for item: '{$price}'";
        parent::__construct($message);
    }
}