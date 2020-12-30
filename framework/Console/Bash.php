<?php

namespace Omen\Console;

use Omen\Debug\Colors;
use Omen\Debug\Console;

/**
 * @method \Omen\Console\bin\Help Help()
 */
class Bash
{
    const NAMESPACE_APP = '\\Omen\\Console\\bin\\';

    /** @var bool */
    protected $factory = false;

    /** @var array */
    protected $argv = [];

    const BASE_APP = [
        'start'     => true,
        'stop'      => true,
        'restart'   => true,
        'status'    => true
    ];

    public function __construct()
    {
        if (isset($_SERVER['argv']) && is_array($_SERVER['argv']) && !empty($_SERVER['argv'])) {
            $this->argv = $_SERVER['argv'];
            if (count($this->argv) === 1) {
                $this->factory()->Help();
                die;
            }

            $bin = $this->factory()->Help()->getBinByName($this->argv[1]);
            if ($bin === null) {
                Console::PrintLn("Команда не найдена", Colors::RED);
                die;
            }

            if (!array_key_exists($bin, self::BASE_APP)) {
                $this->factory()->$bin();
                die();
            }
        }
    }

    /**
     * @return Bash
     */
    private function factory(): Bash
    {
        $this->factory = true;
        return $this;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $name = str_replace(":","\\", $name);
        $name = self::NAMESPACE_APP . $name;

        $instance = new $name($this->argv);
        Console::PrintLn($instance::DESCRIPTION, Colors::YELLOW);
        Console::PrintLn('');
        $instance->run();
        return $instance;
    }
}