<?php

declare(strict_types=1);

namespace Modules\Common\Filters;

use Modules\Common\ValueObjects\ArrayableInterface;

interface FilterInterface extends ArrayableInterface
{
    public function getFilterItems(): array;
}
