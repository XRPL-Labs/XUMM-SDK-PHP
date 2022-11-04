<?php

declare(strict_types=1);

namespace Xrpl\XummSdkPhp\Payload;

use Xrpl\XummSdkPhp\Exception\Payload\InvalidArgumentException;

final class Options
{
    /**
     * @throws InvalidArgumentException
     * @param array<string>|null $signers
     */
    public function __construct(
        public readonly ?bool $submit = null,
        public readonly ?bool $multisign = null,
        public readonly ?int $expire = null,
        public readonly ?bool $immutable = null,
        public readonly ?bool $forceAccount = null,
        public readonly ?ReturnUrl $returnUrl = null,
        public readonly ?array $signers = null,
    ) {
        if (!is_null($this->signers)) {
            foreach ($this->signers as $key => $signer) {
                $this->validate($signer, $key);
            }
        }
    }

    /**
     * @param $value
     * @param int $key
     * @return void
     * @throws InvalidArgumentException
     */
    private function validate($value, int $key): void
    {
        if (!is_string($value)) {
            $type = gettype($value);
            throw new InvalidArgumentException("Argument #$key must be of type ?string, $type given");
        }
    }
}
