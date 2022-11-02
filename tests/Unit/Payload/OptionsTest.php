<?php

namespace Xrpl\XummSdkPhp\Tests\Unit\Payload;

use PHPUnit\Framework\TestCase;
use TypeError;
use Xrpl\XummSdkPhp\Payload\Options;

class OptionsTest extends TestCase
{
    /**
     * @test
     */
    public function optionsCanHaveSigners(): void
    {
        $this->expectNotToPerformAssertions();

        new Options(signers: ['signer-1', 'signer-2']);
    }

    /**
     * @test
     */
    public function optionsCanHaveOnlyStringSigners(): void
    {
        $this->expectException(TypeError::class);

        new Options(signers: [true, 2, 3, 4, 5]);
    }
}