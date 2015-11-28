<?php

namespace WhichBrowser;

use WhichBrowser\Model\Main;

class Parser extends Main
{
    use Analyser;

    public function __construct($options)
    {
        parent::__construct();

        $this->analyse($options);
    }
}
