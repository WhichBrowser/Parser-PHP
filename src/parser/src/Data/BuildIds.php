<?php

namespace WhichBrowser\Data;

use WhichBrowser\Model\Version;

class BuildIds
{
    public static $ANDROID_BUILDS = [];

    public static function identify($type, $id)
    {
        require_once __DIR__ . '/../../data/build-' . $type . '.php';

        switch ($type) {
            case 'android':
                return self::identifyList(BuildIds::$ANDROID_BUILDS, $id);
        }

        return false;
    }

    public static function identifyList($list, $id)
    {
        if (isset($list[$id])) {
            if (is_array($list[$id])) {
                return new Version($list[$id]);
            } else {
                return new Version([ 'value' => $list[$id] ]);
            }
        }

        return false;
    }
}
