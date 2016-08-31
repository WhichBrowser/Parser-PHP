<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Family;
use WhichBrowser\Model\Version;

trait Mobile
{
    private function detectMobile($ua)
    {
        /* Detect the type based on some common markers */
        $this->detectGenericMobile($ua);

        /* Look for specific manufacturers and models */
        $this->detectKin($ua);
        $this->detectNokia($ua);
        $this->detectSamsung($ua);

        /* Try to parse some generic methods to store device information */
        $this->detectGenericMobileModels($ua);
        $this->detectJapaneseMobileModels($ua);

        /* Try to find the model names based on id */
        $this->detectGenericMobileLocations($ua);
    }






    /* Generic markers */

    private function detectGenericMobile($ua)
    {
        if (preg_match('/(MIDP|CLDC|UNTRUSTED\/|3gpp-gba|[Ww][Aa][Pp]2.0|[Ww][Aa][Pp][ _-]?[Bb]rowser)/u', $ua)) {
            $this->data->device->type = Constants\DeviceType::MOBILE;
        }
    }


    /* Microsoft KIN */

    private function detectKin($ua)
    {
        if (preg_match('/KIN\.(One|Two) ([0-9.]*)/ui', $ua, $match)) {
            $this->data->os->name = 'Kin OS';
            $this->data->os->version = new Version([ 'value' => $match[2], 'details' => 2 ]);

            switch ($match[1]) {
                case 'One':
                    $this->data->device->manufacturer = 'Microsoft';
                    $this->data->device->model = 'Kin ONE';
                    $this->data->device->identified |= Constants\Id::MATCH_UA;
                    $this->data->device->generic = false;
                    break;

                case 'Two':
                    $this->data->device->manufacturer = 'Microsoft';
                    $this->data->device->model = 'Kin TWO';
                    $this->data->device->identified |= Constants\Id::MATCH_UA;
                    $this->data->device->generic = false;
                    break;
            }
        }
    }


    /* Nokia */

    private function detectNokia($ua)
    {
        if (isset($this->data->device->manufacturer)) {
            return;
        }

        if (preg_match('/Nokia[- \/]?([^\/\);]+)/ui', $ua, $match)) {

            if ($match[1] == 'Browser') {
                return;
            }

            $this->data->device->manufacturer = 'Nokia';
            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
            $this->data->device->identifier = $match[0];
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->generic = false;
            $this->data->device->type = Constants\DeviceType::MOBILE;

            if (!($this->data->device->identified & Constants\Id::MATCH_UA)) {
                $device = Data\DeviceModels::identify('asha', $this->data->device->model);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;

                    if (!isset($this->data->os->name) || $this->data->os->name != 'Nokia Asha Platform') {
                        $this->data->os->name = 'Nokia Asha Platform';
                        $this->data->os->version = new Version([ 'value' => '1.0' ]);

                        if (preg_match('/java_runtime_version=Nokia_Asha_([0-9_]+)[;\)]/u', $ua, $match)) {
                            $this->data->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
                        }
                    }
                }
            }

            if (!($this->data->device->identified & Constants\Id::MATCH_UA)) {
                $device = Data\DeviceModels::identify('s40', $this->data->device->model);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;

                    if (!isset($this->data->os->name) || $this->data->os->name != 'Series40') {
                        $this->data->os->name = 'Series40';
                        $this->data->os->version = null;
                    }
                }
            }

