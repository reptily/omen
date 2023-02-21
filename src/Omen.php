<?php
/**
 * Singleton
 */

namespace Omen;

use Omen\Debug\Colors;
use Omen\Debug\Console;

class Omen implements OmenConst
{
    /** @var array  */
    protected static $memory = [];

    /**
     *@var Omen instance
     */
    private static $instance;

    /** @var null|array */
    protected static $onConnectEvent = null;

    /**
     * @return Omen|static
     */
    static public function getInstance(): Omen
    {
        return static::$instance ?? (static::$instance = new static());
    }

    /**
     * construct denied
     */
    public function __construct()
    {
        //denied
    }

    /**
     * clone denied
     */
    public function __clone(){
        //denied
    }

    /**
     * wakeup denied
     */
    public function __wakeup(){
        //denied
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param string|null $index
     * @return Omen
     */
    static public function set(string $key, $value, ?string $index = null): Omen
    {
        if ($index !== null) {
            self::$memory[$key][$index] = $value;
        } else {
            self::$memory[$key] = $value;
        }

        return static::getInstance();
    }

    /**
     * @param string $key
     * @param string|null $index
     * @return mixed|null
     */
    static public function get(string $key, ?string $index = null)
    {
        if ($index !== null) {
            return self::$memory[$key][$index] ?? null;
        }
        return self::$memory[$key] ?? null;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return Omen
     */
    static public function append(string $key, $value): Omen
    {
        if (!isset(self::$memory[$key])) {
            self::$memory[$key] = [];
        }

        if (!is_array(self::$memory[$key])) {
            Console::PrintLn('Omen key:' . $key . ' not is array', Colors::RED);
            return static::getInstance();
        }

        self::$memory[$key][] = $value;

        return static::getInstance();
    }

    /**
     * @param string $key
     * @return int
     */
    static public function count(string $key): int
    {
        if (!isset(self::$memory[$key])) {
            return 0;
        }

        if (is_array(self::$memory[$key])) {
            return count(self::get($key));
        }

        if (is_string(self::$memory[$key])) {
            return strlen(self::get($key));
        }

        return 0;
    }
    
    /**
     * @param mixed $key
     * @param mixed $value
     * @return Omen
     */
    static public function remove(string $key, $index = null): Omen
    {
        if ($index !== null) {
            unset(self::$memory[$key][$index]);
        } else {
            unset(self::$memory[$key]);
        }
        
        return static::getInstance();
    }
    
}
