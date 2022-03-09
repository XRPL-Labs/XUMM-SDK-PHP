<?php

namespace Xrpl\XummSdkPhp\Response\Pong;

final class Quota
{
    public function __construct(public readonly ?int $rateLimit = null)
    {
    }
}
