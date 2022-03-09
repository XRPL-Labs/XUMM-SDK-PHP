<?php

namespace Xrpl\XummSdkPhp\Payload;

final class ReturnUrl
{
    public function __construct(
        public readonly ?string $app,
        public readonly ?string $web,
    ) {
    }
}
