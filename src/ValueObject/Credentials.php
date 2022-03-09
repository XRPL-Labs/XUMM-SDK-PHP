<?php

namespace Xrpl\XummSdkPhp\ValueObject;

use Xrpl\XummSdkPhp\Exception\InsufficientCredentialsException;

final class Credentials
{
    private function __construct(
        public readonly string $apiKey,
        public readonly string $apiSecret,
    ) {
    }

    public static function create(?string $apiKey, ?string $apiSecret, ?string $baseUri = null): self
    {
        if (!$apiKey || !$apiSecret) {
            throw new InsufficientCredentialsException();
        }

        return new static($apiKey, $apiSecret, $baseUri);
    }
}
