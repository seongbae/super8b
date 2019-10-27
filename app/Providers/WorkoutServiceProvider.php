<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\WorkoutService;
use App\Services\WorkoutServiceInterface;

class WorkoutServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->singleton(WorkoutService::class, function ($app) {
        //     return new WorkoutService();
        // });

        // $this->app->singleton(WorkoutService::class, function ($app) {
        //     return new WorkoutService($app);
        // });

   

        $this->app->bind(WorkoutServiceInterface::class, WorkoutService::class);

        //$this->app->bind('App\Service\WorkoutService');
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

        // View::composer(
        //     ‘profile’, ‘App\Http\ViewComposers\ProfileComposer’
        // );
    }
}
