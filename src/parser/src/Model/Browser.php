<?php

	namespace WhichBrowser\Model;

	use WhichBrowser\Model\Primitive\NameVersion;


	class Browser extends NameVersion {
		public $channel;
		public $using;
		public $family;

		public $stock = true;
		public $hidden = false;
		public $mode = '';

		public function reset() {
			parent::reset();

			unset($this->channel);
			unset($this->useing);
			unset($this->family);

			$this->stock = true;
			$this->hidden = false;
			$this->mode = '';
		}

		public function getName() {
			$name = !empty($this->alias) ? $this->alias : (!empty($this->name) ? $this->name : '');
			return $name ? $name . (!empty($this->channel) ? ' ' . $this->channel : '') : '';
		}

		public function isUsing($s) {
			if (isset($this->using)) {
				if ($this->using->getName() == $s) return true;
			}

			return false;
		}

		public function toString() {
			$result = trim(($this->hidden == false ? $this->getName() . ' ' : '') . $this->getVersion());

			if (empty($result) && isset($this->using)) {
				return $this->using->toString();
			}

			return $result;
		}

		public function toArray() {
			$result = [];

			if (!empty($this->name)) $result['name'] = $this->name;
			if (!empty($this->alias)) $result['alias'] = $this->alias;
			if (!empty($this->using)) $result['using'] = $this->using->toArray();
			if (!empty($this->family)) $result['family'] = $this->family->toArray();
			if (!empty($this->version)) $result['version'] = $this->version->toArray();

			if (isset($result['name']) && empty($result['name'])) unset($result['name']);
			if (isset($result['version']) && !count($result['version'])) unset($result['version']);

			return $result;
		}
	}