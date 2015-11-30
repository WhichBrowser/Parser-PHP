<?php

namespace WhichBrowser\Analyser\Header;

use WhichBrowser\Constants;
use WhichBrowser\Data;

class Wap
{
    public function __construct($header, &$data)
    {
        $this->data =& $data;

        $header = trim($header);

        if ($header[0] == '"') {
            $header = explode(",", $header);
            $header = trim($header[0], '"');
        }

        $result = Data\DeviceProfiles::identify($header);

        if ($result) {
            if ($result[0] && $result[1]) {
                $this->data->device->manufacturer = $result[0];
                $this->data->device->model = $result[1];
                $this->data->device->identified |= Constants\Id::MATCH_PROF;
            }

            if ($result[2] && (!isset($this->data->os->name) || $this->data->os->name != $result[2])) {
                $this->data->os->name = $result[2];
                $this->data->os->version = null;

                $this->data->engine->name = null;
                $this->data->engine->version = null;
            }

            if ($result[3]) {
                $this->data->device->type = $result[3];
            }
        }
    }
}
