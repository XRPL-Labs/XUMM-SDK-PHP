<?php

namespace Xrpl\XummSdkPhp\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Xrpl\XummSdkPhp\Response\CancelPayload\CancellationReason;
use Xrpl\XummSdkPhp\Response\GetKycStatus\KycStatus;
use Xrpl\XummSdkPhp\Response\GetKycStatus\KycStatusEnum;

final class BackedEnumDenormalizer implements ContextAwareDenormalizerInterface
{
    private const SUPPORTED = [
        KycStatusEnum::class,
        CancellationReason::class,
    ];

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return in_array($type, self::SUPPORTED);
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        return call_user_func($type . '::from', $data);
    }
}
