<?php

namespace Omen\Helper;

class Arr
{
    /**
     * Сравнить рекурсивно структуру двух массивов
     *
     * @param array $arr1
     * @param array $arr2
     *
     * @return array
     */
    public static function diffKeyRecursive(array $arr1, array $arr2): array
    {
        $ret = [];
        foreach ($arr1 as $key => $val) {
            if (array_key_exists($key, $arr2)) {
                if (is_array($val) && is_array($arr2[$key])) {
                    $diff = self::diffKeyRecursive($val, $arr2[$key]);
                    if (count($diff)) {
                        $ret[$key] = $diff;
                    }
                }
            } else {
                $ret[$key] = $val;
            }
        }
        return $ret;
    }
}
