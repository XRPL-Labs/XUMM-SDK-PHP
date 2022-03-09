<?php

namespace Xrpl\XummSdkPhp\Response\Pong;

final class ApplicationDetails
{
    public function __construct(
        /**
         * @SerializedName ("uuidv4")
         */
        public readonly string $uuidV4,
        public readonly string $name,
        public readonly string $webhookUrl,
        public readonly bool $disabled,
    ) {
    }
}
