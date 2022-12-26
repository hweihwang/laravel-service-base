<?php

declare(strict_types=1);

namespace Modules\Common\Exceptions;

abstract class AbstractEntityException extends AbstractException
{
    protected int $statusCode = 400;

    protected string $entity = '';

    public function __construct(string $entity = '')
    {
        parent::__construct();

        if ('' !== $entity) {
            $this->entity = $entity;
        }
    }

    public function responseMessage(): string
    {
        return sprintf($this->responseMessage, $this->entity);
    }
}
