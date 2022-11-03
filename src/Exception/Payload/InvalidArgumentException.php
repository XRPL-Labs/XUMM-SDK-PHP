<?php

namespace Xrpl\XummSdkPhp\Exception\Payload;

use Exception;
use Xrpl\XummSdkPhp\Exception\XummLogicException;

class InvalidArgumentException extends Exception implements XummLogicException
{
}
