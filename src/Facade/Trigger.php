<?php

namespace Omen\Facade;

use Omen\Session;

class Trigger
{
    /** @var Session */
    protected $session;

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }

    /**
     * @param Session $session
     * @return Trigger
     */
    public function setSession(Session $session): Trigger
    {
        $this->session = $session;
        return $this;
    }
}
