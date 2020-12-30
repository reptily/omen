<?php

namespace Omen\Facade;

use DateTime;
use Omen\Debug\Colors;
use Omen\Debug\Console;
use Omen\Debug\Log;
use Omen\Event\DTO;
use Omen\OmenConst;
use Omen\Session;
use Rdw\X\Autoload\AutoloadException;

class Event
{
    /** @var array */
    protected $triggers = [];

    /** @var Session */
    protected $session;

    /**
     * @param string $type
     * @param array $obj
     * @return DTO
     */
    public function create(string $type, array $obj): DTO
    {
        $dto = new DTO;

        try {
            $dto
                ->setDateTimeSend(new DateTime())
                ->setType($type)
                ->setObjs($obj)
            ;
        } catch (\Exception $e) {
            Log::Save($e->getMessage());
        }

        return $dto;
    }

    public function update($subject)
    {
        echo 'is reading \n';
    }

    /**
     * @param string $name
     * @return bool
     */
    public function attachTrigger(string $name): bool
    {
        $name = str_replace(OmenConst::NAMESPACE_TRIGGERS, '', $name);
        try {
            if (!class_exists(OmenConst::NAMESPACE_TRIGGERS . $name)) {
                Console::PrintLn('Class "' . OmenConst::NAMESPACE_TRIGGERS . $name . '" not exists', Colors::RED);
                return false;
            }
        } catch (AutoloadException $e) {
            return false;
        }

        $this->triggers[] = $name;
        return true;
    }

    /**
     * @return array
     */
    public function getTriggers(): array
    {
        return $this->triggers;
    }

    /**
     * @param Session $session
     * @return Event
     */
    public function setSession(Session $session): Event
    {
        $this->session = $session;
        return $this;
    }

    public function getSession(): Session
    {
        return $this->session;
    }
}
