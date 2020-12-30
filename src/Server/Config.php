<?php
/**
 * Singleton
 */
namespace Omen\Server;

class Config
{
    /**
     *@var Config instance
     */
    private static $instance;

    /** @var array */
    protected static $triggers = [];

    /** @var array */
    protected static $config = [];

    /**
     * @param array $config
     * @return Config|static
     */
    static public function getInstance(array $config): Config
    {
        self::$config = $config;
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

    static public function getWebSocket()
    {
        return new class(self::$config['websocket']) {
            public $config;
            public function __construct($config)
            {
                $this->config = $config;
            }

            public function getHost() {
                return $this->config['host'];
            }

            public function getPort() {
                return $this->config['port'];
            }
        };
    }

    static public function getDataBase()
    {
        return new class(self::$config['database']) {
            public $config;
            public function __construct($config)
            {
                $this->config = $config;
            }

            public function getHost() {
                return $this->config['host'];
            }

            public function getPort() {
                return $this->config['port'];
            }

            public function getLogin() {
                return $this->config['login'];
            }

            public function getPassword() {
                return $this->config['password'];
            }

            public function getPower() {
                return $this->config['power'];
            }

            public function getDriver() {
                return $this->config['driver'];
            }

            public function getSchema() {
                return $this->config['schema'];
            }
        };
    }
}
