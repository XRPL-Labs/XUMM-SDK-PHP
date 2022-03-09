<?php

namespace Xrpl\XummSdkPhp\Response\Pong;

use Xrpl\XummSdkPhp\Response\XummResponse;

final class Pong implements XummResponse
{
    public function __construct(
        public readonly Quota $quota,
        public readonly ApplicationDetails $application,
        public readonly Call $call,
    ) {
    }
}
