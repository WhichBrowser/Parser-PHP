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
            $this->data->os->name = '';

            $this->data->device->manufacturer = 'Tesla';
            $this->data->device->model = 'Model S';
            $this->data->device->type = Constants\DeviceType::CAR;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }
    }
}
