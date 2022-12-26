<?php

declare(strict_types=1);

namespace Modules\Common\Services\Session;

interface TransactionalSessionInterface
{
    public function executeAtomically(callable $callback);
}
