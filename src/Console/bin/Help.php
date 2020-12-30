<?php

namespace Omen\Console\bin;

use Omen\Console\bin\make\Event;
use Omen\Console\bin\make\Migrate;
use Omen\Console\bin\make\Model;
use Omen\Console\bin\make\Seed;
use Omen\Console\bin\make\Trigger;
use Omen\Console\bin\migrate\Commit;
use Omen\Console\bin\migrate\Rollback;
use Omen\Console\bin\migrate\Status;
use Omen\Console\bin\seed\Run;
use Omen\Debug\Colors;

class Help implements bin
{
    /** @var string */
    const DESCRIPTION = 'Список команд';

    /** @var null|int */
    private $size = null;

    private $bins = [
        'start'             => 'Запуск сервера',
        'stop'              => 'Остановка сервера',
        'restart'           => 'Перезапуск сервера',
        'status'            => 'Статус сервера',
        'make:event'        => Event::DESCRIPTION,
        'make:trigger'      => Trigger::DESCRIPTION,
        'make:migrate'      => Migrate::DESCRIPTION,
        'make:seed'         => Seed::DESCRIPTION,
        'make:model'        => Model::DESCRIPTION,
        'migrate:commit'    => Commit::DESCRIPTION,
        'migrate:status'    => Status::DESCRIPTION,
        'migrate:rollback'  => Rollback::DESCRIPTION,
        'seed:run'          => Run::DESCRIPTION,
    ];

    public function run(): bool
    {
        foreach ($this->getBins() as $command => $description) {
            $this->printCommand($command, $description);
        }
        return true;
    }

    /**
     * @param string $command
     * @param string $description
     */
    private function printCommand(string $command, string $description): void
    {
        $countCommandLen = strlen($command);

        echo Colors::GREEN . $command . Colors::NONE . $this->makeSpace($countCommandLen) .$description . "\n";
    }

    /**
     * @param int $len
     * @return string
     */
    private function makeSpace(int $len): string
    {
        $spaces = '';

        if ($this->size === null) {
            $maxSize = 0;
            foreach ($this->getBins() as $command => $description) {
                $count = strlen($command);
                if ($count > $maxSize) {
                    $maxSize = $count;
                }
            }

            $this->size = $maxSize + 1;
        }

        for ($i = 0; $i <= $this->size - $len; $i++) {
            $spaces .= ' ';
        }

        return $spaces;
    }

    /**
     * @return array
     */
    public function getBins(): array
    {
        return $this->bins;
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function getBinByName(string $name): ?string
    {
        return $this->bins[$name] ? $name : null;
    }
}
