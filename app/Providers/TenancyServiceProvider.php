<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Stancl\Tenancy\Events;
use Stancl\Tenancy\Jobs;
use Stancl\Tenancy\Listeners;
use Stancl\Tenancy\Middleware;

class TenancyServiceProvider extends ServiceProvider
{
    public function events()
    {
        return [
            Events\CreatingTenant::class => [],
            Events\TenantCreated::class => [
                Jobs\CreateDatabase::class,
                Jobs\MigrateDatabase::class,
            ],
            Events\SavingTenant::class => [],
            Events\TenantSaved::class => [],
            Events\UpdatingTenant::class => [],
            Events\TenantUpdated::class => [],
            Events\DeletingTenant::class => [],
            Events\TenantDeleted::class => [
                Jobs\DeleteDatabase::class,
            ],
        ];
    }

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->bootEvents();
        $this->mapTenantRoutes();
    }

    protected function bootEvents()
    {
        foreach ($this->events() as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }
    }

    protected function mapTenantRoutes()
    {
        if (file_exists(base_path('routes/tenant.php'))) {
            Route::middleware([
                'api',
                Middleware\InitializeTenancyByDomain::class,
                Middleware\PreventAccessFromCentralDomains::class,
            ])->group(base_path('routes/tenant.php'));
        }
    }
}
