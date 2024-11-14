<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Application\Services\GeoServerService;
use App\Infrastructure\Adapters\GeoServerClient;
use App\Domain\Repositories\ICategoryRepository;
use App\Domain\Repositories\ILayerRepository;
use App\Infrastructure\Repositories\EloquentCategoryRepository;
use App\Infrastructure\Repositories\EloquentLayerRepository;
use App\Domain\Repositories\ISubcategoryRepository;
use App\Infrastructure\Repositories\EloquentSubcategoryRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ICategoryRepository::class, EloquentCategoryRepository::class);
        $this->app->bind(ILayerRepository::class, EloquentLayerRepository::class);
        $this->app->bind(ISubcategoryRepository::class, EloquentSubcategoryRepository::class);
        $this->app->singleton(GeoServerService::class, function ($app) {
            return new GeoServerService($app->make(GeoServerClient::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
