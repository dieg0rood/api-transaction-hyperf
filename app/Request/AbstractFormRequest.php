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

use App\Exception\Request\ValidateFormRequest;
use Hyperf\Validation\Contract\ValidatesWhenResolved;
use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\ValidationException;

class AbstractFormRequest extends FormRequest implements ValidatesWhenResolved
{
    /**
     * @codeCoverageIgnore
     */
    public function validateResolved(): void
    {
        try {
            $validator = $this->getValidatorInstance();

            if ($validator->fails()) {
                throw new ValidateFormRequest($validator->errors()->all());
            }
        } catch (ValidationException $exception) {
            throw new ValidateFormRequest($exception->validator->errors()->all());
        }
    }
}
