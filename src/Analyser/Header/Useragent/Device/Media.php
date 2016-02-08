<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;

trait Media
{
    private function detectMedia($ua)
    {
        $this->detectArchos($ua);
        $this->detectZune($ua);
        $this->detectWalkman($ua);
    }




    /* Archos Generation 4 and 5 */

    private function detectArchos($ua)
    {
        if (preg_match('/Archos A([67]04)WIFI\//u', $ua, $match)) {
            $this->data->os->reset();
            $this->data->device->setIdentification([
                'manufacturer'  =>  'Archos',
                'model'         =>  $match[1] . ' WiFi',
                'type'          =>  Constants\DeviceType::MEDIA
            ]);
        }

        if (preg_match('/ARCHOS; GOGI; a([67]05f?);/u', $ua, $match)) {
            $this->data->os->reset();
            $this->data->device->setIdentification([
                'manufacturer'  =>  'Archos',
                'model'         =>  $match[1] . ' WiFi',
                'type'          =>  Constants\DeviceType::MEDIA
            ]);
        }

        if (preg_match('/ARCHOS; GOGI; G6([SHL]);/u', $ua, $match)) {
            $this->data->os->reset();
            $this->data->device->setIdentification([
                'manufacturer'  =>  'Archos',
                'type'          =>  Constants\DeviceType::MEDIA
            ]);

            switch ($match[1]) {
                case 'S':
                case 'H':
                    $this->data->device->model = '5';
                    break;
                case 'L':
                    $this->data->device->model = '7';
                    break;
            }
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
