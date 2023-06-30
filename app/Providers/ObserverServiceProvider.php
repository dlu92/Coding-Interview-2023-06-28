<?php

namespace App\Providers;

use App\Models\Question;
use Illuminate\Support\ServiceProvider;
use App\Observers\QuestionObserver;

class ObserverServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Question::observe(QuestionObserver::class);
    }
}
