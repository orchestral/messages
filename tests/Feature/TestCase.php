<?php

namespace Orchestra\Messages\Tests\Feature;

use Orchestra\Testbench\TestCase as Testbench;

abstract class TestCase extends Testbench
{
    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getPackageAliases($app): array
    {
        return [
            'Messages' => \Orchestra\Support\Facades\Messages::class,
        ];
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getPackageProviders($app): array
    {
        return [
            \Orchestra\Messages\MessagesServiceProvider::class,
        ];
    }
}
