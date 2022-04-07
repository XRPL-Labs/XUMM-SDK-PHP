<?php

namespace Xrpl\XummSdkPhp\Response\VerifyUserTokens;

use Xrpl\XummSdkPhp\Response\XummResponse;

final class UserTokenValidityRecordList implements XummResponse
{
    /**
     * @var UserTokenValidityRecord[]
     */
    public readonly array $tokens;

    public function __construct(?array $tokens = [])
    {
        $this->tokens =  $tokens;
    }
}
