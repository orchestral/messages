<?php

if (! function_exists('messages')) {
    /**
     * Add a message to the bag.
     *
     * @param  string  $key
     * @param  string  $message
     * @return $this
     */
    function messages($key, $message)
    {
        app('orchestra.messages')->add($key, $message);
    }
}
