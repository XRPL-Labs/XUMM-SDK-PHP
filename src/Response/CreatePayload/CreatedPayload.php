<?php

namespace Xrpl\XummSdkPhp\Response\CreatePayload;

use Xrpl\XummSdkPhp\Response\XummResponse;

final class CreatedPayload implements XummResponse
{
    public function __construct(
        public readonly string $uuid,
        public readonly Refs $refs,
        public readonly bool $pushed,
    ) {
    }
}
