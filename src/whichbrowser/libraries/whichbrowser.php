<?php

	/* 
		This file is here for backwards compatiblity with the old
		unsupported non-namespaced WhichBrowser object
	*/

	include_once __DIR__ . '/../src/parser.php';

	class WhichBrowser extends WhichBrowser\Parser {
	}

