<?php

namespace Omen\Server;

use Omen\Event\Event;
use Omen\Event\Register;
use Omen\Session;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;

abstract class Decorator
{
    /**
     * Initialisation
     */
    public function Init(): void
    {
        $this->server = new Worker('websocket://' . Config::getWebSocket()->getHost(). ':' . Config::getWebSocket()->getPort());
        $this->server->count = 1;

        $this->server->onConnect = function ($connection) {
            $this->onConnect($connection);
        };

        $this->server->onMessage = function ($connection, $data) {
            $this->onMessage($connection, $data);
        };

        $this->server->onClose = function ($connection) {
            $this->onDisconnect($connection);
        };
    }

    /**
     * @param TcpConnection $connection
     */
    private function onConnect(TcpConnection $connection): void
    {
        $this->connections[$connection->id] = $connection;
        $session = Session::getInstance($connection->id);

        $onConnectEvent = Register::getOnConnectEvent();
        if ($onConnectEvent !== null) {
            $this->Send($connection, Event::runEvent($onConnectEvent, $connection, $session));
        }
    }

    /**
     * @param TcpConnection $connection
     * @param string|null $data
     */
    private function onMessage(TcpConnection $connection, ?string $data): void
    {
        $obj = $this->dataHandle($data);
        if ($obj === null) {
            return;
        }

        $session = Session::getInstance($connection->id);

        $onMessageEvent = Register::getOnMessageEvent($obj['type']);
        if ($onMessageEvent!== null) {
            $this->Send($connection, Event::runEvent($onMessageEvent, $connection, $session, $obj['message']));
        }
    }

    private function onDisconnect(TcpConnection $connection): void
    {
        $session = Session::getInstance($connection->id);

        $onConnectEvent = Register::getOnDisconnectEvent();
        if ($onConnectEvent !== null) {
            $this->Send($connection, Event::runEvent($onConnectEvent, $connection, $session));
        }
        \Omen\Trigger\Register::deleteConnection($connection->id);
    }

    /**
     *
     */
    public function Start(): void
    {
        Worker::runAll();
    }

    /**
     * @param int $to
     * @param string $text
     */
    public function Send(TcpConnection $to, string $text): void
    {
        if (isset($this->connections[$to->id])) {
            $this->connections[$to->id]->send($text);
        }
    }

    private function dataHandle($data): ?array
    {
        $obj = json_decode($data, true) ?? [];

        if (!isset($obj['type'])) {
            return null;
        }

        if (!isset($obj['message']) || !is_array($obj['message'])) {
            return null;
        }

        return $obj;
    }
}
