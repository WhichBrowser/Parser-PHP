<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

trait Phone
{
    private function detectPhone($ua)
    {
        $this->detectNttTeless($ua);
    }





    /* Casio */

    private function detectNttTeless($ua)
    {
        if (preg_match('/Product\=NTT\/Teless/ui', $ua, $match)) {
            $this->data->device->manufacturer = 'NTT';
            $this->data->device->model = 'Teless';
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->type = Constants\DeviceType::MOBILE;
            $this->data->device->subtype = Constants\DeviceSubType::DESKTOP;
        }
    }
}
