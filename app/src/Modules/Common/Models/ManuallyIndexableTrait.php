<?php

declare(strict_types=1);

namespace Modules\Common\Models;

use Illuminate\Support\Collection;

trait ManuallyIndexableTrait
{
    protected string $scoutKeyName = 'id';

    protected array $indexArr = [];

    /**
     * Mainly used when you want to manually index a model. Use for write only.
     * If you want to change the read flow, check the ScoutBuilderMacros.
     *
     * The validation and anti-corruption should not go here. It should be done before data is come to repository.
     */
    public function mapIndexableData(
        array $attributes,
    ): static
    {
        $this->indexArr = $attributes;

        return $this;
    }

    public function getIndexableData(): array
    {
        return $this->indexArr;
    }

    public function getScoutKey()
    {
        return $this->getIndexableData()[$this->scoutKeyName];
    }

    public function bulkMapToModels(array $items): Collection
    {
        $arrayModels = [];

        foreach ($items as $item) {
            $model = new static();

            $model->mapIndexableData($item);

            $arrayModels[] = $model;
        }

        return $this->newCollection($arrayModels);
    }
}
