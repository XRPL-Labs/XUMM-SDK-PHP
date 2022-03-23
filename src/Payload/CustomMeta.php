<?php

namespace Xrpl\XummSdkPhp\Payload;

final class CustomMeta
{
    public function __construct(
        public readonly ?string $identifier,
        public readonly ?string $instruction,
        public readonly ?array $blob = null,
    ) {
    }
}
