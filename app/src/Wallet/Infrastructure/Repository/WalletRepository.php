<?php

namespace App\Wallet\Infrastructure\Repository;

use App\Shared\Infrastructure\Database\DatabaseConnectionService;
use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Domain\Exception\WalletNotFoundException;
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

    /**
     * @throws WalletNotFoundException
     */
    public function findById(WalletId $walletId): ?Wallet
    {
        $pdo = $this->dbConnectionService->getConnection();
        $stmt = $pdo->prepare('SELECT * FROM wallets WHERE wallet_id = :wallet_id');
        $stmt->execute(['wallet_id' => (string)$walletId]);

        $data = $stmt->fetch();

        if (!$data) {
            throw new WalletNotFoundException($walletId);
        }

        return new Wallet(
            new WalletId($data['wallet_id']),
            new Balance($data['balance'])
        );
    }

    public function create(Wallet $wallet): Wallet
    {
        $pdo = $this->dbConnectionService->getConnection();
        $stmt = $pdo->prepare('INSERT INTO wallets (wallet_id, balance) VALUES (:wallet_id, :balance)');

        $stmt->execute([
            'wallet_id' => (string)$wallet->walletId(),
            'balance' => $wallet->totalAmount()
        ]);

        return $wallet;
    }

    public function update(Wallet $wallet): void
    {
        $pdo = $this->dbConnectionService->getConnection();
        $stmt = $pdo->prepare('UPDATE wallets SET balance = :balance WHERE wallet_id = :wallet_id');
        $stmt->execute([
            'balance' => $wallet->totalAmount(),
            'wallet_id' => (string)$wallet->walletId(),
        ]);
    }
}