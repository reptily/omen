<?php

namespace Omen\Console\bin\make;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Events\Dispatcher;
use Omen\Console\bin\bin;
use Omen\Debug\Colors;
use Omen\Debug\Console;
use Omen\Helper\Str;
use Omen\Server\Config;

class Model extends Make implements bin
{
    const DESCRIPTION = 'Создание модели';
    const TPL = __DIR__ . "/tpl/Model.tpl";

    public function run(): bool
    {
        if (!isset($this->argv[2])) {
            Console::PrintLn("Не задано имя Модели", Colors::RED);
            return false;
        }

        if (!Config::getDataBase()->getPower()) {
            Console::PrintLn("Для создание модели, нужно в конфиге включить базу данных", Colors::RED);
            return false;
        }

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

        $columns = $db->getConnection()->getSchemaBuilder()->getColumnListing('test'); //todo
        $const = "";

        foreach ($columns as $column) {
            $const .= "\tconst FIELD_" . mb_strtoupper(Str::toUnderScored($column)) . " = '" . $column . "';\n";
        }

        $this->setValue('name', Str::toUpperCamelCase($this->argv[2]));
        $this->setValue('const', $const);

        $result = $this->make(Str::toUpperCamelCase($this->argv[2]), 'App/Models');

        if ($result === true) {
            Console::PrintLn("Модель удачно создана", Colors::GREEN);
            return true;
        }

        Console::PrintLn("Ошибка при создании модели", Colors::RED);
        return false;
    }
}
