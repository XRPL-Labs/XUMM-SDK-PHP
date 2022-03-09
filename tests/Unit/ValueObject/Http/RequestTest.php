<?php

namespace Xrpl\XummSdkPhp\Tests\Unit\ValueObject\Http;

use PHPUnit\Framework\TestCase;
use Xrpl\XummSdkPhp\ValueObject\Http\Request;

final class RequestTest extends TestCase
{
    /**
     * @test
     */
    public function noMappingExceptionsAreThrown(): void {
        $this->expectNotToPerformAssertions();

        foreach (Request::cases() as $case) {
            $case->getEndPoint();
            $case->getResponseFqcn();
        }
    }
}
