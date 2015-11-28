<?php

	namespace WhichBrowser\Data;
	

	class Chrome {
		static $DESKTOP = [];
		static $MOBILE = [];
	
		static function getChannel($platform, $version) {
			require_once __DIR__ . '/../../data/browsers-chrome.php';

			$version = implode('.', array_slice(explode('.', $version), 0, 3));

			switch($platform) {
				case 'desktop':	if (isset(Chrome::$DESKTOP[$version])) return Chrome::$DESKTOP[$version]; break;
				case 'mobile':	if (isset(Chrome::$MOBILE[$version])) return Chrome::$MOBILE[$version]; break;
			}

			return 'canary';
		}
	}