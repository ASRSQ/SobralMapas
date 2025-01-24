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
use App\Infrastructure\Adapters\ChatbotAdapter;
use App\Application\Services\ChatbotService;
use App\Infrastructure\Adapters\WmsAdapter;
use App\Application\Services\WmsService;
use App\Domain\Repositories\IUserRepository;
use App\Infrastructure\Repositories\EloquentUserRepository;
use App\Domain\Repositories\IProfileRepository;
use App\Infrastructure\Repositories\EloquentProfileRepository;



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
        $this->app->bind(ILayerRepository::class, EloquentLayerRepository::class);
        $this->app->singleton(GeoServerService::class, function ($app) {
            return new GeoServerService($app->make(GeoServerClient::class));
        });
        $this->app->singleton(ChatbotService::class, function ($app) {
            return new ChatbotService($app->make(ChatbotAdapter::class));
        });
        $this->app->singleton(WmsService::class, function ($app) {
            return new WmsService($app->make(WmsAdapter::class));
        });
        $this->app->bind(IUserRepository::class, EloquentUserRepository::class);
        $this->app->bind(IProfileRepository::class, EloquentProfileRepository::class);
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
