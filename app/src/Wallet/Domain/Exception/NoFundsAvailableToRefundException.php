<?php

namespace App\Wallet\Domain\Exception;

use Exception;

class NoFundsAvailableToRefundException extends Exception
{
    public function __construct()
    {
        parent::__construct("No funds available to refund");
    }
}