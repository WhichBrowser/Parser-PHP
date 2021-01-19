<?php

namespace WhichBrowser\Analyser\Header;

class Skyfire
{
    public function __construct($header, &$data)
    {
        $this->data =& $data;

        if (!isset($this->data->browser->name) || $this->data->browser->name != 'SkyFire Browser') {
            $this->data->browser->name = 'SkyFire Browser';
            $this->data->browser->version = null;
            $this->data->browser->stock = false;
        }
    }
}
