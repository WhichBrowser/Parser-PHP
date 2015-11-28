<?php

	namespace WhichBrowser\Data;
	

	class BrowserIds {
		static $ANDROID_BROWSERS = [];

		static function identify($type, $model) {
			require_once __DIR__ . '/../../data/id-' . $type . '.php';

			switch($type) {
				case 'android':		return self::identifyList(BrowserIds::$ANDROID_BROWSERS, $model);
			}

			return false;
		}

		static function identifyList($list, $id) {
			if (isset($list[$id])) {
				return $list[$id];
			}

			return false;
		}
	}