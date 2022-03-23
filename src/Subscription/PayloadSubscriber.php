<?php

namespace Xrpl\XummSdkPhp\Subscription;

use Psr\Log\LoggerInterface;
use React\Promise\Deferred;
use Xrpl\XummSdkPhp\Exception\MessageDecodingException;
use Xrpl\XummSdkPhp\Response\GetPayload\XummPayload;

use function Ratchet\Client\connect;

/**
 * Subscribes to payloads for status updates via WebSocket.
 */
final class PayloadSubscriber
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {
    }

    public function subscribe(XummPayload $payload, string $websocketStatus, ?callable $callback = null): Subscription
    {
        /**
         * This is ugly, but there's a small chance a created XUMM payload has not been distributed
         * across the load balanced XUMM backend, so wait a bit.
         */
        usleep(75000);

        $deferred = new Deferred();

        connect($websocketStatus)->then(function ($conn) use ($payload, $callback, $deferred) {
            $this->log('Subscription active (WebSocket opened)', $payload->payloadMeta->uuid);

            $conn->on('message', function ($msg) use ($conn, $payload, $callback, $deferred) {
                $this->handleMessage($msg, $payload, $callback, $deferred);
            });

            $conn->on('close', function () use ($payload) {
                $this->log('Subscription ended (WebSocket closed', $payload->payloadMeta->uuid);
            });

            $deferred->promise()->then(function () use ($conn) {
                $conn->close();
            });
        }, function ($e) {
            echo "Could not connect: {$e->getMessage()}\n";
        });

        return new Subscription($payload, $deferred);
    }

    private function log(string $message, string $uuid): void
    {
        $this->logger->info($message, ['uuid' => $uuid]);
    }

    private function handleMessage(string $msg, XummPayload $payload, ?callable $callback, Deferred $deferred): void
    {
        $data = json_decode($msg, 1);

        if (!$data) {
            $deferred->reject(MessageDecodingException::forInvalidJson($msg));
            throw MessageDecodingException::forInvalidJson($msg);
        }

        $params = new CallbackParams($payload->payloadMeta->uuid, $data, $payload);

        if ($callback && !isset($data['devapp_fetched'])) {
            try {
                $result = $callback($params);
                if ($result !== null) {
                    $deferred->resolve($result);
                }
            } catch (\Throwable $e) {
                $deferred->reject($e);
            }
        }
    }
}
