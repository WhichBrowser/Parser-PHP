<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;

trait Cars
{
    private function detectCars($ua)
    {
        if (preg_match('/Car/u', $ua)) {
            $this->detectTesla($ua);
        }
    }





    /* Tesla S */

    private function detectTesla($ua)
    {
        if (preg_match('/QtCarBrowser/u', $ua)) {
            $this->data->os->reset();
            $this->data->device->setIdentification([
                'manufacturer'  =>  'Tesla',
                'model'         =>  'Model S',
                'type'          =>  Constants\DeviceType::CAR
            ]);
        }
    }
}
