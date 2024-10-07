<?php

namespace Unit;

use App\Wallet\Domain\Service\ChangeCalculator;
use PHPUnit\Framework\TestCase;

class ChangeCalculatorTest extends TestCase
{

    private ChangeCalculator $changeCalculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->changeCalculator = new ChangeCalculator();
    }

    public function testCalculateChange(): void
    {

        $result = $this->changeCalculator->calculateChange(11.70);

        $expectedChange = [
            '1.00' => 11,
            '0.25' => 2,
            '0.10' => 2
        ];

        $this->assertEquals($expectedChange, $result);
    }

    public function testCalculateChangeWithExactAmount(): void
    {
        $result = $this->changeCalculator->calculateChange(1.00);

        $expectedChange = [
            '1.00' => 1
        ];

        $this->assertEquals($expectedChange, $result);
    }

    public function testCalculateChangeWithSmallAmount(): void
    {
        $result = $this->changeCalculator->calculateChange(0.15);

        $expectedChange = [
            "0.10" => 1,
            "0.05" => 1
        ];

        $this->assertEquals($expectedChange, $result);
    }
}