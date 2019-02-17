<?php

use Orchestra\Messages\MessageBag;

if (! \function_exists('messages')) {
    /**
     * Add a message to the bag.
     *
     * @param  string  $key
     * @param  string|callable  $message
     *
     * @return \Orchestra\Messages\MessageBag
     */
    function messages(string $key, $message): MessageBag
    {
        return \app('orchestra.messages')->add(
            $key, \value($message)
        );
    }
}
