<?php

namespace Omen\Debug;

class Console implements Colors
{

    /**
     * @param string $text
     * @param string $color
     */
    static public function PrintLn(string $text, string $color = Colors::NONE): void
    {
        echo $color . $text . Colors::NONE . "\n";
    }
}
