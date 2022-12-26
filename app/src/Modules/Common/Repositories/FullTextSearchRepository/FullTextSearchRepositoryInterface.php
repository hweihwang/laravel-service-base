<?php

declare(strict_types=1);

namespace Modules\Common\Repositories\FullTextSearchRepository;

use Illuminate\Support\Collection;
use Modules\Common\Repositories\RepositoryInterface;

interface FullTextSearchRepositoryInterface extends RepositoryInterface
{
    public const MAX_LIMIT = 10000;

    public function bulkAdd(Collection $models): void;

    public function bulkDestroy(Collection $models): void;

    public function getFirstByCondition(array $conditions): ?array;

    public function countAll(): int;
}
