<?php

namespace Xrpl\XummSdkPhp\Response\GetPayload;

use Xrpl\XummSdkPhp\Payload\ReturnUrl;

final class PayloadMeta
{
    public function __construct(
        public readonly string $uuid,
        public readonly bool $multisign,
        public readonly bool $submit,
        public readonly string $destination,
        public readonly string $resolvedDestination,
        public readonly bool $resolved,
        public readonly bool $signed,
        public readonly bool $cancelled,
        public readonly bool $expired,
        public readonly bool $pushed,
        public readonly bool $appOpened,
        public readonly bool $isXapp,
        public readonly ?bool $openedByDeeplink = null,
        public readonly ?bool $immutable = null,
        public readonly ?string $returnUrlApp = null,
        public readonly ?string $returnUrlWeb = null,
    ) {
    }
}
