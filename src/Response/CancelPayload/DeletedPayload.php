<?php

namespace Xrpl\XummSdkPhp\Response\CancelPayload;

use Xrpl\XummSdkPhp\Response\XummResponse;

final class DeletedPayload implements XummResponse
{
    public function __construct(public readonly bool $cancelled, public readonly CancellationReason $reason)
    {
    }
}
