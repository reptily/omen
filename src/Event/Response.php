<?php

namespace Omen\Event;

class Response
{
    /**
     * @param DTO $obj
     * @return string|null
     */
    static public function send(DTO $obj): ?string
    {
        $response = [];
        $response['datetime'] = $obj->getDateTimeSend();
        $response['type'] = $obj->getType();
        $response['message'] = $obj->getObjs();

        return json_encode($response);
    }
}
