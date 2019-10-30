<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\WorkoutService;
use App\Services\WorkoutServiceInterface;
use Illuminate\View\View;

class WorkoutServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WorkoutServiceInterface::class, WorkoutService::class);

        // $this->app->singleton(WorkoutService::class, function ($app) {
        //     return new WorkoutService();
        // });

        // $this->app->singleton(WorkoutService::class, function ($app) {
        //     return new WorkoutService($app);
        // });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('view', function () {
            return 'hello world';
        });

        view()->composer(
            [
                'home', 
                'profile'
            ],
            'App\Http\View\Composers\ProfileComposer'
        );

        view()->share('name', 'Seong');

    }
}
