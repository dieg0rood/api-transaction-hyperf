<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

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
