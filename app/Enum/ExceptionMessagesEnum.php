<?php

namespace App\Enum;

enum ExceptionMessagesEnum: string
{
    case TransactionUnauthorizedMessage = 'Transaction Unauthorized';
    case InvalidAmountFormatMessage = 'Invalid amount format';
    case NotificationRequestMessage = 'Error to send notification';
    case TransactionToYourselfMessage = 'Cannot transfer to yourself';
    case EnterpriseUserCannotBePayerMessage = 'Enterprise User Cannot Be Payer';
    case InsufficientWalletAmountMessage = 'Insufficient Wallet Balance';
    case UserDataNotFoundMessage = 'User data not found';
    case WalletDataNotFoundMessage = 'Wallet data not found';

}
