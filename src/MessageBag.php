<?php

namespace Orchestra\Messages;

use Closure;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\MessageBag as Message;
use Orchestra\Contracts\Messages\MessageBag as MessageBagContract;

class MessageBag extends Message implements MessageBagContract
{
    /**
     * The session store instance.
     *
     * @var \Illuminate\Contracts\Session\Session
     */
    protected $session;

    /**
     * Cached messages to be extends to current request.
     *
     * @var static
     */
    protected $instance;

    /**
     * Set the session store.
     *
     * @param  \Illuminate\Contracts\Session\Session  $session
     *
     * @return $this
     */
    public function setSessionStore(Session $session)
    {
        $this->session = $session;
        $this->instance = null;

        return $this;
    }

    /**
     * Get the session store.
     *
     * @return \Illuminate\Contracts\Session\Session
     */
    public function getSessionStore(): Session
    {
        return $this->session;
    }

    /**
     * Extend Messages instance from session.
     *
     * @param  \Closure  $callback
     *
     * @return static
     */
    public function extend(Closure $callback)
    {
        $instance = $this->retrieve();

        $callback($instance);

        return $instance;
    }

    /**
     * Retrieve Message instance from Session, the data should be in
     * serialize, so we need to unserialize it first.
     *
     * @return static
     */
    public function retrieve()
    {
        $messages = null;

        if (\is_null($this->instance)) {
            $this->instance = new static();
            $this->instance->setSessionStore($this->session);

            if ($this->session->has('message')) {
                $messages = \unserialize($this->session->pull('message'), ['allowed_classes' => false]);
            }

            if (\is_array($messages)) {
                $this->instance->merge($messages);
            }
        }

        return $this->instance;
    }

    /**
     * Store current instance.
     *
     * @return void
     */
    public function save(): void
    {
        $this->session->flash('message', $this->serialize());
        $this->instance = null;
    }

    /**
     * Compile the instance into serialize.
     *
     * @return string   serialize of this instance
     */
    public function serialize(): string
    {
        return \serialize($this->messages);
    }
}
