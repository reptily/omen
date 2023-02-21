<?php

namespace Omen\Trigger;

use Omen\OmenConst;
use Omen\Server\Message;
use Omen\Session;

class Trigger
{
    /**
     * @param Session $session
     */
    static public function runTriggers(Session $session)
    {
        $triggers = Register::getTriggers();
        if (!empty($triggers)) {
            foreach ($triggers as $nameTrigger => $connections) {
                $nameTrigger = OmenConst::NAMESPACE_TRIGGERS . $nameTrigger;
                /** @var \Omen\Facade\Trigger $initTrigger */
                $initTrigger = new $nameTrigger();
                $initTrigger->setSession($session);
                $initTrigger->handler(new Message($connections));
            }
        }
    }
}
