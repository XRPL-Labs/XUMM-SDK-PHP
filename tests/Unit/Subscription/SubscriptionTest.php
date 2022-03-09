<?php

namespace Xrpl\XummSdkPhp\Tests\Unit\Subscription;

use React\Promise\Deferred;
use Xrpl\XummSdkPhp\Subscription\Subscription;
use PHPUnit\Framework\TestCase;
use Xrpl\XummSdkPhp\Tests\helper\Mock\XummPayloadMock;

final class SubscriptionTest extends TestCase
{
    /**
     * @test
     */
    public function endResolvesPromise(): void
    {
        $deferred = new Deferred();

        $subscription = new Subscription(XummPayloadMock::create(), $deferred);
        $subscription->end();

        $deferred->promise()->done(
            function ($result) {
                $this->assertTrue($result);
            },
            function () {
                throw new \Exception('Ending a subscription is not expected to fail.');
            }
        );
    }
}
