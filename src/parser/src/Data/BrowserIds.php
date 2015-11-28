<?php

namespace WhichBrowser\Data;

class BrowserIds
{
    public static $ANDROID_BROWSERS = [];

    public static function identify($type, $model)
    {
        require_once __DIR__ . '/../../data/id-' . $type . '.php';

        switch ($type) {
            case 'android':
                return self::identifyList(BrowserIds::$ANDROID_BROWSERS, $model);
        }

        return false;
    }

    public static function identifyList($list, $id)
    {
        if (isset($list[$id])) {
            return $list[$id];
        }

        return false;
    }
}
