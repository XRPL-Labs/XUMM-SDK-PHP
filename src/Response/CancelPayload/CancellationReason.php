<?php

namespace Xrpl\XummSdkPhp\Response\CancelPayload;

enum CancellationReason: string
{
    case OK = 'OK';
    case ALREADY_CANCELLED = 'ALREADY_CANCELLED';
    case ALREADY_RESOLVED = 'ALREADY_RESOLVED';
    case ALREADY_OPENED = 'ALREADY_OPENED';
    case ALREADY_EXPIRED = 'ALREADY_EXPIRED';
}
