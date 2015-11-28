<?php

	namespace WhichBrowser\Analyser;

	use WhichBrowser\Constants;
	use WhichBrowser\Data;
	use WhichBrowser\Family;
	use WhichBrowser\Using;
	use WhichBrowser\Version;


	include_once 'header-useragent/os.php';
	include_once 'header-useragent/device.php';
	include_once 'header-useragent/browser.php';
	include_once 'header-useragent/engine.php';
	include_once 'header-useragent/bot.php';


	trait HeaderUseragent {

		use HeaderUseragentOs, HeaderUseragentDevice, HeaderUseragentBrowser, HeaderUseragentEngine, HeaderUseragentBot;


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