<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;
use WhichBrowser\Model\Version;

trait Media
{
    private function detectMedia($ua)
    {
        if (!preg_match('/(Archos|Zune|Walkman)/ui', $ua)) {
            return;
        }

        $this->detectArchos($ua);
        $this->detectZune($ua);
        $this->detectWalkman($ua);
    }




    /* Archos Generation 4, 5 and 6 */

    private function detectArchos($ua)
    {
        /* Generation 4 */

        if (preg_match('/Archos A([67]04)WIFI\//u', $ua, $match)) {
            $this->data->os->reset();
            $this->data->device->setIdentification([
                'manufacturer'  =>  'Archos',
                'model'         =>  $match[1] . ' WiFi',
                'type'          =>  Constants\DeviceType::MEDIA
            ]);
        }

        /* Generation 5 */

        if (preg_match('/ARCHOS; GOGI; a([67]05f?);/u', $ua, $match)) {
            $this->data->os->reset();
            $this->data->device->setIdentification([
                'manufacturer'  =>  'Archos',
                'model'         =>  $match[1] . ' WiFi',
                'type'          =>  Constants\DeviceType::MEDIA
            ]);
        }

        /* Generation 6 without Android */

        if (preg_match('/ARCHOS; GOGI; G6-?(S|H|L|3GP);/u', $ua, $match)) {
            $this->data->os->reset();
            $this->data->device->setIdentification([
                'manufacturer'  =>  'Archos',
                'type'          =>  Constants\DeviceType::MEDIA
            ]);

            switch ($match[1]) {
                case '3GP':
                    $this->data->device->model = '5 3G+';
                    break;
                case 'S':
                case 'H':
                    $this->data->device->model = '5';
                    break;
                case 'L':
                    $this->data->device->model = '7';
                    break;
            }
        }

        /* Generation 6 with Android */

        if (preg_match('/ARCHOS; GOGI; A5[SH]; Version ([0-9]\.[0-9])/u', $ua, $match)) {
            $version = new Version([ 'value' => $match[1] ]);

            $this->data->os->reset([
                'name'          => 'Android',
                'version'       => new Version([ 'value' => $version->is('<', '1.7') ? '1.5' : '1.6' ])
            ]);

            $this->data->device->setIdentification([
                'manufacturer'  =>  'Archos',
                'model'         =>  '5',
                'type'          =>  Constants\DeviceType::MEDIA
            ]);
        }
    }


    /* Microsoft Zune */

    private function detectZune($ua)
    {
        if (preg_match('/Microsoft ZuneHD/u', $ua)) {
            $this->data->os->reset();
            $this->data->device->setIdentification([
                'manufacturer'  =>  'Microsoft',
                'model'         =>  'Zune HD',
                'type'          =>  Constants\DeviceType::MEDIA
            ]);
        }
    }


    /* Sony Walkman */

    private function detectWalkman($ua)
    {
        if (preg_match('/Walkman\/(NW-[A-Z0-9]+)/u', $ua, $match)) {
            $this->data->device->setIdentification([
                'manufacturer'  =>  'Sony',
                'model'         =>  $match[1] . ' Walkman',
                'type'          =>  Constants\DeviceType::MEDIA
            ]);
        }
    }
}
