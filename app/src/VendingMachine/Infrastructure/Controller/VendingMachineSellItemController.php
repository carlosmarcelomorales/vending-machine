<?php

namespace App\VendingMachine\Infrastructure\Controller;

use App\VendingMachine\Application\FindItemByNameUseCase;
use App\VendingMachine\Application\PurchaseItemUseCase;
use App\VendingMachine\Domain\Exception\InsufficientFundsException;
use App\VendingMachine\Domain\Exception\OutOfStockException;
use App\VendingMachine\Domain\ValueObject\ItemName;
use App\Wallet\Application\FindWalletUseCase;
use App\Wallet\Domain\Exception\WalletNotFoundException;
use App\Wallet\Domain\ValueObject\WalletId;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class VendingMachineSellItemController
{

    private FindWalletUseCase $findWalletUseCase;
    private FindItemByNameUseCase $findItemByNameUseCase;
    private PurchaseItemUseCase $purchaseItemUseCase;

    public function __construct(
        FindWalletUseCase $findWalletUseCase,
        FindItemByNameUseCase $findItemByNameUseCase,
        PurchaseItemUseCase $purchaseItemUseCase
    ) {
        $this->findWalletUseCase = $findWalletUseCase;
        $this->findItemByNameUseCase = $findItemByNameUseCase;
        $this->purchaseItemUseCase = $purchaseItemUseCase;
    }

    public function sellItem(Request $request): Response
    {
        $walletId = $request->query->get('walletId');

        try {
            $wallet = ($this->findWalletUseCase)(new WalletId($walletId));
        } catch (WalletNotFoundException $exception) {
            return new Response($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $itemName = $request->query->get('item');

        try {
            $item = ($this->findItemByNameUseCase)(new ItemName($itemName));
            $purchasedItem = ($this->purchaseItemUseCase)($wallet, $item);
        } catch (InsufficientFundsException|OutOfStockException $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return new Response('An error occurred: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new Response(
            json_encode([
                'status' => 'success',
                'item' => $purchasedItem->name(),
                'price' => $purchasedItem->price(),
            ]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }
}