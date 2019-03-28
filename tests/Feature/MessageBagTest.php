<?php

namespace Orchestra\Messages\TestCase\Feature;

use Mockery as m;
use Orchestra\Support\Facades\Messages;

class MessageBagTest extends TestCase
{
    /** @test */
    public function it_can_make_a_message_instance()
    {
        Messages::add('welcome', 'Hello world');
        Messages::setFormat();

        $this->assertInstanceOf('\Orchestra\Messages\MessageBag', $this->app['orchestra.messages']);
        $this->assertEquals(['Hello world'], Messages::get('welcome'));

        Messages::add('welcome', 'Hi Foobar')
            ->add('welcome', 'Heya Admin');

        $this->assertEquals(['Hello world', 'Hi Foobar', 'Heya Admin'], Messages::get('welcome'));
    }

    /** @test */
    public function it_can_flash_empty_message_to_session()
    {
        $session = m::mock('\Illuminate\Session\Store');
        $session->shouldReceive('flash')->once()->andReturn(true);

        $this->assertNull(Messages::setSessionStore($session)->save());
        $this->assertSame($session, Messages::getSessionStore());
    }

    /** @test */
    public function it_can_store_messages_to_session()
    {
        $session = m::mock('\Illuminate\Session\Store');

        $session->shouldReceive('flash')->once()->andReturn(true);

        Messages::setSessionStore($session);
        Messages::add('hello', 'Hi World')
                ->add('bye', 'Goodbye');

        $serialize = Messages::serialize();

        $this->assertTrue(is_string($serialize));
        $this->assertStringContainsString('hello', $serialize);
        $this->assertStringContainsString('Hi World', $serialize);
        $this->assertStringContainsString('bye', $serialize);
        $this->assertStringContainsString('Goodbye', $serialize);
        $this->assertSame($session, Messages::getSessionStore());

        Messages::save();
    }

    /** @test */
    public function it_can_retrieve_message_from_session()
    {
        $session = m::mock('\Illuminate\Session\Store');
        $session->shouldReceive('has')->once()->andReturn(true)
            ->shouldReceive('pull')->once()
                ->andReturn('a:2:{s:5:"hello";a:1:{i:0;s:8:"Hi World";}s:3:"bye";a:1:{i:0;s:7:"Goodbye";}}');

        $retrieve = Messages::setSessionStore($session)->retrieve();
        $retrieve->setFormat();

        $this->assertSame($session, Messages::getSessionStore());
        $this->assertInstanceOf('\Orchestra\Messages\MessageBag', $retrieve);
        $this->assertEquals(['Hi World'], $retrieve->get('hello'));
        $this->assertEquals(['Goodbye'], $retrieve->get('bye'));
    }

    /** @test */
    public function it_can_extend_messages_to_current_request()
    {
        $session = m::mock('\Illuminate\Session\Store');
        $session->shouldReceive('has')->once()->andReturn(true)
            ->shouldReceive('pull')->once()
                ->andReturn('a:1:{s:5:"hello";a:1:{i:0;s:8:"Hi World";}}');

        $callback = function ($msg) {
            $msg->add('hello', 'Hi Orchestra Platform');
        };

        $stub = Messages::setSessionStore($session);
        $output = $stub->extend($callback);

        $retrieve = $stub->retrieve();
        $retrieve->setFormat();

        $this->assertSame($session, Messages::getSessionStore());
        $this->assertInstanceOf('\Orchestra\Messages\MessageBag', $output);
        $this->assertInstanceOf('\Orchestra\Messages\MessageBag', $retrieve);
        $this->assertEquals(['Hi World', 'Hi Orchestra Platform'], $retrieve->get('hello'));
    }
}
