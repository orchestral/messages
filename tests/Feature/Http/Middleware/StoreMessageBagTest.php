<?php

namespace Orchestra\Messages\Tests\Feature\Http\Middleware;

use Illuminate\Http\Request;
use Mockery as m;
use Orchestra\Contracts\Messages\MessageBag;
use Orchestra\Messages\Http\Middleware\StoreMessageBag;
use Orchestra\Testbench\TestCase;

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
