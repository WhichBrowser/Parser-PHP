<?php

namespace WhichBrowser;

use Symfony\Component\Yaml\Yaml;

class Testrunner
{
    public static function compare($files, $skipManufacturers = false)
    {
        @unlink('runner.log');

        $result = true;

        foreach ($files as $file) {
            if ($skipManufacturers && substr(basename($file), 0, 13) == 'manufacturer-') {
                continue;
            }
            $result = self::compareFile($file, $skipManufacturers) && $result;
        }

        return $result;
    }

    private static function compareFile($file)
    {
        $fp = fopen('runner.log', 'a+');

        $name = basename(dirname($file)) . DIRECTORY_SEPARATOR . basename($file);

        $success = 0;
        $failed = 0;
        $total = 0;
        $rebase = false;
        $found = false;

        if (file_exists($file)) {
            $found = true;

            $rules = Yaml::parse(file_get_contents($file));

            foreach ($rules as $rule) {
                $options = $rule;

                if (isset($options['headers']) && is_string($options['headers'])) {
                    $options['headers'] = http_parse_headers($options['headers']);
                }

                if (isset($options['result'])) {
                    unset($options['result']);
                }

                $detected = new Parser($options);

                if (isset($rule['result'])) {
                    if ($detected->toArray() != $rule['result'] || $detected->toString() != $rule['readable']) {
                        fwrite($fp, "\n{$name}\n--------------\n\n");

                        if ($detected->toString() != $rule['readable']) {
                            fwrite($fp, $rule['readable'] . "\n");
                            fwrite($fp, $detected->toString() . "\n\n");
                        } else {
                            fwrite($fp, $detected->toString() . "\n\n");
                        }

                        if (isset($options['headers'])) {
                            foreach ($options['headers'] as $k => $v) {
                                fwrite($fp, $k . ': ' . $v . "\n");
                            }
                        }

                        fwrite($fp, "\n");
                        fwrite($fp, "Base:\n");
                        fwrite($fp, Yaml::dump($rule['result']) . "\n");
                        fwrite($fp, "Calculated:\n");
                        fwrite($fp, Yaml::dump($detected->toArray()) . "\n");

                        $failed++;
                    } else {
                        $success++;
                    }
                } else {
                    fwrite($fp, "\n{$name}\n--------------\n\n");
                    fwrite($fp, $detected->toString() . "\n\n");

                    if (isset($options['headers'])) {
                        foreach ($options['headers'] as $k => $v) {
                            fwrite($fp, $k . ': ' . $v . "\n");
                        }
                    }

                    fwrite($fp, "\n");
                    fwrite($fp, "New result:\n");

                    try {
                        fwrite($fp, Yaml::dump($detected->toArray()) . "\n");
                    } catch (Exception $e) {
                        echo $rule['headers'] . "\n";
                        var_dump($detected);
                    }
                    $rebase = true;
                }

                $total++;
            }
        }

        fclose($fp);

        $counter = "[{$success}/{$total}]";

        echo $success == $total && $found ? "\033[0;32m" : "\033[0;31m";
        echo $counter;
        echo "\033[0m";
        echo str_repeat(' ', 16 - strlen($counter));
        echo $name;
        echo (!$found ? "\t\t\033[0;31m => file not found!\033[0m" : "");
        echo ($rebase ? "\t\t\033[0;31m => rebase required!\033[0m" : "");
        echo "\n";

        return $success == $total && !$rebase;
    }

    public static function search($files, $query = '')
    {
        foreach ($files as $file) {
            self::searchFile($file, $query);
        }
    }

    private static function searchFile($file, $query)
    {
        $rules = self::sortRules(Yaml::parse(file_get_contents($file)));

        foreach ($rules as $rule) {
            if (is_string($rule['headers'])) {
                $rule['headers'] = http_parse_headers($rule['headers']);
            }

            if (isset($rule['headers']['User-Agent'])) {
                echo $rule['headers']['User-Agent'] . "\n";
            }
        }
    }

    public static function rebase($files, $sort)
    {
        foreach ($files as $file) {
            self::rebaseFile($file, $sort);
        }
    }

    private static function rebaseFile($file, $sort)
    {
        $result = [];

        if (file_exists($file)) {
            $rules = Yaml::parse(file_get_contents($file));

            if (is_array($rules)) {
                echo "Rebasing {$file}\n";

                foreach ($rules as $k => $v) {
                    if (is_string($rules[$k]['headers'])) {
                        $rules[$k]['headers'] = http_parse_headers($rules[$k]['headers']);
                    }
                }

                if ($sort) {
                    $rules = self::sortRules($rules);
                }

                foreach ($rules as $rule) {
                    if (count($rule['headers']) > 1) {
                        $headers = $rule['headers'];
                    } else {
                        $key = array_keys($rule['headers'])[0];
                        $headers = $key . ': ' . $rule['headers'][$key];
                    }

                    $options = $rule;

                    if (isset($options['result'])) {
                        unset($options['result']);
                    }

                    $detected = new Parser($options);

                    $rule['headers'] = $headers;
                    $rule['readable'] = $detected->toString();
                    $rule['result'] = $detected->toArray();

                    $result[] = $rule;
                }

                if (count($result)) {
                    if (count($result) == count($rules)) {
                        if ($string = Yaml::dump($result)) {
                            file_put_contents($file . '.tmp', $string);

                            rename($file, $file . '.old');
                            rename($file . '.tmp', $file);
                            unlink($file . '.old');
                        }
                    } else {
                        echo "Rebasing {$file}\t\t\033[0;31m => output does not match input\033[0m\n";
                    }
                } else {
                    echo "Rebasing {$file}\t\t\033[0;31m => no results found\033[0m\n";
                }
            } else {
                echo "Rebasing {$file}\t\t\033[0;31m => error reading file\033[0m\n";
            }
        } else {
            echo "Rebasing {$file}\t\t\033[0;31m => file not found\033[0m\n";
        }
    }

    private static function sortRules($rules)
    {
        usort($rules, function ($a, $b) {
            $ah = $a['headers'];
            $bh = $b['headers'];

            $as = '';
            $bs = '';

            if (isset($ah['User-Agent'])) {
                $as = $ah['User-Agent'];
            }
            if (isset($bh['User-Agent'])) {
                $bs = $bh['User-Agent'];
            }

            if ($ah == $bh) {
                return 0;
            }

            return ($ah > $bh) ? +1 : -1;
        });

        return $rules;
    }
}
