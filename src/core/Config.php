<?php

namespace rave\core;

class Config
{
    private static $_container = [];

    public static function addArray(array $options)
    {
        self::$_container = array_merge(self::$_container, $options);
    }

    public static function add($key, $value)
    {
        self::$_container[$key] = $value;
    }

    public static function get(string $option)
    {
       return isset(self::$_container[$option]) ? self::$_container[$option] : null;
    }

    public static function getError($error_type)
    {
        return self::get('error')[$error_type];
    }

}
