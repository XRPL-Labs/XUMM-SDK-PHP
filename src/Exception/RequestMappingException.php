<?php

namespace Xrpl\XummSdkPhp\Exception;

use Exception;
use Xrpl\XummSdkPhp\ValueObject\Http\Request;

final class RequestMappingException extends Exception implements XummLogicException
{
    private const MESSAGE = 'No %s mapped for call [%s]';

    public static function forRequestMethod(Request $request): self
    {
        return new self(sprintf(self::MESSAGE, 'request method', $request->name));
    }

    public static function forEndpoint(Request $request): self
    {
        return new self(sprintf(self::MESSAGE, 'endpoint', $request->name));
    }

    public static function forResponseFqcn(Request $request): self
    {
        return new self(sprintf(self::MESSAGE, 'response FQCN', $request->name));
    }
}
