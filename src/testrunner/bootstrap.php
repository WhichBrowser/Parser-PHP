<?php

include_once 'src/Testrunner.php';
include_once 'src/Polyfills.php';

if (strpos(__FILE__, DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR) !== false) {
    include_once __DIR__ . '/../../autoload.php';
} else {
    include_once __DIR__ . '/../../vendor/autoload.php';
    include_once __DIR__ . '/../parser/bootstrap.php';
}
