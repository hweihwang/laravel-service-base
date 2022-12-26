<?php

declare(strict_types=1);

namespace Frameworks\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Scout\Builder;
use Modules\Common\Mixins\ScoutBuilderMacros;
use Modules\Common\Mixins\ScoutBuilderMacrosInterface;

class ScoutServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ScoutBuilderMacrosInterface::class, ScoutBuilderMacros::class);
        $this->app->singleton('ScoutBuilderMacros', ScoutBuilderMacros::class);

        Builder::mixin($this->app->make('ScoutBuilderMacros'));
    }
}
