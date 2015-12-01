<?php

namespace WhichBrowser\Analyser\Header;

use WhichBrowser\Parser;
use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

class UCBrowserOld
{
    public function __construct($header, &$data)
    {
        $this->data =& $data;

        if ($this->data->device->type == Constants\DeviceType::DESKTOP) {
            $this->data->device->type = Constants\DeviceType::MOBILE;

            unset($this->data->os->name);
            unset($this->data->os->version);
        }

        if (!isset($this->data->browser->name) || $this->data->browser->name != 'UC Browser') {
            $this->data->browser->name = 'UC Browser';
            $this->data->browser->version = null;
        }

        $extra = new Parser([ 'headers' => [ 'User-Agent' => $header ]]);
        
        if ($extra->device->type != Constants\DeviceType::DESKTOP) {
            if (isset($extra->os->version)) {
                $this->data->os = $extra->os;
            }
            if ($extra->device->identified) {
                $this->data->device = $extra->device;
            }
        }
    }
}
