<?php

namespace Omen\Console\bin\migrate;

use Omen\Console\bin\bin;
use Phinx\Console\PhinxApplication;
use Phinx\Wrapper\TextWrapper;

class Rollback extends Migrate implements bin
{
    /** @var string */
    const DESCRIPTION = 'Миграция таблиц';

    public function run(): bool
    {
        $app = new PhinxApplication();
        $wrap = new TextWrapper($app);

        $fileConfig = $this->createCacheConfig();

        $wrap->setOption('configuration', $fileConfig);
        $result = $wrap->getRollback();

        echo $result;

        $this->deleteCache($fileConfig);
        return true;
    }
}
