<?php

	namespace WhichBrowser\Analyser;

	use WhichBrowser\Constants;
	use WhichBrowser\Family;
	use WhichBrowser\Using;
	use WhichBrowser\Version;

	trait Derive {

		private function deriveInformation() {
			if (isset($this->device->flag)) $this->deriveBasedOnDeviceFlag();
			if (isset($this->os->name)) $this->deriveBasedOnOperatingSystem();
		}


		private function deriveDeviceSubType() {
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


		private function deriveBasedOnDeviceFlag() {
			if ($this->device->flag == Constants\Flag::NOKIAX) {
				$this->os->name = 'Nokia X Platform';
				$this->os->family = new Family([ 'name' => 'Android' ]);

				unset($this->os->version);
				unset($this->device->flag);
				return;
			}

			if ($this->device->flag == Constants\Flag::FIREOS) {
				$this->os->name = 'FireOS';
				$this->os->family = new Family([ 'name' => 'Android' ]);

				if (isset($this->os->version) && isset($this->os->version->value)) {
					switch($this->os->version->value) {
						case '2.3.3':	$this->os->version = new Version([ 'value' => '1' ]); break;
						case '4.0.3':	$this->os->version = new Version([ 'value' => '2' ]); break;
						case '4.2.2':	$this->os->version = new Version([ 'value' => '3' ]); break;
						case '4.4.2':	$this->os->version = new Version([ 'value' => '4' ]); break;
						case '4.4.3':	$this->os->version = new Version([ 'value' => '4.5' ]); break;
						case '5.1.1':	$this->os->version = new Version([ 'value' => '5' ]); break;
						default:		unset($this->os->version); break;
					}
				}

				if ($this->isBrowser('Chrome')) {
					$this->browser->using = new Using([ 'name' => 'Amazon WebView' ]); 

					$this->browser->stock = false;
					$this->browser->name = null;
					$this->browser->version = null;
					$this->browser->channel = null;
				}

				if ($this->browser->isUsing('Chromium WebView')) {
					$this->browser->using = new Using([ 'name' => 'Amazon WebView' ]); 
				}

				unset($this->device->flag);
				return;
			}

			if ($this->device->flag == Constants\Flag::GOOGLETV) {
				$this->os->name = 'Google TV';
				$this->os->family = new Family([ 'name' => 'Android' ]);

				unset($this->os->version);
				unset($this->device->flag);
				return;
			}

			if ($this->device->flag == Constants\Flag::ANDROIDTV) {
				$this->os->name = 'Android TV';
				$this->os->family = new Family([ 'name' => 'Android' ]);

				unset($this->device->flag);
				return;
			}

			if ($this->device->flag == Constants\Flag::ANDROIDWEAR) {
				$this->os->name = 'Android Wear';
				$this->os->family = new Family([ 'name' => 'Android' ]);
				unset($this->os->version);

				if (preg_match('/Chrome\/19\.77\.34\.5/u', $ua)) {
					$this->browser->name = "Wear Internet Browser";
					$this->browser->version = null;
				}
				else {
					$this->browser->stock = true;
					$this->browser->hidden = true;
				}

				unset($this->browser->channel);
				unset($this->device->flag);
				return;
			}

			if ($this->device->flag == Constants\Flag::GOOGLEGLASS) {
				$this->os->family = new Family([ 'name' => 'Android' ]);
				unset($this->os->name);
				unset($this->os->version);
				unset($this->device->flag);
				return;
			}
		}

		private function deriveBasedOnOperatingSystem() {
			if ($this->os->name == 'Android' && !isset($this->browser->using) && !isset($this->browser->name) && $this->browser->stock) {
				$this->browser->name = 'Android Browser';
			}

			if ($this->os->name == 'Aliyun OS' && !isset($this->browser->using) && !isset($this->browser->name) && $this->browser->stock) {
				$this->browser->name = 'Aliyun Browser';
			}

			if ($this->os->name == 'Google TV' && !isset($this->browser->name) && $this->browser->stock) {
				$this->browser->name = 'Chrome';
			}

			if ($this->os->name == 'BlackBerry' && !isset($this->browser->name) && $this->browser->stock) {
				$this->browser->name = 'BlackBerry Browser';
				$this->browser->hidden = true;
			}

			if ($this->os->name == 'BlackBerry OS' && !isset($this->browser->name) && $this->browser->stock) {
				$this->browser->name = 'BlackBerry Browser';
				$this->browser->hidden = true;
			}

			if ($this->os->name == 'BlackBerry Tablet OS' && !isset($this->browser->name) && $this->browser->stock) {
				$this->browser->name = 'BlackBerry Browser';
				$this->browser->hidden = true;
			}

			if ($this->os->name == 'Tizen' && !isset($this->browser->name) && $this->browser->stock && $this->device->type == Constants\DeviceType::MOBILE) {
				$this->browser->name = 'Samsung Browser';
			}

			if ($this->os->name == 'Aliyun OS' && $this->browser->stock) {
				$this->browser->hidden = true;
			}

			if ($this->os->name == 'Darwin' && $this->device->type == Constants\DeviceType::MOBILE) {
				$this->os->name = 'iOS';

				switch (strstr($this->os->getVersion(), '.', true)) {
					case '9':		$this->os->version = new Version([ 'value' =>'1' ]); $this->os->alias = 'iPhone OS'; break;
					case '10':		$this->os->version = new Version([ 'value' =>'4' ]); break;
					case '11':		$this->os->version = new Version([ 'value' =>'5' ]); break;
					case '13':		$this->os->version = new Version([ 'value' =>'6' ]); break;
					case '14':		$this->os->version = new Version([ 'value' =>'7' ]); break;
					case '15':		$this->os->version = new Version([ 'value' =>'9' ]); break;
					default:		$this->os->version = null;
				}
			}

			if ($this->os->name == 'Darwin' && $this->device->type == Constants\DeviceType::DESKTOP) {
				$this->os->name = 'OS X';

				switch (strstr($this->os->getVersion(), '.', true)) {
					case '1':		$this->os->version = new Version([ 'value' =>'10.0' ]); break;
					case '5':		$this->os->version = new Version([ 'value' =>'10.1' ]); break;
					case '6':		$this->os->version = new Version([ 'value' =>'10.2' ]); break;
					case '7':		$this->os->version = new Version([ 'value' =>'10.3' ]); break;
					case '8':		$this->os->version = new Version([ 'value' =>'10.4' ]); break;
					case '9':		$this->os->version = new Version([ 'value' =>'10.5' ]); break;
					case '10':		$this->os->version = new Version([ 'value' =>'10.6' ]); break;
					case '11':		$this->os->version = new Version([ 'value' =>'10.7' ]); break;
					case '12':		$this->os->version = new Version([ 'value' =>'10.8' ]); break;
					case '13':		$this->os->version = new Version([ 'value' =>'10.9' ]); break;
					case '14':		$this->os->version = new Version([ 'value' =>'10.10' ]); break;
					case '15':		$this->os->version = new Version([ 'value' =>'10.11' ]); break;
					default:		$this->os->version = null;
				}

				if (!empty($this->os->version)) {
					if ($this->os->version->is('<', '10.7')) $this->os->alias = 'Mac OS X';
					if ($this->os->version->is('10.7')) $this->os->version->nickname = 'Lion';
					if ($this->os->version->is('10.8')) $this->os->version->nickname = 'Mountain Lion';
					if ($this->os->version->is('10.9')) $this->os->version->nickname = 'Mavericks';
					if ($this->os->version->is('10.10')) $this->os->version->nickname = 'Yosemite';
					if ($this->os->version->is('10.11')) $this->os->version->nickname = 'El Capitan';
				}
			}	
		}
	}