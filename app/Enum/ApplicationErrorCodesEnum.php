<?php

namespace App\Enum;

enum ApplicationErrorCodesEnum: string
{
    case Generic = 'generic';
    case TransactionAuthRequestException = 'transaction_auth_request_exception';
    case InsufficientWalletAmount = 'insufficient_wallet_amount';
    case EnterpriseUserCannotBePayer = 'enterprise_user_cannot_be_payer';
    case NotificationRequestException = 'notification_request_exception';
    case TransactionToYourselfException = 'transaction_to_yourself_exception';
    case TransactionUnauthorizedException = 'transaction_unauthorized_exception';
    case InvalidAmountFormatException = 'invalid_amount_format_exception';
}
