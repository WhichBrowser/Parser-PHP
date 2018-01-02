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
    public static $WM_MODELS = [];
    public static $WP_MODELS = [];
    public static $PALMOS_MODELS = [];
    public static $S30PLUS_MODELS = [];
    public static $S40_MODELS = [];
    public static $SYMBIAN_MODELS = [];
    public static $FEATURE_MODELS = [];
    public static $BLACKBERRY_MODELS = [];
    public static $IOS_MODELS = [];
    public static $KDDI_MODELS = [];

    public static $ANDROID_INDEX = [];
    public static $ASHA_INDEX = [];
    public static $BADA_INDEX = [];
    public static $BREW_INDEX = [];
    public static $FIREFOXOS_INDEX = [];
    public static $TIZEN_INDEX = [];
    public static $TOUCHWIZ_INDEX = [];
    public static $WM_INDEX = [];
    public static $WP_INDEX = [];
    public static $PALMOS_INDEX = [];
    public static $S30PLUS_INDEX = [];
    public static $S40_INDEX = [];
    public static $SYMBIAN_INDEX = [];
    public static $FEATURE_INDEX = [];
    public static $KDDI_INDEX = [];


    public static function identify($type, $model)
    {
        require_once __DIR__ . '/../../data/models-' . $type . '.php';

        if ($type != 'blackberry' && $type != 'ios') {
            require_once __DIR__ . '/../../data/indices/models-' . $type . '.php';
        }

        switch ($type) {
            case 'android':
                return self::identifyAndroid($model);
            case 'asha':
                return self::identifyList(self::$ASHA_INDEX, self::$ASHA_MODELS, $model);
            case 'bada':
                return self::identifyList(self::$BADA_INDEX, self::$BADA_MODELS, $model);
            case 'blackberry':
                return self::identifyBlackBerry($model);
            case 'brew':
                return self::identifyList(self::$BREW_INDEX, self::$BREW_MODELS, $model);
            case 'firefoxos':
                return self::identifyList(self::$FIREFOXOS_INDEX, self::$FIREFOXOS_MODELS, $model, false);
            case 'ios':
                return self::identifyIOS($model);
            case 'tizen':
                return self::identifyList(self::$TIZEN_INDEX, self::$TIZEN_MODELS, $model);
            case 'touchwiz':
                return self::identifyList(self::$TOUCHWIZ_INDEX, self::$TOUCHWIZ_MODELS, $model);
            case 'wm':
                return self::identifyWindowsMobile($model);
            case 'wp':
                return self::identifyList(self::$WP_INDEX, self::$WP_MODELS, $model);
            case 's30plus':
                return self::identifyList(self::$S30PLUS_INDEX, self::$S30PLUS_MODELS, $model);
            case 's40':
                return self::identifyList(self::$S40_INDEX, self::$S40_MODELS, $model);
            case 'symbian':
                return self::identifyList(self::$SYMBIAN_INDEX, self::$SYMBIAN_MODELS, $model);
            case 'palmos':
                return self::identifyList(self::$PALMOS_INDEX, self::$PALMOS_MODELS, $model);
            case 'kddi':
                return self::identifyList(self::$KDDI_INDEX, self::$KDDI_MODELS, $model);
        }

        require_once __DIR__ . '/../../data/models-feature.php';
        require_once __DIR__ . '/../../data/indices/models-feature.php';
        return self::identifyList(self::$FEATURE_INDEX, self::$FEATURE_MODELS, $model);
    }
    
    public static function identifyWindowsMobile($model)
    {
        $model = preg_replace('/^(HTC|SAMSUNG|SHARP|Toshiba)\//u', '', $model);
        return self::identifyList(self::$WM_INDEX, self::$WM_MODELS, $model);
    }

    public static function identifyIOS($model)
    {
        $original = $model;

        $model = str_replace('Unknown ', '', $model);
        $model = preg_replace("/iPh([0-9],[0-9])/", 'iPhone\\1', $model);
        $model = preg_replace("/iPd([0-9],[0-9])/", 'iPod\\1', $model);

        $device = new Device([
            'type'          => Constants\DeviceType::MOBILE,
            'identified'    => Constants\Id::NONE,
            'manufacturer'  => null,
            'model'         => $model,
            'identifier'    => $original,
            'generic'       => false
        ]);

        if (isset(self::$IOS_MODELS[$model])) {
            $match = self::$IOS_MODELS[$model];

            $device->manufacturer = $match[0];
            $device->model = $match[1];
            $device->identified = Constants\Id::MATCH_UA;

            if (isset($match[2]) || isset($match['type'])) {
                $type = isset($match[2]) ? $match[2] : $match['type'];
                $device->type = $type;
            }

            return $device;
        }

        return $device;
    }

    public static function identifyBlackBerry($model)
    {
        $original = $model;

        if (preg_match("/BlackBerry ?([0-9]+)/ui", $model, $match)) {
            $model = $match[1];
        }

        $device = new Device([
            'type'          => Constants\DeviceType::MOBILE,
            'identified'    => Constants\Id::NONE,
            'manufacturer'  => null,
            'model'         => $model,
            'identifier'    => $original,
            'generic'       => false
        ]);

        if (preg_match("/^[1-9][0-9][0-9][0-9][ei]?$/u", $model)) {
            $device->manufacturer = 'RIM';
            $device->model = 'BlackBerry ' . $model;
            $device->identified = Constants\Id::PATTERN;

            if (isset(self::$BLACKBERRY_MODELS[$model])) {
                $device->model = 'BlackBerry ' . self::$BLACKBERRY_MODELS[$model] . ' ' . $model;
                $device->identified |= Constants\Id::MATCH_UA;
            }
        }

        return $device;
    }

    public static function identifyAndroid($model)
    {
        $result = self::identifyList(self::$ANDROID_INDEX, self::$ANDROID_MODELS, $model);

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

    public static function identifyList(&$index, &$list, $model, $cleanup = true)
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

        $keys = [ '@' . strtoupper(substr($model, 0, 2)), '@' ];

        $pattern = null;
        $match = null;

        foreach ($keys as $k => $key) {
            if (isset($index[$key])) {
                foreach ($index[$key] as $m => $v) {
                    if (self::hasMatch($v, $model)) {
                        if ($v) {
                            if (substr($v, -2) == "!!") {
                                foreach ($list[$v] as $m2 => $v2) {
                                    if (self::hasMatch($m2, $model)) {
                                        $match = $v2;
                                        $pattern = $m2;
                                        break;
                                    }
                                }
                            } else {
                                $match = $list[$v];
                                $pattern = $v;
                            }
                        }

                        if ($match) {
                            $device->manufacturer = $match[0];
                            $device->model = self::applyMatches($match[1], $model, $pattern);
                            $device->identified = Constants\Id::MATCH_UA;

                            if (isset($match[2]) || isset($match['type'])) {
                                $type = isset($match[2]) ? $match[2] : $match['type'];
                                if (is_array($type)) {
                                    $device->type = $type[0];
                                    $device->subtype = $type[1];
                                } else {
                                    $device->type = $type;
                                }
                            }

                            if (isset($match[3]) || isset($match['flag'])) {
                                $device->flag = isset($match[3]) ? $match[3] : $match['flag'];
                            }

                            if (isset($match['carrier'])) {
                                $device->carrier = $match['carrier'];
                            }

                            if ($device->manufacturer == null && $device->model == null) {
                                $device->identified = Constants\Id::PATTERN;
                            }

                            return $device;
                        }
                    }
                }
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
        // var_dump($s);

        $s = preg_replace('/^phone\//', '', $s);
        $s = preg_replace('/^(\/|; |;)/u', '', $s);
        $s = preg_replace('/\/[^\/]+$/u', '', $s);
        $s = preg_replace('/\/[^\/]+ Android\/.*/u', '', $s);

        $s = preg_replace('/UCBrowser$/u', '', $s);

        $s = preg_replace('/(_TD-LTE|_TD|_LTE|_GPRS|_BLEU|_CMCC|_CMCC_TD|_CUCC)$/u', '', $s);
        $s = preg_replace('/(-BREW| MIDP).+$/u', '', $s);
        $s = preg_replace('/ AU-MIC.+$/u', '', $s);
        $s = preg_replace('/ (AU|UP)\.Browser$/u', '', $s);

        $s = preg_replace('/_/u', ' ', $s);
        $s = preg_replace('/^\*+/u', '', $s);
        $s = preg_replace('/^\s+|\s+$/u', '', $s);

        $s = preg_replace('/^De-Sensed /u', '', $s);
        $s = preg_replace('/^Full JellyBean( on )?/u', '', $s);
        $s = preg_replace('/^(Android|Generic Android|Baidu Yi|Buildroid|Gingerbread|ICS AOSP|AOSPA?|tita) (on |for )/u', '', $s);
        $s = preg_replace('/^Full (AOSP on |Android on |Base for |Cappuccino on |MIPS Android on |Webdroid on |JellyBean on |Android)/u', '', $s);

        $s = preg_replace('/^Acer( |-)?/iu', '', $s);
        $s = preg_replace('/^Iconia( Tab)? /u', '', $s);
        $s = preg_replace('/^ASUS ?/u', '', $s);
        $s = preg_replace('/^Ainol /u', '', $s);
        $s = preg_replace('/^Coolpad-?Coolpad/iu', 'Coolpad', $s);
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
        $s = preg_replace('/^Lenovo/u', 'Lenovo ', $s);
        $s = preg_replace('/^ZTE-/u', 'ZTE ', $s);
        $s = preg_replace('/^(LG)[ _\/]/u', '$1-', $s);
        $s = preg_replace('/^(HTC.+)\s[v|V][0-9.]+$/u', '$1', $s);
        $s = preg_replace('/^(HTC)[-\/]/u', '$1 ', $s);
        $s = preg_replace('/^(HTC)([A-Z][0-9][0-9][0-9])/u', '$1 $2', $s);
        $s = preg_replace('/^(Motorola MOT-|MOT-|Motorola[\s|-])/u', '', $s);
        $s = preg_replace('/^Moto([^\s])/u', '$1', $s);
        $s = preg_replace('/^(UTStar-)/u', '', $s);

        $s = preg_replace('/^VZW:/iu', '', $s);
        $s = preg_replace('/^(Swisscom|Vodafone)\/1.0\//iu', '', $s);
        $s = preg_replace('/-?(orange(-ls)?|vodafone|bouygues|parrot|Kust)$/iu', '', $s);
        $s = preg_replace('/[ -](Mozilla|Opera|Obigo|Java|PPC)$/iu', '', $s);
        $s = preg_replace('/ ?Build$/iu', '', $s);
        $s = preg_replace('/ \(compatible$/iu', '', $s);
        $s = preg_replace('/http:\/\/.+$/iu', '', $s);
        $s = preg_replace('/^\s+|\s+$/u', '', $s);
        $s = preg_replace('/\s+/u', ' ', $s);

        return $s;
    }
}
