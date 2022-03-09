<?php

namespace Xrpl\XummSdkPhp\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Xrpl\XummSdkPhp\Exception\Http\UnexpectedResponseException;
use Xrpl\XummSdkPhp\Response\Pong\Pong;

final class PingResponseDenormalizer implements ContextAwareDenormalizerInterface
{
    public function __construct(private readonly AbstractObjectNormalizer $objectNormalizer)
    {
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === Pong::class;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        if (!isset($data['auth'])) {
            throw UnexpectedResponseException::create();
        }

        return $this->objectNormalizer->denormalize($data['auth'], $type);
    }
}
