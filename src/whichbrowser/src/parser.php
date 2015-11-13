<?php

	namespace WhichBrowser;

	include_once 'constants.php';
	include_once 'primitives.php';
	include_once 'engine.php';
	include_once 'data.php';

	class Parser extends ParserEngine {

		public function __construct($options) {
			$this->browser = new Browser();
			$this->engine = new Engine();
			$this->os = new Os();
			$this->device = new Device();
			$this->camouflage = false;
			$this->features = [];

			parent::__construct($options);
		}

		public function isBrowser() {

		}

		public function isEngine() {

		}

		public function isOs() {

		}

		public function isDevice() {

		}

		public function isType() {

		}

		private function a($s) {
			return (preg_match("/^[aeiou]/i", $s) ? 'an ' : 'a ') . $s;
		}

		public function toString() {
			$prefix = $this->camouflage ? 'an unknown browser that imitates ' : '';
			$browser = $this->browser->toString();
			$os = $this->os->toString();
			$engine = $this->engine->toString();
			$device = $this->device->toString();
			
			if (empty($device) && empty($os) && $this->device->type == 'television') $device = 'television';
			if (empty($device) && $this->device->type == 'emulator') $device = 'emulator';
		
			if (!empty($browser) && !empty($os) && !empty($device)) return $prefix . $browser . ' on ' . $this->a($device) . ' running ' . $os;
			if (!empty($browser) && empty($os) && !empty($device)) return $prefix . $browser . ' on ' . $this->a($device);
			if (!empty($browser) && !empty($os) && empty($device)) return $prefix . $browser . ' on ' . $os;
			if (empty($browser) && !empty($os) && !empty($device)) return $prefix . $this->a($device) . ' running ' . $os;
			if (!empty($browser) && empty($os) && empty($device)) return $prefix . $browser;
			if (empty($browser) && empty($os) && !empty($device)) return $prefix . $this->a($device);
			if ($this->device->type == 'desktop' && !empty($os) && !empty($engine) && empty($device)) return 'an unknown browser based on ' . $engine + ' running on ' + $os;
			if ($this->browser->stock && !empty($os) && empty($device)) return $os;
			if ($this->browser->stock && !empty($engine) && empty($device)) return 'an unknown browser based on ' . $engine;
			
			return 'an unknown browser';
		}

		public function toJavaScript() {
			echo "this.browser = new Browser({ " . $this->browser->toJavaScript() . " });\n";
			echo "this.engine = new Engine({ " . $this->engine->toJavaScript() . " });\n";
			echo "this.engine = new Engine({ " . $this->engine->toJavaScript() . " });\n";
			echo "this.os = new Os({ " . $this->os->toJavaScript() . " });\n";
			echo "this.device = new Device({ " . $this->device->toJavaScript() . " });\n";
			echo "this.camouflage = " . ($this->camouflage ? 'true' : 'false') . ";\n";
			echo "this.features = " . json_encode($this->features) . ";\n";
		}

		public function toArray() {
			$result = [
				'browser'	=> $this->browser->toArray(),
				'engine' 	=> $this->engine->toArray(),
				'os' 		=> $this->os->toArray(),
				'device' 	=> $this->device->toArray()
			];

			if (!count($result['browser'])) unset($result['browser']);
			if (!count($result['engine'])) unset($result['engine']);
			if (!count($result['os'])) unset($result['os']);
			if (!count($result['device'])) unset($result['device']);

			return $result;
		}
	}


