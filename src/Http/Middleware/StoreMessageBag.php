<?php

namespace Orchestra\Messages\Http\Middleware;

use Closure;
use Orchestra\Support\Facades\Messages;

class StoreMessageBag
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return \tap($next($request), static function () {
            Messages::save();
        });
    }
}
