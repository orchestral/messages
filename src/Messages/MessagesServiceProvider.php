<?php namespace Orchestra\Messages;

use Illuminate\Support\ServiceProvider;

class MessagesServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('orchestra.messages', function ($app) {
            return (new MessageBag)->setSessionStore($app['session.store']);
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $app = $this->app;

        $app->after(function () use ($app) {
            $app['orchestra.messages']->save();
        });
    }
}
