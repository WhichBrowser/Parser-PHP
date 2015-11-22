<?php

	namespace WhichBrowser\Analyser;

	use WhichBrowser\Constants;
	use WhichBrowser\Data;

	trait BrowserId {

		private function analyseBrowserId($id) {
			$browser = Data\BrowserIds::identify('android', $id);
			if ($browser) {
				if (!isset($this->browser->name)) {
					$this->browser->name = $browser;
				}
				else {
					if (substr($this->browser->name, 0, strlen($browser)) != $browser) {
						$this->browser->name = $browser;
						$this->browser->version = null;
						$this->browser->stock = false;
					}
					else {
						$this->browser->name = $browser;
					}
				}
			}

			/* The X-Requested-With header is send by the WebView, so our browser name is Chrome it is probably the Chromium WebView which is sometimes misidentified. */
			if (isset($this->browser->name) && $this->browser->name == 'Chrome') {
				$this->browser->stock = true;
				$this->browser->name = null;
				$this->browser->version = null;
				$this->browser->channel = null;
			}

			/* The X-Requested-With header is only send from Android devices */
			if (!isset($this->os->name) || ($this->os->name != 'Android' && (!isset($this->os->family) || $this->os->family->getName() != 'Android'))) {
				$this->os->name = 'Android';
				$this->os->alias = null;
				$this->os->version = null;

				$this->device->manufacturer = null;
				$this->device->model = null;
				$this->device->identified = Constants\Id::NONE;

				if ($this->device->type != Constants\DeviceType::MOBILE && $this->device->type != Constants\DeviceType::TABLET) {
					$this->device->type = Constants\DeviceType::MOBILE;
				}
			}

			/* The X-Requested-With header is send by the WebKit or Chromium Webview */
			if (!isset($this->engine->name) || ($this->engine->name != 'Webkit' && $this->engine->name != 'Blink')) {
				$this->engine->name = 'Webkit';
				$this->engine->version = null;
			}
		}
	}