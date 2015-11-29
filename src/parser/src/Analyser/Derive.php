<?php

namespace WhichBrowser\Analyser;

use WhichBrowser\Constants;
use WhichBrowser\Model\Family;
use WhichBrowser\Model\Using;
use WhichBrowser\Model\Version;

trait Derive
{
    private function deriveInformation()
    {
        if (isset($this->device->flag)) {
            $this->deriveBasedOnDeviceFlag();
        }

        if (isset($this->os->name)) {
            $this->deriveBasedOnOperatingSystem();
        }

        if (isset($this->browser->name)) {
            $this->deriveOperaDevices();
        }

        if (isset($this->browser->name)) {
            $this->deriveFirefoxOS();
        }
    }




    private function deriveDeviceSubType()
    {
        if ($this->device->type == 'mobile') {
            $this->device->subtype = 'feature';

            if (isset($this->os->family) && in_array($this->os->family->getName(), [ 'Android' ])) {
                $this->device->subtype = 'smart';
            }

            if (in_array($this->os->getName(), [ 'Android', 'Bada', 'BlackBerry', 'BlackBerry OS', 'Firefox OS', 'iOS', 'iPhone OS', 'Kin OS', 'Maemo', 'MeeGo', 'Palm OS', 'Sailfish', 'Series60', 'Tizen', 'Ubuntu', 'Windows Mobile', 'Windows Phone', 'webOS' ])) {
                $this->device->subtype = 'smart';
            }
        }
    }


    private function deriveFirefoxOS()
    {
        if ($this->browser->name == 'Firefox Mobile' && !isset($this->os->name)) {
            $this->os->name = 'Firefox OS';
        }

        if (isset($this->os->name) && $this->os->name == 'Firefox OS') {
            switch ($this->engine->getVersion()) {
                case '18.0':
                    $this->os->version = new Version([ 'value' => '1.0.1' ]);
                    break;
                case '18.1':
                    $this->os->version = new Version([ 'value' => '1.1' ]);
                    break;
                case '26.0':
                    $this->os->version = new Version([ 'value' => '1.2' ]);
                    break;
                case '28.0':
                    $this->os->version = new Version([ 'value' => '1.3' ]);
                    break;
                case '30.0':
                    $this->os->version = new Version([ 'value' => '1.4' ]);
                    break;
                case '32.0':
                    $this->os->version = new Version([ 'value' => '2.0' ]);
                    break;
                case '34.0':
                    $this->os->version = new Version([ 'value' => '2.1' ]);
                    break;
            }
        }
    }


    private function deriveOperaDevices()
    {
        if ($this->browser->name == 'Opera' && $this->device->type == Constants\DeviceType::TELEVISION) {
            $this->browser->name = 'Opera Devices';

            if ($this->engine->getName() == 'Presto') {
                switch (implode('.', array_slice(explode('.', $this->engine->getVersion()), 0, 2))) {
                    case '2.12':
                        $this->browser->version = new Version([ 'value' => '3.4' ]);
                        break;
                    case '2.11':
                        $this->browser->version = new Version([ 'value' => '3.3' ]);
                        break;
                    case '2.10':
                        $this->browser->version = new Version([ 'value' => '3.2' ]);
                        break;
                    case '2.9':
                        $this->browser->version = new Version([ 'value' => '3.1' ]);
                        break;
                    case '2.8':
                        $this->browser->version = new Version([ 'value' => '3.0' ]);
                        break;
                    case '2.7':
                        $this->browser->version = new Version([ 'value' => '2.9' ]);
                        break;
                    case '2.6':
                        $this->browser->version = new Version([ 'value' => '2.8' ]);
                        break;
                    case '2.4':
                        $this->browser->version = new Version([ 'value' => '10.3' ]);
                        break;
                    case '2.3':
                        $this->browser->version = new Version([ 'value' => '10' ]);
                        break;
                    case '2.2':
                        $this->browser->version = new Version([ 'value' => '9.7' ]);
                        break;
                    case '2.1':
                        $this->browser->version = new Version([ 'value' => '9.6' ]);
                        break;
                    default:
                        unset($this->browser->version);
                }
            } else {
                switch (explode('.', $this->browser->getVersion())[0]) {
                    case '17':
                        $this->browser->version = new Version([ 'value' => '4.0' ]);
                        break;
                    case '19':
                        $this->browser->version = new Version([ 'value' => '4.1' ]);
                        break;
                    case '22':
                        $this->browser->version = new Version([ 'value' => '4.2' ]);
                        break;
                    default:
                        unset($this->browser->version);
                }
            }

            unset($this->os->name);
            unset($this->os->version);
        }
    }



