<?php

namespace App\Providers;

use App\Services\FileContentReader;
use Illuminate\Support\ServiceProvider;
use App\Repositories\UserJsonRepository;
use App\Repositories\EventJsonRepository;
use App\Contracts\FileContentReaderInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\EventRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserJsonRepository::class);
        $this->app->bind(FileContentReaderInterface::class, FileContentReader::class);
        $this->app->bind(EventRepositoryInterface::class, EventJsonRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
