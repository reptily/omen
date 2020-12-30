<?php

namespace Omen\Console\bin\migrate;

use Omen\OmenConst;
use Omen\Server\Config;

abstract class Migrate
{
    /** @var string */
    const DIR_PATH = __DIR__ . '/../../../../';

    protected function createCacheConfig(): string
    {
        $fileName = "make_command_" . md5(microtime()) . ".json";

        $data = [
            "paths" => [
                "migrations" => "database/migrations",
                "seeds" => "seeds/seeds",
            ],
            "environments" => [
                "default_migration_table" => "migrations",
                "default_database" => "production",
                "production" => [
                    "adapter" => Config::getDataBase()->getDriver(),
                    "host" => Config::getDataBase()->getHost(),
                    "name" => Config::getDataBase()->getSchema(),
                    "user" => Config::getDataBase()->getLogin(),
                    "pass" => Config::getDataBase()->getPassword(),
                    "port" => Config::getDataBase()->getPort(),
                    "charset" => "utf8",
                ]
            ],
        ];

        file_put_contents( self::DIR_PATH . "/" . OmenConst::PATH_CACHE . "/" . $fileName, json_encode($data));

        return OmenConst::PATH_CACHE . "/" . $fileName;
    }

    protected function deleteCache(string $name)
    {
        unlink(self::DIR_PATH . "/" . $name);
    }
}
