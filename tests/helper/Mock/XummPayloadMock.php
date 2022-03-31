<?php

namespace Xrpl\XummSdkPhp\Tests\helper\Mock;

use Xrpl\XummSdkPhp\Response\GetPayload\Application;
use Xrpl\XummSdkPhp\Response\GetPayload\Payload;
use Xrpl\XummSdkPhp\Response\GetPayload\PayloadMeta;
use Xrpl\XummSdkPhp\Response\GetPayload\Response as PayloadResponse;
use DateTimeImmutable;
use Xrpl\XummSdkPhp\Response\GetPayload\XummPayload;

final class XummPayloadMock
{
    public static function create(string $uuid = 'some-uuid'): XummPayload
    {
        return new XummPayload(
            new Payload(
                'SignIn',
                'me',
                [],
                new DateTimeImmutable(),
                new DateTimeImmutable(),
                300,
            ),
            new PayloadMeta(
                $uuid,
                true,
                false,
                'me',
                'me',
                false,
                false,
                false,
                true,
                true,
                true,
                false,
            ),
            new Application(
                'cool app',
                'A very cool app.',
                'some-uuid',
                false,
                'http://example.org/icon.jpg'
            ),
            new PayloadResponse('some-txid')
        );
    }
}