<?php


namespace Tsmsogn\KuronekoDaibikiFee;


use MyCLabs\Enum\Enum;

class PaymentType extends Enum
{
    const CASH = 1;
    const CREDIT_CARD = 2;
    const ELECTRONIC_MONEY = 3;
}