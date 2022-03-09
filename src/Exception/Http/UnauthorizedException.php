<?php

namespace Xrpl\XummSdkPhp\Exception\Http;

use Exception;
use Xrpl\XummSdkPhp\Exception\Http\XummBadResponseException;

final class UnauthorizedException extends Exception implements XummBadResponseException
{
    private const MESSAGE = 'You are not authorized to make this request. Please provide valid API credentials';

    public static function create(): self
    {
        return new self(self::MESSAGE);
    }
}