            if (!($this->data->device->identified & Constants\Id::MATCH_UA)) {
                $device = Data\DeviceModels::identify('symbian', $this->data->device->model);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;

                    if (!isset($this->data->os->name) || $this->data->os->name != 'Series60') {
                        $this->data->os->name = 'Series60';
                        $this->data->os->version = null;
                        $this->data->os->family = new Family([ 'name' => 'Symbian' ]);
                    }
                }
            }

            $this->identifyBasedOnIdentifier();
        }
    }


    /* Samsung */

    private function detectSamsung($ua)
    {
        if (isset($this->data->device->manufacturer)) {
            return;
        }

        if (preg_match('/(?:SAMSUNG; )?SAMSUNG ?[-\/]?([^;\/\)_,]+)/ui', $ua, $match)) {
            $this->data->device->manufacturer = 'Samsung';
            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
            $this->data->device->identifier = $match[0];
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->generic = false;
            $this->data->device->type = Constants\DeviceType::MOBILE;

            if ($this->data->isOS('Bada')) {
                $device = Data\DeviceModels::identify('bada', $this->data->device->model);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            if ($this->data->isOS('Series60')) {
                $device = Data\DeviceModels::identify('symbian', $this->data->device->model);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            if (!$this->data->os->isDetected()) {
                if (preg_match('/Jasmine\/([0-9.]*)/u', $ua, $match)) {
                    $version = $match[1];

                    $device = Data\DeviceModels::identify('touchwiz', $this->data->device->model);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                        $this->data->os->name = 'Touchwiz';

                        switch ($version) {
                            case '0.8':
                                $this->data->os->version = new Version([ 'value' => '1.0' ]);
                                break;
                            case '1.0':
                                $this->data->os->version = new Version([ 'value' => '2.0', 'alias' => '2.0 or earlier' ]);
                                break;
                        }
                    }
                }

                if (preg_match('/(?:Dolfin\/([0-9.]*)|Browser\/Dolfin([0-9.]*))/u', $ua, $match)) {
                    $version = !empty($match[1]) ? $match[1] : $match[2];

                    $device = Data\DeviceModels::identify('bada', $this->data->device->model);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                        $this->data->os->name = 'Bada';

                        switch ($version) {
                            case '2.0':
                                $this->data->os->version = new Version([ 'value' => '1.0' ]);
                                break;
                            case '2.2':
                                $this->data->os->version = new Version([ 'value' => '1.2' ]);
                                break;
                        }
                    } else {
                        $device = Data\DeviceModels::identify('touchwiz', $this->data->device->model);
                        if ($device->identified) {
                            $device->identified |= $this->data->device->identified;
                            $this->data->device = $device;
                            $this->data->os->name = 'Touchwiz';

                            switch ($version) {
                                case '1.0':
                                    $this->data->os->version = new Version([ 'value' => '2.0', 'alias' => '2.0 or earlier' ]);
                                    break;
                                case '1.5':
                                    $this->data->os->version = new Version([ 'value' => '2.0' ]);
                                    break;
                                case '2.0':
                                    $this->data->os->version = new Version([ 'value' => '3.0' ]);
                                    break;
                            }
                        }
                    }
                }
            }

            $this->identifyBasedOnIdentifier();
        }
    }


    /* Generic models */

    private function detectGenericMobileModels($ua)
    {
        if ($this->data->device->identified & Constants\Id::PATTERN) {
            return;
        }

        if (isset($this->data->device->manufacturer)) {
            return;
        }

        if (!preg_match('/(T-Mobile|Danger|HPiPAQ|Acer|Amoi|AIRNESS|ASUS|BenQ|maui|ALCATEL|Bird|COOLPAD|CELKON|Coship|Cricket|DESAY|Diamond|dopod|Ericsson|FLY|GIONEE|Haier|HIKe|Hisense|HS|HTC|T[0-9]{4,4}|HUAWEI|Karbonn|KWC|KONKA|KTOUCH|K-Touch|Lenovo|Lephone|LG|Micromax|MOT|Nexian|NEC|NGM|OPPO|Panasonic|Pantech|Philips|Sagem|Sanyo|Sam|SEC|SGH|SCH|SIE|Sony|SE|SHARP|Spice|Tecno|T-smart|TCL|Tiphone|Toshiba|UTStar|Videocon|vk|Vodafone|Xiaomi|ZTE|WAP)/ui', $ua)) {
            return;
        }

        $this->data->device->identifyModel('/T-Mobile[_ ]([^\/;]+)/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'T-Mobile'
        ]);

        $this->data->device->identifyModel('/Danger hiptop ([0-9.]+)/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Danger',
            'model'         => 'Hiptop'
        ]);

        $this->data->device->identifyModel('/HP(iPAQ[0-9A-Za-z]+)\//u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'HP'
        ]);

        $this->data->device->identifyModel('/Acer[_-]?([^\s\/_]*)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Acer'
        ]);

        $this->data->device->identifyModel('/Amoi[ -]([^\s\/_]*)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Amoi'
        ]);

        $this->data->device->identifyModel('/AIRNESS-([^\/]*)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Airness'
        ]);

        $this->data->device->identifyModel('/ASUS-([^\/]*)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Asus'
        ]);

        $this->data->device->identifyModel('/BenQ[ -]([^\/]*)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'BenQ'
        ]);

        $this->data->device->identifyModel('/ maui ([a-z0-9]+)/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'BenQ',
            'model'         => function ($model) {
                return 'Maui ' . strtoupper($model);
            }
        ]);

        $this->data->device->identifyModel('/ALCATEL[_-]([^\/]*)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Alcatel',
            'model'         => function ($model) {
                if (preg_match('/^TRIBE ([^\s]+)/ui', $model, $match)) {
                    $model = 'One Touch Tribe ' . $match[1];
                } elseif (preg_match('/^ONE TOUCH ([^\s]*)/ui', $model, $match)) {
                    $model = 'One Touch ' . $match[1];
                } elseif (preg_match('/^OT[-\s]*([^\s]*)/ui', $model, $match)) {
                    $model = 'One Touch ' . $match[1];
                }

                return $model;
            }
        ]);

        $this->data->device->identifyModel('/Bird[ _\-\.]([^\/]*)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Bird'
        ]);

        $this->data->device->identifyModel('/(?:YL-|YuLong-)?COOLPAD([^\s]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Coolpad'
        ]);

        $this->data->device->identifyModel('/CELKON\.([^\s]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Celkon'
        ]);

        $this->data->device->identifyModel('/Coship ([^\s]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Coship'
        ]);

        $this->data->device->identifyModel('/Cricket-([^\s]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Cricket'
        ]);

        $this->data->device->identifyModel('/DESAY[ _]([^\s]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'DESAY'
        ]);

        $this->data->device->identifyModel('/Diamond_([^\s]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Diamond'
        ]);

        $this->data->device->identifyModel('/dopod[-_]?([^\s]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Dopod'
        ]);

        $this->data->device->identifyModel('/^Ericsson([^\/]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Ericsson'
        ]);

        $this->data->device->identifyModel('/^(R[0-9]{3,3}) [0-9\.]+ WAP/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Ericsson'
        ]);

        $this->data->device->identifyModel('/FLY_]?([^\s\/]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Fly'
        ]);

        $this->data->device->identifyModel('/GIONEE[-_ ]([^\s\/;]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Gionee'
        ]);

        $this->data->device->identifyModel('/GIONEE([A-Z0-9]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Gionee'
        ]);

        $this->data->device->identifyModel('/HIKe_([^\s]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'HIKe'
        ]);

        $this->data->device->identifyModel('/HAIER-([A-Z][0-9]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Haier'
        ]);

        $this->data->device->identifyModel('/Hisense[ -](?:HS-)?([^\s]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Hisense'
        ]);

        $this->data->device->identifyModel('/HS-([^\s]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Hisense'
        ]);

        $this->data->device->identifyModel('/HTC[\s_-]?([^\s\/\(\);][^\/\(\);]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'HTC'
        ]);

        $this->data->device->identifyModel('/(?:HTC_)?([A-Z0-9_]+_T[0-9]{4,4})/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'HTC'
        ]);

        $this->data->device->identifyModel('/HUAWEI[\s_-]?([^\/\)\()]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Huawei'
        ]);

        $this->data->device->identifyModel('/Karbonn ([a-z0-9]+(?: ?Star| ?Plus|\+)?)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Karbonn'
        ]);

        $this->data->device->identifyModel('/KWC-([^\s\/]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Kyocera'
        ]);

        $this->data->device->identifyModel('/KONKA[-_]?([^\s]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Konka'
        ]);

        $this->data->device->identifyModel('/TIANYU-KTOUCH\/([^\/]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'K-Touch'
        ]);

        $this->data->device->identifyModel('/K-Touch_?([^\/]*)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'K-Touch'
        ]);

        $this->data->device->identifyModel('/Lenovo[_-]?([^\/]*)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Lenovo'
        ]);

        $this->data->device->identifyModel('/Lephone_([^\/]*)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Lephone'
        ]);

        $this->data->device->identifyModel('/LGE?([A-Z]{2,2}[0-9]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'LG'
        ]);

        $this->data->device->identifyModel('/LGE?(?:\/|-|_)([^\s\)\-\[\/]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'LG'
        ]);

        $this->data->device->identifyModel('/LGE? ?([A-Z]*[0-9]+[A-Z]?)/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'LG'
        ]);

        $this->data->device->identifyModel('/Micromax([^\)]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Micromax'
        ]);

        $this->data->device->identifyModel('/^MOTO-?([^\/_]+)/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Motorola'
        ]);

        $this->data->device->identifyModel('/MOT-([^\/_\.]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Motorola'
        ]);

        $this->data->device->identifyModel('/Motorola-([^\s]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Motorola',
            'model'         => function ($model) {
                return strtoupper($model);
            }
        ]);

        $this->data->device->identifyModel('/Motorola[_ ]([^\/_;]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Motorola'
        ]);

        $this->data->device->identifyModel('/Moto([^\/\s_;r][^\/\s_;]*)/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Motorola'
        ]);

        $this->data->device->identifyModel('/Nexian([^\/_]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Nexian'
        ]);

        $this->data->device->identifyModel('/NEC-([^\/_]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'NEC'
        ]);

        $this->data->device->identifyModel('/NGM_([^\/_]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'NGM'
        ]);

        $this->data->device->identifyModel('/OPPO_([^\/_]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Oppo'
        ]);

        $this->data->device->identifyModel('/Panasonic-([^\/_]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Panasonic'
        ]);

        $this->data->device->identifyModel('/Pantech[-_]?([^\/_]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Pantech'
        ]);

        $this->data->device->identifyModel('/Philips ?([A-Z]?[0-9@]+[a-z]?)/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Philips'
        ]);

        $this->data->device->identifyModel('/PHILIPS-([a-zA-Z0-9@]+(?: [0-9]+)?)/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Philips',
            'model'         => function ($model) {
                if (preg_match('/Az@lis([0-9]{3,3})/ui', $model, $match)) {
                    return 'Az@lis ' . $match[1];
                }

                if (preg_match('/Fisio ?([0-9]{3,3})/ui', $model, $match)) {
                    return 'Fisio ' . $match[1];
                }

                return $model;
            }
        ]);

        $this->data->device->identifyModel('/SAGEM-([A-Z0-9\-]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Sagem'
        ]);

        $this->data->device->identifyModel('/Sanyo-([A-Z0-9]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Sanyo'
        ]);

        $this->data->device->identifyModel('/sam-([A-Z][0-9]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Samsung'
        ]);

        $this->data->device->identifyModel('/SEC-(SGH[A-Z][0-9]+)/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Samsung',
            'model'         => function ($model) {
                return str_replace('SGH', 'SGH-', $model);
            }
        ]);

        $this->data->device->identifyModel('/((?:SGH|SCH)-[A-Z][0-9]+)/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Samsung'
        ]);

        $this->data->device->identifyModel('/(GT-[A-Z][0-9]+[A-Z]?)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Samsung'
        ]);

        $this->data->device->identifyModel('/(?:Siemens |SIE-)([A-Z]+[0-9]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Siemens'
        ]);

        $this->data->device->identifyModel('/SIE-([0-9]{4,4}|[A-Z]{4,4})/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Siemens'
        ]);

        $this->data->device->identifyModel('/Sony ([A-Z0-9\-]+)/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Sony'
        ]);

        $this->data->device->identifyModel('/SE([A-Z][0-9]+[a-z])/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Sony Ericsson'
        ]);

        $this->data->device->identifyModel('/sony-ericsson ([A-Z][0-9]+[a-z])/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Sony Ericsson'
        ]);

        $this->data->device->identifyModel('/SonyE?ricsson ?([^\/\);]+)/iu', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Sony Ericsson',
            'model'         => function ($model) {
                if (preg_match('/^([A-Z]) ([0-9]+)$/u', $model, $match)) {
                    $model = $match[1] . $match[2];
                }

                if (preg_match('/^[a-z][0-9]+/u', $model)) {
                    $model[0] = strtoupper($model[0]);
                }

                return $model;
            }
        ]);

        $this->data->device->identifyModel('/SHARP[-_\/]([^\/\;]*)/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Sharp'
        ]);

        $this->data->device->identifyModel('/Spice\s([^\s]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Spice'
        ]);

        $this->data->device->identifyModel('/Spice\s?([A-Z][0-9]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Spice'
        ]);

        $this->data->device->identifyModel('/Tecno([^\/]*)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Tecno'
        ]);

        $this->data->device->identifyModel('/T-smart_([^\/]*)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'T-smart'
        ]);

        $this->data->device->identifyModel('/TCL[-_ ]([^\/\;\)]*)/ui', $ua, [
            'manufacturer'  => 'TCL'
        ]);

        $this->data->device->identifyModel('/Tiphone ([^\/]*)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'TiPhone'
        ]);

        $this->data->device->identifyModel('/Toshiba[-\/]([^\/-]*)/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Toshiba'
        ]);

        $this->data->device->identifyModel('/UTStar(?:com)?-([^\s\.\/;]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'UTStarcom'
        ]);


        $this->data->device->identifyModel('/vk-(vk[0-9]+)/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'VK Mobile',
            'model'         => function ($model) {
                return strtoupper($model);
            }
        ]);

        $this->data->device->identifyModel('/Videocon[-_ \/]([A-Z0-9\.]+)/iu', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Videocon'
        ]);

        $this->data->device->identifyModel('/Vodafone(?:[ _-]Chat)?[ _-]?([0-9]+)/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Vodafone'
        ]);

        $this->data->device->identifyModel('/Vodafone\/[0-9.]+\/(v[0-9]+)[^\/]*\//u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Vodafone'
        ]);

        $this->data->device->identifyModel('/Xiaomi[_]?([^\s]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'Xiaomi'
        ]);


        $this->data->device->identifyModel('/ZTE[-_\s]?([^\s\/\(\);,]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'manufacturer'  => 'ZTE',
            'model'         => function ($model) {
                return preg_match('/[A-Z]+[0-9]+/iu', $model) ? strtoupper($model) : $model;
            }
        ]);

        $this->identifyBasedOnIdentifier();
    }


    /* Japanese models */

    private function detectJapaneseMobileModels($ua)
    {
        if (isset($this->data->device->manufacturer)) {
            return;
        }

        if ($this->data->os->isFamily('Android')) {
            return;
        }

        /* Sometimes DoCoMo UA strings are (partially) encoded */

        if (preg_match('/^DoCoMo/u', $ua)) {
            $ua = preg_replace_callback(
                "#\\\x([0-9A-Fa-f]{2})#",
                function ($m) {
                    return chr(hexdec($m[1]));
                },
                $ua
            );
        }

        /* First identify it based on id */

        $model = null;
        $manufacturer = null;
        $carrier = null;
        $falsepositive = false;

        $ids = [
            'CA'    => 'Casio',
            'DL'    => 'Dell',
            'ER'    => 'Ericsson',
            'HT'    => 'HTC',
            'HW'    => 'Huawei',
            'IA'    => 'Inventec',
            'JR'    => 'JRC',
            'KO'    => 'Kokusai',
            'LC'    => 'Longcheer',
            'NK'    => 'Nokia',
            'NM'    => 'Nokia',
            'KE'    => 'KES',
            'SA'    => 'Sanyo',
            'SC'    => 'Samsung',
            'SS'    => 'Samsung',
            'SH'    => 'Sharp',
            'SE'    => 'Sony Ericsson',
            'SO'    => 'Sony',
            'ZT'    => 'ZTE',
            'F'     => 'Fujitsu',
            'D'     => 'Mitsubishi',
            'J'     => 'JRC',
            'K'     => 'Kyocera',
            'L'     => 'LG',
            'M'     => 'Motorola',
            'N'     => 'NEC',
            'P'     => 'Panasonic',
            'R'     => 'JRC',
            'T'     => 'Toshiba',
            'Z'     => 'ZTE',
        ];

        if (preg_match('/(?:^|[\s\/\-\(;])((' . implode('|', array_keys($ids)) . ')[0-9]{3,3}[a-z]+[A-Z]*)/u', $ua, $match)) {
            $model = $match[1];
            $manufacturer = $match[2];
            $carrier = 'DoCoMo';
        }

        if (preg_match('/(?:; |\()((' . implode('|', array_keys($ids)) . ')[0-9]{2,2}[A-Z][0-9]?)[\);]/u', $ua, $match)) {
            $model = $match[1];
            $manufacturer = $match[2];
            $carrier = 'DoCoMo';
        }

        if (preg_match('/DoCoMo\/[0-9].0 ((' . implode('|', array_keys($ids)) . ')[0-9]{2,2}[A-Z][0-9]?)(?:\s?\(|$)/u', $ua, $match)) {
            $model = $match[1];
            $manufacturer = $match[2];
            $carrier = 'DoCoMo';
        }

        if (preg_match('/DoCoMo\/[0-9].0[\/\s](?:MST_v_)?((' . implode('|', array_keys($ids)) . ')[1-9][0-9]{3,3}[A-Z]?)/u', $ua, $match)) {
            $model = $match[1];
            $manufacturer = $match[2];
            $carrier = 'DoCoMo';
        }

        if (preg_match('/[\/\(]([SHW][0-9]{2,2}(' . implode('|', array_keys($ids)) . '))[\/;]/u', $ua, $match)) {
            $model = $match[1];
            $manufacturer = $match[2];
            $carrier = 'EMOBILE';
        }

        if (preg_match('/\) ([SHW][0-9]{2,2}(' . implode('|', array_keys($ids)) . '))$/u', $ua, $match)) {
            $model = $match[1];
            $manufacturer = $match[2];
            $carrier = 'EMOBILE';
        }

        if (preg_match('/[\s\/\-\(;](J-(' . implode('|', array_keys($ids)) . ')[0-9]{2,2})/u', $ua, $match)) {
            $model = $match[1];
            $manufacturer = $match[2];
            $carrier = 'Softbank';
        }

        if (preg_match('/(?:^|; |\/)([0-9]{3,3}(' . implode('|', array_keys($ids)) . '))[eps]?[\/\)]/u', $ua, $match)) {
            $model = $match[1];
            $manufacturer = $match[2];
            $carrier = 'Softbank';
        }

        if (preg_match('/\(([0-9]{3,3}(' . implode('|', array_keys($ids)) . ')[eps]?);SoftBank/u', $ua, $match)) {
            $model = $match[1];
            $manufacturer = $match[2];
            $carrier = 'Softbank';
        }

        if (preg_match('/(?:^|[\s\/\(;])((V|DM|W|WS|WX)[0-9]{2,3}(' . implode('|', array_keys($ids)) . '))/u', $ua, $match)) {
            $model = $match[1];
            $manufacturer = $match[3];

            switch ($match[2]) {
                case 'V':
                    $carrier = 'Softbank';
                    break;
                case 'DM':
                    $carrier = 'Disney Mobile';
                    break;
                case 'W':
                case 'WS':
                case 'WX':
                    $carrier = 'Willcom';
                    break;
            }
        }

        if (preg_match('/(AH-(' . implode('|', array_keys($ids)) . ')[1-9][0-9]{3,3}[A-Z]?)/u', $ua, $match)) {
            $model = $match[1];
            $manufacturer = $match[2];
            $carrier = 'Willcom';
        }

        if (in_array($model, [ '360SE' ])) {
            $falsepositive = true;
        }

        if (!$falsepositive && !empty($model) && !empty($manufacturer)) {
            $this->data->device->reset([
                'type'      => Constants\DeviceType::MOBILE,
                'model'     => $model,
                'carrier'   => $carrier
            ]);

            if (array_key_exists($manufacturer, $ids)) {
                $this->data->device->manufacturer = $ids[$manufacturer];
            }

            $this->data->device->identified |= Constants\Id::PATTERN;

            /* Set flags for MOAP */

            switch ($model) {
                case 'F06B':
                case 'F07B':
                case 'F08B':
                case 'SH07B':
                    $this->data->os->reset([ 'family' => new Family([ 'name' => 'Symbian' ]) ]);
                    $this->data->device->flag = Constants\Flag::MOAPS;
                    break;
            }

            return;
        }

        /* Then KDDI model number */

        $ids = [
            'CA'    => 'Casio',
            'DE'    => 'Denso',
            'PT'    => 'Pantech',
            'SA'    => 'Sanyo',
            'ST'    => 'Sanyo',
            'SH'    => 'Sharp',
            'H'     => 'Hitachi',
            'K'     => 'Kyocera',
            'P'     => 'Panasonic',
            'S'     => 'Sony Ericsson',
            'T'     => 'Toshiba'
        ];

        if (preg_match('/(?:^|KDDI-)(W[0-9]{2,2}(' . implode('|', array_keys($ids)) . '))[;\)\s\/]/u', $ua, $match)) {
            $model = $match[1];
            $manufacturer = $match[2];

            $this->data->device->reset([
                'type'      => Constants\DeviceType::MOBILE,
                'model'     => $model,
                'carrier'   => 'au'
            ]);

            if (array_key_exists($manufacturer, $ids)) {
                $this->data->device->manufacturer = $ids[$manufacturer];
            }

            $this->data->device->identified |= Constants\Id::PATTERN;
            return;
        }

        /* Then identify it based on KDDI id */

        $ids = [
            'CA'    => 'Casio',
            'DN'    => 'Denso',
            'ER'    => 'Ericsson',
            'FJ'    => 'Fujitsu',
            'HI'    => 'Hitachi',
            'KC'    => 'Kyocera',
            'MA'    => 'Panasonic',
            'MI'    => 'Mitsubishi',
            'PT'    => 'Pantech',
            'SA'    => 'Sanyo',
            'ST'    => 'Sanyo',
            'SY'    => 'Sanyo',
            'SH'    => 'Sharp',
            'SN'    => 'Sony Ericsson',
            'TS'    => 'Toshiba'
        ];

        if (preg_match('/(?:^|KDDI-|UP\. ?Browser\/[0-9\.]+-|; )((' . implode('|', array_keys($ids)) . ')(?:[0-9][0-9]|[A-Z][0-9]|[0-9][A-Z]))($|[;\)\s])/ui', $ua, $match)) {
            $model = strtoupper($match[1]);
            $manufacturer = strtoupper($match[2]);
            $falsepositive = false;

            if (in_array($model, [ 'MAM2', 'MAM3' ])) {
                $falsepositive = true;
            }

            if (!$falsepositive) {
                $this->data->device->reset([
                    'type'      => Constants\DeviceType::MOBILE,
                    'model'     => $model,
                    'carrier'   => 'au'
                ]);

                if (array_key_exists($manufacturer, $ids)) {
                    $this->data->device->manufacturer = $ids[$manufacturer];

                    $device = Data\DeviceModels::identify('kddi', $model);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $device->carrier = 'au';
                        $this->data->device = $device;
                    }
                }

                $this->data->device->identified |= Constants\Id::PATTERN;
                return;
            }
        }


        /* Finally identify it based on carrier */

        $this->data->device->identifyModel('/\(([A-Z]+[0-9]+[A-Z])[^;]*; ?FOMA/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'carrier'       => 'DoCoMo'
        ]);

        $this->data->device->identifyModel('/\(FOMA ([^;]+)+;/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'carrier'       => 'DoCoMo'
        ]);

        $this->data->device->identifyModel('/DoCoMo\/[0-9].0[\/\s]([0-9A-Z]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'carrier'       => 'DoCoMo'
        ]);

        $this->data->device->identifyModel('/NTTDoCoMo ([0-9A-Z]+)/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'carrier'       => 'DoCoMo'
        ]);

        $this->data->device->identifyModel('/J-PHONE\/[^\/]+\/([^\/_]+)/u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'carrier'       => 'Softbank'
        ]);

        $this->data->device->identifyModel('/SoftBank\/[^\/]+\/([^\/]+)\//u', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'carrier'       => 'Softbank'
        ]);

        $this->data->device->identifyModel('/Vodafone\/[0-9.]+\/V([0-9]+[A-Z]+)[^\/]*\//ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'carrier'       => 'Softbank'
        ]);

        $this->data->device->identifyModel('/(KDDI-[^\s\)\.;]{4,})/ui', $ua, [
            'type'          => Constants\DeviceType::MOBILE,
            'carrier'       => 'au'
        ]);


        if (!empty($this->data->device->model)) {
            $this->identifyBasedOnId($this->data->device->model);
        }
    }



    /* Device models not identified by a prefix */

    private function detectGenericMobileLocations($ua)
    {
        if ($this->data->device->identified & Constants\Id::PATTERN) {
            return;
        }

        $candidates = [];

        if (preg_match('/^([a-z0-9\.\_\+\/ ]+)_TD\//iu', $ua, $match)) {
            array_push($candidates, $match[1]);
        }

        if (preg_match('/^([a-z0-9\_]+)/iu', $ua, $match)) {
            array_push($candidates, $match[1]);
        }

        if (preg_match('/[; ]\(?([^\s\)\/;]+)[^\s;]*$/u', $ua, $match)) {
            array_push($candidates, $match[1]);
        }

        if (preg_match('/^([^\/\)]+)/u', $ua, $match)) {
            array_push($candidates, $match[1]);
        }

        if (preg_match('/MobilePhone ([^\/\)]+)/u', $ua, $match)) {
            array_push($candidates, $match[1]);
        }

        $candidates = array_diff($candidates, [
            'Mobile', 'Safari', 'Version', 'GoogleTV', 'WebKit', 'NetFront',
            'Microsoft', 'ZuneWP7', 'Firefox', 'UCBrowser', 'IEMobile', 'Touch',
            'Fennec', 'Minimo', 'Gecko', 'TizenBrowser', 'Browser', 'sdk',
            'Mini', 'Fennec', 'Darwin', 'Puffin', 'Tanggula', 'Edge',
            'QHBrowser', 'BonEcho', 'Iceweasel', 'Midori', 'BeOS', 'UBrowser',
            'SeaMonkey', 'Model', 'Silk-Accelerated=true', 'Configuration',
            'UNTRUSTED', 'OSRE', 'Dolfin', 'Surf', 'Epiphany', 'Konqueror',
            'Presto', 'OWB', 'PmWFx', 'Netscape', 'Netscape6', 'Navigator',
            'Opera', 'Mozilla', 'BrightSign', 'Motorola', 'UCWEB',
            'NativeOperaMini', 'OperaMini', 'SogouMobileBrowser', 'iLunascape',
            'Sleipnir', 'MobileSafari', 'MQQBrowser', 'BREW', '?',
            'Maxthon', '360%20Browser', 'OPR', 'CFNetwork', 'JUC', 'Skyfire',
            'UP.Browser', 'DolphinHDCN', 'NintendoBrowser', 'NCSA',
            'NCSA Mosaic', 'NCSA_Mosaic', 'U', 'NetFrontNX', 'QtWebKit',
            'HtmlRenderer', 'HbbTV', 'WebAppManager', 'SmartTV', 'UPLUSTVBROWSER',
            'LG Browser', 'LG', 'LGSmartTV', 'OBIGO-T10', 'Linux', 'DLNADOC',
            'Aplix_SANYO_browser', 'Japanese', 'WebBrowser', 'Freetime',
            'OreganMediaBrowser', 'NETRANGEMMH', 'http:', 'bxapi', 'Kodi',
            'XBMC', 'KreaTVWebKit', 'MachBlue', 'Espial', 'TouchPad',
            'sharp', 'sharp wd browser', 'sharp pda browser', 'browser',
            'Palmscape', 'CorePlayer', 'Xiino', 'SONY', 'WorldTALK', 'TOPS',
            'Windows', 'Microsoft Pocket Internet Explorer', 'Explorer',
            'CE', 'Desktop', 'Maemo Browser', 'Maemo', 'baidubrowser',
            'Mercury', 'BREW-Applet', 'ucweb-squid', 'iSurf', '3gpp-gba',
            'InfoPath.2', 'UC', 'J2ME', 'IUC', 'AveFront', 'MMP', 'BaiduHD',
            '360%20Lite', '360', 'AppleWebKit', 'Instagram', 'FBOP',
            'Nuanti', 'NuantiMeta', 'Silk', 'VTE', 'DreamKey', 'DreamPassport',
            'Aplix_SEGASATURN_browser', 'NWF', 'Bunjalloo', 'libwww',
            'Inferno', 'NEXT', 'I', 'Microsoft Internet Explorer', 'MAM3',
            'MAM2', '360SE', 'Ziepod', 'Vista', 'XP', 'Links', 'Syllable',
            'sun4m', 'sun4c', 'sun4u', 'i86pc', 'X11', 'NaenaraBrowser',
            'QuickTime', 'IBM', 'QQBrowser', 'x86_64', 'i686', 'i386', 'Chrome',
            'TenFourFox', 'Swing', 'NetFrontBrowserNX', 'Mac_PowerPC',
            'NetCast.TV-2012', 'NetCast.TV-2011', 'NetCast.Media-2011',
            'PaleMoon', 'Fedora', 'SUSE', 'iCab', 'Googlebot', 'Pixi',
            'Pre', 'ELinks', 'developer', 'beta', 'BingPreview', 'IBrowse', '+http:'
        ]);

        $candidates = array_unique($candidates);

        foreach ($candidates as $i => $id) {
            if (preg_match('/^[0-9\.]+$/u', $id)) {
                unset($candidates[$i]);
                continue;
            }

            if (preg_match('/^[0-9]+[xX][0-9]+$/u', $id)) {
                unset($candidates[$i]);
                continue;
            }

            if (preg_match('/^\[?[a-z]{2,2}(\-[a-z]{2,2})?\]?$/ui', $id)) {
                unset($candidates[$i]);
                continue;
            }

            if (strlen($id) < 4) {
                unset($candidates[$i]);
                continue;
            }
        }

        foreach ($candidates as $i => $id) {
            $this->identifyBasedOnIdUsingOs($id);

            if ($this->data->device->identified & Constants\Id::MATCH_UA) {
                return;
            }
        }
    }

    function identifyBasedOnIdentifier()
    {
        if ($this->data->device->identified & Constants\Id::MATCH_UA) {
            return;
        }

        $ids = [];

        if (!empty($this->data->device->identifier)) {
            $ids[] = $this->data->device->identifier;
        }

        if (!empty($this->data->device->model)) {
            $ids[] = $this->data->device->model;
        }

        foreach ($ids as $i => $id) {
            $this->identifyBasedOnIdUsingOs($id);

            if ($this->data->device->identified & Constants\Id::MATCH_UA) {
                return;
            }
        }

        foreach ($ids as $i => $id) {
            $this->identifyBasedOnId($id);

            if ($this->data->device->identified & Constants\Id::MATCH_UA) {
                return;
            }
        }
    }

    function identifyBasedOnIdUsingOs($id)
    {
        switch ($this->data->os->getFamily()) {

            case 'Android':
                $device = Data\DeviceModels::identify('android', $id);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
                break;

            case 'Brew':
                $device = Data\DeviceModels::identify('brew', $id);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
                break;

            case 'Symbian':
                $device = Data\DeviceModels::identify('symbian', $id);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
                break;

            case 'Windows':
            case 'Windows CE':
            case 'Windows Mobile':
                $device = Data\DeviceModels::identify('wm', $id);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;

                    if (!$this->data->isOs('Windows Mobile')) {
                        $this->data->os->reset([
                            'name' => 'Windows Mobile'
                        ]);
                    }
                }
                break;

            default:
                $device = Data\DeviceModels::identify('feature', $id);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
                break;
        }
    }

    function identifyBasedOnId($id)
    {
        if ($this->data->device->type != 'mobile') {
            return;
        }

        if (!($this->data->device->identified & Constants\Id::MATCH_UA)) {
            $device = Data\DeviceModels::identify('brew', $id);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;

                if (!in_array($this->data->os->name, [ 'Brew', 'Brew MP' ])) {
                    $this->data->os->name = 'Brew';
                }
            }
        }

        if (!($this->data->device->identified & Constants\Id::MATCH_UA)) {
            $device = Data\DeviceModels::identify('bada', $id);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
                $this->data->os->name = 'Bada';
            }
        }

        if (!($this->data->device->identified & Constants\Id::MATCH_UA)) {
            $device = Data\DeviceModels::identify('touchwiz', $id);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
                $this->data->os->name = 'Touchwiz';
            }
        }

        if (!($this->data->device->identified & Constants\Id::MATCH_UA)) {
            $device = Data\DeviceModels::identify('symbian', $id);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
                $this->data->os->reset([
                    'family' => new Family([ 'name' => 'Symbian' ])
                ]);
            }
        }

        if (!($this->data->device->identified & Constants\Id::MATCH_UA)) {
            $device = Data\DeviceModels::identify('wm', $id);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
                $this->data->os->name = 'Windows Mobile';
            }
        }

        if (!($this->data->device->identified & Constants\Id::MATCH_UA)) {
            $device = Data\DeviceModels::identify('feature', $id);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
            }
        }
    }
}
