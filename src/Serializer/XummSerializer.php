<?php

namespace Xrpl\XummSdkPhp\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\YamlFileLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Xrpl\XummSdkPhp\Serializer\Normalizer\BackedEnumDenormalizer;
use Xrpl\XummSdkPhp\Serializer\Normalizer\DeletePayloadDenormalizer;
use Xrpl\XummSdkPhp\Serializer\Normalizer\GetRatesResponseDenormalizer;
use Xrpl\XummSdkPhp\Serializer\Normalizer\GetTransactionResponseDenormalizer;
use Xrpl\XummSdkPhp\Serializer\Normalizer\PingResponseDenormalizer;
use Xrpl\XummSdkPhp\Serializer\Normalizer\VerifyTokenNormalizer;

final class XummSerializer implements SerializerInterface
{
    private SerializerInterface $serializer;

    public function __construct()
    {
        $classMetadataFactory = new ClassMetadataFactory(
            new YamlFileLoader(dirname(dirname(dirname(__FILE__))) . '/config/serializer/class_metadata.yaml')
        );
        $metadataAwareNameConverter = new MetadataAwareNameConverter(
            $classMetadataFactory,
            new CamelCaseToSnakeCaseNameConverter(),
        );
        $objNormalizer = new ObjectNormalizer(
            classMetadataFactory: $classMetadataFactory,
            nameConverter: $metadataAwareNameConverter,
            defaultContext: [AbstractObjectNormalizer::SKIP_NULL_VALUES => true],
        );
        $this->serializer = new Serializer(
            [
                new GetRatesResponseDenormalizer($objNormalizer),
                new DeletePayloadDenormalizer($objNormalizer),
                new GetTransactionResponseDenormalizer($objNormalizer),
                new BackedEnumDenormalizer(),
                new PingResponseDenormalizer($objNormalizer),
                new DateTimeNormalizer(),
                new VerifyTokenNormalizer($objNormalizer),
                $objNormalizer
            ],
            [new JsonEncoder()]
        );
    }

    public function serialize(mixed $data, string $format, array $context = []): string
    {
        return $this->serializer->serialize($data, $format, $context);
    }

    public function deserialize(mixed $data, string $type, string $format, array $context = []): mixed
    {
        return $this->serializer->deserialize($data, $type, $format, $context);
    }
}
