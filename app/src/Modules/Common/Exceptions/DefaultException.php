<?php

declare(strict_types=1);

namespace Modules\Common\Exceptions;

use Modules\Common\Exceptions\Concerns\ExceptionCustomizableTrait;

final class DefaultException extends AbstractException
{
    use ExceptionCustomizableTrait;

    protected string $key = 'ERROR_INTERNAL';

    protected int $statusCode = 500;

    protected string $responseMessage = 'An unexpected error occurred';

    public function __construct(string $responseMessage = '')
    {
        parent::__construct();

        if ('' !== $responseMessage) {
            $this->responseMessage = $responseMessage;
        }
    }
}
