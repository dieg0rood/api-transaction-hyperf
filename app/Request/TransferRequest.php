<?php

declare(strict_types=1);

namespace App\Request;

use App\Interface\Request\TransactionRequestInterface;
use App\Rule\AmountRule;
use App\ValueObject\Amount;

class TransferRequest extends AbstractFormRequest implements TransactionRequestInterface
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'value' => [
                'required',
                'numeric',
                'min:1',
                new AmountRule()
            ],
            'payer' => [
                'required',
                'string'
            ],
            'payee' => [
                'required',
                'string'
            ]
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
