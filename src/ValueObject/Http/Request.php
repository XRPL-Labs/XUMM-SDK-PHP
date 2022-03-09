<?php

namespace Xrpl\XummSdkPhp\ValueObject\Http;

use Xrpl\XummSdkPhp\Exception\RequestMappingException;
use Xrpl\XummSdkPhp\Response\CancelPayload\DeletedPayload;
use Xrpl\XummSdkPhp\Response\CreatePayload\CreatedPayload;
use Xrpl\XummSdkPhp\Response\CuratedAssets\CuratedAssets;
use Xrpl\XummSdkPhp\Response\GetKycStatus\KycStatus;
use Xrpl\XummSdkPhp\Response\GetPayload\XummPayload;
use Xrpl\XummSdkPhp\Response\Rates\Rates;
use Xrpl\XummSdkPhp\Response\Transaction\XrplTransaction;
use Xrpl\XummSdkPhp\Response\Pong\Pong;
use Throwable;

// phpcs:disable
enum Request
{
    case deletePayload;
    case createPayload;
    case getPayload;
    case getPayloadByCustomId;
    case getCuratedAssets;
    case getRates;
    case getKycStatusForAccount;
    case getKycStatusByUserToken;
    case getTransaction;
    case ping;

    // phpcs:disable
    public function getEndPoint(): string
    {
        try {
            return match ($this->name) {
                'deletePayload' => 'payload/:payload',
                'createPayload' => 'payload',
                'getPayload' => 'payload/:uuid',
                'getPayloadByCustomId' => 'payload/ci/:id',
                'getCuratedAssets' => 'curated-assets',
                'getKycStatusForAccount' => 'kyc-status/:account',
                'getKycStatusByUserToken' => 'kyc-status',
                'getTransaction' => 'xrpl-tx/:txid',
                'getRates' => 'rates/:currency',
                'ping' => 'ping',

            };
        } catch (Throwable $e) {
            throw RequestMappingException::forEndpoint($this);
        }
    }

    // phpcs:disable
    public function getResponseFqcn(): string
    {
        try {
            return match ($this->name) {
                'deletePayload' => DeletedPayload::class,
                'createPayload' => CreatedPayload::class,
                'getPayload' => XummPayload::class,
                'getPayloadByCustomId' => XummPayload::class,
                'getCuratedAssets' => CuratedAssets::class,
                'getKycStatusForAccount' => KycStatus::class,
                'getKycStatusByUserToken' => KycStatus::class,
                'getTransaction' => XrplTransaction::class,
                'getRates' => Rates::class,
                'ping' => Pong::class,
            };
        } catch (Throwable $e) {
            throw RequestMappingException::forEndpoint($this);
        }
    }
}
