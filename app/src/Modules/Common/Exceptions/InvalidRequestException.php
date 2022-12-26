<?php

declare(strict_types=1);

namespace Modules\Common\Exceptions;

use JsonException;

final class InvalidRequestException extends AbstractException
{
    protected string $key = 'ERROR_INVALID_REQUEST';

    protected string $responseMessage = 'Request is invalid';

    protected int $statusCode = 422;

    protected array $errors = [];

    public function setErrors(array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @throws JsonException
     */
    public function responseMessage(): string
    {
        return json_encode($this->errors, JSON_THROW_ON_ERROR);
    }
}
