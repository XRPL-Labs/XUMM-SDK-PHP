<?php

namespace Xrpl\XummSdkPhp\Response\CuratedAssets;

use Xrpl\XummSdkPhp\Response\XummResponse;

final class CuratedAssets implements XummResponse
{
    /**
     * @var Issuer[]
     */
    public readonly array $details;

    public function __construct(
        public readonly IssuersFlatList $issuers,
        public readonly CurrenciesFlatList $currencies,
        Issuer ...$details
    ) {
        $this->details = $details;
    }
}
