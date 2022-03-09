<?php

namespace Xrpl\XummSdkPhp\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Xrpl\XummSdkPhp\Response\Rates\Rates;

final class GetRatesResponseDenormalizer implements ContextAwareDenormalizerInterface
{
    public function __construct(private readonly AbstractObjectNormalizer $objectNormalizer)
    {
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === Rates::class;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $metadata = array_pop($data);
        $data['currency_metadata'] = $metadata['currency'] ?? null;

        return $this->objectNormalizer->denormalize($data, $type);
    }
}
