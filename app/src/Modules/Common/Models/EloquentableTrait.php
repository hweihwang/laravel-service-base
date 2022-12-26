<?php

namespace Modules\Common\Models;

trait EloquentableTrait
{
    public function getTable(): string
    {
        return class_basename(static::class);
    }

    public function toEloquent(): EloquentModel
    {
        $model = new EloquentModel();

        $model->setTable($this->getTable());

        return $model;
    }
}
