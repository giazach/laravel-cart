<?php

namespace Berkayk\LaravelCart;

use Illuminate\Support\ServiceProvider;
use Berkayk\LaravelCart\Core\Cart;
use Berkayk\LaravelCart\Contracts\CartDriver;
use Berkayk\LaravelCart\Observers\CartObserver;
use Berkayk\LaravelCart\Models\Cart as CartModel;
use Berkayk\LaravelCart\Console\Commands\ClearCartDataCommand;

class CartManagerServiceProvider extends ServiceProvider
{
    /**
     * Publishes configuration file and registers error handler for Slack notification.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/cart_manager.php' => config_path('cart_manager.php'),
            ], 'laravel-cart-manager-config');

            $this->publishes([
                __DIR__ . '/../database/migrations/' => database_path('migrations'),
            ], 'laravel-cart-manager-migrations');

            $this->commands([ClearCartDataCommand::class]);
        }

        CartModel::observe(CartObserver::class);
    }

    /**
     * Service container bindings.
     *
     * @return void
     */
    public function register()
    {
        // Users can specify only the options they actually want to override
        $this->mergeConfigFrom(
            __DIR__ . '/../config/cart_manager.php', 'cart_manager'
        );

        // Bind the driver with contract
        $this->app->bind(CartDriver::class, $this->app['config']['cart_manager']['driver']);

        // Bind the cart class
        $this->app->bind(Cart::class, function ($app) {
            return new Cart($app->make(CartDriver::class));
        });
    }
}
