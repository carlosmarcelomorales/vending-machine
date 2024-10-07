<?php

namespace Unit;

use App\Wallet\Application\RefundMoneyUseCase;
use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Domain\Exception\NoFundsAvailableToRefundException;
use App\Wallet\Domain\Repository\WalletRepositoryInterface;
use App\Wallet\Domain\Service\ChangeCalculator;
use PHPUnit\Framework\TestCase;

class RefundMoneyUseCaseTest extends TestCase
{

    private ChangeCalculator $changeCalculator;
    private WalletRepositoryInterface $walletRepository;
    private RefundMoneyUseCase $refundMoneyUseCase;

    protected function setUp(): void
    {
        $this->changeCalculator = $this->createMock(ChangeCalculator::class);

        $this->walletRepository = $this->createMock(WalletRepositoryInterface::class);

        $this->refundMoneyUseCase = new RefundMoneyUseCase(
            $this->changeCalculator,
            $this->walletRepository
        );
    }

    public function testRefundMoneySuccess(): void
    {

        $wallet = $this->createMock(Wallet::class);
        $wallet->method('totalAmount')->willReturn(11.70);

        $this->changeCalculator->method('calculateChange')
            ->with(11.70)
            ->willReturn([
                "1" => 11,
                "0.25" => 2,
                "0.10" => 2
            ]);


        $wallet->expects($this->once())->method('withdraw')->willReturn($wallet);

        $this->walletRepository->expects($this->once())->method('update')->with($wallet);

        $change = $this->refundMoneyUseCase->__invoke($wallet);

        $expectedChange = [
            "1" => 11,
            "0.25" => 2,
            "0.10" => 2
        ];
        $this->assertEquals($expectedChange, $change);
    }

    public function testRefundMoneyNoFundsException(): void
    {
        $wallet = $this->createMock(Wallet::class);
        $wallet->method('totalAmount')->willReturn(0.00);

        $this->expectException(NoFundsAvailableToRefundException::class);

        $this->refundMoneyUseCase->__invoke($wallet);
    }
}