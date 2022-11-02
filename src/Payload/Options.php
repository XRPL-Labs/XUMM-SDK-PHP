<?php
declare (strict_types=1);

namespace Xrpl\XummSdkPhp\Payload;

final class Options
{
    /**
     * @param array<string>|null $signers
     */
    public function __construct(
        public readonly ?bool $submit = null,
        public readonly ?bool $multisign = null,
        public readonly ?int $expire = null,
        public readonly ?bool $immutable = null,
        public readonly ?bool $forceAccount = null,
        public readonly ?array $signers = null,
        public readonly ?ReturnUrl $returnUrl = null,
        public readonly ?array $signers = null,
    ) {
        if($signers) $this->typeArrayNullString(...$signers);
    }
    private function typeArrayNullString(?string ...$args): void {
    }
}
