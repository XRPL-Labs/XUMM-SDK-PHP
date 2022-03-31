<?php

namespace Xrpl\XummSdkPhp\Client\Guzzle;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Xrpl\XummSdkPhp\Exception\Http\NotFoundException;
use Xrpl\XummSdkPhp\Exception\XummClientLogicException;
use Xrpl\XummSdkPhp\Response\XummResponse;
use Xrpl\XummSdkPhp\ValueObject\Http\Request;
use Xrpl\XummSdkPhp\Client\XummClient as XummClientInterface;
use Xrpl\XummSdkPhp\Exception\Http\BadRequestException;
use Xrpl\XummSdkPhp\Exception\Http\UnauthorizedException;
use Xrpl\XummSdkPhp\Exception\Http\UnexpectedResponseException;
use Xrpl\XummSdkPhp\Exception\ResponseDeserializationException;
use Xrpl\XummSdkPhp\Exception\Http\XummBadResponseException;
use Xrpl\XummSdkPhp\Exception\XummException;
use Xrpl\XummSdkPhp\ValueObject\Credentials;
use Xrpl\XummSdkPhp\ValueObject\Http\Method;
use Xrpl\XummSdkPhp\ValueObject\Http\Uri;
use Xrpl\XummSdkPhp\ValueObject\Http\UriParams;
use Throwable;

final class XummClient implements XummClientInterface
{
    public function __construct(
        private readonly Credentials $credentials,
        private readonly SerializerInterface $serializer,
        private readonly ClientInterface $client,
    ) {
    }

    /**
     * @throws XummException
     */
    public function get(Request $request, ?UriParams $uriParams = null): XummResponse
    {
        return $this->request(Method::GET, $request, $uriParams, null)->wait();
    }

    public function post(Request $request, string $jsonBody, ?UriParams $uriParams = null): XummResponse
    {
        return $this->request(Method::POST, $request, $uriParams, $jsonBody)->wait();
    }

    public function delete(Request $request, UriParams $uriParams): XummResponse
    {
        return $this->request(Method::DELETE, $request, $uriParams, null)->wait();
    }

    /**
     * @throws XummException
     */
    private function request(
        Method $method,
        Request $request,
        ?UriParams $uriParams,
        ?string $jsonBody
    ): PromiseInterface {
        if ($jsonBody !== null && !$method->is(Method::POST)) {
            throw XummClientLogicException::forProvidedPostData();
        }

        $options = $this->buildOptions($jsonBody);

        return $this->client->requestAsync(
            $method->name,
            Uri::build($request->getEndPoint(), $uriParams)->uri,
            $options
        )->then(
            function (ResponseInterface $res) use ($request) {
                $responseFqcn = $request->getResponseFqcn();
                $result = $this->serializer->deserialize($res->getBody(), $responseFqcn, 'json');

                if (!$result) {
                    throw ResponseDeserializationException::forFqcn($responseFqcn);
                }
                return $result;
            },
            fn(Throwable $res) => $this->handleBadResponse($res)
        );
    }

    private function buildOptions(?string $jsonBody): array
    {
        $headers = ['headers' => $this->getHeaders()];
        return $jsonBody ? array_merge(['body' => $jsonBody], $headers) : $headers;
    }

    private function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'X-API-Key' => $this->credentials->apiKey,
            'X-API-Secret' => $this->credentials->apiSecret,
        ];
    }

    /**
     * @throws XummBadResponseException
     */
    private function handleBadResponse(Throwable $response): void
    {
        switch ($response->getCode()) {
            case 400:
                throw BadRequestException::create($response);
            case 403:
                throw UnauthorizedException::create();
            case 404:
                throw NotFoundException::create();
            default:
                throw UnexpectedResponseException::create();
        }
    }
}
