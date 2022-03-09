<?php

namespace Xrpl\XummSdkPhp\Exception;

use Exception;

final class MessageDecodingException extends Exception implements XummException
{
    public static function forInvalidJson(string $message): self
    {
        return new self('Could not decode incoming message from JSON. Message: ' . $message);
    }
}
