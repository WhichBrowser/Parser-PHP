<?php

namespace WhichBrowser\Analyser\Header\Useragent;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\SearchEngines\Sogou;

trait Bot
{
    private function &detectBot($ua)
    {
        /* Detect bots based on url in the UA string */

        if (preg_match('/\+https?:\/\//iu', $ua)) {
            $this->data->browser->reset();
            $this->data->os->reset();
            $this->data->engine->reset();
            $this->data->device->reset();

            $this->data->device->type = Constants\DeviceType::BOT;
        }

        /* Detect bots based on common markers */

        if (preg_match('/(?:Bot|Robot|Spider|Crawler)([\/\);]|$)/iu', $ua) && !preg_match('/CUBOT/iu', $ua)) {
            $this->data->browser->reset();
            $this->data->os->reset();
            $this->data->engine->reset();
            $this->data->device->reset();

            $this->data->device->type = Constants\DeviceType::BOT;
        }

        /* Detect based on a predefined list or markers */

        if ($bot = Data\Applications::identifyBot($ua)) {
            $this->data->browser = $bot;
            $this->data->os->reset();
            $this->data->engine->reset();
            $this->data->device->reset();

            $this->data->device->type = Constants\DeviceType::BOT;
        }

        /* Detect sogou search engine bots */

        if (preg_match('/sogou/iu', $ua, $match)) {
            $Sogou = new Sogou($ua);

            // Only run if the class found a regex match
            if ($Sogou->found == true) {
                $this->data->browser->name = $Sogou->name ?? '';
                $this->data->browser->version = $Sogou->version ?? '';
                $this->data->device->type = $Sogou->bot ?? '';
            }
        }

        return $this;
    }
}
