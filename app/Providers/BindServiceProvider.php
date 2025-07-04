<?php

namespace App\Providers;

use App\Services\Subject\Contracts\iSubjectService;
use App\Services\Subject\SubjectService;
use Illuminate\Support\ServiceProvider;

class BindServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(iSubjectService::class, SubjectService::class);
    }
}
