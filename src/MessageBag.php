<?php

namespace Orchestra\Messages;

use Closure;
use Illuminate\Support\MessageBag as Message;
use Illuminate\Contracts\Session\Session as SessionContract;
use Illuminate\Contracts\Support\MessageBag as MessageContract;
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
     * Carbon copy for MessageBag.
     *
     * @var \Illuminate\Support\MessageBag
     */
    protected $messageBag;

    /**
     * Set the session store.
     *
     * @param  \Illuminate\Contracts\Session\Session  $session
     *
     * @return $this
     */
    public function setSessionStore(SessionContract $session)
    {
        $this->session = $session;

        $this->merge($this->session->pull('message', []));

        return $this;
    }

    /**
     * Get the session store.
     *
     * @return \Illuminate\Contracts\Session\Session
     */
    public function getSessionStore(): SessionContract
    {
        return $this->session;
    }

    /**
     * Extend Messages instance from session.
     *
     * @param  \Closure  $callback
     *
     * @return \Illuminate\Contracts\Support\MessageBag
     */
    public function extend(Closure $callback)
    {
        $messageBag = $this->retrieve();

        $callback($messageBag);

        return $messageBag;
    }

    /**
     * Retrieve Message instance from Session, the data should be in
     * serialize, so we need to unserialize it first.
     *
     * @return \Illuminate\Contracts\Support\MessageBag
     *
     * @deprecated v3.8.2
     * @see static::copy()
     */
    public function retrieve()
    {
        return $this->copy();
    }

    /**
     * Retrieve Message instance from Session, the data should be in
     * serialize, so we need to unserialize it first.
     *
     * @return \Illuminate\Contracts\Support\MessageBag
     */
    public function copy(): MessageContract
    {
        if (! $this->messageBag instanceof MessageContract) {
            $this->messageBag = new Message();
            $this->messageBag->merge($this->messages());
        }

        return $this->messageBag;
    }

    /**
     * Store current instance.
     *
     * @return void
     */
    public function save(): void
    {
        $this->session->flash('message', $this->messages());

        $this->messageBag = null;
    }

    /**
     * Compile the instance into serialize.
     *
     * @return string   serialize of this instance
     */
    public function serialize(): string
    {
        return $this->toJson();
    }
}
