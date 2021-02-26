<?php

namespace Omen\Server;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Events\Dispatcher;
use Omen\Debug\Colors;
use Omen\Debug\Console;
use Omen\Event\Register as Event;
use Omen\Helper\Arr;
use Omen\Omen;
use Omen\OmenConst;
use Omen\Session;
use Omen\Trigger\Register as Trigger;
use Workerman\Connection\TcpConnection;

class Server extends Decorator
{
    protected $server;

    protected $connections = [];

    const CONFIG_STRUCTURE = [
        'websocket' => [
            'host' => true,
            'port' => true,
        ],
        'database' => [
          'driver' => true,
          'host' => true,
          'port' => true,
          'login' => true,
          'password' => true,
          'power' => true,
        ],
    ];

    //*
    public function Init(): void
    {
        Event::getInstance();
        Omen::getInstance();
        Trigger::getInstance();
        $this->loadConfig();

        if (Config::getDataBase()->getPower()) {
            $db = new DB();

            $db->addConnection([
                'driver'        => Config::getDataBase()->getDriver(),
                'host'          => Config::getDataBase()->getHost(),
                'database'      => Config::getDataBase()->getSchema(),
                'username'      => Config::getDataBase()->getLogin(),
                'password'      => Config::getDataBase()->getPassword(),
                'charset'       => 'utf8',
                'collation'     => 'utf8_unicode_ci',
                'prefix'        => '',
            ]);

            $db->setEventDispatcher(new Dispatcher(new Container()));
            $db->setAsGlobal();
            $db->bootEloquent();
        }

        parent::Init();
    }

    /**
     * @param TcpConnection $to
     * @param string|null $text
     */
    public function Send(TcpConnection $to, ?string $text): void
    {
        if ($text !== null ) {
            parent::Send($to, $text);
            Console::PrintLn("Send to id: " . $to->id . " msg: ". $text);
        }

        $session = Session::getInstance($to->id);
        \Omen\Trigger\Trigger::runTriggers($session);
    }

    /**
     * @param TcpConnection $to
     * @param string $text
     */
    static public function manualSend(TcpConnection $to, string $text): void
    {
        parent::Send($to, $text);
        Console::PrintLn("Send to id: " . $to->id . " msg: ". $text);

        $session = Session::getInstance($to->id);
        \Omen\Trigger\Trigger::runTriggers($session);
    }

    /**
     * @param string $text
     */
    static public function manualSendAll(string $text): void
    {
        foreach ((new Server)->getConnections() as $to) {
            self::manualSend($to, $text);
        }
    }

    /**
     * @return array
     */
    private function getConnections(): array
    {
        return $this->connections;
    }

    private function loadConfig()
    {
        $configFile = @file_get_contents(OmenConst::PATH_CONFIG_FILE);

        if ($configFile === false) {
            Console::PrintLn("Ошибка чтения файла " . OmenConst::PATH_CONFIG_FILE, Colors::RED);
            die();
        }

        $config = json_decode($configFile, true) ?? [];

        if (!$this->checkStructures($config)) {
            Console::PrintLn("Ошибка структуры файла " . OmenConst::PATH_CONFIG_FILE, Colors::RED);
            die();
        }

        Config::getInstance($config);
    }

    /**
     * @param array $config
     * @return bool
     */
    private function checkStructures(array $config): bool
    {
       return count(Arr::diffKeyRecursive( self::CONFIG_STRUCTURE, $config)) === 0;
    }
}
