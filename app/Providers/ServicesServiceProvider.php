<?php

namespace App\Providers;

use App\Interfaces\Services\FileUploadServiceInterface;
use App\Services\FileUploadService;
use Carbon\Laravel\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(FileUploadServiceInterface::class, FileUploadService::class);
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
