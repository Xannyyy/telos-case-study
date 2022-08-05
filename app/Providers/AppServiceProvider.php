<?php

namespace App\Providers;

use App\Interfaces\Services\GraphServiceInterface;
use App\Services\GraphService;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Repositories\EventEntryRepositoryInterface;
use App\Repositories\EventEntryRepository;
use App\Interfaces\Services\UploadServiceInterface;
use App\Services\UploadService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EventEntryRepositoryInterface::class, EventEntryRepository::class);
        $this->app->bind(UploadServiceInterface::class, UploadService::class);
        $this->app->bind(GraphServiceInterface::class, GraphService::class);
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
