<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;

trait Printer
{
    private function detectPrinter($ua)
    {
        /* TASKalfa */

        if (preg_match('/TASKalfa ([0-9A-Z]+)/iu', $ua, $match)) {
            $this->data->device->setIdentification([
                'manufacturer'  =>  'Kyocera',
                'model'         =>  'TASKalfa ' . $match[1],
                'type'          =>  Constants\DeviceType::PRINTER
            ]);
        }
    }
}
