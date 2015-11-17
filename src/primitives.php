<?php

	namespace WhichBrowser;


	class Primitive {
		public function __construct($defaults = null) {
			if (is_array($defaults)) {
				foreach ($defaults as $k => $v) {
					$this->{$k} = $v;
				}
			}
		}

		public function toJavaScript() {
			$lines = [];

			foreach ($this as $key => $value) {
				if (!is_null($value)) {
					$line = $key . ": ";

					if ($key == 'version') {
						$line .= 'new Version({ ' . $value->toJavaScript() . ' })';
					} else if ($key == 'family') {
						$line .= 'new Family({ ' . $value->toJavaScript() . ' })';
					} else if ($key == 'using') {
						$line .= 'new Using({ ' . $value->toJavaScript() . ' })';
					} else {
						switch(gettype($value)) {
							case 'boolean':		$line .= $value ? 'true' : 'false'; break;
							case 'string':		$line .= '"' . addslashes($value) . '"'; break;
							case 'integer':		$line .= $value; break;
						}
					}

					$lines[] = $line;
				}
			}

			return implode($lines, ", ");
		}
	}


	class NameVersionPrimitive extends Primitive {
		public $name;
		public $alias;
		public $version;


		public function getName() {
			return !empty($this->alias) ? $this->alias : (!empty($this->name) ? $this->name : '');
		}

		public function getVersion() {
			return !empty($this->version) && !$this->version->hidden ? $this->version->toString() : '';
		}

		public function isDetected() {
			return !empty($this->name);
		}

		public function toString() {
			return trim($this->getName() . ' ' . $this->getVersion());
		}
	}

	class Browser extends NameVersionPrimitive {
		public $channel;
		public $using;
		public $family;

		public $stock = true;
		public $hidden = false;
		public $mode = '';

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
			$result = trim($this->getName() . ' ' . $this->getVersion());

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


	class Engine extends NameVersionPrimitive {
		public function toArray() {
			$result = [];

			if (!empty($this->name)) $result['name'] = $this->name;
			if (!empty($this->version)) $result['version'] = $this->version->toArray();

			if (isset($result['name']) && empty($result['name'])) unset($result['name']);
			if (isset($result['version']) && !count($result['version'])) unset($result['version']);

			return $result;
		}
	}


	class Os extends NameVersionPrimitive {
		public $family;

		public function toArray() {
			$result = [];

			if (!empty($this->name)) $result['name'] = $this->name;
			if (!empty($this->family)) $result['family'] = $this->family->toArray();
			if (!empty($this->alias)) $result['alias'] = $this->alias;
			if (!empty($this->version)) $result['version'] = $this->version->toArray();

			if (isset($result['name']) && empty($result['name'])) unset($result['name']);
			if (isset($result['version']) && !count($result['version'])) unset($result['version']);

			return $result;
		}
	}

	class Family extends NameVersionPrimitive {
		public function toArray() {
			$result = [];

			if (!empty($this->name) && empty($this->version)) return $this->name;
			if (!empty($this->name)) $result['name'] = $this->name;
			if (!empty($this->version)) $result['version'] = $this->version->toArray();

			return $result;
		}
	}

	class Using extends NameVersionPrimitive {
		public function toArray() {
			$result = [];

			if (!empty($this->name) && empty($this->version)) return $this->name;
			if (!empty($this->name)) $result['name'] = $this->name;
			if (!empty($this->version)) $result['version'] = $this->version->toArray();

			return $result;
		}
	}

	class Device extends Primitive {
		public $manufacturer;
		public $model;
		public $series;
		public $identifier;

		public $type = '';
		public $identified = ID_NONE;
		public $generic = true;

		public function getManufacturer() {
			return $this->identified && !empty($this->manufacturer) ? $this->manufacturer : '';
		}

		public function getModel() {
			if ($this->identified) return trim((!empty($this->model) ? $this->model . ' ' : '') . (!empty($this->series) ? $this->series : ''));
			return !empty($this->model) ? $this->model : '';
		}

		public function toString() {
			if ($this->identified) return trim((!empty($this->manufacturer) ? $this->manufacturer . ' ' : '') . (!empty($this->model) ? $this->model . ' ' : '') . (!empty($this->series) ? $this->series : ''));
			return !empty($this->model) ? 'unrecognized device (' . $this->model . ')' : '';
		}

		public function isDetected() {
			return !empty($this->model);
		}

		public function toArray() {
			$result = [];

			if (!empty($this->type)) $result['type'] = $this->type;
			if (!empty($this->manufacturer)) $result['manufacturer'] = $this->manufacturer;
			if (!empty($this->model)) $result['model'] = $this->model;
			if (!empty($this->series)) $result['series'] = $this->series;

			return $result;
		}
	}


	class Version extends Primitive {
		var $value = null;
		var $hidden = false;

		public function is() {
			$valid = false;

			$arguments = func_get_args();
			if (count($arguments)) {
				$operator = '=';
				$compare = null;

				if (count($arguments) == 1) {
					$compare = $arguments[0];
				}
				
				if (count($arguments) >= 2) {
					$operator = $arguments[0];
					$compare = $arguments[1];
				}				

				if (!is_null($compare)) {
					$min = min(substr_count($this->value, '.'), substr_count($compare, '.')) + 1;

					$v1 = $this->toValue($this->value, $min);
					$v2 = $this->toValue($compare, $min);

					switch ($operator) {
						case '<':	$valid = $v1 < $v2; break;
						case '<=':	$valid = $v1 <= $v2; break;
						case '=':	$valid = $v1 == $v2; break;
						case '>':	$valid = $v1 > $v2; break;
						case '>=':	$valid = $v1 >= $v2; break;
					}
				}
			}

			return $valid;
		}

		private function toValue($value = null, $count = null) {
			if (is_null($value)) $value = $this->value;
			$parts = explode('.', $value);
			if (!is_null($count)) $parts = array_slice($parts, 0, $count);

			$result = $parts[0];

			if (count($parts) > 1) {
				$result .= '.';

				for ($p = 1; $p < count($parts); $p++) {
					$result .= substr('0000' . $parts[$p], -4);
				}
			}

			return floatval($result);
		}

		public function toFloat() {
			return floatval($this->value);
		}

		public function toNumber() {
			return intval($this->value);
		}

		public function toString() {
			if (!empty($this->alias))
				return $this->alias;

			$version = '';

			if (!empty($this->nickname)) {
				$version .= $this->nickname . ' ';
			}

			if (!empty($this->value)) {
				if (preg_match("/([0-9]+)(?:\.([0-9]+))?(?:\.([0-9]+))?(?:\.([0-9]+))?(?:([ab])([0-9]+))?/", $this->value, $match)) {
					$v = [ $match[1] ];
					if (array_key_exists(2, $match) && strlen($match[2])) $v[] = $match[2];
					if (array_key_exists(3, $match) && strlen($match[3])) $v[] = $match[3];
					if (array_key_exists(4, $match) && strlen($match[4])) $v[] = $match[4];

					if (!empty($this->details)) {
						if ($this->details < 0) array_splice($v, $this->details, 0 - $this->details);
						if ($this->details > 0) array_splice($v, $this->details, count($v) - $this->details);
					}

					if (isset($this->builds) && !$this->builds) {
						for ($i = 0; $i < count($v); $i++) {
							if ($v[$i] > 999) {
								array_splice($v, $i, 1);
							}					
						}
					}

					$version .= implode($v, '.');

					if (array_key_exists(5, $match) && strlen($match[5])) $version .= $match[5] . (!empty($match[6]) ? $match[6] : '');
				}
			}

			return $version;		
		}

		public function toArray() {
			$result = [];

			if (!empty($this->value)) {
				if (!empty($this->details)) {
					$parts = explode('.', $this->value);
					$result['value'] = join('.', array_slice($parts, 0, $this->details));
				} else {
					$result['value'] = $this->value;
				}
			}

			if (!empty($this->alias)) {
				$result['alias'] = $this->alias;
			}

			if (!empty($this->nickname)) {
				$result['nickname'] = $this->nickname;
			}

			if (isset($result['value']) && !isset($result['alias']) && !isset($result['nickname'])) {
				return $result['value'];
			}

			return $result;
		}
	}

