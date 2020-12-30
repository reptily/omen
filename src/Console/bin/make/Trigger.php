<?php

namespace Omen\Console\bin\make;

use Omen\Console\bin\bin;
use Omen\Debug\Colors;
use Omen\Debug\Console;
use Omen\Helper\Str;

class Trigger extends Make implements bin
{
    const DESCRIPTION = 'Создание триггера';
    const TPL = __DIR__ . "/tpl/Trigger.tpl";

    public function run(): bool
    {
        if (!isset($this->argv[2])) {
            Console::PrintLn("Не задано имя триггера", Colors::RED);
            return false;
        }

        $this->setValue('name', Str::toUpperCamelCase($this->argv[2]));

        $result = $this->make(Str::toUpperCamelCase($this->argv[2]), 'App/Triggers');

        if ($result === true) {
            Console::PrintLn("Триггер удачно создан", Colors::GREEN);
            return true;
        }

        Console::PrintLn("Ошибка при создании триггера", Colors::RED);
        return false;
    }
}