    private function deriveBasedOnDeviceFlag()
    {
        if ($this->device->flag == Constants\Flag::NOKIAX) {
            $this->os->name = 'Nokia X Platform';
            $this->os->family = new Family([ 'name' => 'Android' ]);

            unset($this->os->version);
            unset($this->device->flag);
            return;
        }

        if ($this->device->flag == Constants\Flag::FIREOS) {
            $this->os->name = 'FireOS';
            $this->os->family = new Family([ 'name' => 'Android' ]);

            if (isset($this->os->version) && isset($this->os->version->value)) {
                switch ($this->os->version->value) {
                    case '2.3.3':
                        $this->os->version = new Version([ 'value' => '1' ]);
                        break;
                    case '4.0.3':
                        $this->os->version = new Version([ 'value' => '2' ]);
                        break;
                    case '4.2.2':
                        $this->os->version = new Version([ 'value' => '3' ]);
                        break;
                    case '4.4.2':
                        $this->os->version = new Version([ 'value' => '4' ]);
                        break;
                    case '4.4.3':
                        $this->os->version = new Version([ 'value' => '4.5' ]);
                        break;
                    case '5.1.1':
                        $this->os->version = new Version([ 'value' => '5' ]);
                        break;
                    default:
                        unset($this->os->version);
                        break;
                }
            }

            if ($this->isBrowser('Chrome')) {
                $this->browser->using = new Using([ 'name' => 'Amazon WebView' ]);

                $this->browser->stock = false;
                $this->browser->name = null;
                $this->browser->version = null;
                $this->browser->channel = null;
            }

            if ($this->browser->isUsing('Chromium WebView')) {
                $this->browser->using = new Using([ 'name' => 'Amazon WebView' ]);
            }

            unset($this->device->flag);
            return;
        }

        if ($this->device->flag == Constants\Flag::GOOGLETV) {
            $this->os->name = 'Google TV';
            $this->os->family = new Family([ 'name' => 'Android' ]);

            unset($this->os->version);
            unset($this->device->flag);
            return;
        }

        if ($this->device->flag == Constants\Flag::ANDROIDTV) {
            $this->os->name = 'Android TV';
            $this->os->family = new Family([ 'name' => 'Android' ]);

            unset($this->device->flag);
            return;
        }

        if ($this->device->flag == Constants\Flag::ANDROIDWEAR) {
            $this->os->name = 'Android Wear';
            $this->os->family = new Family([ 'name' => 'Android' ]);
            unset($this->os->version);
            unset($this->device->flag);

            if ($this->browser->isUsing('Chrome Content Shell')) {
                $this->browser->name = 'Wear Internet Browser';
                $this->browser->using = null;
            }

            return;
        }

        if ($this->device->flag == Constants\Flag::GOOGLEGLASS) {
            $this->os->family = new Family([ 'name' => 'Android' ]);
            unset($this->os->name);
            unset($this->os->version);
            unset($this->device->flag);
            return;
        }
    }

