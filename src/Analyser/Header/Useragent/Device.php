<?php

namespace WhichBrowser\Analyser\Header\Useragent;

trait Device
{
    use Device\Cars, Device\Gps, Device\Gaming, Device\Ereader, Device\Mobile,
        Device\Media, Device\Television, Device\Signage, Device\Printer,
        Device\Tablet, Device\Phone, Device\Pda;

    private function &detectDevice($ua)
    {
        $this->detectCars($ua);
        $this->detectGps($ua);
        $this->detectEreader($ua);
        $this->detectGaming($ua);
        $this->detectTelevision($ua);
        $this->detectSignage($ua);
        $this->detectMedia($ua);
        $this->detectPda($ua);
        $this->detectPrinter($ua);
        $this->detectTablet($ua);
        $this->detectPhone($ua);
        $this->detectMobile($ua);

        return $this;
    }
}
