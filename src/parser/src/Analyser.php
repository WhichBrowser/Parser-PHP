<?php

namespace WhichBrowser;

use WhichBrowser\Constants;
use WhichBrowser\Model\Main;

class Analyser
{
    use Analyser\Header, Analyser\Derive, Analyser\Corrections, Analyser\Camouflage;

    private $data;

    private $options;

    private $headers = [];

    public function __construct($options)
    {
        if (is_string($options)) {
            $this->options = (object) [ 'headers' => [ 'User-Agent' => $options ] ];
        } else {
            $this->options = (object) (isset($options['headers']) ? $options : [ 'headers' => $options ]);
        }

        if (isset($this->options->headers)) {
            $this->headers = $this->options->headers;
        }
    }

    public function setData(&$data)
    {
        $this->data =& $data;
    }

    public function &getData()
    {
        return $this->data;
    }

    public function analyse()
    {
        if (!isset($this->data)) {
            $this->data = new Main();
        }

        /* Start the actual analysing steps */

        $this->analyseHeaders()
             ->deriveInformation()
             ->applyCorrections()
             ->detectCamouflage()
             ->deriveDeviceSubType();
    }
}
