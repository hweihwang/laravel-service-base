<?php

declare(strict_types=1);

namespace Modules\Common\Repositories;

use Modules\Common\Filters\FilterInterface;
use Modules\Common\Models\StateGettableInterface;

interface RepositoryInterface
{
    public function getById(int $id);

    public function getByIds(array $ids);

    public function search(string $search = '');

    public function filter(
        ?FilterInterface $filters,
        string $orderBy = 'id',
        string $direction = 'desc',
        array $columns = ['*'],
        string $search = ''
    );

    public function filterPaginated(
        ?FilterInterface $filters = null,
        int $perPage = 10,
        int $page = 1,
        ?string $orderBy = 'id',
        string $direction = 'desc',
        array $columns = ['*'],
        string $pageName = 'page',
        string $search = ''
    );

    public function setModel(StateGettableInterface $model);

    public function getModel(): StateGettableInterface;

    public function getModelClass();

    public function getModelShortClass();

//    public function destroy($model);
//
//    /**
//     * @param Carbon|null $from
//     * @param Carbon|null $to
//     * @param string $ts
//     * @param string[] $columns
//     * @param null $orderBy
//     * @param string $direction
//     */
//    public function getDateBetween(
//        Carbon $from = null,
//        Carbon $to = null,
//        string $ts = 'created_at',
//        array  $columns = ['*'],
//               $orderBy = null,
//        string $direction = 'asc'
//    );
//
//    /**
//     * @param Carbon|null $from
//     * @param Carbon|null $to
//     * @param string $ts
//     * @param int $rows
//     * @param null $orderBy
//     * @param string $direction
//     * @param string[] $columns
//     * @param string $pageName
//     */
//    public function getDateBetweenPaginated(
//        Carbon $from = null,
//        Carbon $to = null,
//        string $ts = 'created_at',
//        int    $rows = 15,
//               $orderBy = null,
//        string $direction = 'asc',
//        array  $columns = ['*'],
//        string $pageName = 'page'
//    );
}
