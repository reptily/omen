<?php

namespace Omen\Console\bin\make;

use Omen\Debug\Colors;
use Omen\Debug\Console;
use Omen\Helper\Str;

class Seed extends Make
{
    const DESCRIPTION = 'Создание семени';
    const TPL = __DIR__ . "/tpl/Seed.tpl";

    public function run(): bool
    {
        if (!isset($this->argv[2])) {
            Console::PrintLn("Не задано имя Семини", Colors::RED);
            return false;
        }

        $this->setValue('name', Str::toUpperCamelCase($this->argv[2]));

        $result = $this->make(Str::toUpperCamelCase($this->argv[2]), 'database/seeds');

        if ($result === true) {
            Console::PrintLn("Семя удачно создано", Colors::GREEN);
            return true;
        }

        Console::PrintLn("Ошибка при создании семини", Colors::RED);
        return false;
    }
}