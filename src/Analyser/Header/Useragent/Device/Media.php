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

            $this->data->device->manufacturer = 'Microsoft';
            $this->data->device->model = 'Zune HD';
            $this->data->device->type = Constants\DeviceType::MEDIA;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }
    }
}
