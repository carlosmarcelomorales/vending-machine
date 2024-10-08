<?php

namespace App\VendingMachine\Infrastructure\Repository;

use App\Shared\Infrastructure\Database\DatabaseConnectionService;
use App\VendingMachine\Domain\Entity\Item;
use App\VendingMachine\Domain\Exception\InvalidItemNameException;
use App\VendingMachine\Domain\Exception\ItemNotFoundException;
use App\VendingMachine\Domain\Repository\VendingMachineRepositoryInterface;
use App\VendingMachine\Domain\ValueObject\ItemId;
use App\VendingMachine\Domain\ValueObject\ItemName;
use App\VendingMachine\Domain\ValueObject\ItemPrice;
use App\VendingMachine\Domain\ValueObject\ItemStock;

class VendingMachineRepository implements VendingMachineRepositoryInterface
{
    private DatabaseConnectionService $dbConnectionService;

    public function __construct(DatabaseConnectionService $dbConnectionService)
    {
        $this->dbConnectionService = $dbConnectionService;
    }

    public function findItemByName(ItemName $itemName): Item
    {
        $pdo = $this->dbConnectionService->getConnection();

        $stmt = $pdo->prepare('SELECT * FROM items WHERE name = :name');
        $stmt->execute(['name' => $itemName->name()]);

        $data = $stmt->fetch();

        if (!$data) {
            throw new ItemNotFoundException($itemName->name());
        }

        return new Item(
            new ItemId($data['item_id']),
            new ItemName($data['name']),
            new ItemPrice($data['price']),
            new ItemStock($data['stock'])
        );
    }

    public function update(Item $item): void
    {
        $pdo = $this->dbConnectionService->getConnection();
        $stmt = $pdo->prepare('UPDATE items SET stock = :stock WHERE item_id = :item_id');
        $stmt->execute([
            'stock' => $item->totalStock(),
            'item_id' => (string)$item->id()->id(),
        ]);
    }

    /**
     * @throws ItemNotFoundException
     * @throws InvalidItemNameException
     */
    public function findItemById(ItemId $itemId): Item
    {
        $pdo = $this->dbConnectionService->getConnection();

        $stmt = $pdo->prepare('SELECT * FROM items WHERE item_id = :item_id');
        $stmt->execute(['item_id' => $itemId->id()]);

        $data = $stmt->fetch();

        if (!$data) {
            throw new ItemNotFoundException($itemId->id());
        }

        return new Item(
            new ItemId($data['item_id']),
            new ItemName($data['name']),
            new ItemPrice($data['price']),
            new ItemStock($data['stock'])
        );
    }
}