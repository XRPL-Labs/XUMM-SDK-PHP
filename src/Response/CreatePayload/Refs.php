<?php

namespace Xrpl\XummSdkPhp\Response\CreatePayload;

final class Refs
{
    public function __construct(
        public readonly string $qrPng,
        public readonly string $qrMatrix,
        public readonly string $websocketStatus,
        public readonly array $qrUriQualityOptions
    ) {
    }
}
