<?php namespace Orchestra\Messages\Http\Middleware\TestCase;

use Mockery as m;
use Illuminate\Http\Request;
use Orchestra\Contracts\Messages\MessageBag;
use Illuminate\Contracts\Foundation\Application;
use Orchestra\Messages\Http\Middleware\StoreMessageBag;

class StoreMessageBagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test Orchestra\Messages\Http\Middleware\StoreMessageBag::handle()
     * method.
     *
     * @test
     */
    public function testHandleMethod()
    {
        $app = m::mock(Application::class);
        $messages = m::mock(MessageBag::class);
        $request = m::mock(Request::class);

        $app->shouldReceive('make')->once()->with('orchestra.messages')->andReturn($messages);
        $messages->shouldReceive('save')->once()->andReturnNull();

        $next = function ($request) {
            return 'foo';
        };

        $stub = new StoreMessageBag($app);

        $this->assertEquals('foo', $stub->handle($request, $next));
    }
}

