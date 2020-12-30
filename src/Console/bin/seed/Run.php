<?php

namespace Omen\Console\bin\seed;

use Omen\Console\bin\bin;
use Omen\Console\bin\migrate\Migrate;
use Phinx\Console\PhinxApplication;
use Phinx\Wrapper\TextWrapper;

class Run extends Migrate implements bin
{
    /** @var string */
    const DESCRIPTION = 'Запуск посева семян';

    public function run(): bool
    {
        $app = new PhinxApplication();
        $wrap = new TextWrapper($app);

        $fileConfig = $this->createCacheConfig();

        $wrap->setOption('configuration', $fileConfig);
        $result = $wrap->getSeed();

        echo $result;

        $this->deleteCache($fileConfig);
        return true;
    }
}
