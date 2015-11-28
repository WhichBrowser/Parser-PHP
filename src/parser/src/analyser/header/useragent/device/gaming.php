<?php

	namespace WhichBrowser\Analyser\Header\Useragent\Device;

	use WhichBrowser\Constants;
	use WhichBrowser\Data;
	use WhichBrowser\Family;
	use WhichBrowser\Using;
	use WhichBrowser\Version;

	trait Gaming {


		private function detectGamingFromUseragent($ua) {

			if (preg_match('/Nintendo/iu', $ua)) $this->detectNintendoFromUseragent($ua);

			if (preg_match('/PlayStation/iu', $ua)) $this->detectPlaystationFromUseragent($ua);

			if (preg_match('/Xbox/iu', $ua)) $this->detectXboxFromUseragent($ua);
		}





		/* Nintendo Wii and DS */

		private function detectNintendoFromUseragent($ua) {

			/* Wii */

			if (preg_match('/Nintendo Wii/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'Wii';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::CONSOLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/* Wii U */

			if (preg_match('/Nintendo Wii ?U/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'Wii U';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::CONSOLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/* DS */

			if (preg_match('/Nintendo DS/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'DS';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::PORTABLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/* DSi */

			if (preg_match('/Nintendo DSi/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'DSi';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::PORTABLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/* 3DS */

			if (preg_match('/Nintendo 3DS/u', $ua)) {
				$this->os->name = '';

				if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = '3DS';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::PORTABLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/* New 3DS */

			if (preg_match('/New Nintendo 3DS/u', $ua)) {
				$this->os->name = '';

				if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'New 3DS';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::PORTABLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}
		}


		/* Sony PlayStation */

		private function detectPlaystationFromUseragent($ua) {

			/* PlayStation Portable */

			if (preg_match('/PlayStation Portable/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation Portable';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::PORTABLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/* PlayStation Vita */

			if (preg_match('/PlayStation Vita ([0-9.]*)/u', $ua, $match)) {
				$this->os->name = '';
				$this->os->version = new Version([ 'value' => $match[1] ]);

				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation Vita';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::PORTABLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;

				if (preg_match('/VTE\//u', $ua, $match)) {
					$this->device->model = 'Playstation TV';
				}
			}

			/* PlayStation 3 */

			if (preg_match('/PlayStation 3/ui', $ua)) {
				$this->os->name = '';

				if (preg_match('/PLAYSTATION 3;? ([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation 3';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::CONSOLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/* PlayStation 4 */

			if (preg_match('/PlayStation 4/ui', $ua)) {
				$this->os->name = '';

				if (preg_match('/PlayStation 4 ([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation 4';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::CONSOLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}
		}


		/* Microsoft Xbox */

		private function detectXboxFromUseragent($ua) {

			/* Xbox 360 */

			if (preg_match('/Xbox\)$/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Microsoft';
				$this->device->model = 'Xbox 360';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::CONSOLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/* Xbox One */

			if (preg_match('/Xbox One\)/u', $ua, $match)) {
				if ($this->isOs('Windows Phone', '=', '10')) {
					$this->os->name = 'Windows';
					$this->os->version->alias = '10';
				}

				if (!$this->isOs('Windows', '=', '10')) {
					unset($this->os->name);
					unset($this->os->version);
				}

				$this->device->manufacturer = 'Microsoft';
				$this->device->model = 'Xbox One';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::CONSOLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

		}
	}
