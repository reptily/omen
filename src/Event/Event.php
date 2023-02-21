<?php

namespace Omen\Event;

use Omen\Debug\Log;
use Omen\OmenConst;
use Omen\Session;
use Omen\Trigger\Register as Trigger;
use Workerman\Connection\TcpConnection;

class Event
{
    /**
     * @param string $events
     * @param string $action
     */
    static public function onConnect(string $events, string $action): void
    {
        try {
            Register::setOnConnectEvent($events, $action);
        } catch (\Exception $e) {
            Log::Save($e->getMessage());
        }
    }

    /**
     * @param string $type
     * @param string $events
     * @param string $action
     */
    static public function onMessage(string $type, string $events, string $action): void
    {
        try {
            Register::setOnMessageEvent($type, $events, $action);
        } catch (\Exception $e) {
            Log::Save($e->getMessage());
        }
    }

    /**
     * @param string $events
     * @param string $action
     */
    static public function onDisconnect(string $events, string $action): void
    {
        try {
            Register::setOnDisconnectEvent($events, $action);
        } catch (\Exception $e) {
            Log::Save($e->getMessage());
        }
    }

    /**
     * @param array $obj
     * @param TcpConnection $connection
     * @param Session $session
     * @param mixed|null $data
     * @return string|null
     */
    static public function runEvent(array $obj, TcpConnection $connection, Session $session, $data = null): ?string
    {
        [$event, $action] = $obj;
        $event = OmenConst::NAMESPACE_EVENTS . $event;
        $response = null;
        $result = null;

        /** @var \Omen\Facade\Event $instance */
        if ($data === null) {
            $instance = new $event();
            $instance->setConnectionId($connection->id);
            $instance->setSession($session);
            $result = $instance->$action();
        } else {
            $instance = new $event($data);
            $instance->setConnectionId($connection->id);
            $instance->setSession($session);
            $result = $instance->$action($data);
        }


        if ($result instanceof DTO) {
            $response = Response::send($result);
        }

        if (!empty($instance->getTriggers())) {
            foreach ($instance->getTriggers() as $trigger) {
                Trigger::add($trigger, $connection);
            }
        }

        return $response;
    }
}
