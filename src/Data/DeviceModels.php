<?php

namespace WhichBrowser\Data;

use WhichBrowser\Constants;
use WhichBrowser\Model\Device;

class DeviceModels
{
    public static $ANDROID_MODELS = [];
    public static $ASHA_MODELS = [];
    public static $BADA_MODELS = [];
    public static $BREW_MODELS = [];
    public static $FIREFOXOS_MODELS = [];
    public static $TIZEN_MODELS = [];
    public static $TOUCHWIZ_MODELS = [];
    public static $WINDOWS_MOBILE_MODELS = [];
    public static $WINDOWS_PHONE_MODELS = [];
    public static $PALMOS_MODELS = [];
    public static $S30PLUS_MODELS = [];
    public static $S40_MODELS = [];
    public static $S60_MODELS = [];
    public static $FEATURE_MODELS = [];
    public static $BLACKBERRY_MODELS = [];
    public static $IOS_MODELS = [];


    public static function identify($type, $model)
    {
        require_once __DIR__ . '/../../data/models-' . $type . '.php';

        switch ($type) {
            case 'android':
                return self::identifyAndroid($model);
            case 'asha':
                return self::identifyList(self::$ASHA_MODELS, $model);
            case 'bada':
                return self::identifyList(self::$BADA_MODELS, $model);
            case 'blackberry':
                return self::identifyBlackBerry($model);
            case 'brew':
                return self::identifyList(self::$BREW_MODELS, $model);
            case 'firefoxos':
                return self::identifyList(self::$FIREFOXOS_MODELS, $model, false);
            case 'ios':
                return self::identifyIOS($model);
            case 'tizen':
                return self::identifyList(self::$TIZEN_MODELS, $model);
            case 'touchwiz':
                return self::identifyList(self::$TOUCHWIZ_MODELS, $model);
            case 'wm':
                return self::identifyList(self::$WINDOWS_MOBILE_MODELS, $model);
            case 'wp':
                return self::identifyList(self::$WINDOWS_PHONE_MODELS, $model);
            case 's30plus':
                return self::identifyList(self::$S30PLUS_MODELS, $model);
            case 's40':
                return self::identifyList(self::$S40_MODELS, $model);
            case 's60':
                return self::identifyList(self::$S60_MODELS, $model);
            case 'palmos':
                return self::identifyList(self::$PALMOS_MODELS, $model);
            case 'feature':
                return self::identifyList(self::$FEATURE_MODELS, $model);
        }
    }

    public static function identifyIOS($model)
    {
        $model = str_replace('Unknown ', '', $model);
        $model = preg_replace("/iPh([0-9],[0-9])/", 'iPhone\\1', $model);
        $model = preg_replace("/iPd([0-9],[0-9])/", 'iPod\\1', $model);

        return self::identifyList(self::$IOS_MODELS, $model);
    }

    public static function identifyAndroid($model)
    {
        $result = self::identifyList(self::$ANDROID_MODELS, $model);

        if (!$result->identified) {
            $model = self::cleanup($model);
            if (preg_match('/AndroVM/iu', $model)  || $model == 'Emulator' || $model == 'x86 Emulator' || $model == 'x86 VirtualBox' || $model == 'vm') {
                return new Device([
                    'type'          => Constants\DeviceType::EMULATOR,
                    'identified'    => Constants\Id::PATTERN,
                    'manufacturer'  => null,
                    'model'         => null,
                    'generic'       => false
                ]);
            }
        }

        return $result;
    }

    public static function identifyBlackBerry($model)
    {
        $device = new Device([
            'type'          => Constants\DeviceType::MOBILE,
            'identified'    => Constants\Id::PATTERN,
            'manufacturer'  => 'RIM',
            'model'         => 'BlackBerry ' . $model,
            'generic'       => false
        ]);

        if (isset(self::$BLACKBERRY_MODELS[$model])) {
            $device->model = 'BlackBerry ' . self::$BLACKBERRY_MODELS[$model] . ' ' . $model;
            $device->identified |= Constants\Id::MATCH_UA;
        }

        return $device;
    }

    public static function identifyList($list, $model, $cleanup = true)
    {
        $original = $model;

        if ($cleanup) {
            $model = self::cleanup($model);
        }

        $device = new Device([
            'type'          => Constants\DeviceType::MOBILE,
            'identified'    => Constants\Id::NONE,
            'manufacturer'  => null,
            'model'         => $model,
            'identifier'    => $original,
            'generic'       => false
        ]);

        foreach ($list as $m => $v) {
            $match = null;
            $pattern = null;

            if (self::hasMatch($m, $model)) {
                if (substr($m, -2) == "!!") {
                    foreach ($v as $m2 => $v2) {
                        if (self::hasMatch($m2, $model)) {
                            $match = $v2;
                            $pattern = $m2;
                            continue;
                        }
                    }
                } else {
                    $match = $v;
                    $pattern = $m;
                }
            }

            if ($match) {
                $device->manufacturer = $match[0];
                $device->model = self::applyMatches($match[1], $model, $pattern);
                $device->identified = Constants\Id::MATCH_UA;

                if (isset($match[2])) {
                    if (is_array($match[2])) {
                        $device->type = $match[2][0];
                        $device->subtype = $match[2][1];
                    } else {
                        $device->type = $match[2];
                    }
                }

                if (isset($match[3])) {
                    $device->flag = $match[3];
                }
                
                if ($device->manufacturer == null && $device->model == null) {
                    $device->identified = Constants\Id::PATTERN;
                }

                return $device;
            }
        }

        return $device;
    }

