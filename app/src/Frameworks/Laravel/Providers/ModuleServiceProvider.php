<?php

declare(strict_types=1);

namespace Frameworks\Laravel\Providers;

use Frameworks\Laravel\Providers\Modules\Product\ProductServiceProvider;
use Frameworks\Laravel\Providers\Modules\ProductOption\ProductOptionServiceProvider;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    private array $modules = [];

    public function register(): void
    {
        foreach ($this->modules as $module) {
            $this->app->register($module);
        }
    }
}
