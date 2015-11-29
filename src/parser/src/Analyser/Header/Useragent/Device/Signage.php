<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;

trait Signage
{
    private function detectSignage($ua)
    {
        /* BrightSign */

        if (preg_match('/BrightSign\/[0-9\.]+(?:-[a-z0-9\-]+)? \(([^\)]+)/u', $ua, $match)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'BrightSign';
            $this->data->device->model = $match[1];
            $this->data->device->type = Constants\DeviceType::SIGNAGE;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }


        /* Iadea */

        if (preg_match('/ADAPI/u', $ua) && preg_match('/\(MODEL:([^\)]+)\)/u', $ua, $match)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Iadea';
            $this->data->device->model = $match[1];
            $this->data->device->type = Constants\DeviceType::SIGNAGE;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }
    }
}
