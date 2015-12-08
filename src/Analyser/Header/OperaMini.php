<?php

namespace WhichBrowser\Analyser\Header;

use WhichBrowser\Data;
use WhichBrowser\Constants;

class OperaMini
{
    public function __construct($header, &$data)
    {
        $this->data =& $data;

        $parts = explode(' # ', $header);
        $manufacturer = isset($parts[0]) ? $parts[0] : '';
        $model = isset($parts[1]) ? $parts[1] : '';

        if ($manufacturer != '?' && $model != '?') {
            if ($this->data->device->identified < Constants\Id::PATTERN) {
                if ($this->identifyBasedOnModel($model)) {
                    return;
                }

                $this->data->device->manufacturer = $manufacturer;
                $this->data->device->model = $model;
                $this->data->device->identified = true;
            }
        }
    }

    private function identifyBasedOnModel($model)
    {
        $device = Data\DeviceModels::identify('bada', $model);
        if ($device->identified) {
            $device->identified |= $this->data->device->identified;
            $this->data->device = $device;

            if (!isset($this->data->os->name) || $this->data->os->name != 'Bada') {
                $this->data->os->name = 'Bada';
                $this->data->os->version = null;
            }

            return true;
        }

        $device = Data\DeviceModels::identify('blackberry', $model);
        if ($device->identified) {
            $device->identified |= $this->data->device->identified;
            $this->data->device = $device;

            if (!isset($this->data->os->name) || $this->data->os->name != 'BlackBerry OS') {
                $this->data->os->name = 'BlackBerry OS';
                $this->data->os->version = null;
            }

            return true;
        }

        $device = Data\DeviceModels::identify('wm', $model);
        if ($device->identified) {
            $device->identified |= $this->data->device->identified;
            $this->data->device = $device;

            if (!isset($this->data->os->name) || $this->data->os->name != 'Windows Mobile') {
                $this->data->os->name = 'Windows Mobile';
                $this->data->os->version = null;
            }

            return true;
        }
    }
}
