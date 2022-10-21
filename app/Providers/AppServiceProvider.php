<?php

namespace App\Providers;

use App\Repositories\BaseRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\BaseRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;

use App\Services\BaseServiceInterface;
use App\Services\BaseService;
use App\Services\UserService;
use App\Services\CategoryService;
use App\Services\ProductService;

use Illuminate\Pagination\Paginator;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BaseRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->singleton(BaseRepositoryInterface::class, CategoryRepository::class);
        $this->app->singleton(BaseRepositoryInterface::class, ProductRepository::class);
        $this->app->singleton(BaseServiceInterface::class, BaseService::class);
        $this->app->singleton(BaseServiceInterface::class, UserService::class);
        $this->app->singleton(BaseServiceInterface::class, CategoryService::class);
        $this->app->singleton(BaseServiceInterface::class, ProductService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}