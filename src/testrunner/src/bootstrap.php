<?php
	

	include_once 'testrunner.php';
	include_once 'polyfills.php';


	$location = '';
	if (strpos(__FILE__, DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR) !== false) $location = 'installed';
	if (strpos(__FILE__, DIRECTORY_SEPARATOR . "dist" . DIRECTORY_SEPARATOR . "testrunner") !== false) $location = 'dist';
	if (strpos(__FILE__, DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "testrunner") !== false) $location = 'local';

	switch($location) {
		case 'installed': 	include_once(__DIR__ . '/../../../autoload.php');
							include_once(__DIR__ . '/../../whichbrowser/src/parser.php');
							break;

		case 'local':
		case 'dist': 		include_once(__DIR__ . '/../../../vendor/autoload.php');
							include_once(__DIR__ . '/../../whichbrowser/src/parser.php');
							break;

		default:			echo "\033[0;31mCannot determine what kind of environment we are running in. Aborted!\033[0m\n\n";
							exit(1);
	}
