<?php

namespace Xrpl\XummSdkPhp\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Xrpl\XummSdkPhp\Response\Transaction\XrplTransaction;

final class GetTransactionResponseDenormalizer implements ContextAwareDenormalizerInterface
{
    public function __construct(private readonly AbstractObjectNormalizer $objectNormalizer)
    {
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === XrplTransaction::class;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $data['balanceChanges'] = $this->denormalizeBalanceChanges($data['balanceChanges']);

        return $this->objectNormalizer->denormalize($data, $type);
    }

    private function denormalizeBalanceChanges(array $data): array
    {
        $denormalizedChanges = [];
        foreach ($data as $accountId => $changes) {
            $denormalizedChanges = array_merge(
                $this->addAccountIdToChanges($accountId, $changes),
                $denormalizedChanges,
            );
        }

        return $denormalizedChanges ?? [];
    }

    private function addAccountIdToChanges(string $accountId, array $changes): array
    {
        return array_map(fn ($change) => array_merge(['account' => $accountId], $change), $changes);
    }
}
