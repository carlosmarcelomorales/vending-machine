<?php

namespace App\Wallet\Domain\Exception;

use Exception;

class WalletNotFoundException extends Exception
{
    public function __construct($walletId)
    {
        $message = "Wallet with ID {$walletId} not found.";
        parent::__construct($message);
    }
}