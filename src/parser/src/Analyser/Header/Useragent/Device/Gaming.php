<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;
use WhichBrowser\Model\Version;

trait Gaming
{
    private function detectGaming($ua)
    {
        if (preg_match('/Nintendo/iu', $ua)) {
            $this->detectNintendo($ua);
        }

        if (preg_match('/PlayStation/iu', $ua)) {
            $this->detectPlaystation($ua);
        }

        if (preg_match('/Xbox/iu', $ua)) {
            $this->detectXbox($ua);
        }
    }





    /* Nintendo Wii and DS */

    private function detectNintendo($ua)
    {
        /* Wii */

        if (preg_match('/Nintendo Wii/u', $ua)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Nintendo';
            $this->data->device->model = 'Wii';
            $this->data->device->type = Constants\DeviceType::GAMING;
            $this->data->device->subtype = Constants\DeviceSubType::CONSOLE;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }

        /* Wii U */

        if (preg_match('/Nintendo Wii ?U/u', $ua)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Nintendo';
            $this->data->device->model = 'Wii U';
            $this->data->device->type = Constants\DeviceType::GAMING;
            $this->data->device->subtype = Constants\DeviceSubType::CONSOLE;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }

        /* DS */

        if (preg_match('/Nintendo DS/u', $ua)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Nintendo';
            $this->data->device->model = 'DS';
            $this->data->device->type = Constants\DeviceType::GAMING;
            $this->data->device->subtype = Constants\DeviceSubType::PORTABLE;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }

        /* DSi */

        if (preg_match('/Nintendo DSi/u', $ua)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Nintendo';
            $this->data->device->model = 'DSi';
            $this->data->device->type = Constants\DeviceType::GAMING;
            $this->data->device->subtype = Constants\DeviceSubType::PORTABLE;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }

        /* 3DS */

        if (preg_match('/Nintendo 3DS/u', $ua)) {
            $this->data->os->reset();

            if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->device->manufacturer = 'Nintendo';
            $this->data->device->model = '3DS';
            $this->data->device->type = Constants\DeviceType::GAMING;
            $this->data->device->subtype = Constants\DeviceSubType::PORTABLE;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }

        /* New 3DS */

        if (preg_match('/New Nintendo 3DS/u', $ua)) {
            $this->data->os->reset();

            if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->device->manufacturer = 'Nintendo';
            $this->data->device->model = 'New 3DS';
            $this->data->device->type = Constants\DeviceType::GAMING;
            $this->data->device->subtype = Constants\DeviceSubType::PORTABLE;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }
    }


    /* Sony PlayStation */

    private function detectPlaystation($ua)
    {
        /* PlayStation Portable */

        if (preg_match('/PlayStation Portable/u', $ua)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Sony';
            $this->data->device->model = 'Playstation Portable';
            $this->data->device->type = Constants\DeviceType::GAMING;
            $this->data->device->subtype = Constants\DeviceSubType::PORTABLE;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }

        /* PlayStation Vita */

        if (preg_match('/PlayStation Vita/u', $ua)) {
            $this->data->os->reset();

            if (preg_match('/PlayStation Vita ([0-9.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->device->manufacturer = 'Sony';
            $this->data->device->model = 'Playstation Vita';
            $this->data->device->type = Constants\DeviceType::GAMING;
            $this->data->device->subtype = Constants\DeviceSubType::PORTABLE;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;

            if (preg_match('/VTE\//u', $ua)) {
                $this->data->device->model = 'Playstation TV';
            }
        }

        /* PlayStation 3 */

        if (preg_match('/PlayStation 3/ui', $ua)) {
            $this->data->os->reset();

            if (preg_match('/PLAYSTATION 3;? ([0-9.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->device->manufacturer = 'Sony';
            $this->data->device->model = 'Playstation 3';
            $this->data->device->type = Constants\DeviceType::GAMING;
            $this->data->device->subtype = Constants\DeviceSubType::CONSOLE;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }

        /* PlayStation 4 */

        if (preg_match('/PlayStation 4/ui', $ua)) {
            $this->data->os->reset();

            if (preg_match('/PlayStation 4 ([0-9.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->device->manufacturer = 'Sony';
            $this->data->device->model = 'Playstation 4';
            $this->data->device->type = Constants\DeviceType::GAMING;
            $this->data->device->subtype = Constants\DeviceSubType::CONSOLE;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }
    }


    /* Microsoft Xbox */

    private function detectXbox($ua)
    {
        /* Xbox 360 */

        if (preg_match('/Xbox\)$/u', $ua, $match)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Microsoft';
            $this->data->device->model = 'Xbox 360';
            $this->data->device->type = Constants\DeviceType::GAMING;
            $this->data->device->subtype = Constants\DeviceSubType::CONSOLE;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }

        /* Xbox One */

        if (preg_match('/Xbox One\)/u', $ua, $match)) {
            if ($this->data->isOs('Windows Phone', '=', '10')) {
                $this->data->os->name = 'Windows';
                $this->data->os->version->alias = '10';
            }

            if (!$this->data->isOs('Windows', '=', '10')) {
                $this->data->os->reset();
            }

            $this->data->device->manufacturer = 'Microsoft';
            $this->data->device->model = 'Xbox One';
            $this->data->device->type = Constants\DeviceType::GAMING;
            $this->data->device->subtype = Constants\DeviceSubType::CONSOLE;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }
    }
}
