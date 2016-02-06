<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

trait Phone
{
    private function detectPhone($ua)
    {
        $this->detectNtt($ua);
    }





    /* Casio */

    private function detectNtt($ua)
    {
        if (preg_match('/Product\=NTT\/([^\);]+)[\);]/ui', $ua, $match)) {
            $this->data->device->manufacturer = 'NTT';
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->type = Constants\DeviceType::MOBILE;
            $this->data->device->subtype = Constants\DeviceSubType::DESKTOP;

            if (substr($match[1], 0, 6) == 'Teless') {
                $this->data->device->model = 'Teless';
            }
        }
    }
}
