<?php

$standaloneAutoloader = __DIR__ . '/../vendor/autoload.php';
$packageAutoloader = __DIR__ . '/../../../autoload.php';

if (file_exists($packageAutoloader)) {
    require_once $packageAutoloader;
} else {
    require_once $standaloneAutoloader;
}
