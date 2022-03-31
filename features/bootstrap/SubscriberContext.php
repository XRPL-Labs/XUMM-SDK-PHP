<?php

use Behat\Behat\Context\Context;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\TestHandler;
use Monolog\Logger;
use WyriHaximus\AsyncTestUtilities\AsyncTestCase;
use Xrpl\XummSdkPhp\Response\CreatePayload\CreatedPayload;
use Xrpl\XummSdkPhp\Response\CreatePayload\Next;
use Xrpl\XummSdkPhp\Response\CreatePayload\Refs;
use Xrpl\XummSdkPhp\Subscription\CallbackParams;
use Xrpl\XummSdkPhp\Subscription\PayloadSubscriber;
use Xrpl\XummSdkPhp\Subscription\Subscription;
use Xrpl\XummSdkPhp\Tests\helper\Mock\XummPayloadMock;
use function Ratchet\Client\connect;

final class SubscriberContext extends AsyncTestCase implements Context
{
    private const PAYLOAD_UUID = '00000000-0000-4839-af2f-f794874a80b0';
    private const CALLBACK_MSG = 'Hey! I\'ve returned!';

    private PayloadSubscriber $subscriber;
    private CreatedPayload $payload;
    private Subscription $subscription;
    private TestHandler $logHandler;
    private mixed $callbackResult = null;

    /**
     * @BeforeScenario
     */
    public function prepare()
    {
        $this->logHandler = new TestHandler();
        $this->subscriber = new PayloadSubscriber(
            new Logger('test', [
                $this->logHandler,
                new StreamHandler('php://stdout'),
            ])
        );
    }

    /**
     * @Given I have created a payload
     */
    public function aCreatedPayload(): void
    {
        $this->payload = new CreatedPayload(
        self::PAYLOAD_UUID,
            new Next('http://example.org/sign'),
            new Refs(
                'qr.png',
                '{}',
                'ws://localhost:8081',
                ['m', 'q']
            ),
            false,
        );
    }

    /**
     * @When I subscribe to that payload
     */
    public function subscribeToPayload(): void
    {
        $this->subscription = $this->subscriber->subscribe(
            XummPayloadMock::create(self::PAYLOAD_UUID),
            $this->payload->refs->websocketStatus,
            fn (CallbackParams $params) => self::CALLBACK_MSG,
        );
    }

    /**
     * @When I receive a message :message
     */
    public function receiveAMessage(string $msg): void
    {
        connect($this->payload->refs->websocketStatus)->then(function($conn) use ($msg) {
            $conn->send($msg);
            $conn->close();
        }, function ($e) {
            echo "Could not connect: {$e->getMessage()}\n";
        });
    }

    /**
     * @Then my callback result should be returned
     */
    public function callBackHasReturned(): void
    {
        $this->callbackResult = $this->await($this->subscription->resolved());
    }

    /**
     * @When I end the subscription manually
     */
    public function endSubscriptionManually(): void {
        $this->subscription->end();
    }

    /**
     * @Then the subscription will have ended
     */
    public function subscriptionEnded(): void
    {
        $this->assertTrue($this->logHandler->hasInfoThatContains('Subscription ended (WebSocket closed'));
    }
}
