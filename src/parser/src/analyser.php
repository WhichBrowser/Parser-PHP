<?php

	namespace WhichBrowser;

	use WhichBrowser\Constants;


	include_once 'analyser/header.php';
	include_once 'analyser/derive.php';
	include_once 'analyser/corrections.php';
	include_once 'analyser/camouflage.php';


	class Analyser {

		use Analyser\Header, Analyser\Derive, Analyser\Corrections, Analyser\Camouflage;


		public function __construct($options) {
			if (is_string($options)) 
				$this->options = (object) [ 'headers' => [ 'User-Agent' => $options ] ];
			else
				$this->options = (object) (isset($options['headers']) ? $options : [ 'headers' => $options ]);

			$this->headers = [];
			if (isset($this->options->headers)) $this->headers = $this->options->headers;



			/* Analyse the headers  */

			$this->analyseHeaders();


			/* Derive more information from everything we have gathered  */

			$this->deriveInformation();


			/* Apply corrections  */

			$this->applyCorrections();


			/* Detect if the browser is camouflaged */

			$this->detectCamouflage();


			/* Determine subtype of devices */

			$this->deriveDeviceSubType();
		}
	}	

