<?php

namespace App\Wallet\Infrastructure\Controller;

use App\Wallet\Application\AddMoneyUseCase;
use App\Wallet\Application\FindWalletUseCase;
use App\Wallet\Domain\ValueObject\WalletId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WalletController extends AbstractController
{

    private AddMoneyUseCase $addMoneyUseCase;
    private FindWalletUseCase $findWalletUseCase;

    public function __construct(
        AddMoneyUseCase $addMoneyUseCase,
        FindWalletUseCase $findWalletUseCase
    )
    {
        $this->addMoneyUseCase = $addMoneyUseCase;
        $this->findWalletUseCase = $findWalletUseCase;
    }

    public function addMoney(Request $request): Response
    {

        $walletId = new WalletId($request->request->get('walletId'));
        $wallet = ($this->findWalletUseCase)($walletId);

        dd($wallet);
    }


}