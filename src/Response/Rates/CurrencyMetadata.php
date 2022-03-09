<?php

namespace Xrpl\XummSdkPhp\Response\Rates;

final class CurrencyMetadata
{
    public function __construct(
        public readonly ?string $en,
        public readonly string $code,
        public readonly string $symbol,
        public readonly int $isoDecimals
    ) {
    }
}
