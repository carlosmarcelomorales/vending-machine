<?php

namespace App\Wallet\Domain\Exception;

use Exception;

class InvalidMoneyAmountException extends Exception
{
    public function __construct(string $message = 'Invalid money amount.')
    {
        parent::__construct($message);
    }
}