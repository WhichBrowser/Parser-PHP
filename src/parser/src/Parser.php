<?php

	namespace WhichBrowser;

	include_once 'Constants.php';
	include_once 'Model.php';
	include_once 'Analyser.php';
	include_once 'Data.php';

	use WhichBrowser\Model\Main;


	class Parser extends Main {

		use Analyser;

		public function __construct($options) {
			parent::__construct();

			$this->analyse($options);
		}		
	}