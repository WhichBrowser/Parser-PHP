<?php

	namespace WhichBrowser\Analyser;

	use WhichBrowser\Constants;
	use WhichBrowser\Data;
	use WhichBrowser\Version;

	trait UC {

		private function analyseOldUCUserAgent($ua) {
			if ($this->device->type == Constants\DeviceType::DESKTOP) {
				$this->device->type = Constants\DeviceType::MOBILE;

				unset($this->os->name);
				unset($this->os->version);
			}
			if (!isset($this->browser->name) || $this->browser->name != 'UC Browser') {
				$this->browser->name = 'UC Browser';
				$this->browser->version = null;
			}

			$extra = new Parser([ 'headers' => [ 'User-Agent' => $ua ]]);
			if ($extra->device->type != Constants\DeviceType::DESKTOP) {
				if (isset($extra->os->version)) $this->os = $extra->os;
				if ($extra->device->identified) $this->device = $extra->device;
			}
		}

		private function analyseNewUCUserAgent($ua) {
			if (preg_match('/pr\(UCBrowser\/([0-9\.]+)/u', $ua, $match)) {
				$this->browser->name = 'UC Browser';
				$this->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
				$this->browser->stock = false;
			}

			/* Find os */
			if (preg_match('/ov\(Android ([0-9\.]+)/u', $ua, $match)) {
				$this->os->name = 'Android';
				$this->os->version = new Version([ 'value' => $match[1] ]);
			}

			if (preg_match('/pf\(Symbian\)/u', $ua) && preg_match('/ov\(S60V5/u', $ua)) {
				if (!isset($this->os->name) || $this->os->name != 'Series60') {
					$this->os->name = 'Series60';
					$this->os->version = new Version([ 'value' => 5 ]);
				}
			}

			if (preg_match('/pf\(Windows\)/u', $ua) && preg_match('/ov\(wds ([0-9\.]+)/u', $ua, $match)) {
				if (!isset($this->os->name) || $this->os->name != 'Windows Phone') {
					$this->os->name = 'Windows Phone';

					switch($match[1]) {
						case '7.0':		$this->os->version = new Version([ 'value' => '7.0' ]); break;
						case '7.1':		$this->os->version = new Version([ 'value' => '7.5' ]); break;
						case '8.0':		$this->os->version = new Version([ 'value' => '8.0' ]); break;
					}
				}
			}

			if (preg_match('/pf\((?:42|44)\)/u', $ua) && preg_match('/ov\((?:iPh OS )?(?:iOS )?([0-9\_]+)/u', $ua, $match)) {
				if (!isset($this->os->name) || $this->os->name != 'iOS') {
					$this->os->name = 'iOS';
					$this->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
				}
			}

			/* Find engine */
			if (preg_match('/re\(AppleWebKit\/([0-9\.]+)/u', $ua, $match)) {
				$this->engine->name = 'Webkit';
				$this->engine->version = new Version([ 'value' => $match[1] ]);
			}

			/* Find device */
			if (isset($this->os->name) && $this->os->name == 'Android') {
				if (preg_match('/dv\((.*)\)/uU', $ua, $match)) {
					$match[1] = preg_replace("/\s+Build/u", '', $match[1]);
					$device = Data\DeviceModels::identify('android', $match[1]);

					if ($device) {
						$this->device = $device;
					}
				}
			}

			if (isset($this->os->name) && $this->os->name == 'Series60') {
				if (preg_match('/dv\((?:Nokia)?([^\)]*)\)/u', $ua, $match)) {
					$device = Data\DeviceModels::identify('s60', $match[1]);

					if ($device) {
						$this->device = $device;
					}
				}
			}

			if (isset($this->os->name) && $this->os->name == 'Windows Phone') {
				if (preg_match('/dv\(([^\)]*)\)/u', $ua, $match)) {
					$device = Data\DeviceModels::identify('wp', substr(strstr($match[1], ' '), 1));

					if ($device) {
						$this->device = $device;
					}
				}
			}

			if (isset($this->os->name) && $this->os->name == 'iOS') {
				if (preg_match('/dv\(([^\)]*)\)/u', $ua, $match)) {
					$device = Data\DeviceModels::identify('ios', $match[1]);

					if ($device) {
						$this->device = $device;
					}
				}
			}
		}
	}