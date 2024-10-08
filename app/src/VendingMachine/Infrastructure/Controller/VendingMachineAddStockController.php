<?php

namespace App\VendingMachine\Infrastructure\Controller;

use App\VendingMachine\Application\AddStockUseCase;
use App\VendingMachine\Application\FindItemByIdUseCase;
use App\VendingMachine\Domain\Exception\ItemNotFoundException;
use App\VendingMachine\Domain\ValueObject\ItemId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VendingMachineAddStockController extends AbstractController
{

    private AddStockUseCase $addStockUseCase;
    private FindItemByIdUseCase $findItemByIdUseCase;

    public function __construct(
        AddStockUseCase $addStockUseCase,
        FindItemByIdUseCase $findItemByIdUseCase
    )
    {
        $this->addStockUseCase = $addStockUseCase;
        $this->findItemByIdUseCase = $findItemByIdUseCase;
    }

    public function addStock(Request $request): Response
    {
        $itemId = $request->request->get('itemId');
        $amount = $request->request->get('amount');

        if (!$itemId || !$amount || $amount <= 0) {
            return new Response('Bad Request', Response::HTTP_BAD_REQUEST);
        }

        try {
            $item = ($this->findItemByIdUseCase)(new ItemId($itemId));

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