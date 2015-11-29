<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;

trait Signage
{
    private function detectSignageFromUseragent($ua)
    {
        /* BrightSign */

        if (preg_match('/BrightSign\/[0-9\.]+(?:-[a-z0-9\-]+)? \(([^\)]+)/u', $ua, $match)) {
            $this->os->reset();

            $this->device->manufacturer = 'BrightSign';
            $this->device->model = $match[1];
            $this->device->type = Constants\DeviceType::SIGNAGE;
            $this->device->identified |= Constants\Id::MATCH_UA;
            $this->device->generic = false;
        }


        /* Iadea */

        if (preg_match('/ADAPI/u', $ua) && preg_match('/\(MODEL:([^\)]+)\)/u', $ua, $match)) {
            $this->os->reset();

            $this->device->manufacturer = 'Iadea';
            $this->device->model = $match[1];
            $this->device->type = Constants\DeviceType::SIGNAGE;
            $this->device->identified |= Constants\Id::MATCH_UA;
            $this->device->generic = false;
        }
    }
}
