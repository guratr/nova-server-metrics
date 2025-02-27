<?php

namespace Llaski\NovaServerMetrics;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-server-metrics', __DIR__.'/../dist/js/card.js');
            Nova::style('nova-server-metrics', __DIR__.'/../dist/css/card.css');
        });
    }

    /**
     * Register the card's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Nova::router()
            ->group(function ($router) {
                $router->get('nova-server-metrics', function (Request $request) {
                    return inertia('NovaServerMetrics');
                });
            });

        Route::middleware(['nova'])
                ->prefix('nova-vendor/llaski/nova-server-metrics')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
