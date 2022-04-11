<?php

namespace WhichBrowser\Analyser;

use WhichBrowser\Constants;
use WhichBrowser\Model\Family;
use WhichBrowser\Model\Using;
use WhichBrowser\Model\Version;

trait Derive
{
    private function &deriveInformation()
    {
        if (isset($this->data->device->flag)) {
            $this->deriveBasedOnDeviceFlag();
        }

        if (isset($this->data->os->name)) {
            $this->deriveBasedOnOperatingSystem();
        }

        if (isset($this->data->browser->name)) {
            $this->deriveOperaDevices();
        }

        if (isset($this->data->browser->name)) {
            $this->deriveFirefoxOS();
        }

        if (isset($this->data->browser->name)) {
            $this->deriveTrident();
            $this->deriveOperaRenderingEngine();
            $this->deriveOmniWebRenderingEngine();
            $this->deriveNetFrontRenderingEngine();
        }

        return $this;
    }




    private function &deriveDeviceSubType()
    {
        if ($this->data->device->type == 'mobile' && empty($this->data->device->subtype)) {
            $this->data->device->subtype = 'feature';

            if (in_array($this->data->os->getName(), [ 'Android', 'Bada', 'BlackBerry', 'BlackBerry OS', 'Firefox OS', 'iOS', 'iPhone OS', 'Kin OS', 'Maemo', 'MeeGo', 'Palm OS', 'Sailfish', 'Series60', 'Series80', 'Tizen', 'Ubuntu Touch', 'Windows Mobile', 'Windows Phone', 'webOS' ])) {
                $this->data->device->subtype = 'smart';
            }

            if (isset($this->data->os->name) && in_array($this->data->os->name, [ 'Windows Phone' ])) {
                $this->data->device->subtype = 'smart';
            }

            if (isset($this->data->os->family) && in_array($this->data->os->family->getName(), [ 'Android' ])) {
                $this->data->device->subtype = 'smart';
            }
        }

        return $this;
    }


    private function deriveOmniWebRenderingEngine()
    {
        if ($this->data->isBrowser('OmniWeb')) {
            $version = $this->data->browser->getVersion();

            if ($version < 5) {
                $this->data->engine->reset();
            }

            if ($version >= 5 && $version < 5.5 && !$this->data->isEngine('WebCore')) {
                $this->data->engine->reset([ 'name' => 'WebCore' ]);
            }

            if ($version >= 5.5 && !$this->data->isEngine('WebKit')) {
                $this->data->engine->reset([ 'name' => 'WebKit' ]);
            }
        }
    }


    private function deriveOperaRenderingEngine()
    {
        if ($this->data->isBrowser('Opera') || $this->data->isBrowser('Opera Mobile')) {
            $version = $this->data->browser->getVersion();

            if ($version >= 3.5 && $version < 7 && !$this->data->isEngine('Electra')) {
                $this->data->engine->reset([ 'name' => 'Electra' ]);
            }

            if ($version >= 7 && $version < 13 && !$this->data->isEngine('Presto')) {
                $this->data->engine->reset([ 'name' => 'Presto' ]);
            }
        }

        if ($this->data->isBrowser('Opera Mini') && !$this->data->isOs('iOS') && !$this->data->isEngine('Presto')) {
            $this->data->engine->reset([ 'name' => 'Presto' ]);
        }
    }


    private function deriveNetFrontRenderingEngine()
    {
        if ($this->data->isBrowser('NetFront') && !$this->data->isEngine('NetFront')) {
            $this->data->engine->reset([ 'name' => 'NetFront' ]);
        }
    }

    private function deriveTrident()
    {
        if ($this->data->isType('desktop') && $this->data->isBrowser('Internet Explorer') && !$this->data->engine->getName()) {
            if ($this->data->isBrowser('Internet Explorer', '>=', 4)) {
                $this->data->engine->set([ 'name' => 'Trident' ]);
            }
        }

        if ($this->data->isMobile() && $this->data->isBrowser('Mobile Internet Explorer') && !$this->data->engine->getName()) {
            if ($this->data->isBrowser('Mobile Internet Explorer', '=', 6)) {
                $this->data->engine->set([ 'name' => 'Trident' ]);
            }

            if ($this->data->isBrowser('Mobile Internet Explorer', '=', 7)) {
                $this->data->engine->set([ 'name' => 'Trident', 'version' => new Version([ 'value' => '3.1' ]) ]);
            }
        }
    }


