<?php

declare(strict_types=1);

namespace Modules\Common\Transports\API\FormRequests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Common\Exceptions\InvalidRequestException;
use Modules\Common\Transports\API\Concerns\APIFoundationTrait;

abstract class AbstractSymphonyFormRequest extends FormRequest
{
    use APIFoundationTrait;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @throws InvalidRequestException
     */
    public function failedValidation(Validator $validator): void
    {
        throw (new InvalidRequestException())->setErrors($validator->messages()->toArray());
    }
}
