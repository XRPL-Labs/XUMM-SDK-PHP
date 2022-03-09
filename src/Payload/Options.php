<?php

namespace Xrpl\XummSdkPhp\Payload;

final class Options
{
    public function __construct(
        public readonly ?bool $submit,
        public readonly ?bool $multisign,
        public readonly ?bool $expire,
        public readonly ?bool $immutable,
        public readonly ?bool $forceAccount,
        public readonly ?ReturnUrl $returnUrl,
    ) {
    }
}
