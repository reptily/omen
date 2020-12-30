<?php

namespace Omen\Console\bin\make;

use Omen\Console\bin\bin;
use Omen\Debug\Colors;
use Omen\Debug\Console;
use Omen\Helper\Str;

class Event extends Make implements bin
{
    const DESCRIPTION = 'Создание события';
    const TPL = __DIR__ . "/tpl/Event.tpl";

    public function run(): bool
    {
        if (!isset($this->argv[2])) {
            Console::PrintLn("Не задано имя события", Colors::RED);
            return false;
        }

        $this->setValue('name', Str::toUpperCamelCase($this->argv[2]));
        $result = $this->make(Str::toUpperCamelCase($this->argv[2]), 'App/Events');

        if ($result === true) {
            Console::PrintLn("Событие удачно создано", Colors::GREEN);
            return true;
        }

        Console::PrintLn("Ошибка при создание события", Colors::RED);
        return false;
    }
}
