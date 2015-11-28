<?php

	namespace WhichBrowser\Analyser;

	include_once 'Header/Baidu.php';
	include_once 'Header/BrowserId.php';
	include_once 'Header/OperaMini.php';
	include_once 'Header/Puffin.php';
	include_once 'Header/UC.php';
	include_once 'Header/Useragent.php';
	include_once 'Header/Wap.php';

	trait Header {

		use Header\Baidu, Header\BrowserId, Header\OperaMini, Header\Puffin, 
			Header\UC, Header\Useragent, Header\Wap;

		private function analyseHeaders() {

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
	}