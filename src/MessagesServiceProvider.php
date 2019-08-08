<?php

namespace Orchestra\Messages;

use Orchestra\Support\Providers\MiddlewareServiceProvider;

class MessagesServiceProvider extends MiddlewareServiceProvider
{
    /**
     * The application's middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        Http\Middleware\StoreMessageBag::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('orchestra.messages', static function ($app) {
            return \tap(new MessageBag(), static function ($messageBag) use ($app) {
                $messageBag->setSessionStore($app->make('session.store'));
            });
        });
    }
}
