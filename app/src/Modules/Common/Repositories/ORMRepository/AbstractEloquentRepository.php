<?php

declare(strict_types=1);

namespace Modules\Common\Repositories\ORMRepository;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Common\Filters\FilterInterface;
use Modules\Common\Models\EloquentableInterface;
use Modules\Common\Models\StateGettableInterface;

abstract class AbstractEloquentRepository implements ORMRepositoryInterface
{
    protected Builder $query;

    /** @var EloquentableInterface */
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

    public function getById(int $id)
    {
        return $this->model->toEloquent()->find($id);
    }

    public function getAll(
        array $columns = ['*'],
        ?string $orderBy = 'id',
        string $direction = 'desc'
    ): array {
        return $this->applySort($orderBy, $direction)->get($columns)->all();
    }

    public function getAllPaginated(
        int $perPage = 10,
        int $page = 1,
        ?string $orderBy = 'id',
        string $direction = 'desc',
        array $columns = ['*'],
        string $pageName = 'page'
    ): LengthAwarePaginator {
        return $this->applySort($orderBy, $direction)->paginate($perPage, $columns, $pageName, $page);
    }

    public function add(array $attributes = [])
    {
        return $this->save($attributes);
    }

    public function update(array $attributes = [])
    {
        return $this->save($attributes);
    }

    public function destroy($model)
    {
        return $model->delete();
    }

    public function save($attributes, $model = null)
    {
        $model = is_null($model) ? new $this->model() : $model;

        $attributes = $this->onlyFillable($attributes, $model);

        $model->fill($attributes)->save();

        return $model;
    }

    public function firstOrCreate($attributes)
    {
        $attributes = $this->onlyFillable($attributes, $this->model);

        return $this->model::firstOrCreate($attributes);
    }

    public function getArrayForSelect(string $value = 'name', string $key = 'id', string $callback = 'ucwords'): array
    {
        $data = $this->getAll()
            ->pluck($value, $key)
            ->toArray();

        if (! is_null($callback)) {
            array_walk($data, function (&$item) use ($callback) {
                $item = call_user_func_array($callback, [$item]);
            });
        }

        return $data;
    }

    public function onlyFillable($attributes, $model): array
    {
        return array_filter($attributes, [$model, 'isFillable'], ARRAY_FILTER_USE_KEY);
    }

    public function search(string $search = '')
    {
        $query = $this->getModel()->where(function ($q) use ($search) {
            $fields = array_diff($this->getModel()->getFillable(), $this->getModel()->getHidden());

            $first = true;

            foreach ($fields as $field) {
                $q = $first ? $q->where($field, 'like', '%'.$search.'%') : $q->orWhere(
                    $field,
                    'like',
                    '%'.$search.'%'
                );

                $first = false;
            }
        });

        return $query->paginate();
    }

    public function deleteByIds(array $ids)
    {
        return $this->getModel()->whereIn('id', $ids)->delete();
    }

    public function getDateBetween(
        ?Carbon $from = null,
        ?Carbon $to = null,
        string $ts = 'created_at',
        array $columns = ['*'],
        ?string $orderBy = 'id',
        string $direction = 'desc'
    ): Collection|array {
        $from = is_null($from) ? Carbon::now()->subDay() : $from;

        $to = is_null($to) ? Carbon::now() : $to;

        return $this->applySort($orderBy, $direction)
            ->whereBetween($ts, [$from->toDateTimeString(), $to->toDateTimeString()])
            ->get($columns);
    }

    public function getDateBetweenPaginated(
        ?Carbon $from = null,
        ?Carbon $to = null,
        string $ts = 'created_at',
        int $perPage = 15,
        int $page = 1,
        ?string $orderBy = 'id',
        string $direction = 'desc',
        array $columns = ['*'],
        string $pageName = 'page'
    ): LengthAwarePaginator {
        $from = is_null($from) ? Carbon::now()
            ->subDay() : $from;

        $to = is_null($to) ? Carbon::now() : $to;

        return $this->applySort($orderBy, $direction)
            ->whereBetween($ts, [$from->toDateTimeString(), $to->toDateTimeString()])
            ->paginate($perPage, $columns, $pageName, $page);
    }

    public function sort(mixed &$query, string $orderBy = 'id', string $direction = 'desc'): void
    {
        if (! is_null($orderBy)) {
            $relationshipOrderBy = explode('.', $orderBy);

            $query = count($relationshipOrderBy) > 1 ?
                $query->select($this->model->getTable().'.*')
                    ->join(
                        $this->getRelatedTable($relationshipOrderBy),
                        $this->getRelatedForeignKey($relationshipOrderBy),
                        '=',
                        'related.id'
                    )
                    ->orderBy($this->getRelatedSortColumn($relationshipOrderBy), $direction) :
                $query->orderBy($orderBy, $direction);
        }
    }

    public function applySort($orderBy = null, $direction = null): Builder
    {
        $query = $this->model->newQuery();

        if (! is_null($orderBy)) {
            $this->sort($query, $orderBy, $direction);
        }

        return $query;
    }

    public function getRelation($relationshipOrderBy): string
    {
        return Str::snake(Arr::first($relationshipOrderBy));
    }

    public function getRelatedTable($relationshipOrderBy): string
    {
        return Str::plural($this->getRelation($relationshipOrderBy)).' as related';
    }

    public function getRelatedForeignKey($relationshipOrderBy): string
    {
        return $this->getModel()
                ->getTable().'.'.Str::singular($this->getRelation($relationshipOrderBy)).'_id';
    }

    public function getRelatedSortColumn($relationshipOrderBy): string
    {
        return 'related.'.Arr::last($relationshipOrderBy);
    }

    public function filter(
        mixed $filters,
        string $orderBy = 'id',
        string $direction = 'asc',
        array $columns = ['*'],
        string $search = ''
    ): Collection {
        return $this->buildFilteredQuery($filters, $orderBy, $direction, $search)->get($columns);
    }

    public function filterPaginated(
        ?FilterInterface $filters = null,
        int $perPage = 10,
        int $page = 1,
        ?string $orderBy = 'id',
        string $direction = 'desc',
        array $columns = ['*'],
        string $pageName = 'page',
        string $search = ''
    ): LengthAwarePaginator {
        return $this->buildFilteredQuery($filters, $orderBy, $direction, $search)->paginate(
            $perPage,
            $columns,
            $pageName,
            $page
        );
    }

    public function filterIsset($filters, $field): bool
    {
        return in_array($field, $this->getModelFilters(), true) &&
            ! is_null(Arr::get($filters, $field, null)) &&
            Arr::get($filters, $field, '') !== '';
    }

    public function setQuery($query): static
    {
        $this->query = $query;

        return $this;
    }

    public function getQuery(): Builder
    {
        return $this->query;
    }

    public function applyFilters($filters): void
    {
        foreach ($filters as $key => $value) {
            $this->{'filter'.Str::studly($key)}($value);
        }
    }

    public function getModelFilters(): array
    {
        return [];
//        return property_exists($this->model, 'filters') ? $this->model->filters : ['search'];
    }

    public function getTableColumns(): array
    {
        return $this->model
            ->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($this->model->getTable());
    }

    public function getSearchableTableColumns(): array
    {
        return array_diff($this->getTableColumns(), $this->model->getDates(), [$this->model->getKeyName()]);
    }

    public function buildFilteredQuery($filters, $orderBy, $direction, $search): Builder
    {
        $this->applyFilters($filters);

        $query = $this->query;

        $this->sort($this->query, $orderBy, $direction);

        return $query;
    }
}
