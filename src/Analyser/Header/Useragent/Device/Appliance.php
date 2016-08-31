<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;

trait Appliance
{
    private function detectAppliance($ua)
    {
        $this->detectIOpener($ua);
    }





    /* Netpliance i-Opener */

    private function detectIOpener($ua)
    {
        if (preg_match('/I-Opener [0-9.]+; Netpliance/u', $ua)) {
            $this->data->os->reset();
            $this->data->device->setIdentification([
                'manufacturer'  =>  'Netpliance',
                'model'         =>  'i-Opener',
                'type'          =>  Constants\DeviceType::DESKTOP
            ]);
        }
    }
}
