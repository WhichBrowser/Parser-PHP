<?php

	namespace WhichBrowser;

	use WhichBrowser\Constants;


	include_once 'analyser/baidu.php';
	include_once 'analyser/browser-id.php';
	include_once 'analyser/camouflage.php';
	include_once 'analyser/opera-mini.php';
	include_once 'analyser/puffin.php';
	include_once 'analyser/uc.php';
	include_once 'analyser/useragent.php';
	include_once 'analyser/wap.php';


	class Analyser {

		use Analyser\Baidu, Analyser\BrowserId, Analyser\Camouflage, Analyser\OperaMini, Analyser\Puffin, 
			Analyser\UC, Analyser\Useragent, Analyser\Wap;


		public function __construct($options) {
			if (is_string($options)) 
				$this->options = (object) [ 'headers' => [ 'User-Agent' => $options ] ];
			else
				$this->options = (object) (isset($options['headers']) ? $options : [ 'headers' => $options ]);

			$this->headers = [];
			if (isset($this->options->headers)) $this->headers = $this->options->headers;


			/* Analyse the main useragent header */

			$this->analyseUserAgent($this->hasHeader('User-Agent') ? $this->getHeader('User-Agent') : '');


			/* Analyse secondary useragent headers */

			if ($this->hasHeader('X-Original-User-Agent')) 
				$this->additionalUserAgent($this->getHeader('X-Original-User-Agent'));
			
			if ($this->hasHeader('X-Device-User-Agent')) 
				$this->additionalUserAgent($this->getHeader('X-Device-User-Agent'));
			
			if ($this->hasHeader('Device-Stock-UA')) 
				$this->additionalUserAgent($this->getHeader('Device-Stock-UA'));
			
			if ($this->hasHeader('X-OperaMini-Phone-UA')) 
				$this->additionalUserAgent($this->getHeader('X-OperaMini-Phone-UA'));

			if ($this->hasHeader('X-UCBrowser-Device-UA')) 
				$this->additionalUserAgent($this->getHeader('X-UCBrowser-Device-UA'));
			

			/* Analyse browser specific headers */

			if ($this->hasHeader('X-OperaMini-Phone')) 
				$this->analyseOperaMiniPhone($this->getHeader('X-OperaMini-Phone'));
			
			if ($this->hasHeader('X-UCBrowser-Phone-UA')) 
				$this->analyseOldUCUserAgent($this->getHeader('X-UCBrowser-Phone-UA'));
			
			if ($this->hasHeader('X-UCBrowser-UA')) 
				$this->analyseNewUCUserAgent($this->getHeader('X-UCBrowser-UA'));
			
			if ($this->hasHeader('X-Puffin-UA')) 
				$this->analysePuffinUserAgent($this->getHeader('X-Puffin-UA'));
			
			if ($this->hasHeader('Baidu-FlyFlow')) 
				$this->analyseBaiduHeader($this->getHeader('Baidu-FlyFlow'));
			

			/* Analyse Android WebView browser ids */

			if ($this->hasHeader('X-Requested-With')) 
				$this->analyseBrowserId($this->getHeader('X-Requested-With'));
			

			/* Analyse WAP profile header */

			if ($this->hasHeader('X-Wap-Profile')) 
				$this->analyseWapProfile($this->getHeader('X-Wap-Profile'));


			/* Detect if the browser is camouflaged */

			$this->detectCamouflage();


			/* Determine subtype of mobile devices */

			if ($this->device->type == 'mobile') {
				$this->device->subtype = 'feature';

				if (isset($this->os->family) && in_array($this->os->family->getName(), [ 'Android' ])) {
					$this->device->subtype = 'smart';
				}

				if (in_array($this->os->getName(), [ 'Android', 'Bada', 'BlackBerry', 'BlackBerry OS', 'Firefox OS', 'iOS', 'iPhone OS', 'Kin OS', 'Maemo', 'MeeGo', 'Palm OS', 'Sailfish', 'Series60', 'Tizen', 'Ubuntu', 'Windows Mobile', 'Windows Phone', 'webOS' ])) {
					$this->device->subtype = 'smart';
				}
			}
		}

		private function hasHeader($h) {
			foreach ($this->headers as $k => $v) {
				if (strtolower($h) == strtolower($k)) return true;
			}

			return false;
		}

		private function getHeader($h) {
			foreach ($this->headers as $k => $v) {
				if (strtolower($h) == strtolower($k)) return $v;
			}
		}

		private function additionalUserAgent($ua) {
			$extra = new Parser($ua);

			if ($extra->device->type != Constants\DeviceType::DESKTOP) {
				if (isset($extra->os->name)) $this->os = $extra->os;
				if ($extra->device->identified) $this->device = $extra->device;
			}
		}
	}	