    public static function applyMatches($model, $original, $pattern)
    {
        if (strpos($model, '$') !== false && substr($pattern, -1) == "!") {
            if (preg_match('/^' . substr($pattern, 0, -1) . '/iu', $original, $matches)) {
                foreach ($matches as $k => $v) {
                    $model = str_replace('$' . $k, $v, $model);
                }
            }
        }

        return $model;
    }

    public static function hasMatch($pattern, $model)
    {
        if (substr($pattern, -2) == "!!") {
            return !! preg_match('/^' . substr($pattern, 0, -2) . '/iu', $model);
        } elseif (substr($pattern, -1) == "!") {
            return !! preg_match('/^' . substr($pattern, 0, -1) . '/iu', $model);
        } else {
            return strtolower($pattern) == strtolower($model);
        }
    }

    public static function cleanup($s = '')
    {
        $s = preg_replace('/^phone\//', '', $s);
        $s = preg_replace('/\/[^\/]+$/u', '', $s);
        $s = preg_replace('/\/[^\/]+ Android\/.*/u', '', $s);

        $s = preg_replace('/UCBrowser$/u', '', $s);

        $s = preg_replace('/_TD$/u', '', $s);
        $s = preg_replace('/_LTE$/u', '', $s);
        $s = preg_replace('/_CMCC$/u', '', $s);
        $s = preg_replace('/_CUCC$/u', '', $s);
        $s = preg_replace('/-BREW.+$/u', '', $s);
        $s = preg_replace('/ MIDP.+$/u', '', $s);

        $s = preg_replace('/_/u', ' ', $s);
        $s = preg_replace('/^\s+|\s+$/u', '', $s);

        $s = preg_replace('/^tita on /u', '', $s);
        $s = preg_replace('/^De-Sensed /u', '', $s);
        $s = preg_replace('/^ICS AOSP on /u', '', $s);
        $s = preg_replace('/^Baidu Yi on /u', '', $s);
        $s = preg_replace('/^Buildroid for /u', '', $s);
        $s = preg_replace('/^Gingerbread on /u', '', $s);
        $s = preg_replace('/^Android (on |for )/u', '', $s);
        $s = preg_replace('/^Generic Android on /u', '', $s);
        $s = preg_replace('/^Full JellyBean( on )?/u', '', $s);
        $s = preg_replace('/^Full (AOSP on |Android on |Base for |Cappuccino on |MIPS Android on |Webdroid on |JellyBean on |Android)/u', '', $s);
        $s = preg_replace('/^AOSPA? on /u', '', $s);

        $s = preg_replace('/^Acer( |-)?/iu', '', $s);
        $s = preg_replace('/^Iconia( Tab)? /u', '', $s);
        $s = preg_replace('/^ASUS ?/u', '', $s);
        $s = preg_replace('/^Ainol /u', '', $s);
        $s = preg_replace('/^Coolpad ?/iu', 'Coolpad ', $s);
        $s = preg_replace('/^Alcatel[_ ]OT[_-](.*)/iu', 'One Touch $1', $s);
        $s = preg_replace('/^ALCATEL /u', '', $s);
        $s = preg_replace('/^YL-/u', '', $s);
        $s = preg_replace('/^TY-K[_\- ]Touch/iu', 'K-Touch', $s);
        $s = preg_replace('/^K-Touch[_\-]/u', 'K-Touch ', $s);
        $s = preg_replace('/^Novo7 ?/iu', 'Novo7 ', $s);
        $s = preg_replace('/^HW-HUAWEI/u', 'HUAWEI', $s);
        $s = preg_replace('/^Huawei[ -]/iu', 'Huawei ', $s);
        $s = preg_replace('/^SAMSUNG SAMSUNG-/iu', '', $s);
        $s = preg_replace('/^SAMSUNG[ -]/iu', '', $s);
        $s = preg_replace('/^(Sony ?Ericsson|Sony)/u', '', $s);
        $s = preg_replace('/^(Lenovo Lenovo|LNV-Lenovo|LENOVO-Lenovo)/u', 'Lenovo', $s);
        $s = preg_replace('/^Lenovo-/u', 'Lenovo', $s);
        $s = preg_replace('/^ZTE-/u', 'ZTE ', $s);
        $s = preg_replace('/^(LG)[ _\/]/u', '$1-', $s);
        $s = preg_replace('/^(HTC.+)\s[v|V][0-9.]+$/u', '$1', $s);
        $s = preg_replace('/^(HTC)[-\/]/u', '$1', $s);
        $s = preg_replace('/^(HTC)([A-Z][0-9][0-9][0-9])/u', '$1 $2', $s);
        $s = preg_replace('/^(Motorola[\s|-])/u', '', $s);
        $s = preg_replace('/^(MOT-)/u', '', $s);
        $s = preg_replace('/^Moto([^\s])/u', '$1', $s);

        $s = preg_replace('/-?(orange(-ls)?|vodafone|bouygues|parrot|Kust|ls)$/iu', '', $s);
        $s = preg_replace('/http:\/\/.+$/iu', '', $s);
        $s = preg_replace('/^\s+|\s+$/u', '', $s);

        return $s;
    }
}
