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


