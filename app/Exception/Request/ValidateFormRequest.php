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

namespace App\Exception\Request;

use Hyperf\HttpMessage\Exception\UnprocessableEntityHttpException;
/**
 * @codeCoverageIgnore
 */
class ValidateFormRequest extends UnprocessableEntityHttpException
{
    public function __construct(?array $data = [])
    {
        $errorEncoded = json_encode($this->getTreatedError($data));
        parent::__construct($errorEncoded);
    }

    public function getTreatedError(?array $data): array
    {
        return [
            'data' => $data,
            'message' => 'validation_fail',
        ];
    }
}
