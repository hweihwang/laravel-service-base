<?php

declare(strict_types=1);

namespace Modules\Common\DTOs;

use Modules\Common\ValueObjects\AbstractValueObject;

abstract class AbstractDetailDTO extends AbstractValueObject
{
    public function __construct(protected array $conditions = [])
    {
    }

    public function toArray(): array
    {
        return [
            'conditions' => $this->conditions,
        ];
    }
}
