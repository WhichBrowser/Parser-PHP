<?php

	namespace WhichBrowser\Analyser;

	use WhichBrowser\Constants;
	use WhichBrowser\Data;
	use WhichBrowser\Family;
	use WhichBrowser\Using;
	use WhichBrowser\Version;


	include_once 'device/cars.php';
	include_once 'device/ereader.php';
	include_once 'device/gaming.php';
	include_once 'device/mobile.php';
	include_once 'device/media.php';
	include_once 'device/television.php';
	include_once 'device/signage.php';


	trait HeaderUseragentDevice {

		use HeaderUseragentDeviceCars, HeaderUseragentDeviceGaming, HeaderUseragentDeviceEreader,
			HeaderUseragentDeviceMobile, HeaderUseragentDeviceMedia, HeaderUseragentDeviceTelevision,
			HeaderUseragentDeviceSignage;


		private function detectDeviceFromUseragent($ua) {

			$this->detectCarsFromUseragent($ua);
			$this->detectEreaderFromUseragent($ua);
			$this->detectGamingFromUseragent($ua);
			$this->detectTelevisionFromUseragent($ua);
			$this->detectSignageFromUseragent($ua);
			$this->detectMediaFromUseragent($ua);
			$this->detectMobileFromUseragent($ua);
		}
	}