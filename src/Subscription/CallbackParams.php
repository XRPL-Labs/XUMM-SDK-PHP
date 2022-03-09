<?php

namespace Xrpl\XummSdkPhp\Subscription;

use Xrpl\XummSdkPhp\Response\GetPayload\XummPayload;

final class CallbackParams
{
    public function __construct(
        public readonly string $uuid,
        public readonly array $data,
        public readonly XummPayload $payload,
    ) {
    }
}
