<?php

namespace Xrpl\XummSdkPhp\Exception;

use Exception;

final class UriBuildingException extends Exception implements XummLogicException
{
    public static function forInvalidUriParamFormat(): self
    {
        return new self('Uri params must be provided as key => value pairs');
    }

    public static function forUriParamNotFound(string $param): self
    {
        return new self(sprintf('Uri param [%s] does not exist', $param));
    }

    public static function forMissingUriParam(string $param, string $uri): self
    {
        return new self(sprintf('Expected uri param [%s] to be provided for uri [%s]', $param, $uri));
    }
}
