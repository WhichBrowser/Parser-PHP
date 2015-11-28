<?php

namespace WhichBrowser\Analyser\Header;

use WhichBrowser\Constants;
use WhichBrowser\Parser;

trait Useragent
{
    use Useragent\Os, Useragent\Device, Useragent\Browser, Useragent\Engine, Useragent\Bot;

    private function analyseUserAgent($ua)
    {
        $ua = preg_replace("/^(Mozilla\/[0-9]\.[0-9].*)\s+Mozilla\/[0-9]\.[0-9].*$/iu", '$1', $ua);

        $this->detectOperatingSystemFromUseragent($ua);

        $this->detectDeviceFromUseragent($ua);

        $this->detectBrowserFromUseragent($ua);

        $this->detectEngineFromUseragent($ua);

        $this->detectBotBasedOnUserAgent($ua);

        $this->refineBrowserFromUseragent($ua);
        
        $this->refineOperatingSystemFromUseragent($ua);
    }

    private function additionalUserAgent($ua)
    {
        $extra = new Parser($ua);

        if ($extra->device->type != Constants\DeviceType::DESKTOP) {
            if (isset($extra->os->name)) {
                $this->os = $extra->os;
            }
            if ($extra->device->identified) {
                $this->device = $extra->device;
            }
        }
    }
}
