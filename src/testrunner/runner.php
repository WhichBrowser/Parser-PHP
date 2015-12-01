<?php

include_once 'bootstrap.php';

use WhichBrowser\Testrunner;

set_error_handler(function ($errno, $errstr, $errfile, $errline, array $errcontext) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }

    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});



$all = false;
$command = 'compare';
$files = [];
$options = [];

array_shift($argv);

if (count($argv)) {
    foreach ($argv as $argument) {
        if (in_array($argument, [ 'compare', 'check', 'rebase', 'list' ])) {
            $command = $argument;
        } elseif (substr($argument, 0, 2) == '--') {
            $options[] = substr($argument, 2);
        } else {
            if (fnmatch("*.yaml", $argument)) {
                $files[] = $argument;
            } else {
                $files = array_merge($files, glob(dirname(__FILE__) . "/data/{$argument}/*.yaml"));
            }
        }
    }
}

if (count($files) === 0) {
    $files = glob(dirname(__FILE__) . "/data/*/*.yaml");
}


switch ($command) {
    case 'list':
        Testrunner::search($files);
        break;

    case 'check':
        if (in_array('coverage', $options)) {
            $coverage = new PHP_CodeCoverage;
            $coverage->filter()->addDirectoryToWhitelist(__DIR__ . '/../parser/');
            $coverage->start('Testrunner');
        }

        $result = Testrunner::compare($files);

        if (in_array('coverage', $options)) {
            $coverage->stop();
            
            $writer = new PHP_CodeCoverage_Report_Clover;
            $writer->process($coverage, __DIR__ . '/../../clover.xml');

            echo "\nWritten coverage to clover.xml\n\n";
        }

        if (!$result) {
            echo "\033[0;31mTestrunner failed, please fix or rebase before building or deploying!\033[0m\n\n";

            if (in_array('show', $options)) {
                echo file_get_contents('runner.log') . "\n\n";
                echo "Done!\n\n";
            }

            exit(1);
        }

        break;

    case 'compare':
        $result = Testrunner::compare($files, true);

        if (!$result) {
            echo "\033[0;31mTestrunner failed, please look at runner.log for the details!\033[0m\n\n";
            exit(1);
        }

        break;

    case 'rebase':
        Testrunner::rebase($files, !$all);
        break;
}
