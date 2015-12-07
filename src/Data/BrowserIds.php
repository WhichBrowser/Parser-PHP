<?php

namespace WhichBrowser\Data;

class BrowserIds
{
    public static $ANDROID_BROWSERS = [];

    public static function identify($model)
    {
        require_once __DIR__ . '/../../data/id-android.php';

        if (isset(BrowserIds::$ANDROID_BROWSERS[$model])) {
            return BrowserIds::$ANDROID_BROWSERS[$model];
        }
    }
}
