<?php

namespace Xrpl\XummSdkPhp\Payload;

final class CustomMeta
{
    public function __construct(
        public readonly ?string $identifier = null,
        public readonly ?string $instruction = null,
        public readonly ?array $blob = null,
    ) {
    }
}
