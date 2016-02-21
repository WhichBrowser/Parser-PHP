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

    public function __construct($headers = null)
    {
        parent::__construct();

        if (!is_null($headers)) {
            $this->analyse($headers);
        }
    }

    public function analyse($headers)
    {
        $analyser = new Analyser($headers);
        $analyser->setdata($this);
        $analyser->analyse();
    }
}
