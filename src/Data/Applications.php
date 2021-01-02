<?php

namespace WhichBrowser\Data;

use WhichBrowser\Model\Browser;
use WhichBrowser\Model\Version;

class Applications
{
    public static $BOTS = [];
    public static $BOTS_REGEX = '';

    public static $BROWSERS = [];
    public static $BROWSERS_REGEX = '';

    public static $OTHERS = [];
    public static $OTHERS_REGEX = '';


    public static function identifyBrowser($ua)
    {
        require_once __DIR__ . '/../../data/regexes/applications-browsers.php';

        if (preg_match(self::$BROWSERS_REGEX, $ua)) {
            require_once __DIR__ . '/../../data/applications-browsers.php';

            foreach (self::$BROWSERS as $type => $list) {
                foreach ($list as $i => $item) {
                    if (preg_match($item['regexp'], $ua, $match)) {
                        return [
                            'browser' => [
                                'name'      => $item['name'],
                                'hidden'    => isset($item['hidden']) ? $item['hidden'] : false,
                                'stock'     => false,
                                'channel'   => '',
                                'type'      => $type,
                                'version'   => isset($match[1]) && $match[1] ? new Version([ 'value' => $match[1], 'details' => isset($item['details']) ? $item['details'] : null ]) : null
                            ],

                            'device' => isset($item['type']) ? [
                                'type'      => $item['type']
                            ] : null
                        ];
                    }
                }
            }
        }
    }

    public static function identifyOther($ua)
    {
        require_once __DIR__ . '/../../data/regexes/applications-others.php';

        if (preg_match(self::$OTHERS_REGEX, $ua)) {
            require_once __DIR__ . '/../../data/applications-others.php';

            foreach (self::$OTHERS as $type => $list) {
                foreach ($list as $i => $item) {
                    if (preg_match($item['regexp'], $ua, $match)) {
                        return [
                            'browser' => [
                                'name'      => $item['name'],
                                'hidden'    => isset($item['hidden']) ? $item['hidden'] : false,
                                'stock'     => false,
                                'channel'   => '',
                                'type'      => $type,
                                'version'   => isset($match[1]) && $match[1] ? new Version([ 'value' => $match[1], 'details' => isset($item['details']) ? $item['details'] : null ]) : null
                            ],

                            'device' => isset($item['type']) ? [
                                'type'      => $item['type']
                            ] : null
                        ];
                    }
                }
            }
        }
    }
    public static function identifyBot($ua)
    {
        require_once __DIR__ . '/../../data/regexes/applications-bots.php';

        if (preg_match(self::$BOTS_REGEX, $ua)) {
            require_once __DIR__ . '/../../data/applications-bots.php';

            foreach (self::$BOTS as $i => $item) {
                if (preg_match($item['regexp'], $ua, $match)) {
                    return new Browser([
                        'name'      => $item['name'],
                        'stock'     => false,
                        'version'   => isset($match[1]) && $match[1] ? new Version([ 'value' => $match[1], 'details' => isset($item['details']) ? $item['details'] : null ]) : null
                    ]);
                }
            }
        }
    }
}
