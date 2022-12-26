<?php

declare(strict_types=1);

namespace Modules\Common\Models;

use Illuminate\Support\Collection;
use JeroenG\Explorer\Application\Explored;

trait CollectForSearchTrait
{
    final public function newCollection(iterable $items): Collection
    {
        $models = [];

        foreach ($items as $item) {
            if (! $item instanceof Explored) {
                continue;
            }

            $models[] = $item;
        }

        $this->registerSearchableMacros();

        return new Collection($models);
    }
}