    private function deriveFirefoxOS()
    {
        if (in_array($this->data->browser->name, [ 'Firefox Mobile', 'Servo Nightly Build' ]) && !isset($this->data->os->name)) {
            $this->data->os->name = 'Firefox OS';
        }

        if (isset($this->data->os->name) && $this->data->os->name == 'Firefox OS' && $this->data->engine->name == 'Gecko') {
            switch ($this->data->engine->getVersion()) {
                case '18.0':
                    $this->data->os->version = new Version([ 'value' => '1.0.1' ]);
                    break;
                case '18.1':
                    $this->data->os->version = new Version([ 'value' => '1.1' ]);
                    break;
                case '26.0':
                    $this->data->os->version = new Version([ 'value' => '1.2' ]);
                    break;
                case '28.0':
                    $this->data->os->version = new Version([ 'value' => '1.3' ]);
                    break;
                case '30.0':
                    $this->data->os->version = new Version([ 'value' => '1.4' ]);
                    break;
                case '32.0':
                    $this->data->os->version = new Version([ 'value' => '2.0' ]);
                    break;
                case '34.0':
                    $this->data->os->version = new Version([ 'value' => '2.1' ]);
                    break;
                case '37.0':
                    $this->data->os->version = new Version([ 'value' => '2.2' ]);
                    break;
                case '44.0':
                    $this->data->os->version = new Version([ 'value' => '2.5' ]);
                    break;
            }
        }
    }


    private function deriveOperaDevices()
    {
        if ($this->data->browser->name == 'Opera' && $this->data->device->type == Constants\DeviceType::TELEVISION) {
            $this->data->browser->name = 'Opera Devices';
            $this->data->browser->version = null;

            if ($this->data->engine->getName() == 'Presto') {
                $data = [
                    '2.12'  => '3.4',
                    '2.11'  => '3.3',
                    '2.10'  => '3.2',
                    '2.9'   => '3.1',
                    '2.8'   => '3.0',
                    '2.7'   => '2.9',
                    '2.6'   => '2.8',
                    '2.4'   => '10.3',
                    '2.3'   => '10',
                    '2.2'   => '9.7',
                    '2.1'   => '9.6'
                ];

                $key = implode('.', array_slice(explode('.', $this->data->engine->getVersion()), 0, 2));

                if (isset($data[$key])) {
                    $this->data->browser->version = new Version([ 'value' => $data[$key] ]);
                } else {
                    unset($this->data->browser->version);
                }
            }

            $this->data->os->reset();
        }
    }



