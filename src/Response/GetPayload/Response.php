<?php

namespace Xrpl\XummSdkPhp\Response\GetPayload;

use DateTimeImmutable;

final class Response
{
    public function __construct(
        public readonly ?string $txid = null,
        public readonly ?DateTimeImmutable $resolvedAt = null,
        public readonly ?string $dispatchedNodeType = null,
        public readonly ?string $dispatchedTo = null,
        public readonly ?string $dispatchedResult = null,
        public readonly ?string $multisignAccount = null,
        public readonly ?string $account = null,
        public readonly ?TransactionApprovalType $approvedWith = null,
    ) {
    }
}
