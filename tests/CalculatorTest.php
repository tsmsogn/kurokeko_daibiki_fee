<?php


namespace Tsmsogn\KuronekoDaibikiFee\Test;


use PHPUnit\Framework\TestCase;
use Tsmsogn\KuronekoDaibikiFee\Calculator;
use Tsmsogn\KuronekoDaibikiFee\Exception\DaibikiLimitExceededException;
use Tsmsogn\KuronekoDaibikiFee\Exception\InvalidArgumentException;
use Tsmsogn\KuronekoDaibikiFee\PaymentType;

class CalculatorTest extends TestCase
{
    /**
     * @var Calculator
     */
    private $calculator;

    public function setUp(): void
    {
        parent::setUp();

        $this->calculator = new Calculator(PaymentType::CASH);
    }

    /**
     * @return void
     */
    public function init()
    {
        $this->expectException(InvalidArgumentException::class);

        new Calculator(0);
    }

    /**
     * @return void
     */
    public function testGetFeeByNyukin()
    {
        $this->assertEquals(330, $this->calculator->getFeeByNyukinPrice(4670));
        $this->assertEquals(440, $this->calculator->getFeeByNyukinPrice(9670));
    }

    /**
     * @return void
     */
    public function testGetFeeByNyukinWithDaikinLimitExceed()
    {
        $this->expectException(DaibikiLimitExceededException::class);

        // 298901 + 1100 = 300001
        $this->calculator->getFeeByNyukinPrice(298901);
    }

    /**
     * @return void
     */
    public function testGetFees()
    {
        $this->assertIsArray($this->calculator->getFees());
    }
}