    private function deriveBasedOnDeviceFlag()
    {
        $flag = $this->data->device->flag;

        if ($flag == Constants\Flag::NOKIAX) {
            $this->data->os->name = 'Nokia X Platform';
            $this->data->os->family = new Family([ 'name' => 'Android' ]);

            unset($this->data->os->version);
            unset($this->data->device->flag);
        }

        if ($flag == Constants\Flag::FIREOS) {
            $this->data->os->name = 'FireOS';
            $this->data->os->family = new Family([ 'name' => 'Android' ]);

            if (isset($this->data->os->version) && isset($this->data->os->version->value)) {
                switch ($this->data->os->version->value) {
                    case '2.3.3':
                    case '2.3.4':
                        $this->data->os->version = new Version([ 'value' => '1' ]);
                        break;
                    case '4.0.3':
                        $this->data->os->version = new Version([ 'value' => '2' ]);
                        break;
                    case '4.2.2':
                        $this->data->os->version = new Version([ 'value' => '3' ]);
                        break;
                    case '4.4.2':
                        $this->data->os->version = new Version([ 'value' => '4' ]);
                        break;
                    case '4.4.3':
                        $this->data->os->version = new Version([ 'value' => '4.5' ]);
                        break;
                    case '5.1.1':
                        $this->data->os->version = new Version([ 'value' => '5' ]);
                        break;
                    default:
                        unset($this->data->os->version);
                        break;
                }
            }

            if ($this->data->isBrowser('Chrome')) {
                $this->data->browser->reset();
                $this->data->browser->using = new Using([ 'name' => 'Amazon WebView' ]);
            }

            if ($this->data->browser->isUsing('Chromium WebView')) {
                $this->data->browser->using = new Using([ 'name' => 'Amazon WebView' ]);
            }

            unset($this->data->device->flag);
        }

        if ($flag == Constants\Flag::GOOGLETV) {
            $this->data->os->name = 'Google TV';
            $this->data->os->family = new Family([ 'name' => 'Android' ]);

            unset($this->data->os->version);
            unset($this->data->device->flag);
        }

        if ($flag == Constants\Flag::ANDROIDTV) {
            $this->data->os->name = 'Android TV';
            $this->data->os->family = new Family([ 'name' => 'Android' ]);
            unset($this->data->device->flag);
            unset($this->data->device->series);
        }

        if ($flag == Constants\Flag::ANDROIDWEAR) {
            $this->data->os->name = 'Android Wear';
            $this->data->os->family = new Family([ 'name' => 'Android' ]);
            unset($this->data->os->version);
            unset($this->data->device->flag);

            if ($this->data->browser->isUsing('Chrome Content Shell')) {
                $this->data->browser->name = 'Wear Internet Browser';
                $this->data->browser->using = null;
            }
        }

        if ($flag == Constants\Flag::GOOGLEGLASS) {
            $this->data->os->family = new Family([ 'name' => 'Android' ]);
            unset($this->data->os->name);
            unset($this->data->os->version);
            unset($this->data->device->flag);
        }

        if ($flag == Constants\Flag::UIQ) {
            unset($this->data->device->flag);

            if (!$this->data->isOs('UIQ')) {
                $this->data->os->name = 'UIQ';
                unset($this->data->os->version);
            }
        }

        if ($flag == Constants\Flag::S60) {
            unset($this->data->device->flag);

            if (!$this->data->isOs('Series60')) {
                $this->data->os->name = 'Series60';
                unset($this->data->os->version);
            }
        }

        if ($flag == Constants\Flag::MOAPS) {
            unset($this->data->device->flag);
            $this->data->os->name = 'MOAP(S)';
            unset($this->data->os->version);
        }
    }

