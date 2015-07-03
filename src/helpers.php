<?php

if (! function_exists('messages')) {
    /**
     * Add a message to the bag.
     *
     * @param  string  $key
     * @param  string  $message
     *
     * @return \Orchestra\Messages\MessageBag
     */
    function messages($key, $message)
    {
        return app('orchestra.messages')->add($key, value($message));
    }
}
