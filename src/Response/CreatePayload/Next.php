<?php

namespace Xrpl\XummSdkPhp\Response\CreatePayload;

final class Next
{
    public function __construct(
        public readonly string $always,
        public readonly ?string $noPushMessageReceived = null,
    ) {
    }
}
