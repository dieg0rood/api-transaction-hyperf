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

namespace App\Request;

use App\Interface\Request\TransactionRequestInterface;
use App\Rule\AmountRule;
use App\ValueObject\Amount;

class TransferRequest extends AbstractFormRequest implements TransactionRequestInterface
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // @codeCoverageIgnoreStart
    public function authorize(): bool
    {
        return true;
    }
// @codeCoverageIgnoreEnd
    public function rules(): array
    {
        return [
            'value' => [
                'required',
                'numeric',
                'min:1',
                new AmountRule(),
            ],
            'payer' => [
                'required',
                'string',
            ],
            'payee' => [
                'required',
                'string',
            ],
        ];
    }

    public function getTransactionValue(): Amount
    {
        return Amount::fromDecimal($this->input('value'));
    }

    public function getSenderId(): string
    {
        return $this->input('payer');
    }

    public function getReceiverId(): string
    {
        return $this->input('payee');
    }
}
