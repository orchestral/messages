<?php

namespace Orchestra\Messages\TestCase\Unit\Http\Middleware;

use Mockery as m;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use Orchestra\Contracts\Messages\MessageBag;
use Illuminate\Contracts\Foundation\Application;
use Orchestra\Messages\Http\Middleware\StoreMessageBag;

class StoreMessageBagTest extends TestCase
{
    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function it_handle_as_http_middleware()
    {
        $app = m::mock(Application::class);
        $messages = m::mock(MessageBag::class);
        $request = m::mock(Request::class);

        $app->shouldReceive('make')->once()->with('orchestra.messages')->andReturn($messages);
        $messages->shouldReceive('save')->once()->andReturnNull();

        $stub = new StoreMessageBag($app);

        $this->assertEquals('foo', $stub->handle($request, function ($request) {
            return 'foo';
        }));
    }
}
