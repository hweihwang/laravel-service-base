<?php

declare(strict_types=1);

namespace Modules\Common\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Common\Transports\API\Concerns\APIFoundationTrait;

abstract class AbstractException extends Exception
{
    use APIFoundationTrait;

    protected string $key;

    protected int $statusCode;

    protected string $responseMessage;

    public function __construct()
    {
        parent::__construct();
    }

    public function responseMessage(): string
    {
        return $this->responseMessage;
    }

    final public function render(): JsonResponse
    {
        return $this->error(
            __($this->responseMessage()),
            $this->key,
            $this->statusCode
        );
    }
}
