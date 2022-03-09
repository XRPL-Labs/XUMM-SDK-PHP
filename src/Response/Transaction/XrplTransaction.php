<?php

namespace Xrpl\XummSdkPhp\Response\Transaction;

use Xrpl\XummSdkPhp\Response\XummResponse;

final class XrplTransaction implements XummResponse
{
    /**
     * @var BalanceChange[]
     */
    public readonly array $balanceChanges;

    public function __construct(
        public readonly string $txid,
        public readonly string $node,
        public readonly array $transaction,
        BalanceChange ...$balanceChanges,
    ) {
        $this->balanceChanges = $balanceChanges;
    }
}
