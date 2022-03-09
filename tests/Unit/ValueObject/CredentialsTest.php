<?php

namespace Xrpl\XummSdkPhp\Tests\Unit\ValueObject;

use Xrpl\XummSdkPhp\Exception\InsufficientCredentialsException;
use Xrpl\XummSdkPhp\ValueObject\Credentials;
use PHPUnit\Framework\TestCase;

final class CredentialsTest extends TestCase
{
    /**
     * @test
     */
    public function createFailsForMissingKey(): void {
        $this->expectException(InsufficientCredentialsException::class);
        Credentials::create(null, 'some-secret');
    }

    /**
     * @test
     */
    public function createFailsForMissingSecret(): void {
        $this->expectException(InsufficientCredentialsException::class);
        Credentials::create('some-key', null);
    }
}
