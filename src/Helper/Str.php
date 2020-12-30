<?php

namespace Omen\Helper;

class Str
{
    /**
     * "this_method_name" -> "ThisMethodName"
     *
     * @param string $string
     * @return string
     */
    static public function toUpperCamelCase(string $string): string
    {
        return preg_replace_callback(
            '/(?:^|_)(.?)/',
            function ($str) {
                return strtoupper($str[0]);
            },
            $string
        );
    }

    /**
     * "this_method_name" -> "thisMethodName"
     *
     * @param string $string
     * @return string
     */
    static public function toLowerCamelCase(string $string): string
    {
        return preg_replace_callback(
            '/_(.?)/',
            function ($str) {
                return strtoupper($str[0]);
            }
            , $string);
    }

    /**
     * "thisMethodName" -> "this_method_name"
     *
     * @param string $string
     * @return string
     */
    static public function toUnderScored(string $string): string
    {
        return strtolower(preg_replace('/([^A-Z])([A-Z])/', "$1_$2", $string));
    }
}
