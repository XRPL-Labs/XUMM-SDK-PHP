<?php

namespace Xrpl\XummSdkPhp\Tests\Unit\ValueObject\Http;

use PHPUnit\Framework\TestCase;
use Xrpl\XummSdkPhp\Exception\UriBuildingException;
use Xrpl\XummSdkPhp\ValueObject\Http\Uri;
use Xrpl\XummSdkPhp\ValueObject\Http\UriParams;

final class UriTest extends TestCase
{
    /**
     * @test
     * @dataProvider uriParamProvider
     */
    public function buildReturnsExpectedResult(string $endpoint, array $params, string $expectedResult): void {
        $uri = Uri::build($endpoint, new UriParams($params));
        $this->assertEquals($expectedResult, $uri->uri);
    }

    /**
     * @test
     */
    public function buildFailsForMissingParam(): void {
        $this->expectException(UriBuildingException::class);
        Uri::build('some/:cool/endpoint', new UriParams(['foo' => 'bar']));
    }

    public function uriParamProvider(): array {
        $params = ['foo' => 'bar', 'cool' => 'nice', 'ada' => 'lovelace'];
        return [
            'no uri params' => ['some/cool/endpoint', $params, 'some/cool/endpoint'],
            'one uri param' => ['hopper/hamilton/:ada', $params, 'hopper/hamilton/lovelace'],
            'multiple uri params' => [':foo/:cool/endpoint', $params, 'bar/nice/endpoint'],
            'sandwiched uri param' => [
                'some/:cool/endpoint',
                ['foo' => 'bar', 'cool' => 'nice'],
                'some/nice/endpoint'
            ]
        ];
    }
}
