<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

trait Tablet
{
    private function detectTablet($ua)
    {
        $this->detectWebTab($ua);
    }





    /* WeTab */

    private function detectWebTab($ua)
    {
        if (preg_match('/WeTab-Browser /ui', $ua, $match)) {
            $this->data->device->manufacturer = 'WeTab';
            $this->data->device->model = 'WeTab';
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->type = Constants\DeviceType::TABLET;

            $this->data->browser->name = 'WebTab Browser';
            $this->data->browser->version = null;

            $this->data->os->name = 'MeeGo';
            $this->data->os->version = null;
        }
    }
}
