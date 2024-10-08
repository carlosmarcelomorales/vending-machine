<?php

namespace Unit\Entity;

use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Domain\Exception\InvalidMoneyAmountException;
use App\Wallet\Domain\Repository\WalletRepositoryInterface;
use App\Wallet\Domain\ValueObject\Balance;
use App\Wallet\Domain\ValueObject\Money;
use App\Wallet\Domain\ValueObject\WalletId;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{

    private const VALID_WALLET_ID = 'fb6b13fc-1831-434e-b493-969eda40c631';

    /**
     * @throws InvalidMoneyAmountException
     * @throws Exception
     */
    public function testAddInvalidMoneyAmount()
    {
        $wallet = $this->createMock(Wallet::class);
        $wallet->expects($this->never())->method('addMoney');

        $walletRepository = $this->createMock(WalletRepositoryInterface::class);

        $walletRepository->expects($this->never())->method('update');

        $this->expectException(InvalidMoneyAmountException::class);

        $money = new Money(-0.50);

    }

    public function testSubtractSuccessfully()
    {
        $wallet = new Wallet(new WalletId(self::VALID_WALLET_ID), new Balance(10.00));

        $updatedWallet = $wallet->subtract(5.00);

        $this->assertEquals(5.00, $updatedWallet->totalAmount());
    }
}
