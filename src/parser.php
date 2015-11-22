<?php

	namespace WhichBrowser;

	include_once 'constants.php';
	include_once 'primitives.php';
	include_once 'analyser.php';
	include_once 'data.php';

	class Parser extends Analyser {
		public $browser;
		public $engine;
		public $os;
		public $device;

		public $camouflage = false;
		public $features = [];

		public function __construct($options) {
			$this->browser = new Browser();
			$this->engine = new Engine();
			$this->os = new Os();
			$this->device = new Device();

			parent::__construct($options);
		}

		private function isX() {
			$arguments = func_get_args();
			$x = $arguments[0];
			$valid = true;
			
			if (count($arguments) >= 2) {
				$valid = $valid && $this->$x->name == $arguments[1];
			
				if (count($arguments) >= 4 && !empty($this->$x->version) && $valid) {
					$valid = $valid && $this->$x->version->is($arguments[2], $arguments[3]);
				}

				if ($valid) return true;
			}

			return $valid;
		}

		public function isBrowser() {
			$arguments = func_get_args();
			array_unshift($arguments, 'browser');
			return call_user_func_array([ $this, 'isX' ], $arguments);
		}

		public function isEngine() {
			$arguments = func_get_args();
			array_unshift($arguments, 'engine');
			return call_user_func_array([ $this, 'isX' ], $arguments);
		}

		public function isOs() {
			$arguments = func_get_args();
			array_unshift($arguments, 'os');
			return call_user_func_array([ $this, 'isX' ], $arguments);
		}

		public function isDevice($d) {
			return (!empty($this->device->series) && $this->device->series == $d) || (!empty($this->device->model) && $this->device->model == $d);
		}

		public function getType() {
			return $this->device->type . (!empty($this->device->subtype) ? ':' . $this->device->subtype : '');
		}

		public function isType() {
			$arguments = func_get_args();

			for ($a = 0; $a < count($arguments); $a++) { 
				if (strpos($arguments[$a], ':') !== false) {
					list($type, $subtype) = explode(':', $arguments[$a]);
					if ($type == $this->device->type && $subtype == $this->device->subtype) {
						return true;
					}
				}
				else {
					if ($arguments[$a] == $this->device->type) {
						return true;
					}
				}
			}

			return false;
		}

		public function isDetected() {
			return $this->browser->isDetected() || $this->os->isDetected() || $this->engine->isDetected() || $this->device->isDetected();
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
			return "this.browser = new Browser({ " . $this->browser->toJavaScript() . " });\n" .
				   "this.engine = new Engine({ " . $this->engine->toJavaScript() . " });\n" .
				   "this.os = new Os({ " . $this->os->toJavaScript() . " });\n" .
				   "this.device = new Device({ " . $this->device->toJavaScript() . " });\n" .
				   "this.camouflage = " . ($this->camouflage ? 'true' : 'false') . ";\n" .
				   "this.features = " . json_encode($this->features) . ";\n";
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


