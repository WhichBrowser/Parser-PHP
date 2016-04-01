<?php

include_once __DIR__ . '/bootstrap.php';

use WhichBrowser\Data\Applications;

$command = 'list';
$types = [];
$options = [];

array_shift($argv);

if (count($argv)) {
    foreach ($argv as $argument) {
        if (in_array($argument, [ 'list' ])) {
            $command = $argument;
        } elseif (substr($argument, 0, 2) == '--') {
            $options[] = substr($argument, 2);
        } else {
			$types[] = $argument;
        }
    }
}

if (in_array('all', $options)) {
	$types = [
		'applications-bots'
	];
}


foreach ($types as $i => $type) {
	command($command, $type);
}


function command($command, $type) {
	switch($command) {
		case 'list':
			command_list($type);
			break;
	}
}

function command_list($type) {
	echo "Creating regex for 'data/{$type}.php'...\n";

    require_once __DIR__ . '/../data/' . $type . '.php';

    if ($type == 'applications-bots') {
        $list = Applications::$BOTS;

        $ids = [];

        foreach ($list as $i => $bot) {
            $ids[] = $bot['id'];
        }

        $ids = array_unique($ids);
        $regex = '/(' . implode('|', $ids) . ')/i';

        $file  = "<" . "?php\n";
        $file .= "\n";
        $file .= "namespace WhichBrowser\\Data;\n";
        $file .= "\n";
        $file .= "Applications::\$BOTS_REGEX = '" . $regex . "';\n";

        file_put_contents(__DIR__ . '/../data/regexes/' . $type . '.php', $file);
    }
}
