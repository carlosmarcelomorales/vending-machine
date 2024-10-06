<?php

namespace App\Wallet\Infrastructure\Controller;

use App\Wallet\Application\AddMoneyUseCase;
use App\Wallet\Application\CreateNewWalletUseCase;
use App\Wallet\Application\FindWalletUseCase;
use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Domain\Exception\InvalidMoneyAmountException;
use App\Wallet\Domain\Exception\WalletNotFoundException;
use App\Wallet\Domain\ValueObject\Money;
use App\Wallet\Domain\ValueObject\WalletId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WalletController extends AbstractController
{

    private AddMoneyUseCase $addMoneyUseCase;
    private FindWalletUseCase $findWalletUseCase;
    private CreateNewWalletUseCase $createNewWalletUseCase;

    public function __construct(
        AddMoneyUseCase $addMoneyUseCase,
        FindWalletUseCase $findWalletUseCase,
        CreateNewWalletUseCase $createNewWalletUseCase
    )
    {
        $this->addMoneyUseCase = $addMoneyUseCase;
        $this->findWalletUseCase = $findWalletUseCase;
        $this->createNewWalletUseCase = $createNewWalletUseCase;
    }

    public function addMoney(Request $request): Response
    {
        try {
            $this->ensureRequest($request);
            $amount = new Money($request->request->get('amount'));
        } catch (InvalidMoneyAmountException $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $walletId = $request->request->get('walletId');
        try {
            $wallet = $this->getWallet($walletId, $amount);
        } catch (WalletNotFoundException $exception) {
            return new Response($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        dd($wallet);
    }

    private function getWallet(?string $walletId, Money $money): Wallet
    {
        return $walletId ? ($this->findWalletUseCase)(new WalletId($walletId)) : ($this->createNewWalletUseCase)($money);
    }

    /**
     * @throws InvalidMoneyAmountException
     */
    private function ensureRequest(Request $request): void
    {
        if (!$request->request->has('amount')) {
            throw new InvalidMoneyAmountException('Amount is required.');
        }
    }


}