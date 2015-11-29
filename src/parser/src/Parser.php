<?php

namespace WhichBrowser;

use WhichBrowser\Model\Main;

class Parser extends Main
{
    public function __construct($options)
    {
        parent::__construct();

        $analyser = new Analyser($options);
        $analyser->setdata($this);
        $analyser->analyse();
    }
}
