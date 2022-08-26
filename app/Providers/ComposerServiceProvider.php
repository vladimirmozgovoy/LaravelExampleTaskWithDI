<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Order;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('courier.panels.bottomNav', function ($view) {
            $courier_id = auth()->user()->id;
            $view->with([
                'footerOrderCount' => Order::where('courier_id', $courier_id)
                    ->where('order_state', 3)
                    ->count(),
                'footerReturnCount' => Order::where('order_state', 10)
                    ->orWhere('order_state', 11)
                    ->where('courier_id', $courier_id)
                    ->count(),
            ]);
        });

        view()->composer('collector.panels.bottomNav', function ($view) {
            $collector_id = auth()->user()->id;
            $view->with([
                'footerOrderCount' => Order::where('collector_id', $collector_id)
                    ->where('order_state', 1)
                    ->count(),
                'footerReturnCount' => Order::where('order_state', 12)
                    ->orWhere('order_state', 14)
                    ->where('collector_id', $collector_id)
                    ->count(),
            ]);
        });
    }
}
