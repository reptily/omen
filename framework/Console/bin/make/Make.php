<?php

namespace Omen\Console\bin\make;

use Omen\Debug\Colors;
use Omen\Debug\Console;
use Omen\OmenConst;
use Omen\Server\Config;

abstract class Make
{
    /** @var string */
    const DIR_PATH = __DIR__ . '/../../../../';

    /** @var null|string */
    protected $tpl = null;

    /** @var array */
    protected $argv = [];

    public function __construct(array $argv)
    {
        $this->tpl = @file_get_contents(static::TPL) ?? null;
        $this->argv = $argv;
    }

    /**
     * @param string $key
     * @param string $value
     * @return Make
     */
    protected function setValue(string $key, string $value): Make
    {
        $this->tpl = str_replace("{{" . $key . "}}", $value, $this->tpl);
        return $this;
    }

    /**
     * @param string $file
     * @param string $dir
     * @return bool
     */
    protected function make(string $file, string $dir): bool
    {
        if (file_exists(self::DIR_PATH  . $dir . '/' . $file . '.php')) {
            Console::PrintLn("Файл уже существует", Colors::RED);
            return false;
        }

        $result = file_put_contents(self::DIR_PATH  . $dir . '/' . $file . '.php', $this->tpl);
        if ($result === false) {
            return false;
        }

        return true;
    }
}
