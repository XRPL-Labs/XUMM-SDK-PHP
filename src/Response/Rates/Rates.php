<?php

namespace Xrpl\XummSdkPhp\Response\Rates;

use Xrpl\XummSdkPhp\Response\XummResponse;

final class Rates implements XummResponse
{
    public function __construct(
        public readonly float $usd,
        public readonly float $xrp,
        public readonly CurrencyMetadata $currencyMetadata
    ) {
    }
}
