<?php

namespace Xrpl\XummSdkPhp\Exception;

use Exception;

final class XummClientLogicException extends Exception implements XummLogicException
{
    private const MESSAGE = 'Xumm API client logic exception';

    public static function forProvidedPostData(): self
    {
        throw new self(self::MESSAGE . ': POST data provided on non-POST request');
    }
}
