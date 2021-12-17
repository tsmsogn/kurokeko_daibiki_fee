<?php


namespace Tsmsogn\KuronekoDaibikiFee;


use Tsmsogn\KuronekoDaibikiFee\Exception\DaibikiLimitExceededException;

class Calculator
{
    /**
     * @var
     */
    protected $payment_type;

    /**
     * @var int[] 決済手数料
     */
    protected $fees = [
        9999 => 330,
        29999 => 440,
        99999 => 660,
        300000 => 1100,
    ];

    public function __construct($payment_type)
    {
        if (!PaymentType::isValid($payment_type)) {
            throw new Exception\InvalidArgumentException();
        }

        $this->payment_type = $payment_type;
    }

    /**
     * 入金額から代金引換手数料を求める
     *
     * @param $nyukin_price
     * @return int
     * @throws DaibikiLimitExceededException
     */
    public function getFeeByNyukinPrice($nyukin_price)
    {
        foreach ($this->getFees() as $threshold => $fee) {
            $price = $nyukin_price + $fee;
            if ($price <= $threshold) {
                return $fee;
            }
        }

        throw new DaibikiLimitExceededException();
    }

    /**
     * @return int[]
     */
    public function getFees()
    {
        return $this->fees;
    }
}