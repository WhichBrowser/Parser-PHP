<?php
	
	// Installed by Composer as a project
	if (file_exists('vendor/autoload.php')) {
		include_once 'vendor/autoload.php';
	}

	// Installed by Composer in the vendor directory
	elseif (strpos(__FILE__, DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR) !== false) {
		include_once __DIR__ . '/../../autoload.php';
	}

	// Development environment
	else {
		include_once __DIR__ . '/../parser/bootstrap.php';
	}
