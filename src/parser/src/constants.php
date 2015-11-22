<?php


	namespace WhichBrowser\Constants;

	class DeviceType {
		const DESKTOP = 'desktop';
		const MOBILE = 'mobile';
		const DECT = 'dect';
		const TABLET = 'tablet';
		const GAMING = 'gaming';
		const EREADER = 'ereader';
		const MEDIA = 'media';
		const HEADSET = 'headset';
		const WATCH = 'watch';
		const EMULATOR = 'emulator';
		const TELEVISION = 'television';
		const MONITOR = 'monitor';
		const CAMERA = 'camera';
		const SIGNAGE = 'signage';
		const WHITEBOARD = 'whiteboard';
		const DEVBOARD = 'devboard';
		const GPS = 'gps';
		const CAR = 'car';
		const POS = 'pos';
		const BOT = 'bot';
	}

	class DeviceSubType {
		const FEATURE = 'feature';
		const SMART = 'smart';
		const CONSOLE = 'console';
		const PORTABLE = 'portable';
	}

	class Flag {
		const GOOGLETV = 1;
		const GOOGLEGLASS = 2;
		const ANDROIDWEAR = 4;
		const ANDROIDTV = 8;
		const NOKIAX = 16;
		const FIREOS = 32;
	}

	class Id {
		const NONE = 0;
		const INFER = 1;
		const PATTERN = 2;
		const MATCH_UA = 4;
		const MATCH_PROF = 8;
	}

	class EngineType {
		const TRIDENT = 1;
		const PRESTO = 2;
		const CHROMIUM = 3;
		const GECKO = 8;
		const WEBKIT = 16;
		const V8 = 32;
	}

	class Feature {
		const SANDBOX = 1;
		const WEBSOCKET = 2;
		const WORKER = 4;
		const APPCACHE = 8;
		const HISTORY = 16;
		const FULLSCREEN = 32;
		const FILEREADER = 64;
	}
