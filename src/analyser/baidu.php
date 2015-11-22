<?php

	namespace WhichBrowser\Analyser;

	use WhichBrowser\Constants;

	trait Baidu {

		private function analyseBaiduHeader($ua) {
			if (!isset($this->browser->name) || $this->browser->name != 'Baidu Browser') {
				$this->browser->name = 'Baidu Browser';
				$this->browser->version = null;
				$this->browser->stock = false;
			}
		}
	}