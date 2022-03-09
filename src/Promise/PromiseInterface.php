<?php

namespace Xrpl\XummSdkPhp\Promise;

/**
 * Annoyingly this has to extend a ReactPromise as the async test utilities
 * expect a ReactPromise. Hopefully we'll be able to decouple this at some point in the future.
 */
interface PromiseInterface extends \React\Promise\PromiseInterface
{
    public function then(
        callable $onFulfilled = null,
        callable $onRejected = null,
        callable $onProgress = null
    ): PromiseInterface;

    public function done(callable $onFulfilled = null, callable $onRejected = null): void;
}
