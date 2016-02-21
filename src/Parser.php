<?php

namespace WhichBrowser;

use WhichBrowser\Model\Main;

class Parser extends Main
{
    use Cache;

    /**
     * Create a new object that contains all the detected information
     *
     * @param  array|string   $headers   Optional, an array with all of the headers or a string with just the User-Agent header
     */

    public function __construct($headers = null)
    {
        parent::__construct();

        if (!is_null($headers)) {
            $this->analyse($headers);
        }
    }

    /**
     * Analyse the provided headers or User-Agent string
     *
     * @param  array|string   $headers   An array with all of the headers or a string with just the User-Agent header
     */

    public function analyse($headers)
    {
        if ($this->analyseWithCache($headers)) {
            return;
        }

        $analyser = new Analyser($headers);
        $analyser->setdata($this);
        $analyser->analyse();
    }
}
