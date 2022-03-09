<?php

namespace Xrpl\XummSdkPhp\Exception\Payload;

use Exception;
use Xrpl\XummSdkPhp\Exception\Http\XummBadResponseException;

final class PayloadCancellationException extends Exception implements XummBadResponseException
{
    private const BASE_MSG = 'Could not cancel payload as it was already ';

    public static function forReason(string $reason): self
    {
        return match ($reason) {
            'ALREADY_CANCELLED' => new self(self::BASE_MSG . 'cancelled'),
            'ALREADY_RESOLVED' => new self(self::BASE_MSG . 'rejected or signed'),
            'ALREADY_OPENED' => new self(self::BASE_MSG . 'opened by the user'),
            'ALREADY_EXPIRED' => new self(self::BASE_MSG . 'expired'),
        };
    }
}
