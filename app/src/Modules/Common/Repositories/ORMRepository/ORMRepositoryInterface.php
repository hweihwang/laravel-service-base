<?php

declare(strict_types=1);

namespace Modules\Common\Repositories\ORMRepository;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Common\Repositories\RepositoryInterface;

interface ORMRepositoryInterface extends RepositoryInterface
{
    public function sort(mixed &$query, string $orderBy = 'id', string $direction = 'desc');

    public function onlyFillable($attributes, $model);

    public function save($attributes, $model = null);

    public function firstOrCreate($attributes);

    public function setQuery($query);

    public function getQuery();

    public function applySort($orderBy = null, $direction = null);

    public function deleteByIds(array $ids);

    public function getRelation($relationshipOrderBy);

    public function getRelatedTable($relationshipOrderBy);

    public function getRelatedForeignKey($relationshipOrderBy);

    public function getRelatedSortColumn($relationshipOrderBy);

    public function applyFilters($filters);

    public function getModelFilters(): array;

    public function getTableColumns();

    public function getSearchableTableColumns();

    public function buildFilteredQuery($filters, $orderBy, $direction, $search);

    public function getDateBetween(
        ?Carbon $from = null,
        ?Carbon $to = null,
        string $ts = 'created_at',
        array $columns = ['*'],
        ?string $orderBy = 'id',
        string $direction = 'desc'
    ): Collection|array;

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
    ): LengthAwarePaginator;

    public function add(array $attributes);

    public function update(array $attributes);

    public function getAll(
        array $columns = ['*'],
        ?string $orderBy = 'id',
        string $direction = 'desc'
    ): array;

    public function getAllPaginated(
        int $perPage = 10,
        int $page = 1,
        ?string $orderBy = 'id',
        string $direction = 'desc',
        array $columns = ['*'],
        string $pageName = 'page'
    );
}
