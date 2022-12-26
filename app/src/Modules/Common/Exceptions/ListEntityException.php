<?php

declare(strict_types=1);

namespace Modules\Common\Exceptions;

final class ListEntityException extends AbstractEntityException
{
    protected string $key = 'ERROR_LIST_ENTITY';

    protected string $responseMessage = 'Cannot list %s';
}
