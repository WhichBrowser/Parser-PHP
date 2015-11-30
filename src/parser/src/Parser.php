<?php

namespace WhichBrowser;

use WhichBrowser\Model\Main;

class Parser extends Main
{
    /**
     * Create a new object that contains all the detected information
     *
     * @param  array|string   $headers   An array with all of the headers or a string with just the User-Agent header
     */

    public function __construct($headers)
    {
        parent::__construct();

        $analyser = new Analyser($headers);
        $analyser->setdata($this);
        $analyser->analyse();
    }
}
