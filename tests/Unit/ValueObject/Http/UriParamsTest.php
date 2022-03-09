<?php

namespace Xrpl\XummSdkPhp\Tests\Unit\ValueObject\Http;

use Xrpl\XummSdkPhp\Exception\UriBuildingException;
use Xrpl\XummSdkPhp\ValueObject\Http\UriParams;
use PHPUnit\Framework\TestCase;

final class UriParamsTest extends TestCase
{
    /**
     * @test
     */
    public function constructFailsForInvalidFormat(): void {
        $this->expectException(UriBuildingException::class);
        new UriParams(['foo', 'bar']);
    }

    /**
     * @test
     */
    public function getReturnsExpectedResult(): void {
        $params = new UriParams(['foo' => 'bar', 'nice' => 'param']);
        $this->assertEquals('param', $params->get('nice'));
    }

    /**
     * @test
     */
    public function getFailsForMissingParam(): void {
        $this->expectException(UriBuildingException::class);

        $params = new UriParams(['foo' => 'bar', 'nice' => 'param']);
        $params->get('whoops');
    }
}
