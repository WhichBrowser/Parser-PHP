<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;
use WhichBrowser\Model\Version;

trait Desktop
{
    private function detectDesktop($ua)
    {
        $this->detectSharpShoin($ua);
    }





    /* Sharp Shoin (Word Processor) */

    private function detectSharpShoin($ua)
    {
        if (preg_match('/sharp wd browser\/([0-9\.]+)/ui', $ua, $match)) {
            $this->data->browser->name = 'Sharp WD Browser';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

            $this->data->device->manufacturer = 'Sharp';
            $this->data->device->model = '書院';
            $this->data->device->type = Constants\DeviceType::DESKTOP;

            if (preg_match('/\(([A-Z0-9\-]+)\/[0-9\.]+\)/ui', $ua, $match)) {
                $this->data->device->model = '書院 ' . $match[1];
                $this->data->device->identified |= Constants\Id::MATCH_UA;
                $this->data->device->generic = false;
            }
        }
    }
}
