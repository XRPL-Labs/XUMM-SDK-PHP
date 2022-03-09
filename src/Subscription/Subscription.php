<?php

namespace Xrpl\XummSdkPhp\Subscription;

use React\Promise\Deferred;
use Xrpl\XummSdkPhp\Promise\PromiseInterface;
use Xrpl\XummSdkPhp\Promise\React\Promise;
use Xrpl\XummSdkPhp\Response\GetPayload\XummPayload;

final class Subscription
{
    public function __construct(
        public readonly XummPayload $payload,
        private readonly Deferred $deferred,
    ) {
    }

    public function end(): void
    {
        $this->deferred->resolve(true);
    }

    public function resolved(): PromiseInterface
    {
        return new Promise($this->deferred->promise());
    }
}
