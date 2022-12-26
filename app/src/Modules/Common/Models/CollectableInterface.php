<?php

declare(strict_types=1);

namespace Modules\Common\Models;

use Illuminate\Support\Collection;

interface CollectableInterface
{
    public function newCollection(iterable $items): Collection;
}
