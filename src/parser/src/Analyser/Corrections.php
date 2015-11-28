<?php

	namespace WhichBrowser\Analyser;

	use WhichBrowser\Constants;
	use WhichBrowser\Model\Family;
	use WhichBrowser\Model\Using;
	use WhichBrowser\Model\Version;

	trait Corrections {

		private function applyCorrections() {
			if (isset($this->device->model)) $this->hideDeviceModelIfMatchesLanguage();
			if (isset($this->browser->name) && isset($this->os->name)) $this->hideBrowserBasedOnOperatingSystem();
			if (isset($this->browser->name) && isset($this->os->name)) $this->correctVersionOfMobileInternetExplorer();
			if (isset($this->browser->name) && $this->device->type == Constants\DeviceType::TELEVISION) $this->hideBrowserOnDeviceTypeTelevision();
			if ($this->device->type == Constants\DeviceType::TELEVISION) $this->hideOsOnDeviceTypeTelevision();
			if (isset($this->browser->name) && isset($this->engine->name)) $this->fixMidoriEngineName();
		}			

		private function hideDeviceModelIfMatchesLanguage() {
			if (!$this->device->identified) {
				if (preg_match('/^[a-z][a-z]-[a-z][a-z]$/u', $this->device->model)) {
					$this->device->model = null;
				}
			}
		}

		private function fixMidoriEngineName() {
			if ($this->browser->name == 'Midori' && $this->engine->name != 'Webkit') {
				$this->engine->name = 'Webkit';
				$this->engine->version = null;
			}
		}

		private function correctVersionOfMobileInternetExplorer() {
			if ($this->os->name == 'Windows Phone' && $this->browser->name == 'Mobile Internet Explorer') {
				if ($this->os->version->toFloat() == 8.0 && $this->browser->version->toNumber() < 10) {
					$this->browser->version = new Version([ 'value' => '10' ]);
				}

				if ($this->os->version->toFloat() == 8.1 && $this->browser->version->toNumber() < 11) {
					$this->browser->version = new Version([ 'value' => '11' ]);
				}
			}
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

		private function hideOsOnDeviceTypeTelevision() {
			if (isset($this->os->name) && !in_array($this->os->name, [ 'Aliyun OS', 'Tizen', 'Android', 'Android TV', 'FireOS', 'Google TV', 'Firefox OS' ])) {
				unset($this->os->name);
				unset($this->os->version);
			}
		}
	}