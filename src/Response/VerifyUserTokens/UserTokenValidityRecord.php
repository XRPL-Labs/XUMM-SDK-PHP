<?php

namespace Xrpl\XummSdkPhp\Response\VerifyUserTokens;

use Xrpl\XummSdkPhp\Response\XummResponse;

final class UserTokenValidityRecord implements XummResponse
{
    public function __construct(
        public readonly string $userToken,
        public readonly bool $active,
        public readonly ?int $issued = null,
        public readonly ?int $expires = null,
    ) {
    }
}
