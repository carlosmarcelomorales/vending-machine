<?php

namespace App\Wallet\Application;

use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Domain\Exception\NoFundsAvailableToRefundException;
use App\Wallet\Domain\Repository\WalletRepositoryInterface;
use App\Wallet\Domain\Service\ChangeCalculator;

class RefundMoneyUseCase
{

    private ChangeCalculator $changeCalculator;
    private WalletRepositoryInterface $walletRepository;


    public function __construct(
        ChangeCalculator $changeCalculator,
        WalletRepositoryInterface $walletRepository
    )
    {
        $this->changeCalculator = $changeCalculator;
        $this->walletRepository = $walletRepository;
    }

    /**
     * @throws NoFundsAvailableToRefundException
     */
    public function __invoke(Wallet $wallet)
    {
        if ($wallet->totalAmount() <= 0 ) {
            throw new NoFundsAvailableToRefundException();
        }

        $change = $this->changeCalculator->calculateChange($wallet->totalAmount());

        $wallet = $wallet->withdraw();
        $this->walletRepository->update($wallet);

        return $change;
    }
}