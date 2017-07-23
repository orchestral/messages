<?php

namespace Orchestra\Messages\TestCase;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Orchestra\Messages\MessageBag;

class MessageBagTest extends TestCase
{
    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test Orchestra\Support\MessageBag::make() method.
     *
     * @test
     */
    public function testMakeMethod()
    {
        $session = m::mock('\Illuminate\Session\Store');

        $message = (new MessageBag())->setSessionStore($session);
        $message->add('welcome', 'Hello world');
        $message->setFormat();

        $this->assertInstanceOf('\Orchestra\Messages\MessageBag', $message);
        $this->assertEquals(['Hello world'], $message->get('welcome'));

        $message->add('welcome', 'Hi Foobar')->add('welcome', 'Heya Admin');
        $this->assertEquals(['Hello world', 'Hi Foobar', 'Heya Admin'], $message->get('welcome'));

        $this->assertEquals($session, $message->getSessionStore());
    }

    /**
     * Test Orchestra\Messages\MessageBag::save() method.
     *
     * @test
     */
    public function testSaveMethod()
    {
        $session = m::mock('\Illuminate\Session\Store');
        $session->shouldReceive('flash')->once()->andReturn(true);

        with(new MessageBag())->setSessionStore($session)->save();
    }

    /**
     * Test serializing and storing Orchestra\Messages\MessageBag over
     * Session.
     *
     * @test
     */
    public function testStoreMethod()
    {
        $session = m::mock('\Illuminate\Session\Store');

        $session->shouldReceive('flash')->once()->andReturn(true);

        $message = (new MessageBag())->setSessionStore($session);
        $message->add('hello', 'Hi World');
        $message->add('bye', 'Goodbye');

        $serialize = $message->serialize();

        $this->assertTrue(is_string($serialize));
        $this->assertContains('hello', $serialize);
        $this->assertContains('Hi World', $serialize);
        $this->assertContains('bye', $serialize);
        $this->assertContains('Goodbye', $serialize);

        $message->save();
    }

    /**
     * Test un-serializing and retrieving Orchestra\Messages\MessageBag over
     * Session.
     *
     * @test
     */
    public function testRetrieveMethod()
    {
        $session = m::mock('\Illuminate\Session\Store');
        $session->shouldReceive('has')->once()->andReturn(true)
            ->shouldReceive('pull')->once()
                ->andReturn('a:2:{s:5:"hello";a:1:{i:0;s:8:"Hi World";}s:3:"bye";a:1:{i:0;s:7:"Goodbye";}}');

        $retrieve = (new MessageBag())->setSessionStore($session)->retrieve();
        $retrieve->setFormat();

        $this->assertInstanceOf('\Orchestra\Messages\MessageBag', $retrieve);
        $this->assertEquals(['Hi World'], $retrieve->get('hello'));
        $this->assertEquals(['Goodbye'], $retrieve->get('bye'));
    }

    /**
     * Test un-serializing and extending Orchestra\Messages\MessageBag over
     * Session.
     *
     * @test
     */
    public function testExtendMethod()
    {
        $session = m::mock('\Illuminate\Session\Store');
        $session->shouldReceive('has')->once()->andReturn(true)
            ->shouldReceive('pull')->once()
                ->andReturn('a:1:{s:5:"hello";a:1:{i:0;s:8:"Hi World";}}');

        $callback = function ($msg) {
            $msg->add('hello', 'Hi Orchestra Platform');
        };

        $stub   = (new MessageBag())->setSessionStore($session);
        $output = $stub->extend($callback);

        $retrieve = $stub->retrieve();
        $retrieve->setFormat();

        $this->assertInstanceOf('\Orchestra\Messages\MessageBag', $output);
        $this->assertInstanceOf('\Orchestra\Messages\MessageBag', $retrieve);
        $this->assertEquals(['Hi World', 'Hi Orchestra Platform'], $retrieve->get('hello'));
    }
}
