<?php

declare(strict_types=1);

namespace Modules\Common\Models;

interface EloquentableInterface
{
    public function getTable(): string;

    public function toEloquent(): EloquentModel;
}
