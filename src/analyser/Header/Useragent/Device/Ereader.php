<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;

trait Ereader
{
    private function detectEreader($ua)
    {
        $this->detectKindle($ua);
        $this->detectNook($ua);
        $this->detectBookeen($ua);
        $this->detectKobo($ua);
        $this->detectSonyreader($ua);
        $this->detectPocketbook($ua);
        $this->detectIriver($ua);
    }




    /* Amazon Kindle */

    private function detectKindle($ua)
    {
        if (preg_match('/Kindle/u', $ua) && !preg_match('/Fire/u', $ua)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Amazon';
            $this->data->device->series = 'Kindle';
            $this->data->device->type = Constants\DeviceType::EREADER;

            if (preg_match('/Kindle SkipStone/u', $ua)) {
                $this->data->device->model = 'Kindle Touch or later';
            } elseif (preg_match('/Kindle\/3.0\+/u', $ua)) {
                $this->data->device->model = 'Kindle 3 or later';
            } elseif (preg_match('/Kindle\/3.0/u', $ua)) {
                $this->data->device->model = 'Kindle 3';
            } elseif (preg_match('/Kindle\/2.5/u', $ua)) {
                $this->data->device->model = 'Kindle 2';
            } elseif (preg_match('/Kindle\/2.0/u', $ua)) {
                $this->data->device->model = 'Kindle 2';
            } elseif (preg_match('/Kindle\/1.0/u', $ua)) {
                $this->data->device->model = 'Kindle 1';
            }

            if (!empty($this->data->device->model)) {
                $this->data->device->series = null;
            }

            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }
    }


    /* Barnes & Noble Nook */

    private function detectNook($ua)
    {
        if (preg_match('/nook browser/u', $ua)) {
            $this->data->os->name = 'Android';

            $this->data->device->manufacturer = 'Barnes & Noble';
            $this->data->device->series = 'NOOK';
            $this->data->device->type = Constants\DeviceType::EREADER;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }
    }


    /* Bookeen */

    private function detectBookeen($ua)
    {
        if (preg_match('/bookeen\/cybook/u', $ua)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Bookeen';
            $this->data->device->series = 'Cybook';
            $this->data->device->type = Constants\DeviceType::EREADER;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }
    }


    /* Kobo */

    private function detectKobo($ua)
    {
        if (preg_match('/Kobo Touch/u', $ua, $match)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Kobo';
            $this->data->device->series = 'eReader';
            $this->data->device->type = Constants\DeviceType::EREADER;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }
    }


    /* Sony Reader */

    private function detectSonyreader($ua)
    {
        if (preg_match('/EBRD([0-9]+)/u', $ua, $match)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Sony';
            $this->data->device->series = 'Reader';
            $this->data->device->type = Constants\DeviceType::EREADER;
            $this->data->device->identified |= Constants\Id::MATCH_UA;

            switch ($match[1]) {
                case '1101':
                    $this->data->device->model = 'PRS-T1';
                    $this->data->device->generic = false;
                    break;
                case '1102':
                    $this->data->device->model = 'PRS-T1';
                    $this->data->device->generic = false;
                    break;
                case '1201':
                    $this->data->device->model = 'PRS-T2';
                    $this->data->device->generic = false;
                    break;
                case '1301':
                    $this->data->device->model = 'PRS-T3';
                    $this->data->device->generic = false;
                    break;
            }
        }
    }


    /* PocketBook */

    private function detectPocketbook($ua)
    {
        if (preg_match('/PocketBook\/([0-9]+)/u', $ua, $match)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'PocketBook';
            $this->data->device->type = Constants\DeviceType::EREADER;
            $this->data->device->identified |= Constants\Id::MATCH_UA;

            switch ($match[1]) {
                case '515':
                    $this->data->device->model = 'Mini';
                    $this->data->device->generic = false;
                    break;
                case '614':
                    $this->data->device->model = 'Basic 2';
                    $this->data->device->generic = false;
                    break;
                case '622':
                    $this->data->device->model = 'Touch';
                    $this->data->device->generic = false;
                    break;
                case '623':
                    $this->data->device->model = 'Touch Lux';
                    $this->data->device->generic = false;
                    break;
                case '624':
                    $this->data->device->model = 'Basic Touch';
                    $this->data->device->generic = false;
                    break;
                case '626':
                    $this->data->device->model = 'Touch Lux 2';
                    $this->data->device->generic = false;
                    break;
                case '630':
                    $this->data->device->model = 'Sense';
                    $this->data->device->generic = false;
                    break;
                case '640':
                    $this->data->device->model = 'Auqa';
                    $this->data->device->generic = false;
                    break;
                case '650':
                    $this->data->device->model = 'Ultra';
                    $this->data->device->generic = false;
                    break;
                case '801':
                    $this->data->device->model = 'Color Lux';
                    $this->data->device->generic = false;
                    break;
                case '840':
                    $this->data->device->model = 'InkPad';
                    $this->data->device->generic = false;
                    break;
            }
        }
    }


    /* iRiver */

    private function detectIriver($ua)
    {
        if (preg_match('/Iriver ;/u', $ua)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'iRiver';
            $this->data->device->series = 'Story';
            $this->data->device->type = Constants\DeviceType::EREADER;

            if (preg_match('/EB07/u', $ua)) {
                $this->data->device->model = 'Story HD EB07';
                $this->data->device->generic = false;
            }

            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }
    }
}
