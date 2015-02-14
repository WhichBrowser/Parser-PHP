<?php

	/*
		Copyright (c) 2010-2014 Niels Leenheer

		Permission is hereby granted, free of charge, to any person obtaining
		a copy of this software and associated documentation files (the
		"Software"), to deal in the Software without restriction, including
		without limitation the rights to use, copy, modify, merge, publish,
		distribute, sublicense, and/or sell copies of the Software, and to
		permit persons to whom the Software is furnished to do so, subject to
		the following conditions:

		The above copyright notice and this permission notice shall be
		included in all copies or substantial portions of the Software.

		THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
		EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
		MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
		NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
		LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
		OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
		WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
	*/


	define ('_BASEPATH_', dirname(__FILE__) . '/');


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



	class WhichBrowser {

		function __construct($options) {
			$this->options = (object) $options;
			$this->headers = array();
			if (isset($this->options->headers)) $this->headers = $this->options->headers;

			$this->browser = (object) array('stock' => true, 'hidden' => false, 'channel' => '', 'mode' => '');
			$this->engine = (object) array();
			$this->os = (object) array();
			$this->device = (object) array('type' => '', 'identified' => ID_NONE, 'generic' => true);

			$this->camouflage = false;
			$this->features = array();

			$this->analyseUserAgent($this->hasHeader('User-Agent') ? $this->getHeader('User-Agent') : '');

			if ($this->hasHeader('X-Original-User-Agent')) $this->analyseAlternativeUserAgent($this->getHeader('X-Original-User-Agent'));
			if ($this->hasHeader('X-Device-User-Agent')) $this->analyseAlternativeUserAgent($this->getHeader('X-Device-User-Agent'));
			if ($this->hasHeader('Device-Stock-UA')) $this->analyseAlternativeUserAgent($this->getHeader('Device-Stock-UA'));
			if ($this->hasHeader('X-OperaMini-Phone-UA')) $this->analyseAlternativeUserAgent($this->getHeader('X-OperaMini-Phone-UA'));
			if ($this->hasHeader('X-OperaMini-Phone')) $this->analyseOperaMiniPhone($this->getHeader('X-OperaMini-Phone'));
			if ($this->hasHeader('X-UCBrowser-Device-UA')) $this->analyseAlternativeUserAgent($this->getHeader('X-UCBrowser-Device-UA'));
			if ($this->hasHeader('X-UCBrowser-Phone-UA')) $this->analyseOldUCUserAgent($this->getHeader('X-UCBrowser-Phone-UA'));
			if ($this->hasHeader('X-UCBrowser-UA')) $this->analyseNewUCUserAgent($this->getHeader('X-UCBrowser-UA'));
			if ($this->hasHeader('X-Puffin-UA')) $this->analysePuffinUserAgent($this->getHeader('X-Puffin-UA'));
			if ($this->hasHeader('Baidu-FlyFlow')) $this->analyseBaiduHeader($this->getHeader('Baidu-FlyFlow'));
			if ($this->hasHeader('X-Requested-With')) $this->analyseBrowserId($this->getHeader('X-Requested-With'));
			if ($this->hasHeader('X-Wap-Profile')) $this->analyseWapProfile($this->getHeader('X-Wap-Profile'));

			$this->detectCamouflage();
		}

		function hasHeader($h) {
			foreach ($this->headers as $k => $v) {
				if (strtolower($h) == strtolower($k)) return true;
			}

			return false;
		}

		function getHeader($h) {
			foreach ($this->headers as $k => $v) {
				if (strtolower($h) == strtolower($k)) return $v;
			}
		}



		function detectCamouflage() {
			if (isset($this->options->useragent) && $this->options->useragent != '') {
				if ($this->options->useragent == 'Mozilla/5.0 (X11; U; Linux i686; zh-CN; rv:1.2.3.4) Gecko/') {

					if ($this->browser->name != 'UC Browser') {
						$this->browser->name = 'UC Browser';
						$this->browser->version = null;
						$this->browser->stock = false;
					}

					if ($this->os->name == 'Windows') {
						$this->os->name = '';
						$this->os->version = null;
					}

					$this->engine->name = 'Gecko';
					$this->engine->version = null;

					$this->device->type = 'mobile';
				}


				if (preg_match('/Mac OS X 10_6_3; ([^;]+); [a-z]{2}-(?:[a-z]{2})?\)/u', $this->options->useragent, $match)) {
					$this->browser->name = '';
					$this->browser->version = null;
					$this->browser->mode = 'desktop';

					$this->os->name = 'Android';
					$this->os->alias = null;
					$this->os->version = null;

					$this->engine->name = 'Webkit';
					$this->engine->version = null;

					$this->features[] = 'foundDevice';
				}

				if (preg_match('/Linux Ventana; [a-z]{2}-[a-z]{2}; (.+) Build/u', $this->options->useragent, $match)) {
					$this->browser->name = '';
					$this->browser->version = null;
					$this->browser->mode = 'desktop';

					$this->os->name = 'Android';
					$this->os->version = null;

					$this->engine->name = 'Webkit';
					$this->engine->version = null;

					$this->features[] = 'foundDevice';
				}

				if (isset($this->browser->name) && $this->browser->name == 'Safari') {
					preg_match('/AppleWebKit\/([0-9]+.[0-9]+)/iu', $this->options->useragent, $webkitMatch);
					preg_match('/Safari\/([0-9]+.[0-9]+)/iu', $this->options->useragent, $safariMatch);

					if ($this->os->name != 'iOS' && $webkitMatch[1] != $safariMatch[1]) {
						$this->features[] = 'safariMismatch';
						$this->camouflage = true;
					}

					if ($this->os->name == 'iOS' && !preg_match('/^Mozilla/u', $this->options->useragent)) {
						$this->features[] = 'noMozillaPrefix';
						$this->camouflage = true;
					}

					if (!preg_match('/Version\/[0-9\.]+/u', $this->options->useragent)) {
						$this->features[] = 'noVersion';
						$this->camouflage = true;
					}
				}

				if (isset($this->browser->name) && $this->browser->name == 'Chrome') {
					if (!preg_match('/(?:Chrome|CrMo|CriOS)\/([0-9]{1,2}\.[0-9]\.[0-9]{3,4}\.[0-9]+)/u', $this->options->useragent)) {
						$this->features[] = 'wrongVersion';
						$this->camouflage = true;
					}
				}
			}

			if (isset($this->options->engine)) {
				if (isset($this->engine->name) && $this->browser->mode != 'proxy') {


					/* If it claims not to be Trident, but it is probably Trident running camouflage mode */
					if ($this->options->engine & ENGINE_TRIDENT) {
						$this->features[] = 'trident';

						if ($this->engine->name && $this->engine->name != 'Trident') {
							$this->camouflage = !isset($this->browser->name) || ($this->browser->name != 'Maxthon' && $this->browser->name != 'Motorola WebKit');
						}
					}

					/* If it claims not to be Opera, but it is probably Opera running camouflage mode */
					if ($this->options->engine & ENGINE_PRESTO) {
						$this->features[] = 'presto';

						if ($this->engine->name && $this->engine->name != 'Presto') {
							$this->camouflage = true;
						}

						if (isset($this->browser->name) && $this->browser->name == 'Internet Explorer') {
							$this->camouflage = true;
						}
					}

					/* If it claims not to be Gecko, but it is probably Gecko running camouflage mode */
					if ($this->options->engine & ENGINE_GECKO) {
						$this->features[] = 'gecko';

						if ($this->engine->name && $this->engine->name != 'Gecko') {
							$this->camouflage = true;
						}

						if (isset($this->browser->name) && $this->browser->name == 'Internet Explorer') {
							$this->camouflage = true;
						}
					}

					/* If it claims not to be Webkit, but it is probably Webkit running camouflage mode */
					if ($this->options->engine & ENGINE_WEBKIT) {
						$this->features[] = 'webkit';

						if ($this->engine->name && ($this->engine->name != 'Blink' && $this->engine->name != 'Webkit')) {
							$this->camouflage = true;
						}

						if (isset($this->browser->name) && $this->browser->name == 'Internet Explorer') {
							$this->camouflage = true;
						}

						/* IE 11 on mobile now supports Webkit APIs */
						if (isset($this->browser->name) && $this->browser->name == 'Mobile Internet Explorer' &&
							isset($this->browser->version) && $this->browser->version->toFloat() >= 11 &&
							isset($this->os->name) && $this->os->name == 'Windows Phone')
						{
							$this->camouflage = false;
						}

						/* IE 11 Developer Preview now supports  Webkit APIs */
						if (isset($this->browser->name) && $this->browser->name == 'Internet Explorer' &&
							isset($this->browser->version) && $this->browser->version->toFloat() >= 11 &&
							isset($this->os->name) && $this->os->name == 'Windows')
						{
							$this->camouflage = false;
						}

						/* IE / Spartan EdgeHTML rendering engine also appears to be WebKit */
						if (isset($this->engine->name) && $this->engine->name == 'EdgeHTML') {
							$this->camouflage = false;
						}
					}

					if ($this->options->engine & ENGINE_CHROMIUM) {
						$this->features[] = 'chrome';

						if ($this->engine->name && ($this->engine->name != 'EdgeHTML' && $this->engine->name != 'Blink' && $this->engine->name != 'Webkit')) {
							$this->camouflage = true;
						}
					}

					/* If it claims to be Safari and uses V8, it is probably an Android device running camouflage mode */
					if ($this->engine->name == 'Webkit' && $this->options->engine & ENGINE_V8) {
						$this->features[] = 'v8';

						if (isset($this->browser->name) && $this->browser->name == 'Safari') {
							$this->camouflage = true;
						}
					}

				}
			}

			if (isset($this->options->width) && isset($this->options->height)) {
				if (isset($this->device->model)) {
					/* If we have an iPad that is not 768 x 1024, we have an imposter */
					if ($this->device->model == 'iPad') {
						if (($this->options->width != 0 && $this->options->height != 0) && ($this->options->width != 768 && $this->options->height != 1024) && ($this->options->width != 1024 && $this->options->height != 768)) {
							$this->features[] = 'sizeMismatch';
							$this->camouflage = true;
						}
					}

					/* If we have an iPhone or iPod that is not 320 x 480, we have an imposter */
					/*
					if ($this->device->model == 'iPhone' || $this->device->model == 'iPod') {
						if (($this->options->width != 0 && $this->options->height != 0) && 
							($this->options->width != 320 && $this->options->height != 480) && 
							($this->options->width != 480 && $this->options->height != 320)
						) {
							$this->features[] = 'sizeMismatch';
							$this->camouflage = true;
						}
					}
					*/
				}
			}

			if (isset($this->options->features)) {
				if (isset($this->browser->name) && isset($this->os->name)) {

					if ($this->os->name == 'iOS' && $this->browser->name != 'Opera Mini' && $this->browser->name != 'UC Browser' && isset($this->os->version)) {

						if ($this->os->version->toFloat() < 4.0 && $this->options->features & FEATURE_SANDBOX) {
							$this->features[] = 'foundSandbox';
							$this->camouflage = true;
						}

						if ($this->os->version->toFloat() < 4.2 && $this->options->features & FEATURE_WEBSOCKET) {
							$this->features[] = 'foundSockets';
							$this->camouflage = true;
						}

						if ($this->os->version->toFloat() < 5.0 && $this->options->features & FEATURE_WORKER) {
							$this->features[] = 'foundWorker';
							$this->camouflage = true;
						}

						if ($this->os->version->toFloat() > 2.1 && !$this->options->features & FEATURE_APPCACHE) {
							$this->features[] = 'noAppCache';
							$this->camouflage = true;
						}
					}

					if ($this->os->name != 'iOS' && $this->browser->name == 'Safari' && isset($this->browser->version)) {

						if ($this->browser->version->toFloat() < 4.0 && $this->options->features & FEATURE_APPCACHE) {
							$this->features[] = 'foundAppCache';
							$this->camouflage = true;
						}

						if ($this->browser->version->toFloat() < 4.1 && $this->options->features & FEATURE_HISTORY) {
							$this->features[] = 'foundHistory';
							$this->camouflage = true;
						}

						if ($this->browser->version->toFloat() < 5.1 && $this->options->features & FEATURE_FULLSCREEN) {
							$this->features[] = 'foundFullscreen';
							$this->camouflage = true;
						}

						if ($this->browser->version->toFloat() < 5.2 && $this->options->features & FEATURE_FILEREADER) {
							$this->features[] = 'foundFileReader';
							$this->camouflage = true;
						}
					}
				}
			}
		}

		function analyseWapProfile($url) {
			$url = trim($url);

			if ($url[0] == '"') {
				$url = explode(",", $url);
				$url = trim($url[0], '"');
			}

			$result = DeviceProfiles::identify($url);

			if ($result) {
				if ($result[0] && $result[1]) {
					$this->device->manufacturer = $result[0];
					$this->device->model = $result[1];
					$this->device->identified |= ID_MATCH_PROF;
				}

				if ($result[2] && (!isset($this->os->name) || $this->os->name != $result[2])) {
					$this->os->name = $result[2];
					$this->os->version = null;

					$this->engine->name = null;
					$this->engine->version = null;
				}

				if ($result[3]) {
					$this->device->type = $result[3];
				}
			}
		}

		function analyseBrowserId($id) {
			$browser = BrowserIds::identify('android', $id);
			if ($browser) {
				if (!isset($this->browser->name)) {
					$this->browser->name = $browser;
				}
				else {
					if (substr($this->browser->name, 0, strlen($browser)) != $browser) {
						$this->browser->name = $browser;
						$this->browser->version = null;
						$this->browser->stock = false;
					}
					else {
						$this->browser->name = $browser;
					}
				}
			}

			if (!isset($this->os->name) || ($this->os->name != 'Android' && (!isset($this->os->family) || $this->os->family != 'Android'))) {
				$this->os->name = 'Android';
				$this->os->alias = null;
				$this->os->version = null;

				$this->device->manufacturer = null;
				$this->device->model = null;
				$this->device->identified = ID_NONE;

				if ($this->device->type != TYPE_MOBILE && $this->device->type != TYPE_TABLET) {
					$this->device->type = TYPE_MOBILE;
				}
			}

			if (!isset($this->engine->name) || $this->engine->name != 'Webkit') {
				$this->engine->name = 'Webkit';
				$this->engine->version = null;
			}
		}

		function analyseAlternativeUserAgent($ua) {
			$extra = new WhichBrowser(array('headers' => array("User-Agent" => $ua)));

			if ($extra->device->type != TYPE_DESKTOP) {
				if (isset($extra->os->name)) $this->os = $extra->os;
				if ($extra->device->identified) $this->device = $extra->device;
			}
		}

		function analyseBaiduHeader($ua) {
			if (!isset($this->browser->name) || $this->browser->name != 'Baidu Browser') {
				$this->browser->name = 'Baidu Browser';
				$this->browser->version = null;
				$this->browser->stock = false;
			}
		}

		function analyseOldUCUserAgent($ua) {
			if ($this->device->type == TYPE_DESKTOP) {
				$this->device->type = TYPE_MOBILE;

				unset($this->os->name);
				unset($this->os->version);
			}
			if (!isset($this->browser->name) || $this->browser->name != 'UC Browser') {
				$this->browser->name = 'UC Browser';
				$this->browser->version = null;
			}

			$extra = new WhichBrowser(array('headers' => array("User-Agent" => $ua)));
			if ($extra->device->type != TYPE_DESKTOP) {
				if (isset($extra->os->version)) $this->os = $extra->os;
				if ($extra->device->identified) $this->device = $extra->device;
			}
		}

		function analyseNewUCUserAgent($ua) {
			if (preg_match('/pr\(UCBrowser\/([0-9\.]+)/u', $ua, $match)) {
				$this->browser->name = 'UC Browser';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));
				$this->browser->stock = false;
			}

			/* Find os */
			if (preg_match('/pf\(Linux\)/u', $ua) && preg_match('/ov\(Android ([0-9\.]+)/u', $ua, $match)) {
				$this->os->name = 'Android';
				$this->os->version = new Version(array('value' => $match[1]));
			}

			if (preg_match('/pf\(Symbian\)/u', $ua) && preg_match('/ov\(S60V5/u', $ua)) {
				if (!isset($this->os->name) || $this->os->name != 'Series60') {
					$this->os->name = 'Series60';
					$this->os->version = new Version(array('value' => 5));
				}
			}

			if (preg_match('/pf\(Windows\)/u', $ua) && preg_match('/ov\(wds ([0-9\.]+)/u', $ua, $match)) {
				if (!isset($this->os->name) || $this->os->name != 'Windows Phone') {
					$this->os->name = 'Windows Phone';

					switch($match[1]) {
						case '7.0':		$this->os->version = new Version(array('value' => '7.0')); break;
						case '7.1':		$this->os->version = new Version(array('value' => '7.5')); break;
						case '8.0':		$this->os->version = new Version(array('value' => '8.0')); break;
					}
				}
			}

			if (preg_match('/pf\((?:42|44)\)/u', $ua) && preg_match('/ov\((?:iPh OS )?(?:iOS )?([0-9\_]+)/u', $ua, $match)) {
				if (!isset($this->os->name) || $this->os->name != 'iOS') {
					$this->os->name = 'iOS';
					$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
				}
			}

			/* Find engine */
			if (preg_match('/re\(AppleWebKit\/([0-9\.]+)/u', $ua, $match)) {
				$this->engine->name = 'Webkit';
				$this->engine->version = new Version(array('value' => $match[1]));
			}

			/* Find device */
			if (isset($this->os->name) && $this->os->name == 'Android') {
				if (preg_match('/dv\((.*)\s+Build/u', $ua, $match)) {
					$device = DeviceModels::identify('android', $match[1]);

					if ($device) {
						$this->device = $device;
					}
				}
			}

			if (isset($this->os->name) && $this->os->name == 'Series60') {
				if (preg_match('/dv\((?:Nokia)?([^\)]*)\)/u', $ua, $match)) {
					$device = DeviceModels::identify('s60', $match[1]);

					if ($device) {
						$this->device = $device;
					}
				}
			}

			if (isset($this->os->name) && $this->os->name == 'Windows Phone') {
				if (preg_match('/dv\(([^\)]*)\)/u', $ua, $match)) {
					$device = DeviceModels::identify('wp', substr(strstr($match[1], ' '), 1));

					if ($device) {
						$this->device = $device;
					}
				}
			}

			if (isset($this->os->name) && $this->os->name == 'iOS') {
				if (preg_match('/dv\(([^\)]*)\)/u', $ua, $match)) {
					$device = DeviceModels::identify('ios', $match[1]);

					if ($device) {
						$this->device = $device;
					}
				}
			}
		}

		function analysePuffinUserAgent($ua) {
			$parts = explode('/', $ua);

			if ($this->browser->name != 'Puffin') {
				$this->browser->name = 'Puffin';
				$this->browser->version = null;
				$this->browser->stock = false;
			}

			$this->device->type = 'mobile';

			if (count($parts) > 1 && $parts[0] == 'Android') {
				if (!isset($this->os->name) || $this->os->name != 'Android') {
					$this->os->name = 'Android';
					$this->os->version = null;
				}

				$device = DeviceModels::identify('android', $parts[1]);
				if ($device->identified) {
					$device->identified |= $this->device->identified;
					$this->device = $device;
				}
			}

			if (count($parts) > 1 && $parts[0] == 'iPhone OS') {
				if (!isset($this->os->name) || $this->os->name != 'iOS') {
					$this->os->name = 'iOS';
					$this->os->version = null;
				}

				$device = DeviceModels::identify('ios', $parts[1]);

				if ($device->identified) {
					$device->identified |= $this->device->identified;
					$this->device = $device;
				}
			}
		}

		function analyseOperaMiniPhone($ua) {
			@list($manufacturer, $model) = explode(' # ', $ua);

			if ($manufacturer != '?' && $model != '?') {
				if (!$this->device->identified && $this->os->name == 'Bada') {
					$device = DeviceModels::identify('bada', $model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}

				if (!$this->device->identified && $this->os->name == 'Blackberry') {
					$device = DeviceModels::identify('blackberry', $model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}

				if (!$this->device->identified && $this->os->name == 'Windows Mobile') {
					$device = DeviceModels::identify('wm', $model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}

				if (!$this->device->identified) {
					$this->device->manufacturer = $manufacturer;
					$this->device->model = $model;
					$this->device->identified = true;
				}
			}
		}

		function analyseUserAgent($ua) {
			$ua = preg_replace("/^(Mozilla\/[0-9]\.[0-9].*)\s+Mozilla\/[0-9]\.[0-9].*$/iu", '$1', $ua);


			/****************************************************
			 *		Unix
			 */

			if (preg_match('/Unix/u', $ua)) {
				$this->os->name = 'Unix';
			}

			/****************************************************
			 *		FreeBSD
			 */

			if (preg_match('/FreeBSD/u', $ua)) {
				$this->os->name = 'FreeBSD';
			}

			/****************************************************
			 *		OpenBSD
			 */

			if (preg_match('/OpenBSD/u', $ua)) {
				$this->os->name = 'OpenBSD';
			}

			/****************************************************
			 *		NetBSD
			 */

			if (preg_match('/NetBSD/u', $ua)) {
				$this->os->name = 'NetBSD';
			}


			/****************************************************
			 *		Solaris
			 */

			if (preg_match('/SunOS/u', $ua)) {
				$this->os->name = 'Solaris';
			}


			/****************************************************
			 *		IRIX
			 */

			if (preg_match('/IRIX/u', $ua)) {
				$this->os->name = 'IRIX';

				if (preg_match('/IRIX ([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/IRIX;?(?:64|32) ([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}
			}


			/****************************************************
			 *		Syllable
			 */

			if (preg_match('/Syllable/u', $ua)) {
				$this->os->name = 'Syllable';
			}


			/****************************************************
			 *		Linux
			 */

			if (preg_match('/Linux/u', $ua)) {
				$this->os->name = 'Linux';

				if (preg_match('/CentOS/u', $ua)) {
					$this->os->name = 'CentOS';
					if (preg_match('/CentOS\/[0-9\.\-]+el([0-9_]+)/u', $ua, $match)) {
						$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Debian/u', $ua)) {
					$this->os->name = 'Debian';
					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Fedora/u', $ua)) {
					$this->os->name = 'Fedora';
					if (preg_match('/Fedora\/[0-9\.\-]+fc([0-9]+)/u', $ua, $match)) {
						$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Gentoo/u', $ua)) {
					$this->os->name = 'Gentoo';
					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/gNewSense/u', $ua)) {
					$this->os->name = 'gNewSense';
					if (preg_match('/gNewSense\/[^\(]+\(([0-9\.]+)/u', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1]));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Kubuntu/u', $ua)) {
					$this->os->name = 'Kubuntu';
					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Mandriva Linux/u', $ua)) {
					$this->os->name = 'Mandriva';
					if (preg_match('/Mandriva Linux\/[0-9\.\-]+mdv([0-9]+)/u', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1]));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Mageia/u', $ua)) {
					$this->os->name = 'Mageia';
					if (preg_match('/Mageia\/[0-9\.\-]+mga([0-9]+)/u', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1]));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Mandriva/u', $ua)) {
					$this->os->name = 'Mandriva';
					if (preg_match('/Mandriva\/[0-9\.\-]+mdv([0-9]+)/u', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1]));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Red Hat/u', $ua)) {
					$this->os->name = 'Red Hat';
					if (preg_match('/Red Hat[^\/]*\/[0-9\.\-]+el([0-9_]+)/u', $ua, $match)) {
						$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Slackware/u', $ua)) {
					$this->os->name = 'Slackware';
					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/SUSE/u', $ua)) {
					$this->os->name = 'SUSE';
					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Turbolinux/u', $ua)) {
					$this->os->name = 'Turbolinux';
					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Ubuntu/u', $ua)) {
					$this->os->name = 'Ubuntu';
					if (preg_match('/Ubuntu\/([0-9.]*)/u', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1]));
					}

					$this->device->type = TYPE_DESKTOP;
				}


				if (preg_match('/Linux\/X2\/R1/u', $ua)) {
					$this->os->name = 'LiMo';
					$this->device->type = TYPE_MOBILE;
				}
			}

			else if (preg_match('/\(Ubuntu; (Mobile|Tablet)/u', $ua)) {
				$this->os->name = 'Ubuntu Touch';

				if (preg_match('/\(Ubuntu; Mobile/u', $ua)) $this->device->type = TYPE_MOBILE;
				if (preg_match('/\(Ubuntu; Tablet/u', $ua)) $this->device->type = TYPE_TABLET;
			}




			/****************************************************
			 *		iOS
			 */

			if ((preg_match('/iPhone/u', $ua) && !preg_match('/like iPhone/u', $ua)) || 
				preg_match('/iPad/u', $ua) || preg_match('/iPod/u', $ua)) 
			{
				$this->os->name = 'iOS';
				$this->os->version = new Version(array('value' => '1.0'));

				if (preg_match('/OS (.*) like Mac OS X/u', $ua, $match)) {
					$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
					if ($this->os->version->is('<', '4')) $this->os->alias = 'iPhone OS';
				}

				if (preg_match('/iPhone Simulator;/u', $ua)) {
					$this->device->type = TYPE_EMULATOR;
				}

				else {
					if (preg_match('/(iPad|iPhone( 3GS| 3G| 4S| 4| 5)?|iPod( touch)?)/u', $ua, $match)) {
						$device = DeviceModels::identify('ios', $match[0]);

						if ($device) {
							$this->device = $device;
						}
					}

					if (preg_match('/(iPad|iPhone|iPod)[0-9],[0-9]/u', $ua, $match)) {
						$device = DeviceModels::identify('ios', $match[0]);

						if ($device) {
							$this->device = $device;
						}
					}
				}
			}


			/****************************************************
			 *		OS X
			 */

			else if (preg_match('/Mac OS X/u', $ua)) {
				$this->os->name = 'OS X';

				if (preg_match('/Mac OS X (10[0-9\._]*)/u', $ua, $match)) {
					$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1]), 'details' => 2));

					if ($this->os->version->is('<', '10.7')) $this->os->alias = 'Mac OS X';
					if ($this->os->version->is('10.7')) $this->os->version->nickname = 'Lion';
					if ($this->os->version->is('10.8')) $this->os->version->nickname = 'Mountain Lion';
					if ($this->os->version->is('10.9')) $this->os->version->nickname = 'Mavericks';
					if ($this->os->version->is('10.10')) $this->os->version->nickname = 'Yosemite';
				}

				$this->device->type = TYPE_DESKTOP;
			}


			/****************************************************
			 *		Windows
			 */

			if (preg_match('/Windows/u', $ua)) {
				$this->os->name = 'Windows';
				$this->device->type = TYPE_DESKTOP;

				if (preg_match('/Windows NT ([0-9][0-9]?\.[0-9])/u', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));

					switch($match[1]) {
						case '10.0':
						case '6.4':		if (preg_match('/; ARM;/u', $ua))
											$this->os->version = new Version(array('value' => $match[1], 'alias' => 'RT 10'));
										else
											$this->os->version = new Version(array('value' => $match[1], 'alias' => '10'));
										break;

						case '6.3':		if (preg_match('/; ARM;/u', $ua))
											$this->os->version = new Version(array('value' => $match[1], 'alias' => 'RT 8.1'));
										else
											$this->os->version = new Version(array('value' => $match[1], 'alias' => '8.1'));
										break;

						case '6.2':		if (preg_match('/; ARM;/u', $ua))
											$this->os->version = new Version(array('value' => $match[1], 'alias' => 'RT'));
										else
											$this->os->version = new Version(array('value' => $match[1], 'alias' => '8'));
										break;

						case '6.1':		$this->os->version = new Version(array('value' => $match[1], 'alias' => '7')); break;
						case '6.0':		$this->os->version = new Version(array('value' => $match[1], 'alias' => 'Vista')); break;
						case '5.2':		$this->os->version = new Version(array('value' => $match[1], 'alias' => 'Server 2003')); break;
						case '5.1':		$this->os->version = new Version(array('value' => $match[1], 'alias' => 'XP')); break;
						case '5.0':		$this->os->version = new Version(array('value' => $match[1], 'alias' => '2000')); break;
						default:		$this->os->version = new Version(array('value' => $match[1], 'alias' => 'NT ' . $match[1])); break;
					}
				}

				if (preg_match('/Windows 95/u', $ua) || preg_match('/Win95/u', $ua) || preg_match('/Win 9x 4.00/u', $ua)) {
					$this->os->version = new Version(array('value' => '4.0', 'alias' => '95'));
				}

				if (preg_match('/Windows 98/u', $ua) || preg_match('/Win98/u', $ua) || preg_match('/Win 9x 4.10/u', $ua)) {
					$this->os->version = new Version(array('value' => '4.1', 'alias' => '98'));
				}

				if (preg_match('/Windows ME/u', $ua) || preg_match('/WinME/u', $ua) || preg_match('/Win 9x 4.90/u', $ua)) {
					$this->os->version = new Version(array('value' => '4.9', 'alias' => 'ME'));
				}

				if (preg_match('/Windows XP/u', $ua) || preg_match('/WinXP/u', $ua)) {
					$this->os->version = new Version(array('value' => '5.1', 'alias' => 'XP'));
				}

				if (preg_match('/WPDesktop/u', $ua)) {
					$this->os->name = 'Windows Phone';
					$this->os->version = new Version(array('value' => '8.0', 'details' => 1));
					$this->device->type = TYPE_MOBILE;
					$this->browser->mode = 'desktop';
				}

				if (preg_match('/WP7/u', $ua)) {
					$this->os->name = 'Windows Phone';
					$this->os->version = new Version(array('value' => '7', 'details' => 1));
					$this->device->type = TYPE_MOBILE;
					$this->browser->mode = 'desktop';
				}

				if (preg_match('/Windows CE/u', $ua) || preg_match('/WinCE/u', $ua) || preg_match('/WindowsCE/u', $ua)) {
					if (preg_match('/ IEMobile/u', $ua)) {
						$this->os->name = 'Windows Mobile';

						if (preg_match('/ IEMobile 8/u', $ua)) {
							$this->os->version = new Version(array('value' => '6.5', 'details' => 2));
						}

						if (preg_match('/ IEMobile 7/u', $ua)) {
							$this->os->version = new Version(array('value' => '6.1', 'details' => 2));
						}

						if (preg_match('/ IEMobile 6/u', $ua)) {
							$this->os->version = new Version(array('value' => '6.0', 'details' => 2));
						}
					}
					else {
						$this->os->name = 'Windows CE';

						if (preg_match('/WindowsCEOS\/([0-9.]*)/u', $ua, $match)) {
							$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
						}

						if (preg_match('/Windows CE ([0-9.]*)/u', $ua, $match)) {
							$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
						}
					}

					$this->device->type = TYPE_MOBILE;
				}

				if (preg_match('/Windows ?Mobile/u', $ua)) {
					$this->os->name = 'Windows Mobile';
					$this->device->type = TYPE_MOBILE;
				}

				if (preg_match('/WindowsMobile\/([0-9.]*)/u', $ua, $match)) {
					$this->os->name = 'Windows Mobile';
					$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
					$this->device->type = TYPE_MOBILE;
				}

				if (preg_match('/Windows Phone/u', $ua) || preg_match('/WPDesktop/u', $ua)) {
					$this->os->name = 'Windows Phone';
					$this->device->type = TYPE_MOBILE;

					if (preg_match('/Windows Phone (?:OS )?([0-9.]*)/u', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1], 'details' => 2));

						if (intval($match[1]) < 7) {
							$this->os->name = 'Windows Mobile';
						}
					}

					/* Windows Phone OS 7 and 8 */
					if (preg_match('/IEMobile\/[^;]+;(?: ARM; Touch; )?\s*([^;\s][^;]*);\s*([^;\)\s][^;\)]*)[;|\)]/u', $ua, $match)) {
						$this->device->manufacturer = $match[1];
						$this->device->model = $match[2];
						$this->device->identified |= ID_PATTERN;

						$device = DeviceModels::identify('wp', $match[2]);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}

					/* Windows Phone 10 */
					if (preg_match('/Windows Phone 1[0-9]\.[0-9]; Android [0-9\.]+; ([^;\s][^;]*);\s*([^;\)\s][^;\)]*)[;|\)]/u', $ua, $match)) {
						$this->device->manufacturer = $match[1];
						$this->device->model = $match[2];
						$this->device->identified |= ID_PATTERN;

						$device = DeviceModels::identify('wp', $match[2]);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}

					/* Third party browsers */
					if (preg_match('/IEMobile\/[^;]+;(?: ARM; Touch; )?\s*(?:[^\/]+\/[^\/]+);\s*([^;\s][^;]*);\s*([^;\)\s][^;\)]*)[;|\)]/u', $ua, $match)) {
						$this->device->manufacturer = $match[1];
						$this->device->model = $match[2];
						$this->device->identified |= ID_PATTERN;

						$device = DeviceModels::identify('wp', $match[2]);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}

					/* Desktop mode of WP 8.1 */
					if (preg_match('/WPDesktop;\s*([^;\)]*)(?:;\s*([^;\)]*))?(?:;\s*([^;\)]*))?\) like Gecko/u', $ua, $match)) {
						$this->os->version = new Version(array('value' => '8.1', 'details' => 2));

						if (preg_match("/^[A-Z]+$/", $match[1])) {
							$this->device->manufacturer = $match[1];
							$this->device->model = $match[2];
						} else {
							$this->device->model = $match[1];
						}

						$this->device->identified |= ID_PATTERN;

						$device = DeviceModels::identify('wp', $this->device->model);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}

					/* Desktop mode of WP 8.1 Update (buggy version) */
					if (preg_match('/Touch; WPDesktop;\s*([^;\)]*)(?:;\s*([^;\)]*))?(?:;\s*([^;\)]*))?\)/u', $ua, $match)) {
						$this->os->version = new Version(array('value' => '8.1', 'details' => 2));

						if (preg_match("/^[A-Z]+$/", $match[1]) && isset($match[2])) {
							$this->device->manufacturer = $match[1];
							$this->device->model = $match[2];
						} else {
							$this->device->model = $match[1];
						}

						$this->device->identified |= ID_PATTERN;

						$device = DeviceModels::identify('wp', $this->device->model);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}

					if (isset($this->device->manufacturer) && isset($this->device->model)) {
						if ($this->device->manufacturer == 'ARM' && $this->device->model == 'Touch') {
							$this->device->manufacturer = null;
							$this->device->model = null;
							$this->device->identified = ID_NONE;
						}

						if ($this->device->manufacturer == 'Microsoft' && $this->device->model == 'XDeviceEmulator') {
							$this->device->manufacturer = null;
							$this->device->model = null;
							$this->device->type = TYPE_EMULATOR;
							$this->device->identified |= ID_MATCH_UA;
						}
					}
				}
			}



			/****************************************************
			 *		Android
			 */

			if (preg_match('/Android/u', $ua)) {
				$falsepositive = false;

				/* Prevent the Mobile IE 11 Franken-UA from matching Android */
				if (preg_match('/IEMobile\/1/u', $ua)) $falsepositive = true;
				if (preg_match('/Windows Phone 10/u', $ua)) $falsepositive = true;

				/* Prevent from OSes that claim to be 'like' Android from matching */
				if (preg_match('/like Android/u', $ua)) $falsepositive = true;
				if (preg_match('/COS like Android/u', $ua)) $falsepositive = false;

				if (!$falsepositive) {
					$this->os->name = 'Android';
					$this->os->version = new Version();

					if (preg_match('/Android(?: )?(?:AllPhone_|CyanogenMod_|OUYA )?(?:\/)?v?([0-9.]+)/u', str_replace('-update', ',', $ua), $match)) {
						$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
					}

					if (preg_match('/Android [0-9][0-9].[0-9][0-9].[0-9][0-9]\(([^)]+)\);/u', str_replace('-update', ',', $ua), $match)) {
						$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
					}

					if (preg_match('/Android Eclair/u', $ua)) {
						$this->os->version = new Version(array('value' => '2.0', 'details' => 3));
					}

					if (preg_match('/Android KeyLimePie/u', $ua)) {
						$this->os->version = new Version(array('value' => '4.4', 'details' => 3));
					}

					$this->device->type = TYPE_MOBILE;
					if ($this->os->version->toFloat() >= 3) $this->device->type = TYPE_TABLET;
					if ($this->os->version->toFloat() >= 4 && preg_match('/Mobile/u', $ua)) $this->device->type = TYPE_MOBILE;


					if (preg_match('/Eclair; (?:[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?) Build\/([^\/]*)\//u', $ua, $match)) {
						$this->device->model = $match[1];
					}

					else if (preg_match('/; ?([^;]*[^;\s])\s+Build/u', $ua, $match)) {
						$this->device->model = $match[1];
					}

					else if (preg_match('/Linux;Android [0-9.]+,([^\)]+)\)/u', $ua, $match)) {
						$this->device->model = $match[1];
					}

					else if (preg_match('/[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?; ([^;]*[^;\s]);\s+Build/u', $ua, $match)) {
						$this->device->model = $match[1];
					}

					else if (preg_match('/\(([^;]+);U;Android\/[^;]+;[0-9]+\*[0-9]+;CTC\/2.0\)/u', $ua, $match)) {
						$this->device->model = $match[1];
					}

					else if (preg_match('/;\s?([^;]+);\s?[0-9]+\*[0-9]+;\s?CTC\/2.0/u', $ua, $match)) {
						$this->device->model = $match[1];
					}

					else if (preg_match('/Android [^;]+; (?:[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?; )?([^)]+)\)/u', $ua, $match)) {
						if (!preg_match('/[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?/u', $ua)) {
							$this->device->model = $match[1];
						}
					}

					/* Sometimes we get a model name that starts with Android, in that case it is a mismatch and we should ignore it */
					if (isset($this->device->model) && substr($this->device->model, 0, 7) == 'Android') {
						$this->device->model = null;
					}

					/* Sometimes we get version and API numbers and display size too */
					if (isset($this->device->model) && preg_match('/(.*) - [0-9\.]+ - (?:with Google Apps - )?API [0-9]+ - [0-9]+x[0-9]+/', $this->device->model, $matches)) {
						$this->device->model = $matches[1];
					}

					/* Sometimes we get a model that is actually an old style useragent */
					if (isset($this->device->model) && preg_match('/([^\/]+?)(?:\/[0-9\.]+)? (?:Android|Release)\//', $this->device->model, $matches)) {
						$this->device->model = $matches[1];
					}

					if (isset($this->device->model) && $this->device->model) {
						$this->device->identified |= ID_PATTERN;

						$device = DeviceModels::identify('android', $this->device->model);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}

					if (preg_match('/HP eStation/u', $ua)) 	{ $this->device->manufacturer = 'HP'; $this->device->model = 'eStation'; $this->device->type = TYPE_TABLET; $this->device->identified |= ID_MATCH_UA; $this->device->generic = false; }
					if (preg_match('/Pre\/1.0/u', $ua)) 		{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pre'; $this->device->identified |= ID_MATCH_UA; $this->device->generic = false; }
					if (preg_match('/Pre\/1.1/u', $ua)) 		{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pre Plus'; $this->device->identified |= ID_MATCH_UA; $this->device->generic = false; }
					if (preg_match('/Pre\/1.2/u', $ua)) 		{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pre 2'; $this->device->identified |= ID_MATCH_UA; $this->device->generic = false; }
					if (preg_match('/Pre\/3.0/u', $ua)) 		{ $this->device->manufacturer = 'HP'; $this->device->model = 'Pre 3'; $this->device->identified |= ID_MATCH_UA; $this->device->generic = false; }
					if (preg_match('/Pixi\/1.0/u', $ua)) 	{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pixi'; $this->device->identified |= ID_MATCH_UA; $this->device->generic = false; }
					if (preg_match('/Pixi\/1.1/u', $ua)) 	{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pixi Plus'; $this->device->identified |= ID_MATCH_UA; $this->device->generic = false; }
					if (preg_match('/P160UN?A?\/1.0/u', $ua)) { $this->device->manufacturer = 'HP'; $this->device->model = 'Veer'; $this->device->identified |= ID_MATCH_UA; $this->device->generic = false; }
				}
			}



			/****************************************************
			 *		Aliyun OS
			 */

			if (preg_match('/Aliyun/u', $ua) || preg_match('/YunOs/ui', $ua)) {
				$this->os->name = 'Aliyun OS';
				$this->os->family = 'Android';
				$this->os->version = new Version();

				if (preg_match('/YunOs[ \/]([0-9.]+)/iu', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				if (preg_match('/AliyunOS ([0-9.]+)/u', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				$this->device->type = TYPE_MOBILE;

				if (preg_match('/; ([^;]*[^;\s])\s+Build/u', $ua, $match)) {
					$this->device->model = $match[1];
				}

				if (isset($this->device->model)) {
					$this->device->identified |= ID_PATTERN;

					$device = DeviceModels::identify('android', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}
			}

			if (preg_match('/Android/u', $ua)) {
				if (preg_match('/Android v(1.[0-9][0-9])_[0-9][0-9].[0-9][0-9]-/u', $ua, $match)) {
					$this->os->name = 'Aliyun OS';
					$this->os->family = 'Android';
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				if (preg_match('/Android (1.[0-9].[0-9].[0-9]+)-R?T/u', $ua, $match)) {
					$this->os->name = 'Aliyun OS';
					$this->os->family = 'Android';
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				if (preg_match('/Android ([12].[0-9].[0-9]+)-R-20[0-9]+/u', $ua, $match)) {
					$this->os->name = 'Aliyun OS';
					$this->os->family = 'Android';
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				if (preg_match('/Android 20[0-9]+/u', $ua, $match)) {
					$this->os->name = 'Aliyun OS';
					$this->os->family = 'Android';
					$this->os->version = null;
				}
			}



			/****************************************************
			 *		Baidu Yi
			 */

			if (preg_match('/Baidu Yi/u', $ua)) {
				$this->os->name = 'Baidu Yi';
				$this->os->version = null;
			}




			/****************************************************
			 *		Google TV
			 */

			if (preg_match('/GoogleTV/u', $ua)) {
				$this->os->name = 'Google TV';
				$this->os->family = 'Android';

				$this->device->type = TYPE_TELEVISION;

				if (preg_match('/GoogleTV [0-9\.]+; ?([^;]*[^;\s])\s+Build/u', $ua, $match)) {
					$this->device->model = $match[1];
				}

				if (isset($this->device->model) && $this->device->model) {
					$this->device->identified |= ID_PATTERN;

					$device = DeviceModels::identify('android', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}
			}


			/****************************************************
			 *		Chromecast
			 */

			if (preg_match('/CrKey/u', $ua) && !preg_match('/Espial/u', $ua)) {
				$this->device->manufacturer = 'Google';
				$this->device->model = 'Chromecast';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}


			/****************************************************
			 *		WoPhone
			 */

			if (preg_match('/WoPhone/u', $ua)) {
				$this->os->name = 'WoPhone';

				if (preg_match('/WoPhone\/([0-9\.]*)/u', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		BlackBerry
			 */

			if (preg_match('/BlackBerry/u', $ua) && !preg_match('/BlackBerry Runtime for Android Apps/u', $ua)) {
				$this->os->name = 'BlackBerry OS';

				$this->device->model = 'BlackBerry';
				$this->device->manufacturer = 'RIM';
				$this->device->type = TYPE_MOBILE;
				$this->device->identified = ID_NONE;

				if (!preg_match('/Opera/u', $ua)) {
					if (preg_match('/BlackBerry([0-9]*)\/([0-9.]*)/u', $ua, $match)) {
						$this->device->model = $match[1];
						$this->os->version = new Version(array('value' => $match[2], 'details' => 2));
					}

					if (preg_match('/; BlackBerry ([0-9]*);/u', $ua, $match)) {
						$this->device->model = $match[1];
					}

					if (preg_match('/; ([0-9]+)[^;\)]+\)/u', $ua, $match)) {
						$this->device->model = $match[1];
					}

					if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
					}

					if (isset($this->os->version) && $this->os->version->toFloat() >= 10) {
						$this->os->name = 'BlackBerry';
					}

					if ($this->device->model) {
						$device = DeviceModels::identify('blackberry', $this->device->model);

						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}
				}
			}

			if (preg_match('/\(BB(1[^;]+); ([^\)]+)\)/u', $ua, $match)) {
				$this->os->name = 'BlackBerry';
				$this->os->version = new Version(array('value' => $match[1], 'details' => 2));

				$this->device->manufacturer = 'BlackBerry';
				$this->device->model = $match[2];

				if ($this->device->model == 'Kbd') {
					$this->device->model = 'Q series';
				}

				if ($this->device->model == 'Touch') {
					$this->device->model = 'A or Z series';
				}

				$this->device->type = preg_match('/Mobile/u', $ua) ? TYPE_MOBILE : TYPE_TABLET;
				$this->device->identified |= ID_MATCH_UA;

				if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
				}
			}

			/****************************************************
			 *		BlackBerry PlayBook
			 */

			if (preg_match('/RIM Tablet OS ([0-9.]*)/u', $ua, $match)) {
				$this->os->name = 'BlackBerry Tablet OS';
				$this->os->version = new Version(array('value' => $match[1], 'details' => 2));

				$this->device->manufacturer = 'RIM';
				$this->device->model = 'BlackBerry PlayBook';
				$this->device->type = TYPE_TABLET;
				$this->device->identified |= ID_MATCH_UA;
			}

			else if (preg_match('/\(PlayBook;/u', $ua) && preg_match('/PlayBook Build\/([0-9.]*)/u', $ua, $match)) {
				$this->os->name = 'BlackBerry Tablet OS';
				$this->os->version = new Version(array('value' => $match[1], 'details' => 2));

				$this->device->manufacturer = 'RIM';
				$this->device->model = 'BlackBerry PlayBook';
				$this->device->type = TYPE_TABLET;
				$this->device->identified |= ID_MATCH_UA;
			}

			else if (preg_match('/PlayBook/u', $ua) && !preg_match('/Android/u', $ua)) {
				if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
					$this->os->name = 'BlackBerry Tablet OS';
					$this->os->version = new Version(array('value' => $match[1], 'details' => 2));

					$this->device->manufacturer = 'RIM';
					$this->device->model = 'BlackBerry PlayBook';
					$this->device->type = TYPE_TABLET;
					$this->device->identified |= ID_MATCH_UA;
				}
			}


			/****************************************************
			 *		WebOS
			 */

			if (preg_match('/(?:web|hpw)OS\/(?:HP webOS )?([0-9.]*)/u', $ua, $match)) {
				$this->os->name = 'webOS';
				$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
				$this->device->type = preg_match('/Tablet/iu', $ua) ? TYPE_TABLET : TYPE_MOBILE;
				$this->device->generic = false;

				if (preg_match('/Pre\/1.0/u', $ua)) $this->device->model = 'Pre';
				if (preg_match('/Pre\/1.1/u', $ua)) $this->device->model = 'Pre Plus';
				if (preg_match('/Pre\/1.2/u', $ua)) $this->device->model = 'Pre 2';
				if (preg_match('/Pre\/3.0/u', $ua)) $this->device->model = 'Pre 3';
				if (preg_match('/Pixi\/1.0/u', $ua)) $this->device->model = 'Pixi';
				if (preg_match('/Pixi\/1.1/u', $ua)) $this->device->model = 'Pixi Plus';
				if (preg_match('/P160UN?A?\/1.0/u', $ua)) $this->device->model = 'Veer';
				if (preg_match('/TouchPad\/1.0/u', $ua)) $this->device->model = 'TouchPad';
				if (isset($this->device->model)) $this->device->manufacturer = preg_match('/hpwOS/u', $ua) ? 'HP' : 'Palm';

				if (preg_match('/Emulator\//u', $ua) || preg_match('/Desktop\//u', $ua)) {
					$this->device->type = TYPE_EMULATOR;
					$this->device->manufacturer = null;
					$this->device->model = null;
				}

				$this->device->identified |= ID_MATCH_UA;
			}

			if (preg_match('/elite\/fzz/u', $ua, $match)) {
				$this->os->name = 'webOS';
			}


			/****************************************************
			 *		S80
			 */

			if (preg_match('/Series80\/([0-9.]*)/u', $ua, $match)) {
				$this->os->name = 'Series80';
				$this->os->version = new Version(array('value' => $match[1]));

				if (preg_match('/Nokia([^\/;\)]+)[\/|;|\)]/u', $ua, $match)) {
					if ($match[1] != 'Browser') {
						$this->device->manufacturer = 'Nokia';
						$this->device->model = DeviceModels::cleanup($match[1]);
						$this->device->identified |= ID_PATTERN;
					}
				}
			}


			/****************************************************
			 *		S60
			 */

			if (preg_match('/Symbian/u', $ua) || preg_match('/Series[ ]?60/u', $ua) || preg_match('/S60;/u', $ua) || preg_match('/S60V/u', $ua)) {
				$this->os->name = 'Series60';

				if (preg_match('/SymbianOS\/9.1/u', $ua) && !preg_match('/Series60/u', $ua)) {
					$this->os->version = new Version(array('value' => '3.0'));
				}

				if (preg_match('/Series60\/([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/S60V([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/Nokia([^\/;\)]+)[\/|;|\)]/u', $ua, $match)) {
					if ($match[1] != 'Browser') {
						$this->device->manufacturer = 'Nokia';
						$this->device->model = DeviceModels::cleanup($match[1]);
						$this->device->identified |= ID_PATTERN;
					}
				}

				if (preg_match('/Symbian; U; (?:Nokia)?([^;]+); [a-z][a-z](?:\-[a-z][a-z])?/u', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = DeviceModels::cleanup($match[1]);
					$this->device->identified |= ID_PATTERN;
				}

				if (preg_match('/Vertu([^\/;]+)[\/|;]/u', $ua, $match)) {
					$this->device->manufacturer = 'Vertu';
					$this->device->model = DeviceModels::cleanup($match[1]);
					$this->device->identified |= ID_PATTERN;
				}

				if (preg_match('/Samsung\/([^;]*);/u', $ua, $match)) {
					$this->device->manufacturer = 'Samsung';
					$this->device->model = DeviceModels::cleanup($match[1]);
					$this->device->identified |= ID_PATTERN;
				}

				if (isset($this->device->model)) {
					$device = DeviceModels::identify('s60', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}

				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		S40
			 */

			if (preg_match('/Series40/u', $ua)) {
				$this->os->name = 'Series40';

				if (preg_match('/Nokia([^\/]+)\//u', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = DeviceModels::cleanup($match[1]);
					$this->device->identified |= ID_PATTERN;
				}

				if (isset($this->device->model)) {
					$device = DeviceModels::identify('s40', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}

				if (isset($this->device->model)) {
					$device = DeviceModels::identify('asha', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->os->name = 'Nokia Asha Platform';
						$this->os->version = new Version(array('value' => '1.0'));
						$this->device = $device;
					}

					if (preg_match('/java_runtime_version=Nokia_Asha_([0-9_]+);/u', $ua, $match)) {
						$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
					}
				}

				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		S30
			 */

			if (preg_match('/Series30/u', $ua)) {
				$this->os->name = 'Series30';

				if (preg_match('/Nokia([^\/]+)\//u', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = DeviceModels::cleanup($match[1]);
					$this->device->identified |= ID_PATTERN;
				}

				if (isset($this->device->model)) {
					$device = DeviceModels::identify('s30', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}

				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		MeeGo
			 */

			if (preg_match('/MeeGo/u', $ua)) {
				$this->os->name = 'MeeGo';
				$this->device->type = TYPE_MOBILE;

				if (preg_match('/Nokia([^\)]+)\)/u', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = DeviceModels::cleanup($match[1]);
					$this->device->identified |= ID_PATTERN;
					$this->device->generic = false;
				}
			}

			/****************************************************
			 *		Maemo
			 */

			if (preg_match('/Maemo/u', $ua)) {
				$this->os->name = 'Maemo';
				$this->device->type = TYPE_MOBILE;

				if (preg_match('/(N[0-9]+)/u', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = $match[1];
					$this->device->identified |= ID_PATTERN;
					$this->device->generic = false;
				}
			}

			/****************************************************
			 *		Tizen
			 */

			if (preg_match('/Tizen/u', $ua)) {
				$this->os->name = 'Tizen';

				if (preg_match('/Tizen[\/ ]([0-9.]*[0-9])/u', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/\(([^;]+); ([^\/]+)\//u', $ua, $match)) {
					if (strtoupper($match[1]) != 'SMART-TV' && $match[1] != 'Linux' && $match[1] != 'Tizen') {
						$this->device->manufacturer = $match[1];
						$this->device->model = $match[2];
						$this->device->identified = ID_PATTERN;

						$device = DeviceModels::identify('tizen', $match[2]);

						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}
				}

				if (preg_match('/\s*([^;]+);\s+([^;\)]+)\)/u', $ua, $match)) {
					if ($match[1] != 'U' && substr($match[2], 0, 5) != 'Tizen') {
						$this->device->model = $match[2];
						$this->device->identified = ID_PATTERN;

						$device = DeviceModels::identify('tizen', $match[2]);

						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}
				}

				if (preg_match('/\(SMART[ -]TV;/iu', $ua, $match)) {
					$this->device->type = TYPE_TELEVISION;
					$this->device->manufacturer = 'Samsung';
					$this->device->series = 'Smart TV';
					$this->device->identified = ID_PATTERN;
				}
			}

			/****************************************************
			 *		Jolla Sailfish
			 */

			if (preg_match('/Jolla; Sailfish;/u', $ua)) {
				$this->os->name = 'Sailfish';
				$this->device->manufacturer = 'Jolla';

				if (preg_match('/Mobile/u', $ua)) { 
					$this->device->model = 'Phone';
					$this->device->type = TYPE_MOBILE;
					$this->device->identified = ID_PATTERN;
				}

				if (preg_match('/Tablet/u', $ua)) { 
					$this->device->model = 'Tablet';
					$this->device->type = TYPE_TABLET;
					$this->device->identified = ID_PATTERN;
				}
			}

			/****************************************************
			 *		Bada
			 */

			if (preg_match('/[b|B]ada/u', $ua)) {
				$this->os->name = 'Bada';

				if (preg_match('/[b|B]ada[\/ ]([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
				}

				$this->device->type = TYPE_MOBILE;

				if (preg_match('/\(([^;]+); ([^\/]+)\//u', $ua, $match)) {
					if ($match[1] != 'Bada') {
						$this->device->manufacturer = $match[1];
						$this->device->model = $match[2];
						$this->device->identified = ID_PATTERN;

						$device = DeviceModels::identify('bada', $match[2]);

						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}
				}
			}

			/****************************************************
			 *		Brew
			 */

			if (preg_match('/BREW/ui', $ua) || preg_match('/BMP( [0-9.]*)?; U/u', $ua) || preg_match('/BMP\/([0-9.]*)/u', $ua)) {
				$this->os->name = 'Brew';

				if (preg_match('/BREW; U; ([0-9.]*)/iu', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				else if (preg_match('/BREW MP ([0-9.]*)/iu', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				else if (preg_match('/[\(;]BREW[\/ ]([0-9.]*)/iu', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				else if (preg_match('/BMP ([0-9.]*); U/iu', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				else if (preg_match('/BMP\/([0-9.]*)/iu', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}


				$this->device->type = TYPE_MOBILE;

				if (preg_match('/(?:Brew MP|BREW|BMP) [^;]+; U; [^;]+; ([^;]+); NetFront[^\)]+\) [^\s]+ ([^\s]+)/u', $ua, $match)) {
					$this->device->manufacturer = trim($match[1]);
					$this->device->model = $match[2];
					$this->device->identified = ID_PATTERN;

					$device = DeviceModels::identify('brew', $match[2]);

					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}

				if (preg_match('/\(([^;]+);U;REX\/[^;]+;BREW\/[^;]+;(?:.*;)?[0-9]+\*[0-9]+(?:;CTC\/2.0)?\)/u', $ua, $match)) {
					$this->device->model = $match[1];
					$this->device->identified = ID_PATTERN;

					$device = DeviceModels::identify('brew', $match[1]);

					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}
			}

			/****************************************************
			 *		MTK
			 */

			if (preg_match('/\(MTK;/u', $ua)) {
				$this->os->name = 'MTK';
				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		MAUI Runtime
			 */

			if (preg_match('/\(MAUI Runtime;/u', $ua)) {
				$this->os->name = 'MAUI Runtime';
				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		VRE
			 */

			if (preg_match('/\(VRE;/u', $ua)) {
				$this->os->name = 'VRE';
				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		SpreadTrum
			 */

			if (preg_match('/\(SpreadTrum;/u', $ua)) {
				$this->os->name = 'SpreadTrum';
				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		ThreadX
			 */

			if (preg_match('/ThreadX(?:_OS)?\/([0-9.]*)/ui', $ua, $match)) {
				$this->os->name = 'ThreadX';
				$this->os->version = new Version(array('value' => $match[1]));
			}

			/****************************************************
			 *		COS
			 */

			if (preg_match('/COS like Android/ui', $ua, $match)) {
				$this->os->name = 'COS';
				$this->os->family = 'Android';
				$this->os->version = null;
				$this->device->type = TYPE_MOBILE;
			}

			if (preg_match('/COSBrowser\//ui', $ua, $match)) {
				$this->os->name = 'COS';
				$this->os->family = 'Android';
			}

			if (preg_match('/COS\/([0-9.]*)/ui', $ua, $match)) {
				$this->os->name = 'COS';
				$this->os->family = 'Android';
				$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
			}

			if (preg_match('/(?:\(|; )COS/ui', $ua, $match)) {
				$this->os->name = 'COS';
				$this->os->family = 'Android';
			}

			if (preg_match('/(?:\(|; )Chinese Operating System ([0-9]\.[0-9.]*);/ui', $ua, $match)) {
				$this->os->name = 'COS';
				$this->os->family = 'Android';
				$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
			}

			if (preg_match('/(?:\(|; )COS ([0-9]\.[0-9.]*);/ui', $ua, $match)) {
				$this->os->name = 'COS';
				$this->os->family = 'Android';
				$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
			}


			/****************************************************
			 *		CrOS
			 */

			if (preg_match('/CrOS/u', $ua)) {
				$this->os->name = 'Chrome OS';
				$this->device->type = TYPE_DESKTOP;
			}

			/****************************************************
			 *		Joli OS
			 */

			if (preg_match('/Joli OS\/([0-9.]*)/ui', $ua, $match)) {
				$this->os->name = 'Joli OS';
				$this->os->version = new Version(array('value' => $match[1]));
				$this->device->type = TYPE_DESKTOP;
			}

			/****************************************************
			 *		BeOS
			 */

			if (preg_match('/BeOS/u', $ua)) {
				$this->os->name = 'BeOS';
				$this->device->type = TYPE_DESKTOP;
			}

			/****************************************************
			 *		Haiku
			 */

			if (preg_match('/Haiku/u', $ua)) {
				$this->os->name = 'Haiku';
				$this->device->type = TYPE_DESKTOP;
			}

			/****************************************************
			 *		QNX
			 */

			if (preg_match('/QNX/u', $ua)) {
				$this->os->name = 'QNX';
				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		OS/2 Warp
			 */

			if (preg_match('/OS\/2; (?:U; )?Warp ([0-9.]*)/iu', $ua, $match)) {
				$this->os->name = 'OS/2 Warp';
				$this->os->version = new Version(array('value' => $match[1]));
				$this->device->type = TYPE_DESKTOP;
			}

			/****************************************************
			 *		Palm OS
			 */

			if (preg_match('/PalmSource/u', $ua, $match)) {
				$this->os->name = 'Palm OS';
				$this->os->version = null;
				$this->device->type = TYPE_MOBILE;

				if (preg_match('/PalmSource\/([^;]+);/u', $ua, $match)) {
					$this->device->model = $match[1];
					$this->device->identified = ID_PATTERN;
				}

				if ($this->device->model) {
					$device = DeviceModels::identify('palmos', $this->device->model);

					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}
			}

			/****************************************************
			 *		Grid OS
			 */

			if (preg_match('/Grid OS ([0-9.]*)/iu', $ua, $match)) {
				$this->os->name = 'Grid OS';
				$this->os->version = new Version(array('value' => $match[1]));
				$this->device->type = TYPE_TABLET;
			}

			/****************************************************
			 *		AmigaOS
			 */

			if (preg_match('/AmigaOS/iu', $ua, $match)) {
				$this->os->name = 'AmigaOS';
				$this->device->type = TYPE_DESKTOP;

				if (preg_match('/AmigaOS ([0-9.]*)/iu', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}
			}

			/****************************************************
			 *		MorphOS
			 */

			if (preg_match('/MorphOS/iu', $ua, $match)) {
				$this->os->name = 'MorphOS';
				$this->device->type = TYPE_DESKTOP;

				if (preg_match('/MorphOS ([0-9.]*)/iu', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}
			}

			/****************************************************
			 *		AROS
			 */

			if (preg_match('/AROS/u', $ua, $match)) {
				$this->os->name = 'AROS';
				$this->device->type = TYPE_DESKTOP;
			}

			/****************************************************
			 *		Kindle
			 */

			if (preg_match('/Kindle/u', $ua) && !preg_match('/Fire/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Amazon';
				$this->device->series = 'Kindle';
				$this->device->type = TYPE_EREADER;

				if (preg_match('/Kindle\/1.0/u', $ua)) $this->device->model = 'Kindle 1';
				if (preg_match('/Kindle\/2.0/u', $ua)) $this->device->model = 'Kindle 2';
				if (preg_match('/Kindle\/2.5/u', $ua)) $this->device->model = 'Kindle 2';
				if (preg_match('/Kindle\/3.0/u', $ua)) $this->device->model = 'Kindle 3';
				if (preg_match('/Kindle\/3.0\+/u', $ua)) $this->device->model = 'Kindle 3 or later';
				if (preg_match('/Kindle SkipStone/u', $ua)) $this->device->model = 'Kindle Touch or later';

				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		NOOK
			 */

			if (preg_match('/nook browser/u', $ua)) {
				$this->os->name = 'Android';

				$this->device->manufacturer = 'Barnes & Noble';
				$this->device->series = 'NOOK';
				$this->device->type = TYPE_EREADER;
				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		Bookeen
			 */

			if (preg_match('/bookeen\/cybook/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Bookeen';
				$this->device->series = 'Cybook';
				$this->device->type = TYPE_EREADER;

				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		Kobo Reader
			 */

			if (preg_match('/Kobo Touch/u', $ua, $match)) {
				$this->os->name = '';
				$this->os->version = null;

				$this->device->manufacturer = 'Kobo';
				$this->device->series = 'eReader';
				$this->device->type = TYPE_EREADER;
				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		Sony Reader
			 */

			if (preg_match('/EBRD([0-9]+)/u', $ua, $match)) {
				$this->os->name = '';


				$this->device->manufacturer = 'Sony';
				$this->device->series = 'Reader';
				$this->device->type = TYPE_EREADER;
				$this->device->identified |= ID_MATCH_UA;

				switch($match[1]) {
					case '1101':	$this->device->model = 'PRS-T1'; $this->device->generic = false; break;
					case '1102':	$this->device->model = 'PRS-T1'; $this->device->generic = false; break;
					case '1201':	$this->device->model = 'PRS-T2'; $this->device->generic = false; break;
					case '1301':	$this->device->model = 'PRS-T3'; $this->device->generic = false; break;
				}
			}

			/****************************************************
			 *		PocketBook
			 */

			if (preg_match('/PocketBook\/([0-9]+)/u', $ua, $match)) {
				$this->os->name = '';

				$this->device->manufacturer = 'PocketBook';
				$this->device->type = TYPE_EREADER;
				$this->device->identified |= ID_MATCH_UA;

				switch($match[1]) {
					case '515':	$this->device->model = 'Mini'; $this->device->generic = false; break;
					case '614':	$this->device->model = 'Basic 2'; $this->device->generic = false; break;
					case '622':	$this->device->model = 'Touch'; $this->device->generic = false; break;
					case '623':	$this->device->model = 'Touch Lux'; $this->device->generic = false; break;
					case '624':	$this->device->model = 'Basic Touch'; $this->device->generic = false; break;
					case '626':	$this->device->model = 'Touch Lux 2'; $this->device->generic = false; break;
					case '630':	$this->device->model = 'Sense'; $this->device->generic = false; break;
					case '640':	$this->device->model = 'Auqa'; $this->device->generic = false; break;
					case '650':	$this->device->model = 'Ultra'; $this->device->generic = false; break;
					case '801':	$this->device->model = 'Color Lux'; $this->device->generic = false; break;
					case '840':	$this->device->model = 'InkPad'; $this->device->generic = false; break;
				}
			}

			/****************************************************
			 *		iRiver
			 */

			if (preg_match('/Iriver ;/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'iRiver';
				$this->device->series = 'Story';
				$this->device->type = TYPE_EREADER;

				if (preg_match('/EB07/u', $ua)) {
					$this->device->model = 'Story HD EB07'; $this->device->generic = false;
				}

				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		Tesla Model S in-car browser
			 */

			if (preg_match('/QtCarBrowser/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Tesla';
				$this->device->model = 'Model S';
				$this->device->type = TYPE_CAR;
				$this->device->identified |= ID_MATCH_UA;
			}


			/****************************************************
			 *		Nintendo
			 */

			if (preg_match('/Nintendo Wii/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'Wii';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}

			if (preg_match('/Nintendo Wii ?U/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'Wii U';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}

			if (preg_match('/Nintendo DSi/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'DSi';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}

			if (preg_match('/Nintendo 3DS/u', $ua)) {
				$this->os->name = '';

				if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = '3DS';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}

			if (preg_match('/New Nintendo 3DS/u', $ua)) {
				$this->os->name = '';

				if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'New 3DS';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}

			/****************************************************
			 *		Sony Playstation
			 */

			if (preg_match('/PlayStation Portable/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation Portable';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}

			if (preg_match('/PlayStation Vita ([0-9.]*)/u', $ua, $match)) {
				$this->os->name = '';
				$this->os->version = new Version(array('value' => $match[1]));

				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation Vita';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;

				if (preg_match('/VTE\//u', $ua, $match)) {
					$this->device->model = 'Playstation Vita TV';
				}
			}

			if (preg_match('/PlayStation 3/ui', $ua)) {
				$this->os->name = '';

				if (preg_match('/PLAYSTATION 3;? ([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation 3';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}

			if (preg_match('/PlayStation 4/ui', $ua)) {
				$this->os->name = '';

				if (preg_match('/PlayStation 4 ([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation 4';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}

			/****************************************************
			 *		XBox
			 */

			if (preg_match('/Xbox\)$/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Microsoft';
				$this->device->model = 'Xbox 360';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;

				if (isset($this->browser->name) && $this->browser->name == 'Mobile Internet Explorer')
					$this->browser->name = 'Internet Explorer';
			}

			if (preg_match('/Xbox One\)$/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Microsoft';
				$this->device->model = 'Xbox One';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;

				if (isset($this->browser->name) && $this->browser->name == 'Mobile Internet Explorer')
					$this->browser->name = 'Internet Explorer';
			}

			/****************************************************
			 *		Kin
			 */

			if (preg_match('/KIN\.(One|Two) ([0-9.]*)/ui', $ua, $match)) {
				$this->os->name = 'Kin OS';
				$this->os->version = new Version(array('value' => $match[2], 'details' => 2));

				switch($match[1]) {
					case 'One':		$this->device->manufacturer = 'Microsoft';
									$this->device->model = 'Kin ONE';
									$this->device->identified |= ID_MATCH_UA;
									$this->device->generic = false;
									break;

					case 'Two':		$this->device->manufacturer = 'Microsoft';
									$this->device->model = 'Kin TWO';
									$this->device->identified |= ID_MATCH_UA;
									$this->device->generic = false;
									break;
				}
			}

			/****************************************************
			 *		Zune HD
			 *
			 *		Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 6.12; Microsoft ZuneHD 4.5)
			 */

			if (preg_match('/Microsoft ZuneHD/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Microsoft';
				$this->device->model = 'Zune HD';
				$this->device->type = TYPE_MEDIA;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}








			/****************************************************
			 *		Generic television detection
			 */

			if (preg_match('/\(([^,\(]+),\s*([^,\(]+),\s*(?:[Ww]ired|[Ww]ireless)\)/u', $ua, $match)) {
				$vendorName = Manufacturers::identify(TYPE_TELEVISION, $match[1]);
				$modelName = trim($match[2]);

				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_PATTERN;
				if (!isset($this->device->series)) $this->device->series = 'Smart TV';

				switch ($vendorName) {
					case 'ARRIS':			$this->device->manufacturer = 'Arris';
											$this->device->model = $modelName;
											break;

					case 'LG':				$this->device->manufacturer = 'LG';

											switch($modelName) {
												case 'webOS.TV':		$this->device->series = 'webOS TV'; break;
												case 'WEBOS1':			$this->device->series = 'webOS TV'; break;
												case 'GLOBAL-PLAT3':	$this->device->series = 'NetCast TV 2012'; break;
												case 'GLOBAL-PLAT4':	$this->device->series = 'NetCast TV 2013'; break;
												case 'GLOBAL-PLAT5':	$this->device->series = 'NetCast TV 2014'; break;
												default:				$this->device->model = $modelName; break;
											}

											break;

					case 'TiVo':			$this->device->manufacturer = 'TiVo';
											$this->device->series = 'DVR';
											break;

					default:				$this->device->manufacturer = $vendorName;
											$this->device->model = $modelName;
											break;
				}
			}

			if (preg_match('/(?:DTVNetBrowser|InettvBrowser|Hybridcast)\/[0-9\.]+[A-Z]? \(/u', $ua, $match)) {
				$this->device->type = TYPE_TELEVISION;

				$found = false;

				if (preg_match('/(?:DTVNetBrowser|InettvBrowser)\/[0-9\.]+[A-Z]? \(([^;]*)\s*;\s*([^;]*)\s*;/u', $ua, $match)) {
					$vendorName = trim($match[1]);
					$modelName = trim($match[2]);
					$found = true;
				}

				if (preg_match('/Hybridcast\/[0-9\.]+ \([^;]*;([^;]*)\s*;\s*([^;]*)\s*;/u', $ua, $match)) {
					$vendorName = trim($match[1]);
					$modelName = trim($match[2]);
					$found = true;
				}

				if ($found) {
					$this->device->identified |= ID_PATTERN;
					if (!isset($this->device->series)) $this->device->series = 'Smart TV';

					switch($vendorName . '#') {
						case '000087#':			$this->device->manufacturer = 'Hitachi';
												break;

						case '00E091#':			$this->device->manufacturer = 'LG';

												switch($modelName) {
													case 'LGE2D2012M':		$this->device->series = 'NetCast TV 2012'; break;
													case 'LGE3D2012M':		$this->device->series = 'NetCast TV 2012'; break;
												}

												break;

						case '38E08E#':			$this->device->manufacturer = 'Mitsubishi';
												break;

						case '008045#':			$this->device->manufacturer = 'Panasonic';
												break;

						case '00E064#':			$this->device->manufacturer = 'Samsung';
												break;

						case '08001F#':			$this->device->manufacturer = 'Sharp';
												break;

						case '00014A#':			$this->device->manufacturer = 'Sony';
												break;

						case '000039#':			$this->device->manufacturer = 'Toshiba';
												break;
					}
				}
			}

			if (preg_match('/(?:HbbTV|SmartTV)\/[0-9\.]+ \(/u', $ua, $match)) {
				$this->device->type = TYPE_TELEVISION;

				$found = false;

				if (preg_match('/HbbTV\/[0-9\.]+ \([^;]*;\s*([^;]*)\s*;\s*([^;]*)\s*;/u', $ua, $match)) {
					$vendorName = Manufacturers::identify(TYPE_TELEVISION, $match[1]);
					$modelName = trim($match[2]);
					$found = true;
				}

				if (preg_match('/(?:^|\s)SmartTV\/[0-9\.]+ \(([^;]*)\s*;\s*([^;]*)\s*;/u', $ua, $match)) {
					$vendorName = Manufacturers::identify(TYPE_TELEVISION, $match[1]);
					$modelName = trim($match[2]);
					$found = true;
				}

				if ($found) {
					$this->device->identified |= ID_PATTERN;

					switch($vendorName) {
						case 'LG':				$this->device->manufacturer = 'LG';

												switch($modelName) {
													case 'GLOBAL_PLAT3':	$this->device->series = 'NetCast TV 2012'; break;
													case 'GLOBAL_PLAT4':	$this->device->series = 'NetCast TV 2013'; break;
													case 'GLOBAL_PLAT5':	$this->device->series = 'NetCast TV 2014'; break;
													case 'NetCast 2.0':		$this->device->series = 'NetCast TV 2011'; break;
													case 'NetCast 3.0':		$this->device->series = 'NetCast TV 2012'; break;
													case 'NetCast 4.0':		$this->device->series = 'NetCast TV 2013'; break;
													case 'NetCast 4.5':		$this->device->series = 'NetCast TV 2014'; break;
													default:				$this->device->model = $modelName; break;
												}

												break;

						case 'SAMSUNG':	
						case 'Samsung':			$this->device->manufacturer = 'Samsung';

												switch($modelName) {
													case 'SmartTV2012':		$this->device->series = 'Smart TV 2012'; break;
													case 'SmartTV2013':		$this->device->series = 'Smart TV 2013'; break;
													case 'SmartTV2014':		$this->device->series = 'Smart TV 2014'; break;
													case 'OTV-SMT-E5015':	$this->device->model = 'Olleh SkyLife Smart Settopbox'; unset($this->device->series); break;
													default:				$this->device->model = $modelName; break;
												}

												break;

						case 'Panasonic':		$this->device->manufacturer = 'Panasonic';

												switch($modelName) {
													case 'VIERA 2011':		$this->device->series = 'Smart Viera 2011'; break;
													case 'VIERA 2012':		$this->device->series = 'Smart Viera 2012'; break;
													case 'VIERA 2013':		$this->device->series = 'Smart Viera 2013'; break;
													case 'VIERA 2014':		$this->device->series = 'Smart Viera 2014'; break;
													default:				$this->device->model = $modelName; break;
												}

												break;

						case 'TV2N':			$this->device->manufacturer = 'TV2N';

												switch($modelName) {
													case 'videoweb':		$this->device->model = 'Videoweb'; break;
													default:				$this->device->model = $modelName; break;
												}

												break;

						default:				if ($vendorName != '' && $vendorName != 'vendorName') $this->device->manufacturer = $vendorName;
												if ($modelName != '' && $modelName != 'modelName') $this->device->model = $modelName;
												break;
					}

					switch($modelName) {
						case 'hdr1000s':		$this->device->manufacturer = 'Humax';
												$this->device->model = 'HDR-1000S';
												$this->device->identified |= ID_MATCH_UA;
												$this->device->generic = false;
												break;

						case 'hms1000s':
						case 'hms1000sph2':		$this->device->manufacturer = 'Humax';
												$this->device->model = 'HMS-1000S';
												$this->device->identified |= ID_MATCH_UA;
												$this->device->generic = false;
												break;
					}
				}
			}

			if (preg_match('/HbbTV\/[0-9.]+;CE-HTML\/[0-9.]+;([^\s;]+)\s[^\s;]+;/u', $ua, $match)) {
				$this->device->manufacturer = Manufacturers::identify(TYPE_TELEVISION, $match[1]);
				if (!isset($this->device->series)) $this->device->series = 'Smart TV';
			}

			if (preg_match('/HbbTV\/[0-9.]+;CE-HTML\/[0-9.]+;Vendor\/([^\s;]+);/u', $ua, $match)) {
				$this->device->manufacturer = Manufacturers::identify(TYPE_TELEVISION, $match[1]);
				if (!isset($this->device->series)) $this->device->series = 'Smart TV';
			}



			/****************************************************
			 *		Panasonic Smart Viera
			 */

			if (preg_match('/Viera/u', $ua)) {
				$this->device->manufacturer = 'Panasonic';
				$this->device->series = 'Smart Viera';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;

				if (preg_match('/Panasonic\.tv\.([0-9]+)/u', $ua, $match)) {
					$this->device->series = 'Smart Viera ' . $match[1];
				}

				if (preg_match('/\(Panasonic, ([0-9]+),/u', $ua, $match)) {
					$this->device->series = 'Smart Viera ' . $match[1];
				}
			}

			/****************************************************
			 *		Panasonic Diga
			 */

			if (preg_match('/; Diga;/u', $ua)) {
				$this->device->manufacturer = 'Panasonic';
				$this->device->series = 'Diga';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}



			/****************************************************
			 *		Sharp AQUOS TV
			 */

			if (preg_match('/AQUOSBrowser/u', $ua) || preg_match('/AQUOS-(AS|DMP)/u', $ua)) {
				$this->device->manufacturer = 'Sharp';
				$this->device->series = 'Aquos TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;

				if (preg_match('/LC\-([0-9]+[A-Z]+[0-9]+[A-Z]+)/u', $ua, $match)) {
					$this->device->model = $match[1];
					$this->device->generic = false;
				}
			}


			/****************************************************
			 *		Samsung Smart TV
			 */

			if (preg_match('/SMART-TV/u', $ua)) {
				$this->device->manufacturer = 'Samsung';
				$this->device->series = 'Smart TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;

				if (preg_match('/Linux\/SmartTV\+([0-9]*)/u', $ua, $match)) {
					$this->device->series = 'Smart TV ' . $match[1];
				}

				elseif (preg_match('/Maple([0-9]*)/u', $ua, $match)) {
					$this->device->series = 'Smart TV ' . $match[1];
				}
			}

			if (preg_match('/Maple_([0-9][0-9][0-9][0-9])/u', $ua, $match)) {
				$this->device->manufacturer = 'Samsung';
				$this->device->series = 'Smart TV ' . $match[1];
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}

			if (preg_match('/Maple ([0-9]+\.[0-9]+)\.[0-9]+/u', $ua, $match)) {
				$this->device->manufacturer = 'Samsung';
				$this->device->series = 'Smart TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;

				switch ($match[1]) {
					case '5.0':		$this->device->series = 'Smart TV 2009'; break;
					case '5.1':		$this->device->series = 'Smart TV 2010'; break;
					case '6.0':		$this->device->series = 'Smart TV 2011'; break;
				}
			}

			if (preg_match('/Model\/Samsung-(BD-[A-Z][0-9]+)/u', $ua, $match)) {
				$this->device->manufacturer = 'Samsung';
				$this->device->model = $match[1];
				$this->device->series = 'Blu-ray Player';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}


			/****************************************************
			 *		Sony Internet TV
			 */

			if (preg_match('/SonyCEBrowser/u', $ua)) {
				$this->device->manufacturer = 'Sony';
				$this->device->series = 'Smart TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;

				if (preg_match('/SonyCEBrowser\/[0-9.]+ \((?:BDPlayer; |DTV[0-9]+\/)?([^;_]+)/u', $ua, $match)) {
					if ($match[1] != 'ModelName') {
						$this->device->model = $match[1];
					}
				}
			}

			if (preg_match('/SonyDTV/u', $ua)) {
				$this->device->manufacturer = 'Sony';
				$this->device->series = 'Smart TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;

				if (preg_match('/(KDL-?[0-9]+[A-Z]+[0-9]+)/u', $ua, $match)) {
					$this->device->model = $match[1];
					$this->device->generic = false;
				}

				if (preg_match('/(XBR-?[0-9]+[A-Z]+[0-9]+)/u', $ua, $match)) {
					$this->device->model = $match[1];
					$this->device->generic = false;
				}
			}

			if (preg_match('/SonyBDP/u', $ua)) {
				$this->device->manufacturer = 'Sony';
				$this->device->series = "Blu-ray Player";
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}

			if (preg_match('/SmartBD/u', $ua) && preg_match('/(BDP-[A-Z][0-9]+)/u', $ua, $match)) {
				$this->device->manufacturer = 'Sony';
				$this->device->model = $match[1];
				$this->device->series = 'Blu-ray Player';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}

			if (preg_match('/\s+([0-9]+)BRAVIA/u', $ua, $match)) {
				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Bravia';
				$this->device->series = 'Smart TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		Philips Net TV
			 */

			if (preg_match('/NETTV\//u', $ua)) {
				$this->device->manufacturer = 'Philips';
				$this->device->series = 'Net TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;

				if (preg_match('/AquosTV/u', $ua)) {
					$this->device->manufacturer = 'Sharp';
					$this->device->series = 'Aquos TV';
				}

				if (preg_match('/BANGOLUFSEN/u', $ua)) {
					$this->device->manufacturer = 'Bang & Olufsen';
					$this->device->series = 'Smart TV';
				}

				if (preg_match('/PHILIPS-AVM/u', $ua)) {
					$this->device->series = 'Blu-ray Player';
				}
			}

			/****************************************************
			 *		LG NetCast TV
			 */

			if (preg_match('/LGSmartTV/u', $ua)) {
				$this->device->manufacturer = 'LG';
				$this->device->series = 'Smart TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}

			if (preg_match('/UPLUSTVBROWSER/u', $ua)) {
				$this->device->manufacturer = 'LG';
				$this->device->series = 'U+ tv';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}


			/* NetCast */

			if (preg_match('/LG NetCast\.(TV|Media)-([0-9]*)/u', $ua, $match)) {
				$this->device->manufacturer = 'LG';
				$this->device->series = 'NetCast ' . $match[1] . ' ' . $match[2];
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;

				if (preg_match('/LG Browser\/[0-9.]+\([^;]+; LGE; ([^;]+);/u', $ua, $match)) {
					if (substr($match[1], 0, 6) != 'GLOBAL') {
						$this->device->model = $match[1];
					}
				}
			}

			/* NetCast or WebOS */

			if (preg_match('/NetCast/u', $ua) && preg_match('/SmartTV\/([0-9])/u', $ua, $match)) {
				$this->device->manufacturer = 'LG';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;

				if (intval($match[1]) < 5) {
					$this->device->series = 'NetCast TV';
				} 
				else {
					$this->device->series = 'webOS TV';
				}
			}

			/* WebOS */

			if (preg_match('/Web[O0]S/u', $ua) && preg_match('/Large Screen/u', $ua)) {
				$this->device->manufacturer = 'LG';
				$this->device->series = 'webOS TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}

			if (preg_match('/webOS\.TV-([0-9]+)/u', $ua, $match)) {
				$this->device->manufacturer = 'LG';
				$this->device->series = 'webOS TV'; // . $match[1];
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;

				if (preg_match('/LG Browser\/[0-9.]+\(LGE; ([^;]+);/u', $ua, $match)) {
					if (strtoupper(substr($match[1], 0, 5)) != 'WEBOS') {
						$this->device->model = $match[1];
					}
				}
			}


			/****************************************************
			 *		Toshiba Smart TV
			 */

			if (preg_match('/Toshiba_?TP\//u', $ua) || preg_match('/TSBNetTV\//u', $ua)) {
				$this->device->manufacturer = 'Toshiba';
				$this->device->series = 'Smart TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}

			if (preg_match('/TOSHIBA;[^;]+;([A-Z]+[0-9]+[A-Z]+);/u', $ua, $match)) {
				$this->device->manufacturer = 'Toshiba';
				$this->device->model = $match[1];
				$this->device->series = 'Smart TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}


			/****************************************************
			 *		Loewe
			 */

			if (preg_match('/LOEWE\/TV/u', $ua)) {
				$this->device->manufacturer = 'Loewe';
				$this->device->series = 'Smart TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;

				if (preg_match('/((?:SL|ID)[0-9]+)/u', $ua, $match)) {
					$this->device->model = $match[1];
				}
			}


			/****************************************************
			 *		KreaTV
			 */

			if (preg_match('/KreaTV/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->series = 'KreaTV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;

				if (preg_match('/Motorola/u', $ua)) {
					$this->device->manufacturer = 'Motorola';
				}
			}


			/****************************************************
			 *		ADB
			 */

			if (preg_match('/\(ADB; ([^\)]+)\)/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'ADB';
				$this->device->model = ($match[1] != 'Unknown' ? str_replace('ADB', '', $match[1]) . ' ' : '') . 'IPTV receiver';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}

			/****************************************************
			 *		MStar
			 */

			if (preg_match('/Mstar;OWB/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'MStar';
				$this->device->model = 'PVR';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;

				$this->browser->name = 'Origyn Web Browser';
			}

			/****************************************************
			 *		TechniSat
			 */

			if (preg_match('/TechniSat ([^;]+);/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'TechniSat';
				$this->device->model = $match[1];
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}

			/****************************************************
			 *		Technicolor
			 */

			if (preg_match('/Technicolor_([^;]+);/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Technicolor';
				$this->device->model = $match[1];
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}

			/****************************************************
			 *		Winbox Evo2
			 */

			if (preg_match('/Winbox Evo2/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Winbox';
				$this->device->model = 'Evo2';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}

			/****************************************************
			 *		DuneHD
			 */

			if (preg_match('/DuneHD\//u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Dune HD';
				$this->device->model = '';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;

				if (preg_match('/DuneHD\/[0-9.]+ \(([^;]+);/u', $ua, $match)) {
					$this->device->model = $match[1];
				}
			}

			/****************************************************
			 *		Roku
			 */

			if (preg_match('/^Roku\/DVP-([0-9]+)/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Roku';
				$this->device->type = TYPE_TELEVISION;

				switch ($match[1]) {
					case '2000':	$this->device->model = 'HD'; $this->device->generic = false; break;
					case '2050':	$this->device->model = 'XD'; $this->device->generic = false; break;
					case '2100':	$this->device->model = 'XDS'; $this->device->generic = false; break;
					case '2400':	$this->device->model = 'LT'; $this->device->generic = false; break;
					case '3000':	$this->device->model = '2 HD'; $this->device->generic = false; break;
					case '3050':	$this->device->model = '2 XD'; $this->device->generic = false; break;
					case '3100':	$this->device->model = '2 XS'; $this->device->generic = false; break;
				}

				$this->device->identified |= ID_MATCH_UA;
			}


			/****************************************************
			 *		AppleTV
			 */

			if (preg_match('/AppleTV[0-9],[0-9]/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->model = 'AppleTV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}


			/****************************************************
			 *		WebTV
			 */

			if (preg_match('/WebTV\/[0-9.]/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->model = 'WebTV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}


			/****************************************************
			 *		OpenTV
			 */

			if (preg_match('/OpenTV/u', $ua)) {
				$this->device->series = 'OpenTV';
				$this->device->type = TYPE_TELEVISION;
			}


			/****************************************************
			 *		MediStream
			 */

			if (preg_match('/MediStream/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Bewatec';
				$this->device->model = 'MediStream';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}


			/****************************************************
			 *		BrightSign
			 */

			if (preg_match('/BrightSign\/[0-9\.]+(?:-[a-z0-9\-]+)? \(([^\)]+)/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'BrightSign';
				$this->device->model = $match[1];
				$this->device->type = TYPE_SIGNAGE;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}


			/****************************************************
			 *		Iadea
			 */

			if (preg_match('/ADAPI/u', $ua) && preg_match('/\(MODEL:([^\)]+)\)/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Iadea';
				$this->device->model = $match[1];
				$this->device->type = TYPE_SIGNAGE;
				$this->device->identified |= ID_MATCH_UA;
				$this->device->generic = false;
			}


			/****************************************************
			 *		Generic
			 */

			if ($this->device->type == TYPE_TELEVISION) {

				/* Drop OS */
				if (isset($this->os->name) && !in_array($this->os->name, array('Tizen', 'Android', 'Google TV'))) {
					unset($this->os->name);
					unset($this->os->version);
				}


				/* Format model numbers */
				if (isset($this->device->model) && isset($this->device->manufacturer)) {

					if ($this->device->manufacturer == 'Dune HD') {
						if (preg_match('/tv([0-9]+[a-z]?)/u', $this->device->model, $match)) {
							$this->device->model = 'TV-' . strtoupper($match[1]);
						}

						if ($this->device->model == 'connect') {
							$this->device->model = 'Connect';
						}
					}

					if ($this->device->manufacturer == 'Humax') {
						$this->device->series = "Digital Receiver";
					}

					if ($this->device->manufacturer == 'Inverto') {
						if (preg_match('/IDL[ -]?([0-9]+.*)/u', $this->device->model, $match)) {
							$this->device->model = 'IDL ' . $match[1];
						}

						if (preg_match('/MBN([0-9]+)/u', $this->device->model, $match)) {
							$this->device->model = 'MBN ' . $match[1];
						}
					}

					if ($this->device->manufacturer == 'HyperPanel') {
						$this->device->model = strtok(strtoupper($this->device->model), ' ');
					}

					if ($this->device->manufacturer == 'LG') {
						if (preg_match('/(?:ATSC|DVB)-(.*)/u', $this->device->model, $match)) {
							$this->device->model = $match[1];
							$this->device->generic = false;
						}

						if (preg_match('/[0-9][0-9]([A-Z][A-Z][0-9][0-9][0-9][0-9A-Z])/u', $this->device->model, $match)) {
							$this->device->model = $match[1];
							$this->device->generic = false;
						}

						if (preg_match('/Media\/(.*)/u', $this->device->model, $match)) {
							$this->device->model = $match[1];
							$this->device->generic = false;
						}
					}

					if ($this->device->manufacturer == 'Loewe') {
						$this->device->series = 'Smart TV';

						if (preg_match('/((?:ID|SL)[0-9]+)/u', $ua, $match)) {
							$this->device->model = 'Connect '.  $match[1];
							$this->device->generic = false;
						}
					}

					if ($this->device->manufacturer == 'Philips') {
						if (preg_match('/[0-9][0-9]([A-Z][A-Z][A-Z][0-9][0-9][0-9][0-9])/u', $this->device->model, $match)) {
							$this->device->model = $match[1];
							$this->device->generic = false;
						}

						if (preg_match('/(MT[0-9]+)/u', $this->device->model, $match)) {
							$this->device->model = $match[1];
							$this->device->series = "Digital Receiver";
							$this->device->generic = false;
						}

						if (preg_match('/(BDP[0-9]+)/u', $this->device->model, $match)) {
							$this->device->model = $match[1];
							$this->device->series = "Blu-ray Player";
							$this->device->generic = false;
						}
					}

					if ($this->device->manufacturer == 'Toshiba') {
						if (preg_match('/DTV_(.*)/u', $this->device->model, $match)) {
							$this->device->model = 'Regza ' . $match[1];
							$this->device->generic = false;
						}

						if (preg_match('/[0-9][0-9]([A-Z][A-Z][0-9][0-9][0-9])/u', $this->device->model, $match)) {
							$this->device->model = 'Regza ' . $match[1];
							$this->device->generic = false;
						}

						if (preg_match('/[0-9][0-9](ZL[0-9])/u', $this->device->model, $match)) {
							$this->device->model = $match[1] . ' Cevo';
							$this->device->generic = false;
						}

						if (preg_match('/(BDX[0-9]+)/u', $this->device->model, $match)) {
							$this->device->model = $match[1];
							$this->device->series = "Blu-ray Player";
							$this->device->generic = false;
						}
					}

					if ($this->device->manufacturer == 'Selevision') {
						$this->device->model = str_replace('Selevision ', '', $this->device->model);
					}

					if ($this->device->manufacturer == 'Sharp') {
						if (preg_match('/[0-9][0-9]([A-Z]+[0-9]+[A-Z]+)/u', $this->device->model, $match)) {
							$this->device->model = $match[1];
							$this->device->generic = false;
						}
					}

					if ($this->device->manufacturer == 'Sony') {
						if (preg_match('/(BDP[0-9]+G)/u', $this->device->model, $match)) {
							$this->device->model = $match[1];
							$this->device->series = "Blu-ray Player";
							$this->device->generic = false;
						}

						if (preg_match('/KDL?-?[0-9]*([A-Z]+[0-9]+)[A-Z]*/u', $this->device->model, $match)) {
							$this->device->model = 'Bravia ' . $match[1];
							$this->device->series = 'Smart TV';
							$this->device->generic = false;
						}
					}

					if ($this->device->manufacturer == 'Pioneer') {
						if (preg_match('/(BDP-[0-9]+)/u', $this->device->model, $match)) {
							$this->device->model = $match[1];
							$this->device->series = "Blu-ray Player";
							$this->device->generic = false;
						}
					}
				}
			}




			/****************************************************
			 *		Detect type based on common identifiers
			 */

			if (preg_match('/SmartTvA\//u', $ua)) {
				$this->device->type = TYPE_TELEVISION;
			}

			if (preg_match('/NETRANGEMMH/u', $ua)) {
				$this->device->type = TYPE_TELEVISION;
			}

			if (preg_match('/MIDP/u', $ua)) {
				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		Try to detect any devices based on common
			 *		locations of model ids
			 */

			if (!isset($this->device->model) && !isset($this->device->manufacturer)) {
				$candidates = array();

				if (!preg_match('/^(Mozilla|Opera)/u', $ua)) if (preg_match('/^(?:MQQBrowser\/[0-9\.]+\/)?([^\s]+)/u', $ua, $match)) {
					$match[1] = preg_replace('/_TD$/u', '', $match[1]);
					$match[1] = preg_replace('/_CMCC$/u', '', $match[1]);
					$match[1] = preg_replace('/[_ ]Mozilla$/u', '', $match[1]);
					$match[1] = preg_replace('/ Linux$/u', '', $match[1]);
					$match[1] = preg_replace('/ Opera$/u', '', $match[1]);
					$match[1] = preg_replace('/\/[0-9].*$/u', '', $match[1]);

					array_push($candidates, $match[1]);
				}

				if (preg_match('/^((?:SAMSUNG|TCL|ZTE) [^\s]+)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/(Samsung (?:GT|SCH|SGH|SHV|SHW|SPH)-[A-Z-0-9]+)/ui', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/[0-9]+x[0-9]+; ([^;]+)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/[0-9]+x[0-9]+; [^;]+; ([^;]+)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\s*([^;]*[^\s])\s*; [0-9]+\*[0-9]+\)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/[0-9]+X[0-9]+ ([^;\/\(\)]+)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Windows NT 5.1; ([^;]+); Windows Phone/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\) PPC; (?:[0-9]+x[0-9]+; )?([^;\/\(\)]+)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Windows Mobile; ([^;]+); PPC;/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\(([^;]+); U; Windows Mobile/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Series60\/[0-9\.]+ ([^\s]+) Profile/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Vodafone\/1.0\/([^\/]+)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/^(DoCoMo[^(]+)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\ ([^\s]+)$/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/; ([^;\)]+)\)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/^(.*)\/UCWEB/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/^([^\s]+\s[^\s]+)\s+Opera/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/^([a-z0-9\.\_\-\+\/ ]+) Linux/iu', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/^([a-z0-9\.\_\-\+\/ ]+) Android/iu', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\(([a-z0-9\.\_\-\+\/ ]+) Browser/iu', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/^([a-z0-9\.\_\-\+\/ ]+) Release/iu', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Mozilla\/[0-9.]+ ([a-z0-9\.\-\_\+\/ ]+) Browser/iu', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/ \(([^\)]+)\)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/^([a-z0-9\.\_\+\/ ]+)_TD\//iu', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (isset($this->os->name)) {
					for ($i = 0; $i < count($candidates); $i++) {
						$result = false;

						if (!isset($this->device->model) && !isset($this->device->manufacturer)) {
							if (isset($this->os->name) && ($this->os->name == 'Android' || $this->os->name == 'Linux')) {
								$device = DeviceModels::identify('android', $candidates[$i]);
								if ($device->identified) {
									$result = true;

									$device->identified |= $this->device->identified;
									$this->device = $device;

									if ($this->os->name != 'Android') {
										$this->os->name = 'Android';
										$this->os->version = null;
									}
								}
							}

							if (!isset($this->os->name) || $this->os->name == 'Windows' || $this->os->name == 'Windows Mobile' || $this->os->name == 'Windows CE') {
								$device = DeviceModels::identify('wm', $candidates[$i]);
								if ($device->identified) {
									$result = true;

									$device->identified |= $this->device->identified;
									$this->device = $device;

									if (isset($this->os->name) && $this->os->name != 'Windows Mobile') {
										$this->os->name = 'Windows Mobile';
										$this->os->version = null;
									}
								}
							}
						}
					}
				}

				if (!isset($this->device->model) && !isset($this->device->manufacturer)) {
					$identified = false;

					for ($i = 0; $i < count($candidates); $i++) {
						if (!$this->device->identified) {
							if (preg_match('/^acer_([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Acer';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^ALCATEL[_-]([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Alcatel';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;

								if (preg_match('/^TRIBE ([^\s]+)/ui', $this->device->model, $match)) {
									$this->device->model = 'One Touch Tribe ' . $match[1];
								}

								elseif (preg_match('/^ONE TOUCH ([^\s]*)/ui', $this->device->model, $match)) {
									$this->device->model = 'One Touch ' . $match[1];
								}

								elseif (preg_match('/^OT[-\s]*([^\s]*)/ui', $this->device->model, $match)) {
									$this->device->model = 'One Touch ' . $match[1];
								}

								$identified = true;
							}

							if (preg_match('/^BenQ-([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'BenQ';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Bird[ _]([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Bird';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^(?:YL-|YuLong-)?COOLPAD([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Coolpad';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Coship ([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Coship';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^DESAY[ _]([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'DESAY';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Diamond_([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Diamond';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^DoCoMo\/[0-9\.]+ ([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'DoCoMo';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^dopod[-_]?([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Dopod';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^GIONEE[-_]([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Gionee';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^HIKe_([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'HIKe';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Hisense[ -](?:HS-)?([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Hisense';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^HS-([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Hisense';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^HTC[_-]?([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'HTC';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^HUAWEI[\s_-]?([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Huawei';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^KDDI-([^\s;]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'KDDI';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^KONKA[-_]?([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Konka';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^K-Touch_?([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'K-Touch';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Lenovo-([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Lenovo';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Lephone_([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Lephone';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/(?:^|\()LGE?(?:\/|-|_|\s)([^\s]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'LG';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^MOT-([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Motorola';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Motorola_([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Motorola';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Nokia-?([^\/]+)(?:\/|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Nokia';

								if ($match[1] != 'Browser') {
									$this->device->model = DeviceModels::cleanup($match[1]);
									$this->device->type = TYPE_MOBILE;
									$this->device->identified = false;
									$this->device->generic = false;
									$identified = true;

									if (!$this->device->identified) {
										$device = DeviceModels::identify('s60', $this->device->model);
										if ($device->identified) {
											$device->identified |= $this->device->identified;
											$this->device = $device;

											if (!isset($this->os->name) || $this->os->name != 'Series60') {
												$this->os->name = 'Series60';
												$this->os->version = null;
											}
										}
									}

									if (!$this->device->identified) {
										$device = DeviceModels::identify('s40', $this->device->model);
										if ($device->identified) {
											$device->identified |= $this->device->identified;
											$this->device = $device;

											if (!isset($this->os->name) || $this->os->name != 'Series40') {
												$this->os->name = 'Series40';
												$this->os->version = null;
											}
										}
									}

									if (!$this->device->identified) {
										$device = DeviceModels::identify('asha', $this->device->model);
										if ($device->identified) {
											$device->identified |= $this->device->identified;
											$this->device = $device;

											if (!isset($this->os->name) || $this->os->name != 'Nokia Asha Platform') {
												$this->os->name = 'Nokia Asha Platform';
												$this->os->version = new Version(array('value' => '1.0'));

												if (preg_match('/java_runtime_version=Nokia_Asha_([0-9_]+);/u', $ua, $match)) {
													$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
												}
											}
										}
									}
								}
							}

							if (preg_match('/^OPPO_([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Oppo';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Pantech([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Pantech';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Philips([^\/_\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Philips';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^SE([A-Z][0-9]+[a-z])$/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Sony Ericsson';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->identified = false;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^SonyEricsson([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Sony Ericsson';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->identified = false;
								$this->device->generic = false;
								$identified = true;

								if (preg_match('/^[a-z][0-9]+/u', $this->device->model)) {
									$this->device->model[0] = strtoupper($this->device->model[0]);
								}

								if (isset($this->os->name) && $this->os->name == 'Series60') {
									$device = DeviceModels::identify('s60', $this->device->model);
									if ($device->identified) {
										$device->identified |= $this->device->identified;
										$this->device = $device;
									}
								}
							}

							if (preg_match('/^T-smart_([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'T-smart';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^TCL[-_ ]([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'TCL';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Toshiba\/([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Toshiba';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^SHARP[-_\/]([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Sharp';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^SAMSUNG[-\/ ]?([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Samsung';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->identified = false;
								$this->device->generic = false;
								$identified = true;

								if (isset($this->os->name) && $this->os->name == 'Bada') {
									$device = DeviceModels::identify('bada', $this->device->model);
									if ($device->identified) {
										$device->identified |= $this->device->identified;
										$this->device = $device;
									}
								}

								else if (isset($this->os->name) && $this->os->name == 'Series60') {
									$device = DeviceModels::identify('s60', $this->device->model);
									if ($device->identified) {
										$device->identified |= $this->device->identified;
										$this->device = $device;
									}
								}

								else if (preg_match('/Jasmine\/([0-9.]*)/u', $ua, $match)) {
									$version = $match[1];

									$device = DeviceModels::identify('touchwiz', $this->device->model);
									if ($device->identified) {
										$device->identified |= $this->device->identified;
										$this->device = $device;
										$this->os->name = 'Touchwiz';

										switch($version) {
											case '0.8':		$this->os->version = new Version(array('value' => '1.0')); break;
											case '1.0':		$this->os->version = new Version(array('value' => '2.0', 'alias' => '2.0 or earlier')); break;
											case '2.0':		$this->os->version = new Version(array('value' => '3.0')); break;
										}
									}
								}

								else if (preg_match('/(?:Dolfin\/([0-9.]*)|Browser\/Dolfin([0-9.]*))/u', $ua, $match)) {
									$version = $match[1] || $match[2];

									$device = DeviceModels::identify('bada', $this->device->model);
									if ($device->identified) {
										$device->identified |= $this->device->identified;
										$this->device = $device;
										$this->os->name = 'Bada';

										switch($version) {
											case '2.0':		$this->os->version = new Version(array('value' => '1.0')); break;
											case '2.2':		$this->os->version = new Version(array('value' => '1.2')); break;
											case '3.0':		$this->os->version = new Version(array('value' => '2.0')); break;
										}
									}

									else {
										$device = DeviceModels::identify('touchwiz', $this->device->model);
										if ($device->identified) {
										$device->identified |= $this->device->identified;
											$this->device = $device;
											$this->os->name = 'Touchwiz';

											switch($version) {
												case '1.5':		$this->os->version = new Version(array('value' => '2.0')); break;
												case '2.0':		$this->os->version = new Version(array('value' => '3.0')); break;
											}
										}
									}
								}
							}

							if (preg_match('/^Spice\s([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Spice';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^UTStar-([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'UTStar';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Xiaomi[_]?([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Xiaomi';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^ZTE[-_]?([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'ZTE';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->generic = false;
								$identified = true;
							}
						}
					}

					if ($identified && !$this->device->identified) {
						if (!$this->device->identified) {
							$device = DeviceModels::identify('bada', $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Bada';
							}
						}

						if (!$this->device->identified) {
							$device = DeviceModels::identify('touchwiz', $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Touchwiz';
							}
						}

						if (!$this->device->identified) {
							$device = DeviceModels::identify('wp', $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Windows Phone';
							}
						}

						if (!$this->device->identified) {
							$device = DeviceModels::identify('wm', $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Windows Mobile';
							}
						}

						if (!$this->device->identified) {
							$device = DeviceModels::identify('android', $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;

								if (!isset($this->os->name) || ($this->os->name != 'Android' && (!isset($this->os->family) || $this->os->family != 'Android'))) {
									$this->os->name = 'Android';
								}
							}
						}

						if (!$this->device->identified) {
							$device = DeviceModels::identify('brew', $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Brew';
							}
						}

						if (!$this->device->identified) {
							$device = DeviceModels::identify('feature', $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
							}
						}
					}

					if ($identified && !$this->device->identified) {
						if (!$this->device->identified) {
							$device = DeviceModels::identify('bada', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Bada';
							}
						}

						if (!$this->device->identified) {
							$device = DeviceModels::identify('touchwiz', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Touchwiz';
							}
						}

						if (!$this->device->identified) {
							$device = DeviceModels::identify('wp', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Windows Phone';
							}
						}

						if (!$this->device->identified) {
							$device = DeviceModels::identify('wm', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Windows Mobile';
							}
						}

						if (!$this->device->identified) {
							$device = DeviceModels::identify('android', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;

								if (!isset($this->os->name)) {
									$this->os->name = 'Android';
								}
							}
						}

						if (!$this->device->identified) {
							$device = DeviceModels::identify('feature', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
							}
						}
					}

					if ($identified) {
						$this->device->identified |= ID_PATTERN;
					}
				}
			}

			if (preg_match('/SoftBank\/[^\/]+\/([^\/]+)\//u', $ua, $match)) {
				$this->device->manufacturer = 'Softbank';
				$this->device->model = DeviceModels::cleanup($match[1]);
				$this->device->type = TYPE_MOBILE;
				$this->device->identified |= ID_PATTERN;
				$this->device->generic = false;
			}

			if (preg_match('/HP(iPAQ[0-9]+)\//u', $ua, $match)) {
				$this->device->manufacturer = 'HP';
				$this->device->model = DeviceModels::cleanup($match[1]);
				$this->device->type = TYPE_MOBILE;
				$this->device->identified |= ID_PATTERN;
				$this->device->generic = false;

				$device = DeviceModels::identify('wm', $this->device->model);
				if ($device->identified) {
					$device->identified |= $this->device->identified;
					$this->device = $device;
				}
			}

			if (preg_match('/\((?:LG[-|\/])(.*) (?:Browser\/)?AppleWebkit/u', $ua, $match)) {
				$this->device->manufacturer = 'LG';
				$this->device->model = DeviceModels::cleanup($match[1]);
				$this->device->type = TYPE_MOBILE;
				$this->device->identified |= ID_PATTERN;
				$this->device->generic = false;
			}

			if (preg_match('/^Mozilla\/5.0 \((?:Nokia|NOKIA)(?:\s?)([^\)]+)\)UC AppleWebkit\(like Gecko\) Safari\/530$/u', $ua, $match)) {
				$this->device->manufacturer = 'Nokia';
				$this->device->model = DeviceModels::cleanup($match[1]);
				$this->device->type = TYPE_MOBILE;
				$this->device->identified |= ID_PATTERN;
				$this->device->generic = false;

				if (! ($this->device->identified & ID_MATCH_UA)) {
					$device = DeviceModels::identify('s60', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;

						if (!isset($this->os->name) || $this->os->name != 'Series60') {
							$this->os->name = 'Series60';
							$this->os->version = null;
						}
					}
				}

				if (! ($this->device->identified & ID_MATCH_UA)) {
					$device = DeviceModels::identify('s40', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;

						if (!isset($this->os->name) || $this->os->name != 'Series40') {
							$this->os->name = 'Series40';
							$this->os->version = null;
						}
					}
				}
			}



			/****************************************************
			 *		Safari
			 */

			if (preg_match('/Safari/u', $ua)) {

				if (isset($this->os->name) && $this->os->name == 'iOS') {
					$this->browser->stock = true;
					$this->browser->hidden = true;
					$this->browser->name = 'Safari';
					$this->browser->version = null;

					if (preg_match('/Version\/([0-9\.]+)/u', $ua, $match)) {
						$this->browser->version = new Version(array('value' => $match[1], 'hidden' => true));
					}
				}

				if (isset($this->os->name) && ($this->os->name == 'OS X' || $this->os->name == 'Windows')) {
					$this->browser->name = 'Safari';
					$this->browser->stock = $this->os->name == 'OS X';

					if (preg_match('/Version\/([0-9\.]+)/u', $ua, $match)) {
						$this->browser->version = new Version(array('value' => $match[1]));
					}

					if (preg_match('/AppleWebKit\/[0-9\.]+\+/u', $ua)) {
						$this->browser->name = 'WebKit Nightly Build';
						$this->browser->version = null;
					}
				}
			}

			/****************************************************
			 *		Internet Explorer
			 */

			if (preg_match('/MSIE/u', $ua)) {
				$this->browser->name = 'Internet Explorer';

				if (preg_match('/IEMobile/u', $ua) || preg_match('/Windows CE/u', $ua) || preg_match('/Windows Phone/u', $ua) || preg_match('/WP7/u', $ua) || preg_match('/WPDesktop/u', $ua)) {
					$this->browser->name = 'Mobile Internet Explorer';
				}

				if (preg_match('/MSIE ([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/Mac_/u', $ua)) {
					$this->os->name = 'Mac OS';
					$this->engine->name = 'Tasman';
					$this->device->type = TYPE_DESKTOP;

					if ($this->browser->version->toFloat() >= 5.11 && $this->browser->version->toFloat() <= 5.13) {
						$this->os->name = 'OS X';
					}

					if ($this->browser->version->toFloat() >= 5.2) {
						$this->os->name = 'OS X';
					}
				}
			}

			if (preg_match('/\(IE ([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Internet Explorer';
				$this->browser->version = new Version(array('value' => $match[1]));
			}

			if (preg_match('/Browser\/IE([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Internet Explorer';
				$this->browser->version = new Version(array('value' => $match[1]));
			}

			if (preg_match('/Trident\/[789][^\)]+; rv:([0-9.]*)\)/u', $ua, $match)) {
				$this->browser->name = 'Internet Explorer';
				$this->browser->version = new Version(array('value' => $match[1]));
			}

			if (preg_match('/Trident\/[789][^\)]+; Touch; rv:([0-9.]*);\s+IEMobile\//u', $ua, $match)) {
				$this->browser->name = 'Mobile Internet Explorer';
				$this->browser->version = new Version(array('value' => $match[1]));
			}

			if (preg_match('/Trident\/[789][^\)]+; Touch; rv:([0-9.]*); WPDesktop/u', $ua, $match)) {
				$this->browser->mode = 'desktop';
				$this->browser->name = 'Mobile Internet Explorer';
				$this->browser->version = new Version(array('value' => $match[1]));
			}


			/****************************************************
			 *		Firefox
			 */

			if (preg_match('/Firefox/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/Firefox\/([0-9ab.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));

					if (preg_match('/a/u', $match[1])) {
						$this->browser->channel = 'Aurora';
					}

					if (preg_match('/b/u', $match[1])) {
						$this->browser->channel = 'Beta';
					}
				}

				if (preg_match('/Fennec/u', $ua)) {
					$this->device->type = TYPE_MOBILE;
				}

				if (preg_match('/Mobile;(?: ([^;]+);)? rv/u', $ua, $match)) {
					$this->device->type = TYPE_MOBILE;

					if (isset($match[1])) {
						$device = DeviceModels::identify('firefoxos', $match[1]);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->os->name = 'Firefox OS';
							$this->device = $device;
						}
					}
				}

				if (preg_match('/Tablet;(?: ([^;]+);)? rv/u', $ua, $match)) {
					$this->device->type = TYPE_TABLET;

					if (isset($match[1])) {
						$device = DeviceModels::identify('firefoxos', $match[1]);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->os->name = 'Firefox OS';
							$this->device = $device;
						}
					}
				}

				if ($this->device->type == TYPE_MOBILE || $this->device->type == TYPE_TABLET) {
					$this->browser->name = 'Firefox Mobile';
				}

				if ($this->device->type == '') {
					$this->device->type = TYPE_DESKTOP;
				}
			}

			if (preg_match('/Namoroka/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/Namoroka\/([0-9ab.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				$this->browser->channel = 'Namoroka';
			}

			if (preg_match('/Shiretoko/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/Shiretoko\/([0-9ab.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				$this->browser->channel = 'Shiretoko';
			}

			if (preg_match('/Minefield/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/Minefield\/([0-9ab.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				$this->browser->channel = 'Minefield';
			}

			if (preg_match('/BonEcho/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/BonEcho\/([0-9ab.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				$this->browser->channel = 'BonEcho';
			}

			if (preg_match('/Firebird/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firebird';

				if (preg_match('/Firebird\/([0-9ab.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
			}

			/****************************************************
			 *		SeaMonkey
			 */

			if (preg_match('/SeaMonkey/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'SeaMonkey';

				if (preg_match('/SeaMonkey\/([0-9ab.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if ($this->device->type == '') {
					$this->device->type = TYPE_DESKTOP;
				}
			}

			if (preg_match('/PmWFx\/([0-9ab.]*)/u', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->name = 'SeaMonkey';
				$this->browser->version = new Version(array('value' => $match[1]));
			}



			/****************************************************
			 *		Netscape
			 */

			if (preg_match('/Netscape/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Netscape';

				if (preg_match('/Netscape[0-9]?\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
			}

			/****************************************************
			 *		Konqueror
			 */

			if (preg_match('/[k|K]onqueror\//u', $ua)) {
				$this->browser->name = 'Konqueror';

				if (preg_match('/[k|K]onqueror\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if ($this->device->type == '') {
					$this->device->type = TYPE_DESKTOP;
				}
			}

			/****************************************************
			 *		Chrome
			 */

			if (preg_match('/(?:Chrome|CrMo|CriOS)\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->name = 'Chrome';
				$this->browser->version = new Version(array('value' => $match[1]));

				if (isset($this->os->name) && $this->os->name == 'Android') {
					switch (implode('.', array_splice((explode('.', $match[1])), 0, 3))) {
						case '16.0.912':
							$this->browser->channel = 'Beta';
							break;
						case '18.0.1025':
						case '25.0.1364':
						case '27.0.1453':
						case '29.0.1547':
						case '30.0.1599':
						case '31.0.1650':
						case '32.0.1700':
						case '33.0.1750':
						case '34.0.1847':
						case '35.0.1916':
						case '36.0.1985':
						case '37.0.2062':
						case '38.0.2125':
						case '39.0.2171':
						case '40.0.2214':
							$this->browser->version->details = 1;
							break;
						default:
							$this->browser->channel = 'Dev';
							break;
					}

					/* Webview for Android 4.4 and higher */
					if (implode('.', array_splice((explode('.', $match[1])), 1, 2)) == '0.0' && preg_match('/Version\//u', $ua)) {
						$this->browser->stock = true;
						$this->browser->name = null;
						$this->browser->version = null;
						$this->browser->channel = null;
					}

					/* LG Chromium based browsers */
					if (isset($device->manufacturer) && $device->manufacturer == 'LG') {
						if (in_array($match[1], array('30.0.1599.103', '34.0.1847.118', '38.0.2125.102')) && preg_match('/Version\/4/u', $ua)) {
							$this->browser->name = "LG Browser";
							$this->browser->channel = null;
							$this->browser->stock = true;
							$this->browser->version = null;
							$this->browser->channel = null;
						}
					}

					/* Samsung Chromium based browsers */
					if (isset($device->manufacturer) && $device->manufacturer == 'Samsung') {

						/* Version 1.0 */
						if ($match[1] == '18.0.1025.308' && preg_match('/Version\/1.0/u', $ua)) {
							$this->browser->name = "Samsung Browser";
							$this->browser->channel = null;
							$this->browser->stock = true;
							$this->browser->version = new Version(array('value' => '1.0'));
							$this->browser->channel = null;
						}

						/* Version 1.5 */
						if ($match[1] == '28.0.1500.94' && preg_match('/Version\/1.5/u', $ua)) {
							$this->browser->name = "Samsung Browser";
							$this->browser->channel = null;
							$this->browser->stock = true;
							$this->browser->version = new Version(array('value' => '1.5'));
							$this->browser->channel = null;
						}

						/* Version 1.6 */
						if ($match[1] == '28.0.1500.94' && preg_match('/Version\/1.6/u', $ua)) {
							$this->browser->name = "Samsung Browser";
							$this->browser->channel = null;
							$this->browser->stock = true;
							$this->browser->version = new Version(array('value' => '1.6'));
							$this->browser->channel = null;
						}

						/* Version 2.0 */
						if ($match[1] == '34.0.1847.76' && preg_match('/Version\/2.0/u', $ua)) {
							$this->browser->name = "Samsung Browser";
							$this->browser->channel = null;
							$this->browser->stock = true;
							$this->browser->version = new Version(array('value' => '2.0'));
							$this->browser->channel = null;
						}

						/* Version 2.1 */
						if ($match[1] == '34.0.1847.76' && preg_match('/Version\/2.1/u', $ua)) {
							$this->browser->name = "Samsung Browser";
							$this->browser->channel = null;
							$this->browser->stock = true;
							$this->browser->version = new Version(array('value' => '2.1'));
							$this->browser->channel = null;
						}
					}

					/* Samsung Chromium based browsers */
					if (preg_match('/SamsungBrowser\/([0-9.]*)/u', $ua, $match)) {
						$this->browser->name = "Samsung Browser";
						$this->browser->channel = null;
						$this->browser->stock = true;
						$this->browser->version = new Version(array('value' => $match[1]));
						$this->browser->channel = null;
					}
				}

				else {
					switch (implode('.', array_splice((explode('.', $match[1])), 0, 3))) {
						case '0.2.149':
						case '0.3.154':
						case '0.4.154':
						case '4.1.249':
							$this->browser->version->details = 2;
							break;

						case '1.0.154':
						case '2.0.172':
						case '3.0.195':
						case '4.0.249':
						case '5.0.375':
						case '6.0.472':
						case '7.0.517':
						case '8.0.552':
						case '9.0.597':
						case '10.0.648':
						case '11.0.696':
						case '12.0.742':
						case '13.0.782':
						case '14.0.835':
						case '15.0.874':
						case '16.0.912':
						case '17.0.963':
						case '18.0.1025':
						case '19.0.1084':
						case '20.0.1132':
						case '21.0.1180':
						case '22.0.1229':
						case '23.0.1271':
						case '24.0.1312':
						case '25.0.1364':
						case '26.0.1410':
						case '27.0.1453':
						case '28.0.1500':
						case '29.0.1547':
						case '30.0.1599':
						case '31.0.1650':
						case '32.0.1700':
						case '33.0.1750':
						case '34.0.1847':
						case '35.0.1916':
						case '36.0.1985':
						case '37.0.2062':
						case '38.0.2125':
						case '39.0.2171':
						case '40.0.2214':
							$this->browser->version->details = 1;
							break;
						default:
							$this->browser->channel = 'Dev';
							break;
					}
				}

				if ($this->device->type == '') {
					$this->device->type = TYPE_DESKTOP;
				}
			}

			/****************************************************
			 *		Chromium
			 */

			if (preg_match('/Chromium/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->channel = '';
				$this->browser->name = 'Chromium';

				if (preg_match('/Chromium\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if ($this->device->type == '') {
					$this->device->type = TYPE_DESKTOP;
				}
			}


			/****************************************************
			 *		Opera
			 */

			if (preg_match('/OPR\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->channel = '';
				$this->browser->name = 'Opera';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));

				if (preg_match('/Edition Developer/u', $ua)) {
					$this->browser->channel = 'Developer';
				}

				if (preg_match('/Edition Next/u', $ua)) {
					$this->browser->channel = 'Next';
				}

				if (preg_match('/Edition beta/u', $ua)) {
					$this->browser->channel = 'Beta';
				}

				if ($this->device->type == TYPE_MOBILE) {
					$this->browser->name = 'Opera Mobile';
				}
			}

			if (preg_match('/Opera[\/\-\s]/iu', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Opera';

				if (preg_match('/Opera[\/| ]([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
					if (floatval($match[1]) >= 10)
						$this->browser->version = new Version(array('value' => $match[1]));
					else
						$this->browser->version = null;
				}

				if (isset($this->browser->version) && preg_match('/Edition Labs/u', $ua)) {
					$this->browser->channel = 'Labs';
				}

				if (isset($this->browser->version) && preg_match('/Edition Next/u', $ua)) {
					$this->browser->channel = 'Next';
				}

				if (preg_match('/Opera Tablet/u', $ua)) {
					$this->browser->name = 'Opera Mobile';
					$this->device->type = TYPE_TABLET;
				}

				if (preg_match('/Opera Mobi/u', $ua)) {
					$this->browser->name = 'Opera Mobile';
					$this->device->type = TYPE_MOBILE;
				}

				if (preg_match('/Opera Mini;/u', $ua)) {
					$this->browser->name = 'Opera Mini';
					$this->browser->version = null;
					$this->browser->mode = 'proxy';
					$this->device->type = TYPE_MOBILE;
				}

				if (preg_match('/Opera Mini\/(?:att\/)?([0-9.]*)/u', $ua, $match)) {
					$this->browser->name = 'Opera Mini';
					$this->browser->version = new Version(array('value' => $match[1], 'details' => (intval(substr(strrchr($match[1], '.'), 1)) > 99 ? -1 : null)));
					$this->browser->mode = 'proxy';
					$this->device->type = TYPE_MOBILE;
				}

				if ($this->browser->name == 'Opera' && $this->device->type == TYPE_MOBILE) {
					$this->browser->name = 'Opera Mobile';

					if (preg_match('/BER/u', $ua)) {
						$this->browser->name = 'Opera Mini';
						$this->browser->version = null;
					}
				}

				if (preg_match('/InettvBrowser/u', $ua)) {
					$this->device->type = TYPE_TELEVISION;
				}

				if (preg_match('/Opera[ -]TV/u', $ua)) {
					$this->browser->name = 'Opera';
					$this->device->type = TYPE_TELEVISION;
				}

				if (preg_match('/Linux zbov/u', $ua)) {
					$this->browser->name = 'Opera Mobile';
					$this->browser->mode = 'desktop';

					$this->device->type = TYPE_MOBILE;

					$this->os->name = null;
					$this->os->version = null;
				}

				if (preg_match('/Linux zvav/u', $ua)) {
					$this->browser->name = 'Opera Mini';
					$this->browser->version = null;
					$this->browser->mode = 'desktop';

					$this->device->type = TYPE_MOBILE;

					$this->os->name = null;
					$this->os->version = null;
				}

				if ($this->device->type == '') {
					$this->device->type = TYPE_DESKTOP;
				}
			}

			if (preg_match('/OPiOS\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Opera Mini';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2 ));
			}

			if (preg_match('/Coast\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Coast by Opera';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 3 ));
			}

			/****************************************************
			 *		wOSBrowser
			 */

			if (preg_match('/wOSBrowser/u', $ua)) {
				$this->browser->name = 'webOS Browser';

				if ($this->os->name != 'webOS') {
					$this->os->name = 'webOS';
				}
			}

			/****************************************************
			 *		Sailfish Browser
			 */

			if (preg_match('/Sailfish ?Browser/u', $ua)) {
				$this->browser->name = 'Sailfish Browser';
				$this->browser->stock = true;

				if (preg_match('/Sailfish ?Browser\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));
				}
			}

			/****************************************************
			 *		BrowserNG
			 */

			if (preg_match('/BrowserNG/u', $ua)) {
				$this->browser->name = 'Nokia Browser';

				if (preg_match('/BrowserNG\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3, 'builds' => false));
				}
			}

			/****************************************************
			 *		Nokia Browser
			 */

			if (preg_match('/NokiaBrowser/u', $ua)) {
				$this->browser->name = 'Nokia Browser';
				$this->browser->channel = null;

				if (preg_match('/NokiaBrowser\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				}
			}

			/****************************************************
			 *		Nokia Xpress
			 *
			 *		Mozilla/5.0 (X11; Linux x86_64; rv:5.0.1) Gecko/20120822 OSRE/1.0.7f
			 */

			if (preg_match('/OSRE/u', $ua)) {
				$this->browser->name = 'Nokia Xpress';
				$this->browser->mode = 'proxy';
				$this->device->type = TYPE_MOBILE;

				$this->os->name = null;
				$this->os->version = null;
			}

			if (preg_match('/S40OviBrowser/u', $ua)) {
				$this->browser->name = 'Nokia Xpress';
				$this->browser->mode = 'proxy';

				if (preg_match('/S40OviBrowser\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				if (preg_match('/Nokia([^\/]+)\//u', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = $match[1];
					$this->device->identified |= ID_PATTERN;

					if (isset($this->device->model)) {
						$device = DeviceModels::identify('s40', $this->device->model);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}

					if (isset($this->device->model)) {
						$device = DeviceModels::identify('asha', $this->device->model);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->os->name = 'Nokia Asha Platform';
							$this->os->version = new Version(array('value' => '1.0'));
							$this->device = $device;


							if (preg_match('/java_runtime_version=Nokia_Asha_([0-9_]+);/u', $ua, $match)) {
								$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
							}
						}
					}
				}

				if (preg_match('/NOKIALumia([0-9]+)/u', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = $match[1];
					$this->device->identified |= ID_PATTERN;

					$device = DeviceModels::identify('wp', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
						$this->os->name = 'Windows Phone';
					}
				}
			}


			/****************************************************
			 *		MicroB
			 */

			if (preg_match('/Maemo[ |_]Browser/u', $ua)) {
				$this->browser->name = 'MicroB';

				if (preg_match('/Maemo[ |_]Browser[ |_]([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				}
			}


			/****************************************************
			 *		Silk
			 */

			if (preg_match('/Silk/u', $ua)) {
				if (preg_match('/Silk-Accelerated/u', $ua) || !preg_match('/PlayStation/u', $ua)) {
					$this->browser->name = 'Silk';
					$this->browser->channel = null;

					if (preg_match('/Silk\/([0-9.]*)/u', $ua, $match)) {
						$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));
					}

					if (preg_match('/; ([^;]*[^;\s])\s+Build/u', $ua, $match)) {
						$this->device = DeviceModels::identify('android', $match[1]);
					}

					if (!$this->device->identified) {
						$this->device->manufacturer = 'Amazon';
						$this->device->model = 'Kindle Fire';
						$this->device->type = TYPE_TABLET;
						$this->device->identified |= ID_INFER;
					}

					if (isset($this->os->name) && $this->os->name != 'Android') {
						$this->os->name = 'Android';
						$this->os->version = null;
					}
				}
			}

			/****************************************************
			 *		Dolfin
			 */

			if (preg_match('/Dolfin/u', $ua) || preg_match('/Jasmine/u', $ua)) {
				$this->browser->name = 'Dolfin';

				if (preg_match('/Dolfin\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/Browser\/Dolfin([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/Jasmine\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
			}

			/****************************************************
			 *		Iris
			 */

			if (preg_match('/Iris/u', $ua)) {
				$this->browser->name = 'Iris';

				$this->device->type = TYPE_MOBILE;
				$this->device->manufacturer = null;
				$this->device->model = null;

				$this->os->name = 'Windows Mobile';
				$this->os->version = null;

				if (preg_match('/Iris\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/ WM([0-9]) /u', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1] . '.0'));
				} else {
					$this->browser->mode = 'desktop';
				}
			}

			/****************************************************
			 *		Boxee
			 */

			if (preg_match('/Boxee/u', $ua)) {
				$this->browser->name = 'Boxee';
				$this->device->type = TYPE_TELEVISION;

				if (preg_match('/Boxee\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
			}

			/****************************************************
			 *		Sraf TV Browser
			 */

			if (preg_match('/sraf_tv_browser/u', $ua)) {
				$this->browser->name = 'Sraf TV Browser';
				$this->browser->version = null;
				$this->device->type = TYPE_TELEVISION;
			}

			/****************************************************
			 *		LG Browser
			 */

			if (preg_match('/LG Browser\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'LG Browser';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));
				$this->device->type = TYPE_TELEVISION;
			}

			if (preg_match('/NetCast/u', $ua) && preg_match('/SmartTV\//u', $ua)) {
				unset($this->browser->name);
				unset($this->browser->version);
			}

			/****************************************************
			 *		Sony Browser
			 */

			if (preg_match('/SonyBrowserCore\/([0-9.]*)/u', $ua, $match)) {
				unset($this->browser->name);
				unset($this->browser->version);
				$this->device->type = TYPE_TELEVISION;
			}



			/****************************************************
			 *		Espial
			 */

			if (preg_match('/Espial/u', $ua)) {
				$this->browser->name = 'Espial';

				$this->os->name = '';
				$this->os->version = null;

				if ($this->device->type != TYPE_TELEVISION) {
					$this->device->type = TYPE_TELEVISION;
					$this->device->manufacturer = null;
					$this->device->model = null;
				}

				if (preg_match('/Espial\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/;L7200/u', $ua)) {
					$this->device->manufacturer = 'Toshiba';
					$this->device->model = 'Regza L7200';
					$this->device->series = 'Smart TV';
					$this->device->identified |= ID_MATCH_UA;
					$this->device->generic = false;
				}
			}

			/****************************************************
			 *		MachBlue XT
			 */

			if (preg_match('/mbxtWebKit\/([0-9.]*)/u', $ua, $match)) {
				$this->os->name = '';
				$this->browser->name = 'MachBlue XT';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));
				$this->device->type = TYPE_TELEVISION;
			}

			if ($ua == 'MachBlue') {
				$this->os->name = '';
				$this->browser->name = 'MachBlue XT';
				$this->device->type = TYPE_TELEVISION;
			}

			/****************************************************
			 *		ANT Galio
			 */

			if (preg_match('/ANTGalio\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'ANT Galio';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				$this->device->type = TYPE_TELEVISION;
			}

			/****************************************************
			 *		NetFront
			 */

			if (preg_match('/Net[fF]ront/u', $ua)) {
				$this->browser->name = 'NetFront';
				$this->device->type = TYPE_MOBILE;

				if (preg_match('/NetFront\/?([0-9.]*)/ui', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/InettvBrowser/u', $ua)) {
					$this->device->type = TYPE_TELEVISION;
				}
			}

			if (preg_match('/Browser\/NF([0-9.]*)/ui', $ua, $match)) {
				$this->browser->name = 'NetFront';
				$this->browser->version = new Version(array('value' => $match[1]));
				$this->device->type = TYPE_MOBILE;
			}

			if (preg_match('/Browser\/NetFont-([0-9.]*)/ui', $ua, $match)) {
				$this->browser->name = 'NetFront';
				$this->browser->version = new Version(array('value' => $match[1]));
				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		NetFront NX
			 */

			if (preg_match('/NX\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'NetFront NX';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));

				if (!isset($this->device->type) || !$this->device->type) {
					if (preg_match('/DTV/iu', $ua)) {
						$this->device->type = TYPE_TELEVISION;
					} else if (preg_match('/mobile/iu', $ua)) {
						$this->device->type = TYPE_MOBILE;
					} else {
						$this->device->type = TYPE_DESKTOP;
					}
				}

				$this->os->name = '';
				$this->os->version = null;
			}

			/****************************************************
			 *		XBMC
			 */

			if (preg_match('/^XBMC\/(?:PRE-)?([0-9.]+)/u', $ua, $match)) {
				$this->browser->name = 'XBMC';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));
			}

			/****************************************************
			 *		Obigo
			 */

			if (preg_match('/(?:Obigo|Teleca)/ui', $ua)) {
				$this->browser->name = 'Obigo';

				if (preg_match('/Obigo\/0?([0-9.]+)/iu', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				else if (preg_match('/(?:Obigo(?:InternetBrowser| Browser)?|Teleca)\/([A-Z]+)0?([0-9.]+)/ui', $ua, $match)) {
					$this->browser->name = 'Obigo ' . $match[1];
					$this->browser->version = new Version(array('value' => $match[2]));
				}

				else if (preg_match('/(?:Obigo|Teleca)[- ]([A-Z]+)0?([0-9.]+)[\/;]/ui', $ua, $match)) {
					$this->browser->name = 'Obigo ' . $match[1];
					$this->browser->version = new Version(array('value' => $match[2]));
				}

				else if (preg_match('/Browser\/(?:Obigo|Teleca)[_-](?:Browser\/)?([A-Z]+)0?([0-9.]+)/ui', $ua, $match)) {
					$this->browser->name = 'Obigo ' . $match[1];
					$this->browser->version = new Version(array('value' => $match[2]));
				}
			}

			/****************************************************
			 *		UC Web
			 */

			if (preg_match('/UCWEB/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';

				unset($this->browser->channel);

				if (preg_match('/UCWEB\/?([0-9]*[.][0-9]*)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				if (!$this->device->type) {
					$this->device->type = TYPE_MOBILE;
				}

				if (isset($this->os->name) && $this->os->name == 'Linux') {
					$this->os->name = '';
				}

				if (preg_match('/^IUC ?\(U; ?iOS ([0-9\._]+);/u', $ua, $match)) {
					$this->os->name = 'iOS';
					$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
				}

				if (preg_match('/^JUC ?\(Linux; ?U; ?(?:Android)? ?([0-9\.]+)[^;]*; ?[^;]+; ?([^;]*[^\s])\s*; ?[0-9]+\*[0-9]+;?\)/u', $ua, $match)) {
					$this->os->name = 'Android';
					$this->os->version = new Version(array('value' => $match[1]));

					$this->device = DeviceModels::identify('android', $match[2]);
				}

				if (preg_match('/; Adr ([0-9\.]+); [^;]+; ([^;]*[^\s])\)/u', $ua, $match)) {
					$this->os->name = 'Android';
					$this->os->version = new Version(array('value' => $match[1]));

					$this->device = DeviceModels::identify('android', $match[2]);
				}

				if (preg_match('/\(iOS;/u', $ua)) {
					$this->os->name = 'iOS';
					$this->os->version = new Version(array('value' => '1.0'));

					if (preg_match('/OS ([0-9_]*);/u', $ua, $match)) {
						$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
					}
				}

				if (preg_match('/\(Windows;/u', $ua)) {
					$this->os->name = 'Windows Phone';
					$this->os->version = null;

					if (preg_match('/wds ([0-9]\.[0-9])/u', $ua, $match)) {
						switch($match[1]) {
							case '7.0':		$this->os->version = new Version(array('value' => '7.0')); break;
							case '7.1':		$this->os->version = new Version(array('value' => '7.5')); break;
							case '8.0':		$this->os->version = new Version(array('value' => '8.0')); break;
						}
					}

					if (preg_match('/; ([^;]+); ([^;]+)\)/u', $ua, $match)) {
						$this->device->manufacturer = $match[1];
						$this->device->model = $match[2];
						$this->device->identified |= ID_PATTERN;

						$device = DeviceModels::identify('wp', $match[2]);

						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}
				}
			}

			if (preg_match('/Ucweb\/([0-9]*[.][0-9]*)/u', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
			}

			if (preg_match('/ucweb-squid/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';

				unset($this->browser->channel);
			}

			if (preg_match('/\) UC /u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';

				unset($this->browser->version);
				unset($this->browser->channel);
				unset($this->browser->mode);

				if (!$this->device->type) {
					$this->device->type = TYPE_MOBILE;
				}

				if ($this->device->type == TYPE_DESKTOP) {
					$this->device->type = TYPE_MOBILE;
					$this->browser->mode = 'desktop';
				}
			}

			if (preg_match('/UC ?Browser\/?([0-9.]*)/u', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));

				unset($this->browser->channel);

				if (!$this->device->type) {
					$this->device->type = TYPE_MOBILE;
				}
			}

			if (preg_match('/UBrowser\/?([0-9.]*)/u', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));

				unset($this->browser->channel);
			}

			/* U2 is the Proxy service used by UC Browser on low-end phones */
			if (preg_match('/U2\//u', $ua)) {
				$this->engine->name = 'Gecko';
				$this->browser->mode = 'proxy';

				/* UC Browser running on Windows 8 is identifing itself as U2, but instead its a Trident Webview */
				if (isset($this->os->name) && isset($this->os->version)) {
					if ($this->os->name == 'Windows Phone' && $this->os->version->toFloat() >= 8) {
						$this->engine->name = 'Trident';
						$this->browser->mode = '';
					}
				}

				if (!$this->device->identified && preg_match('/; ([^;]*)\) U2\//u', $ua, $match)) {
					$device = DeviceModels::identify('android', $match[1]);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;

						if (!isset($this->os->name) || ($this->os->name != 'Android' && (!isset($this->os->family) || $this->os->family != 'Android'))) {
							$this->os->name = 'Android';
						}
					}
				}
			}

			/* U3 is the Webkit based Webview used on Android phones */
			if (preg_match('/U3\//u', $ua)) {
				$this->engine->name = 'Webkit';
			}


			/****************************************************
			 *		NineSky
			 */

			if (preg_match('/Ninesky(?:-android-mobile(?:-cn)?)?\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'NineSky';
				$this->browser->version = new Version(array('value' => $match[1]));

				if (isset($this->device->manufacturer) && $this->device->manufacturer == 'Apple') {
					unset($this->device->manufacturer);
					unset($this->device->model);
					unset($this->device->identifier);
					$this->device->identified = ID_NONE;
				}

				if (isset($this->os->name) && $this->os->name != 'Android') {
					$this->os->name = 'Android';
					$this->os->version = null;
				}
			}

			/****************************************************
			 *		Skyfire
			 */

			if (preg_match('/Skyfire\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Skyfire';
				$this->browser->version = new Version(array('value' => $match[1]));

				$this->device->type = TYPE_MOBILE;

				$this->os->name = 'Android';
				$this->os->version = null;
			}

			/****************************************************
			 *		Dolphin HD
			 */

			if (preg_match('/Dolphin(?:HDCN)?\/(?:INT|CN)?-?([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Dolphin';
				$this->browser->version = new Version(array('value' => $match[1]));

				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		QQ Browser
			 */

			if (preg_match('/(M?QQBrowser)\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'QQ Browser';

				$version = $match[2];
				if (preg_match('/^[0-9][0-9]$/u', $version)) $version = $version[0] . '.' . $version[1];

				$this->browser->version = new Version(array('value' => $version, 'details' => 2));
				$this->browser->channel = '';

				if (!isset($this->os->name) && $match[1] == 'QQBrowser') {
					$this->os->name = 'Windows';
				}
			}

			if (preg_match('/MQQBrowser\/Mini([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'QQ Browser Mini';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));
				$this->browser->channel = '';
			}

			/****************************************************
			*		360 Phone Browser
			*/

			if (preg_match('/360 (?:Aphone|Android Phone) Browser \((?:Version |V)?([0-9.]*)(?:beta)?\)/u', $ua, $match)) {
				$this->browser->name = '360 Phone Browser';
				$this->browser->channel = '';
				$this->browser->version = null;
				$this->browser->version = new Version(array('value' => $match[1]));
				
				if (preg_match('/360\(android/u', $ua) && (!isset($this->os->name) || ($this->os->name != 'Android' && (!isset($this->os->family) || $this->os->family != 'Android')))) {
					$this->os->name = 'Android';
					$this->os->version = null;
					$this->device->type = TYPE_MOBILE;
				}
			}

			/****************************************************
			 *		iBrowser
			 */

			if (preg_match('/(iBrowser)\/([0-9.]*)/u', $ua, $match) && !preg_match('/OviBrowser/u', $ua)) {
				$this->browser->name = 'iBrowser';

				$version = $match[2];
				if (preg_match('/^[0-9][0-9]$/u', $version)) $version = $version[0] . '.' . $version[1];

				$this->browser->version = new Version(array('value' => $version, 'details' => 2));
				$this->browser->channel = '';
			}

			if (preg_match('/iBrowser\/Mini([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'iBrowser Mini';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));
				$this->browser->channel = '';
			}

			/****************************************************
			 *		Puffin
			 */

			if (preg_match('/Puffin\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Puffin';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));
				$this->browser->mode = 'proxy';
				$this->browser->channel = '';

				$this->device->type = TYPE_MOBILE;

				if ($this->os->name == 'Linux') {
					$this->os->name = null;
					$this->os->version = null;
				}
			}

			/****************************************************
			 *		Midori
			 */

			if (preg_match('/Midori\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Midori';
				$this->browser->version = new Version(array('value' => $match[1]));

				$this->device->manufacturer = null;
				$this->device->model = null;
				$this->device->type = TYPE_DESKTOP;

				if (isset($this->os->name) && $this->os->name == 'OS X') {
					$this->os->name = null;
					$this->os->version = null;
				}
			}

			if (preg_match('/midori$/u', $ua)) {
				$this->browser->name = 'Midori';
			}


			/****************************************************
			 *		MiniBrowser Mobile
			 */

			if (preg_match('/MiniBr?owserM(?:obile)?\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'MiniBrowser';
				$this->browser->version = new Version(array('value' => $match[1]));

				$this->os->name = 'Series60';
				$this->os->version = null;
			}

			/****************************************************
			 *		Maxthon
			 */

			if (preg_match('/Maxthon/iu', $ua, $match)) {
				$this->browser->name = 'Maxthon';
				$this->browser->channel = '';
				$this->browser->version = null;
				
				if (preg_match('/Maxthon[\/\' ]\(?([0-9.]*)\)?/iu', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				if (isset($this->os->name) && $this->browser->version && $this->os->name == 'Windows' && $this->browser->version->toFloat() < 4) {
					$this->browser->version->details = 1;
				}
			}

			if (preg_match('/MxNitro/iu', $ua, $match)) {
				$this->browser->name = 'Maxthon Nitro';
				$this->browser->channel = '';
				$this->browser->version = null;
				
				if (preg_match('/MxNitro\/([0-9.]*)/iu', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				}
			}

			/****************************************************
			 *		WebPositive
			 */

			if (preg_match('/WebPositive/u', $ua, $match)) {
				$this->browser->name = 'WebPositive';
				$this->browser->channel = '';
				$this->browser->version = null;

				if (preg_match('/WebPositive\/([0-9]\.[0-9.]+)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				}
			}

			/****************************************************
			 *		WorldWideweb
			 */

			if (preg_match('/WorldWideweb \(NEXT\)/u', $ua, $match)) {
				$this->browser->name = 'WorldWideWeb';
				$this->browser->channel = '';
				$this->browser->version = null;

				$this->os->name = 'NextStep';
			}

			/****************************************************
			 *		Sogou Mobile
			 */

			if (preg_match('/SogouAndroidBrowser\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Sogou Mobile';
				$this->browser->version = new Version(array('value' => $match[1]));

				if (isset($this->device->manufacturer) && $this->device->manufacturer == 'Apple') {
					unset($this->device->manufacturer);
					unset($this->device->model);
					unset($this->device->identifier);
					$this->device->identified = ID_NONE;
				}

				if (isset($this->os->name) && $this->os->name != 'Android') {
					$this->os->name = 'Android';
					$this->os->version = null;
				}
			}





			/****************************************************
			 *		Others
			 */

			$browsers = array(
				array('name' => 'AdobeAIR',				'regexp' => '/AdobeAIR\/([0-9.]*)/u'),
				array('name' => 'Awesomium',			'regexp' => '/Awesomium\/([0-9.]*)/u'),
				array('name' => 'Bsalsa Embedded',		'regexp' => '/EmbeddedWB ([0-9.]*)/u'),
				array('name' => 'Bsalsa Embedded',		'regexp' => '/bsalsa\.com/u'),
				array('name' => 'Bsalsa Embedded',		'regexp' => '/Embedded Web Browser/u'),
				array('name' => 'Canvace',				'regexp' => '/Canvace Standalone\/([0-9.]*)/u'),
				array('name' => 'Ekioh',				'regexp' => '/Ekioh\/([0-9.]*)/u'),
				array('name' => 'JavaFX',				'regexp' => '/JavaFX\/([0-9.]*)/u'),
				array('name' => 'GFXe',					'regexp' => '/GFXe\/([0-9.]*)/u'),
				array('name' => 'LuaKit',				'regexp' => '/luakit/u'),
				array('name' => 'Titanium',				'regexp' => '/Titanium\/([0-9.]*)/u'),
				array('name' => 'OpenWebKitSharp',		'regexp' => '/OpenWebKitSharp/u'),
				array('name' => 'Prism',				'regexp' => '/Prism\/([0-9.]*)/u'),
				array('name' => 'Qt',					'regexp' => '/Qt\/([0-9.]*)/u'),
				array('name' => 'QtEmbedded',			'regexp' => '/QtEmbedded/u'),
				array('name' => 'QtEmbedded',			'regexp' => '/QtEmbedded.*Qt\/([0-9.]*)/u'),
				array('name' => 'ReqwirelessWeb',		'regexp' => '/ReqwirelessWeb\/([0-9.]*)/u'),
				array('name' => 'RhoSimulator',			'regexp' => '/RhoSimulator/u'),
				array('name' => 'UWebKit',				'regexp' => '/UWebKit\/([0-9.]*)/u'),
				array('name' => 'Node-WebKit',			'regexp' => '/nw-tests\/([0-9.]*)/u'),
				array('name' => 'WebKit2.NET',			'regexp' => '/WebKit2.NET/u'),

				array('name' => 'PhantomJS',			'regexp' => '/PhantomJS\/([0-9.]*)/u'),

				array('name' => 'Google Earth',			'regexp' => '/Google Earth\/([0-9.]*)/u'),
				array('name' => 'EA Origin',			'regexp' => '/Origin\/([0-9.]*)/u'),
				array('name' => 'SecondLife',			'regexp' => '/SecondLife\/([0-9.]*)/u'),
				array('name' => 'Valve Steam',			'regexp' => '/Valve Steam/u'),

				array('name' => 'Bluefish',				'regexp' => '/bluefish ([0-9.]*)/u'),
				array('name' => 'Songbird',				'regexp' => '/Songbird\/([0-9.]*)/u'),
				array('name' => 'Thunderbird',			'regexp' => '/Thunderbird[\/ ]([0-9.]*)/u', 'type' => TYPE_DESKTOP),
				array('name' => 'Microsoft FrontPage',	'regexp' => '/MS FrontPage ([0-9.]*)/u', 'details' => 2, 'type' => TYPE_DESKTOP),
				array('name' => 'Microsoft Outlook',	'regexp' => '/Microsoft Outlook IMO, Build ([0-9.]*)/u', 'details' => 2, 'type' => TYPE_DESKTOP),
				array('name' => 'FeedDemon',			'regexp' => '/FeedDemon\/([0-9.]*)/u'),
				array('name' => 'iTunes',				'regexp' => '/iTunes\/([0-9.]*)/u'),

				array('name' => '1Browser',				'regexp' => '/1Password\/([0-9.]*)/u'),
				array('name' => '2345 Browser',			'regexp' => '/Mb2345Browser\/([0-9.]*)/u'),
				array('name' => '3G Explorer',			'regexp' => '/3G Explorer\/([0-9.]*)/u', 'details' => 3),
				array('name' => '4G Explorer',			'regexp' => '/4G Explorer\/([0-9.]*)/u', 'details' => 3),
				array('name' => '360 Extreme Explorer',	'regexp' => '/QIHU 360EE/u', 'type' => TYPE_DESKTOP),
				array('name' => '360 Safe Explorer',	'regexp' => '/QIHU 360SE/u', 'type' => TYPE_DESKTOP),
				array('name' => 'ABrowse',				'regexp' => '/A[Bb]rowse ([0-9.]*)/u'),
				array('name' => 'Abrowser',				'regexp' => '/Abrowser\/([0-9.]*)/u'),
				array('name' => 'AltiBrowser',			'regexp' => '/AltiBrowser\/([0-9.]*)/i'),
				array('name' => 'AOL Desktop',			'regexp' => '/AOL ([0-9.]*); AOLBuild/i'),
				array('name' => 'AOL Browser',			'regexp' => '/America Online Browser (?:[0-9.]*); rev([0-9.]*);/i'),
				array('name' => 'Arachne',				'regexp' => '/Arachne\/([0-9.]*)/u', 'type' => TYPE_DESKTOP),
				array('name' => 'Arora',				'regexp' => '/[Aa]rora\/([0-9.]*)/u'),							// see: www.arora-browser.org
				array('name' => 'Avant Browser',		'regexp' => '/Avant Browser/u'),
				array('name' => 'Avant Browser',		'regexp' => '/Avant TriCore/u'),
				array('name' => 'Aviator',				'regexp' => '/Aviator\/([0-9.]*)/u', 'details' => 1),
				array('name' => 'AWeb',					'regexp' => '/Amiga-AWeb\/([0-9.]*)/u'),
				array('name' => 'Baidu Browser',		'regexp' => '/M?BaiduBrowser\/([0-9.]*)/i'),
				array('name' => 'Baidu Browser',		'regexp' => '/BdMobile\/([0-9.]*)/i'),
				array('name' => 'Baidu Browser',		'regexp' => '/FlyFlow\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Baidu Browser',		'regexp' => '/BIDUBrowser[ \/]([0-9.]*)/u'),
				array('name' => 'Baidu Browser',		'regexp' => '/BaiduHD\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Baidu Spark',			'regexp' => '/BDSpark\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Black Wren',			'regexp' => '/BlackWren\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Blazer',				'regexp' => '/Blazer\/([0-9.]*)/u'),
				array('name' => 'BrightSign', 			'regexp' => '/BrightSign\/([0-9.]*)/u', 'type' => TYPE_SIGNAGE),
				array('name' => 'Byffox', 				'regexp' => '/Byffox\/([0-9.]*)/u', 'type' => TYPE_DESKTOP),
				array('name' => 'Camino', 				'regexp' => '/Camino\/([0-9.]*)/u', 'type' => TYPE_DESKTOP),
				array('name' => 'Canure', 				'regexp' => '/Canure\/([0-9.]*)/u', 'details' => 3),
				array('name' => 'CometBird', 			'regexp' => '/CometBird\/([0-9.]*)/u'),
				array('name' => 'Comodo Dragon', 		'regexp' => '/Comodo_Dragon\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Comodo Dragon', 		'regexp' => '/Dragon\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Conkeror', 			'regexp' => '/[Cc]onkeror\/([0-9.]*)/u'),
				array('name' => 'CoolNovo', 			'regexp' => '/(?:CoolNovo|CoolNovoChromePlus)\/([0-9.]*)/u', 'details' => 3, 'type' => TYPE_DESKTOP),
				array('name' => 'ChromePlus', 			'regexp' => '/ChromePlus(?:\/([0-9.]*))?$/u', 'details' => 3, 'type' => TYPE_DESKTOP),
				array('name' => 'Cunaguaro', 			'regexp' => '/Cunaguaro\/([0-9.]*)/u', 'details' => 3, 'type' => TYPE_DESKTOP),
				array('name' => 'CuteBrowser', 			'regexp' => '/CuteBrowser\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Cyberfox', 			'regexp' => '/Cyberfox\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Daedalus', 			'regexp' => '/Daedalus ([0-9.]*)/u', 'details' => 2),
				array('name' => 'Demobrowser', 			'regexp' => '/demobrowser\/([0-9.]*)/u'),
				array('name' => 'Doga Rhodonit', 		'regexp' => '/DogaRhodonit/u'),
				array('name' => 'Dorado', 				'regexp' => '/Browser\/Dorado([0-9.]*)/u'),
				array('name' => 'Dooble', 				'regexp' => '/Dooble(?:\/([0-9.]*))?/u'),
				array('name' => 'Dorothy', 				'regexp' => '/Dorothy$/u'),
				array('name' => 'DWB', 					'regexp' => '/dwb(?:-hg)?(?:\/([0-9.]*))?/u'),
				array('name' => 'GNOME Web', 			'regexp' => '/Epiphany\/([0-9.]*)/u', 'type' => TYPE_DESKTOP),
				array('name' => 'ELinks', 				'regexp' => '/ELinks\/([0-9.]*[0-9])/u', 'type' => TYPE_DESKTOP),
				array('name' => 'EVM Browser', 			'regexp' => '/EVMBrowser\/([0-9.]*)/u'),
				array('name' => 'FireWeb', 				'regexp' => '/FireWeb\/([0-9.]*)/u'),
				array('name' => 'Flock', 				'regexp' => '/Flock\/([0-9.]*)/u', 'details' => 3, 'type' => TYPE_DESKTOP),
				array('name' => 'Galeon', 				'regexp' => '/Galeon\/([0-9.]*)/u', 'details' => 3),
				array('name' => 'Helium', 				'regexp' => '/HeliumMobileBrowser\/([0-9.]*)/u'),
				array('name' => 'Hive Explorer', 		'regexp' => '/HiveE/u'),
				array('name' => 'IBrowse', 				'regexp' => '/IBrowse\/([0-9.]*)/u', 'type' => TYPE_DESKTOP),
				array('name' => 'iCab', 				'regexp' => '/iCab\/([0-9.]*)/u'),
				array('name' => 'Iceape', 				'regexp' => '/Iceape\/([0-9.]*)/u'),
				array('name' => 'IceCat', 				'regexp' => '/IceCat[ \/]([0-9.]*)/u', 'type' => TYPE_DESKTOP),
				array('name' => 'Comodo IceDragon', 	'regexp' => '/IceDragon\/([0-9.]*)/u', 'details' => 2, 'type' => TYPE_DESKTOP),
				array('name' => 'Iceweasel', 			'regexp' => '/Iceweasel\/([0-9.]*)/iu', 'type' => TYPE_DESKTOP),
				array('name' => 'InternetSurfboard', 	'regexp' => '/InternetSurfboard\/([0-9.]*)/u'),
				array('name' => 'Iron', 				'regexp' => '/Iron\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Isis', 				'regexp' => '/BrowserServer/u'),
				array('name' => 'Isis', 				'regexp' => '/ISIS\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Jumanji', 				'regexp' => '/jumanji/u'),
				array('name' => 'Kazehakase', 			'regexp' => '/Kazehakase\/([0-9.]*)/u'),
				array('name' => 'KChrome', 				'regexp' => '/KChrome\/([0-9.]*)/u', 'details' => 3),
				array('name' => 'Kiosk', 				'regexp' => '/Kiosk\/([0-9.]*)/u'),
				array('name' => 'K-Meleon', 			'regexp' => '/K-Meleon\/([0-9.]*)/u', 'type' => TYPE_DESKTOP),
				array('name' => 'Lbbrowser',			'regexp' => '/LBBROWSER/u'),
				array('name' => 'Leechcraft', 			'regexp' => '/Leechcraft(?:\/([0-9.]*))?/u', 'details' => 2),
				array('name' => 'Lightning', 			'regexp' => '/Lightning\/([0-9.]*)/u'),
				array('name' => 'Lobo', 				'regexp' => '/Lobo\/([0-9.]*)/u', 'type' => TYPE_DESKTOP),
				array('name' => 'Lotus Expeditor', 		'regexp' => '/Gecko Expeditor ([0-9.]*)/u', 'details' => 3),
				array('name' => 'Lunascape', 			'regexp' => '/Lunascape[\/| ]([0-9.]*)/u', 'details' => 3),
				array('name' => 'Lynx', 				'regexp' => '/Lynx\/([0-9.]*)/u'),
				array('name' => 'iLunascape', 			'regexp' => '/iLunascape\/([0-9.]*)/u', 'details' => 3),
				array('name' => 'Intermec Browser', 	'regexp' => '/Intermec\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'MaCross Mobile', 		'regexp' => '/MaCross\/([0-9.]*)/u'),
				array('name' => 'Mammoth', 				'regexp' => '/Mammoth\/([0-9.]*)/u'),										// see: https://itunes.apple.com/cn/app/meng-ma-liu-lan-qi/id403760998?mt=8
				array('name' => 'Mercury Browser', 		'regexp' => '/Mercury\/([0-9.]*)/u'),
				array('name' => 'MixShark', 			'regexp' => '/MixShark\/([0-9.]*)/u'),
				array('name' => 'mlbrowser',			'regexp' => '/mlbrowser/u'),
				array('name' => 'Motorola WebKit', 		'regexp' => '/MotorolaWebKit(?:\/([0-9.]*))?/u', 'details' => 3),
				array('name' => 'NetFront Life Browser', 'regexp' => '/NetFrontLifeBrowser\/([0-9.]*)/u'),
				array('name' => 'NetPositive', 			'regexp' => '/NetPositive\/([0-9.]*)/u'),
				array('name' => 'Netscape Navigator', 	'regexp' => '/Navigator\/([0-9.]*)/u', 'details' => 3),
				array('name' => 'Odyssey', 				'regexp' => '/OWB\/([0-9.]*)/u'),
				array('name' => 'OmniWeb', 				'regexp' => '/OmniWeb/u', 'type' => TYPE_DESKTOP),
				array('name' => 'OneBrowser', 			'regexp' => '/OneBrowser\/([0-9.]*)/u'),
				array('name' => 'Openwave',				'regexp' => '/Openwave\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Orca', 				'regexp' => '/Orca\/([0-9.]*)/u'),
				array('name' => 'Origyn', 				'regexp' => '/Origyn Web Browser/u'),
				array('name' => 'Otter', 				'regexp' => '/Otter Browser\/([0-9.]*)/u'),
				array('name' => 'Palemoon', 			'regexp' => '/Pale[mM]oon\/([0-9.]*)/u'),
				array('name' => 'Phantom', 				'regexp' => '/Phantom\/V([0-9.]*)/u'),
				array('name' => 'Polaris', 				'regexp' => '/Polaris[\/ ]v?([0-9.]*)/iu', 'details' => 2),
				array('name' => 'Polaris', 				'regexp' => '/POLARIS([0-9.]+)/u', 'details' => 2),
				array('name' => 'Qihoo 360', 			'regexp' => '/QIHU THEWORLD/u'),
				array('name' => 'QtCreator', 			'regexp' => '/QtCreator\/([0-9.]*)/u'),
				array('name' => 'QtQmlViewer', 			'regexp' => '/QtQmlViewer/u'),
				array('name' => 'QtTestBrowser', 		'regexp' => '/QtTestBrowser\/([0-9.]*)/u'),
				array('name' => 'QtWeb', 				'regexp' => '/QtWeb Internet Browser\/([0-9.]*)/u'),
				array('name' => 'QupZilla', 			'regexp' => '/QupZilla\/([0-9.]*)/u', 'type' => TYPE_DESKTOP),
				array('name' => 'Ryouko', 				'regexp' => '/Ryouko\/([0-9.]*)/u', 'type' => TYPE_DESKTOP),						// see: https://github.com/foxhead128/ryouko
				array('name' => 'Roccat', 				'regexp' => '/Roccat\/([0-9]\.[0-9.]*)/u'),
				array('name' => 'Raven for Mac', 		'regexp' => '/Raven for Mac\/([0-9.]*)/u'),
				array('name' => 'rekonq', 				'regexp' => '/rekonq(?:\/([0-9.]*))?/u', 'type' => TYPE_DESKTOP),
				array('name' => 'RockMelt', 			'regexp' => '/RockMelt\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'SaaYaa Explorer', 		'regexp' => '/SaaYaa/u', 'type' => TYPE_DESKTOP),
				array('name' => 'Sleipnir', 			'regexp' => '/Sleipnir\/([0-9.]*)/u', 'details' => 3),
				array('name' => 'SlimBoat', 			'regexp' => '/SlimBoat\/([0-9.]*)/u'),
				array('name' => 'SMBrowser', 			'regexp' => '/SMBrowser/u'),
				array('name' => 'Sogou Explorer', 		'regexp' => '/SE 2.X MetaSr/u', 'type' => TYPE_DESKTOP),
				array('name' => 'Sogou Mobile',			'regexp' => '/SogouMobileBrowser\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Snowshoe', 			'regexp' => '/Snowshoe\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Sputnik', 				'regexp' => '/Sputnik\/([0-9.]*)/iu', 'details' => 3),
				array('name' => 'Stainless', 			'regexp' => '/Stainless\/([0-9.]*)/u'),
				array('name' => 'SunChrome', 			'regexp' => '/SunChrome\/([0-9.]*)/u'),
				array('name' => 'Superbird', 			'regexp' => '/Superbird\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Surf', 				'regexp' => '/Surf\/([0-9.]*)/u'),
				array('name' => 'The World', 			'regexp' => '/TheWorld ([0-9.]*)/u'),
				array('name' => 'TaoBrowser', 			'regexp' => '/TaoBrowser\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'TaomeeBrowser', 		'regexp' => '/TaomeeBrowser\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'TazWeb', 				'regexp' => '/TazWeb/u'),
				array('name' => 'Tencent Traveler', 	'regexp' => '/TencentTraveler ([0-9.]*)/u', 'details' => 2),
				array('name' => 'UP.Browser', 			'regexp' => '/UP\.Browser\/([a-z0-9.]*)/u', 'details' => 2),
				array('name' => 'Uzbl', 				'regexp' => '/^Uzbl/u'),
				array('name' => 'Viera', 				'regexp' => '/Viera\/([0-9.]*)/u'),
				array('name' => 'Villanova', 			'regexp' => '/Villanova\/([0-9.]*)/u', 'details' => 3),
				array('name' => 'Vimb', 				'regexp' => '/vimb\/([0-9.]*)/u'),
				array('name' => 'Vivaldi', 				'regexp' => '/Vivaldi\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Voyager',				'regexp' => '/AmigaVoyager\/([0-9.]*)/u'),
				array('name' => 'Waterfox', 			'regexp' => '/Waterfox\/([0-9.]*)/u', 'details' => 2, 'type' => TYPE_DESKTOP),
				array('name' => 'Wavelink Velocity',	'regexp' => '/Wavelink Velocity Browser\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'WebLite', 				'regexp' => '/WebLite\/([0-9.]*)/u', 'type' => TYPE_MOBILE),
				array('name' => 'WebRender', 			'regexp' => '/WebRender/u'),
				array('name' => 'Webster', 				'regexp' => '/Webster ([0-9.]*)/u'),
				array('name' => 'Wear Internet Browser','regexp' => '/WIB\/([0-9.]*)/u'),
				array('name' => 'Wyzo', 				'regexp' => '/Wyzo\/([0-9.]*)/u', 'details' => 3),
				array('name' => 'Miui Browser', 		'regexp' => '/XiaoMi\/MiuiBrowser\/([0-9.]*)/u'),
				array('name' => 'Yandex Browser', 		'regexp' => '/YaBrowser\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Yelang', 				'regexp' => '/Yelang\/([0-9.]*)/u', 'details' => 3),							// see: wellgo.org
				array('name' => 'YRC Weblink', 			'regexp' => '/YRCWeblink\/([0-9.]*)/u'),
				array('name' => 'Zetakey', 				'regexp' => '/Zetakey Webkit\/([0-9.]*)/u'),
				array('name' => 'Zetakey', 				'regexp' => '/Zetakey\/([0-9.]*)/u'),

				array('name' => 'Nimbus', 				'regexp' => '/Nimbus\/([0-9.]*)/u'),

				array('name' => 'McAfee Web Gateway', 	'regexp' => '/Webwasher\/([0-9.]*)/u'),

				array('name' => 'Open Sankoré', 		'regexp' => '/Open-Sankore\/([0-9.]*)/u', 'type' => TYPE_WHITEBOARD),
				array('name' => 'Coship MMCP', 			'regexp' => '/Coship_MMCP_([0-9.]*)/u', 'type' => TYPE_SIGNAGE),

				array('name' => '80legs', 				'regexp' => '/(?:^|\s)008\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'ArchiveBot', 			'regexp' => '/ArchiveTeam ArchiveBot/u', 'type' => TYPE_BOT),
				array('name' => 'Ask Jeeves', 			'regexp' => '/Ask Jeeves\/Teoma/u', 'type' => TYPE_BOT),
				array('name' => 'Ad Muncher', 			'regexp' => '/Ad Muncher v([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'Baiduspider', 			'regexp' => '/Baiduspider[\+ ]\([\+ ]/u', 'type' => TYPE_BOT),
				array('name' => 'Baiduspider', 			'regexp' => '/Baiduspider\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'Baiduspider', 			'regexp' => '/Baiduspider/u', 'type' => TYPE_BOT),
				array('name' => 'Bing', 				'regexp' => '/bingbot\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'Bing', 				'regexp' => '/msnbot\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'Bing Preview', 		'regexp' => '/BingPreview\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'Bloglines', 			'regexp' => '/Bloglines\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'Facebook External Hit','regexp' => '/facebookexternalhit\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'Facebook Scraper', 	'regexp' => '/facebookscraper\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'Facebook Security', 	'regexp' => '/FacebookSecurity\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'FAST Enterprise Crawler', 	'regexp' => '/FAST Enterprise Crawler\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'FAST Web Crawler', 	'regexp' => '/FAST-WebCrawler\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'Googlebot', 			'regexp' => '/Google[Bb]ot\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'Google Ads Bot', 		'regexp' => '/AdsBot-Google/u', 'type' => TYPE_BOT),
				array('name' => 'Google App Engine', 	'regexp' => '/AppEngine-Google/u', 'type' => TYPE_BOT),
				array('name' => 'Google Web Preview',	'regexp' => '/Google Web Preview/u', 'type' => TYPE_BOT),
				array('name' => 'Google Page Speed',	'regexp' => '/Google Page Speed Insights/u', 'type' => TYPE_BOT),
				array('name' => 'Google Feed Fetcher',	'regexp' => '/FeedFetcher-Google/u', 'type' => TYPE_BOT),
				array('name' => 'Google Font Analysis', 'regexp' => '/Google-FontAnalysis\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'Google Sitemaps', 		'regexp' => '/Google-Sitemaps\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'Google News', 			'regexp' => '/Googlebot-News/u', 'type' => TYPE_BOT),
				array('name' => 'Google Wireless Transcoder', 'regexp' => '/Google Wireless Transcoder/u', 'type' => TYPE_BOT),
				array('name' => 'Grub', 				'regexp' => '/grub-client-([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'HeartRails Capture', 	'regexp' => '/HeartRails_Capture\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'CiteSeerX',			'regexp' => '/heritrix\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'PowerMapper',			'regexp' => '/CrawlerProcess \(http:\/\/www\.PowerMapper\.com\) \/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'Sogou Web Spider',		'regexp' => '/Sogou web spider\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'Yahoo Slurp', 			'regexp' => '/Yahoo\! Slurp\/([0-9.]*)/u', 'type' => TYPE_BOT),
				array('name' => 'Wget', 				'regexp' => '/Wget\/([0-9.]*)/u', 'type' => TYPE_BOT)
			);

			for ($b = 0; $b < count($browsers); $b++) {
				if (preg_match($browsers[$b]['regexp'], $ua, $match)) {
					$this->browser->name = $browsers[$b]['name'];
					$this->browser->channel = '';
					$this->browser->hidden = false;
					$this->browser->stock = false;

					if (isset($match[1]) && $match[1]) {
						$this->browser->version = new Version(array('value' => $match[1], 'details' => isset($browsers[$b]['details']) ? $browsers[$b]['details'] : null));
					} else {
						$this->browser->version = null;
					}

					if (isset($browsers[$b]['type'])) {
						$this->device->type = $browsers[$b]['type'];
					}
				}
			}


			/****************************************************
			 *		WebKit
			 */

			if (preg_match('/WebKit\/([0-9.]*)/iu', $ua, $match)) {
				$this->engine->name = 'Webkit';
				$this->engine->version = new Version(array('value' => $match[1]));

				if (preg_match('/(?:Chrome|Chromium)\/([0-9]*)/u', $ua, $match)) {
					if (intval($match[1]) >= 27) {
						$this->engine->name = 'Blink';
					}
				}
			}

			if (preg_match('/Browser\/AppleWebKit\/?([0-9.]*)/iu', $ua, $match)) {
				$this->engine->name = 'Webkit';
				$this->engine->version = new Version(array('value' => $match[1]));
			}

			if (preg_match('/AppleWebkit\(like Gecko\)/iu', $ua, $match)) {
				$this->engine->name = 'Webkit';
			}


			/****************************************************
			 *		KHTML
			 */

			if (preg_match('/KHTML\/([0-9.]*)/u', $ua, $match)) {
				$this->engine->name = 'KHTML';
				$this->engine->version = new Version(array('value' => $match[1]));
			}

			/****************************************************
			 *		Gecko
			 */

			if (preg_match('/Gecko/u', $ua) && !preg_match('/like Gecko/u', $ua)) {
				$this->engine->name = 'Gecko';

				if (preg_match('/; rv:([^\);]+)[\);]/u', $ua, $match)) {
					$this->engine->version = new Version(array('value' => $match[1], 'details' => 3));
				}
			}

			/****************************************************
			 *		Presto
			 */

			if (preg_match('/Presto\/([0-9.]*)/u', $ua, $match)) {
				$this->engine->name = 'Presto';
				$this->engine->version = new Version(array('value' => $match[1]));
			}

			/****************************************************
			 *		Trident
			 */

			if (preg_match('/Trident\/([0-9.]*)/u', $ua, $match)) {
				$this->engine->name = 'Trident';
				$this->engine->version = new Version(array('value' => $match[1]));


				if (isset($this->browser->version) && isset($this->browser->name) && $this->browser->name == 'Internet Explorer') {
					if ($this->engine->version->toNumber() == 7 && $this->browser->version->toFloat() < 11) {
						$this->browser->version = new Version(array('value' => '11.0'));
						$this->browser->mode = 'compat';
					}

					if ($this->engine->version->toNumber() == 6 && $this->browser->version->toFloat() < 10) {
						$this->browser->version = new Version(array('value' => '10.0'));
						$this->browser->mode = 'compat';
					}

					if ($this->engine->version->toNumber() == 5 && $this->browser->version->toFloat() < 9) {
						$this->browser->version = new Version(array('value' => '9.0'));
						$this->browser->mode = 'compat';
					}

					if ($this->engine->version->toNumber() == 4 && $this->browser->version->toFloat() < 8) {
						$this->browser->version = new Version(array('value' => '8.0'));
						$this->browser->mode = 'compat';
					}
				}

				if (isset($this->os->version) && isset($this->os->name) && $this->os->name == 'Windows Phone' && isset($this->browser->name) && $this->browser->name == 'Mobile Internet Explorer') {
					if ($this->engine->version->toNumber() == 7 && $this->os->version->toFloat() < 8.1) {
						$this->os->version = new Version(array('value' => '8.1'));
					}

					if ($this->engine->version->toNumber() == 6 && $this->os->version->toFloat() < 8) {
						$this->os->version = new Version(array('value' => '8.0'));
					}

					if ($this->engine->version->toNumber() == 5 && $this->os->version->toFloat() < 7.5) {
						$this->os->version = new Version(array('value' => '7.5'));
					}
				}
			}

			if (preg_match('/Edge\/([0-9.]*)/u', $ua, $match)) {
				$this->engine->name = 'EdgeHTML';
				$this->engine->version = null;
			}


			/****************************************************
			 *		Corrections
			 */

			if (isset($this->os->name)) {
				if ($this->os->name == 'Android' && $this->browser->stock) {
					$this->browser->hidden = true;
				}

				if ($this->os->name == 'Aliyun OS' && $this->browser->stock) {
					$this->browser->hidden = true;
				}
			}

			if (isset($this->os->name) && isset($this->browser->name)) {
				if ($this->os->name == 'iOS' && ($this->browser->name == 'Opera Mini' && $this->browser->version->toFloat() < 8)) {
					$this->os->version = null;
				}

				if ($this->os->name == 'Series80' && $this->browser->name == 'Internet Explorer') {
					$this->browser->name = null;
					$this->browser->version = null;
				}
			}

			if (isset($this->browser->name) && isset($this->engine->name)) {
				if ($this->browser->name == 'Midori' && $this->engine->name != 'Webkit') {
					$this->engine->name = 'Webkit';
					$this->engine->version = null;
				}
			}


			if (isset($this->browser->name) && $this->browser->name == 'Firefox Mobile' && !isset($this->os->name)) {
				$this->os->name = 'Firefox OS';
			}


			if (isset($this->os->name) && $this->os->name == 'Windows Phone' && isset($this->browser->name) && $this->browser->name == 'Mobile Internet Explorer') {
				if ($this->os->version->toFloat() == 8.0 && $this->browser->version->toNumber() < 10) {
					$this->browser->version = new Version(array('value' => '11'));
				}

				if ($this->os->version->toFloat() == 8.1 && $this->browser->version->toNumber() < 11) {
					$this->browser->version = new Version(array('value' => '11'));
				}
			}

			if (preg_match('/Edge\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Internet Explorer';
				$this->browser->version = new Version(array('value' => $match[1]));
				
				switch($match[1]) {
					case '12.0': $this->browser->version = new Version(array('value' => '11.0')); break;
				}
			}


			if (isset($this->browser->name) && $this->browser->name == 'Opera' && $this->device->type == TYPE_TELEVISION) {
				$this->browser->name = 'Opera Devices';

				if (preg_match('/Presto\/([0-9]+\.[0-9]+)/u', $ua, $match)) {
					switch($match[1]) {
						case '2.12':		$this->browser->version = new Version(array('value' => '3.4')); break;
						case '2.11':		$this->browser->version = new Version(array('value' => '3.3')); break;
						case '2.10':		$this->browser->version = new Version(array('value' => '3.2')); break;
						case '2.9':			$this->browser->version = new Version(array('value' => '3.1')); break;
						case '2.8':			$this->browser->version = new Version(array('value' => '3.0')); break;
						case '2.7':			$this->browser->version = new Version(array('value' => '2.9')); break;
						case '2.6':			$this->browser->version = new Version(array('value' => '2.8')); break;
						case '2.4':			$this->browser->version = new Version(array('value' => '10.3')); break;
						case '2.3':			$this->browser->version = new Version(array('value' => '10')); break;
						case '2.2':			$this->browser->version = new Version(array('value' => '9.7')); break;
						case '2.1':			$this->browser->version = new Version(array('value' => '9.6')); break;
						default:			unset($this->browser->version);
					}
				}

				else if (preg_match('/OMI\/([0-9]+\.[0-9]+)/u', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				else if (preg_match('/OPR\/([0-9]+)/u', $ua, $match)) {
					switch($match[1]) {
						case '17':			$this->browser->version = new Version(array('value' => '4.0')); break;
						case '19':			$this->browser->version = new Version(array('value' => '4.1')); break;
						case '22':			$this->browser->version = new Version(array('value' => '4.2')); break;
						default:			unset($this->browser->version);
					}
				}

				unset($this->os->name);
				unset($this->os->version);
			}

			if (isset($this->browser->name)) {
				if ($this->browser->name == 'UC Browser') {
					if (!preg_match("/UBrowser\//", $ua) && ($this->device->type == 'desktop' || (isset($this->os->name) && ($this->os->name == 'Windows' || $this->os->name == 'OS X')))) {
						$this->device->type = TYPE_MOBILE;

						$this->browser->mode = 'desktop';

						unset($this->engine->name);
						unset($this->engine->version);
						unset($this->os->name);
						unset($this->os->version);
					}

					else if (!isset($this->os->name) || ($this->os->name != 'iOS' && $this->os->name != 'Windows Phone' && $this->os->name != 'Windows' && $this->os->name != 'Android' && (!isset($this->os->family) || $this->os->family != 'Android'))) {
						$this->engine->name = 'Gecko';
						unset($this->engine->version);
						$this->browser->mode = 'proxy';
					}

					if (isset($this->engine->name) && $this->engine->name == 'Presto') {
						$this->engine->name = 'Webkit';
						unset($this->engine->version);
					}
				}
			}

			if (isset($this->device->flag) && $this->device->flag == FLAG_NOKIAX) {
				$this->os->name = 'Nokia X Platform';
				$this->os->family = 'Android';

				unset($this->os->version);
				unset($this->device->flag);
			}

			if (isset($this->device->flag) && $this->device->flag == FLAG_FIREOS) {
				$this->os->name = 'FireOS';
				$this->os->family = 'Android';

				if (isset($this->os->version) && isset($this->os->version->value)) {
					switch($this->os->version->value) {
						case '2.3.3':	$this->os->version = new Version(array('value' => '1')); break;
						case '4.0.3':	$this->os->version = new Version(array('value' => '2')); break;
						case '4.2.2':	$this->os->version = new Version(array('value' => '3')); break;
						case '4.4.2':	$this->os->version = new Version(array('value' => '4')); break;
						case '4.4.3':	$this->os->version = new Version(array('value' => '4.5')); break;
						default:		unset($this->os->version); break;
					}
				}

				unset($this->device->flag);
			}

			if (isset($this->device->flag) && $this->device->flag == FLAG_GOOGLETV) {
				$this->os->name = 'Google TV';
				$this->os->family = 'Android';

				unset($this->os->version);
				unset($this->device->flag);
			}

			if (isset($this->device->flag) && $this->device->flag == FLAG_ANDROIDWEAR) {
				$this->os->name = 'Android Wear';
				$this->os->family = 'Android';
				unset($this->os->version);

				$this->browser->stock = true;
				$this->browser->hidden = true;
				unset($this->browser->channel);

				unset($this->device->flag);
			}

			if (isset($this->device->flag) && $this->device->flag == FLAG_GOOGLEGLASS) {
				$this->os->family = 'Android';
				unset($this->os->name);
				unset($this->os->version);
				unset($this->device->flag);
			}


			if ($this->device->type == TYPE_BOT) {
				$this->device->identified = false;
				unset($this->os->name);
				unset($this->os->version);
				unset($this->device->manufacturer);
				unset($this->device->model);
			}

			if (!$this->device->identified && isset($this->device->model)) {
				if (preg_match('/^[a-z][a-z]-[a-z][a-z]$/u', $this->device->model)) {
					$this->device->model = null;
				}
			}


			if (isset($this->os->name) && $this->os->name == 'Android') {
				if (preg_match('/Build\/([^\);]+)/u', $ua, $match)) {
					$version = BuildIds::identify('android', $match[1]);

					if ($version) {
						if (!isset($this->os->version) || $this->os->version == null || $this->os->version->value == null || $version->toFloat() < $this->os->version->toFloat()) {
							$this->os->version = $version;
						}

						/* Special case for Android L */
						if ($version->toFloat() == 5) {
							$this->os->version = $version;
						}
					}

					$this->os->build = $match[1];
				}
			}

			if ($this->device->type == TYPE_TELEVISION) {
				if (isset($this->browser->name) && $this->browser->name == 'Firefox') {
					unset($this->browser->name);
					unset($this->browser->version);
				}

				if (isset($this->browser->name) && $this->browser->name == 'Internet Explorer') {
					$valid = false;
					if (isset($this->device->model) && in_array($this->device->model, array('WebTV'))) $valid = true;

					if (!$valid) {
						unset($this->browser->name);
						unset($this->browser->version);
					}
				}

				if (isset($this->browser->name) && ($this->browser->name == 'Chrome' || $this->browser->name == 'Chromium')) {
					$valid = false;
					if (isset($this->os->name) && in_array($this->os->name, array('Google TV', 'Android'))) $valid = true;
					if (isset($this->device->model) && in_array($this->device->model, array('Chromecast'))) $valid = true;

					if (!$valid) {
						unset($this->browser->name);
						unset($this->browser->version);
					}
				}
			}
		}

		function toJavaScript() {
			if (isset($this->browser)) {
				echo "this.browser = new Browser({ ";
				echo $this->toJavaScriptObject($this->browser);
				echo " });\n";
			}

			if (isset($this->engine)) {
				echo "this.engine = new Engine({ ";
				echo $this->toJavaScriptObject($this->engine);
				echo " });\n";
			}

			if (isset($this->os)) {
				echo "this.os = new Os({ ";
				echo $this->toJavaScriptObject($this->os);
				echo " });\n";
			}

			if (isset($this->device)) {
				echo "this.device = new Device({ ";
				echo $this->toJavaScriptObject($this->device);
				echo " });\n";
			}

			echo "this.camouflage = " . ($this->camouflage ? 'true' : 'false') . ";\n";
			echo "this.features = " . json_encode($this->features) . ";\n";
		}

		function toJavaScriptObject($object) {
			$lines = array();

			foreach ((array)$object as $key => $value) {
				if (!is_null($value)) {
					$line = $key . ": ";

					if ($key == 'version') {
						$line .= 'new Version({ ' . $this->toJavaScriptObject($value) . ' })';
					} else {
						switch(gettype($value)) {
							case 'boolean':		$line .= $value ? 'true' : 'false'; break;
							case 'string':		$line .= '"' . addslashes($value) . '"'; break;
							case 'integer':		$line .= $value; break;
						}
					}

					$lines[] = $line;
				}
			}

			return implode($lines, ", ");
		}

		function toArray() {
			$result = array();

			if (isset($this->browser)) {
				$result['browser'] = array();
				if (isset($this->browser->name) && $this->browser->name) $result['browser']['name'] = $this->browser->name;
				if (isset($this->browser->version) && $this->browser->version) $result['browser']['version'] = $this->browser->version->toArray();
			}

			if (isset($this->engine)) {
				$result['engine'] = array();
				if (isset($this->engine->name) && $this->engine->name) $result['engine']['name'] = $this->engine->name;
				if (isset($this->engine->version) && $this->engine->version) $result['engine']['version'] = $this->engine->version->toArray();
			}

			if (isset($this->os)) {
				$result['os'] = array();
				if (isset($this->os->name) && $this->os->name) $result['os']['name'] = $this->os->name;
				if (isset($this->os->family) && $this->os->family) $result['os']['family'] = $this->os->family;
				if (isset($this->os->version) && $this->os->version) $result['os']['version'] = $this->os->version->toArray();
			}

			if (isset($this->device)) {
				$result['device'] = array();
				if (isset($this->device->type) && $this->device->type) $result['device']['type'] = $this->device->type;
				if (isset($this->device->manufacturer) && $this->device->manufacturer) $result['device']['manufacturer'] = $this->device->manufacturer;
				if (isset($this->device->model) && $this->device->model) $result['device']['model'] = $this->device->model;
				if (isset($this->device->series) && $this->device->series) $result['device']['series'] = $this->device->series;
			}

			if (!count($result['browser'])) unset($result['browser']);
			if (!count($result['engine'])) unset($result['engine']);
			if (!count($result['os'])) unset($result['os']);
			if (!count($result['device'])) unset($result['device']);

			return $result;
		}
	}

	class BrowserIds {
		static $ANDROID_BROWSERS = array();

		static function identify($type, $model) {
			require_once(_BASEPATH_ . '../data/id-' . $type . '.php');

			switch($type) {
				case 'android':		return BrowserIds::identifyList(BrowserIds::$ANDROID_BROWSERS, $model);
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

	class BuildIds {
		static $ANDROID_BUILDS = array();

		static function identify($type, $id) {
			require_once(_BASEPATH_ . '../data/build-' . $type . '.php');

			switch($type) {
				case 'android':		return BuildIds::identifyList(BuildIds::$ANDROID_BUILDS, $id);
			}

			return false;
		}

		static function identifyList($list, $id) {
			if (isset($list[$id])) {
				if (is_array($list[$id]))
					return new Version($list[$id]);
				else
					return new Version(array('value' => $list[$id]));
			}

			return false;
		}
	}

	class Manufacturers {
		static $TELEVISION = array();

		static function identify($type, $name) {
			$name = preg_replace('/^CUS\:/u', '', trim($name));

			require_once(_BASEPATH_ . '../data/manufacturers.php');

			if (isset(Manufacturers::$TELEVISION[$name])) return Manufacturers::$TELEVISION[$name];
			return $name;
		}
	}

	class DeviceModels {
		static $ANDROID_MODELS = array();
		static $ASHA_MODELS = array();
		static $BADA_MODELS = array();
		static $BREW_MODELS = array();
		static $FIREFOXOS_MODELS = array();
		static $TIZEN_MODELS = array();
		static $TOUCHWIZ_MODELS = array();
		static $WINDOWS_MOBILE_MODELS = array();
		static $WINDOWS_PHONE_MODELS = array();
		static $PALMOS_MODELS = array();
		static $S30_MODELS = array();
		static $S40_MODELS = array();
		static $S60_MODELS = array();
		static $FEATURE_MODELS = array();
		static $BLACKBERRY_MODELS = array();
		static $IOS_MODELS = array();


		static function identify($type, $model) {
			require_once(_BASEPATH_ . '../data/models-' . $type . '.php');

			switch($type) {
				case 'android':		return DeviceModels::identifyAndroid($model);
				case 'asha': 		return DeviceModels::identifyList(DeviceModels::$ASHA_MODELS, $model);
				case 'bada': 		return DeviceModels::identifyList(DeviceModels::$BADA_MODELS, $model);
				case 'blackberry':	return DeviceModels::identifyBlackBerry($model);
				case 'brew': 		return DeviceModels::identifyList(DeviceModels::$BREW_MODELS, $model);
				case 'firefoxos': 	return DeviceModels::identifyList(DeviceModels::$FIREFOXOS_MODELS, $model, false);
				case 'ios':			return DeviceModels::identifyIOS($model);
				case 'tizen': 		return DeviceModels::identifyList(DeviceModels::$TIZEN_MODELS, $model);
				case 'touchwiz': 	return DeviceModels::identifyList(DeviceModels::$TOUCHWIZ_MODELS, $model);
				case 'wm': 			return DeviceModels::identifyList(DeviceModels::$WINDOWS_MOBILE_MODELS, $model);
				case 'wp': 			return DeviceModels::identifyList(DeviceModels::$WINDOWS_PHONE_MODELS, $model);
				case 's30': 		return DeviceModels::identifyList(DeviceModels::$S30_MODELS, $model);
				case 's40': 		return DeviceModels::identifyList(DeviceModels::$S40_MODELS, $model);
				case 's60': 		return DeviceModels::identifyList(DeviceModels::$S60_MODELS, $model);
				case 'palmos': 		return DeviceModels::identifyList(DeviceModels::$PALMOS_MODELS, $model);
				case 'feature': 	return DeviceModels::identifyList(DeviceModels::$FEATURE_MODELS, $model);
			}

			return (object) array('type' => '', 'model' => $model, 'identified' => ID_NONE);
		}

		static function identifyIOS($model) {
			$model = str_replace('Unknown ', '', $model);
			$model = preg_replace("/iPh([0-9],[0-9])/", 'iPhone\\1', $model);
			$model = preg_replace("/iPd([0-9],[0-9])/", 'iPod\\1', $model);

			return DeviceModels::identifyList(DeviceModels::$IOS_MODELS, $model);
		}

		static function identifyAndroid($model) {
			$result = DeviceModels::identifyList(DeviceModels::$ANDROID_MODELS, $model);

			if (!$result->identified) {
				$model = DeviceModels::cleanup($model);
				if (preg_match('/AndroVM/iu', $model)  || $model == 'Emulator' || $model == 'x86 Emulator' || $model == 'x86 VirtualBox' || $model == 'vm') {
					return (object) array(
						'type'			=> TYPE_EMULATOR,
						'identified'	=> ID_PATTERN,
						'manufacturer'	=> null,
						'model'			=> null,
						'generic'		=> false
					);
				}
			}

			return $result;
		}

		static function identifyBlackBerry($model) {
			$device = (object) array(
				'type'			=> TYPE_MOBILE,
				'identified'	=> ID_PATTERN,
				'manufacturer'	=> 'RIM',
				'model'			=> 'BlackBerry ' . $model,
				'generic'		=> false
			);

			if (isset(DeviceModels::$BLACKBERRY_MODELS[$model])) {
				$device->model = 'BlackBerry ' . DeviceModels::$BLACKBERRY_MODELS[$model] . ' ' . $model;
				$device->identified |= ID_MATCH_UA;
			}

			return $device;
		}

		static function identifyList($list, $model, $cleanup = true) {
			$original = $model;

			if ($cleanup) $model = DeviceModels::cleanup($model);

			$device = (object) array(
				'type'			=> TYPE_MOBILE,
				'identified'	=> ID_NONE,
				'manufacturer'	=> null,
				'model'			=> $model,
				'identifier'	=> $original,
				'generic'		=> false
			);

			foreach ($list as $m => $v) {
				$match = false;
				if (substr($m, -1) == "!")
					$match = preg_match('/^' . substr($m, 0, -1) . '/iu', $model);
				else
					$match = strtolower($m) == strtolower($model);

				if ($match) {
 					$device->manufacturer = $v[0];
					$device->model = $v[1];
					if (isset($v[2])) $device->type = $v[2];
					if (isset($v[3])) $device->flag = $v[3];
					$device->identified = ID_MATCH_UA;

					if ($device->manufacturer == null && $device->model == null) {
						$device->identified = ID_PATTERN;
					}

					return $device;
				}
			}

			return $device;
		}

		static function cleanup($s = '') {
			$s = preg_replace('/\/[^\/]+$/u', '', $s);
			$s = preg_replace('/\/[^\/]+ Android\/.*/u', '', $s);

			$s = preg_replace('/UCBrowser$/u', '', $s);

			$s = preg_replace('/_TD$/u', '', $s);
			$s = preg_replace('/_LTE$/u', '', $s);
			$s = preg_replace('/_CMCC$/u', '', $s);
			$s = preg_replace('/_CUCC$/u', '', $s);
			$s = preg_replace('/-BREW.+$/u', '', $s);
			$s = preg_replace('/ MIDP.+$/u', '', $s);

			$s = preg_replace('/_/u', ' ', $s);
			$s = preg_replace('/^\s+|\s+$/u', '', $s);

			$s = preg_replace('/^tita on /u', '', $s);
			$s = preg_replace('/^De-Sensed /u', '', $s);
			$s = preg_replace('/^ICS AOSP on /u', '', $s);
			$s = preg_replace('/^Baidu Yi on /u', '', $s);
			$s = preg_replace('/^Buildroid for /u', '', $s);
			$s = preg_replace('/^Gingerbread on /u', '', $s);
			$s = preg_replace('/^Android (on |for )/u', '', $s);
			$s = preg_replace('/^Generic Android on /u', '', $s);
			$s = preg_replace('/^Full JellyBean( on )?/u', '', $s);
			$s = preg_replace('/^Full (AOSP on |Android on |Base for |Cappuccino on |MIPS Android on |Webdroid on |JellyBean on |Android)/u', '', $s);
			$s = preg_replace('/^AOSPA? on /u', '', $s);

			$s = preg_replace('/^Acer( |-)?/iu', '', $s);
			$s = preg_replace('/^Iconia( Tab)? /u', '', $s);
			$s = preg_replace('/^ASUS ?/u', '', $s);
			$s = preg_replace('/^Ainol /u', '', $s);
			$s = preg_replace('/^Coolpad ?/iu', 'Coolpad ', $s);
			$s = preg_replace('/^Alcatel[_ ]OT[_-](.*)/iu', 'One Touch $1', $s);
			$s = preg_replace('/^ALCATEL /u', '', $s);
			$s = preg_replace('/^YL-/u', '', $s);
			$s = preg_replace('/^TY-K[_\- ]Touch/iu', 'K-Touch', $s);
			$s = preg_replace('/^K-Touch[_\-]/u', 'K-Touch ', $s);
			$s = preg_replace('/^Novo7 ?/iu', 'Novo7 ', $s);
			$s = preg_replace('/^HW-HUAWEI/u', 'HUAWEI', $s);
			$s = preg_replace('/^Huawei[ -]/iu', 'Huawei ', $s);
			$s = preg_replace('/^SAMSUNG SAMSUNG-/iu', '', $s);
			$s = preg_replace('/^SAMSUNG[ -]/iu', '', $s);
			$s = preg_replace('/^(Sony ?Ericsson|Sony)/u', '', $s);
			$s = preg_replace('/^(Lenovo Lenovo|LNV-Lenovo|LENOVO-Lenovo)/u', 'Lenovo', $s);
			$s = preg_replace('/^Lenovo-/u', 'Lenovo', $s);
			$s = preg_replace('/^ZTE-/u', 'ZTE ', $s);
			$s = preg_replace('/^(LG)[ _\/]/u', '$1-', $s);
			$s = preg_replace('/^(HTC.+)\s[v|V][0-9.]+$/u', '$1', $s);
			$s = preg_replace('/^(HTC)[-\/]/u', '$1', $s);
			$s = preg_replace('/^(HTC)([A-Z][0-9][0-9][0-9])/u', '$1 $2', $s);
			$s = preg_replace('/^(Motorola[\s|-])/u', '', $s);
			$s = preg_replace('/^(MOT-)/u', '', $s);
			$s = preg_replace('/^Moto([^\s])/u', '$1', $s);

			$s = preg_replace('/-?(orange(-ls)?|vodafone|bouygues|parrot|Kust|ls)$/iu', '', $s);
			$s = preg_replace('/http:\/\/.+$/iu', '', $s);
			$s = preg_replace('/^\s+|\s+$/u', '', $s);

			return $s;
		}
	}

	class DeviceProfiles {
		static $PROFILES = array();

		static function identify($url) {
			require_once(_BASEPATH_ . '../data/profiles.php');

			if (isset(DeviceProfiles::$PROFILES[$url])) {
				return DeviceProfiles::$PROFILES[$url];
			}

			return false;
		}
	}


	class Version {
		var $value = null;

		function __construct($options = null) {
			if (is_array($options)) {
				if (isset($options['value'])) $this->value = $options['value'];
				if (isset($options['alias'])) $this->alias = $options['alias'];
				if (isset($options['nickname'])) $this->nickname = $options['nickname'];
				if (isset($options['details'])) $this->details = $options['details'];
				if (isset($options['hidden'])) $this->hidden = $options['hidden'];
			}
		}

		function is() {
			$valid = false;

			$arguments = func_get_args();
			if (count($arguments)) {
				$operator = '=';
				$compare = null;

				if (count($arguments) == 1) {
					$compare = $arguments[0];
				}
				
				if (count($arguments) >= 2) {
					$operator = $arguments[0];
					$compare = $arguments[1];
				}				

				if (!is_null($compare)) {
					$min = min(substr_count($this->value, '.'), substr_count($compare, '.')) + 1;

					$v1 = $this->toValue($this->value, $min);
					$v2 = $this->toValue($compare, $min);

					switch ($operator) {
						case '<':	$valid = $v1 < $v2; break;
						case '<=':	$valid = $v1 <= $v2; break;
						case '=':	$valid = $v1 == $v2; break;
						case '>':	$valid = $v1 > $v2; break;
						case '>=':	$valid = $v1 >= $v2; break;
					}
				}
			}

			return $valid;
		}

		function toValue($value = null, $count = null) {
			if (is_null($value)) $value = $this->value;
			$parts = explode('.', $value);
			if (!is_null($count)) $parts = array_slice($parts, 0, $count);

			$result = $parts[0];

			if (count($parts) > 1) {
				$result .= '.';

				for ($p = 1; $p < count($parts); $p++) {
					$result .= substr('0000' . $parts[$p], -4);
				}
			}

			return floatval($result);
		}

		function toFloat() {
			return floatval($this->value);
		}

		function toNumber() {
			return intval($this->value);
		}

		function toArray() {
			$result = array();

			if (isset($this->value)) {
				if (isset($this->details)) {
					$parts = explode('.', $this->value);
					$result['value'] = join('.', array_slice($parts, 0, $this->details));
				} else {
					$result['value'] = $this->value;
				}
			}

			if (isset($this->alias)) {
				$result['alias'] = $this->alias;
				return $result;
			}

			else {
				if (isset($result['value'])) {
					return $result['value'];
				}
			}

			return $result;
		}
	}
