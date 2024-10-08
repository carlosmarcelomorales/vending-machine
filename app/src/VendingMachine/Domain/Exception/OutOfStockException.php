<?php

namespace App\VendingMachine\Domain\Exception;

use Exception;

class OutOfStockException extends Exception
{

    public function __construct()
    {
        parent::__construct("Item is out of stock.");
    }
}