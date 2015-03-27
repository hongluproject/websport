<?php

namespace Utils;

Class Arr
{
    public static function removeEmpty($arr)
    {
        return array_filter($arr, function($var)
        {
            if (!$var) return false;
            return true;
        });
    }
}