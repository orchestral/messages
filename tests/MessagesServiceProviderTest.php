<?php namespace Orchestra\Messages\TestCase;

use Mockery as m;
use Orchestra\Messages\MessagesServiceProvider;

class MessagesServiceProviderTest extends \PHPUnit_Framework_TestCase
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
        $app = m::mock('\Illuminate\Container\Container');
        $session = m::mock('\Illuminate\Session\Store');

        $app->shouldReceive('bindShared')->once()->with('orchestra.messages', m::type('Closure'))
                ->andReturnUsing(function ($n, $c) use ($app) {
                    $c($app);
                })
            ->shouldReceive('offsetGet')->once()->with('session.store')->andReturn($session);

        $stub = new MessagesServiceProvider($app);
        $this->assertNull($stub->register());
    }

    /**
     * Test Orchestra\Support\MessagesServiceProvider::boot() method.
     *
     * @test
     */
    public function testBootMethod()
    {
        $app = [
            'router' => $router = m::mock('\Illuminate\Routing\Router'),
            'orchestra.messages' => $messages = m::mock('\Orchestra\Message\MessageBag'),
        ];

        $router->shouldReceive('after')->once()->with(m::type('Closure'))
                ->andReturnUsing(function ($c) {
                    $c();
                });
        $messages->shouldReceive('save')->once();

        $stub = new MessagesServiceProvider($app);
        $this->assertNull($stub->boot());
    }
}
