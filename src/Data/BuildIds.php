<?php

namespace WhichBrowser\Data;

use WhichBrowser\Model\Version;

class BuildIds
{
    public static $ANDROID_BUILDS = [];

    public static function identify($id)
    {
        require_once __DIR__ . '/../../data/build-android.php';

        if (isset(BuildIds::$ANDROID_BUILDS[$id])) {
            if (is_array(BuildIds::$ANDROID_BUILDS[$id])) {
                return new Version(BuildIds::$ANDROID_BUILDS[$id]);
            } else {
                return new Version([ 'value' => BuildIds::$ANDROID_BUILDS[$id] ]);
            }
        }
    }
}
