<?php

declare(strict_types=1);

namespace Modules\Common\Repositories\FullTextSearchRepository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Laravel\Scout\Builder;
use Modules\Common\Filters\AbstractElasticSearchFilter;
use Modules\Common\Filters\FilterInterface;
use Modules\Common\Mixins\ScoutBuilderMacrosInterface;
use Modules\Common\Models\StateGettableInterface;

abstract class AbstractElasticsearchRepository implements FullTextSearchRepositoryInterface
{
    protected StateGettableInterface $model;

    public function setModel(StateGettableInterface $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getModel(): StateGettableInterface
    {
        return $this->model;
    }

    public function getModelClass(): string
    {
        return get_class($this->model);
    }

    public function getModelShortClass(): string
    {
        return class_basename($this->getModelClass());
    }

    //Be careful with these methods, it can be very slow
    public function getByIds(array $ids): Collection
    {
        return $this->model::search()
            ->whereIns('id', $ids)
            ->take(self::MAX_LIMIT)
            ->getData();
    }

    public function search(string $search = ''): Collection
    {
        return $this->model::search($search)
            ->take(self::MAX_LIMIT)
            ->getData();
    }

    public function filter(
        ?FilterInterface $filters = null,
        string $orderBy = 'id',
        string $direction = 'desc',
        array $columns = ['*'],
        string $search = ''
    ): Collection {
        $builder = $this->model::search($search);

        if ($filters instanceof AbstractElasticSearchFilter) {
            $builder->applyFilters($filters);
        }

        return $builder
            ->orderBy($orderBy, $direction)
            ->take(self::MAX_LIMIT)
            ->getData($columns);
    }

    public function countAll(): int
    {
        return $this->model::search()->raw()->count();
    }

    public function getById(int $id): ?array
    {
        return $this->model::search()
            ->where('id', $id)
            ->take(1)
            ->getData()
            ->first();
    }

    public function getFirstByCondition(array $conditions): ?array
    {
        $builder = $this->model::search();

        $builder->wheres = array_merge($builder->wheres, $conditions);

        return $builder
            ->take(1)
            ->getData()
            ->first();
    }

    public function filterPaginated(
        ?FilterInterface $filters = null,
        int $perPage = 10,
        int $page = 1,
        ?string $orderBy = 'id',
        string $direction = 'desc',
        array $columns = ['*'],
        string $pageName = 'page',
        string $search = '',
    ): LengthAwarePaginator {
        /** @var ScoutBuilderMacrosInterface|Builder $builder */
        $builder = $this->model::search($search);

        if ($filters instanceof AbstractElasticSearchFilter) {
            $builder->applyFilters($filters);
        }

        if ($orderBy) {
            $builder->orderBy($orderBy, $direction);
        }

        return $builder->paginateData($perPage, $pageName, $page);
    }

    public function add(StateGettableInterface $model): void
    {
        $model->searchable();
    }

    public function bulkAdd(Collection $models): void
    {
        $models = $this->model->newCollection($models);
        $models->searchable();
    }

    public function destroy(StateGettableInterface $model): void
    {
        $model->unsearchable();
    }

    public function bulkDestroy(Collection $models): void
    {
        $models = $this->model->newCollection($models);

        $models->unsearchable();
    }
}
