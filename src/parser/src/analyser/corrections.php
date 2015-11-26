<?php

	namespace WhichBrowser\Analyser;

	use WhichBrowser\Constants;
	use WhichBrowser\Family;
	use WhichBrowser\Using;
	use WhichBrowser\Version;

	trait Corrections {

		private function applyCorrections() {
			if (isset($this->browser->name) && isset($this->os->name)) $this->hideBrowserBasedOnOperatingSystem();
			if (isset($this->browser->name) && $this->device->type == Constants\DeviceType::TELEVISION) $this->hideBrowserOnDeviceTypeTelevision();
		}			

		private function hideBrowserBasedOnOperatingSystem() {
			if ($this->os->name == 'Series80' && $this->browser->name == 'Internet Explorer') {
				$this->browser->name = null;
				$this->browser->version = null;
			}

			if ($this->os->name == 'Tizen' && $this->browser->name == 'Chrome') {
				$this->browser->name = null;
				$this->browser->version = null;
			}

			if ($this->os->name == 'Ubuntu Touch' && $this->browser->name == 'Chromium') {
				$this->browser->name = null;
				$this->browser->version = null;
			}
		}

		private function hideBrowserOnDeviceTypeTelevision() {
			switch ($this->browser->name) 
			{
				case 'Firefox':				unset($this->browser->name);
											unset($this->browser->version);
											break;

				case 'Internet Explorer':	$valid = false;
											if (isset($this->device->model) && in_array($this->device->model, [ 'WebTV' ])) $valid = true;

											if (!$valid) {
												unset($this->browser->name);
												unset($this->browser->version);
											}

											break;

				case 'Chrome':
				case 'Chromium':			$valid = false;
											if (isset($this->os->name) && in_array($this->os->name, [ 'Google TV', 'Android' ])) $valid = true;
											if (isset($this->device->model) && in_array($this->device->model, [ 'Chromecast' ])) $valid = true;

											if (!$valid) {
												unset($this->browser->name);
												unset($this->browser->version);
											}

											break;
			}
		}
	}