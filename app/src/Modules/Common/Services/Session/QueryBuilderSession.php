<?php

declare(strict_types=1);

namespace Modules\Common\Services\Session;

use Illuminate\Support\Facades\DB;
use Throwable;

final class QueryBuilderSession implements TransactionalSessionInterface
{
    /**
     * @throws Throwable
     */
    public function executeAtomically(callable $callback)
    {
        return DB::transaction($callback);
    }
}
