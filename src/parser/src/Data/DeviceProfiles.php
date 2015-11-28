<?php

	namespace WhichBrowser\Data;
	

	class DeviceProfiles {
		static $PROFILES = [];

		static function identify($url) {
			require_once __DIR__ . '/../../data/profiles.php';

			if (isset(self::$PROFILES[$url])) {
				return self::$PROFILES[$url];
			}

			return false;
		}
	}

