<?php

namespace Xrpl\XummSdkPhp\Response\CuratedAssets;

final class Currency
{
    public function __construct(
        public readonly int $id,
        public readonly int $issuerId,
        public string $currency,
        public string $name,
        public ?string $avatar,
        public int $shortlist,
    ) {
    }
}
