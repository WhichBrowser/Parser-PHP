<?php

namespace WhichBrowser;

use WhichBrowser\Constants;

trait Analyser
{
    use Analyser\Header, Analyser\Derive, Analyser\Corrections, Analyser\Camouflage;

    public function analyse($options)
    {
        if (is_string($options)) {
            $this->options = (object) [ 'headers' => [ 'User-Agent' => $options ] ];
        } else {
            $this->options = (object) (isset($options['headers']) ? $options : [ 'headers' => $options ]);
        }

        $this->headers = [];

        if (isset($this->options->headers)) {
            $this->headers = $this->options->headers;
        }


        /* Analyse the headers  */

        $this->analyseHeaders();


        /* Derive more information from everything we have gathered  */

        $this->deriveInformation();


        /* Apply corrections  */

        $this->applyCorrections();


        /* Detect if the browser is camouflaged */

        $this->detectCamouflage();


        /* Determine subtype of devices */

        $this->deriveDeviceSubType();
    }
}
