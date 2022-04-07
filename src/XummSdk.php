<?php

namespace Xrpl\XummSdkPhp;

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\Serializer\SerializerInterface;
use Xrpl\XummSdkPhp\Client\Guzzle\XummClient;
use Xrpl\XummSdkPhp\Client\XummClient as XummClientInterface;
use Xrpl\XummSdkPhp\Exception\Http\UnexpectedResponseException;
use Xrpl\XummSdkPhp\Exception\Payload\PayloadCancellationException;
use Xrpl\XummSdkPhp\Exception\XummException;
use Xrpl\XummSdkPhp\Payload\Payload;
use Xrpl\XummSdkPhp\Response\CancelPayload\DeletedPayload;
use Xrpl\XummSdkPhp\Response\CreatePayload\CreatedPayload;
use Xrpl\XummSdkPhp\Response\CuratedAssets\CuratedAssets;
use Xrpl\XummSdkPhp\Response\GetKycStatus\KycStatus;
use Xrpl\XummSdkPhp\Response\GetPayload\XummPayload;
use Xrpl\XummSdkPhp\Response\Pong\Pong;
use Xrpl\XummSdkPhp\Response\Rates\Rates;
use Xrpl\XummSdkPhp\Response\Transaction\XrplTransaction;
use Xrpl\XummSdkPhp\Response\VerifyUserTokens\UserTokenValidityRecordList;
use Xrpl\XummSdkPhp\Serializer\XummSerializer;
use Xrpl\XummSdkPhp\Subscription\PayloadSubscriber;
use Xrpl\XummSdkPhp\Subscription\Subscription;
use Xrpl\XummSdkPhp\ValueObject\Credentials;
use Xrpl\XummSdkPhp\Response\XummResponse;
use Xrpl\XummSdkPhp\ValueObject\Http\Request;
use Xrpl\XummSdkPhp\ValueObject\Http\UriParams;

final class XummSdk
{
    private const XUMM_BASE_URI = 'https://xumm.app/api/v1/platform/';

    private readonly XummClientInterface $client;
    private readonly SerializerInterface $serializer;
    private readonly PayloadSubscriber $subscriber;

    public function __construct(string $apiKey = null, string $apiSecret = null)
    {
        $this->serializer = new XummSerializer();
        $this->configure($apiKey, $apiSecret);
    }

    /** HELPER METHODS */

    public function ping(): Pong & XummResponse
    {
        return $this->client->get(Request::ping);
    }

    public function getCuratedAssets(): CuratedAssets & XummResponse
    {
        return $this->client->get(Request::getCuratedAssets);
    }

    public function getRates(string $currencyCode): Rates & XummResponse
    {
        return $this->client->get(Request::getRates, new UriParams(['currency' => $currencyCode]));
    }

    public function getTransaction(string $txid): XrplTransaction & XummResponse
    {
        return $this->client->get(Request::getTransaction, new UriParams(['txid' => $txid]));
    }

    public function getKycStatusForAccount(string $accountId): XummResponse
    {
        return $this->client->get(Request::getKycStatusForAccount, new UriParams(['account' => $accountId]));
    }

    public function getKycStatusByUserToken(string $userToken): KycStatus & XummResponse
    {
        $body = json_encode(['user_token' => $userToken]);
        return $this->client->post(Request::getKycStatusByUserToken, $body);
    }

    public function verifyUserTokens(string ...$userTokens): UserTokenValidityRecordList & XummResponse
    {
        $body = json_encode(['tokens' => $userTokens]);
        return $this->client->post(Request::verifyUserTokens, $body);
    }

    public function verifyUserToken(string $token): ?XummResponse
    {
        try {
            return $this->client->get(Request::verifyUserToken, new UriParams(['token' => $token]));
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        return null;
    }

    /**
     * PAYLOAD METHODS (GET, CREATE, SUBSCRIBE, CANCEL, ETC.)
     */

    /**
     * Refer to the docs for full specification of payload options.
     */
    public function createPayload(Payload $payload): CreatedPayload & XummResponse
    {
        $data = $this->serializer->serialize($payload, 'json');
        return $this->client->post(Request::createPayload, $data);
    }

    public function getPayload(string $uuid): XummPayload & XummResponse
    {
        return $this->client->get(Request::getPayload, new UriParams(['uuid' => $uuid]));
    }

    /**
     * If your custom identifier is not a string, it should be cast here
     * as it needs to be passed as a URI parameter to the API.
     */
    public function getPayloadByCustomId(string $id): XummPayload & XummResponse
    {
        return $this->client->get(Request::getPayloadByCustomId, new UriParams(['id' => $id]));
    }

    /**
     * Handle incoming payload status updates using your user-defined callback function.
     *
     * End the Subscription by returning non-void in your callback function,
     * or by calling Subscription::end manually on the Subscription returned by this method.
     */
    public function subscribe(CreatedPayload $createdPayload, ?callable $callback = null): Subscription
    {
        $payload = $this->getPayload($createdPayload->uuid);
        return $this->subscriber->subscribe($payload, $createdPayload->refs->websocketStatus, $callback);
    }

    /**
     * @throws XummException
     */
    public function cancel(CreatedPayload $payload): void
    {
        $params = new UriParams(['payload' => $payload->uuid]);
        $result = $this->client->delete(Request::deletePayload, $params);

        if (!$result instanceof DeletedPayload) {
            throw UnexpectedResponseException::create();
        }

        if ($result->cancelled === false) {
            throw PayloadCancellationException::forReason($result->reason);
        }
    }

    private function configure(?string $apiKey, ?string $apiSecret): void
    {
        Dotenv::createImmutable(dirname(dirname(__FILE__)))->safeLoad();

        $mode = $_SERVER['MODE'] ?? 'prod';
        $baseUri = $mode === 'test' ? $_SERVER['XUMM_TEST_BASE_URI'] : self::XUMM_BASE_URI;

        $this->client = new XummClient(
            Credentials::create(
                $apiKey ?? $_SERVER['XUMM_API_KEY'] ?? null,
                $apiSecret ?? $_SERVER['XUMM_API_SECRET'] ?? null,
            ),
            $this->serializer,
            new Client(['base_uri' => $baseUri]),
        );

        $this->subscriber = new PayloadSubscriber(
            new Logger('payload', [new StreamHandler('php://stdout')])
        );
    }
}
