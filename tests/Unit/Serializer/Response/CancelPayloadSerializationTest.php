<?php

namespace Xrpl\XummSdkPhp\Tests\Unit\Serializer\Response;

use Xrpl\XummSdkPhp\Response\CancelPayload\CancellationReason;
use Xrpl\XummSdkPhp\Response\CancelPayload\DeletedPayload;

final class CancelPayloadSerializationTest
{
    use SerializationTestCase;

    /**
     * @test
     */
    public function deserialize(): void
    {
        $data = <<<JS
{
  "result": {
    "cancelled": true,
    "reason": "OK"
  },
  "meta": {
    "exists": true,
    "uuid": "95deb115-de21-4d04-830f-e5f608a6da65",
    "multisign": false,
    "submit": false,
    "destination": "",
    "resolved_destination": "",
    "resolved": false,
    "signed": false,
    "cancelled": false,
    "expired": true,
    "pushed": false,
    "app_opened": false,
    "opened_by_deeplink": null,
    "return_url_app": null,
    "return_url_web": null,
    "is_xapp": false
  },
  "custom_meta": {
    "identifier": null,
    "blob": null,
    "instruction": null
  }
}
JS;
        $this->assertDeserializedEquals($data, new DeletedPayload(
            true,
            CancellationReason::OK,
        ));
    }
}
