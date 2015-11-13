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


	class Browser extends Primitive {
		var $stock = true;
		var $hidden = false;
		var $channel = '';
		var $mode = '';

		public function toString() {
			$name = !empty($this->alias) ? $this->alias : (!empty($this->name) ? $this->name : '');
			return $name ? $name . (!empty($this->channel) ? ' ' . $this->channel : '') . (!empty($this->version) && !$this->version->hidden ? ' ' . $this->version->toString() : '') : '';
		}

		public function toArray() {
			$result = [];

			if (!empty($this->name)) $result['name'] = $this->name;
			if (!empty($this->alias)) $result['alias'] = $this->alias;
			if (!empty($this->version)) $result['version'] = $this->version->toArray();

			if (isset($result['version']) && !count($result['version'])) unset($result['version']);

			return $result;
		}
	}


	class Engine extends Primitive {
		public function toString() {
			$name = !empty($this->alias) ? $this->alias : (!empty($this->name) ? $this->name : '');
			return $name;
		}

		public function toArray() {
			$result = [];

			if (!empty($this->name)) $result['name'] = $this->name;
			if (!empty($this->version)) $result['version'] = $this->version->toArray();

			if (isset($result['version']) && !count($result['version'])) unset($result['version']);

			return $result;
		}
	}


	class Os extends Primitive {
		public function toString() {
			$name = !empty($this->alias) ? $this->alias : (!empty($this->name) ? $this->name : '');
			return $name ? $name . (!empty($this->version) && !$this->version->hidden ? ' ' . $this->version->toString() : '') : '';
		}

		public function toArray() {
			$result = [];

			if (!empty($this->name)) $result['name'] = $this->name;
			if (!empty($this->family)) $result['family'] = $this->family;
			if (!empty($this->alias)) $result['alias'] = $this->alias;
			if (!empty($this->version)) $result['version'] = $this->version->toArray();

			if (isset($result['version']) && !count($result['version'])) unset($result['version']);

			return $result;
		}
	}


	class Device extends Primitive {
		var $type = '';
		var $identified = ID_NONE;
		var $generic = true;

		public function toString() {
			if ($this->identified)			
				return (!empty($this->manufacturer) ? $this->manufacturer . ' ' : '') . 
					   (!empty($this->model) ? $this->model . ' ' : '') . 
					   (!empty($this->series) ? $this->series : '');
			else
				return !empty($this->model) ? 'unrecognized device (' . $this->model . ')' : '';
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
					if (!empty($match[2])) $v[] = $match[2];
					if (!empty($match[3])) $v[] = $match[3];
					if (!empty($match[4])) $v[] = $match[4];

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

					if (!empty($match[5])) $version .= $match[5] . (!empty($match[6]) ? $match[6] : '');
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

