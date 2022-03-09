<?php

namespace Xrpl\XummSdkPhp\Exception\Http;

use Exception;

final class NotFoundException extends Exception implements XummBadResponseException
{
    public static function create(): self
    {
        return new self('The requested resource was not found.');
    }
}
