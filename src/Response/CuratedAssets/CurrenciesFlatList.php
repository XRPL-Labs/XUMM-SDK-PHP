<?php

namespace Xrpl\XummSdkPhp\Response\CuratedAssets;

final class CurrenciesFlatList
{
    /**
     * @var string[]
     */
    public readonly array $currencies;

    public function __construct(string ...$currencies)
    {
        $this->currencies = $currencies;
    }
}
