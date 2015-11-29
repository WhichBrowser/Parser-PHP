<?php

namespace WhichBrowser\Analyser\Header\Useragent;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Family;
use WhichBrowser\Model\Version;

trait Os
{
    private function detectOperatingSystemFromUseragent($ua)
    {
        $this->detectUnixFromUseragent($ua);
        $this->detectDarwinFromUseragent($ua);
        $this->detectWindowsFromUseragent($ua);
        $this->detectAndroidFromUseragent($ua);
        $this->detectChromeosFromUseragent($ua);
        $this->detectBlackberryFromUseragent($ua);
        $this->detectWebosFromUseragent($ua);
        $this->detectNokiaFromUseragent($ua);
        $this->detectTizenFromUseragent($ua);
        $this->detectSailfishFromUseragent($ua);
        $this->detectBadaFromUseragent($ua);
        $this->detectBrewFromUseragent($ua);
        $this->detectPalmOSFromUseragent($ua);
        $this->detectRemainingOperatingSystemsFromUserAgent($ua);
    }


    private function refineOperatingSystemFromUseragent($ua)
    {
        $this->determineAndroidVersionBasedOnBuild($ua);
    }







    /* Darwin */

    private function detectDarwinFromUseragent($ua)
    {
        /* iOS */

        if ((preg_match('/iPhone/u', $ua) && !preg_match('/like iPhone/u', $ua)) ||
            preg_match('/iPad/u', $ua) || preg_match('/iPod/u', $ua)) {
            $this->os->name = 'iOS';
            $this->os->version = new Version([ 'value' => '1.0' ]);

            if (preg_match('/OS (.*) like Mac OS X/u', $ua, $match)) {
                $this->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
                if ($this->os->version->is('<', '4')) {
                    $this->os->alias = 'iPhone OS';
                }
            }

            if (preg_match('/iPhone Simulator;/u', $ua)) {
                $this->device->type = Constants\DeviceType::EMULATOR;
            } else {
                if (preg_match('/(iPad|iPhone( 3GS| 3G| 4S| 4| 5)?|iPod( touch)?)/u', $ua, $match)) {
                    $device = Data\DeviceModels::identify('ios', $match[0]);

                    if ($device) {
                        $this->device = $device;
                    }
                }

                if (preg_match('/(iPad|iPhone|iPod)[0-9],[0-9]/u', $ua, $match)) {
                    $device = Data\DeviceModels::identify('ios', $match[0]);

                    if ($device) {
                        $this->device = $device;
                    }
                }
            }
        } /* OS X */

        elseif (preg_match('/Mac OS X/u', $ua) || preg_match('/;os=Mac/u', $ua)) {
            $this->os->name = 'OS X';

            if (preg_match('/Mac OS X (10[0-9\._]*)/u', $ua, $match)) {
                $this->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]), 'details' => 2 ]);
            }

            if (preg_match('/;os=Mac (10[0-9\.]*)/u', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            }

            if (!empty($this->os->version)) {
                if ($this->os->version->is('<', '10.7')) {
                    $this->os->alias = 'Mac OS X';
                }
                
                if ($this->os->version->is('10.7')) {
                    $this->os->version->nickname = 'Lion';
                } elseif ($this->os->version->is('10.8')) {
                    $this->os->version->nickname = 'Mountain Lion';
                } elseif ($this->os->version->is('10.9')) {
                    $this->os->version->nickname = 'Mavericks';
                } elseif ($this->os->version->is('10.10')) {
                    $this->os->version->nickname = 'Yosemite';
                } elseif ($this->os->version->is('10.11')) {
                    $this->os->version->nickname = 'El Capitan';
                }
            }

            $this->device->type = Constants\DeviceType::DESKTOP;
        }

        /* Darwin */

        if (preg_match('/Darwin[\/ ]([0-9]+.[0-9]+)/u', $ua, $match)) {
            $this->os->name = "Darwin";
            $this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
        }
    }


    /* Android */

    private function detectAndroidFromUseragent($ua)
    {
        /* Android */

        if (preg_match('/Android/u', $ua)) {
            $falsepositive = false;

            /* Prevent the Mobile IE 11 Franken-UA from matching Android */
            if (preg_match('/IEMobile\/1/u', $ua)) {
                $falsepositive = true;
            }
            if (preg_match('/Windows Phone 10/u', $ua)) {
                $falsepositive = true;
            }

            /* Prevent from OSes that claim to be 'like' Android from matching */
            if (preg_match('/like Android/u', $ua)) {
                $falsepositive = true;
            }
            if (preg_match('/COS like Android/u', $ua)) {
                $falsepositive = false;
            }

            if (!$falsepositive) {
                $this->os->name = 'Android';
                $this->os->version = new Version();

                if (preg_match('/Android(?: )?(?:AllPhone_|CyanogenMod_|OUYA )?(?:\/)?v?([0-9.]+)/u', str_replace('-update', ',', $ua), $match)) {
                    $this->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
                }

                if (preg_match('/Android [0-9][0-9].[0-9][0-9].[0-9][0-9]\(([^)]+)\);/u', str_replace('-update', ',', $ua), $match)) {
                    $this->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
                }

                if (preg_match('/Android Eclair/u', $ua)) {
                    $this->os->version = new Version([ 'value' => '2.0', 'details' => 3 ]);
                }

                if (preg_match('/Android KeyLimePie/u', $ua)) {
                    $this->os->version = new Version([ 'value' => '4.4', 'details' => 3 ]);
                }

                if (preg_match('/Android 5.[01].99/u', $ua)) {
                    $this->os->version = new Version([ 'value' => '6', 'details' => 3, 'alias' => 'M' ]);
                }

                $this->device->type = Constants\DeviceType::MOBILE;

                if ($this->os->version->toFloat() >= 3) {
                    $this->device->type = Constants\DeviceType::TABLET;
                }

                if ($this->os->version->toFloat() >= 4 && preg_match('/Mobile/u', $ua)) {
                    $this->device->type = Constants\DeviceType::MOBILE;
                }


                if (preg_match('/Eclair; (?:[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?) Build\/([^\/]*)\//u', $ua, $match)) {
                    $this->device->model = $match[1];
                } elseif (preg_match('/; ?([^;]*[^;\s])\s+[Bb]uild/u', $ua, $match)) {
                    $this->device->model = $match[1];
                } elseif (preg_match('/Linux;Android [0-9.]+,([^\)]+)\)/u', $ua, $match)) {
                    $this->device->model = $match[1];
                } elseif (preg_match('/[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?; ([^;]*[^;\s])\s?;\s+[Bb]uild/u', $ua, $match)) {
                    $this->device->model = $match[1];
                } elseif (preg_match('/\(([^;]+);U;Android\/[^;]+;[0-9]+\*[0-9]+;CTC\/2.0\)/u', $ua, $match)) {
                    $this->device->model = $match[1];
                } elseif (preg_match('/;\s?([^;]+);\s?[0-9]+\*[0-9]+;\s?CTC\/2.0/u', $ua, $match)) {
                    $this->device->model = $match[1];
                } elseif (preg_match('/Android [^;]+; (?:[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?; )?([^)]+)\)/u', $ua, $match)) {
                    if (!preg_match('/[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?/u', $ua)) {
                        $this->device->model = $match[1];
                    }
                }

                /* Sometimes we get a model name that starts with Android, in that case it is a mismatch and we should ignore it */
                if (isset($this->device->model) && substr($this->device->model, 0, 7) == 'Android') {
                    $this->device->model = null;
                }

                /* Sometimes we get version and API numbers and display size too */
                if (isset($this->device->model) && preg_match('/(.*) - [0-9\.]+ - (?:with Google Apps - )?API [0-9]+ - [0-9]+x[0-9]+/', $this->device->model, $matches)) {
                    $this->device->model = $matches[1];
                }

                /* Sometimes we get a model that is actually an old style useragent */
                if (isset($this->device->model) && preg_match('/([^\/]+?)(?:\/[0-9\.]+)? (?:Android|Release)\//', $this->device->model, $matches)) {
                    $this->device->model = $matches[1];
                }

                if (isset($this->device->model) && $this->device->model) {
                    $this->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('android', $this->device->model);
                    if ($device->identified) {
                        $device->identified |= $this->device->identified;
                        $this->device = $device;
                    }
                }

                if (preg_match('/HP eStation/u', $ua)) {
                    $this->device->manufacturer = 'HP';
                    $this->device->model = 'eStation';
                    $this->device->type = Constants\DeviceType::TABLET;
                    $this->device->identified |= Constants\Id::MATCH_UA;
                    $this->device->generic = false;
                }
                if (preg_match('/Pre\/1.0/u', $ua)) {
                    $this->device->manufacturer = 'Palm';
                    $this->device->model = 'Pre';
                    $this->device->identified |= Constants\Id::MATCH_UA;
                    $this->device->generic = false;
                }
                if (preg_match('/Pre\/1.1/u', $ua)) {
                    $this->device->manufacturer = 'Palm';
                    $this->device->model = 'Pre Plus';
                    $this->device->identified |= Constants\Id::MATCH_UA;
                    $this->device->generic = false;
                }
                if (preg_match('/Pre\/1.2/u', $ua)) {
                    $this->device->manufacturer = 'Palm';
                    $this->device->model = 'Pre 2';
                    $this->device->identified |= Constants\Id::MATCH_UA;
                    $this->device->generic = false;
                }
                if (preg_match('/Pre\/3.0/u', $ua)) {
                    $this->device->manufacturer = 'HP';
                    $this->device->model = 'Pre 3';
                    $this->device->identified |= Constants\Id::MATCH_UA;
                    $this->device->generic = false;
                }
                if (preg_match('/Pixi\/1.0/u', $ua)) {
                    $this->device->manufacturer = 'Palm';
                    $this->device->model = 'Pixi';
                    $this->device->identified |= Constants\Id::MATCH_UA;
                    $this->device->generic = false;
                }
                if (preg_match('/Pixi\/1.1/u', $ua)) {
                    $this->device->manufacturer = 'Palm';
                    $this->device->model = 'Pixi Plus';
                    $this->device->identified |= Constants\Id::MATCH_UA;
                    $this->device->generic = false;
                }
                if (preg_match('/P160UN?A?\/1.0/u', $ua)) {
                    $this->device->manufacturer = 'HP';
                    $this->device->model = 'Veer';
                    $this->device->identified |= Constants\Id::MATCH_UA;
                    $this->device->generic = false;
                }
            }
        }

        if (preg_match('/\(Linux; ([^;]+) Build/u', $ua, $match)) {
            $device = Data\DeviceModels::identify('android', $match[1]);
            if ($device->identified) {
                $device->identified |= Constants\Id::PATTERN;
                $device->identified |= $this->device->identified;

                $this->os->name = 'Android';
                $this->device = $device;
            }
        }

        /* Aliyun OS */

        if (preg_match('/Aliyun/u', $ua) || preg_match('/YunOs/ui', $ua)) {
            $this->os->name = 'Aliyun OS';
            $this->os->family = new Family([ 'name' => 'Android' ]);
            $this->os->version = new Version();

            if (preg_match('/YunOs[ \/]([0-9.]+)/iu', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }

            if (preg_match('/AliyunOS ([0-9.]+)/u', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }

            $this->device->type = Constants\DeviceType::MOBILE;

            if (preg_match('/; ([^;]*[^;\s])\s+Build/u', $ua, $match)) {
                $this->device->model = $match[1];
            }

            if (isset($this->device->model)) {
                $this->device->identified |= Constants\Id::PATTERN;

                $device = Data\DeviceModels::identify('android', $this->device->model);
                if ($device->identified) {
                    $device->identified |= $this->device->identified;
                    $this->device = $device;
                }
            }
        }

        if (preg_match('/Android/u', $ua)) {
            if (preg_match('/Android v(1.[0-9][0-9])_[0-9][0-9].[0-9][0-9]-/u', $ua, $match)) {
                $this->os->name = 'Aliyun OS';
                $this->os->family = new Family([ 'name' => 'Android' ]);
                $this->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }

            if (preg_match('/Android (1.[0-9].[0-9].[0-9]+)-R?T/u', $ua, $match)) {
                $this->os->name = 'Aliyun OS';
                $this->os->family = new Family([ 'name' => 'Android' ]);
                $this->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }

            if (preg_match('/Android ([12].[0-9].[0-9]+)-R-20[0-9]+/u', $ua, $match)) {
                $this->os->name = 'Aliyun OS';
                $this->os->family = new Family([ 'name' => 'Android' ]);
                $this->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }

            if (preg_match('/Android 20[0-9]+/u', $ua, $match)) {
                $this->os->name = 'Aliyun OS';
                $this->os->family = new Family([ 'name' => 'Android' ]);
                $this->os->version = null;
            }
        }

        /* Baidu Yi */

        if (preg_match('/Baidu Yi/u', $ua)) {
            $this->os->name = 'Baidu Yi';
            $this->os->version = null;
        }

        /* Google TV */

        if (preg_match('/GoogleTV/u', $ua)) {
            $this->os->name = 'Google TV';
            $this->os->family = new Family([ 'name' => 'Android' ]);

            $this->device->type = Constants\DeviceType::TELEVISION;

            if (preg_match('/GoogleTV [0-9\.]+; ?([^;]*[^;\s])\s+Build/u', $ua, $match)) {
                $this->device->model = $match[1];
            }

            if (isset($this->device->model) && $this->device->model) {
                $this->device->identified |= Constants\Id::PATTERN;

                $device = Data\DeviceModels::identify('android', $this->device->model);
                if ($device->identified) {
                    $device->identified |= $this->device->identified;
                    $this->device = $device;
                }
            }
        }

        /* WoPhone */

        if (preg_match('/WoPhone/u', $ua)) {
            $this->os->name = 'WoPhone';

            if (preg_match('/WoPhone\/([0-9\.]*)/u', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1] ]);
            }

            $this->device->type = Constants\DeviceType::MOBILE;
        }

        /* COS */

        if (preg_match('/COS like Android/ui', $ua, $match)) {
            $this->os->name = 'COS';
            $this->os->family = new Family([ 'name' => 'Android' ]);
            $this->os->version = null;
            $this->device->type = Constants\DeviceType::MOBILE;
        }

        if (preg_match('/COSBrowser\//ui', $ua, $match)) {
            $this->os->name = 'COS';
            $this->os->family = new Family([ 'name' => 'Android' ]);
        }

        if (preg_match('/COS\/([0-9.]*)/ui', $ua, $match)) {
            $this->os->name = 'COS';
            $this->os->family = new Family([ 'name' => 'Android' ]);
            $this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
        }

        if (preg_match('/(?:\(|; )COS/ui', $ua, $match)) {
            $this->os->name = 'COS';
            $this->os->family = new Family([ 'name' => 'Android' ]);
        }

        if (preg_match('/(?:\(|; )Chinese Operating System ([0-9]\.[0-9.]*);/ui', $ua, $match)) {
            $this->os->name = 'COS';
            $this->os->family = new Family([ 'name' => 'Android' ]);
            $this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
        }

        if (preg_match('/(?:\(|; )COS ([0-9]\.[0-9.]*);/ui', $ua, $match)) {
            $this->os->name = 'COS';
            $this->os->family = new Family([ 'name' => 'Android' ]);
            $this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
        }
    }

    private function determineAndroidVersionBasedOnBuild($ua)
    {
        if ((isset($this->os->name) && $this->os->name == 'Android') || isset($this->os->name) && $this->os->name == 'Android TV') {
            if (preg_match('/Build\/([^\);]+)/u', $ua, $match)) {
                $version = Data\BuildIds::identify('android', $match[1]);

                if ($version) {
                    if (!isset($this->os->version) || $this->os->version == null || $this->os->version->value == null || $version->toFloat() < $this->os->version->toFloat()) {
                        $this->os->version = $version;
                    }

                    /* Special case for Android L */
                    if ($version->toFloat() == 5) {
                        $this->os->version = $version;
                    }
                }

                $this->os->build = $match[1];
            }
        }
    }


    /* Windows */

    private function detectWindowsFromUseragent($ua)
    {
        if (preg_match('/Windows/u', $ua) || preg_match('/Win[9MX]/u', $ua)) {
            $this->os->name = 'Windows';
            $this->device->type = Constants\DeviceType::DESKTOP;

            if (preg_match('/Windows NT ([0-9][0-9]?\.[0-9])/u', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1] ]);

                switch ($match[1]) {
                    case '10.0':
                    case '6.4':
                        if (preg_match('/; ARM;/u', $ua)) {
                            $this->os->version = new Version([ 'value' => $match[1], 'alias' => 'RT 10' ]);
                        } else {
                            $this->os->version = new Version([ 'value' => $match[1], 'alias' => '10' ]);
                        }
                        break;

                    case '6.3':
                        if (preg_match('/; ARM;/u', $ua)) {
                            $this->os->version = new Version([ 'value' => $match[1], 'alias' => 'RT 8.1' ]);
                        } else {
                            $this->os->version = new Version([ 'value' => $match[1], 'alias' => '8.1' ]);
                        }
                        break;

                    case '6.2':
                        if (preg_match('/; ARM;/u', $ua)) {
                            $this->os->version = new Version([ 'value' => $match[1], 'alias' => 'RT' ]);
                        } else {
                            $this->os->version = new Version([ 'value' => $match[1], 'alias' => '8' ]);
                        }
                        break;

                    case '6.1':
                        $this->os->version = new Version([ 'value' => $match[1], 'alias' => '7' ]);
                        break;
                    case '6.0':
                        $this->os->version = new Version([ 'value' => $match[1], 'alias' => 'Vista' ]);
                        break;
                    case '5.2':
                        $this->os->version = new Version([ 'value' => $match[1], 'alias' => 'Server 2003' ]);
                        break;
                    case '5.1':
                        $this->os->version = new Version([ 'value' => $match[1], 'alias' => 'XP' ]);
                        break;
                    case '5.0':
                        $this->os->version = new Version([ 'value' => $match[1], 'alias' => '2000' ]);
                        break;
                    default:
                        $this->os->version = new Version([ 'value' => $match[1], 'alias' => 'NT ' . $match[1] ]);
                        break;
                }
            }

            if (preg_match('/Windows 95/u', $ua) || preg_match('/Win95/u', $ua) || preg_match('/Win 9x 4.00/u', $ua)) {
                $this->os->version = new Version([ 'value' => '4.0', 'alias' => '95' ]);
            }

            if (preg_match('/Windows 98/u', $ua) || preg_match('/Win98/u', $ua) || preg_match('/Win 9x 4.10/u', $ua)) {
                $this->os->version = new Version([ 'value' => '4.1', 'alias' => '98' ]);
            }

            if (preg_match('/Windows ME/u', $ua) || preg_match('/WinME/u', $ua) || preg_match('/Win 9x 4.90/u', $ua)) {
                $this->os->version = new Version([ 'value' => '4.9', 'alias' => 'ME' ]);
            }

            if (preg_match('/Windows XP/u', $ua) || preg_match('/WinXP/u', $ua)) {
                $this->os->version = new Version([ 'value' => '5.1', 'alias' => 'XP' ]);
            }

            if (preg_match('/WPDesktop/u', $ua)) {
                $this->os->name = 'Windows Phone';
                $this->os->version = new Version([ 'value' => '8.0', 'details' => 1 ]);
                $this->device->type = Constants\DeviceType::MOBILE;
                $this->browser->mode = 'desktop';
            }

            if (preg_match('/WP7/u', $ua)) {
                $this->os->name = 'Windows Phone';
                $this->os->version = new Version([ 'value' => '7', 'details' => 1 ]);
                $this->device->type = Constants\DeviceType::MOBILE;
                $this->browser->mode = 'desktop';
            }

            if (preg_match('/Windows CE/u', $ua) || preg_match('/WinCE/u', $ua) || preg_match('/WindowsCE/u', $ua)) {
                if (preg_match('/ IEMobile/u', $ua)) {
                    $this->os->name = 'Windows Mobile';

                    if (preg_match('/ IEMobile 8/u', $ua)) {
                        $this->os->version = new Version([ 'value' => '6.5', 'details' => 2 ]);
                    }

                    if (preg_match('/ IEMobile 7/u', $ua)) {
                        $this->os->version = new Version([ 'value' => '6.1', 'details' => 2 ]);
                    }

                    if (preg_match('/ IEMobile 6/u', $ua)) {
                        $this->os->version = new Version([ 'value' => '6.0', 'details' => 2 ]);
                    }
                } else {
                    $this->os->name = 'Windows CE';

                    if (preg_match('/WindowsCEOS\/([0-9.]*)/u', $ua, $match)) {
                        $this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
                    }

                    if (preg_match('/Windows CE ([0-9.]*)/u', $ua, $match)) {
                        $this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
                    }
                }

                $this->device->type = Constants\DeviceType::MOBILE;
            }

            if (preg_match('/Windows ?Mobile/u', $ua)) {
                $this->os->name = 'Windows Mobile';
                $this->device->type = Constants\DeviceType::MOBILE;
            }

            if (preg_match('/WindowsMobile\/([0-9.]*)/u', $ua, $match)) {
                $this->os->name = 'Windows Mobile';
                $this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
                $this->device->type = Constants\DeviceType::MOBILE;
            }

            if (preg_match('/Windows Phone/u', $ua) || preg_match('/WPDesktop/u', $ua)) {
                $this->os->name = 'Windows Phone';
                $this->device->type = Constants\DeviceType::MOBILE;

                if (preg_match('/Windows Phone (?:OS )?([0-9.]*)/u', $ua, $match)) {
                    $this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

                    if (intval($match[1]) < 7) {
                        $this->os->name = 'Windows Mobile';
                    }
                }

                /* Windows Phone OS 7 and 8 */
                if (preg_match('/IEMobile\/[^;]+;(?: ARM; Touch; )?(?: WpsLondonTest; )?\s*([^;\s][^;]*);\s*([^;\)\s][^;\)]*)[;|\)]/u', $ua, $match)) {
                    $this->device->manufacturer = $match[1];
                    $this->device->model = $match[2];
                    $this->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('wp', $match[2]);
                    if ($device->identified) {
                        $device->identified |= $this->device->identified;
                        $this->device = $device;
                    }
                }

                /* Windows Phone 10 */
                if (preg_match('/Windows Phone 1[0-9]\.[0-9]; Android [0-9\.]+; ([^;\s][^;]*);\s*([^;\)\s][^;\)]*)[;|\)]/u', $ua, $match)) {
                    $this->device->manufacturer = $match[1];
                    $this->device->model = $match[2];
                    $this->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('wp', $match[2]);
                    if ($device->identified) {
                        $device->identified |= $this->device->identified;
                        $this->device = $device;
                    }
                }

                /* Third party browsers */
                if (preg_match('/IEMobile\/[^;]+;(?: ARM; Touch; )?\s*(?:[^\/]+\/[^\/]+);\s*([^;\s][^;]*);\s*([^;\)\s][^;\)]*)[;|\)]/u', $ua, $match)) {
                    $this->device->manufacturer = $match[1];
                    $this->device->model = $match[2];
                    $this->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('wp', $match[2]);
                    if ($device->identified) {
                        $device->identified |= $this->device->identified;
                        $this->device = $device;
                    }
                }

                /* Desktop mode of WP 8.1 */
                if (preg_match('/WPDesktop;\s*([^;\)]*)(?:;\s*([^;\)]*))?(?:;\s*([^;\)]*))?\) like Gecko/u', $ua, $match)) {
                    $this->os->version = new Version([ 'value' => '8.1', 'details' => 2 ]);

                    if (preg_match("/^[A-Z]+$/", $match[1])) {
                        $this->device->manufacturer = $match[1];
                        $this->device->model = $match[2];
                    } else {
                        $this->device->model = $match[1];
                    }

                    $this->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('wp', $this->device->model);
                    if ($device->identified) {
                        $device->identified |= $this->device->identified;
                        $this->device = $device;
                    }
                }

                /* Desktop mode of WP 8.1 Update (buggy version) */
                if (preg_match('/Touch; WPDesktop;\s*([^;\)]*)(?:;\s*([^;\)]*))?(?:;\s*([^;\)]*))?\)/u', $ua, $match)) {
                    $this->os->version = new Version([ 'value' => '8.1', 'details' => 2 ]);

                    if (preg_match("/^[A-Z]+$/", $match[1]) && isset($match[2])) {
                        $this->device->manufacturer = $match[1];
                        $this->device->model = $match[2];
                    } else {
                        $this->device->model = $match[1];
                    }

                    $this->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('wp', $this->device->model);
                    if ($device->identified) {
                        $device->identified |= $this->device->identified;
                        $this->device = $device;
                    }
                }

                if (isset($this->device->manufacturer) && isset($this->device->model)) {
                    if ($this->device->manufacturer == 'ARM' && $this->device->model == 'Touch') {
                        $this->device->manufacturer = null;
                        $this->device->model = null;
                        $this->device->identified = Constants\Id::NONE;
                    }

                    if ($this->device->manufacturer == 'Microsoft' && $this->device->model == 'XDeviceEmulator') {
                        $this->device->manufacturer = null;
                        $this->device->model = null;
                        $this->device->type = Constants\DeviceType::EMULATOR;
                        $this->device->identified |= Constants\Id::MATCH_UA;
                    }
                }
            }
        }
    }


    /* Jolla Sailfish */

    private function detectSailfishFromUseragent($ua)
    {
        if (preg_match('/Sailfish;/u', $ua)) {
            $this->os->name = 'Sailfish';
            $this->os->version = null;

            if (preg_match('/Jolla;/u', $ua)) {
                $this->device->manufacturer = 'Jolla';
            }

            if (preg_match('/Mobile/u', $ua)) {
                $this->device->model = 'Phone';
                $this->device->type = Constants\DeviceType::MOBILE;
                $this->device->identified = Constants\Id::PATTERN;
            }

            if (preg_match('/Tablet/u', $ua)) {
                $this->device->model = 'Tablet';
                $this->device->type = Constants\DeviceType::TABLET;
                $this->device->identified = Constants\Id::PATTERN;
            }
        }
    }


    /* Bada */

    private function detectBadaFromUseragent($ua)
    {
        if (preg_match('/[b|B]ada/u', $ua)) {
            $this->os->name = 'Bada';

            if (preg_match('/[b|B]ada[\/ ]([0-9.]*)/u', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            }

            $this->device->type = Constants\DeviceType::MOBILE;

            if (preg_match('/\(([^;]+); ([^\/]+)\//u', $ua, $match)) {
                if ($match[1] != 'Bada') {
                    $this->device->manufacturer = $match[1];
                    $this->device->model = $match[2];
                    $this->device->identified = Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('bada', $match[2]);

                    if ($device->identified) {
                        $device->identified |= $this->device->identified;
                        $this->device = $device;
                    }
                }
            }
        }
    }


    /* Tizen */

    private function detectTizenFromUseragent($ua)
    {
        if (preg_match('/Tizen/u', $ua)) {
            $this->os->name = 'Tizen';

            if (preg_match('/Tizen[\/ ]([0-9.]*[0-9])/u', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1] ]);
            }

            if (preg_match('/\(([^;]+); ([^\/]+)\//u', $ua, $match)) {
                $falsepositive = false;
                if (strtoupper($match[1]) == 'SMART-TV') {
                    $falsepositive = true;
                }
                if ($match[1] == 'Linux') {
                    $falsepositive = true;
                }
                if ($match[1] == 'Tizen') {
                    $falsepositive = true;
                }

                if (!$falsepositive) {
                    $this->device->manufacturer = $match[1];
                    $this->device->model = $match[2];
                    $this->device->identified = Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('tizen', $match[2]);

                    if ($device->identified) {
                        $device->identified |= $this->device->identified;
                        $this->device = $device;
                    }
                }
            }

            if (preg_match('/\s*([^;]+);\s+([^;\)]+)\)/u', $ua, $match)) {
                $falsepositive = false;
                if ($match[1] == 'U') {
                    $falsepositive = true;
                }
                if (substr($match[2], 0, 5) == 'Tizen') {
                    $falsepositive = true;
                }
                if (substr($match[2], 0, 11) == 'AppleWebKit') {
                    $falsepositive = true;
                }
                if (preg_match("/^[a-z]{2,2}(?:\-[a-z]{2,2})?$/", $match[2])) {
                    $falsepositive = true;
                }

                if (!$falsepositive) {
                    $this->device->model = $match[2];
                    $this->device->identified = Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('tizen', $match[2]);

                    if ($device->identified) {
                        $device->identified |= $this->device->identified;
                        $this->device = $device;
                    }
                }
            }


            if (!$this->device->type && preg_match('/Mobile/iu', $ua, $match)) {
                $this->device->type = Constants\DeviceType::MOBILE;
            }


            if (preg_match('/\(SMART[ -]TV;/iu', $ua, $match)) {
                $this->device->type = Constants\DeviceType::TELEVISION;
                $this->device->manufacturer = 'Samsung';
                $this->device->series = 'Smart TV';
                $this->device->identified = Constants\Id::PATTERN;
            }


            if (preg_match('/(?:Samsung|Tizen ?)Browser\/([0-9.]*)/u', $ua, $match)) {
                $this->browser->name = "Samsung Browser";
                $this->browser->channel = null;
                $this->browser->stock = true;
                $this->browser->version = new Version([ 'value' => $match[1] ]);
                $this->browser->channel = null;
            }
        }

        if (preg_match('/Linux\; U\; Android [0-9.]+\; ko\-kr\; SAMSUNG\; (NX[0-9]+[^\)]]*)/u', $ua, $match)) {
            $this->os->name = 'Tizen';
            $this->os->version = null;

            $this->device->type = Constants\DeviceType::CAMERA;
            $this->device->manufacturer = 'Samsung';
            $this->device->model = $match[1];
            $this->device->identified = Constants\Id::PATTERN;
        }
    }


    /* Nokia */

    private function detectNokiaFromUseragent($ua)
    {
        /* Series 80 */

        if (preg_match('/Series80\/([0-9.]*)/u', $ua, $match)) {
            $this->os->name = 'Series80';
            $this->os->version = new Version([ 'value' => $match[1] ]);

            if (preg_match('/Nokia([^\/;\)]+)[\/|;|\)]/u', $ua, $match)) {
                if ($match[1] != 'Browser') {
                    $this->device->manufacturer = 'Nokia';
                    $this->device->model = Data\DeviceModels::cleanup($match[1]);
                    $this->device->identified |= Constants\Id::PATTERN;
                }
            }
        }

        /* Series 60 */

        if (preg_match('/Symbian/u', $ua) || preg_match('/Series[ ]?60/u', $ua) || preg_match('/S60;/u', $ua) || preg_match('/S60V/u', $ua)) {
            $this->os->name = 'Series60';

            if (preg_match('/SymbianOS\/9.1/u', $ua) && !preg_match('/Series60/u', $ua)) {
                $this->os->version = new Version([ 'value' => '3.0' ]);
            }

            if (preg_match('/Series60\/([0-9.]*)/u', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1] ]);
            }

            if (preg_match('/S60V([0-9.]*)/u', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1] ]);
            }

            if (preg_match('/Nokia([^\/;\)]+)[\/|;|\)]/u', $ua, $match)) {
                if ($match[1] != 'Browser') {
                    $this->device->manufacturer = 'Nokia';
                    $this->device->model = Data\DeviceModels::cleanup($match[1]);
                    $this->device->identified |= Constants\Id::PATTERN;
                }
            }

            if (preg_match('/Symbian; U; (?:Nokia)?([^;]+); [a-z][a-z](?:\-[a-z][a-z])?/u', $ua, $match)) {
                $this->device->manufacturer = 'Nokia';
                $this->device->model = Data\DeviceModels::cleanup($match[1]);
                $this->device->identified |= Constants\Id::PATTERN;
            }

            if (preg_match('/Vertu([^\/;]+)[\/|;]/u', $ua, $match)) {
                $this->device->manufacturer = 'Vertu';
                $this->device->model = Data\DeviceModels::cleanup($match[1]);
                $this->device->identified |= Constants\Id::PATTERN;
            }

            if (preg_match('/Samsung\/([^;]*);/u', $ua, $match)) {
                $this->device->manufacturer = 'Samsung';
                $this->device->model = Data\DeviceModels::cleanup($match[1]);
                $this->device->identified |= Constants\Id::PATTERN;
            }

            if (isset($this->device->model)) {
                $device = Data\DeviceModels::identify('s60', $this->device->model);
                if ($device->identified) {
                    $device->identified |= $this->device->identified;
                    $this->device = $device;
                }
            }

            $this->device->type = Constants\DeviceType::MOBILE;
        }

        /* Series 40 */

        if (preg_match('/Series40/u', $ua)) {
            $this->os->name = 'Series40';

            if (preg_match('/Nokia([^\/]+)\//u', $ua, $match)) {
                $this->device->manufacturer = 'Nokia';
                $this->device->model = Data\DeviceModels::cleanup($match[1]);
                $this->device->identified |= Constants\Id::PATTERN;
            }

            if (isset($this->device->model)) {
                $device = Data\DeviceModels::identify('s40', $this->device->model);
                if ($device->identified) {
                    $device->identified |= $this->device->identified;
                    $this->device = $device;
                }
            }

            if (isset($this->device->model)) {
                $device = Data\DeviceModels::identify('asha', $this->device->model);
                if ($device->identified) {
                    $device->identified |= $this->device->identified;
                    $this->os->name = 'Nokia Asha Platform';
                    $this->os->version = new Version([ 'value' => '1.0' ]);
                    $this->device = $device;
                }

                if (preg_match('/java_runtime_version=Nokia_Asha_([0-9_]+);/u', $ua, $match)) {
                    $this->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
                }
            }

            $this->device->type = Constants\DeviceType::MOBILE;
        }

        /* Series 30+ */

        if (preg_match('/Series30Plus/u', $ua)) {
            $this->os->name = 'Series30+';

            if (preg_match('/Nokia([^\/]+)\//u', $ua, $match)) {
                $this->device->manufacturer = 'Nokia';
                $this->device->model = Data\DeviceModels::cleanup($match[1]);
                $this->device->identified |= Constants\Id::PATTERN;
            }

            if (isset($this->device->model)) {
                $device = Data\DeviceModels::identify('s30plus', $this->device->model);
                if ($device->identified) {
                    $device->identified |= $this->device->identified;
                    $this->device = $device;
                }
            }

            $this->device->type = Constants\DeviceType::MOBILE;
        } elseif (preg_match('/Series30/u', $ua)) {
            $this->os->name = 'Series30';

            if (preg_match('/Nokia([^\/]+)\//u', $ua, $match)) {
                $this->device->manufacturer = 'Nokia';
                $this->device->model = Data\DeviceModels::cleanup($match[1]);
                $this->device->identified |= Constants\Id::PATTERN;
            }

            $this->device->type = Constants\DeviceType::MOBILE;
        }

        /* Meego */

        if (preg_match('/MeeGo/u', $ua)) {
            $this->os->name = 'MeeGo';
            $this->device->type = Constants\DeviceType::MOBILE;

            if (preg_match('/Nokia([^\)]+)\)/u', $ua, $match)) {
                $this->device->manufacturer = 'Nokia';
                $this->device->model = Data\DeviceModels::cleanup($match[1]);
                $this->device->identified |= Constants\Id::PATTERN;
                $this->device->generic = false;
            }
        }

        /* Maemo */

        if (preg_match('/Maemo/u', $ua)) {
            $this->os->name = 'Maemo';
            $this->device->type = Constants\DeviceType::MOBILE;

            if (preg_match('/(N[0-9]+)/u', $ua, $match)) {
                $this->device->manufacturer = 'Nokia';
                $this->device->model = $match[1];
                $this->device->identified |= Constants\Id::PATTERN;
                $this->device->generic = false;
            }
        }
    }


    /* WebOS */

    private function detectWebosFromUseragent($ua)
    {
        if (preg_match('/(?:web|hpw)OS\/(?:HP webOS )?([0-9.]*)/u', $ua, $match)) {
            $this->os->name = 'webOS';
            $this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->device->type = preg_match('/Tablet/iu', $ua) ? Constants\DeviceType::TABLET : Constants\DeviceType::MOBILE;
            $this->device->generic = false;

            if (preg_match('/Pre\/1.0/u', $ua)) {
                $this->device->model = 'Pre';
            }
            if (preg_match('/Pre\/1.1/u', $ua)) {
                $this->device->model = 'Pre Plus';
            }
            if (preg_match('/Pre\/1.2/u', $ua)) {
                $this->device->model = 'Pre 2';
            }
            if (preg_match('/Pre\/3.0/u', $ua)) {
                $this->device->model = 'Pre 3';
            }
            if (preg_match('/Pixi\/1.0/u', $ua)) {
                $this->device->model = 'Pixi';
            }
            if (preg_match('/Pixi\/1.1/u', $ua)) {
                $this->device->model = 'Pixi Plus';
            }
            if (preg_match('/P160UN?A?\/1.0/u', $ua)) {
                $this->device->model = 'Veer';
            }
            if (preg_match('/TouchPad\/1.0/u', $ua)) {
                $this->device->model = 'TouchPad';
            }
            if (isset($this->device->model)) {
                $this->device->manufacturer = preg_match('/hpwOS/u', $ua) ? 'HP' : 'Palm';
            }

            if (preg_match('/Emulator\//u', $ua) || preg_match('/Desktop\//u', $ua)) {
                $this->device->type = Constants\DeviceType::EMULATOR;
                $this->device->manufacturer = null;
                $this->device->model = null;
            }

            $this->device->identified |= Constants\Id::MATCH_UA;
        }

        if (preg_match('/elite\/fzz/u', $ua, $match)) {
            $this->os->name = 'webOS';
        }
    }


    /* BlackBerry */

    private function detectBlackberryFromUseragent($ua)
    {
        /* BlackBerry OS */

        if (preg_match('/BlackBerry/u', $ua) && !preg_match('/BlackBerry Runtime for Android Apps/u', $ua)) {
            $this->os->name = 'BlackBerry OS';

            $this->device->model = 'BlackBerry';
            $this->device->manufacturer = 'RIM';
            $this->device->type = Constants\DeviceType::MOBILE;
            $this->device->identified = Constants\Id::INFER;

            if (!preg_match('/Opera/u', $ua)) {
                if (preg_match('/BlackBerry([0-9]*)\/([0-9.]*)/u', $ua, $match)) {
                    $this->device->model = $match[1];
                    $this->os->version = new Version([ 'value' => $match[2], 'details' => 2 ]);
                }

                if (preg_match('/; BlackBerry ([0-9]*);/u', $ua, $match)) {
                    $this->device->model = $match[1];
                }

                if (preg_match('/; ([0-9]+)[^;\)]+\)/u', $ua, $match)) {
                    $this->device->model = $match[1];
                }

                if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
                    $this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
                }

                if (isset($this->os->version) && $this->os->version->toFloat() >= 10) {
                    $this->os->name = 'BlackBerry';
                }

                if ($this->device->model) {
                    $device = Data\DeviceModels::identify('blackberry', $this->device->model);

                    if ($device->identified) {
                        $device->identified |= $this->device->identified;
                        $this->device = $device;
                    }
                }
            }
        }

        /* BlackBerry 10 */

        if (preg_match('/\(BB(1[^;]+); ([^\)]+)\)/u', $ua, $match)) {
            $this->os->name = 'BlackBerry';
            $this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

            $this->device->manufacturer = 'BlackBerry';
            $this->device->model = $match[2];

            if ($this->device->model == 'Kbd') {
                $this->device->model = 'Q series or Passport';
            }

            if ($this->device->model == 'Touch') {
                $this->device->model = 'A or Z series';
            }

            $this->device->type = preg_match('/Mobile/u', $ua) ? Constants\DeviceType::MOBILE : Constants\DeviceType::TABLET;
            $this->device->identified |= Constants\Id::MATCH_UA;

            if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            }
        }

        /* BlackBerry Tablet OS */

        if (preg_match('/RIM Tablet OS ([0-9.]*)/u', $ua, $match)) {
            $this->os->name = 'BlackBerry Tablet OS';
            $this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

            $this->device->manufacturer = 'RIM';
            $this->device->model = 'BlackBerry PlayBook';
            $this->device->type = Constants\DeviceType::TABLET;
            $this->device->identified |= Constants\Id::MATCH_UA;
        } elseif (preg_match('/\(PlayBook;/u', $ua) && preg_match('/PlayBook Build\/([0-9.]*)/u', $ua, $match)) {
            $this->os->name = 'BlackBerry Tablet OS';
            $this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

            $this->device->manufacturer = 'RIM';
            $this->device->model = 'BlackBerry PlayBook';
            $this->device->type = Constants\DeviceType::TABLET;
            $this->device->identified |= Constants\Id::MATCH_UA;
        } elseif (preg_match('/PlayBook/u', $ua) && !preg_match('/Android/u', $ua)) {
            if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
                $this->os->name = 'BlackBerry Tablet OS';
                $this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

                $this->device->manufacturer = 'RIM';
                $this->device->model = 'BlackBerry PlayBook';
                $this->device->type = Constants\DeviceType::TABLET;
                $this->device->identified |= Constants\Id::MATCH_UA;
            }
        }
    }


    /* Chrome OS */

    private function detectChromeosFromUseragent($ua)
    {
        /* ChromeCast */

        if (preg_match('/CrKey/u', $ua) && !preg_match('/Espial/u', $ua)) {
            $this->device->manufacturer = 'Google';
            $this->device->model = 'Chromecast';
            $this->device->type = Constants\DeviceType::TELEVISION;
            $this->device->identified |= Constants\Id::MATCH_UA;
            $this->device->generic = false;
        }

        /* Chrome OS */

        if (preg_match('/CrOS/u', $ua)) {
            $this->os->name = 'Chrome OS';
            $this->device->type = Constants\DeviceType::DESKTOP;
        }
    }


    /* Unix */

    private function detectUnixFromUseragent($ua)
    {
        /* Unix */

        if (preg_match('/Unix/u', $ua)) {
            $this->os->name = 'Unix';
        }

        /* Digital Unix */

        if (preg_match('/OSF1 /u', $ua)) {
            $this->os->name = 'Digital Unix';

            if (preg_match('/OSF1 V([0-9.]*)/u', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1] ]);
            }

            $this->device->type = Constants\DeviceType::DESKTOP;
        }

        /* FreeBSD */

        if (preg_match('/FreeBSD/u', $ua)) {
            $this->os->name = 'FreeBSD';
        }

        /* OpenBSD */

        if (preg_match('/OpenBSD/u', $ua)) {
            $this->os->name = 'OpenBSD';
        }

        /* NetBSD */

        if (preg_match('/NetBSD/u', $ua)) {
            $this->os->name = 'NetBSD';
        }

        /* Solaris */

        if (preg_match('/SunOS/u', $ua)) {
            $this->os->name = 'Solaris';
            $this->device->type = Constants\DeviceType::DESKTOP;
        }

        /* IRIX */

        if (preg_match('/IRIX/u', $ua)) {
            $this->os->name = 'IRIX';

            if (preg_match('/IRIX ([0-9.]*)/u', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1] ]);
            }

            if (preg_match('/IRIX;?(?:64|32) ([0-9.]*)/u', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1] ]);
            }

            $this->device->type = Constants\DeviceType::DESKTOP;
        }

        /* Syllable */

        if (preg_match('/Syllable/u', $ua)) {
            $this->os->name = 'Syllable';
            $this->device->type = Constants\DeviceType::DESKTOP;
        }

        /* Linux */

        if (preg_match('/Linux/u', $ua)) {
            $this->os->name = 'Linux';

            if (preg_match('/CentOS/u', $ua)) {
                $this->os->name = 'CentOS';
                if (preg_match('/CentOS\/[0-9\.\-]+el([0-9_]+)/u', $ua, $match)) {
                    $this->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
                }

                $this->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Debian/u', $ua)) {
                $this->os->name = 'Debian';
                $this->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Fedora/u', $ua)) {
                $this->os->name = 'Fedora';
                if (preg_match('/Fedora\/[0-9\.\-]+fc([0-9]+)/u', $ua, $match)) {
                    $this->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
                }

                $this->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Gentoo/u', $ua)) {
                $this->os->name = 'Gentoo';
                $this->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/gNewSense/u', $ua)) {
                $this->os->name = 'gNewSense';
                if (preg_match('/gNewSense\/[^\(]+\(([0-9\.]+)/u', $ua, $match)) {
                    $this->os->version = new Version([ 'value' => $match[1] ]);
                }

                $this->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Kubuntu/u', $ua)) {
                $this->os->name = 'Kubuntu';
                $this->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Mandriva Linux/u', $ua)) {
                $this->os->name = 'Mandriva';
                if (preg_match('/Mandriva Linux\/[0-9\.\-]+mdv([0-9]+)/u', $ua, $match)) {
                    $this->os->version = new Version([ 'value' => $match[1] ]);
                }

                $this->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Mageia/u', $ua)) {
                $this->os->name = 'Mageia';
                if (preg_match('/Mageia\/[0-9\.\-]+mga([0-9]+)/u', $ua, $match)) {
                    $this->os->version = new Version([ 'value' => $match[1] ]);
                }

                $this->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Mandriva/u', $ua)) {
                $this->os->name = 'Mandriva';
                if (preg_match('/Mandriva\/[0-9\.\-]+mdv([0-9]+)/u', $ua, $match)) {
                    $this->os->version = new Version([ 'value' => $match[1] ]);
                }

                $this->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Red Hat/u', $ua)) {
                $this->os->name = 'Red Hat';
                if (preg_match('/Red Hat[^\/]*\/[0-9\.\-]+el([0-9_]+)/u', $ua, $match)) {
                    $this->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
                }

                $this->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Slackware/u', $ua)) {
                $this->os->name = 'Slackware';
                $this->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/SUSE/u', $ua)) {
                $this->os->name = 'SUSE';
                $this->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Turbolinux/u', $ua)) {
                $this->os->name = 'Turbolinux';
                $this->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Ubuntu/u', $ua)) {
                $this->os->name = 'Ubuntu';
                if (preg_match('/Ubuntu\/([0-9.]*)/u', $ua, $match)) {
                    $this->os->version = new Version([ 'value' => $match[1] ]);
                }

                $this->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Linux\/X2\/R1/u', $ua)) {
                $this->os->name = 'LiMo';
                $this->device->type = Constants\DeviceType::MOBILE;
            }
        } elseif (preg_match('/\(Ubuntu; (Mobile|Tablet)/u', $ua)) {
            $this->os->name = 'Ubuntu Touch';

            if (preg_match('/\(Ubuntu; Mobile/u', $ua)) {
                $this->device->type = Constants\DeviceType::MOBILE;
            }
            if (preg_match('/\(Ubuntu; Tablet/u', $ua)) {
                $this->device->type = Constants\DeviceType::TABLET;
            }
        } elseif (preg_match('/\(Ubuntu ([0-9.]+) like Android/u', $ua, $match)) {
            $this->os->name = 'Ubuntu Touch';
            $this->os->version = new Version([ 'value' => $match[1] ]);
            $this->device->type = Constants\DeviceType::MOBILE;
        }
    }


    /* Brew */

    private function detectBrewFromUseragent($ua)
    {
        if (preg_match('/BREW/ui', $ua) || preg_match('/BMP( [0-9.]*)?; U/u', $ua) || preg_match('/BMP\/([0-9.]*)/u', $ua)) {
            $this->os->name = 'Brew';

            if (preg_match('/; Brew ([0-9.]*);/iu', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1] ]);
            }

            if (preg_match('/BREW; U; ([0-9.]*)/iu', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1] ]);
            } elseif (preg_match('/BREW MP ([0-9.]*)/iu', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1] ]);
            } elseif (preg_match('/[\(;]BREW[\/ ]([0-9.]*)/iu', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1] ]);
            } elseif (preg_match('/BMP ([0-9.]*); U/iu', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1] ]);
            } elseif (preg_match('/BMP\/([0-9.]*)/iu', $ua, $match)) {
                $this->os->version = new Version([ 'value' => $match[1] ]);
            }


            $this->device->type = Constants\DeviceType::MOBILE;

            if (preg_match('/(?:Brew MP|BREW|BMP) [^;]+; U; [^;]+; ([^;]+); NetFront[^\)]+\) [^\s]+ ([^\s]+)/u', $ua, $match)) {
                $this->device->manufacturer = trim($match[1]);
                $this->device->model = $match[2];
                $this->device->identified = Constants\Id::PATTERN;

                $device = Data\DeviceModels::identify('brew', $match[2]);

                if ($device->identified) {
                    $device->identified |= $this->device->identified;
                    $this->device = $device;
                }
            }

            if (preg_match('/\(([^;]+);U;REX\/[^;]+;BREW\/[^;]+;(?:.*;)?[0-9]+\*[0-9]+(?:;CTC\/2.0)?\)/u', $ua, $match)) {
                $this->device->model = $match[1];
                $this->device->identified = Constants\Id::PATTERN;

                $device = Data\DeviceModels::identify('brew', $match[1]);

                if ($device->identified) {
                    $device->identified |= $this->device->identified;
                    $this->device = $device;
                }
            }
        }
    }


    /* Palm OS */

    private function detectPalmOSFromUseragent($ua)
    {
        if (preg_match('/PalmOS/iu', $ua, $match)) {
            $this->os->name = 'Palm OS';
            $this->device->type = Constants\DeviceType::MOBILE;

            if (preg_match('/; ([^;)]+)\)/u', $ua, $match)) {
                $device = Data\DeviceModels::identify('palmos', $match[1]);

                if ($device->identified) {
                    $device->identified |= $this->device->identified;
                    $this->device = $device;
                }
            }
        }

        if (preg_match('/Palm OS ([0-9.]*)/iu', $ua, $match)) {
            $this->os->name = 'Palm OS';
            $this->os->version = new Version([ 'value' => $match[1] ]);
            $this->device->type = Constants\DeviceType::MOBILE;
        }

        if (preg_match('/PalmSource/u', $ua, $match)) {
            $this->os->name = 'Palm OS';
            $this->os->version = null;
            $this->device->type = Constants\DeviceType::MOBILE;

            if (preg_match('/PalmSource\/([^;]+)/u', $ua, $match)) {
                $this->device->model = $match[1];
                $this->device->identified = Constants\Id::PATTERN;
            }

            if (isset($this->device->model) && $this->device->model) {
                $device = Data\DeviceModels::identify('palmos', $this->device->model);

                if ($device->identified) {
                    $device->identified |= $this->device->identified;
                    $this->device = $device;
                }
            }
        }

    }


    /* Remaining operating systems */

    private function detectRemainingOperatingSystemsFromUserAgent($ua)
    {
        $patterns = [
            [ 'name' => 'BeOS',         'regexp' => [ '/BeOS/iu' ],                                         'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Haiku',        'regexp' => [ '/Haiku/iu' ],                                        'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'AmigaOS',      'regexp' => [ '/AmigaOS/iu', '/AmigaOS ([0-9.]*)/iu' ],             'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'MorphOS',      'regexp' => [ '/MorphOS(?: ([0-9.]*))?/iu' ],                       'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'AROS',         'regexp' => [ '/AROS/iu' ],                                         'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'RISC OS',      'regexp' => [ '/RISC OS/iu', '/RISC OS(?:-NC)? ([0-9.]*)/iu' ],     'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Joli OS',      'regexp' => [ '/Joli OS\/([0-9.]*)/iu' ],                           'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'OS/2 Warp',    'regexp' => [ '/OS\/2; (?:U; )?Warp ([0-9.]*)/iu' ],                'type' => Constants\DeviceType::DESKTOP ],

            [ 'name' => 'Grid OS',      'regexp' => [ '/Grid OS ([0-9.]*)/iu' ],                            'type' => Constants\DeviceType::TABLET ],

            [ 'name' => 'MAUI Runtime', 'regexp' => [ '/MAUI/u' ],                                          'type' => Constants\DeviceType::MOBILE ],
            [ 'name' => 'MTK',          'regexp' => [ '/\(MTK;/iu', '/\/MTK /iu' ],                         'type' => Constants\DeviceType::MOBILE ],
            [ 'name' => 'QNX',          'regexp' => [ '/QNX/iu' ],                                          'type' => Constants\DeviceType::MOBILE ],
            [ 'name' => 'VRE',          'regexp' => [ '/\(VRE;/iu' ],                                       'type' => Constants\DeviceType::MOBILE ],
            [ 'name' => 'SpreadTrum',   'regexp' => [ '/\(SpreadTrum;/iu' ],                                'type' => Constants\DeviceType::MOBILE ],

            [ 'name' => 'ThreadX',      'regexp' => [ '/ThreadX(?:_OS)?\/([0-9.]*)/iu' ] ],
        ];

        for ($b = 0; $b < count($patterns); $b++) {
            for ($r = 0; $r < count($patterns[$b]['regexp']); $r++) {

                if (preg_match($patterns[$b]['regexp'][$r], $ua, $match)) {
                    $this->os->name = $patterns[$b]['name'];

                    $this->os->name = $patterns[$b]['name'];

                    if (isset($match[1]) && $match[1]) {
                        $this->os->version = new Version([ 'value' => $match[1], 'details' => isset($patterns[$b]['details']) ? $patterns[$b]['details'] : null ]);
                    } else {
                        $this->os->version = null;
                    }

                    if (isset($patterns[$b]['type'])) {
                        $this->device->type = $patterns[$b]['type'];
                    }
                }
            }
        }
    }
}
