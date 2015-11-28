<?php

	namespace WhichBrowser\Analyser;

	use WhichBrowser\Constants;
	use WhichBrowser\Data;
	use WhichBrowser\Family;
	use WhichBrowser\Using;
	use WhichBrowser\Version;

	trait HeaderUseragentDeviceCars {


		private function detectCarsFromUseragent($ua) {

			if (preg_match('/Car/u', $ua)) $this->detectTeslaFromUseragent($ua);
		}





		/* Tesla S */

		private function detectTeslaFromUseragent($ua) {
			if (preg_match('/QtCarBrowser/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Tesla';
				$this->device->model = 'Model S';
				$this->device->type = Constants\DeviceType::CAR;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}
		}
	}