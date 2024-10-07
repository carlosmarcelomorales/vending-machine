<?php

namespace Unit;

use App\Wallet\Domain\Exception\InvalidMoneyAmountException;
use App\Wallet\Domain\Repository\WalletRepositoryInterface;
use App\Wallet\Domain\ValueObject\Money;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use App\Wallet\Domain\Entity\Wallet;

class WalletTest extends TestCase
{

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
}
