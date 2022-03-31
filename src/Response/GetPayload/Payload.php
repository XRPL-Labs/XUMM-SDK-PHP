<?php

namespace Xrpl\XummSdkPhp\Response\GetPayload;

use DateTimeImmutable;

final class Payload
{
    public function __construct(
        public readonly string $txType,
        public readonly string $txDestination,
        public readonly array $request,
        public readonly DateTimeImmutable $createdAt,
        public readonly DateTimeImmutable $expiresAt,
        public readonly int $expiresInSeconds,
        public readonly ?string $txDestinationTag = null,
        public readonly ?string $originType = null,
        public readonly ?string $signMethod = null,
    ) {
    }
}
