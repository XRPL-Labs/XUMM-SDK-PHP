<?php

namespace Xrpl\XummSdkPhp\Tests\Unit\Client\Guzzle;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Promise\RejectedPromise;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Xrpl\XummSdkPhp\Client\XummClient;
use Xrpl\XummSdkPhp\Client\Guzzle\XummClient as GuzzleXummClient;
use Xrpl\XummSdkPhp\Exception\Http\BadRequestException;
use Xrpl\XummSdkPhp\Exception\Http\NotFoundException;
use Xrpl\XummSdkPhp\Exception\Http\UnauthorizedException;
use Xrpl\XummSdkPhp\Exception\Http\UnexpectedResponseException;
use Xrpl\XummSdkPhp\ValueObject\Credentials;
use Xrpl\XummSdkPhp\ValueObject\Http\Request;

final class XummClientTest extends TestCase
{
    private readonly XummClient $xummClient;
    private readonly Client|MockObject $httpClient;

    public function setUp(): void
    {
        $serializer = new Serializer(
            [new ObjectNormalizer()],
            [new JsonEncoder()]
        );

        $this->httpClient = $this->createMock(Client::class);

        $this->xummClient = new GuzzleXummClient(
            Credentials::create('foo', 'bar'),
            $serializer,
            $this->httpClient,
        );
    }

    /**
     * @test
     * @dataProvider badRequestProvider
     */
    public function handlesBadRequest(int $statusCode, string $expectedException): void
    {
        $this->expectException($expectedException);

        $this->httpClient->expects($this->once())
            ->method('requestAsync')
            ->willReturn(new RejectedPromise(
                new BadResponseException(
                    'Whoops',
                    new GuzzleRequest('GET', '/ping'),
                    new Response($statusCode)
                )
            ));

        $this->xummClient->get(Request::ping);
    }

    public function badRequestProvider(): iterable
    {
        yield [404, NotFoundException::class];
        yield [403, UnauthorizedException::class];
        yield [400, BadRequestException::class];
        yield [418, UnexpectedResponseException::class];
    }
}
