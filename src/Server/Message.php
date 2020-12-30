<?php

namespace Omen\Server;

use DateTime;
use Omen\Debug\Console;
use Omen\Debug\Log;
use Omen\Event\DTO;
use Omen\Event\Response;
use Workerman\Connection\TcpConnection;

class Message
{
    /** @var TcpConnection[]|null */
    protected $connections = null;

    public function __construct(array $connections)
    {
        $this->connections = $connections;
    }

    public function send(string $type, $obj) {
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

        $response = Response::send($dto);
        foreach ($this->connections as $connection) {
            $connection->send($response);
            Console::PrintLn("Send to id: " . $connection->id . " msg: ". $response);
        }
    }
}
