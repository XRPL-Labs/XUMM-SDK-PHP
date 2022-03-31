<?php

namespace Xrpl\XummSdkPhp\Response\GetPayload;

use Xrpl\XummSdkPhp\Payload\CustomMeta;
use Xrpl\XummSdkPhp\Response\XummResponse;

final class XummPayload implements XummResponse
{
    public function __construct(
        public readonly Payload $payload,
        public readonly PayloadMeta $payloadMeta,
        public readonly Application $application,
        public readonly ?Response $response = null,
        public readonly ?CustomMeta $customMeta = null,
    ) {
    }
}
