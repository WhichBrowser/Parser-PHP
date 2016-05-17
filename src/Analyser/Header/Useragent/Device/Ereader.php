<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;

trait Ereader
{
    private function detectEreader($ua)
    {
        if (!preg_match('/(Kindle|Nook|Bookeen|Kobo|EBRD|PocketBook|Iriver)/ui', $ua)) {
            return;
        }

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
            $this->data->device->setIdentification([
                'manufacturer'  =>  'Amazon',
                'series'        =>  'Kindle',
                'type'          =>  Constants\DeviceType::EREADER
            ]);

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
                $this->data->device->generic = false;
                $this->data->device->series = null;
            }
        }
    }


    /* Barnes & Noble Nook */

    private function detectNook($ua)
    {
        if (preg_match('/nook browser/u', $ua)) {
            $this->data->os->reset([ 'name' => 'Android' ]);
            $this->data->device->setIdentification([
                'manufacturer'  =>  'Barnes & Noble',
                'series'        =>  'NOOK',
                'type'          =>  Constants\DeviceType::EREADER
            ]);
        }
    }


    /* Bookeen */

    private function detectBookeen($ua)
    {
        if (preg_match('/bookeen\/cybook/u', $ua)) {
            $this->data->os->reset();
            $this->data->device->setIdentification([
                'manufacturer'  =>  'Bookeen',
                'series'        =>  'Cybook',
                'type'          =>  Constants\DeviceType::EREADER
            ]);
        }
    }


    /* Kobo */

    private function detectKobo($ua)
    {
        if (preg_match('/Kobo (eReader|Touch)/u', $ua, $match)) {
            $this->data->os->reset();
            $this->data->device->setIdentification([
                'manufacturer'  =>  'Kobo',
                'series'        =>  'eReader',
                'type'          =>  Constants\DeviceType::EREADER
            ]);
        }
    }


    /* Sony Reader */

    private function detectSonyreader($ua)
    {
        if (preg_match('/EBRD([0-9]+)/u', $ua, $match)) {
            $model = null;

            switch ($match[1]) {
                case '1101':
                    $model = 'PRS-T1';
                    break;
                case '1102':
                    $model = 'PRS-G1';
                    break;
                case '1201':
                    $model = 'PRS-T2';
                    break;
                case '1301':
                    $model = 'PRS-T3';
                    break;
            }

            $this->data->os->reset();
            $this->data->device->setIdentification([
                'manufacturer'  =>  'Sony',
                'model'         =>  $model,
                'series'        =>  'Reader',
                'type'          =>  Constants\DeviceType::EREADER
            ]);

        }
    }


    /* PocketBook */

    private function detectPocketbook($ua)
    {
        if (preg_match('/PocketBook\/([0-9]+)/u', $ua, $match)) {
            $model = null;

            switch ($match[1]) {
                case '515':
                    $model = 'Mini';
                    break;
                case '614':
                    $model = 'Basic 2';
                    break;
                case '622':
                    $model = 'Touch';
                    break;
                case '623':
                    $model = 'Touch Lux';
                    break;
                case '624':
                    $model = 'Basic Touch';
                    break;
                case '626':
                    $model = 'Touch Lux 2';
                    break;
                case '630':
                    $model = 'Sense';
                    break;
                case '640':
                    $model = 'Aqua';
                    break;
                case '650':
                    $model = 'Ultra';
                    break;
                case '801':
                    $model = 'Color Lux';
                    break;
                case '840':
                    $model = 'InkPad';
                    break;
            }

            $this->data->os->reset();
            $this->data->device->setIdentification([
                'manufacturer'  =>  'PocketBook',
                'model'         =>  $model,
                'type'          =>  Constants\DeviceType::EREADER
            ]);
        }
    }


    /* iRiver */

    private function detectIriver($ua)
    {
        if (preg_match('/Iriver ;/u', $ua)) {
            $this->data->os->reset();
            $this->data->device->setIdentification([
                'manufacturer'  =>  'iRiver',
                'series'        =>  'Story',
                'type'          =>  Constants\DeviceType::EREADER
            ]);

            if (preg_match('/EB07/u', $ua)) {
                $this->data->device->model = 'Story HD EB07';
                $this->data->device->series = null;
                $this->data->device->generic = false;
            }
        }
    }
}
