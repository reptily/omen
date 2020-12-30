<?php

namespace Omen\Debug;

class Log
{
    /**
     * @param string $text
     */
    static public function Save(string $text): void
    {
        file_put_contents("./logs/runtime.log", "[" . date("H:i:s Y-m-d"). "] " . $text . "\n", FILE_APPEND);
    }
}
