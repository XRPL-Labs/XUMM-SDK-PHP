<?php

namespace Xrpl\XummSdkPhp\Response\GetKycStatus;

use Xrpl\XummSdkPhp\Response\XummResponse;

final class KycStatus implements XummResponse
{
    public function __construct(public readonly KycStatusEnum $kycStatus)
    {
    }
}
