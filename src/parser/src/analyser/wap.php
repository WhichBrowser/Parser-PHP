<?php

	namespace WhichBrowser\Analyser;

	use WhichBrowser\Constants;
	use WhichBrowser\Data;

	trait Wap {
		
		private function analyseWapProfile($url) {
			$url = trim($url);

			if ($url[0] == '"') {
				$url = explode(",", $url);
				$url = trim($url[0], '"');
			}

			$result = Data\DeviceProfiles::identify($url);

			if ($result) {
				if ($result[0] && $result[1]) {
					$this->device->manufacturer = $result[0];
					$this->device->model = $result[1];
					$this->device->identified |= Constants\Id::MATCH_PROF;
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
	}