<?php

namespace Xrpl\XummSdkPhp\ValueObject\Http;

enum Method
{
    case DELETE;
    case GET;
    case POST;

    // phpcs:disable
    public function is(Method $method): bool
    {
        return $this->name === $method->name;
    }
}
