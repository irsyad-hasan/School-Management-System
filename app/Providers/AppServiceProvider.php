<?php

namespace App\Providers;

use App\Models\SchoolClass;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use App\Observers\ActivityObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $models = [User::class, Student::class, Teacher::class, SchoolClass::class, Subject::class, Schedule::class];

        foreach ($models as $model) {
            $model::observe(ActivityObserver::class);
        }
    }
}
