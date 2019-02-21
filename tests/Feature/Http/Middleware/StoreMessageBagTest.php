<?php

namespace Orchestra\Messages\TestCase\Feature\Http\Middleware;

use Mockery as m;
use Illuminate\Http\Request;
use Orchestra\Testbench\TestCase;
use Orchestra\Support\Facades\Messages;
use Orchestra\Contracts\Messages\MessageBag;
use Illuminate\Contracts\Foundation\Application;
use Orchestra\Messages\Http\Middleware\StoreMessageBag;

class StoreMessageBagTest extends TestCase
{
    /** @test */
    public function it_handle_as_http_middleware()
    {
        $messages = m::mock(MessageBag::class);
        $request = m::mock(Request::class);

        $this->app->instance('orchestra.messages', $messages);
        $messages->shouldReceive('save')->once()->andReturnNull();

        $stub = new StoreMessageBag();

        $this->assertEquals('foo', $stub->handle($request, function ($request) {
            return 'foo';
        }));
    }
}
