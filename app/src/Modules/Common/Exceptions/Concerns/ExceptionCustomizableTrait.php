<?php

declare(strict_types=1);

namespace Modules\Common\Exceptions\Concerns;

trait ExceptionCustomizableTrait
{
    public function setResponseMessage(string $responseMessage): static
    {
        $this->responseMessage = $responseMessage;

        return $this;
    }

    public function setLog(string $log): static
    {
        $this->log = $log;

        return $this;
    }

    public function setKey(string $key): static
    {
        $this->key = $key;

        return $this;
    }

    public function setStatusCode(int $statusCode): static
    {
        $this->statusCode = $statusCode;

        return $this;
    }
}
