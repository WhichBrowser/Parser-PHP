<?php

namespace WhichBrowser\Analyser\Header\Useragent;

trait Device
{
    use Device\Cars, Device\Gaming, Device\Ereader, Device\Mobile,
        Device\Media, Device\Television, Device\Signage;

    private function detectDeviceFromUseragent($ua)
    {
        $this->detectCarsFromUseragent($ua);
        $this->detectEreaderFromUseragent($ua);
        $this->detectGamingFromUseragent($ua);
        $this->detectTelevisionFromUseragent($ua);
        $this->detectSignageFromUseragent($ua);
        $this->detectMediaFromUseragent($ua);
        $this->detectMobileFromUseragent($ua);
    }
}
