<?php

	namespace WhichBrowser\Analyser;

	use WhichBrowser\Constants;
	use WhichBrowser\Data;

	trait OperaMini {

		private function analyseOperaMiniPhone($ua) {
			@list($manufacturer, $model) = explode(' # ', $ua);

			if ($manufacturer != '?' && $model != '?') {
				if (!$this->device->identified && $this->os->name == 'Bada') {
					$device = Data\DeviceModels::identify('bada', $model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}

				if (!$this->device->identified && $this->os->name == 'Blackberry') {
					$device = Data\DeviceModels::identify('blackberry', $model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}

				if (!$this->device->identified && $this->os->name == 'Windows Mobile') {
					$device = Data\DeviceModels::identify('wm', $model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}

				if (!$this->device->identified) {
					$this->device->manufacturer = $manufacturer;
					$this->device->model = $model;
					$this->device->identified = true;
				}
			}
		}
	}