<?php

namespace Xrpl\XummSdkPhp\Response\Pong;

final class Call
{
    public function __construct(public readonly string $uuidV4)
    {
    }
}
