<?php

namespace Modules\Common\Exceptions\Reporters;

use Throwable;

final class ExceptionReporter implements ReportableInterface
{
    public function report(Throwable $e): void
    {
        report($e);
    }
}
