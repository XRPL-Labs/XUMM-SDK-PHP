<?php

namespace Xrpl\XummSdkPhp\Tests\Unit\Serializer\Response;

use PHPUnit\Framework\TestCase;
use Xrpl\XummSdkPhp\Payload\CustomMeta;
use Xrpl\XummSdkPhp\Response\GetPayload\Application;
use Xrpl\XummSdkPhp\Response\GetPayload\Payload;
use Xrpl\XummSdkPhp\Response\GetPayload\PayloadMeta;
use Xrpl\XummSdkPhp\Response\GetPayload\Response;
use Xrpl\XummSdkPhp\Response\GetPayload\XummPayload;

final class GetPayloadSerializationTest extends TestCase
{
    use SerializationTestCase;

    /**
     * @test
     */
    public function deserialize(): void
    {
        $json = <<<JS
{
  "meta": {
    "exists": true,
    "uuid": "34174044-d2b6-4d3e-a394-daa777007985",
    "multisign": false,
    "submit": false,
    "destination": "",
    "resolved_destination": "",
    "resolved": false,
    "signed": false,
    "cancelled": false,
    "expired": false,
    "pushed": false,
    "app_opened": false,
    "opened_by_deeplink": null,
    "return_url_app": null,
    "return_url_web": null,
    "is_xapp": false
  },
  "application": {
    "name": "Xumm PHP SDK test",
    "description": "App for testing the Xumm PHP SDK",
    "disabled": 0,
    "uuidv4": "72495d71-0601-4225-aba5-40cf9a57aee7",
    "icon_url": "https://example.com/icon.jpeg",
    "issued_user_token": null
  },
  "payload": {
    "tx_type": "SignIn",
    "tx_destination": "",
    "tx_destination_tag": null,
    "request_json": {
      "TransactionType": "SignIn",
      "SignIn": true
    },
    "origintype": null,
    "signmethod": null,
    "created_at": "2022-03-31T12:00:34Z",
    "expires_at": "2022-04-01T12:00:34Z",
    "expires_in_seconds": 86369
  },
  "response": {
    "hex": null,
    "txid": null,
    "resolved_at": null,
    "dispatched_to": null,
    "dispatched_result": null,
    "dispatched_nodetype": null,
    "multisign_account": null,
    "account": null
  },
  "custom_meta": {
    "identifier": null,
    "blob": null,
    "instruction": null
  }
}
JS;
        $this->assertDeserializedEquals($json, new XummPayload(
            new Payload(
                txType: 'SignIn',
                txDestination: '',
                request: [
                    'TransactionType' => 'SignIn',
                    'SignIn' => true,
                ],
                createdAt: new \DateTimeImmutable('2022-03-31T12:00:34Z'),
                expiresAt: new \DateTimeImmutable('2022-04-01T12:00:34Z'),
                expiresInSeconds: 86369
            ),
            payloadMeta: new PayloadMeta(
                uuid: "34174044-d2b6-4d3e-a394-daa777007985",
                multisign: false,
                submit: false,
                appOpened: false,
                destination: '',
                resolvedDestination: '',
                resolved: false,
                signed: false,
                cancelled: false,
                expired: false,
                pushed: false,
                isXapp: false,
            ),
            application: new Application(
                name: 'Xumm PHP SDK test',
                description: 'App for testing the Xumm PHP SDK',
                uuidV4: '72495d71-0601-4225-aba5-40cf9a57aee7',
                disabled: 0,
                iconUrl: 'https://example.com/icon.jpeg'
            ),
            response: new Response(),
            customMeta: new CustomMeta(),
        ));
    }
}
