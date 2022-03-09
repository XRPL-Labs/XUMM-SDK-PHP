<?php

namespace Xrpl\XummSdkPhp\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Xrpl\XummSdkPhp\Response\CancelPayload\DeletedPayload;

final class DeletePayloadDenormalizer implements ContextAwareDenormalizerInterface
{
    public function __construct(private readonly AbstractObjectNormalizer $objectNormalizer)
    {
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === DeletedPayload::class;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        return $this->objectNormalizer->denormalize($data['result'], $type);
    }
}
