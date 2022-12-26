<?php

namespace Modules\Common\Exceptions\Reporters;

use Throwable;

interface ReportableInterface
{
    public function report(Throwable $e): void;
}
