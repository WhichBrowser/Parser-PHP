<?php

	namespace WhichBrowser\Analyser;

	use WhichBrowser\Constants;
	use WhichBrowser\Data;

	trait Puffin {

		private function analysePuffinUserAgent($ua) {
			$parts = explode('/', $ua);

			if ($this->browser->name != 'Puffin') {
				$this->browser->name = 'Puffin';
				$this->browser->version = null;
				$this->browser->stock = false;
			}

			$this->device->type = 'mobile';

			if (count($parts) > 1 && $parts[0] == 'Android') {
				if (!isset($this->os->name) || $this->os->name != 'Android') {
					$this->os->name = 'Android';
					$this->os->version = null;
				}

				$device = Data\DeviceModels::identify('android', $parts[1]);
				if ($device->identified) {
					$device->identified |= $this->device->identified;
					$this->device = $device;
				}
			}

			if (count($parts) > 1 && $parts[0] == 'iPhone OS') {
				if (!isset($this->os->name) || $this->os->name != 'iOS') {
					$this->os->name = 'iOS';
					$this->os->version = null;
				}

				$device = Data\DeviceModels::identify('ios', $parts[1]);

				if ($device->identified) {
					$device->identified |= $this->device->identified;
					$this->device = $device;
				}
			}
		}
	}