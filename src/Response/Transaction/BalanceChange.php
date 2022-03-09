<?php

namespace Xrpl\XummSdkPhp\Response\Transaction;

final class BalanceChange
{
    public function __construct(
        public readonly string $account,
        public readonly string $currency,
        public readonly string $value,
    ) {
    }
}
