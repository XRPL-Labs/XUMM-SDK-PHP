<?php

namespace Xrpl\XummSdkPhp\Response\GetKycStatus;

enum KycStatusEnum:string
{
    case NONE = 'NONE';
    case IN_PROGRESS = 'IN_PROGRESS';
    case REJECTED = 'REJECTED';
    case SUCCESSFUL = 'SUCCESSFUL';
}
