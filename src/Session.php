<?php
/**
 * Multiton
 */

namespace Omen;


final class Session
{
    /** @var Session instance[] */
    private static $instance = [];

    /** @var array */
    private $array = [];

    /**
     * @param string $session
     * @return static
     */
    static public function getInstance(string $session){
        return static::$instance[$session] ?? (static::$instance[$session] = new static());
    }

    /**
     * construct denied
     */
    private function __construct(){
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
     * @param $val
     * @return Session
     */
    public function set($val): Session
    {
        $this->array = $val;
        return $this;
    }

    /**
     * @return string;
     */
    public function get(): array
    {
        return $this->array;
    }

}
