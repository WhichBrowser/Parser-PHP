<?php

namespace WhichBrowser\Analyser\Header\Useragent;

trait Device
{
    use Device\Cars, Device\Gaming, Device\Ereader, Device\Mobile,
        Device\Media, Device\Television, Device\Signage, Device\Desktop;

    private function &detectDevice($ua)
    {
        $this->detectDesktop($ua);
        $this->detectCars($ua);
        $this->detectEreader($ua);
        $this->detectGaming($ua);
        $this->detectTelevision($ua);
        $this->detectSignage($ua);
        $this->detectMedia($ua);
        $this->detectMobile($ua);

        return $this;
    }
}
