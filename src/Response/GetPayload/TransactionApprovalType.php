<?php

namespace Xrpl\XummSdkPhp\Response\GetPayload;

enum TransactionApprovalType
{
    case PIN;
    case BIOMETRIC;
    case PASSPHRASE;
    case OTHER;
}
