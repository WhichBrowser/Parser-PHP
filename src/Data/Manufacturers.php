<?php

namespace WhichBrowser\Data;

use WhichBrowser\Constants;

class Manufacturers
{
    public static $GENERIC = [];
    public static $TELEVISION = [];

    public static function identify($type, $name)
    {
        $name = preg_replace('/^CUS\:/u', '', trim($name));

        require_once __DIR__ . '/../../data/manufacturer-names.php';

        if ($type == Constants\DeviceType::TELEVISION) {
            if (isset(Manufacturers::$TELEVISION[$name])) {
                return self::$TELEVISION[$name];
            }
        }

        if (isset(Manufacturers::$GENERIC[$name])) {
            return self::$GENERIC[$name];
        }

        return $name;
    }
}
