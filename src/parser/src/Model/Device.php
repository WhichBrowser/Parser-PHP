<?php

	namespace WhichBrowser\Model;

	use WhichBrowser\Constants;


	class Device extends Base {
		public $manufacturer;
		public $model;
		public $series;
		public $identifier;

		public $type = '';
		public $subtype = '';
		public $identified = Constants\Id::NONE;
		public $generic = true;

		public function reset() {
			unset($this->manufacturer);
			unset($this->model);
			unset($this->series);
			unset($this->identifier);

			$this->type = '';
			$this->subtype = '';
			$this->identified = Constants\Id::NONE;
			$this->generic = true;
		}

		public function getManufacturer() {
			return $this->identified && !empty($this->manufacturer) ? $this->manufacturer : '';
		}

		public function getModel() {
			if ($this->identified) return trim((!empty($this->model) ? $this->model . ' ' : '') . (!empty($this->series) ? $this->series : ''));
			return !empty($this->model) ? $this->model : '';
		}

		public function toString() {
			if ($this->identified) {
				$model = $this->getModel();
				$manufacturer = $this->getManufacturer();

				if ($manufacturer != '' && strpos($model, $manufacturer) === 0) {
					$manufacturer = '';
				}

				return trim($manufacturer . ' ' . $model);
			}

			return !empty($this->model) ? 'unrecognized device (' . $this->model . ')' : '';
		}

		public function isDetected() {
			return !empty($this->type) || !empty($this->model) || !empty($this->manufacturer);
		}

		public function toArray() {
			$result = [];

			if (!empty($this->type)) $result['type'] = $this->type;
			if (!empty($this->subtype)) $result['subtype'] = $this->subtype;
			if (!empty($this->manufacturer)) $result['manufacturer'] = $this->manufacturer;
			if (!empty($this->model)) $result['model'] = $this->model;
			if (!empty($this->series)) $result['series'] = $this->series;

			return $result;
		}
	}