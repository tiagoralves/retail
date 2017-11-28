<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }

        $this->app->bind('bootstrapper::form', function ($app) {
            $form = new Form( $app->make('collective::html'),
                                $app->make('url'),
                                $app->make('view'),
                                $app['session.store']->getToken(),
                                $app['session.store']->token() );

            return $form->setSessionStore($app['session.store']); },true);
    }
}
