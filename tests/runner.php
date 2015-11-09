<?php

	$location = '';
	if (strpos(__FILE__, DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR) !== false) $location = 'installed';
	if (strpos(__FILE__, DIRECTORY_SEPARATOR . "dist" . DIRECTORY_SEPARATOR . "testrunner") !== false) $location = 'dist';
	if (strpos(__FILE__, DIRECTORY_SEPARATOR . "tests" . DIRECTORY_SEPARATOR) !== false) $location = 'local';

	switch($location) {
		case 'installed': 	include_once(dirname(__FILE__) . '/../../autoload.php');
							include_once(dirname(__FILE__) . '/../whichbrowser/libraries/utilities.php');
							include_once(dirname(__FILE__) . '/../whichbrowser/libraries/whichbrowser.php');
							break;

		case 'dist': 		include_once(dirname(__FILE__) . '/../../vendor/autoload.php');
							include_once(dirname(__FILE__) . '/../whichbrowser/libraries/utilities.php');
							include_once(dirname(__FILE__) . '/../whichbrowser/libraries/whichbrowser.php');
							break;

		case 'local': 		include_once(dirname(__FILE__) . '/../vendor/autoload.php');
							include_once(dirname(__FILE__) . '/../src/libraries/utilities.php');
							include_once(dirname(__FILE__) . '/../src/libraries/whichbrowser.php');
							break;

		default:			echo "\033[0;31mCannot determine what kind of enviroment we are running in. Aborted!\033[0m\n\n";
							exit(1);
	}

	use Symfony\Component\Yaml\Yaml;

	function handleError($errno, $errstr, $errfile, $errline, array $errcontext) {
	    // error was suppressed with the @-operator
	    if (0 === error_reporting()) {
	        return false;
	    }

	    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
	}
	set_error_handler("handleError");


	$all = false;
	$command = 'compare';
	$files = array();

	array_shift($argv);

	if (count($argv)) {
		if (in_array($argv[0], array('compare', 'check', 'rebase', 'list'))) {
			$command = array_shift($argv);
		}

		if (count($argv)) {
			foreach($argv as $file) {
				if (fnmatch("*.yaml", $file)) {
					echo "MATCH!";
					$files[] = $file;
				}
				else {
					$files = array_merge($files, glob(dirname(__FILE__) . "/data/{$file}/*.yaml"));
				}
			}
		}

		else {
			$files = glob(dirname(__FILE__) . "/data/*/*.yaml");
		}
	}
	else {
		$files = glob(dirname(__FILE__) . "/data/*/*.yaml");
	}


	switch($command) {

		case 'list':
				Runner::search($files);
				break;

		case 'check':
				$result = Runner::compare($files);

				if (!$result) {
					echo "\033[0;31mTestrunner failed, please fix or rebase before building or deploying!\033[0m\n\n";
					exit(1);
				}

				break;

		case 'compare':
				$result = Runner::compare($files);

				if (!$result) {
					echo "\033[0;31mTestrunner failed, please look at runner.log for the details!\033[0m\n\n";
					exit(1);
				}

				break;

		case 'rebase':
				Runner::rebase($files, !$all);
				break;
	}



	class Runner {

		static function compare($files) {
			@unlink('runner.log');

			$result = true;

			foreach($files as $file) {
				$result = Runner::_compareFile($file) && $result;
			}

			return $result;
		}

		static function _compareFile($file) {
			$fp = fopen('runner.log', 'a+');

			$name = basename(dirname($file)) . DIRECTORY_SEPARATOR . basename($file);

			$success = 0;
			$failed = 0;
			$total = 0;
			$rebase = false;

			$rules = Yaml::parse(file_get_contents($file));

			foreach($rules as $rule) {
				$detected = new WhichBrowser(array('headers' => http_parse_headers($rule['headers'])));

				if (isset($rule['result'])) {
					if ($detected->toArray() != $rule['result']) {
						fwrite($fp, "\n{$name}\n--------------\n\n");
						fwrite($fp, $rule['headers'] . "\n");
						fwrite($fp, "Base:\n");
						fwrite($fp, Yaml::dump($rule['result']) . "\n");
						fwrite($fp, "Calculated:\n");
						fwrite($fp, Yaml::dump($detected->toArray()) . "\n");

						$failed++;
					}
					else {
						$success++;
					}
				} else {
					fwrite($fp, "\n{$name}\n--------------\n\n");
					fwrite($fp, $rule['headers'] . "\n");
					fwrite($fp, "New result:\n");

					try {
						fwrite($fp, Yaml::dump($detected->toArray()) . "\n");
					} catch(Exception $e) {
						echo $rule['headers'] . "\n";
						var_dump($detected);
					}
					$rebase = true;
				}

				$total++;
			}

			fclose($fp);

			$counter = "[{$success}/{$total}]";

			echo $success == $total ? "\033[0;32m" : "\033[0;31m";
			echo $counter;
			echo "\033[0m";
			echo str_repeat(' ', 16 - strlen($counter));
			echo $name;
			echo ($rebase ? "\t\t\033[0;31m => rebase required!\033[0m" : "");
			echo "\n";

			return $success == $total && !$rebase;
		}

		static function search($files, $query = '') {
			foreach($files as $file) {
				Runner::_searchFile($file, $query);
			}
		}

		static function _searchFile($file, $query) {
			$rules = Runner::_sortRules(Yaml::parse(file_get_contents($file)));

			foreach($rules as $rule) {
				$headers = http_parse_headers($rule['headers']);
				echo $headers['User-Agent'] . "\n";
			}
		}

		static function rebase($files, $sort) {
			foreach($files as $file) {
				Runner::_rebaseFile($file, $sort);
			}
		}

		static function _rebaseFile($file, $sort) {
			$result = array();

			$rules = Yaml::parse(file_get_contents($file));

			if (is_array($rules)) {
				echo "Rebasing {$file}\n";

				if ($sort) {
					$rules = Runner::_sortRules($rules);
				}

				foreach($rules as $rule) {
					$detected = new WhichBrowser(array('headers' => http_parse_headers($rule['headers'])));

					$result[] = array(
						'headers' 	=> trim($rule['headers']),
						'result'	=> $detected->toArray()
					);
				}

				if (count($result)) {
					if (count($result) == count($rules)) {
						if ($string = Yaml::dump($result)) {
							file_put_contents($file . '.tmp', $string);

							rename($file, $file . '.old');
							rename($file . '.tmp', $file);
							unlink($file . '.old');
						}
					}
					else {
						echo "Rebasing {$file}\t\t\033[0;31m => output does not match input\033[0m\n";
					}
				} else {
					echo "Rebasing {$file}\t\t\033[0;31m => no results found\033[0m\n";
				}
			} else {
				echo "Rebasing {$file}\t\t\033[0;31m => error reading file\033[0m\n";
			}
		}

		static function _sortRules($rules) {
			usort($rules, function($a, $b) {
				$ah = http_parse_headers($a['headers']);
				$bh = http_parse_headers($b['headers']);

				$as = '';
				$bs = '';

				if (isset($ah['User-Agent'])) $as = $ah['User-Agent'];
				if (isset($bh['User-Agent'])) $bs = $bh['User-Agent'];

		        if ($ah == $bh) {
		            return 0;
				}
		        return ($ah > $bh) ? +1 : -1;
			});

			return $rules;
		}
	}
