<?php

use Orchestra\Contracts\Messages\MessageBag;
use Orchestra\Support\Facades\Messages;

if (! \function_exists('messages')) {
    /**
     * Add a message to the bag.
     *
     * @param  string|callable  $message
     */
    function messages(string $key, $message): MessageBag
    {
        return Messages::add($key, \value($message));
    }
}
