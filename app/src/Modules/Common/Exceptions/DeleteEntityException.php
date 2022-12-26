<?php

declare(strict_types=1);

namespace Modules\Common\Exceptions;

final class DeleteEntityException extends AbstractEntityException
{
    protected string $key = 'ERROR_DELETE_ENTITY';

    protected string $responseMessage = 'Cannot delete %s';
}
