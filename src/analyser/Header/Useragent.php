<?php

namespace WhichBrowser\Analyser\Header;

class Useragent
{
    use Useragent\Os, Useragent\Device, Useragent\Browser, Useragent\Engine, Useragent\Bot;

    public function __construct($header, &$data)
    {
        $this->data =& $data;

        /* Make sure we do not have a duplicate concatenated useragent string */

        $header = preg_replace("/^(Mozilla\/[0-9]\.[0-9].*)\s+Mozilla\/[0-9]\.[0-9].*$/iu", '$1', $header);

        /* Detect the basic information */

        $this->detectOperatingSystem($header)
             ->detectDevice($header)
             ->detectBrowser($header)
             ->detectEngine($header)
             ->detectBot($header);

        /* Refine some of the information */

        $this->refineBrowser($header)
             ->refineOperatingSystem($header);
    }
}
