<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Contracts\DeliveryRepositoryContract',
            'App\Repositories\DeliveryRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\ItemRepositoryContract',
            'App\Repositories\ItemRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\CartRepositoryContract',
            'App\Repositories\CartRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Models\Group::observe(\App\Observers\GroupObserver::class);
        \App\Models\Order::observe(\App\Observers\OrderObserver::class);
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Pivots\OrderUser::observe(\App\Observers\Pivots\OrderUserObserver::class);
    }
}
