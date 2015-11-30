<?php

namespace WhichBrowser\Analyser\Header;

use WhichBrowser\Data;

class OperaMini
{
    public function __construct($header, &$data)
    {
        $this->data =& $data;

        @list($manufacturer, $model) = explode(' # ', $header);

        if ($manufacturer != '?' && $model != '?') {
            if (!$this->data->device->identified && $this->data->os->name == 'Bada') {
                $device = Data\DeviceModels::identify('bada', $model);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            if (!$this->data->device->identified && $this->data->os->name == 'Blackberry') {
                $device = Data\DeviceModels::identify('blackberry', $model);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            if (!$this->data->device->identified && $this->data->os->name == 'Windows Mobile') {
                $device = Data\DeviceModels::identify('wm', $model);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            if (!$this->data->device->identified) {
                $this->data->device->manufacturer = $manufacturer;
                $this->data->device->model = $model;
                $this->data->device->identified = true;
            }
        }
    }
}
