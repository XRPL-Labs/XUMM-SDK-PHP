<?php

namespace Xrpl\XummSdkPhp\Exception;

use Exception;

final class ResponseDeserializationException extends Exception implements XummLogicException
{
    public static function forFqcn(string $fqcn): self
    {
        return new self(
            sprintf(
                'Couldn\'t deserialize API response into instance of %s. Is the serializer misconfigured?',
                $fqcn
            )
        );
    }
}
