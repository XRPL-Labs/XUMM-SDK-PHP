<?php

namespace Xrpl\XummSdkPhp\Tests\Unit\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Xrpl\XummSdkPhp\Exception\Http\XummBadResponseException;
use Xrpl\XummSdkPhp\Serializer\Normalizer\PingResponseDenormalizer;
use PHPUnit\Framework\TestCase;
use Xrpl\XummSdkPhp\Response\Pong\Pong;

final class PingResponseDenormalizerTest extends TestCase
{
    /**
     * @test
     */
    public function failsForUnexpectedResponse(): void {
        $denormalizer = new PingResponseDenormalizer(new ObjectNormalizer());
        $data = json_encode(['cool' => 'value']);

        $this->expectException(XummBadResponseException::class);
        $denormalizer->denormalize($data, Pong::class);
    }
}
