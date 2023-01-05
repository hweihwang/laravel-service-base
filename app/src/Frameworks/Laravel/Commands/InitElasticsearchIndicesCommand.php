<?php

namespace Frameworks\Laravel\Commands;

use Illuminate\Console\Command;
use Laravel\Scout\Console\IndexCommand;

final class InitElasticsearchIndicesCommand extends Command
{
    protected $signature = 'init-elasticsearch-indices';

    public function handle(): void
    {
        $indices = config('explorer.indexes', []);

        foreach ($indices as $index) {
            $this->callSilently(IndexCommand::class, [
                'name' => $index,
            ]);
        }
    }
}
