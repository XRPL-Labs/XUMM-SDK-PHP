<?php

namespace Xrpl\XummSdkPhp\Tests\Unit\Serializer\Response;

use Symfony\Component\Serializer\SerializerInterface;
use Xrpl\XummSdkPhp\Response\XummResponse;
use Xrpl\XummSdkPhp\Serializer\XummSerializer;

trait SerializationTestCase
{
    private SerializerInterface $serializer;

    /**
     * @before
     */
    public function setup(): void
    {
        $this->serializer = new XummSerializer();
    }

    public function assertDeserializedEquals(string $jsonData, XummResponse $expectedResponse): void
    {
        $actual = $this->serializer->deserialize($jsonData, get_class($expectedResponse),'json');
        $this->assertEquals($expectedResponse, $actual);
    }

    public function assertSerializedEquals(object $obj, string $expected): void
    {
        $actual = $this->serializer->serialize($obj, 'json');
        $this->assertEquals($expected, $actual);
    }
}