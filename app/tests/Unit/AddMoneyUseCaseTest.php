<?php

namespace Unit;

use App\Wallet\Application\AddMoneyUseCase;
use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Domain\Exception\InvalidMoneyAmountException;
use App\Wallet\Domain\Repository\WalletRepositoryInterface;
use App\Wallet\Domain\ValueObject\Money;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class AddMoneyUseCaseTest extends TestCase
{
    /**
     * @throws InvalidMoneyAmountException
     * @throws Exception
     */
    public function testAddMoneySuccessfully()
    {
        $wallet = $this->createMock(Wallet::class);
        $wallet->expects($this->once())->method('addMoney')->with($this->isInstanceOf(Money::class));

        $walletRepository = $this->createMock(WalletRepositoryInterface::class);
        $walletRepository->expects($this->once())->method('update')->with($wallet);

        $addMoneyUseCase = new AddMoneyUseCase($walletRepository);
        $money = new Money(0.25);
        $addMoneyUseCase($wallet, $money);
    }

    /**
     * @throws InvalidMoneyAmountException
     * @throws Exception
     */
    public function testUpdateNotCalledWhenFails()
    {
        $wallet = $this->createMock(Wallet::class);

        $wallet->expects($this->once())
            ->method('addMoney')
            ->with($this->isInstanceOf(Money::class))
            ->willThrowException(new InvalidMoneyAmountException('Invalid money amount'));

        $walletRepository = $this->createMock(WalletRepositoryInterface::class);

        $walletRepository->expects($this->never())->method('update');

        $addMoneyUseCase = new AddMoneyUseCase($walletRepository);
        $money = new Money(0.25);

        $this->expectException(InvalidMoneyAmountException::class);
        $addMoneyUseCase($wallet, $money);
    }
}