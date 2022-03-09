<?php

namespace Xrpl\XummSdkPhp\Promise\React;

use Xrpl\XummSdkPhp\Promise\PromiseInterface;
use React\Promise\Promise as ReactPromise;

final class Promise implements PromiseInterface
{
    public function __construct(private readonly ReactPromise $promise)
    {
    }

    public function then(
        callable $onFulfilled = null,
        callable $onRejected = null,
        callable $onProgress = null,
    ): PromiseInterface {
        return new self($this->promise->then($onFulfilled, $onRejected, $onProgress));
    }

    public function done(callable $onFulfilled = null, callable $onRejected = null): void
    {
        $this->promise->done($onFulfilled, $onRejected);
    }
}
