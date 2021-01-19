<?php

namespace WhichBrowser\Analyser\Header;

class Bolt
{
    public function __construct($header, &$data)
    {
        $this->data =& $data;

        if (!isset($this->data->browser->name) || $this->data->browser->name != 'Bolt Browser') {
            $this->data->browser->name = 'Bolt Browser';
            $this->data->browser->version = null;
            $this->data->browser->stock = false;
        }
    }
}
