<?php

	namespace WhichBrowser\Analyser\Header;

	use WhichBrowser\Constants;
	use WhichBrowser\Data;
	use WhichBrowser\Family;
	use WhichBrowser\Using;
	use WhichBrowser\Version;


	include_once 'useragent/os.php';
	include_once 'useragent/device.php';
	include_once 'useragent/browser.php';
	include_once 'useragent/engine.php';
	include_once 'useragent/bot.php';


	trait Useragent {

		use Useragent\Os, Useragent\Device, Useragent\Browser, Useragent\Engine, Useragent\Bot;


		private function analyseUserAgent($ua) {
			$ua = preg_replace("/^(Mozilla\/[0-9]\.[0-9].*)\s+Mozilla\/[0-9]\.[0-9].*$/iu", '$1', $ua);

			$this->detectOperatingSystemFromUseragent($ua);

			$this->detectDeviceFromUseragent($ua);

			$this->detectBrowserFromUseragent($ua);

			$this->detectEngineFromUseragent($ua);

			$this->detectBotBasedOnUserAgent($ua);

			$this->refineBrowserFromUseragent($ua);
			
			$this->refineOperatingSystemFromUseragent($ua);
		}
	}