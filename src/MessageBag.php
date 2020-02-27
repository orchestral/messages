<?php

namespace Orchestra\Messages;

use Closure;
use Illuminate\Contracts\Session\Session as SessionContract;
use Illuminate\Contracts\Support\MessageBag as MessageContract;
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
     * Carbon copy for MessageBag.
     *
     * @var \Illuminate\Support\MessageBag
     */
    protected $messageBag;

    /**
     * Set the session store.
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
     */
    public function getSessionStore(): SessionContract
    {
        return $this->session;
    }

    /**
     * Extend Messages instance from session.
     */
    public function extend(Closure $callback): MessageContract
    {
        $messageBag = $this->copy();

        $callback($messageBag);

        return $messageBag;
    }

    /**
     * Retrieve Message instance from Session, the data should be in
     * serialize, so we need to unserialize it first.
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
     */
    public function save(): void
    {
        $this->session->flash('message', $this->messages());

        $this->messageBag = null;
    }
}
