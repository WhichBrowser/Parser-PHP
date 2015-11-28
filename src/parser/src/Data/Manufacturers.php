<?php

namespace WhichBrowser\Data;

class Manufacturers
{
    public static $TELEVISION = [];

    public static function identify($type, $name)
    {
        $name = preg_replace('/^CUS\:/u', '', trim($name));

        require_once __DIR__ . '/../../data/manufacturer-names.php';

        if (isset(Manufacturers::$TELEVISION[$name])) {
            return self::$TELEVISION[$name];
        }

        return $name;
    }
}
