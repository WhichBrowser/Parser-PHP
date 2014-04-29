<?php

	/*
		Copyright (c) 2010-2013 Niels Leenheer
		 
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
			$this->device = (object) array('type' => '', 'identified' => ID_NONE);
		
			$this->camouflage = false;
			$this->features = array();
		
			$this->analyseUserAgent($this->hasHeader('User-Agent') ? $this->getHeader('User-Agent') : '');
			
			if ($this->hasHeader('X-Original-User-Agent')) $this->analyseAlternativeUserAgent($this->getHeader('X-Original-User-Agent'));
			if ($this->hasHeader('X-Device-User-Agent')) $this->analyseAlternativeUserAgent($this->getHeader('X-Device-User-Agent'));
			if ($this->hasHeader('Device-Stock-UA')) $this->analyseAlternativeUserAgent($this->getHeader('Device-Stock-UA'));
			if ($this->hasHeader('X-OperaMini-Phone-UA')) $this->analyseAlternativeUserAgent($this->getHeader('X-OperaMini-Phone-UA'));
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
			return isset($this->headers[$h]) || isset($this->headers[strtolower($h)]) || isset($this->headers[strtoupper($h)]);
		}
		
		function getHeader($h) {
			if (isset($this->headers[$h])) return $this->headers[$h];
			if (isset($this->headers[strtolower($h)])) return $this->headers[strtolower($h)];
			if (isset($this->headers[strtoupper($h)])) return $this->headers[strtoupper($h)];
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


				if (preg_match('/Mac OS X 10_6_3; ([^;]+); [a-z]{2}-(?:[a-z]{2})?\)/', $this->options->useragent, $match)) {
					$this->browser->name = '';
					$this->browser->version = null;
					$this->browser->mode = 'desktop';
					
					$this->os->name = 'Android';
					$this->os->version = null;
				
					$this->engine->name = 'Webkit';
					$this->engine->version = null;
	
					$this->features[] = 'foundDevice';
				}

				if (preg_match('/Linux Ventana; [a-z]{2}-[a-z]{2}; (.+) Build/', $this->options->useragent, $match)) {
					$this->browser->name = '';
					$this->browser->version = null;
					$this->browser->mode = 'desktop';
					
					$this->os->name = 'Android';
					$this->os->version = null;
				
					$this->engine->name = 'Webkit';
					$this->engine->version = null;
	
					$this->features[] = 'foundDevice';
				}

				if ($this->browser->name == 'Safari') {
					preg_match('/AppleWebKit\/([0-9]+.[0-9]+)/i', $this->options->useragent, $webkitMatch);
					preg_match('/Safari\/([0-9]+.[0-9]+)/i', $this->options->useragent, $safariMatch);
					
					if ($this->os->name != 'iOS' && $webkitMatch[1] != $safariMatch[1]) {
						$this->features[] = 'safariMismatch';
						$this->camouflage = true;			
					}
	
					if ($this->os->name == 'iOS' && !preg_match('/^Mozilla/', $this->options->useragent)) {
						$this->features[] = 'noMozillaPrefix';
						$this->camouflage = true;			
					}

					if (!preg_match('/Version\/[0-9\.]+/', $this->options->useragent)) {
						$this->features[] = 'noVersion';
						$this->camouflage = true;			
					}
				}
				
				if ($this->browser->name == 'Chrome') {
					if (!preg_match('/(?:Chrome|CrMo|CriOS)\/([0-9]{1,2}\.[0-9]\.[0-9]{3,4}\.[0-9]+)/', $this->options->useragent)) {
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
					}

					if ($this->options->engine & ENGINE_CHROMIUM) {
						$this->features[] = 'chrome';		

						if ($this->engine->name && ($this->engine->name != 'Blink' && $this->engine->name != 'Webkit')) {
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
					if ($this->device->model == 'iPhone' || $this->device->model == 'iPod') {
						if (($this->options->width != 0 && $this->options->height != 0) && ($this->options->width != 320 && $this->options->height != 480) && ($this->options->width != 480 && $this->options->height != 320)) {
							$this->features[] = 'sizeMismatch';		
							$this->camouflage = true;	
						}				
					}
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
				if (!isset($this->browser->name) || $this->browser->name != $browser) {
					$this->browser->name = $browser;

					if (substr($this->browser->name, 0, strlen($browser)) != $browser) {
						$this->browser->version = null;
						$this->browser->stock = false;
					}
				}
			}

			if ($this->os->name != 'Android' && $this->os->name != 'Aliyun OS') {
				$this->os->name = 'Android';
				$this->os->version = null;
				
				$this->device->manufacturer = null;
				$this->device->model = null;
				$this->device->identified = ID_NONE;
				
				if ($this->device->type != TYPE_MOBILE && $this->device->type != TYPE_TABLET) {
					$this->device->type = TYPE_MOBILE;
				}
			}
			
			if ($this->engine->name != 'Webkit') {
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
			if ($this->browser->name != 'Baidu Browser') {
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
			if ($this->browser->name != 'UC Browser') {
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
			if (preg_match('/pr\(UCBrowser\/([0-9\.]+)/', $ua, $match)) {
				$this->browser->name = 'UC Browser';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));
				$this->browser->stock = false;
			}		

			/* Find os */
			if (preg_match('/pf\(Linux\)/', $ua) && preg_match('/ov\(Android ([0-9\.]+)/', $ua, $match)) {
				$this->os->name = 'Android';
				$this->os->version = new Version(array('value' => $match[1]));
			}		
			
			if (preg_match('/pf\(Symbian\)/', $ua) && preg_match('/ov\(S60V5/', $ua)) {
				if (!isset($this->os->name) || $this->os->name != 'Series60') {
					$this->os->name = 'Series60';
					$this->os->version = new Version(array('value' => 5));
				}
			}

			if (preg_match('/pf\(Windows\)/', $ua) && preg_match('/ov\(wds ([0-9\.]+)/', $ua, $match)) {
				if (!isset($this->os->name) || $this->os->name != 'Windows Phone') {
					$this->os->name = 'Windows Phone';

					switch($match[1]) {
						case '7.0':		$this->os->version = new Version(array('value' => '7.0')); break;
						case '7.1':		$this->os->version = new Version(array('value' => '7.5')); break;
						case '8.0':		$this->os->version = new Version(array('value' => '8.0')); break;
					}
				}
			}		

			if (preg_match('/pf\((?:42|44)\)/', $ua) && preg_match('/ov\((?:iPh OS )?(?:iOS )?([0-9\_]+)/', $ua, $match)) {
				if (!isset($this->os->name) || $this->os->name != 'iOS') {
					$this->os->name = 'iOS';
					$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
				}
			}

			/* Find engine */
			if (preg_match('/re\(AppleWebKit\/([0-9\.]+)/', $ua, $match)) {
				$this->engine->name = 'Webkit';
				$this->engine->version = new Version(array('value' => $match[1]));
			}		

			/* Find device */
			if (isset($this->os->name) && $this->os->name == 'Android') {
				if (preg_match('/dv\((.*)\s+Build/', $ua, $match)) {
					$device = DeviceModels::identify('android', $match[1]);
					
					if ($device) {
						$this->device = $device;
					}
				}		
			}

			if (isset($this->os->name) && $this->os->name == 'Series60') {
				if (preg_match('/dv\((?:Nokia)?([^\)]*)\)/', $ua, $match)) {
					$device = DeviceModels::identify('s60', $match[1]);
					
					if ($device) {
						$this->device = $device;
					}
				}		
			}

			if (isset($this->os->name) && $this->os->name == 'Windows Phone') {
				if (preg_match('/dv\(([^\)]*)\)/', $ua, $match)) {
					$device = DeviceModels::identify('wp', substr(strstr($match[1], ' '), 1));
					
					if ($device) {
						$this->device = $device;
					}
				}		
			}

			if (isset($this->os->name) && $this->os->name == 'iOS') {
				if (preg_match('/dv\(([^\)]*)\)/', $ua, $match)) {
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
		
		function analyseUserAgent($ua) {
			
			/****************************************************
			 *		Unix
			 */
		
			if (preg_match('/Unix/', $ua)) {
				$this->os->name = 'Unix';
			}
			
			/****************************************************
			 *		FreeBSD
			 */
		
			if (preg_match('/FreeBSD/', $ua)) {
				$this->os->name = 'FreeBSD';
			}
			
			/****************************************************
			 *		OpenBSD
			 */
		
			if (preg_match('/OpenBSD/', $ua)) {
				$this->os->name = 'OpenBSD';
			}
			
			/****************************************************
			 *		NetBSD
			 */
		
			if (preg_match('/NetBSD/', $ua)) {
				$this->os->name = 'NetBSD';
			}
			
			
			/****************************************************
			 *		Solaris
			 */
		
			if (preg_match('/SunOS/', $ua)) {
				$this->os->name = 'Solaris';
			}
			
			
			/****************************************************
			 *		IRIX
			 */
		
			if (preg_match('/IRIX/', $ua)) {
				$this->os->name = 'IRIX';

				if (preg_match('/IRIX ([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/IRIX;(?:64|32) ([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}
			}
			
			
			/****************************************************
			 *		Syllable
			 */
		
			if (preg_match('/Syllable/', $ua)) {
				$this->os->name = 'Syllable';
			}
			
			
			/****************************************************
			 *		Linux
			 */
		
			if (preg_match('/Linux/', $ua)) {
				$this->os->name = 'Linux';

				if (preg_match('/CentOS/', $ua)) {
					$this->os->name = 'CentOS';
					if (preg_match('/CentOS\/[0-9\.\-]+el([0-9_]+)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Debian/', $ua)) {
					$this->os->name = 'Debian';
					$this->device->type = TYPE_DESKTOP;
				}
				
				if (preg_match('/Fedora/', $ua)) {
					$this->os->name = 'Fedora';
					if (preg_match('/Fedora\/[0-9\.\-]+fc([0-9]+)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Gentoo/', $ua)) {
					$this->os->name = 'Gentoo';
					$this->device->type = TYPE_DESKTOP;
				}
				
				if (preg_match('/gNewSense/', $ua)) {
					$this->os->name = 'gNewSense';
					if (preg_match('/gNewSense\/[^\(]+\(([0-9\.]+)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1]));
					}

					$this->device->type = TYPE_DESKTOP;
				}
				
				if (preg_match('/Kubuntu/', $ua)) {
					$this->os->name = 'Kubuntu';
					$this->device->type = TYPE_DESKTOP;
				}
				
				if (preg_match('/Mandriva Linux/', $ua)) {
					$this->os->name = 'Mandriva';
					if (preg_match('/Mandriva Linux\/[0-9\.\-]+mdv([0-9]+)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1]));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Mageia/', $ua)) {
					$this->os->name = 'Mageia';
					if (preg_match('/Mageia\/[0-9\.\-]+mga([0-9]+)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1]));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Mandriva/', $ua)) {
					$this->os->name = 'Mandriva';
					if (preg_match('/Mandriva\/[0-9\.\-]+mdv([0-9]+)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1]));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Red Hat/', $ua)) {
					$this->os->name = 'Red Hat';
					if (preg_match('/Red Hat[^\/]*\/[0-9\.\-]+el([0-9_]+)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Slackware/', $ua)) {
					$this->os->name = 'Slackware';
					$this->device->type = TYPE_DESKTOP;
				}
				
				if (preg_match('/SUSE/', $ua)) {
					$this->os->name = 'SUSE';
					$this->device->type = TYPE_DESKTOP;
				}
				
				if (preg_match('/Turbolinux/', $ua)) {
					$this->os->name = 'Turbolinux';
					$this->device->type = TYPE_DESKTOP;
				}
				
				if (preg_match('/Ubuntu/', $ua)) {
					$this->os->name = 'Ubuntu';
					if (preg_match('/Ubuntu\/([0-9.]*)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1]));
					}

					$this->device->type = TYPE_DESKTOP;
				}
			}
			
			else if (preg_match('/\(Ubuntu; (Mobile|Tablet)/', $ua)) {
				$this->os->name = 'Ubuntu Touch';

				if (preg_match('/\(Ubuntu; Mobile/', $ua)) $this->device->type = TYPE_MOBILE;
				if (preg_match('/\(Ubuntu; Tablet/', $ua)) $this->device->type = TYPE_TABLET;
			}



			
			/****************************************************
			 *		iOS
			 */
		
			if (preg_match('/iPhone/', $ua) || preg_match('/iPad/', $ua) || preg_match('/iPod/', $ua)) {
				$this->os->name = 'iOS';
				$this->os->version = new Version(array('value' => '1.0'));

				if (preg_match('/OS (.*) like Mac OS X/', $ua, $match)) {
					$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
				}

				if (preg_match('/iPhone Simulator;/', $ua)) {
					$this->device->type = TYPE_EMULATOR;
				} 
				
				else {
					if (preg_match('/(iPad|iPhone( 3GS| 3G| 4S| 4| 5)?|iPod( touch)?)/', $ua, $match)) {
						$device = DeviceModels::identify('ios', $match[0]);
						
						if ($device) {
							$this->device = $device;
						}
					}

					if (preg_match('/(iPad|iPhone|iPod)[0-9],[0-9]/', $ua, $match)) {
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
		
			else if (preg_match('/Mac OS X/', $ua)) {
				$this->os->name = 'Mac OS X';

				if (preg_match('/Mac OS X (10[0-9\._]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
				}

				$this->device->type = TYPE_DESKTOP;
			}


			/****************************************************
			 *		Windows
			 */
			 
			if (preg_match('/Windows/', $ua)) {
				$this->os->name = 'Windows';
				$this->device->type = TYPE_DESKTOP;

				if (preg_match('/Windows NT ([0-9]\.[0-9])/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
					
					switch($match[1]) {
						case '6.3':		if (preg_match('/; ARM;/', $ua))
											$this->os->version = new Version(array('value' => $match[1], 'alias' => 'RT 8.1')); 
										else
											$this->os->version = new Version(array('value' => $match[1], 'alias' => '8.1')); 
										break;
										
						case '6.2':		if (preg_match('/; ARM;/', $ua))
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
				
				if (preg_match('/Windows 95/', $ua) || preg_match('/Win95/', $ua) || preg_match('/Win 9x 4.00/', $ua)) {
					$this->os->version = new Version(array('value' => '4.0', 'alias' => '95')); 
				}

				if (preg_match('/Windows 98/', $ua) || preg_match('/Win98/', $ua) || preg_match('/Win 9x 4.10/', $ua)) {
					$this->os->version = new Version(array('value' => '4.1', 'alias' => '98')); 
				}

				if (preg_match('/Windows ME/', $ua) || preg_match('/WinME/', $ua) || preg_match('/Win 9x 4.90/', $ua)) {
					$this->os->version = new Version(array('value' => '4.9', 'alias' => 'ME')); 
				}

				if (preg_match('/Windows XP/', $ua) || preg_match('/WinXP/', $ua)) {
					$this->os->version = new Version(array('value' => '5.1', 'alias' => 'XP')); 
				}

				if (preg_match('/WPDesktop/', $ua)) {
					$this->os->name = 'Windows Phone';
					$this->os->version = new Version(array('value' => '8', 'details' => 1)); 
					$this->device->type = TYPE_MOBILE;
				}
				
				if (preg_match('/WP7/', $ua)) {
					$this->os->name = 'Windows Phone';
					$this->os->version = new Version(array('value' => '7', 'details' => 1)); 
					$this->device->type = TYPE_MOBILE;
					$this->browser->mode = 'desktop';
				}

				if (preg_match('/Windows CE/', $ua) || preg_match('/WinCE/', $ua) || preg_match('/WindowsCE/', $ua)) {
					if (preg_match('/ IEMobile/', $ua)) {
						$this->os->name = 'Windows Mobile';

						if (preg_match('/ IEMobile 8/', $ua)) {
							$this->os->version = new Version(array('value' => '6.5', 'details' => 2)); 
						}
	
						if (preg_match('/ IEMobile 7/', $ua)) {
							$this->os->version = new Version(array('value' => '6.1', 'details' => 2)); 
						}
	
						if (preg_match('/ IEMobile 6/', $ua)) {
							$this->os->version = new Version(array('value' => '6.0', 'details' => 2)); 
						}
					}
					else {
						$this->os->name = 'Windows CE';
						
						if (preg_match('/WindowsCEOS\/([0-9.]*)/', $ua, $match)) {
							$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
						}
	
						if (preg_match('/Windows CE ([0-9.]*)/', $ua, $match)) {
							$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
						}
					}
										
					$this->device->type = TYPE_MOBILE;
				}

				if (preg_match('/Windows ?Mobile/', $ua)) {
					$this->os->name = 'Windows Mobile';
					$this->device->type = TYPE_MOBILE;
				}

				if (preg_match('/WindowsMobile\/([0-9.]*)/', $ua, $match)) {
					$this->os->name = 'Windows Mobile';
					$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
					$this->device->type = TYPE_MOBILE;
				}

				if (preg_match('/Windows Phone/', $ua)) {
					$this->os->name = 'Windows Phone';
					$this->device->type = TYPE_MOBILE;
					
					if (preg_match('/Windows Phone (?:OS )?([0-9.]*)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1], 'details' => 2));

						if (intval($match[1]) < 7) {
							$this->os->name = 'Windows Mobile';
						}						
					}
					
					if (preg_match('/IEMobile\/[^;]+;(?: ARM; Touch; )?\s*([^;\s][^;]*);\s*([^;\)\s][^;\)]*)[;|\)]/', $ua, $match)) {
						$this->device->manufacturer = $match[1];
						$this->device->model = $match[2];
						$this->device->identified |= ID_PATTERN;

						$device = DeviceModels::identify('wp', $match[2]);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}						

					if (preg_match('/WPDesktop; \s*([^;\s][^;]*);\s*([^;\)\s][^;\)]*)[;|\)]/', $ua, $match)) {
						$this->device->manufacturer = $match[1];
						$this->device->model = $match[2];
						$this->device->identified |= ID_PATTERN;

						$device = DeviceModels::identify('wp', $match[2]);
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
		
			if (preg_match('/Android/', $ua)) {
				$this->os->name = 'Android';
				$this->os->version = new Version(); 

				if (preg_match('/Android(?: )?(?:AllPhone_|CyanogenMod_|OUYA )?(?:\/)?v?([0-9.]+)/', str_replace('-update', ',', $ua), $match)) {
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}
				
				if (preg_match('/Android [0-9][0-9].[0-9][0-9].[0-9][0-9]\(([^)]+)\);/', str_replace('-update', ',', $ua), $match)) {
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}
				
				if (preg_match('/Android Eclair/', $ua)) {
					$this->os->version = new Version(array('value' => '2.0', 'details' => 3));
				}
				
				if (preg_match('/Android KeyLimePie/', $ua)) {
					$this->os->version = new Version(array('value' => '4.4', 'details' => 3));
				}
				
				$this->device->type = TYPE_MOBILE;
				if ($this->os->version->toFloat() >= 3) $this->device->type = TYPE_TABLET;
				if ($this->os->version->toFloat() >= 4 && preg_match('/Mobile/', $ua)) $this->device->type = TYPE_MOBILE;


				if (preg_match('/Eclair; (?:[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?) Build\/([^\/]*)\//', $ua, $match)) {
					$this->device->model = $match[1];
				}
				
				else if (preg_match('/; ?([^;]*[^;\s])\s+Build/', $ua, $match)) {
					$this->device->model = $match[1];
				}		
				
				else if (preg_match('/[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?; ([^;]*[^;\s]);\s+Build/', $ua, $match)) {
					$this->device->model = $match[1];
				}		
				
				else if (preg_match('/\(([^;]+);U;Android\/[^;]+;[0-9]+\*[0-9]+;CTC\/2.0\)/', $ua, $match)) {
					$this->device->model = $match[1];
				}		
				
				else if (preg_match('/;\s?([^;]+);\s?[0-9]+\*[0-9]+;\s?CTC\/2.0/', $ua, $match)) {
					$this->device->model = $match[1];
				}		
				
				else if (preg_match('/Android [^;]+; (?:[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?; )?([^)]+)\)/', $ua, $match)) {
					if (!preg_match('/[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?/', $ua)) {
						$this->device->model = $match[1];
					}
				}	
				
				/* Sometimes we get a model name that starts with Android, in that case it is a mismatch and we should ignore it */
				if (isset($this->device->model) && substr($this->device->model, 0, 7) == 'Android') {
					$this->device->model = null;
				}
				
				if (isset($this->device->model) && $this->device->model) {
					$this->device->identified |= ID_PATTERN;
					
					$device = DeviceModels::identify('android', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;						
					}
				}
				
				if (preg_match('/HP eStation/', $ua)) 	{ $this->device->manufacturer = 'HP'; $this->device->model = 'eStation'; $this->device->type = TYPE_TABLET; $this->device->identified |= ID_MATCH_UA; }
				if (preg_match('/Pre\/1.0/', $ua)) 		{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pre'; $this->device->identified |= ID_MATCH_UA; }
				if (preg_match('/Pre\/1.1/', $ua)) 		{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pre Plus'; $this->device->identified |= ID_MATCH_UA; }
				if (preg_match('/Pre\/1.2/', $ua)) 		{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pre 2'; $this->device->identified |= ID_MATCH_UA; }
				if (preg_match('/Pre\/3.0/', $ua)) 		{ $this->device->manufacturer = 'HP'; $this->device->model = 'Pre 3'; $this->device->identified |= ID_MATCH_UA; }
				if (preg_match('/Pixi\/1.0/', $ua)) 	{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pixi'; $this->device->identified |= ID_MATCH_UA; }
				if (preg_match('/Pixi\/1.1/', $ua)) 	{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pixi Plus'; $this->device->identified |= ID_MATCH_UA; }
				if (preg_match('/P160UN?A?\/1.0/', $ua)) { $this->device->manufacturer = 'HP'; $this->device->model = 'Veer'; $this->device->identified |= ID_MATCH_UA; }
			}



			/****************************************************
			 *		Aliyun OS
			 */
		
			if (preg_match('/Aliyun/', $ua) || preg_match('/YunOs/i', $ua)) {
				$this->os->name = 'Aliyun OS';
				$this->os->version = new Version(); 

				if (preg_match('/YunOs[ \/]([0-9.]+)/i', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				if (preg_match('/AliyunOS ([0-9.]+)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				$this->device->type = TYPE_MOBILE;

				if (preg_match('/; ([^;]*[^;\s])\s+Build/', $ua, $match)) {
					$this->device->model = $match[1];
				}
				
				if ($this->device->model) {
					$this->device->identified |= ID_PATTERN;
					
					$device = DeviceModels::identify('android', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;						
					}
				}
			}

			if (preg_match('/Android/', $ua)) {
				if (preg_match('/Android v(1.[0-9][0-9])_[0-9][0-9].[0-9][0-9]-/', $ua, $match)) {
					$this->os->name = 'Aliyun OS';
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				if (preg_match('/Android (1.[0-9].[0-9].[0-9]+)-R?T/', $ua, $match)) {
					$this->os->name = 'Aliyun OS';
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				if (preg_match('/Android ([12].[0-9].[0-9]+)-R-20[0-9]+/', $ua, $match)) {
					$this->os->name = 'Aliyun OS';
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				if (preg_match('/Android 20[0-9]+/', $ua, $match)) {
					$this->os->name = 'Aliyun OS';
					$this->os->version = null;
				}
			}
			
						
			
			/****************************************************
			 *		Baidu Yi
			 */
		
			if (preg_match('/Baidu Yi/', $ua)) {
				$this->os->name = 'Baidu Yi';
				$this->os->version = null;
			} 
				
				
			

			/****************************************************
			 *		Google TV
			 */
		
			if (preg_match('/GoogleTV/', $ua)) {
				$this->os->name = 'Google TV';
				
				/*
				if (preg_match('/Chrome\/5./', $ua)) {
					$this->os->version = new Version(array('value' => '1'));
				}

				if (preg_match('/Chrome\/11./', $ua)) {
					$this->os->version = new Version(array('value' => '2'));
				}
				*/

				$this->device->type = TYPE_TELEVISION;

				if (preg_match('/GoogleTV [0-9\.]+; ?([^;]*[^;\s])\s+Build/', $ua, $match)) {
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
		
			if (preg_match('/CrKey/', $ua)) {
				$this->device->manufacturer = 'Google';
				$this->device->model = 'Chromecast';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}


			/****************************************************
			 *		WoPhone
			 */
		
			if (preg_match('/WoPhone/', $ua)) {
				$this->os->name = 'WoPhone';

				if (preg_match('/WoPhone\/([0-9\.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				$this->device->type = TYPE_MOBILE;
			}
			
			/****************************************************
			 *		BlackBerry
			 */
		
			if (preg_match('/BlackBerry/', $ua) && !preg_match('/BlackBerry Runtime for Android Apps/', $ua)) {
				$this->os->name = 'BlackBerry OS';

				$this->device->model = 'BlackBerry';
				$this->device->manufacturer = 'RIM';
				$this->device->type = TYPE_MOBILE;
				$this->device->identified = ID_NONE;
				
				if (!preg_match('/Opera/', $ua)) {
					if (preg_match('/BlackBerry([0-9]*)\/([0-9.]*)/', $ua, $match)) {
						$this->device->model = $match[1];
						$this->os->version = new Version(array('value' => $match[2], 'details' => 2));
					}
					
					if (preg_match('/; BlackBerry ([0-9]*);/', $ua, $match)) {
						$this->device->model = $match[1];
					}

					if (preg_match('/; ([0-9]+)[^;\)]+\)/', $ua, $match)) {
						$this->device->model = $match[1];
					}
					
					if (preg_match('/Version\/([0-9.]*)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
					}

					if ($this->os->version->toFloat() >= 10) {
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
			
			if (preg_match('/\(BB(1[^;]+); ([^\)]+)\)/', $ua, $match)) {
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
				
				$this->device->type = preg_match('/Mobile/', $ua) ? TYPE_MOBILE : TYPE_TABLET;
				$this->device->identified |= ID_MATCH_UA;

				if (preg_match('/Version\/([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
				}
			}
				
			/****************************************************
			 *		BlackBerry PlayBook
			 */
		
			if (preg_match('/RIM Tablet OS ([0-9.]*)/', $ua, $match)) {
				$this->os->name = 'BlackBerry Tablet OS';
				$this->os->version = new Version(array('value' => $match[1], 'details' => 2));

				$this->device->manufacturer = 'RIM';
				$this->device->model = 'BlackBerry PlayBook';
				$this->device->type = TYPE_TABLET;
				$this->device->identified |= ID_MATCH_UA;
			}

			else if (preg_match('/\(PlayBook;/', $ua) && preg_match('/PlayBook Build\/([0-9.]*)/', $ua, $match)) {
				$this->os->name = 'BlackBerry Tablet OS';
				$this->os->version = new Version(array('value' => $match[1], 'details' => 2));

				$this->device->manufacturer = 'RIM';
				$this->device->model = 'BlackBerry PlayBook';
				$this->device->type = TYPE_TABLET;
				$this->device->identified |= ID_MATCH_UA;
			}			

			else if (preg_match('/PlayBook/', $ua) && !preg_match('/Android/', $ua)) {
				if (preg_match('/Version\/([0-9.]*)/', $ua, $match)) {
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
		
			if (preg_match('/(?:web|hpw)OS\/(?:HP webOS )?([0-9.]*)/', $ua, $match)) {
				$this->os->name = 'webOS';
				$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
				$this->device->type = preg_match('/Tablet/i', $ua) ? TYPE_TABLET : TYPE_MOBILE;

				if (preg_match('/Pre\/1.0/', $ua)) $this->device->model = 'Pre';
				if (preg_match('/Pre\/1.1/', $ua)) $this->device->model = 'Pre Plus';
				if (preg_match('/Pre\/1.2/', $ua)) $this->device->model = 'Pre 2';
				if (preg_match('/Pre\/3.0/', $ua)) $this->device->model = 'Pre 3';
				if (preg_match('/Pixi\/1.0/', $ua)) $this->device->model = 'Pixi';
				if (preg_match('/Pixi\/1.1/', $ua)) $this->device->model = 'Pixi Plus';
				if (preg_match('/P160UN?A?\/1.0/', $ua)) $this->device->model = 'Veer';
				if (preg_match('/TouchPad\/1.0/', $ua)) $this->device->model = 'TouchPad';
				if (isset($this->device->model)) $this->device->manufacturer = preg_match('/hpwOS/', $ua) ? 'HP' : 'Palm';
				
				if (preg_match('/Emulator\//', $ua) || preg_match('/Desktop\//', $ua)) {
					$this->device->type = TYPE_EMULATOR;
					$this->device->manufacturer = null;
					$this->device->model = null;
				}

				$this->device->identified |= ID_MATCH_UA;
			}

			if (preg_match('/elite\/fzz/', $ua, $match)) {
				$this->os->name = 'webOS';
			}

			if (preg_match('/Web[0O]S/', $ua) && preg_match('/Large Screen/', $ua)) {
				$this->os->name = 'webOS';
				$this->device->type = 'television';
			}


			/****************************************************
			 *		S80
			 */

			if (preg_match('/Series80\/([0-9.]*)/', $ua, $match)) {
				$this->os->name = 'Series80';
				$this->os->version = new Version(array('value' => $match[1]));

				if (preg_match('/Nokia([^\/;\)]+)[\/|;|\)]/', $ua, $match)) {
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
		
			if (preg_match('/Symbian/', $ua) || preg_match('/Series[ ]?60/', $ua) || preg_match('/S60;/', $ua) || preg_match('/S60V/', $ua)) {
				$this->os->name = 'Series60';
				
				if (preg_match('/SymbianOS\/9.1/', $ua) && !preg_match('/Series60/', $ua)) {
					$this->os->version = new Version(array('value' => '3.0'));
				}
							
				if (preg_match('/Series60\/([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}
							
				if (preg_match('/S60V([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/Nokia([^\/;\)]+)[\/|;|\)]/', $ua, $match)) {
					if ($match[1] != 'Browser') {
						$this->device->manufacturer = 'Nokia';
						$this->device->model = DeviceModels::cleanup($match[1]);
						$this->device->identified |= ID_PATTERN;
					}
				}

				if (preg_match('/Symbian; U; (?:Nokia)?([^;]+); [a-z][a-z]\-[a-z][a-z]/', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = DeviceModels::cleanup($match[1]);
					$this->device->identified |= ID_PATTERN;
				}

				if (preg_match('/Vertu([^\/;]+)[\/|;]/', $ua, $match)) {
					$this->device->manufacturer = 'Vertu';
					$this->device->model = DeviceModels::cleanup($match[1]);
					$this->device->identified |= ID_PATTERN;
				}

				if (preg_match('/Samsung\/([^;]*);/', $ua, $match)) {
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
		
			if (preg_match('/Series40/', $ua)) {
				$this->os->name = 'Series40';

				if (preg_match('/Nokia([^\/]+)\//', $ua, $match)) {
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
						$this->device = $device;
					}
				}
				
				$this->device->type = TYPE_MOBILE;
			}
			
			/****************************************************
			 *		MeeGo
			 */
		
			if (preg_match('/MeeGo/', $ua)) {
				$this->os->name = 'MeeGo';
				$this->device->type = TYPE_MOBILE;

				if (preg_match('/Nokia([^\)]+)\)/', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = DeviceModels::cleanup($match[1]);
					$this->device->identified |= ID_PATTERN;
				}
			}
			
			/****************************************************
			 *		Maemo
			 */
		
			if (preg_match('/Maemo/', $ua)) {
				$this->os->name = 'Maemo';
				$this->device->type = TYPE_MOBILE;

				if (preg_match('/(N[0-9]+)/', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = $match[1];
					$this->device->identified |= ID_PATTERN;
				}
			}
			
			/****************************************************
			 *		Tizen
			 */
		
			if (preg_match('/Tizen/', $ua)) {
				$this->os->name = 'Tizen';

				if (preg_match('/Tizen[\/ ]([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				$this->device->type = TYPE_MOBILE;

				if (preg_match('/\(([^;]+); ([^\/]+)\//', $ua, $match)) {
					if ($match[1] != 'Linux' && $match[1] != 'Tizen') {
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

				if (preg_match('/\s*([^;]+);\s+([^;\)]+)\)/', $ua, $match)) {
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
			}
			
			/****************************************************
			 *		Jolla Sailfish
			 */
		
			if (preg_match('/Jolla; Sailfish;/', $ua)) {
				$this->os->name = 'Sailfish';
				$this->device->type = TYPE_MOBILE;
			}
			
			/****************************************************
			 *		Bada
			 */
		
			if (preg_match('/[b|B]ada/', $ua)) {
				$this->os->name = 'Bada';

				if (preg_match('/[b|B]ada[\/ ]([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
				}

				$this->device->type = TYPE_MOBILE;

				if (preg_match('/\(([^;]+); ([^\/]+)\//', $ua, $match)) {
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
		
			if (preg_match('/BREW/i', $ua) || preg_match('/BMP( [0-9.]*)?; U/', $ua) || preg_match('/BMP\/([0-9.]*)/', $ua)) {
				$this->os->name = 'Brew';

				if (preg_match('/BREW; U; ([0-9.]*)/i', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				else if (preg_match('/BREW MP ([0-9.]*)/i', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				else if (preg_match('/;BREW[\/ ]([0-9.]*)/i', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				else if (preg_match('/BMP( [0-9.]*)?; U/i', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				else if (preg_match('/BMP\/([0-9.]*)/i', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}


				$this->device->type = TYPE_MOBILE;

				if (preg_match('/\(([^;]+);U;REX\/[^;]+;BREW\/[^;]+;(?:.*;)?[0-9]+\*[0-9]+;CTC\/2.0\)/', $ua, $match)) {
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
		
			if (preg_match('/\(MTK;/', $ua)) {
				$this->os->name = 'MTK';
				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		MAUI Runtime
			 */
		
			if (preg_match('/\(MAUI Runtime;/', $ua)) {
				$this->os->name = 'MAUI Runtime';
				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		VRE
			 */
		
			if (preg_match('/\(VRE;/', $ua)) {
				$this->os->name = 'VRE';
				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		SpreadTrum
			 */
		
			if (preg_match('/\(SpreadTrum;/', $ua)) {
				$this->os->name = 'SpreadTrum';
				$this->device->type = TYPE_MOBILE;
			}
			
			/****************************************************
			 *		ThreadX
			 */
		
			if (preg_match('/ThreadX_OS\/([0-9.]*)/i', $ua, $match)) {
				$this->os->name = 'ThreadX';
				$this->os->version = new Version(array('value' => $match[1]));
			}

			/****************************************************
			 *		COS
			 */
			 
			if (preg_match('/COS like Android/i', $ua, $match)) {
				$this->os->name = 'COS';
				$this->os->version = null;
			}

			if (preg_match('/COSBrowser\/([0-9.]*)/i', $ua, $match)) {
				$this->os->name = 'COS';
				$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
			}

			if (preg_match('/\(Chinese Operating System ([0-9.]*);/i', $ua, $match)) {
				$this->os->name = 'COS';
				$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
			}

			if (preg_match('/\(COS ([0-9.]*);/i', $ua, $match)) {
				$this->os->name = 'COS';
				$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
			}

			if (preg_match('/\(COS;/i', $ua, $match)) {
				$this->os->name = 'COS';
			}


			/****************************************************
			 *		CrOS
			 */
		
			if (preg_match('/CrOS/', $ua)) {
				$this->os->name = 'Chrome OS';
				$this->device->type = TYPE_DESKTOP;
			}
			
			/****************************************************
			 *		Joli OS
			 */
		
			if (preg_match('/Joli OS\/([0-9.]*)/i', $ua, $match)) {
				$this->os->name = 'Joli OS';
				$this->os->version = new Version(array('value' => $match[1]));
				$this->device->type = TYPE_DESKTOP;
			}
			
			/****************************************************
			 *		BeOS
			 */
		
			if (preg_match('/BeOS/', $ua)) {
				$this->os->name = 'BeOS';
				$this->device->type = TYPE_DESKTOP;
			}
			
			/****************************************************
			 *		Haiku
			 */
		
			if (preg_match('/Haiku/', $ua)) {
				$this->os->name = 'Haiku';
				$this->device->type = TYPE_DESKTOP;
			}
			
			/****************************************************
			 *		QNX
			 */
		
			if (preg_match('/QNX/', $ua)) {
				$this->os->name = 'QNX';
				$this->device->type = TYPE_MOBILE;
			}
			
			/****************************************************
			 *		OS/2 Warp
			 */
		
			if (preg_match('/OS\/2; (?:U; )?Warp ([0-9.]*)/i', $ua, $match)) {
				$this->os->name = 'OS/2 Warp';
				$this->os->version = new Version(array('value' => $match[1]));
				$this->device->type = TYPE_DESKTOP;
			}
			
			/****************************************************
			 *		Grid OS
			 */
		
			if (preg_match('/Grid OS ([0-9.]*)/i', $ua, $match)) {
				$this->os->name = 'Grid OS';
				$this->os->version = new Version(array('value' => $match[1]));
				$this->device->type = TYPE_TABLET;
			}

			/****************************************************
			 *		AmigaOS
			 */
		
			if (preg_match('/AmigaOS ([0-9.]*)/i', $ua, $match)) {
				$this->os->name = 'AmigaOS';
				$this->os->version = new Version(array('value' => $match[1]));
				$this->device->type = TYPE_DESKTOP;
			}

			/****************************************************
			 *		MorphOS
			 */
		
			if (preg_match('/MorphOS ([0-9.]*)/i', $ua, $match)) {
				$this->os->name = 'MorphOS';
				$this->os->version = new Version(array('value' => $match[1]));
				$this->device->type = TYPE_DESKTOP;
			}
			
			/****************************************************
			 *		AROS
			 */
		
			if (preg_match('/AROS/', $ua, $match)) {
				$this->os->name = 'AROS';
				$this->device->type = TYPE_DESKTOP;
			}
			
			/****************************************************
			 *		Kindle
			 */
		
			if (preg_match('/Kindle/', $ua) && !preg_match('/Fire/', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Amazon';
				$this->device->model = 'Kindle';
				$this->device->type = TYPE_EREADER;

				if (preg_match('/Kindle\/2.0/', $ua)) $this->device->model = 'Kindle 2';
				if (preg_match('/Kindle\/3.0/', $ua)) $this->device->model = 'Kindle 3 or later';

				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		NOOK
			 */
		
			if (preg_match('/nook browser/', $ua)) {
				$this->os->name = 'Android';
				
				$this->device->manufacturer = 'Barnes & Noble';
				$this->device->model = 'NOOK';
				$this->device->type = TYPE_EREADER;
				$this->device->identified |= ID_MATCH_UA;
			}
			
			/****************************************************
			 *		Bookeen
			 */
		
			if (preg_match('/bookeen\/cybook/', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Bookeen';
				$this->device->model = 'Cybook';
				$this->device->type = TYPE_EREADER;
				
				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		Kobo Reader
			 */
		
			if (preg_match('/Kobo Touch/', $ua, $match)) {
				$this->os->name = '';
				$this->os->version = null;
				
				$this->device->manufacturer = 'Kobo';
				$this->device->model = 'eReader';
				$this->device->type = TYPE_EREADER;
				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		Sony Reader
			 */
		
			if (preg_match('/EBRD([0-9]+)/', $ua, $match)) {
				$this->os->name = '';
				

				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Reader';
				$this->device->type = TYPE_EREADER;
				$this->device->identified |= ID_MATCH_UA;
				
				switch($match[1]) {
					case '1101':	$this->device->model = 'Reader PRS-T1'; break;
					case '1102':	$this->device->model = 'Reader PRS-T1'; break;
					case '1201':	$this->device->model = 'Reader PRS-T2'; break;
					case '1301':	$this->device->model = 'Reader PRS-T3'; break;
				}
			}

			/****************************************************
			 *		iRiver
			 */
		
			if (preg_match('/Iriver ;/', $ua)) {
				$this->os->name = '';
		
				$this->device->manufacturer = 'iRiver';
				$this->device->model = 'Story';
				$this->device->type = TYPE_EREADER;
				
				if (preg_match('/EB07/', $ua)) $this->device->model = 'Story HD EB07';

				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		Tesla Model S in-car browser
			 */
		
			if (preg_match('/QtCarBrowser/', $ua)) {
				$this->os->name = '';
				
				$this->device->manufacturer = 'Tesla';
				$this->device->model = 'Model S';
				$this->device->type = TYPE_CAR;
				$this->device->identified |= ID_MATCH_UA;
			}


			/****************************************************
			 *		Nintendo
			 *
			 *		Opera/9.30 (Nintendo Wii; U; ; 3642; en)
			 *		Opera/9.30 (Nintendo Wii; U; ; 2047-7; en)
			 *		Opera/9.50 (Nintendo DSi; Opera/507; U; en-US)
			 *		Mozilla/5.0 (Nintendo 3DS; U; ; en) Version/1.7455.US
			 *		Mozilla/5.0 (Nintendo 3DS; U; ; en) Version/1.7455.EU
			 *
			 *		Mozilla/5.0 (Nintendo WiiU) AppleWebKit/534.52 (KHTML, like Gecko) NX/2.1.0.8.8 Version/1.0.0.6760.JP
			 *		Mozilla/5.0 (Nintendo WiiU) AppleWebKit/534.53 (KHTML, like Gecko) NWF/1.2.0.USA
			 *		Mozilla/5.0 (Nintendo WiiU) AppleWebKit/534.53 (KHTML, like Gecko) NWF/1.2.13993.USA
			 *		Mozilla/5.0 (Nintendo WiiU) AppleWebKit/534.53 (KHTML, like Gecko) NWF/1.3.0.USA
			 *		Mozilla/5.0 (Nintendo WiiU) AppleWebKit/534.52 (KHTML, like Gecko) NX/2.1.0.10.9 NintendoBrowser/1.5.0.8047.EU
			 *		Mozilla/5.0 (Nintendo WiiU) AppleWebKit/536.28 (KHTML, like Gecko) NX/3.0.3.11.12 NintendoBrowser/2.0.0.9098.JP
			 *		Mozilla/5.0 (Nintendo WiiU) AppleWebKit/536.28 (KHTML, like Gecko) NX/3.0.3.12.6 NintendoBrowser/2.0.0.9362.EU
			 */
		
			if (preg_match('/Nintendo Wii/', $ua)) {
				$this->os->name = '';
		
				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'Wii';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
			}
			
			if (preg_match('/Nintendo Wii ?U/', $ua)) {
				$this->os->name = '';
		
				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'Wii U';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
			}

			if (preg_match('/Nintendo DSi/', $ua)) {
				$this->os->name = '';
		
				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'DSi';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
			}

			if (preg_match('/Nintendo 3DS/', $ua)) {
				$this->os->name = '';
		
				if (preg_match('/Version\/([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = '3DS';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
			}
			
			/****************************************************
			 *		Sony Playstation
			 *
			 *		Mozilla/4.0 (PSP (PlayStation Portable); 2.00)
			 *
			 *		Mozilla/5.0 (PlayStation Vita 1.00) AppleWebKit/531.22.8 (KHTML, like Gecko) Silk/3.2
			 *		Mozilla/5.0 (PlayStation Vita 1.50) AppleWebKit/531.22.8 (KHTML, like Gecko) Silk/3.2
			 *		Mozilla/5.0 (PlayStation Vita 1.51) AppleWebKit/531.22.8 (KHTML, like Gecko) Silk/3.2
			 *		Mozilla/5.0 (PlayStation Vita 1.52) AppleWebKit/531.22.8 (KHTML, like Gecko) Silk/3.2
			 *		Mozilla/5.0 (PlayStation Vita 1.60) AppleWebKit/531.22.8 (KHTML, like Gecko) Silk/3.2
			 *		Mozilla/5.0 (PlayStation Vita 1.61) AppleWebKit/531.22.8 (KHTML, like Gecko) Silk/3.2
			 *		Mozilla/5.0 (PlayStation Vita 1.80) AppleWebKit/531.22.8 (KHTML, like Gecko) Silk/3.2
			 *
			 *		Mozilla/5.0 (PLAYSTATION 3; 1.00)
			 *		Mozilla/5.0 (PLAYSTATION 3; 2.00)
			 *		Mozilla/5.0 (PLAYSTATION 3; 3.55)
			 *		Mozilla/5.0 (PLAYSTATION 3 4.11) AppleWebKit/531.22.8 (KHTML, like Gecko)
			 *		Mozilla/5.0 (PLAYSTATION 3 4.10) AppleWebKit/531.22.8 (KHTML, like Gecko)
			 *
			 *		Mozilla/5.0 (PlayStation 3) SonyComputerEntertainmentEurope/531.3 (NCell) NuantiMeta/2.0
			 */
		
			if (preg_match('/PlayStation Portable/', $ua)) {
				$this->os->name = '';
		
				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation Portable';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
			}

			if (preg_match('/PlayStation Vita ([0-9.]*)/', $ua, $match)) {
				$this->os->name = '';
				$this->os->version = new Version(array('value' => $match[1]));
		
				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation Vita';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
				
				if (preg_match('/VTE\//', $ua, $match)) {
					$this->device->model = 'Playstation Vita TV';
				}	
			}

			if (preg_match('/PlayStation 3/i', $ua)) {
				$this->os->name = '';

				if (preg_match('/PLAYSTATION 3;? ([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}
				
				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation 3';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
			}

			if (preg_match('/PlayStation 4/i', $ua)) {
				$this->os->name = '';

				if (preg_match('/PlayStation 4 ([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}
				
				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation 4';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		XBox
			 *
			 *		Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; Xbox)
			 *		Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0; Xbox; Xbox One)
			 */
		
			if (preg_match('/Xbox\)$/', $ua, $match)) {
				$this->os->name = '';
				$this->os->version = null;
		
				$this->device->manufacturer = 'Microsoft';
				$this->device->model = 'Xbox 360';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;
				
				if ($this->browser->name == 'Mobile Internet Explorer')
					$this->browser->name = 'Internet Explorer';
			}

			if (preg_match('/Xbox One\)$/', $ua, $match)) {
				$this->os->name = '';
				$this->os->version = null;
		
				$this->device->manufacturer = 'Microsoft';
				$this->device->model = 'Xbox One';
				$this->device->type = TYPE_GAMING;
				$this->device->identified |= ID_MATCH_UA;

				if ($this->browser->name == 'Mobile Internet Explorer')
					$this->browser->name = 'Internet Explorer';
			}

			/****************************************************
			 *		Kin
			 *
			 *		Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 6.12; en-US; KIN.One 1.0)
			 *		Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 6.12; en-US; KIN.Two 1.0)
			 */

			if (preg_match('/KIN\.(One|Two) ([0-9.]*)/i', $ua, $match)) {
				$this->os->name = 'Kin OS';
				$this->os->version = new Version(array('value' => $match[2], 'details' => 2));
				
				switch($match[1]) {
					case 'One':		$this->device->manufacturer = 'Microsoft';
									$this->device->model = 'Kin ONE';
									$this->device->identified |= ID_MATCH_UA;
									break;
									
					case 'Two':		$this->device->manufacturer = 'Microsoft';
									$this->device->model = 'Kin TWO';
									$this->device->identified |= ID_MATCH_UA;
									break;
				}
			}

			/****************************************************
			 *		Zune HD
			 *
			 *		Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 6.12; Microsoft ZuneHD 4.5)
			 */
		
			if (preg_match('/Microsoft ZuneHD/', $ua)) {
				$this->os->name = '';
				$this->os->version = null;

				$this->device->manufacturer = 'Microsoft';
				$this->device->model = 'Zune HD';
				$this->device->type = TYPE_MEDIA;
				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		Panasonic Smart Viera
			 *
			 *		Mozilla/5.0 (FreeBSD; U; Viera; ja-JP) AppleWebKit/535.1 (KHTML, like Gecko) Viera/1.2.4 Chrome/14.0.835.202 Safari/535.1
			 */
		
			if (preg_match('/Viera/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Panasonic';
				$this->device->model = 'Smart Viera';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}


			/****************************************************
			 *		Sharp AQUOS TV
			 *
			 *		Mozilla/5.0 (DTV) AppleWebKit/531.2  (KHTML, like Gecko) AQUOSBrowser/1.0 (US00DTV;V;0001;0001)
			 *		Mozilla/5.0 (DTV) AppleWebKit/531.2+ (KHTML, like Gecko) Espial/6.0.4 AQUOSBrowser/1.0 (CH00DTV;V;0001;0001)
			 *		Opera/9.80 (Linux armv6l; U; en) Presto/2.8.115 Version/11.10 AQUOS-AS/1.0 LC-40LE835X
			 */
		
			if (preg_match('/AQUOSBrowser/', $ua) || preg_match('/AQUOS-AS/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Sharp';
				$this->device->model = 'Aquos TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}


			/****************************************************
			 *		Samsung Smart TV
			 *
			 *		Mozilla/5.0 (SmartHub; SMART-TV; U; Linux/SmartTV; Maple2012) AppleWebKit/534.7 (KHTML, like Gecko) SmartTV Safari/534.7
			 *		Mozilla/5.0 (SmartHub; SMART-TV; U; Linux/SmartTV) AppleWebKit/531.2+ (KHTML, like Gecko) WebBrowser/1.0 SmartTV Safari/531.2+
			 */

			if (preg_match('/SMART-TV/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Samsung';
				$this->device->model = 'Smart TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;

				if (preg_match('/Maple([0-9]*)/', $ua, $match)) {
					$this->device->model .= ' ' . $match[1];
				}
			}


			/****************************************************
			 *		Sony Internet TV
			 *
			 *		Opera/9.80 (Linux armv7l; U; InettvBrowser/2.2(00014A;SonyDTV115;0002;0100) KDL-46EX640; CC/USA; en) Presto/2.8.115 Version/11.10
			 *		Opera/9.80 (Linux armv7l; U; InettvBrowser/2.2(00014A;SonyDTV115;0002;0100) KDL-40EX640; CC/USA; en) Presto/2.10.250 Version/11.60
			 *		Opera/9.80 (Linux armv7l; U; InettvBrowser/2.2(00014A;SonyDTV115;0002;0100) N/A; CC/USA; en) Presto/2.8.115 Version/11.10
			 *		Opera/9.80 (Linux mips; U; InettvBrowser/2.2 (00014A;SonyDTV115;0002;0100) ; CC/JPN; en) Presto/2.9.167 Version/11.50
			 *		Opera/9.80 (Linux mips; U; InettvBrowser/2.2 (00014A;SonyDTV115;0002;0100) AZ2CVT2; CC/CAN; en) Presto/2.7.61 Version/11.00
			 *		Opera/9.80 (Linux armv6l; Opera TV Store/4207; U; (SonyBDP/BDV11); en) Presto/2.9.167 Version/11.50
			 *		Opera/9.80 (Linux armv6l ; U; (SonyBDP/BDV11); en) Presto/2.6.33 Version/10.60
			 *		Opera/9.80 (Linux armv6l; U; (SonyBDP/BDV11); en) Presto/2.8.115 Version/11.10
			 */

			if (preg_match('/SonyDTV|SonyBDP|SonyCEBrowser/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Internet TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		Philips Net TV
			 *
			 *		Opera/9.70 (Linux armv6l ; U; CE-HTML/1.0 NETTV/2.0.2; en) Presto/2.2.1
			 *		Opera/9.80 (Linux armv6l ; U; CE-HTML/1.0 NETTV/3.0.1;; en) Presto/2.6.33 Version/10.60
			 *		Opera/9.80 (Linux mips; U; CE-HTML/1.0 NETTV/3.0.1; PHILIPS-AVM-2012; en) Presto/2.9.167 Version/11.50
			 *		Opera/9.80 (Linux mips ; U; HbbTV/1.1.1 (; Philips; ; ; ; ) CE-HTML/1.0 NETTV/3.1.0; en) Presto/2.6.33 Version/10.70
			 *		Opera/9.80 (Linux i686; U; HbbTV/1.1.1 (; Philips; ; ; ; ) CE-HTML/1.0 NETTV/3.1.0; en) Presto/2.9.167 Version/11.50
			 */

			if (preg_match('/NETTV\//', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Philips';
				$this->device->model = 'Net TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}
			
			/****************************************************
			 *		LG NetCast TV
			 *
			 *		Mozilla/5.0 (DirectFB; Linux armv7l) AppleWebKit/534.26+ (KHTML, like Gecko) Version/5.0 Safari/534.26+ LG Browser/5.00.00(+mouse+3D+SCREEN+TUNER; LGE; GLOBAL-PLAT4; 03.09.22; 0x00000001;); LG NetCast.TV-2012
			 *		Mozilla/5.0 (DirectFB; Linux armv7l) AppleWebKit/534.26+ (KHTML, like Gecko) Version/5.0 Safari/534.26+ LG Browser/5.00.00(+SCREEN+TUNER; LGE; GLOBAL-PLAT4; 01.00.00; 0x00000001;); LG NetCast.TV-2012
			 *		Mozilla/5.0 (DirectFB; U; Linux armv6l; en) AppleWebKit/531.2  (KHTML, like Gecko) Safari/531.2  LG Browser/4.1.4( BDP; LGE; Media/BD660; 6970; abc;); LG NetCast.Media-2011
			 *		Mozilla/5.0 (DirectFB; U; Linux 7631; en) AppleWebKit/531.2  (KHTML, like Gecko) Safari/531.2  LG Browser/4.1.4( NO_NUM; LGE; Media/SP520; ST.3.97.409.F; 0x00000001;); LG NetCast.Media-2011
			 *		Mozilla/5.0 (DirectFB; U; Linux 7630; en) AppleWebKit/531.2  (KHTML, like Gecko) Safari/531.2  LG Browser/4.1.4( 3D BDP NO_NUM; LGE; Media/ST600; LG NetCast.Media-2011
			 *		(LGSmartTV/1.0) AppleWebKit/534.23 OBIGO-T10/2.0
			 */

			if (preg_match('/LG NetCast\.(?:TV|Media)-([0-9]*)/', $ua, $match)) {
				$this->os->name = '';
				$this->device->manufacturer = 'LG';
				$this->device->model = 'NetCast TV ' . $match[1];
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}

			if (preg_match('/LGSmartTV/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'LG';
				$this->device->model = 'Smart TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		Toshiba Smart TV
			 *
			 *		Mozilla/5.0 (Linux mipsel; U; HbbTV/1.1.1 (; TOSHIBA; DTV_RL953; 56.7.66.7; t12; ) ; ToshibaTP/1.3.0 (+VIDEO_MP4+VIDEO_X_MS_ASF+AUDIO_MPEG+AUDIO_MP4+DRM+NATIVELAUNCH) ; en) AppleWebKit/534.1 (KHTML, like Gecko)
			 *		Mozilla/5.0 (DTV; TSBNetTV/T32013713.0203.7DD; TVwithVideoPlayer; like Gecko) NetFront/4.1 DTVNetBrowser/2.2 (000039;T32013713;0203;7DD) InettvBrowser/2.2 (000039;T32013713;0203;7DD)
			 *		Mozilla/5.0 (Linux mipsel; U; HbbTV/1.1.1 (; TOSHIBA; 40PX200; 0.7.3.0.; t12; ) ; Toshiba_TP/1.3.0 (+VIDEO_MP4+AUDIO_MPEG+AUDIO_MP4+VIDEO_X_MS_ASF+OFFLINEAPP) ; en) AppleWebKit/534.1 (KHTML, like Gec
			 */

			if (preg_match('/Toshiba_?TP\//', $ua) || preg_match('/TSBNetTV\//', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Toshiba';
				$this->device->model = 'Smart TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		NetRange MMH 
			 */

			if (preg_match('/NETRANGEMMH/', $ua)) {
				$this->os->name = '';
				$this->os->version = null;
				$this->browser->name = '';
				$this->browser->version = null;
				$this->device->model = 'NetRange MMH';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		MachBlue XT
			 */

			if (preg_match('/mbxtWebKit\/([0-9.]*)/', $ua, $match)) {
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
			 *		Motorola KreaTV
			 */

			if (preg_match('/Motorola KreaTV STB/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Motorola';
				$this->device->model = 'KreaTV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		ADB
			 */

			if (preg_match('/\(ADB; ([^\)]+)\)/', $ua, $match)) {
				$this->os->name = '';
				$this->device->manufacturer = 'ADB';
				$this->device->model = ($match[1] != 'Unknown' ? str_replace('ADB', '', $match[1]) . ' ' : '') . 'IPTV receiver';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		MStar
			 */

			if (preg_match('/Mstar;OWB/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'MStar';
				$this->device->model = 'PVR';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;

				$this->browser->name = 'Origyn Web Browser';
			}

			/****************************************************
			 *		TechniSat
			 */

			if (preg_match('/\TechniSat ([^;]+);/', $ua, $match)) {
				$this->os->name = '';
				$this->device->manufacturer = 'TechniSat';
				$this->device->model = $match[1];
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}
			
			/****************************************************
			 *		Technicolor
			 */

			if (preg_match('/\Technicolor_([^;]+);/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Technicolor';
				$this->device->model = $match[1];
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		Winbox Evo2
			 */

			if (preg_match('/Winbox Evo2/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Winbox';
				$this->device->model = 'Evo2';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		DuneHD
			 */

			if (preg_match('/DuneHD\//', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Dune HD';
				$this->device->model = '';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}

			/****************************************************
			 *		Roku
			 */

			if (preg_match('/^Roku\/DVP-([0-9]+)/', $ua, $match)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Roku';
				$this->device->type = TYPE_TELEVISION;

				switch ($match[1]) {
					case '2000':	$this->device->model = 'HD'; break;
					case '2050':	$this->device->model = 'XD'; break;
					case '2100':	$this->device->model = 'XDS'; break;
					case '2400':	$this->device->model = 'LT'; break;
					case '3000':	$this->device->model = '2 HD'; break;
					case '3050':	$this->device->model = '2 XD'; break;
					case '3100':	$this->device->model = '2 XS'; break;
				}

				$this->device->identified |= ID_MATCH_UA;
			}


			/****************************************************
			 *		MediStream
			 */

			if (preg_match('/MediStream/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Bewatec';
				$this->device->model = 'MediStream';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified |= ID_MATCH_UA;
			}


			/****************************************************
			 *		BrightSign
			 */

			if (preg_match('/BrightSign\/[0-9\.]+ \(([^\)]+)/', $ua, $match)) {
				$this->os->name = '';
				$this->device->manufacturer = 'BrightSign';
				$this->device->model = $match[1];
				$this->device->type = TYPE_SIGNAGE;
				$this->device->identified |= ID_MATCH_UA;
			}
			
			
			/****************************************************
			 *		Iadea
			 */

			if (preg_match('/ADAPI/', $ua) && preg_match('/\(MODEL:([^\)]+)\)/', $ua, $match)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Iadea';
				$this->device->model = $match[1];
				$this->device->type = TYPE_SIGNAGE;
				$this->device->identified |= ID_MATCH_UA;
			}


			/****************************************************
			 *		Generic
			 */

			if (preg_match('/HbbTV\/[0-9\.]+ \([^;]*;\s*([^;]*)\s*;\s*([^;]*)\s*;/', $ua, $match)) {
				$vendorName = trim($match[1]);
				$modelName = trim($match[2]);

				if (!isset($this->device->manufacturer) && $vendorName != '' && $vendorName != 'vendorName') {
					switch($vendorName) {
						case 'LG Electronics':	$this->device->manufacturer = 'LG'; break;
						case 'LGE':				$this->device->manufacturer = 'LG'; break;
						case 'TOSHIBA':			$this->device->manufacturer = 'Toshiba'; break;
						case 'smart':			$this->device->manufacturer = 'Smart'; break;
						case 'tv2n':			$this->device->manufacturer = 'TV2N'; break;
						default:				$this->device->manufacturer = $vendorName;
					}

					if (!isset($this->device->model) && $modelName != '' && $modelName != 'modelName') {
						$this->device->identified |= ID_PATTERN;

						switch($modelName) {
							case 'GLOBAL_PLAT3':	$this->device->model = 'NetCast 3.0'; $this->device->identified |= ID_MATCH_UA; break;
							case 'GLOBAL_PLAT4':	$this->device->model = 'NetCast 4.0'; $this->device->identified |= ID_MATCH_UA; break;
							case 'NetCast 4.0':		$this->device->model = 'NetCast 4.0'; $this->device->identified |= ID_MATCH_UA; break;
							case 'SmartTV2012':		$this->device->model = 'Smart TV 2012'; $this->device->identified |= ID_MATCH_UA; break;
							case 'videoweb':		$this->device->model = 'Videoweb'; $this->device->identified |= ID_MATCH_UA; break;
							case 'VIERA 2013':		$this->device->model = 'Smart Viera'; $this->device->identified |= ID_MATCH_UA; break;
							case 'VIERA 2014':		$this->device->model = 'Smart Viera'; $this->device->identified |= ID_MATCH_UA; break;
							case 'hms1000sph2':		$this->device->manufacturer = 'Humax'; $this->device->model = 'HMS-1000S'; $this->device->identified |= ID_MATCH_UA; break;
							default:				$this->device->model = $modelName;
						}
						
						if ($vendorName == 'Humax') {
							$this->device->model = strtoupper($this->device->model);
						}
						
						$this->os->name = '';
					}
				}

				$this->device->type = TYPE_TELEVISION;
			}
			
			/****************************************************
			 *		Detect type based on common identifiers
			 */

			if (preg_match('/InettvBrowser/', $ua)) {
				$this->device->type = TYPE_TELEVISION;
			}

			if (preg_match('/MIDP/', $ua)) {
				$this->device->type = TYPE_MOBILE;
			}
			
			/****************************************************
			 *		Try to detect any devices based on common
			 *		locations of model ids
			 */

			if (!isset($this->device->model) && !isset($this->device->manufacturer)) {
				$candidates = array();
				
				if (!preg_match('/^(Mozilla|Opera)/', $ua)) if (preg_match('/^(?:MQQBrowser\/[0-9\.]+\/)?([^\s]+)/', $ua, $match)) {
					$match[1] = preg_replace('/_TD$/', '', $match[1]);
					$match[1] = preg_replace('/_CMCC$/', '', $match[1]);
					$match[1] = preg_replace('/[_ ]Mozilla$/', '', $match[1]);
					$match[1] = preg_replace('/ Linux$/', '', $match[1]);
					$match[1] = preg_replace('/ Opera$/', '', $match[1]);
					$match[1] = preg_replace('/\/[0-9].*$/', '', $match[1]);

					array_push($candidates, $match[1]);
				}
			
				if (preg_match('/^((?:SAMSUNG|TCL|ZTE) [^\s]+)/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}
				
				if (preg_match('/(Samsung (?:GT|SCH|SGH|SHV|SHW|SPH)-[A-Z-0-9]+)/i', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/[0-9]+x[0-9]+; ([^;]+)/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\s*([^;]*[^\s])\s*; [0-9]+\*[0-9]+\)/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}
				
				if (preg_match('/[0-9]+X[0-9]+ ([^;\/\(\)]+)/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Windows NT 5.1; ([^;]+); Windows Phone/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\) PPC; (?:[0-9]+x[0-9]+; )?([^;\/\(\)]+)/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Windows Mobile; ([^;]+); PPC;/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\(([^;]+); U; Windows Mobile/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Series60\/[0-9\.]+ ([^\s]+) Profile/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Vodafone\/1.0\/([^\/]+)/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/^(DoCoMo[^(]+)/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\ ([^\s]+)$/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}
				
				if (preg_match('/; ([^;\)]+)\)/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}
				
				if (preg_match('/^(.*)\/UCWEB/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}
				
				if (preg_match('/^([a-z0-9\.\_\+\/ ]+) Linux/i', $ua, $match)) {
					array_push($candidates, $match[1]);
				}
				
				if (preg_match('/\(([a-z0-9\.\_\+\/ ]+) Browser/i', $ua, $match)) {
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
							if (preg_match('/^acer_([^\/]*)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Acer';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}

							if (preg_match('/^ALCATEL[_-]([^\/]*)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Alcatel';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;

								if (preg_match('/^OT\s*([^\s]*)/i', $this->device->model, $match)) {
									$this->device->model = 'One Touch ' . $match[1];
								}

								$identified = true;
							}

							if (preg_match('/^BenQ-([^\/]*)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'BenQ';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
	
							if (preg_match('/^Bird_([^\/]*)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Bird';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
	
							if (preg_match('/^(?:YL-)?COOLPAD([^\s]+)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Coolpad';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
							
							if (preg_match('/^DoCoMo\/[0-9\.]+ ([^\s]+)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'DoCoMo';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
							
							if (preg_match('/^dopod[-_]?([^\s]+)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Dopod';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
							
							if (preg_match('/^GIONEE[-_]([^\s]+)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Gionee';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
							
							if (preg_match('/^HTC[_-]?([^\/_]+)(?:\/|_|$)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'HTC';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
	
							if (preg_match('/^HUAWEI[_-]?([^\/]*)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Huawei';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
	
							if (preg_match('/^KONKA[-_]?([^\s]+)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Konka';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
							
							if (preg_match('/^K-Touch_?([^\/]*)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'K-Touch';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
	
							if (preg_match('/^Lenovo-([^\/]*)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Lenovo';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
	
							if (preg_match('/^Lephone_([^\/]*)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Lephone';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
	
							if (preg_match('/(?:^|\()LGE?(?:\/|-|_|\s)([^\s]*)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'LG';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
	
							if (preg_match('/^MOT-([^\/_]+)(?:\/|_|$)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Motorola';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
							
							if (preg_match('/^Motorola_([^\/_]+)(?:\/|_|$)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Motorola';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
	
							if (preg_match('/^Nokia-?([^\/]+)(?:\/|$)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Nokia';

								if ($match[1] != 'Browser') {
									$this->device->model = DeviceModels::cleanup($match[1]);
									$this->device->type = TYPE_MOBILE;
									$this->device->identified = false;
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
												$this->os->version = null;
											}
										}
									}
								}
							}
	
							if (preg_match('/^OPPO_([^\/_]+)(?:\/|_|$)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Oppo';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
							
							if (preg_match('/^Pantech([^\/_]+)(?:\/|_|$)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Pantech';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
							
							if (preg_match('/^SonyEricsson([^\/_]+)(?:\/|_|$)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Sony Ericsson';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->identified = false;
								$identified = true;
								
								if (preg_match('/^[a-z][0-9]+/', $this->device->model)) {
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
	
							if (preg_match('/^T-smart_([^\/]*)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'T-smart';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
							
							if (preg_match('/^TCL[-_ ]([^\/]*)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'TCL';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
							
							if (preg_match('/^SHARP[-_\/]([^\/]*)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Sharp';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}
			
							if (preg_match('/^SAMSUNG[-\/ ]?([^\/_]+)(?:\/|_|$)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Samsung';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$this->device->identified = false;
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
								
								else if (preg_match('/Jasmine\/([0-9.]*)/', $ua, $match)) {
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
					
								else if (preg_match('/(?:Dolfin\/([0-9.]*)|Browser\/Dolfin([0-9.]*))/', $ua, $match)) {
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
	
							if (preg_match('/^Xiaomi[_]?([^\s]+)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Xiaomi';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
								$identified = true;
							}

							if (preg_match('/^ZTE[-_]?([^\s]+)/i', $candidates[$i], $match)) {
								$this->device->manufacturer = 'ZTE';
								$this->device->model = DeviceModels::cleanup($match[1]);
								$this->device->type = TYPE_MOBILE;
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
								$this->os->name = 'Android';
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
								$this->os->name = 'Android';
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
			

			if (preg_match('/Sprint ([^\s]+)/', $ua, $match)) {
				$this->device->manufacturer = 'Sprint';
				$this->device->model = DeviceModels::cleanup($match[1]);
				$this->device->type = TYPE_MOBILE;
				$this->device->identified |= ID_PATTERN;
			}

			if (preg_match('/SoftBank\/[^\/]+\/([^\/]+)\//', $ua, $match)) {
				$this->device->manufacturer = 'Softbank';
				$this->device->model = DeviceModels::cleanup($match[1]);
				$this->device->type = TYPE_MOBILE;
				$this->device->identified |= ID_PATTERN;
			}

			if (preg_match('/\((?:LG[-|\/])(.*) (?:Browser\/)?AppleWebkit/', $ua, $match)) {
				$this->device->manufacturer = 'LG';
				$this->device->model = DeviceModels::cleanup($match[1]);
				$this->device->type = TYPE_MOBILE;
				$this->device->identified |= ID_PATTERN;
			}

			if (preg_match('/^Mozilla\/5.0 \((?:Nokia|NOKIA)(?:\s?)([^\)]+)\)UC AppleWebkit\(like Gecko\) Safari\/530$/', $ua, $match)) {
				$this->device->manufacturer = 'Nokia';
				$this->device->model = DeviceModels::cleanup($match[1]);
				$this->device->type = TYPE_MOBILE;
				$this->device->identified |= ID_PATTERN;
				
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
		
			if (preg_match('/Safari/', $ua)) {
				
				if (isset($this->os->name) && $this->os->name == 'iOS') {
					$this->browser->stock = true;
					$this->browser->hidden = true;
					$this->browser->name = 'Safari';
					$this->browser->version = null;
				}
				
				if (isset($this->os->name) && ($this->os->name == 'Mac OS X' || $this->os->name == 'Windows')) {
					$this->browser->name = 'Safari';
					$this->browser->stock = $this->os->name == 'Mac OS X';

					if (preg_match('/Version\/([0-9\.]+)/', $ua, $match)) {
						$this->browser->version = new Version(array('value' => $match[1]));
					}		

					if (preg_match('/AppleWebKit\/[0-9\.]+\+/', $ua)) {
						$this->browser->name = 'WebKit Nightly Build';
						$this->browser->version = null;
					}
				}
			}

			/****************************************************
			 *		Internet Explorer
			 */
		
			if (preg_match('/MSIE/', $ua)) {
				$this->browser->name = 'Internet Explorer';
				
				if (preg_match('/IEMobile/', $ua) || preg_match('/Windows CE/', $ua) || preg_match('/Windows Phone/', $ua) || preg_match('/WP7/', $ua) || preg_match('/WPDesktop/', $ua)) {
					$this->browser->name = 'Mobile Internet Explorer';
				}

				if (preg_match('/MSIE ([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
				
				if (preg_match('/Mac_/', $ua)) {
					$this->os->name = 'Mac OS';
					$this->engine->name = 'Tasman';
					$this->device->type = TYPE_DESKTOP;
					
					if ($this->browser->version->toFloat() >= 5.11 && $this->browser->version->toFloat() <= 5.13) {
						$this->os->name = 'Mac OS X';
					}

					if ($this->browser->version->toFloat() >= 5.2) {
						$this->os->name = 'Mac OS X';
					}
				}
			}

			if (preg_match('/\(IE ([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'Internet Explorer';
				$this->browser->version = new Version(array('value' => $match[1]));
			}

			if (preg_match('/Browser\/IE([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'Internet Explorer';
				$this->browser->version = new Version(array('value' => $match[1]));
			}

			if (preg_match('/Trident\/[789][^\)]+; rv:([0-9.]*)\)/', $ua, $match)) {
				$this->browser->name = 'Internet Explorer';
				$this->browser->version = new Version(array('value' => $match[1]));
			}

			/****************************************************
			 *		Firefox
			 */
		
			if (preg_match('/Firefox/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/Firefox\/([0-9ab.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
					
					if (preg_match('/a/', $match[1])) {
						$this->browser->channel = 'Aurora';
					}

					if (preg_match('/b/', $match[1])) {
						$this->browser->channel = 'Beta';
					}
				}

				if (preg_match('/Fennec/', $ua)) {
					$this->device->type = TYPE_MOBILE;
				}
				
				if (preg_match('/Mobile;(?: ([^;]+);)? rv/', $ua, $match)) {
					$this->device->type = TYPE_MOBILE;

					$device = DeviceModels::identify('firefoxos', $match[1]);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->os->name = 'Firefox OS';
						$this->device = $device;
					}
				}

				if (preg_match('/Tablet;(?: ([^;]+);)? rv/', $ua, $match)) {
					$this->device->type = TYPE_TABLET;

					$device = DeviceModels::identify('firefoxos', $match[1]);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->os->name = 'Firefox OS';
						$this->device = $device;
					}
				}
				
				if ($this->device->type == TYPE_MOBILE || $this->device->type == TYPE_TABLET) {
					$this->browser->name = 'Firefox Mobile';
				}

				if ($this->device->type == '') {
					$this->device->type = TYPE_DESKTOP;
				}
			}

			if (preg_match('/Namoroka/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/Namoroka\/([0-9ab.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				$this->browser->channel = 'Namoroka';
			}

			if (preg_match('/Shiretoko/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/Shiretoko\/([0-9ab.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
				
				$this->browser->channel = 'Shiretoko';
			}
			
			if (preg_match('/Minefield/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/Minefield\/([0-9ab.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				$this->browser->channel = 'Minefield';
			}
			
			if (preg_match('/Firebird/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firebird';

				if (preg_match('/Firebird\/([0-9ab.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
			}
			
			/****************************************************
			 *		SeaMonkey
			 */
		
			if (preg_match('/SeaMonkey/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'SeaMonkey';

				if (preg_match('/SeaMonkey\/([0-9ab.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if ($this->device->type == '') {
					$this->device->type = TYPE_DESKTOP;
				}
			}
			
			if (preg_match('/PmWFx\/([0-9ab.]*)/', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->name = 'SeaMonkey';
				$this->browser->version = new Version(array('value' => $match[1]));
			}
			
			

			/****************************************************
			 *		Netscape
			 */
		
			if (preg_match('/Netscape/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Netscape';

				if (preg_match('/Netscape[0-9]?\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
			}

			/****************************************************
			 *		Konqueror
			 */
		
			if (preg_match('/[k|K]onqueror\//', $ua)) {
				$this->browser->name = 'Konqueror';

				if (preg_match('/[k|K]onqueror\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if ($this->device->type == '') {
					$this->device->type = TYPE_DESKTOP;
				}
			}

			/****************************************************
			 *		Chrome
			 */
		
			if (preg_match('/(?:Chrome|CrMo|CriOS)\/([0-9.]*)/', $ua, $match)) {
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
							$this->browser->version->details = 1;
							break;
						default:	
							$this->browser->channel = 'Dev';
							break;
					}
					
					/* Webview for Android 4.4 and higher */
					if (implode('.', array_splice((explode('.', $match[1])), 1, 2)) == '0.0' && preg_match('/Version\//', $ua)) {
						$this->browser->stock = true;
						$this->browser->name = null;
						$this->browser->version = null;					
						$this->browser->channel = null;
					}

					/* Samsung Chromium based browsers */
					if (isset($device->manufacturer) && $device->manufacturer == 'Samsung') {
					
						/* Version 1.0 */
						if ($match[1] == '18.0.1025.308' && preg_match('/Version\/1.0/', $ua)) {
							$this->browser->stock = true;
							$this->browser->name = null;
							$this->browser->version = null;					
							$this->browser->channel = null;
						}

						/* Version 1.5 */
						if ($match[1] == '28.0.1500.94' && preg_match('/Version\/1.5/', $ua)) {
							$this->browser->stock = true;
							$this->browser->name = null;
							$this->browser->version = null;					
							$this->browser->channel = null;
						}
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
		
			if (preg_match('/Chromium/', $ua)) {
				$this->browser->stock = false;
				$this->browser->channel = '';
				$this->browser->name = 'Chromium';

				if (preg_match('/Chromium\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if ($this->device->type == '') {
					$this->device->type = TYPE_DESKTOP;
				}
			}	
			
			
			/****************************************************
			 *		Opera
			 */
		
			if (preg_match('/OPR\/([0-9.]*)/', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->channel = '';
				$this->browser->name = 'Opera';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));

				if (preg_match('/Edition Developer/', $ua)) {
					$this->browser->channel = 'Developer';
				}

				if (preg_match('/Edition Next/', $ua)) {
					$this->browser->channel = 'Next';
				}

				if ($this->device->type == TYPE_MOBILE) {
					$this->browser->name = 'Opera Mobile';
				}
			}

			if (preg_match('/Opera/i', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Opera';

				if (preg_match('/Opera[\/| ]([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/Version\/([0-9.]*)/', $ua, $match)) {
					if (floatval($match[1]) >= 10)
						$this->browser->version = new Version(array('value' => $match[1]));
					else
						$this->browser->version = null;
				}

				if (!is_null($this->browser->version) && preg_match('/Edition Labs/', $ua)) {
					$this->browser->channel = 'Labs';
				}
				
				if (!is_null($this->browser->version) && preg_match('/Edition Next/', $ua)) {
					$this->browser->channel = 'Next';
				}
				
				if (preg_match('/Opera Tablet/', $ua)) {
					$this->browser->name = 'Opera Mobile';
					$this->device->type = TYPE_TABLET;
				}
				
				if (preg_match('/Opera Mobi/', $ua)) {
					$this->browser->name = 'Opera Mobile';
					$this->device->type = TYPE_MOBILE;
				}

				if (preg_match('/Opera Mini;/', $ua)) {
					$this->browser->name = 'Opera Mini';
					$this->browser->version = null;
					$this->browser->mode = 'proxy';
					$this->device->type = TYPE_MOBILE;
				}
				
				if (preg_match('/Opera Mini\/(?:att\/)?([0-9.]*)/', $ua, $match)) {
					$this->browser->name = 'Opera Mini';
					$this->browser->version = new Version(array('value' => $match[1], 'details' => (intval(substr(strrchr($match[1], '.'), 1)) > 99 ? -1 : null)));
					$this->browser->mode = 'proxy';
					$this->device->type = TYPE_MOBILE;
				}
				
				if ($this->browser->name == 'Opera' && $this->device->type == TYPE_MOBILE) {
					$this->browser->name = 'Opera Mobile';
					
					if (preg_match('/BER/', $ua)) {
						$this->browser->name = 'Opera Mini';
						$this->browser->version = null;
					}
				}

				if (preg_match('/InettvBrowser/', $ua)) {
					$this->device->type = TYPE_TELEVISION;
				}

				if (preg_match('/Opera[ -]TV/', $ua)) {
					$this->browser->name = 'Opera';
					$this->device->type = TYPE_TELEVISION;
				}

				if (preg_match('/Linux zbov/', $ua)) {
					$this->browser->name = 'Opera Mobile';
					$this->browser->mode = 'desktop';

					$this->device->type = TYPE_MOBILE;

					$this->os->name = null;
					$this->os->version = null;
				}

				if (preg_match('/Linux zvav/', $ua)) {
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

			if (preg_match('/Coast\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'Coast by Opera';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 3 ));
			}

			/****************************************************
			 *		wOSBrowser
			 */
		
			if (preg_match('/wOSBrowser/', $ua)) {
				$this->browser->name = 'webOS Browser';
				
				if ($this->os->name != 'webOS') {
					$this->os->name = 'webOS';
				}
			}

			/****************************************************
			 *		Sailfish Browser
			 */
		
			if (preg_match('/Sailfish ?Browser/', $ua)) {
				$this->browser->name = 'Sailfish Browser';
				$this->browser->stock = true;

				if (preg_match('/Sailfish ?Browser\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));
				}
			}	

			/****************************************************
			 *		BrowserNG
			 */
		
			if (preg_match('/BrowserNG/', $ua)) {
				$this->browser->name = 'Nokia Browser';

				if (preg_match('/BrowserNG\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3, 'builds' => false));
				}
			}	

			/****************************************************
			 *		Nokia Browser
			 */
		
			if (preg_match('/NokiaBrowser/', $ua)) {
				$this->browser->name = 'Nokia Browser';
				$this->browser->channel = null;

				if (preg_match('/NokiaBrowser\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				}
			}	
			
			/****************************************************
			 *		Nokia Xpress
			 *
			 *		Mozilla/5.0 (X11; Linux x86_64; rv:5.0.1) Gecko/20120822 OSRE/1.0.7f
			 */
			
			if (preg_match('/OSRE/', $ua)) {
				$this->browser->name = 'Nokia Xpress';
				$this->browser->mode = 'proxy';
				$this->device->type = TYPE_MOBILE;

				$this->os->name = null;
				$this->os->version = null;
			}

			if (preg_match('/S40OviBrowser/', $ua)) {
				$this->browser->name = 'Nokia Xpress';
				$this->browser->mode = 'proxy';

				if (preg_match('/S40OviBrowser\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				}
	
				if (preg_match('/Nokia([^\/]+)\//', $ua, $match)) {
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
							$this->device = $device;
						}
					}
				}
				
				if (preg_match('/NOKIALumia([0-9]+)/', $ua, $match)) {
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
		
			if (preg_match('/Maemo[ |_]Browser/', $ua)) {
				$this->browser->name = 'MicroB';

				if (preg_match('/Maemo[ |_]Browser[ |_]([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				}
			}
			

			/****************************************************
			 *		Silk
			 */
		
			if (preg_match('/Silk/', $ua)) {
				if (preg_match('/Silk-Accelerated/', $ua)) {
					$this->browser->name = 'Silk';

					if (preg_match('/Silk\/([0-9.]*)/', $ua, $match)) {
						$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));
					}
	
					if (preg_match('/; ([^;]*[^;\s])\s+Build/', $ua, $match)) {
						$this->device = DeviceModels::identify('android', $match[1]);
					}		

					if (!$this->device->identified) {
						$this->device->manufacturer = 'Amazon';
						$this->device->model = 'Kindle Fire';
						$this->device->type = TYPE_TABLET;
						$this->device->identified |= ID_INFER;
					}
					
					if ($this->os->name != 'Android') {
						$this->os->name = 'Android';
						$this->os->version = null;
					}
				}
			}

			/****************************************************
			 *		Dolfin
			 */
		
			if (preg_match('/Dolfin/', $ua) || preg_match('/Jasmine/', $ua)) {
				$this->browser->name = 'Dolfin';

				if (preg_match('/Dolfin\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/Browser\/Dolfin([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/Jasmine\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
			}

			/****************************************************
			 *		Iris
			 */
		
			if (preg_match('/Iris/', $ua)) {
				$this->browser->name = 'Iris';

				$this->device->type = TYPE_MOBILE;
				$this->device->manufacturer = null;
				$this->device->model = null;

				$this->os->name = 'Windows Mobile';
				$this->os->version = null;

				if (preg_match('/Iris\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
				
				if (preg_match('/ WM([0-9]) /', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1] . '.0'));
				} else {
					$this->browser->mode = 'desktop';
				}
			}

			/****************************************************
			 *		Boxee
			 */
		
			if (preg_match('/Boxee/', $ua)) {
				$this->browser->name = 'Boxee';
				$this->device->type = TYPE_TELEVISION;

				if (preg_match('/Boxee\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
			}

			/****************************************************
			 *		LG Browser
			 */

			if (preg_match('/LG Browser\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'LG Browser';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));
				$this->device->type = TYPE_TELEVISION;
			}
			
			/****************************************************
			 *		Espial
			 */
		
			if (preg_match('/Espial/', $ua)) {
				$this->browser->name = 'Espial';
				
				$this->os->name = '';
				$this->os->version = null;

				if ($this->device->type != TYPE_TELEVISION) {
					$this->device->type = TYPE_TELEVISION;
					$this->device->manufacturer = null;
					$this->device->model = null;
				}
				
				if (preg_match('/Espial\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
				
				if (preg_match('/;L7200/', $ua)) {
					$this->device->manufacturer = 'Toshiba';
					$this->device->model = 'L7200 Smart TV';
					$this->device->identified |= ID_UA_MATCH;
				}
			}

			/****************************************************
			 *		ANT Galio
			 */

			if (preg_match('/ANTGalio\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'ANT Galio';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				$this->device->type = TYPE_TELEVISION;
			}
			
			/****************************************************
			 *		NetFront
			 */
		
			if (preg_match('/Net[fF]ront/', $ua)) {
				$this->browser->name = 'NetFront';
				$this->device->type = TYPE_MOBILE;

				if (preg_match('/NetFront\/?([0-9.]*)/i', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/InettvBrowser/', $ua)) {
					$this->device->type = TYPE_TELEVISION;
				}
			}
			
			if (preg_match('/Browser\/NF([0-9.]*)/i', $ua, $match)) {
				$this->browser->name = 'NetFront';
				$this->browser->version = new Version(array('value' => $match[1]));
				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		NetFront NX
			 */

			if (preg_match('/NX\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'NetFront NX';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));

				if (!isset($this->device->type) || !$this->device->type) {
					if (preg_match('/DTV/i', $ua)) {
						$this->device->type = TYPE_TELEVISION;
					} else if (preg_match('/mobile/i', $ua)) {
						$this->device->type = TYPE_MOBILE;
					} else {
						$this->device->type = TYPE_DESKTOP;
					}
				}
				
				$this->os->name = '';
				$this->os->version = null;
			}
			
			/****************************************************
			 *		Obigo
			 */
		
			if (preg_match('/(?:Obigo|Teleca)/i', $ua)) {
				$this->browser->name = 'Obigo';

				if (preg_match('/Obigo\/([0-9.]*)/i', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/Obigo(?:InternetBrowser)?\/([A-Z])([0-9.]*)/i', $ua, $match)) {
					$this->browser->name = 'Obigo ' . $match[1];
					$this->browser->version = new Version(array('value' => $match[2]));
				}

				if (preg_match('/(?:Obigo|Teleca)[- ]([A-Z])([0-9.]*)[\/;]/i', $ua, $match)) {
					$this->browser->name = 'Obigo ' . $match[1];
					$this->browser->version = new Version(array('value' => $match[2]));
				}

				if (preg_match('/Browser\/(?:Obigo|Teleca)[_-](?:Browser\/)?([A-Z])([0-9.]*)/i', $ua, $match)) {
					$this->browser->name = 'Obigo ' . $match[1];
					$this->browser->version = new Version(array('value' => $match[2]));
				}
			}

			/****************************************************
			 *		UC Web
			 */
		
			if (preg_match('/UCWEB/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';

				unset($this->browser->channel);
				
				if (preg_match('/UCWEB\/?([0-9]*[.][0-9]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				if (!$this->device->type) {
					$this->device->type = TYPE_MOBILE;
				}

				if (isset($this->os->name) && $this->os->name == 'Linux') {
					$this->os->name = '';
				}
				
				if (preg_match('/^IUC ?\(U; ?iOS ([0-9\._]+);/', $ua, $match)) {
					$this->os->name = 'iOS';
					$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
				}
				
				if (preg_match('/^JUC ?\(Linux; ?U; ?([0-9\.]+)[^;]*; ?[^;]+; ?([^;]*[^\s])\s*; ?[0-9]+\*[0-9]+\)/', $ua, $match)) {
					$this->os->name = 'Android';
					$this->os->version = new Version(array('value' => $match[1]));
					
					$this->device = DeviceModels::identify('android', $match[2]);
				}
				
				if (preg_match('/; Adr ([0-9\.]+); [^;]+; ([^;]*[^\s])\)/', $ua, $match)) {
					$this->os->name = 'Android';
					$this->os->version = new Version(array('value' => $match[1]));
					
					$this->device = DeviceModels::identify('android', $match[2]);
				}

				if (preg_match('/\(iOS;/', $ua)) {
					$this->os->name = 'iOS';
					$this->os->version = new Version(array('value' => '1.0'));
	
					if (preg_match('/OS ([0-9_]*);/', $ua, $match)) {
						$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
					}
				}

				if (preg_match('/\(Windows;/', $ua)) {
					$this->os->name = 'Windows Phone';
					$this->os->version = null;

					if (preg_match('/wds ([0-9]\.[0-9])/', $ua, $match)) {
						switch($match[1]) {
							case '7.0':		$this->os->version = new Version(array('value' => '7.0')); break;
							case '7.1':		$this->os->version = new Version(array('value' => '7.5')); break;
							case '8.0':		$this->os->version = new Version(array('value' => '8.0')); break;
						}
					}
	
					if (preg_match('/; ([^;]+); ([^;]+)\)/', $ua, $match)) {
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

			if (preg_match('/ucweb-squid/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';

				unset($this->browser->channel);
			}

			if (preg_match('/\) UC /', $ua)) {
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

			if (preg_match('/UC ?Browser\/?([0-9.]*)/', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));

				unset($this->browser->channel);

				if (!$this->device->type) {
					$this->device->type = TYPE_MOBILE;
				}
			}

			/* U2 is the Proxy service used by UC Browser on low-end phones */
			if (preg_match('/U2\//', $ua)) {
				$this->engine->name = 'Gecko';
				$this->browser->mode = 'proxy';
				
				/* UC Browser running on Windows 8 is identifing itself as U2, but instead its a Trident Webview */
				if (isset($this->os->name) && isset($this->os->version)) {
					if ($this->os->name == 'Windows Phone' && $this->os->version->toFloat() >= 8) {
						$this->engine->name = 'Trident';
						$this->browser->mode = '';
					}
				}
			}

			/* U3 is the Webkit based Webview used on Android phones */
			if (preg_match('/U3\//', $ua)) {
				$this->engine->name = 'Webkit';
			}

						
			/****************************************************
			 *		NineSky
			 */
		
			if (preg_match('/Ninesky(?:-android-mobile(?:-cn)?)?\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'NineSky';
				$this->browser->version = new Version(array('value' => $match[1]));

				if ($this->os->name != 'Android') {
					$this->os->name = 'Android';
					$this->os->version = null;
					
					$this->device->manufacturer = null;
					$this->device->model = null;
				}
			}

			/****************************************************
			 *		Skyfire
			 */
		
			if (preg_match('/Skyfire\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'Skyfire';
				$this->browser->version = new Version(array('value' => $match[1]));

				$this->device->type = TYPE_MOBILE;

				$this->os->name = 'Android';
				$this->os->version = null;
			}
			
			/****************************************************
			 *		Dolphin HD
			 */
		
			if (preg_match('/DolphinHDCN\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'Dolphin';
				$this->browser->version = new Version(array('value' => $match[1]));

				$this->device->type = TYPE_MOBILE;

				if ($this->os->name != 'Android') {
					$this->os->name = 'Android';
					$this->os->version = null;
				}
			}

			if (preg_match('/Dolphin\/(?:INT|CN)/', $ua, $match)) {
				$this->browser->name = 'Dolphin';
				$this->device->type = TYPE_MOBILE;
			}
			
			/****************************************************
			 *		QQ Browser
			 */
		
			if (preg_match('/(M?QQBrowser)\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'QQ Browser';

				$version = $match[2];
				if (preg_match('/^[0-9][0-9]$/', $version)) $version = $version[0] . '.' . $version[1];
				
				$this->browser->version = new Version(array('value' => $version, 'details' => 2));
				$this->browser->channel = '';
				
				if (!$this->os->name && $match[1] == 'QQBrowser') {
					$this->os->name = 'Windows';
				}
			}	

			/****************************************************
			 *		iBrowser
			 */
		
			if (preg_match('/(iBrowser)\/([0-9.]*)/', $ua, $match) && !preg_match('/OviBrowser/', $ua)) {
				$this->browser->name = 'iBrowser';
				
				$version = $match[2];
				if (preg_match('/^[0-9][0-9]$/', $version)) $version = $version[0] . '.' . $version[1];
				
				$this->browser->version = new Version(array('value' => $version, 'details' => 2));
				$this->browser->channel = '';
			}	

			/****************************************************
			 *		Puffin
			 */
		
			if (preg_match('/Puffin\/([0-9.]*)/', $ua, $match)) {
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
		
			if (preg_match('/Midori\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'Midori';
				$this->browser->version = new Version(array('value' => $match[1]));

				$this->device->manufacturer = null;
				$this->device->model = null;
				$this->device->type = TYPE_DESKTOP;
				
				if ($this->os->name == 'Mac OS X' || $this->os->name == 'OS X') {
					$this->os->name = null;
					$this->os->version = null;
				}
			}	

			if (preg_match('/midori$/', $ua)) {
				$this->browser->name = 'Midori';
			}


			/****************************************************
			 *		MiniBrowser Mobile
			 */
		
			if (preg_match('/MiniBr?owserM(?:obile)?\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'MiniBrowser';
				$this->browser->version = new Version(array('value' => $match[1]));

				$this->os->name = 'Series60';
				$this->os->version = null;
			}
						
			/****************************************************
			 *		Maxthon
			 */
		
			if (preg_match('/Maxthon[\/\' ]\(?([0-9.]*)\)?/', $ua, $match)) {
				$this->browser->name = 'Maxthon';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				$this->browser->channel = '';
				
				if ($this->os->name == 'Windows' && $this->browser->version->toFloat() < 4) {
					$this->browser->version->details = 1;
				}
			}	

			/****************************************************
			 *		Others
			 */

			$browsers = array(
				array('name' => 'AdobeAIR',				'regexp' => '/AdobeAIR\/([0-9.]*)/'),
				array('name' => 'Awesomium',			'regexp' => '/Awesomium\/([0-9.]*)/'),
				array('name' => 'Bsalsa Embedded',		'regexp' => '/EmbeddedWB ([0-9.]*)/'),
				array('name' => 'Bsalsa Embedded',		'regexp' => '/Embedded Web Browser/'),
				array('name' => 'Canvace',				'regexp' => '/Canvace Standalone\/([0-9.]*)/'),
				array('name' => 'Ekioh',				'regexp' => '/Ekioh\/([0-9.]*)/'),
				array('name' => 'JavaFX',				'regexp' => '/JavaFX\/([0-9.]*)/'),
				array('name' => 'GFXe',					'regexp' => '/GFXe\/([0-9.]*)/'),
				array('name' => 'LuaKit',				'regexp' => '/luakit/'),
				array('name' => 'Titanium',				'regexp' => '/Titanium\/([0-9.]*)/'),
				array('name' => 'OpenWebKitSharp',		'regexp' => '/OpenWebKitSharp/'),
				array('name' => 'Prism',				'regexp' => '/Prism\/([0-9.]*)/'),
				array('name' => 'Qt',					'regexp' => '/Qt\/([0-9.]*)/'),
				array('name' => 'QtEmbedded',			'regexp' => '/QtEmbedded/'),
				array('name' => 'QtEmbedded',			'regexp' => '/QtEmbedded.*Qt\/([0-9.]*)/'),
				array('name' => 'RhoSimulator',			'regexp' => '/RhoSimulator/'),
				array('name' => 'UWebKit',				'regexp' => '/UWebKit\/([0-9.]*)/'),
				array('name' => 'Node-WebKit',			'regexp' => '/nw-tests\/([0-9.]*)/'),
				array('name' => 'WebKit2.NET',			'regexp' => '/WebKit2.NET/'),
				
				array('name' => 'PhantomJS',			'regexp' => '/PhantomJS\/([0-9.]*)/'),
				
				array('name' => 'Google Earth',			'regexp' => '/Google Earth\/([0-9.]*)/'),
				array('name' => 'EA Origin',			'regexp' => '/Origin\/([0-9.]*)/'),
				array('name' => 'SecondLife',			'regexp' => '/SecondLife\/([0-9.]*)/'),
				array('name' => 'Valve Steam',			'regexp' => '/Valve Steam/'),
				
				array('name' => 'Bluefish',				'regexp' => '/bluefish ([0-9.]*)/'),
				array('name' => 'Songbird',				'regexp' => '/Songbird\/([0-9.]*)/'),
				array('name' => 'Thunderbird',			'regexp' => '/Thunderbird[\/ ]([0-9.]*)/', 'type' => TYPE_DESKTOP),
				array('name' => 'Microsoft FrontPage',	'regexp' => '/MS FrontPage ([0-9.]*)/', 'details' => 2, 'type' => TYPE_DESKTOP),
				array('name' => 'Microsoft Outlook',	'regexp' => '/Microsoft Outlook IMO, Build ([0-9.]*)/', 'details' => 2, 'type' => TYPE_DESKTOP),
				
				array('name' => '1Browser',				'regexp' => '/1Password\/([0-9.]*)/'),
				array('name' => '360 Extreme Explorer',	'regexp' => '/QIHU 360EE/', 'type' => TYPE_DESKTOP),
				array('name' => '360 Safe Explorer',	'regexp' => '/QIHU 360SE/', 'type' => TYPE_DESKTOP),
				array('name' => '360 Phone Browser',	'regexp' => '/360 Android Phone Browser \(V([0-9.]*)\)/'),
				array('name' => '360 Phone Browser',	'regexp' => '/360 Aphone Browser \(Version ([0-9.]*)\)/'),
				array('name' => 'ABrowse',				'regexp' => '/A[Bb]rowse ([0-9.]*)/'),
				array('name' => 'Abrowser',				'regexp' => '/Abrowser\/([0-9.]*)/'),
				array('name' => 'AltiBrowser',			'regexp' => '/AltiBrowser\/([0-9.]*)/i'),
				array('name' => 'AOL Desktop',			'regexp' => '/AOL ([0-9.]*); AOLBuild/i'),
				array('name' => 'AOL Browser',			'regexp' => '/America Online Browser (?:[0-9.]*); rev([0-9.]*);/i'),
				array('name' => 'Arachne',				'regexp' => '/Arachne\/([0-9.]*)/', 'type' => TYPE_DESKTOP),
				array('name' => 'Arora',				'regexp' => '/[Aa]rora\/([0-9.]*)/'),							// see: www.arora-browser.org
				array('name' => 'Avant Browser',		'regexp' => '/Avant Browser/'),
				array('name' => 'Avant Browser',		'regexp' => '/Avant TriCore/'),
				array('name' => 'Baidu Browser',		'regexp' => '/M?BaiduBrowser\/([0-9.]*)/i'),
				array('name' => 'Baidu Browser',		'regexp' => '/BdMobile\/([0-9.]*)/i'),
				array('name' => 'Baidu Browser',		'regexp' => '/FlyFlow\/([0-9.]*)/', 'details' => 2),
				array('name' => 'Baidu Browser',		'regexp' => '/BIDUBrowser[ \/]([0-9.]*)/'),
				array('name' => 'Baidu Browser',		'regexp' => '/BaiduHD\/([0-9.]*)/', 'details' => 2),
				array('name' => 'Baidu Spark',			'regexp' => '/BDSpark\/([0-9.]*)/', 'details' => 2),
				array('name' => 'Black Wren',			'regexp' => '/BlackWren\/([0-9.]*)/', 'details' => 2),
				array('name' => 'BrightSign', 			'regexp' => '/BrightSign\/([0-9.]*)/', 'type' => TYPE_SIGNAGE),
				array('name' => 'Byffox', 				'regexp' => '/Byffox\/([0-9.]*)/', 'type' => TYPE_DESKTOP),
				array('name' => 'Camino', 				'regexp' => '/Camino\/([0-9.]*)/', 'type' => TYPE_DESKTOP),
				array('name' => 'Canure', 				'regexp' => '/Canure\/([0-9.]*)/', 'details' => 3),
				array('name' => 'CometBird', 			'regexp' => '/CometBird\/([0-9.]*)/'),
				array('name' => 'Comodo Dragon', 		'regexp' => '/Comodo_Dragon\/([0-9.]*)/', 'details' => 2),
				array('name' => 'Conkeror', 			'regexp' => '/[Cc]onkeror\/([0-9.]*)/'),
				array('name' => 'CoolNovo', 			'regexp' => '/(?:CoolNovo|CoolNovoChromePlus)\/([0-9.]*)/', 'details' => 3, 'type' => TYPE_DESKTOP),
				array('name' => 'ChromePlus', 			'regexp' => '/ChromePlus(?:\/([0-9.]*))?$/', 'details' => 3, 'type' => TYPE_DESKTOP),
				array('name' => 'Cunaguaro', 			'regexp' => '/Cunaguaro\/([0-9.]*)/', 'details' => 3, 'type' => TYPE_DESKTOP),
				array('name' => 'Daedalus', 			'regexp' => '/Daedalus ([0-9.]*)/', 'details' => 2),
				array('name' => 'Demobrowser', 			'regexp' => '/demobrowser\/([0-9.]*)/'),
				array('name' => 'Doga Rhodonit', 		'regexp' => '/DogaRhodonit/'),
				array('name' => 'Dooble', 				'regexp' => '/Dooble(?:\/([0-9.]*))?/'),
				array('name' => 'Dorothy', 				'regexp' => '/Dorothy$/'),
				array('name' => 'DWB', 					'regexp' => '/dwb(?:-hg)?(?:\/([0-9.]*))?/'),
				array('name' => 'GNOME Web', 			'regexp' => '/Epiphany\/([0-9.]*)/', 'type' => TYPE_DESKTOP),
				array('name' => 'EVM Browser', 			'regexp' => '/EVMBrowser\/([0-9.]*)/'),
				array('name' => 'FireWeb', 				'regexp' => '/FireWeb\/([0-9.]*)/'),
				array('name' => 'Flock', 				'regexp' => '/Flock\/([0-9.]*)/', 'details' => 3, 'type' => TYPE_DESKTOP),
				array('name' => 'Galeon', 				'regexp' => '/Galeon\/([0-9.]*)/', 'details' => 3),
				array('name' => 'Helium', 				'regexp' => '/HeliumMobileBrowser\/([0-9.]*)/'),
				array('name' => 'Hive Explorer', 		'regexp' => '/HiveE/'),
				array('name' => 'IBrowse', 				'regexp' => '/IBrowse\/([0-9.]*)/', 'type' => TYPE_DESKTOP),
				array('name' => 'iCab', 				'regexp' => '/iCab\/([0-9.]*)/'),
				array('name' => 'Iceape', 				'regexp' => '/Iceape\/([0-9.]*)/'),
				array('name' => 'IceCat', 				'regexp' => '/IceCat[ \/]([0-9.]*)/', 'type' => TYPE_DESKTOP),
				array('name' => 'Comodo IceDragon', 	'regexp' => '/IceDragon\/([0-9.]*)/', 'details' => 2, 'type' => TYPE_DESKTOP),
				array('name' => 'Iceweasel', 			'regexp' => '/Iceweasel\/([0-9.]*)/', 'type' => TYPE_DESKTOP),
				array('name' => 'InternetSurfboard', 	'regexp' => '/InternetSurfboard\/([0-9.]*)/'),
				array('name' => 'Iron', 				'regexp' => '/Iron\/([0-9.]*)/', 'details' => 2),
				array('name' => 'Isis', 				'regexp' => '/BrowserServer/'),
				array('name' => 'Isis', 				'regexp' => '/ISIS\/([0-9.]*)/', 'details' => 2),
				array('name' => 'Jumanji', 				'regexp' => '/jumanji/'),
				array('name' => 'Kazehakase', 			'regexp' => '/Kazehakase\/([0-9.]*)/'),
				array('name' => 'KChrome', 				'regexp' => '/KChrome\/([0-9.]*)/', 'details' => 3),
				array('name' => 'Kiosk', 				'regexp' => '/Kiosk\/([0-9.]*)/'),
				array('name' => 'K-Meleon', 			'regexp' => '/K-Meleon\/([0-9.]*)/', 'type' => TYPE_DESKTOP),
				array('name' => 'Lbbrowser',			'regexp' => '/LBBROWSER/'),
				array('name' => 'Leechcraft', 			'regexp' => '/Leechcraft(?:\/([0-9.]*))?/', 'details' => 2),
				array('name' => 'Lightning', 			'regexp' => '/Lightning\/([0-9.]*)/'),
				array('name' => 'Lobo', 				'regexp' => '/Lobo\/([0-9.]*)/', 'type' => TYPE_DESKTOP),
				array('name' => 'Lotus Expeditor', 		'regexp' => '/Gecko Expeditor ([0-9.]*)/', 'details' => 3),
				array('name' => 'Lunascape', 			'regexp' => '/Lunascape[\/| ]([0-9.]*)/', 'details' => 3),
				array('name' => 'Lynx', 				'regexp' => '/Lynx\/([0-9.]*)/'),
				array('name' => 'iLunascape', 			'regexp' => '/iLunascape\/([0-9.]*)/', 'details' => 3),
				array('name' => 'Intermec Browser', 	'regexp' => '/Intermec\/([0-9.]*)/', 'details' => 2),
				array('name' => 'MaCross Mobile', 		'regexp' => '/MaCross\/([0-9.]*)/'),
				array('name' => 'Mammoth', 				'regexp' => '/Mammoth\/([0-9.]*)/'),										// see: https://itunes.apple.com/cn/app/meng-ma-liu-lan-qi/id403760998?mt=8
				array('name' => 'Mercury Browser', 		'regexp' => '/Mercury\/([0-9.]*)/'),
				array('name' => 'MixShark', 			'regexp' => '/MixShark\/([0-9.]*)/'),
				array('name' => 'mlbrowser',			'regexp' => '/mlbrowser/'),
				array('name' => 'Motorola WebKit', 		'regexp' => '/MotorolaWebKit(?:\/([0-9.]*))?/', 'details' => 3),
				array('name' => 'NetFront LifeBrowser', 'regexp' => '/NetFrontLifeBrowser\/([0-9.]*)/'),
				array('name' => 'NetPositive', 			'regexp' => '/NetPositive\/([0-9.]*)/'),
				array('name' => 'Netscape Navigator', 	'regexp' => '/Navigator\/([0-9.]*)/', 'details' => 3),
				array('name' => 'Odyssey', 				'regexp' => '/OWB\/([0-9.]*)/'),
				array('name' => 'OmniWeb', 				'regexp' => '/OmniWeb/', 'type' => TYPE_DESKTOP),
				array('name' => 'OneBrowser', 			'regexp' => '/OneBrowser\/([0-9.]*)/'),
				array('name' => 'Openwave',				'regexp' => '/Openwave\/([0-9.]*)/', 'details' => 2),
				array('name' => 'Orca', 				'regexp' => '/Orca\/([0-9.]*)/'),
				array('name' => 'Origyn', 				'regexp' => '/Origyn Web Browser/'),
				array('name' => 'Otter', 				'regexp' => '/Otter Browser\/([0-9.]*)/'),
				array('name' => 'Palemoon', 			'regexp' => '/Pale[mM]oon\/([0-9.]*)/'),
				array('name' => 'Phantom', 				'regexp' => '/Phantom\/V([0-9.]*)/'),
				array('name' => 'Polaris', 				'regexp' => '/Polaris[\/ ]v?([0-9.]*)/i', 'details' => 2),
				array('name' => 'Qihoo 360', 			'regexp' => '/QIHU THEWORLD/'),
				array('name' => 'QtCreator', 			'regexp' => '/QtCreator\/([0-9.]*)/'),
				array('name' => 'QtQmlViewer', 			'regexp' => '/QtQmlViewer/'),
				array('name' => 'QtTestBrowser', 		'regexp' => '/QtTestBrowser\/([0-9.]*)/'),
				array('name' => 'QtWeb', 				'regexp' => '/QtWeb Internet Browser\/([0-9.]*)/'),
				array('name' => 'QupZilla', 			'regexp' => '/QupZilla\/([0-9.]*)/', 'type' => TYPE_DESKTOP),				
				array('name' => 'Ryouko', 				'regexp' => '/Ryouko\/([0-9.]*)/', 'type' => TYPE_DESKTOP),						// see: https://github.com/foxhead128/ryouko
				array('name' => 'Roccat', 				'regexp' => '/Roccat\/([0-9]\.[0-9.]*)/'),
				array('name' => 'Raven for Mac', 		'regexp' => '/Raven for Mac\/([0-9.]*)/'),
				array('name' => 'rekonq', 				'regexp' => '/rekonq(?:\/([0-9.]*))?/', 'type' => TYPE_DESKTOP),
				array('name' => 'RockMelt', 			'regexp' => '/RockMelt\/([0-9.]*)/', 'details' => 2),
				array('name' => 'SaaYaa Explorer', 		'regexp' => '/SaaYaa/', 'type' => TYPE_DESKTOP),
				array('name' => 'Sleipnir', 			'regexp' => '/Sleipnir\/([0-9.]*)/', 'details' => 3),
				array('name' => 'SlimBoat', 			'regexp' => '/SlimBoat\/([0-9.]*)/'),
				array('name' => 'SMBrowser', 			'regexp' => '/SMBrowser/'),
				array('name' => 'Sogou Explorer', 		'regexp' => '/SE 2.X MetaSr/', 'type' => TYPE_DESKTOP),
				array('name' => 'Sogou Mobile',			'regexp' => '/SogouMobileBrowser\/([0-9.]*)/', 'details' => 2),
				array('name' => 'Snowshoe', 			'regexp' => '/Snowshoe\/([0-9.]*)/', 'details' => 2),
				array('name' => 'Sputnik', 				'regexp' => '/Sputnik\/([0-9.]*)/i', 'details' => 3),
				array('name' => 'Stainless', 			'regexp' => '/Stainless\/([0-9.]*)/'),
				array('name' => 'SunChrome', 			'regexp' => '/SunChrome\/([0-9.]*)/'),
				array('name' => 'Surf', 				'regexp' => '/Surf\/([0-9.]*)/'),
				array('name' => 'The World', 			'regexp' => '/TheWorld ([0-9.]*)/'),
				array('name' => 'TaoBrowser', 			'regexp' => '/TaoBrowser\/([0-9.]*)/', 'details' => 2),
				array('name' => 'TaomeeBrowser', 		'regexp' => '/TaomeeBrowser\/([0-9.]*)/', 'details' => 2),
				array('name' => 'TazWeb', 				'regexp' => '/TazWeb/'),
				array('name' => 'Tencent Traveler', 	'regexp' => '/TencentTraveler ([0-9.]*)/', 'details' => 2),
				array('name' => 'UP.Browser', 			'regexp' => '/UP\.Browser\/([a-z0-9.]*)/', 'details' => 2),
				array('name' => 'Uzbl', 				'regexp' => '/^Uzbl/'),
				array('name' => 'Viera', 				'regexp' => '/Viera\/([0-9.]*)/'),
				array('name' => 'Villanova', 			'regexp' => '/Villanova\/([0-9.]*)/', 'details' => 3),
				array('name' => 'Waterfox', 			'regexp' => '/Waterfox\/([0-9.]*)/', 'details' => 2, 'type' => TYPE_DESKTOP),
				array('name' => 'Wavelink Velocity',	'regexp' => '/Wavelink Velocity Browser\/([0-9.]*)/', 'details' => 2),
				array('name' => 'WebLite', 				'regexp' => '/WebLite\/([0-9.]*)/', 'type' => TYPE_MOBILE),
				array('name' => 'WebPositive', 			'regexp' => '/WebPositive/'),
				array('name' => 'WebRender', 			'regexp' => '/WebRender/'),
				array('name' => 'Webster', 				'regexp' => '/Webster ([0-9.]*)/'),
				array('name' => 'Wyzo', 				'regexp' => '/Wyzo\/([0-9.]*)/', 'details' => 3),
				array('name' => 'Miui Browser', 		'regexp' => '/XiaoMi\/MiuiBrowser\/([0-9.]*)/'),
				array('name' => 'Yandex Browser', 		'regexp' => '/YaBrowser\/([0-9.]*)/', 'details' => 2),
				array('name' => 'Yelang', 				'regexp' => '/Yelang\/([0-9.]*)/', 'details' => 3),							// see: wellgo.org
				array('name' => 'YRC Weblink', 			'regexp' => '/YRCWeblink\/([0-9.]*)/'),
				array('name' => 'Zetakey', 				'regexp' => '/Zetakey Webkit\/([0-9.]*)/'),
				array('name' => 'Zetakey', 				'regexp' => '/Zetakey\/([0-9.]*)/'),
				
				array('name' => 'Nimbus', 				'regexp' => '/Nimbus\/([0-9.]*)/'),

				array('name' => 'McAfee Web Gateway', 	'regexp' => '/Webwasher\/([0-9.]*)/'),
				
				array('name' => 'Open Sankoré', 		'regexp' => '/Open-Sankore\/([0-9.]*)/', 'type' => TYPE_WHITEBOARD),
				array('name' => 'Coship MMCP', 			'regexp' => '/Coship_MMCP_([0-9.]*)/', 'type' => TYPE_SIGNAGE),
				
				array('name' => '80legs', 				'regexp' => '/008\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'Ask Jeeves', 			'regexp' => '/Ask Jeeves\/Teoma/', 'type' => TYPE_BOT),
				array('name' => 'Baiduspider', 			'regexp' => '/Baiduspider[\+ ]\([\+ ]/', 'type' => TYPE_BOT),
				array('name' => 'Baiduspider', 			'regexp' => '/Baiduspider\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'Bing', 				'regexp' => '/bingbot\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'Bing', 				'regexp' => '/msnbot\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'Bing Preview', 		'regexp' => '/BingPreview\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'Bloglines', 			'regexp' => '/Bloglines\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'Googlebot', 			'regexp' => '/Google[Bb]ot\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'Google App Engine', 	'regexp' => '/AppEngine-Google/', 'type' => TYPE_BOT),
				array('name' => 'Google Web Preview',	'regexp' => '/Google Web Preview/', 'type' => TYPE_BOT),
				array('name' => 'Google Page Speed',	'regexp' => '/Google Page Speed Insights/', 'type' => TYPE_BOT),
				array('name' => 'Google Feed Fetcher',	'regexp' => '/FeedFetcher-Google/', 'type' => TYPE_BOT),
				array('name' => 'Google Font Analysis', 'regexp' => '/Google-FontAnalysis\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'Grub', 				'regexp' => '/grub-client-([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'HeartRails Capture', 	'regexp' => '/HeartRails_Capture\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'CiteSeerX',			'regexp' => '/heritrix\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'Sogou Web Spider',		'regexp' => '/Sogou web spider\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'Yahoo Slurp', 			'regexp' => '/Yahoo\! Slurp\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'Wget', 				'regexp' => '/Wget\/([0-9.]*)/', 'type' => TYPE_BOT)
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
	
			if (preg_match('/WebKit\/([0-9.]*)/i', $ua, $match)) {
				$this->engine->name = 'Webkit';
				$this->engine->version = new Version(array('value' => $match[1]));

				if (preg_match('/(?:Chrome|Chromium)\/([0-9]*)/', $ua, $match)) {
					if (intval($match[1]) >= 27) {
						$this->engine->name = 'Blink';
					}
				}
			}

			if (preg_match('/Browser\/AppleWebKit([0-9.]*)/i', $ua, $match)) {
				$this->engine->name = 'Webkit';
				$this->engine->version = new Version(array('value' => $match[1]));
			}

			if (preg_match('/AppleWebkit\(like Gecko\)/i', $ua, $match)) {
				$this->engine->name = 'Webkit';
			}


			/****************************************************
			 *		KHTML
			 */
		
			if (preg_match('/KHTML\/([0-9.]*)/', $ua, $match)) {
				$this->engine->name = 'KHTML';
				$this->engine->version = new Version(array('value' => $match[1]));
			}

			/****************************************************
			 *		Gecko
			 */
		
			if (preg_match('/Gecko/', $ua) && !preg_match('/like Gecko/', $ua)) {
				$this->engine->name = 'Gecko';

				if (preg_match('/; rv:([^\)]+)\)/', $ua, $match)) {
					$this->engine->version = new Version(array('value' => $match[1]));
				}
			}

			/****************************************************
			 *		Presto
			 */
		
			if (preg_match('/Presto\/([0-9.]*)/', $ua, $match)) {
				$this->engine->name = 'Presto';
				$this->engine->version = new Version(array('value' => $match[1]));
			}

			/****************************************************
			 *		Trident
			 */
		
			if (preg_match('/Trident\/([0-9.]*)/', $ua, $match)) {
				$this->engine->name = 'Trident';
				$this->engine->version = new Version(array('value' => $match[1]));

				
				if ($this->browser->name == 'Internet Explorer') {
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

				if ($this->os->name == 'Windows Phone') {
					if ($this->engine->version->toNumber() == 6 && $this->browser->version->toFloat() < 8) {
						$this->os->version = new Version(array('value' => '8.0'));
					}

					if ($this->engine->version->toNumber() == 5 && $this->browser->version->toFloat() < 7.5) {
						$this->os->version = new Version(array('value' => '7.5'));
					}
				}
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
				if ($this->os->name == 'iOS' && $this->browser->name == 'Opera Mini') {
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
				
			
			if (isset($this->browser->name) && $this->browser->name == 'Opera' && $this->device->type == TYPE_TELEVISION) {
				$this->browser->name = 'Opera Devices';
				
				if (preg_match('/Presto\/([0-9]+\.[0-9]+)/', $ua, $match)) {
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
				
				unset($this->os->name);
				unset($this->os->version);
			}
			
			if (isset($this->browser->name)) {
				if ($this->browser->name == 'UC Browser') {
					if ($this->device->type == 'desktop' || (isset($this->os->name) && ($this->os->name == 'Windows' || $this->os->name == 'Mac OS X'))) {
						$this->device->type = TYPE_MOBILE;
						
						$this->browser->mode = 'desktop';
						
						unset($this->engine->name);
						unset($this->engine->version);
						unset($this->os->name);
						unset($this->os->version);
					}
				
					else if (!isset($this->os->name) || ($this->os->name != 'iOS' && $this->os->name != 'Windows Phone' && $this->os->name != 'Android' && $this->os->name != 'Aliyun OS')) {
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
			
			if (isset($this->device->flag) && $this->device->flag == FLAG_GOOGLETV) {
				$this->os->name = 'Google TV';

				unset($this->os->version);	
				unset($this->device->flag);			
			}

			if (isset($this->device->flag) && $this->device->flag == FLAG_GOOGLEGLASS) {
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
				if (preg_match('/^[a-z][a-z]-[a-z][a-z]$/', $this->device->model)) {
					$this->device->model = null;
				}
			}
			
			
			if (isset($this->os->name) && $this->os->name == 'Android') {
				if (preg_match('/Build\/([^\);]+)/', $ua, $match)) {
					$version = BuildIds::identify('android', $match[1]);
					
					if ($version) {
						if (!isset($this->os->version) || $this->os->version == null || $this->os->version->value == null || $version->toFloat() < $this->os->version->toFloat()) {		
							$this->os->version = $version;
						}
					}
					
					$this->os->build = $match[1];
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
				return new Version(array('value' => $list[$id])); 
			}
			
			return false;
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
				case 'firefoxos': 	return DeviceModels::identifyList(DeviceModels::$FIREFOXOS_MODELS, $model);
				case 'ios':			return DeviceModels::identifyIOS($model);
				case 'tizen': 		return DeviceModels::identifyList(DeviceModels::$TIZEN_MODELS, $model);
				case 'touchwiz': 	return DeviceModels::identifyList(DeviceModels::$TOUCHWIZ_MODELS, $model);
				case 'wm': 			return DeviceModels::identifyList(DeviceModels::$WINDOWS_MOBILE_MODELS, $model);
				case 'wp': 			return DeviceModels::identifyList(DeviceModels::$WINDOWS_PHONE_MODELS, $model);
				case 's40': 		return DeviceModels::identifyList(DeviceModels::$S40_MODELS, $model);
				case 's60': 		return DeviceModels::identifyList(DeviceModels::$S60_MODELS, $model);
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
				if (preg_match('/AndroVM/i', $model)  || $model == 'Emulator' || $model == 'x86 Emulator' || $model == 'x86 VirtualBox' || $model == 'vm') {
					return (object) array(
						'type'			=> TYPE_EMULATOR,
						'identified'	=> ID_PATTERN,
						'manufacturer'	=> null,
						'model'			=> null
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
				'model'			=> 'BlackBerry ' . $model
			);

			if (isset(DeviceModels::$BLACKBERRY_MODELS[$model])) {
				$device->model = 'BlackBerry ' . DeviceModels::$BLACKBERRY_MODELS[$model] . ' ' . $model;
				$device->identified |= ID_MATCH_UA;
			}

			return $device;
		}
		
		static function identifyList($list, $model) {
			$model = DeviceModels::cleanup($model);
			
			$device = (object) array(
				'type'			=> TYPE_MOBILE,
				'identified'	=> ID_NONE,
				'manufacturer'	=> null,
				'model'			=> $model
			);

			foreach ($list as $m => $v) {
				$match = false;
				if (substr($m, -1) == "!") 
					$match = preg_match('/^' . substr($m, 0, -1) . '/i', $model);
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
			$s = preg_replace('/\/[^\/]+$/', '', $s);
			$s = preg_replace('/\/[^\/]+ Android\/.*/', '', $s);
			
			$s = preg_replace('/UCBrowser$/', '', $s);

			$s = preg_replace('/_TD$/', '', $s);
			$s = preg_replace('/_CMCC$/', '', $s);
			
			$s = preg_replace('/_/', ' ', $s);
			$s = preg_replace('/^\s+|\s+$/', '', $s);
			
			$s = preg_replace('/^tita on /', '', $s);
			$s = preg_replace('/^De-Sensed /', '', $s);
			$s = preg_replace('/^ICS AOSP on /', '', $s);
			$s = preg_replace('/^Baidu Yi on /', '', $s);
			$s = preg_replace('/^Buildroid for /', '', $s);
			$s = preg_replace('/^Gingerbread on /', '', $s);			
			$s = preg_replace('/^Android (on |for )/', '', $s);
			$s = preg_replace('/^Generic Android on /', '', $s);
			$s = preg_replace('/^Full JellyBean( on )?/', '', $s);			
			$s = preg_replace('/^Full (AOSP on |Android on |Cappuccino on |MIPS Android on |Android)/', '', $s);
			$s = preg_replace('/^AOSP on /', '', $s);			

			$s = preg_replace('/^Acer( |-)?/i', '', $s);
			$s = preg_replace('/^Iconia( Tab)? /', '', $s);
			$s = preg_replace('/^ASUS ?/', '', $s);
			$s = preg_replace('/^Ainol /', '', $s);
			$s = preg_replace('/^Coolpad ?/i', 'Coolpad ', $s);
			$s = preg_replace('/^ALCATEL /', '', $s);
			$s = preg_replace('/^Alcatel OT-(.*)/', 'one touch $1', $s);
			$s = preg_replace('/^YL-/', '', $s);
			$s = preg_replace('/^Novo7 ?/i', 'Novo7 ', $s);
			$s = preg_replace('/^G[iI]ONEE[ -]/', '', $s);
			$s = preg_replace('/^HW-/', '', $s);
			$s = preg_replace('/^Huawei[ -]/i', 'Huawei ', $s);
			$s = preg_replace('/^SAMSUNG[ -]/i', '', $s);
			$s = preg_replace('/^SAMSUNG SAMSUNG-/i', '', $s);
			$s = preg_replace('/^(Sony ?Ericsson|Sony)/', '', $s);
			$s = preg_replace('/^(Lenovo Lenovo|LNV-Lenovo|LENOVO-Lenovo)/', 'Lenovo', $s);
			$s = preg_replace('/^Lenovo-/', 'Lenovo', $s);
			$s = preg_replace('/^ZTE-/', 'ZTE ', $s);
			$s = preg_replace('/^(LG)[ _\/]/', '$1-', $s);
			$s = preg_replace('/^(HTC.+)\s[v|V][0-9.]+$/', '$1', $s);
			$s = preg_replace('/^(HTC)[-\/]/', '$1', $s);
			$s = preg_replace('/^(HTC)([A-Z][0-9][0-9][0-9])/', '$1 $2', $s);
			$s = preg_replace('/^(Motorola[\s|-])/', '', $s);
			$s = preg_replace('/^(Moto|MOT-)/', '', $s);

			$s = preg_replace('/-?(orange(-ls)?|vodafone|bouygues|parrot|Kust)$/i', '', $s);
			$s = preg_replace('/http:\/\/.+$/i', '', $s);
			$s = preg_replace('/^\s+|\s+$/', '', $s);
			
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
				if (isset($options['details'])) $this->details = $options['details'];
			}
		}
		
		function toFloat() {
			return floatval($this->value);
		}

		function toNumber() {
			return intval($this->value);
		}
	}
