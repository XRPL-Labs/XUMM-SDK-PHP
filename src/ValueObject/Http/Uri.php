<?php

namespace Xrpl\XummSdkPhp\ValueObject\Http;

use Xrpl\XummSdkPhp\Exception\UriBuildingException;

final class Uri
{
    public function __construct(public readonly string $uri)
    {
    }

    /**
     * @throws UriBuildingException
     */
    public static function build(string $endpoint, ?UriParams $params = null): self
    {
        preg_match_all('/:([a-zA-Z]+)/', $endpoint, $matches);

        if (!$paramNames = $matches[1] ?? false) {
            return new Uri($endpoint);
        }

        foreach ($paramNames as $name) {
            try {
                $endpoint = str_replace(sprintf(':%s', $name), $params->get($name), $endpoint);
            } catch (UriBuildingException $e) {
                throw UriBuildingException::forMissingUriParam($name, $endpoint);
            }
        }

        return new Uri($endpoint);
    }
}
