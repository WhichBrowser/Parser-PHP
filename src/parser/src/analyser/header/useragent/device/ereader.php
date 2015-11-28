<?php

	namespace WhichBrowser\Analyser\Header\Useragent\Device;

	use WhichBrowser\Constants;
	use WhichBrowser\Data;
	use WhichBrowser\Family;
	use WhichBrowser\Using;
	use WhichBrowser\Version;

	trait Ereader {


		private function detectEreaderFromUseragent($ua) {

			$this->detectKindleFromUseragent($ua);

			$this->detectNookFromUseragent($ua);

			$this->detectBookeenFromUseragent($ua);

			$this->detectKoboFromUseragent($ua);

			$this->detectSonyreaderFromUseragent($ua);

			$this->detectPocketbookFromUseragent($ua);

			$this->detectIriverFromUseragent($ua);
		}




		/* Amazon Kindle */

		private function detectKindleFromUseragent($ua) {
			if (preg_match('/Kindle/u', $ua) && !preg_match('/Fire/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Amazon';
				$this->device->series = 'Kindle';
				$this->device->type = Constants\DeviceType::EREADER;

				if (preg_match('/Kindle\/1.0/u', $ua)) $this->device->model = 'Kindle 1';
				if (preg_match('/Kindle\/2.0/u', $ua)) $this->device->model = 'Kindle 2';
				if (preg_match('/Kindle\/2.5/u', $ua)) $this->device->model = 'Kindle 2';
				if (preg_match('/Kindle\/3.0/u', $ua)) $this->device->model = 'Kindle 3';
				if (preg_match('/Kindle\/3.0\+/u', $ua)) $this->device->model = 'Kindle 3 or later';
				if (preg_match('/Kindle SkipStone/u', $ua)) $this->device->model = 'Kindle Touch or later';

				if (!empty($this->device->model)) $this->device->series = null;

				$this->device->identified |= Constants\Id::MATCH_UA;
			}
		}


		/* Barnes & Noble Nook */

		private function detectNookFromUseragent($ua) {
			if (preg_match('/nook browser/u', $ua)) {
				$this->os->name = 'Android';

				$this->device->manufacturer = 'Barnes & Noble';
				$this->device->series = 'NOOK';
				$this->device->type = Constants\DeviceType::EREADER;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}
		}


		/* Bookeen */

		private function detectBookeenFromUseragent($ua) {
			if (preg_match('/bookeen\/cybook/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Bookeen';
				$this->device->series = 'Cybook';
				$this->device->type = Constants\DeviceType::EREADER;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}
		}


		/* Kobo */

		private function detectKoboFromUseragent($ua) {
			if (preg_match('/Kobo Touch/u', $ua, $match)) {
				$this->os->name = '';
				$this->os->version = null;

				$this->device->manufacturer = 'Kobo';
				$this->device->series = 'eReader';
				$this->device->type = Constants\DeviceType::EREADER;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}
		}


		/* Sony Reader */

		private function detectSonyreaderFromUseragent($ua) {
			if (preg_match('/EBRD([0-9]+)/u', $ua, $match)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Sony';
				$this->device->series = 'Reader';
				$this->device->type = Constants\DeviceType::EREADER;
				$this->device->identified |= Constants\Id::MATCH_UA;

				switch($match[1]) {
					case '1101':	$this->device->model = 'PRS-T1'; $this->device->generic = false; break;
					case '1102':	$this->device->model = 'PRS-T1'; $this->device->generic = false; break;
					case '1201':	$this->device->model = 'PRS-T2'; $this->device->generic = false; break;
					case '1301':	$this->device->model = 'PRS-T3'; $this->device->generic = false; break;
				}
			}
		}


		/* PocketBook */

		private function detectPocketbookFromUseragent($ua) {
			if (preg_match('/PocketBook\/([0-9]+)/u', $ua, $match)) {
				$this->os->name = '';

				$this->device->manufacturer = 'PocketBook';
				$this->device->type = Constants\DeviceType::EREADER;
				$this->device->identified |= Constants\Id::MATCH_UA;

				switch($match[1]) {
					case '515':	$this->device->model = 'Mini'; $this->device->generic = false; break;
					case '614':	$this->device->model = 'Basic 2'; $this->device->generic = false; break;
					case '622':	$this->device->model = 'Touch'; $this->device->generic = false; break;
					case '623':	$this->device->model = 'Touch Lux'; $this->device->generic = false; break;
					case '624':	$this->device->model = 'Basic Touch'; $this->device->generic = false; break;
					case '626':	$this->device->model = 'Touch Lux 2'; $this->device->generic = false; break;
					case '630':	$this->device->model = 'Sense'; $this->device->generic = false; break;
					case '640':	$this->device->model = 'Auqa'; $this->device->generic = false; break;
					case '650':	$this->device->model = 'Ultra'; $this->device->generic = false; break;
					case '801':	$this->device->model = 'Color Lux'; $this->device->generic = false; break;
					case '840':	$this->device->model = 'InkPad'; $this->device->generic = false; break;
				}
			}
		}


		/* iRiver */

		private function detectIriverFromUseragent($ua) {
			if (preg_match('/Iriver ;/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'iRiver';
				$this->device->series = 'Story';
				$this->device->type = Constants\DeviceType::EREADER;

				if (preg_match('/EB07/u', $ua)) {
					$this->device->model = 'Story HD EB07'; $this->device->generic = false;
				}

				$this->device->identified |= Constants\Id::MATCH_UA;
			}
		}
	}