    private function deriveBasedOnOperatingSystem()
    {
        /* Derive the default browser on Windows Mobile */

        if ($this->data->os->name == 'Windows Mobile' && $this->data->isBrowser('Internet Explorer')) {
            $this->data->browser->name = 'Mobile Internet Explorer';
        }

        /* Derive the default browser on Android */

        if ($this->data->os->name == 'Android' && !isset($this->data->browser->using) && !isset($this->data->browser->name) && $this->data->browser->stock) {
            $this->data->browser->name = 'Android Browser';
        }

        /* Derive the default browser on Google TV */

        if ($this->data->os->name == 'Google TV' && !isset($this->data->browser->name) && $this->data->browser->stock) {
            $this->data->browser->name = 'Chrome';
        }

        /* Derive the default browser on BlackBerry */

        if ($this->data->os->name == 'BlackBerry' && !isset($this->data->browser->name) && $this->data->browser->stock) {
            $this->data->browser->name = 'BlackBerry Browser';
            $this->data->browser->hidden = true;
        }

        if ($this->data->os->name == 'BlackBerry OS' && !isset($this->data->browser->name) && $this->data->browser->stock) {
            $this->data->browser->name = 'BlackBerry Browser';
            $this->data->browser->hidden = true;
        }

        if ($this->data->os->name == 'BlackBerry Tablet OS' && !isset($this->data->browser->name) && $this->data->browser->stock) {
            $this->data->browser->name = 'BlackBerry Browser';
            $this->data->browser->hidden = true;
        }

        /* Derive the default browser on Tizen */

        if ($this->data->os->name == 'Tizen' && !isset($this->data->browser->name) && $this->data->browser->stock && in_array($this->data->device->type, [ Constants\DeviceType::MOBILE, Constants\DeviceType::APPLIANCE ])) {
            $this->data->browser->name = 'Samsung Browser';
        }

        /* Derive the default browser on Aliyun OS */

        if ($this->data->os->name == 'Aliyun OS' && !isset($this->data->browser->using) && !isset($this->data->browser->name) && $this->data->browser->stock) {
            $this->data->browser->name = 'Aliyun Browser';
        }

        if ($this->data->os->name == 'Aliyun OS' && $this->data->browser->isUsing('Chrome Content Shell')) {
            $this->data->browser->name = 'Aliyun Browser';
            $this->data->browser->using = null;
            $this->data->browser->stock = true;
        }

        if ($this->data->os->name == 'Aliyun OS' && $this->data->browser->stock) {
            $this->data->browser->hidden = true;
        }

        /* Derive OS/2 nickname */

        if ($this->data->os->name == 'OS/2') {
            if (!empty($this->data->os->version)) {
                if ($this->data->os->version->is('>', '2')) {
                    $this->data->os->version->nickname = 'Warp';
                }
            }
        }

        /* Derive HP TouchPad based on webOS and tablet */

        if ($this->data->os->name == 'webOS' && $this->data->device->type == Constants\DeviceType::TABLET) {
            $this->data->device->manufacturer = 'HP';
            $this->data->device->model = 'TouchPad';
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }

        /* Derive Windows 10 Mobile edition */

        if ($this->data->os->name == 'Windows Phone') {
            if (!empty($this->data->os->version)) {
                if ($this->data->os->version->is('=', '10')) {
                    $this->data->os->alias = 'Windows';
                    $this->data->os->edition = 'Mobile';
                    $this->data->os->version->alias = '10';
                }
            }
        }

        /* Derive manufacturer and model based on MacOS or OS X */

        if ($this->data->os->name == 'OS X' || $this->data->os->name == 'Mac OS') {
            if (empty($this->data->device->model)) {
                $this->data->device->manufacturer = 'Apple';
                $this->data->device->model = 'Macintosh';
                $this->data->device->identified |= Constants\Id::INFER;
                $this->data->device->hidden = true;
            }
        }

        /* Derive manufacturer and model based on MacOS or OS X */

        if ($this->data->os->name == 'iOS') {
            if (empty($this->data->device->model)) {
                $this->data->device->manufacturer = 'Apple';
                $this->data->device->identified |= Constants\Id::INFER;
                $this->data->device->hidden = true;
            }
        }

        /* Derive iOS and OS X aliases */

        if ($this->data->os->name == 'iOS') {
            if (!empty($this->data->os->version)) {
                if ($this->data->os->version->is('<', '4')) {
                    $this->data->os->alias = 'iPhone OS';
                }
            }
        }

        if ($this->data->os->name == 'OS X') {
            if (!empty($this->data->os->version)) {
                if ($this->data->os->version->is('<', '10.7')) {
                    $this->data->os->alias = 'Mac OS X';
                }

                if ($this->data->os->version->is('>=', '10.12')) {
                    $this->data->os->alias = 'macOS';
                }

                if ($this->data->os->version->is('10.7')) {
                    $this->data->os->version->nickname = 'Lion';
                }

                if ($this->data->os->version->is('10.8')) {
                    $this->data->os->version->nickname = 'Mountain Lion';
                }

                if ($this->data->os->version->is('10.9')) {
                    $this->data->os->version->nickname = 'Mavericks';
                }

                if ($this->data->os->version->is('10.10')) {
                    $this->data->os->version->nickname = 'Yosemite';
                }

                if ($this->data->os->version->is('10.11')) {
                    $this->data->os->version->nickname = 'El Capitan';
                }

                if ($this->data->os->version->is('10.12')) {
                    $this->data->os->version->nickname = 'Sierra';
                }

                if ($this->data->os->version->is('10.13')) {
                    $this->data->os->version->nickname = 'High Sierra';
                }

                if ($this->data->os->version->is('10.14')) {
                    $this->data->os->version->nickname = 'Mojave';
                }

                if ($this->data->os->version->is('10.15')) {
                    $this->data->os->version->nickname = 'Catalina';
                }

                if ($this->data->os->version->is('11')) {
                    $this->data->os->version->nickname = 'Big Sur';
                }

                if ($this->data->os->version->is('12')) {
                    $this->data->os->version->nickname = 'Monterey';
                }
            }
        }
    }
}
