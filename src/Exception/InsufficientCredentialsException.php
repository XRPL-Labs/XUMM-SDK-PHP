<?php

namespace Xrpl\XummSdkPhp\Exception;

final class InsufficientCredentialsException extends \Exception implements XummLogicException
{
    public function __construct()
    {
        parent::__construct('API key and secret must not be empty.');
    }
}
