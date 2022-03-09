<?php

namespace Xrpl\XummSdkPhp\Response\CuratedAssets;

use Xrpl\XummSdkPhp\Response\XummResponse;

final class Issuer implements XummResponse
{
    /**
     * @var Currency[]
     */
    public readonly array $currencies;

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $domain,
        public readonly ?string $avatar,
        public readonly int $shortlist,
        Currency ...$currencies
    ) {
        $this->currencies = $currencies;
    }
}
