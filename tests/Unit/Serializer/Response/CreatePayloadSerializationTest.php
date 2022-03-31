<?php

namespace Xrpl\XummSdkPhp\Tests\Unit\Serializer\Response;

use PHPUnit\Framework\TestCase;
use Xrpl\XummSdkPhp\Payload\CustomMeta;
use Xrpl\XummSdkPhp\Payload\Options;
use Xrpl\XummSdkPhp\Payload\Payload;
use Generator;
use Xrpl\XummSdkPhp\Payload\ReturnUrl;
use Xrpl\XummSdkPhp\Response\CreatePayload\CreatedPayload;
use Xrpl\XummSdkPhp\Response\CreatePayload\Next;
use Xrpl\XummSdkPhp\Response\CreatePayload\Refs;

final class CreatePayloadSerializationTest extends TestCase
{
    use SerializationTestCase;

    /**
     * @test
     * @dataProvider serializeDataProvider
     */
    public function serialize(object $object, string $json): void
    {
        $this->assertSerializedEquals($object, trim($json));
    }

    /**
     * @test
     */
    public function deserialize(): void
    {
        $json = <<<JS
{
  "uuid": "81feacac-c98a-4884-9a07-f6ff6126a2c0",
  "next": {
    "always": "https://xumm.app/sign/81feacac-c98a-4884-9a07-f6ff6126a2c0",
    "no_push_msg_received": "https://xumm.app/sign/81feacac-c98a-4884-9a07-f6ff6126a2c1"
  },
  "refs": {
    "qr_png": "https://xumm.app/sign/81feacac-c98a-4884-9a07-f6ff6126a2c0_q.png",
    "qr_matrix": "https://xumm.app/sign/81feacac-c98a-4884-9a07-f6ff6126a2c0_q.json",
    "qr_uri_quality_opts": [
      "m",
      "q",
      "h"
    ],
    "websocket_status": "wss://xumm.app/sign/81feacac-c98a-4884-9a07-f6ff6126a2c0"
  },
  "pushed": false
}
JS;
        $this->assertDeserializedEquals($json, new CreatedPayload(
            '81feacac-c98a-4884-9a07-f6ff6126a2c0',
            new Next(
                'https://xumm.app/sign/81feacac-c98a-4884-9a07-f6ff6126a2c0',
                'https://xumm.app/sign/81feacac-c98a-4884-9a07-f6ff6126a2c1'
            ),
            new Refs(
                'https://xumm.app/sign/81feacac-c98a-4884-9a07-f6ff6126a2c0_q.png',
                'https://xumm.app/sign/81feacac-c98a-4884-9a07-f6ff6126a2c0_q.json',
                'wss://xumm.app/sign/81feacac-c98a-4884-9a07-f6ff6126a2c0',
                ['m', 'q', 'h']
            ),
            false
        ));
    }

    public function serializeDataProvider(): Generator
    {
        yield [new Payload(['TransactionType' => 'SignIn']), '{"txjson":{"TransactionType":"SignIn"}}'];
        yield [new Payload(
            ['TransactionType' => 'SignIn'],
            null,
            new Options(
                submit: true,
                expire: 5,
                returnUrl: new ReturnUrl(
                    'http://example.org/app',
                    null,
                )
            ),
            new CustomMeta(null, 'Please pay me!', ['foo' => 'bar'])
        ),
            json_encode([
                'txjson' => ['TransactionType' => 'SignIn'],
                'options' => [
                    'submit' => true,
                    'expire' => 5,
                    'return_url' => ['app' => 'http://example.org/app']
                ],
                'custom_meta' => ['instruction' => 'Please pay me!', 'blob' => ['foo' => 'bar']]
            ])
        ];
    }
}
