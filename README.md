# kurokeko_daibiki_fee


## Installation

```shell
composer require tsmsogn/kuroneko_daibiki_fee
```

## Usage

```php
$calculator = new Calculator(PaymentType::CASH);

$calculator->getFeeByNyukinPrice(4670); // 330
$calculator->getFeeByNyukinPrice(9670); // 440
```
