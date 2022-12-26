<?php

declare(strict_types=1);

namespace Modules\Common\Exceptions;

final class NotFoundEntityException extends AbstractEntityException
{
    protected string $key = 'ERR_NOT_FOUND_ENTITY';

    protected string $responseMessage = '%s not found';

    protected int $statusCode = 404;
}
