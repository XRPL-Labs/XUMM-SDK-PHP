<?php

namespace Xrpl\XummSdkPhp\Exception\Http;

use Exception;

final class UnexpectedResponseException extends Exception implements XummBadResponseException
{
    public static function create(): self
    {
        return new self('Received an unexpected API response');
    }
}
