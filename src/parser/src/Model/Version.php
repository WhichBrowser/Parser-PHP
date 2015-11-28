<?php

	namespace WhichBrowser\Model;


	class Version extends Base {
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

