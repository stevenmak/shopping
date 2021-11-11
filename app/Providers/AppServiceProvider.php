<?php

namespace App\Providers;

use App\Models\Shop;
use Darryldecode\Cart\Cart;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        View::composer(['layouts.app', 'products.show'], function ($view) {
            $view->with(['cartCount' => \Cart::getTotalQuantity(), 'cartTotal' => \Cart::getTotal(),]);
        });

        Route::resourceVerbs([
            'edit' => 'modification',
            'create' => 'creation',
        ]);

        View::share('shop', Shop::firstOrFail());
    }
}
