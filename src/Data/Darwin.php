<?php

namespace WhichBrowser\Data;

class Darwin
{
    public static $OSX = [];
    public static $IOS = [];

    public static function getVersion($platform, $version)
    {
        require_once __DIR__ . '/../../data/os-darwin.php';

        $version = implode('.', array_slice(explode('.', $version), 0, 3));

        switch ($platform) {
            case 'osx':
                if (isset(Darwin::$OSX[$version])) {
                    return Darwin::$OSX[$version];
                }
                break;
            case 'ios':
                if (isset(Darwin::$IOS[$version])) {
                    return Darwin::$IOS[$version];
                }
                break;
        }
    }
}
