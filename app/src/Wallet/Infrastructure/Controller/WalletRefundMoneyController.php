<?php

namespace App\Wallet\Infrastructure\Controller;

use App\Wallet\Application\FindWalletUseCase;
use App\Wallet\Application\RefundMoneyUseCase;
use App\Wallet\Domain\Exception\NoFundsAvailableToRefundException;
use App\Wallet\Domain\Exception\WalletNotFoundException;
use App\Wallet\Domain\ValueObject\WalletId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WalletRefundMoneyController extends AbstractController
{

    private FindWalletUseCase $findWalletUseCase;
    private RefundMoneyUseCase $refundMoneyUseCase;

    public function __construct(
        FindWalletUseCase $findWalletUseCase,
        RefundMoneyUseCase $refundMoneyUseCase
    ) {
        $this->findWalletUseCase = $findWalletUseCase;
        $this->refundMoneyUseCase = $refundMoneyUseCase;
    }

    public function refundMoney(Request $request): Response
    {
        $walletId = $request->request->get('walletId');
        try {
            $wallet = ($this->findWalletUseCase)(new WalletId($walletId));
        } catch (WalletNotFoundException $exception) {
            return new Response($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        try {
            $change = ($this->refundMoneyUseCase)($wallet);

            return new Response(
                json_encode([
                    'status' => 'success',
                    'walletId' => (string)$wallet->walletId(),
                    'balance' => number_format($wallet->totalAmount(), 2),
                    'change' => $change
                ]),
                Response::HTTP_OK,
                ['Content-Type' => 'application/json']
            );

        } catch (NoFundsAvailableToRefundException $exception)
        {
            return new Response($exception->getMessage(), Response::HTTP_CONFLICT);
        }
    }
}