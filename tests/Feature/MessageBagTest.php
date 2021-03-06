<?php

namespace Orchestra\Messages\Tests\Feature;

use Mockery as m;
use Orchestra\Support\Facades\Messages;

class MessageBagTest extends TestCase
{
    /** @test */
    public function it_can_make_a_message_instance()
    {
        Messages::add('welcome', 'Hello world');
        Messages::setFormat();

        $this->assertInstanceOf('Orchestra\Messages\MessageBag', $this->app['orchestra.messages']);
        $this->assertEquals(['Hello world'], Messages::get('welcome'));

        Messages::add('welcome', 'Hi Foobar')
            ->add('welcome', 'Heya Admin');

        $this->assertEquals(['Hello world', 'Hi Foobar', 'Heya Admin'], Messages::get('welcome'));
    }

    /** @test */
    public function it_can_flash_empty_message_to_session()
    {
        $session = m::mock('\Illuminate\Session\Store');
        $session->shouldReceive('pull')->once()->with('message', [])->andReturn([])
            ->shouldReceive('flash')->once()->andReturn(true);

        $this->assertNull(Messages::setSessionStore($session)->save());
        $this->assertSame($session, Messages::getSessionStore());
    }

    /** @test */
    public function it_can_store_messages_to_session()
    {
        $session = m::mock('\Illuminate\Session\Store');
        $session->shouldReceive('pull')->once()->with('message', [])->andReturn([])
            ->shouldReceive('flash')->once()->andReturn(true);

        Messages::setSessionStore($session);
        Messages::add('hello', 'Hi World')
                ->add('bye', 'Goodbye');

        $this->assertSame($session, Messages::getSessionStore());

        Messages::save();
    }

    /** @test */
    public function it_can_copy_message_from_session()
    {
        $session = m::mock('\Illuminate\Session\Store');
        $session->shouldReceive('pull')->once()->with('message', [])
                ->andReturn(['hello' => ['Hi World'], 'bye' => ['Goodbye']]);

        $clone = Messages::setSessionStore($session)->copy();
        $clone->setFormat();

        $this->assertSame($session, Messages::getSessionStore());
        $this->assertInstanceOf('Illuminate\Support\MessageBag', $clone);
        $this->assertEquals(['Hi World'], $clone->get('hello'));
        $this->assertEquals(['Goodbye'], $clone->get('bye'));
    }

    /** @test */
    public function it_can_extend_messages_to_current_request()
    {
        $session = m::mock('\Illuminate\Session\Store');
        $session->shouldReceive('pull')->once()->with('message', [])->andReturn(['hello' => ['Hi World']]);

        $callback = function ($msg) {
            $msg->add('hello', 'Hi Orchestra Platform');
        };

        $stub = Messages::setSessionStore($session);
        $output = $stub->extend($callback);

        $clone = $stub->copy();
        $clone->setFormat();

        $this->assertSame($session, Messages::getSessionStore());
        $this->assertInstanceOf('Illuminate\Support\MessageBag', $output);
        $this->assertInstanceOf('Illuminate\Support\MessageBag', $clone);
        $this->assertEquals(['Hi World', 'Hi Orchestra Platform'], $clone->get('hello'));
    }
}
