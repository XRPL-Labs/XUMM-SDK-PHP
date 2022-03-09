<?php

namespace Xrpl\XummSdkPhp\Response\GetPayload;

use DateTimeImmutable;

final class Payload
{
    public function __construct(
        public readonly string $txType,
        public readonly string $txDestination,
        public readonly ?string $txDestinationTag,
        public readonly array $request,
        public readonly ?string $originType,
        public readonly ?string $signMethod,
        public readonly DateTimeImmutable $createdAt,
        public readonly DateTimeImmutable $expiresAt,
        public readonly int $expiresInSeconds,
    ) {
    }
}
