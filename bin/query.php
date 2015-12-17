<?php

include_once __DIR__ . '/bootstrap.php';

use WhichBrowser\Parser;

$command = 'exec';
$options = [];
$payload = [];

array_shift($argv);

if (count($argv)) {
    foreach ($argv as $argument) {
        if (in_array($argument, [ 'exec' ])) {
            $command = $argument;
        } elseif (substr($argument, 0, 2) == '--') {
            $options[] = substr($argument, 2);
        } else {
            $payload[] = $argument;
        }
    }
}

$payload = implode(' ', $payload);


if ($command == 'exec') {
    if ($payload == '') {
        $payload = file_get_contents('php://stdin');
    }

    if ($payload != '') {
        echo "\n\033[0;32mInput:\033[0;0m\n" . trim($payload) . "\n";

        $result = new Parser(trim($payload));
        echo "\n\033[0;32mHuman readable:\033[0;0m\n" . $result->toString() . "\n";
        echo "\n\033[0;32mData:\033[0;0m\n";
        echo json_encode($result, JSON_PRETTY_PRINT);
        echo "\n\n";
    }
}