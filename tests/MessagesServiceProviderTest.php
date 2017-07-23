<?php

namespace Orchestra\Messages\TestCase;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Orchestra\Messages\MessagesServiceProvider;

class MessagesServiceProviderTest extends TestCase
{
    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test Orchestra\Support\MessagesServiceProvider::register() method.
     *
     * @test
     */
    public function testRegisterMethod()
    {
        $app     = m::mock('\Illuminate\Container\Container');
        $session = m::mock('\Illuminate\Session\Store');

        $app->shouldReceive('singleton')->once()->with('orchestra.messages', m::type('Closure'))
                ->andReturnUsing(function ($n, $c) use ($app) {
                    $c($app);
                })
            ->shouldReceive('make')->once()->with('session.store')->andReturn($session);

        $stub = new MessagesServiceProvider($app);
        $this->assertNull($stub->register());
    }
}
