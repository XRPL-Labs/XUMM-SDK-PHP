<?php

namespace Xrpl\XummSdkPhp\Payload;

final class Payload
{
    public function __construct(
        public readonly array $transactionBody,
        public readonly ?string $userToken = null,
        public readonly ?Options $options = null,
        public readonly ?CustomMeta $customMeta = null,
    ) {
    }
}
