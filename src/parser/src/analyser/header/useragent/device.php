<?php

	namespace WhichBrowser\Analyser\Header\Useragent;


	include_once 'device/cars.php';
	include_once 'device/ereader.php';
	include_once 'device/gaming.php';
	include_once 'device/mobile.php';
	include_once 'device/media.php';
	include_once 'device/television.php';
	include_once 'device/signage.php';


	trait Device {

		use Device\Cars, Device\Gaming, Device\Ereader, Device\Mobile, 
			Device\Media, Device\Television, Device\Signage;

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