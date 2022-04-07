<?php

namespace Xrpl\XummSdkPhp\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Xrpl\XummSdkPhp\Exception\Http\UnexpectedResponseException;
use Xrpl\XummSdkPhp\Response\VerifyUserTokens\UserTokenValidityRecord;
use Xrpl\XummSdkPhp\Response\VerifyUserTokens\UserTokenValidityRecordList;

final class VerifyTokenNormalizer implements ContextAwareDenormalizerInterface
{
    public function __construct(private readonly AbstractObjectNormalizer $objectNormalizer)
    {
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === UserTokenValidityRecord::class;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $tokens = $data['tokens'] ?? null;

        if (!$tokens) {
            throw UnexpectedResponseException::create();
        }

        $token = $tokens[0] ?? null;
        return $token ? $this->objectNormalizer->denormalize($token, $type) : null;
    }
}
