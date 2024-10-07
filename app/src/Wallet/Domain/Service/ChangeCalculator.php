<?php

namespace App\Wallet\Domain\Service;

class ChangeCalculator
{
    public function calculateChange(float $totalBalance): array
    {
        $acceptedValues = [1.00, 0.25, 0.10, 0.05];
        $change = [];

        foreach ($acceptedValues as $acceptedValue) {
            $coinCount = floor($totalBalance / $acceptedValue);

            if ($coinCount > 0) {
                $change[number_format($acceptedValue, 2)] = (int)$coinCount;

                $totalBalance -= $coinCount * $acceptedValue;
                $totalBalance = round($totalBalance, 2);
            }
        }

        return $change;
    }
}