<?php

namespace WhichBrowser\Analyser\Header\Useragent;

use WhichBrowser\Constants;
use WhichBrowser\Data;

trait Bot
{
    private function detectBotBasedOnUserAgent($ua)
    {
        /* Detect bots based on common markers */

        if (preg_match('/(?:Bot|Robot|Spider|Crawler)([\/;]|$)/iu', $ua)) {
            $this->browser->reset();
            $this->os->reset();
            $this->engine->reset();
            $this->device->reset();

            $this->device->type = Constants\DeviceType::BOT;
        }

        /* Detect based on a predefined list or markers */

        if ($bot = Data\Bots::identify($ua)) {
            $this->browser = $bot;
            $this->os->reset();
            $this->engine->reset();
            $this->device->reset();

            $this->device->type = Constants\DeviceType::BOT;
        }
    }
}
