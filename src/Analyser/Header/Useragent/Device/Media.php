<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;

trait Media
{
    private function detectMedia($ua)
    {
        $this->detectZune($ua);
        $this->detectWalkman($ua);
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
