<?php

namespace App\VendingMachine\Infrastructure\Controller;

use App\VendingMachine\Application\AddStockUseCase;
use App\VendingMachine\Application\FindItemByNameUseCase;
use App\VendingMachine\Domain\Exception\ItemNotFoundException;
use App\VendingMachine\Domain\ValueObject\ItemId;
use App\VendingMachine\Domain\ValueObject\ItemName;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VendingMachineAddStockController extends AbstractController
{

    private AddStockUseCase $addStockUseCase;
    private FindItemByNameUseCase $findItemByNameUseCase;

    public function __construct(
        AddStockUseCase $addStockUseCase,
        FindItemByNameUseCase $findItemByNameUseCase
    )
    {
        $this->addStockUseCase = $addStockUseCase;
        $this->findItemByNameUseCase = $findItemByNameUseCase;
    }

    public function addStock(Request $request): Response
    {
        $itemName = $request->request->get('itemName');
        $amount = $request->request->get('amount');

        if (!$itemName || !$amount || $amount <= 0) {
            return new Response('Bad Request', Response::HTTP_BAD_REQUEST);
        }

        try {
            $item = ($this->findItemByNameUseCase)(new ItemName($itemName));

            $updatedItem = ($this->addStockUseCase)($item, (int)$amount);

            return new Response(json_encode([
                'status' => 'success',
                'itemId' => $updatedItem->id()->id(),
                'newStock' => $updatedItem->totalStock(),
            ]), Response::HTTP_OK, ['Content-Type' => 'application/json']);

        } catch (ItemNotFoundException $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return new Response('An error occurred: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}