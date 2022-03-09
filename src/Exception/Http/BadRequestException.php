<?php

namespace Xrpl\XummSdkPhp\Exception\Http;

use Throwable;
use Xrpl\XummSdkPhp\Exception\Http\XummBadResponseException;
use Exception;

final class BadRequestException extends Exception implements XummBadResponseException
{
    private const MSG = 'The request you made was invalid. Please check the parameters you provided: %s';
    public static function create(Throwable $prev = null): self
    {
        return new self(sprintf(self::MSG, $prev->getMessage()));
    }
}
