<?php

namespace App\Wallet\Infrastructure\Repository;

use App\Shared\Infrastructure\Database\DatabaseConnectionService;
use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Domain\Repository\WalletRepositoryInterface;
use App\Wallet\Domain\ValueObject\Balance;
use App\Wallet\Domain\ValueObject\WalletId;

class WalletRepository implements WalletRepositoryInterface
{

    private DatabaseConnectionService $dbConnectionService;

    public function __construct(DatabaseConnectionService $dbConnectionService)
    {
        $this->dbConnectionService = $dbConnectionService;
    }

    public function findById(WalletId $walletId): ?Wallet
    {
        $pdo = $this->dbConnectionService->getConnection();
        $stmt = $pdo->prepare('SELECT * FROM wallets WHERE wallet_id = :wallet_id');
        $stmt->execute(['wallet_id' => (string)$walletId]);

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return new Wallet(
            new WalletId($data['wallet_id']),
            new Balance($data['balance'])
        );
    }
}