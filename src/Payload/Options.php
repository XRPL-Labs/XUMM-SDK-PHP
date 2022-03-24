<?php

namespace Xrpl\XummSdkPhp\Payload;

final class Options
{
    public function __construct(
        public readonly ?bool $submit = null,
        public readonly ?bool $multisign = null,
        public readonly ?int $expire = null,
        public readonly ?bool $immutable = null,
        public readonly ?bool $forceAccount = null,
        public readonly ?ReturnUrl $returnUrl = null,
    ) {
    }
}
