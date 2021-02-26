<?php

/**
 * Singleton
 */

namespace Omen\Trigger;

use Workerman\Connection\TcpConnection;

class Register
{
    /**
     *@var Register instance
     */
    private static $instance;

    /** @var array */
    protected static $triggers = [];

    /**
     * @return Register|static
     */
    static public function getInstance(): Register
    {
        return static::$instance ?? (static::$instance = new static());
    }

    /**
     * construct denied
     */
    private function __construct()
    {
        //denied
    }

    /**
     * clone denied
     */
    private function __clone(){
        //denied
    }

    /**
     * wakeup denied
     */
    private function __wakeup(){
        //denied
    }

    /**
     * @param string $name
     * @param TcpConnection $connections
     * @return Register
     */
    static public function add(string $name, TcpConnection $connection): Register
    {
        self::$triggers[$name][$connection->id] = $connection;
        return self::getInstance();
    }

    /**
     * @return string[]|null
     */
    static public function getTriggers(): ?array
    {
        return self::$triggers;
    }

    /**
     * @param int $connectionId
     * @return Register
     */
    static public function deleteConnection(int $connectionId): Register
    {
        foreach (self::$triggers as $name => $trigger) {
            unset(self::$triggers[$name][$connectionId]);
        }

        return self::getInstance();
    }
}
