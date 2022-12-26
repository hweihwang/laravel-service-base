<?php

declare(strict_types=1);

namespace Frameworks\Laravel;

use Frameworks\Laravel\Commands\InitElasticsearchIndicesCommand;
use Frameworks\Laravel\Commands\SyncProductDataFromMysqlToElasticsearchCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel;

class ConsoleKernel extends Kernel
{
    protected $commands = [
        InitElasticsearchIndicesCommand::class,
    ];
    
    protected function schedule(Schedule $schedule): void
    {
    }
}
