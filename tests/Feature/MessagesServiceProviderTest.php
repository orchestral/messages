<?php

namespace Orchestra\Messages\Tests\Feature;

class MessagesServiceProviderTest extends TestCase
{
    /** @test */
    public function it_can_register_expected_services()
    {
        $this->assertInstanceOf('\Orchestra\Messages\MessageBag', $this->app['orchestra.messages']);
    }
}
