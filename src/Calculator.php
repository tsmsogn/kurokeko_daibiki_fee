<?php


namespace Tsmsogn\KuronekoDaibikiFee;


use Tsmsogn\KuronekoDaibikiFee\Exception\DaibikiLimitExceededException;
use Tsmsogn\KuronekoDaibikiFee\Exception\InvalidArgumentException;

class Calculator
{
    /**
     * @var
     */
    protected $payment_type;

    /**
     * @var int[] 税抜決済手数料
     */
    protected $tax_exclude_fees = [
        9999 => 300,
        29999 => 400,
        99999 => 600,
        300000 => 1000,
    ];

    public function __construct($payment_type)
    {
        if (!PaymentType::isValid($payment_type)) {
            throw new InvalidArgumentException();
        }

        $this->payment_type = $payment_type;
    }

    /**
     * 入金額から代金引換手数料を求める
     *
     * @param $nyukin_price
     * @param null $date 手数料計算日
     * @return int
     * @throws DaibikiLimitExceededException
     */
    public function getFeeByNyukinPrice($nyukin_price, $date = null)
    {
        foreach ($this->getFees($date) as $threshold => $fee) {
            $price = $nyukin_price + $fee;
            if ($price <= $threshold) {
                return $fee;
            }
        }

        throw new DaibikiLimitExceededException();
    }

    /**
     * 決済手数料を返す
     *
     * @param null $date 手数料計算日
     * @return array|float[]|int[]
     */
    public function getFees($date = null)
    {
        return array_map(function ($fee) use ($date) {
            return $fee + $fee * $this->getTaxRate($date);
        }, $this->tax_exclude_fees);
    }

    /**
     * 消費税率を返す
     *
     * @param null $date
     * @return int
     */
    protected function getTaxRate($date = null)
    {
        return 0.1;
    }
}