<?php
/**
 * String Utils
 */

namespace Utils;

class Str
{
    public static function highlight($str, $keyword)
    {
        if (!$str || !$keyword) return $str;

        return preg_replace('/(' . str_replace(array('/', '.'), array('\\/',
                                                                      '\\.'), $keyword) . ')/i', '<font color="#f00">$1</font>', $str);
    }
}