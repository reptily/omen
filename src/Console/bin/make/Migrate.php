<?php

namespace Omen\Console\bin\make;

use Omen\Console\bin\bin;
use Omen\Debug\Colors;
use Omen\Debug\Console;
use Omen\Helper\Str;

class Migrate extends Make implements bin
{
    const DESCRIPTION = 'Создание миграции';
    const TPL = __DIR__ . "/tpl/Migrate.tpl";

    public function run(): bool
    {
        if (!isset($this->argv[2])) {
            Console::PrintLn("Не задано имя Миграции", Colors::RED);
            return false;
        }

        $this->setValue('name', Str::toUpperCamelCase($this->argv[2]));
        $this->setValue('table_name', Str::toUnderScored($this->argv[2]));

        $result = $this->make(date("YmdHis") . "_" . Str::toUnderScored($this->argv[2]), 'database/migrations');

        if ($result === true) {
            Console::PrintLn("Миграция удачно создана", Colors::GREEN);
            return true;
        }

        Console::PrintLn("Ошибка при создании миграции", Colors::RED);
        return false;
    }
}
