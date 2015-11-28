<?php

	/* 
		This file is here for backwards compatiblity with the old
		unsupported non-namespaced WhichBrowser object
	*/

	include_once __DIR__ . '/../bootstrap.php';

	define ('TYPE_DESKTOP', 'desktop');
	define ('TYPE_MOBILE', 'mobile');
	define ('TYPE_DECT', 'dect');
	define ('TYPE_TABLET', 'tablet');
	define ('TYPE_GAMING', 'gaming');
	define ('TYPE_EREADER', 'ereader');
	define ('TYPE_MEDIA', 'media');
	define ('TYPE_HEADSET', 'headset');
	define ('TYPE_WATCH', 'watch');
	define ('TYPE_EMULATOR', 'emulator');
	define ('TYPE_TELEVISION', 'television');
	define ('TYPE_MONITOR', 'monitor');
	define ('TYPE_CAMERA', 'camera');
	define ('TYPE_SIGNAGE', 'signage');
	define ('TYPE_WHITEBOARD', 'whiteboard');
	define ('TYPE_GPS', 'gps');
	define ('TYPE_CAR', 'car');
	define ('TYPE_POS', 'pos');
	define ('TYPE_BOT', 'bot');

	define ('FLAG_GOOGLETV', 1);
	define ('FLAG_GOOGLEGLASS', 2);
	define ('FLAG_ANDROIDWEAR', 4);
	define ('FLAG_ANDROIDTV', 8);
	define ('FLAG_NOKIAX', 16);
	define ('FLAG_FIREOS', 32);

	define ('ID_NONE', 0);
	define ('ID_INFER', 1);
	define ('ID_PATTERN', 2);
	define ('ID_MATCH_UA', 4);
	define ('ID_MATCH_PROF', 8);

	define ('ENGINE_TRIDENT', 1);
	define ('ENGINE_PRESTO', 2);
	define ('ENGINE_CHROMIUM', 4);
	define ('ENGINE_GECKO', 8);
	define ('ENGINE_WEBKIT', 16);
	define ('ENGINE_V8', 32);
	
	define ('FEATURE_SANDBOX', 1);
	define ('FEATURE_WEBSOCKET', 2);
	define ('FEATURE_WORKER', 4);
	define ('FEATURE_APPCACHE', 8);
	define ('FEATURE_HISTORY', 16);
	define ('FEATURE_FULLSCREEN', 32);
	define ('FEATURE_FILEREADER', 64);

	class WhichBrowser extends WhichBrowser\Parser {
	}

