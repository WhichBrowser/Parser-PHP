<?php

	namespace WhichBrowser;

	use WhichBrowser\Constants;

	trait AnalyserBaidu {

		private function analyseBaiduHeader($ua) {
			if (!isset($this->browser->name) || $this->browser->name != 'Baidu Browser') {
				$this->browser->name = 'Baidu Browser';
				$this->browser->version = null;
				$this->browser->stock = false;
			}
		}
	}