<?php

namespace WhichBrowser\Analyser\Header\Useragent;

use WhichBrowser\Constants;
use WhichBrowser\Data;

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

        /* Detect Seznam bots */

        if (preg_match('/Seznam|HomePage/iu', $ua, $match)) {
            /* SeznamBot */
            if (preg_match('/SeznamBot\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->reset();
                $this->data->device->reset();
                $this->data->browser->name = 'SeznamBot';
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);

                $this->data->device->type = Constants\DeviceType::BOT;
            }
            /* SeznamBot Test */
            elseif (preg_match('/SeznamBot\/([0-9.]*)-test/u', $ua, $match)) {
                $this->data->browser->reset();
                $this->data->device->reset();
                $this->data->browser->name = 'SeznamBot Test';
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);

                $this->data->device->type = Constants\DeviceType::BOT;
            }
            /* SklikBot */
            elseif (preg_match('/SklikBot\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->reset();
                $this->data->device->reset();
                $this->data->browser->name = 'SeznamBot';
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);

                $this->data->device->type = Constants\DeviceType::BOT;
            }
            /* Seznam HomePageBot Rss Reader */
            elseif (preg_match('/HomePage(Bot)? Rss Reader ([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->reset();
                $this->data->device->reset();
                $this->data->browser->name = 'Seznam HomePageBot Rss Reader';
                $this->data->browser->version = new Version([ 'value' => $match[2] ]);

                $this->data->device->type = Constants\DeviceType::BOT;
            }
            /* Seznam HomePageBot Downloader */
            elseif (preg_match('/HomePageBot downloader ([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->reset();
                $this->data->device->reset();
                $this->data->browser->name = 'Seznam HomePageBot Downloader';
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);

                $this->data->device->type = Constants\DeviceType::BOT;
            }
            /* Seznam Screenshot Generator */
            elseif (preg_match('/Seznam screenshot-generator ([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->reset();
                $this->data->device->reset();
                $this->data->browser->name = 'Seznam Screenshot Generator';
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);

                $this->data->device->type = Constants\DeviceType::BOT;
            }
            /* SeznamReadLaterBot */
            elseif (preg_match('/SeznamBot\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->reset();
                $this->data->device->reset();
                $this->data->browser->name = 'SeznamReadLaterBot';
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);

                $this->data->device->type = Constants\DeviceType::BOT;
            }
            /* Seznam Email Proxy */
            elseif (preg_match('/SeznamEmailProxy/u', $ua, $match)) {
                $this->data->browser->reset();
                $this->data->device->reset();
                $this->data->browser->name = 'Seznam Email Proxy';

                $this->data->device->type = Constants\DeviceType::BOT;
            }
            /* Seznam Zbozi.cz */
            elseif (preg_match('/Seznam-Zbozi-robot/u', $ua, $match)) {
                $this->data->browser->reset();
                $this->data->device->reset();
                $this->data->browser->name = 'Seznam Zbozi.cz';

                $this->data->device->type = Constants\DeviceType::BOT;
            }            
        }

        /* Detect based on a predefined list or markers */

        if ($bot = Data\Applications::identifyBot($ua)) {
            $this->data->browser = $bot;
            $this->data->os->reset();
            $this->data->engine->reset();
            $this->data->device->reset();

            $this->data->device->type = Constants\DeviceType::BOT;
        }

        return $this;
    }
}
