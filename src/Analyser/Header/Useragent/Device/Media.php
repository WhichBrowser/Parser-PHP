<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;

trait Media
{
    private function detectMedia($ua)
    {
        $this->detectZune($ua);
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
}
