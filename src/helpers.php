<?php

use Orchestra\Contracts\Messages\MessageBag;
use Orchestra\Support\Facades\Messages;

if (! \function_exists('messages')) {
    /**
     * Add a message to the bag.
     *
     * @param  string  $key
     * @param  string|callable  $message
     *
     * @return \Orchestra\Contracts\Messages\MessageBag
     */
    function messages(string $key, $message): MessageBag
    {
        return Messages::add($key, \value($message));
    }
}
