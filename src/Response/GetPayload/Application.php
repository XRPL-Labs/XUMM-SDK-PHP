<?php

namespace Xrpl\XummSdkPhp\Response\GetPayload;

final class Application
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly string $uuidV4,
        public readonly bool $disabled,
        public readonly string $iconUrl,
        public readonly ?string $issuedUserToken = null,
    ) {
    }
}
