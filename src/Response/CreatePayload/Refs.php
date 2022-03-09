<?php

namespace Xrpl\XummSdkPhp\Response\CreatePayload;

final class Refs
{
    /**
     * @var string[]
     */
    public readonly array $qrUriQualityOptions;

    public function __construct(
        public readonly string $qrPng,
        public readonly string $qrMatrix,
        public readonly string $websocketStatus,
        string ...$qrUriQualityOptions
    ) {
        $this->qrUriQualityOptions = $qrUriQualityOptions;
    }
}
