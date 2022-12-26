<?php

declare(strict_types=1);

namespace Frameworks\Laravel\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'Modules\Modules\Model' => 'Modules\Policies\ModelPolicy',
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
