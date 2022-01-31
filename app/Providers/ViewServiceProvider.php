<?php

namespace App\Providers;

use App\Models\Group;
use App\Models\Order;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\ViewErrorBag;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('common.index.index', function($view){
            $currentGroup = $view->getData()['group']->id ?? 0;
            $group = new Group();
            $view->with([
                'currentGroup' => $group->findOrFirst($currentGroup)
            ]);
        });

        view()->composer('layouts.groups', function($view){
            $status = $view->getData()['status'] ?? 'actual';
            $group = new Group();
            $currentGroup = $view->getData()['currentGroup'] 
                ?? Group::findOrFirst($view->getData()['group']->id ?? 0);
            $view->with([
                'currentGroup' => $currentGroup,
                'groups' => $group->$status()->get()->keyBy('id')
            ]);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('route', function ($routes) {
            return is_array($routes)
                ? in_array(Route::currentRouteName(), $routes)
                : Route::currentRouteName() == $routes;
        });

        Blade::if('order', function ($order) {
            return is_a($order, Order::class);
        });

        Blade::if('ordercan', function ($order, string $action) {
            return is_a($order, Order::class) 
                && Gate::allows($action, Order::class);
        });

        Blade::directive('icon', function (string $classes = '') {
            $classes = str_replace(['\'', '\"'], '', $classes);
            return "<i class='fas fa-$classes'></i>";
        });

        Blade::directive('i', function (string $name) {
            $name = str_replace(['\'', '\"'], '', $name);
            return "fas fa-".$name;
        });
    }
}
