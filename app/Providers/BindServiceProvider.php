<?php

namespace App\Providers;

use App\Services\QuestionType\Contracts\iQuestionTypeService;
use App\Services\QuestionType\QuestionTypeService;
use App\Services\Subject\Contracts\iSubjectService;
use App\Services\Topic\Contracts\iTopicService;
use App\Services\Subject\SubjectService;
use Illuminate\Support\ServiceProvider;
use App\Services\Topic\TopicService;

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
        $this->app->bind(iQuestionTypeService::class, QuestionTypeService::class);
        $this->app->bind(iSubjectService::class, SubjectService::class);
        $this->app->bind(iTopicService::class, TopicService::class);
    }
}
