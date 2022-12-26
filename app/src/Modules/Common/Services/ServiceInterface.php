<?php

declare(strict_types=1);

namespace Modules\Common\Services;

use Modules\Common\ValueObjects\AbstractValueObject;

interface ServiceInterface
{
    public function execute(AbstractValueObject $dto);
}
