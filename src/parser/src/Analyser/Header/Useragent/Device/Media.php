<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;

trait Media
{
    private function detectMediaFromUseragent($ua)
    {
        $this->detectZuneFromUseragent($ua);
    }




    /* Microsoft Zune */

    private function detectZuneFromUseragent($ua)
    {
        if (preg_match('/Microsoft ZuneHD/u', $ua)) {
            unset($this->os->name);
            unset($this->os->version);

            $this->device->manufacturer = 'Microsoft';
            $this->device->model = 'Zune HD';
            $this->device->type = Constants\DeviceType::MEDIA;
            $this->device->identified |= Constants\Id::MATCH_UA;
            $this->device->generic = false;
        }
    }
}