    private function deriveBasedOnOperatingSystem()
    {
        /* Derive the default browser on Android */

        if ($this->os->name == 'Android' && !isset($this->browser->using) && !isset($this->browser->name) && $this->browser->stock) {
            $this->browser->name = 'Android Browser';
        }

        /* Derive the default browser on Google TV */

        if ($this->os->name == 'Google TV' && !isset($this->browser->name) && $this->browser->stock) {
            $this->browser->name = 'Chrome';
        }

        /* Derive the default browser on BlackBerry */

        if ($this->os->name == 'BlackBerry' && !isset($this->browser->name) && $this->browser->stock) {
            $this->browser->name = 'BlackBerry Browser';
            $this->browser->hidden = true;
        }

        if ($this->os->name == 'BlackBerry OS' && !isset($this->browser->name) && $this->browser->stock) {
            $this->browser->name = 'BlackBerry Browser';
            $this->browser->hidden = true;
        }

        if ($this->os->name == 'BlackBerry Tablet OS' && !isset($this->browser->name) && $this->browser->stock) {
            $this->browser->name = 'BlackBerry Browser';
            $this->browser->hidden = true;
        }

        /* Derive the default browser on Tizen */

        if ($this->os->name == 'Tizen' && !isset($this->browser->name) && $this->browser->stock && $this->device->type == Constants\DeviceType::MOBILE) {
            $this->browser->name = 'Samsung Browser';
        }

        /* Derive the default browser on Aliyun OS */

        if ($this->os->name == 'Aliyun OS' && !isset($this->browser->using) && !isset($this->browser->name) && $this->browser->stock) {
            $this->browser->name = 'Aliyun Browser';
        }

        if ($this->os->name == 'Aliyun OS' && $this->browser->isUsing('Chrome Content Shell')) {
            $this->browser->name = 'Aliyun Browser';
            $this->browser->using = null;
            $this->browser->stock = true;
        }

        if ($this->os->name == 'Aliyun OS' && $this->browser->stock) {
            $this->browser->hidden = true;
        }

        /* Derive iOS and OS X versions from Darwin */

        if ($this->os->name == 'Darwin' && $this->device->type == Constants\DeviceType::MOBILE) {
            $this->os->name = 'iOS';

            switch (strstr($this->os->getVersion(), '.', true)) {
                case '9':
                    $this->os->version = new Version([ 'value' =>'1' ]);
                    $this->os->alias = 'iPhone OS';
                    break;
                case '10':
                    $this->os->version = new Version([ 'value' =>'4' ]);
                    break;
                case '11':
                    $this->os->version = new Version([ 'value' =>'5' ]);
                    break;
                case '13':
                    $this->os->version = new Version([ 'value' =>'6' ]);
                    break;
                case '14':
                    $this->os->version = new Version([ 'value' =>'7' ]);
                    break;
                case '15':
                    $this->os->version = new Version([ 'value' =>'9' ]);
                    break;
                default:
                    $this->os->version = null;
            }
        }

        if ($this->os->name == 'Darwin' && $this->device->type == Constants\DeviceType::DESKTOP) {
            $this->os->name = 'OS X';

            switch (strstr($this->os->getVersion(), '.', true)) {
                case '1':
                    $this->os->version = new Version([ 'value' =>'10.0' ]);
                    break;
                case '5':
                    $this->os->version = new Version([ 'value' =>'10.1' ]);
                    break;
                case '6':
                    $this->os->version = new Version([ 'value' =>'10.2' ]);
                    break;
                case '7':
                    $this->os->version = new Version([ 'value' =>'10.3' ]);
                    break;
                case '8':
                    $this->os->version = new Version([ 'value' =>'10.4' ]);
                    break;
                case '9':
                    $this->os->version = new Version([ 'value' =>'10.5' ]);
                    break;
                case '10':
                    $this->os->version = new Version([ 'value' =>'10.6' ]);
                    break;
                case '11':
                    $this->os->version = new Version([ 'value' =>'10.7' ]);
                    break;
                case '12':
                    $this->os->version = new Version([ 'value' =>'10.8' ]);
                    break;
                case '13':
                    $this->os->version = new Version([ 'value' =>'10.9' ]);
                    break;
                case '14':
                    $this->os->version = new Version([ 'value' =>'10.10' ]);
                    break;
                case '15':
                    $this->os->version = new Version([ 'value' =>'10.11' ]);
                    break;
                default:
                    $this->os->version = null;
            }

            if (!empty($this->os->version)) {
                if ($this->os->version->is('<', '10.7')) {
                    $this->os->alias = 'Mac OS X';
                }

                if ($this->os->version->is('10.7')) {
                    $this->os->version->nickname = 'Lion';
                }

                if ($this->os->version->is('10.8')) {
                    $this->os->version->nickname = 'Mountain Lion';
                }

                if ($this->os->version->is('10.9')) {
                    $this->os->version->nickname = 'Mavericks';
                }

                if ($this->os->version->is('10.10')) {
                    $this->os->version->nickname = 'Yosemite';
                }
                
                if ($this->os->version->is('10.11')) {
                    $this->os->version->nickname = 'El Capitan';
                }
            }
        }
    }
}
