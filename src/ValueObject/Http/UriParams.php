<?php

namespace Xrpl\XummSdkPhp\ValueObject\Http;

use Xrpl\XummSdkPhp\Exception\UriBuildingException;

final class UriParams
{
    /**
     * @var string[]
     */
    public readonly array $params;

    /**
     * @throws UriBuildingException
     */
    public function __construct(array $params)
    {
        $this->ensureValidParams($params);
        $this->params = $params;
    }

    /**
     * @throws UriBuildingException
     */
    private function ensureValidParams(array $params): void
    {
        foreach ($params as $k => $v) {
            if (!is_string($k) || (!is_string($v) && !is_int($v))) {
                throw UriBuildingException::forInvalidUriParamFormat();
            }
        }
    }

    /**
     * @throws UriBuildingException
     */
    public function get(string $param): string
    {
        if (!array_key_exists($param, $this->params)) {
            throw UriBuildingException::forUriParamNotFound($param);
        }
        return $this->params[$param];
    }
}
