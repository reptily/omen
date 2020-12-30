<?php

/**
 * Singleton
 */

namespace Omen\Event;

use Omen\Debug\Colors;
use Omen\Debug\Console;
use Omen\OmenConst;

class Register
{
    /**
     *@var Register instance
     */
    private static $instance;

    /** @var null|array */
    protected static $onConnectEvent = null;

    /** @var null|array */
    protected static $onDisconnectEvent = null;

    /** @var array */
    protected static $onMessageEvent = [];

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
     * @param string $event
     * @return string|null
     */
    static private function normalizedEvent(string $event): ?string
    {
        return str_replace(OmenConst::NAMESPACE_EVENTS, '', $event);
    }

    /**
     * @param string $event
     * @param string $action
     * @return bool
     * @throws \Rdw\X\Autoload\AutoloadException
     */
    static private function checkEvent(string $event, string $action): bool
    {
        if (!class_exists(OmenConst::NAMESPACE_EVENTS . $event)) {
            Console::PrintLn('Class "' . OmenConst::NAMESPACE_EVENTS . $event . '" not exists', Colors::RED);
            return false;
        }

        if (!method_exists(OmenConst::NAMESPACE_EVENTS . $event, $action)) {
            Console::PrintLn('Method "' . OmenConst::NAMESPACE_EVENTS . $event . '::' . $action . '" not exists', Colors::RED);
            return false;
        }

        if(!OmenConst::NAMESPACE_EVENTS . $event instanceof DTO) {
            Console::PrintLn('Invalid method "' . OmenConst::NAMESPACE_EVENTS . $event . '::' . $action . '" type, need type Omen\Event\DTO', Colors::RED);
            return false;
        }

        return true;
    }

    /**
     * @param string $event
     * @param string $action
     * @return Register
     * @throws \Rdw\X\Autoload\AutoloadException
     */
    static public function setOnConnectEvent(string $event, string $action): Register
    {
        $event = self::normalizedEvent($event);

        if (!self::checkEvent($event, $action)) {
            return static::getInstance();
        }

        self::$onConnectEvent = [$event, $action];
        return static::getInstance();
    }

    /**
     * @return string|null
     */
    static public function getOnConnectEvent(): ?array
    {
        return self::$onConnectEvent;
    }

    /**
     * @param string $event
     * @param string $action
     * @return Register
     * @throws \Rdw\X\Autoload\AutoloadException
     */
    static public function setOnDisconnectEvent(string $event, string $action): Register
    {
        $event = self::normalizedEvent($event);

        if (!self::checkEvent($event, $action)) {
            return static::getInstance();
        }

        self::$onDisconnectEvent = [$event, $action];
        return static::getInstance();
    }

    /**
     * @return string|null
     */
    static public function getOnDisconnectEvent(): ?array
    {
        return self::$onDisconnectEvent;
    }

    /**
     * @param string $type
     * @param string $event
     * @param string $action
     * @return Register
     * @throws \Rdw\X\Autoload\AutoloadException
     */
    static public function setOnMessageEvent(string $type, string $event, string $action): Register
    {
        $event = self::normalizedEvent($event);

        if (!self::checkEvent($event, $action)) {
            return static::getInstance();
        }

        self::$onMessageEvent[$type] = [$event, $action];
        return static::getInstance();
    }

    /**
     * @param string $type
     * @return array|null
     */
    static public function getOnMessageEvent(string $type): ?array
    {
        return self::$onMessageEvent[$type] ?? null;
    }
}
