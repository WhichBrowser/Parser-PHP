<?php

	namespace WhichBrowser\Analyser\Header\Useragent;


	include_once 'Device/Cars.php';
	include_once 'Device/Ereader.php';
	include_once 'Device/Gaming.php';
	include_once 'Device/Mobile.php';
	include_once 'Device/Media.php';
	include_once 'Device/Television.php';
	include_once 'Device/Signage.php';


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