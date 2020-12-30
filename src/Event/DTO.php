<?php

namespace Omen\Event;

use DateTime;

class DTO
{
    /** @var string */
    protected $type;

    /** @var DateTime */
    protected $dateTimeSend;

    /** @var array */
    protected $objs;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return DTO
     */
    public function setType(string $type): DTO
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateTimeSend(): DateTime
    {
        return $this->dateTimeSend;
    }

    /**
     * @param DateTime $dateTimeSend
     * @return DTO
     */
    public function setDateTimeSend(DateTime $dateTimeSend): DTO
    {
        $this->dateTimeSend = $dateTimeSend;
        return $this;
    }

    /**
     * @return array
     */
    public function getObjs(): array
    {
        return $this->objs;
    }

    /**
     * @param array $objs
     * @return DTO
     */
    public function setObjs(array $objs): DTO
    {
        $this->objs = $objs;
        return $this;
    }
}
