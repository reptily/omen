<?php

namespace Omen\Debug;

interface Colors
{
    const NONE          = "\e[0m";
    const BLACK         = "\e[0;30m";
    const GRAY          = "\e[1;30m";
    const RED           = "\e[0;31m";
    const LIGHT_RED     = "\e[1;31m";
    const GREEN         = "\e[0;32m";
    const LIGHT_GREEN   = "\e[1;32m";
    const BROWN         = "\e[0;33m";
    const YELLOW        = "\e[1;33m";
    const BLUE          = "\e[0;34m";
    const LIGHT_BLUE    = "\e[1;34m";
    const PURPLE        = "\e[0;35m";
    const LIGHT_PURPLE  = "\e[1;35m";
    const CYAN          = "\e[0;36m";
    const LIGHT_CYAN    = "\e[1;36m";
    const LIGHT_GRAY    = "\e[0;37m";
    const WHITE         = "\e[1;37m";
}
