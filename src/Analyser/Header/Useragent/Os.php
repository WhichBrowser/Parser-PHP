<?php

namespace WhichBrowser\Analyser\Header\Useragent;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Family;
use WhichBrowser\Model\Version;

trait Os
{
    private function &detectOperatingSystem($ua)
    {
        $this->detectUnix($ua);
        $this->detectLinux($ua);
        $this->detectBsd($ua);
        $this->detectDarwin($ua);
        $this->detectWindows($ua);
        $this->detectAndroid($ua);
        $this->detectChromeos($ua);
        $this->detectBlackberry($ua);
        $this->detectWebos($ua);
        $this->detectSymbian($ua);
        $this->detectNokiaOs($ua);
        $this->detectTizen($ua);
        $this->detectSailfish($ua);
        $this->detectBada($ua);
        $this->detectBrew($ua);
        $this->detectQtopia($ua);
        $this->detectRemainingOperatingSystems($ua);

        return $this;
    }


    private function &refineOperatingSystem($ua)
    {
        $this->determineAndroidVersionBasedOnBuild($ua);

        return $this;
    }







    /* Darwin */

    private function detectDarwin($ua)
    {
        /* iOS */

        if ((preg_match('/iPhone/u', $ua) && !preg_match('/like iPhone/u', $ua)) ||
            preg_match('/iPad/u', $ua) || preg_match('/iPod/u', $ua)) {
            $this->data->os->name = 'iOS';

            if (preg_match('/CPU like Mac OS X/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => '1.0' ]);
            }

            if (preg_match('/OS (.*) like Mac OS X/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
            }

            if (preg_match('/iPhone OS ([0-9._]*);/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
            }

            if (preg_match('/iPhone Simulator;/u', $ua)) {
                $this->data->device->type = Constants\DeviceType::EMULATOR;
            } else {
                if (preg_match('/(iPad|iPhone( 3GS| 3G| 4S| 4| 5)?|iPod( touch)?)/u', $ua, $match)) {
                    $device = Data\DeviceModels::identify('ios', $match[0]);

                    if ($device) {
                        $this->data->device = $device;
                    }
                }

                if (preg_match('/(iPad|iPhone|iPod)[0-9],[0-9]/u', $ua, $match)) {
                    $device = Data\DeviceModels::identify('ios', $match[0]);

                    if ($device) {
                        $this->data->device = $device;
                    }
                }
            }
        } /* OS X */

        elseif (preg_match('/Mac OS X/u', $ua) || preg_match('/;os=Mac/u', $ua)) {
            $this->data->os->name = 'OS X';

            if (preg_match('/Mac OS X (10[0-9\._]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]), 'details' => 2 ]);
            }

            if (preg_match('/;os=Mac (10[0-9\.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            }

            $this->data->device->type = Constants\DeviceType::DESKTOP;
        }

        /* Darwin */

        if (preg_match('/Darwin\/([0-9]+).[0-9]+/u', $ua, $match)) {
            if (preg_match('/\((?:x86_64|i386|Power%20Macintosh)\)/u', $ua)) {

                /* OS X */
                $this->data->os->name = 'OS X';
                $this->data->device->type = Constants\DeviceType::DESKTOP;

                $version = Data\Darwin::getVersion('osx', $match[1]);
                if ($version) {
                    $this->data->os->version = new Version($version);
                }

                if (preg_match('/CFNetwork\/([0-9\.]+)/u', $ua, $match)) {
                    $version = Data\CFNetwork::getVersion('osx', $match[1]);
                    if ($version) {
                        $this->data->os->version = new Version($version);
                    }
                }
            } else {

                /* iOS */
                $this->data->os->name = 'iOS';
                $this->data->device->type = Constants\DeviceType::MOBILE;

                $version = Data\Darwin::getVersion('ios', $match[1]);
                if ($version) {
                    $this->data->os->version = new Version($version);
                }

                if (preg_match('/CFNetwork\/([0-9\.]+)/u', $ua, $match)) {
                    $version = Data\CFNetwork::getVersion('ios', $match[1]);
                    if ($version) {
                        $this->data->os->version = new Version($version);
                    }
                }
            }
        }

        /* Mac OS */

        if (preg_match('/\(Macintosh;/u', $ua) && !preg_match('/OS X/u', $ua)) {
            $this->data->os->name = 'Mac OS';
            $this->data->device->type = Constants\DeviceType::DESKTOP;
        }
    }


    /* Android */

    private function detectAndroid($ua)
    {
        /* Android */

        if (preg_match('/Android/ui', $ua)) {
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
                $this->data->os->name = 'Android';
                $this->data->os->version = new Version();

                if (preg_match('/Android(?: )?(?:AllPhone_|CyanogenMod_|OUYA )?(?:\/)?v?([0-9.]+)/ui', str_replace('-update', ',', $ua), $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
                }

                if (preg_match('/Android [0-9][0-9].[0-9][0-9].[0-9][0-9]\(([^)]+)\);/u', str_replace('-update', ',', $ua), $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
                }

                if (preg_match('/Android Eclair/u', $ua)) {
                    $this->data->os->version = new Version([ 'value' => '2.0', 'details' => 3 ]);
                }

                if (preg_match('/Android KeyLimePie/u', $ua)) {
                    $this->data->os->version = new Version([ 'value' => '4.4', 'details' => 3 ]);
                }

                if (preg_match('/Android 5.[01].99/u', $ua)) {
                    $this->data->os->version = new Version([ 'value' => '6', 'details' => 3, 'alias' => 'M' ]);
                }

                $this->data->device->type = Constants\DeviceType::MOBILE;

                if ($this->data->os->version->toFloat() >= 3) {
                    $this->data->device->type = Constants\DeviceType::TABLET;
                }

                if ($this->data->os->version->toFloat() >= 4 && preg_match('/Mobile/u', $ua)) {
                    $this->data->device->type = Constants\DeviceType::MOBILE;
                }



                if (preg_match('/Eclair; (?:[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?) Build\/([^\/]*)\//u', $ua, $match)) {
                    $this->data->device->model = $match[1];
                } elseif (preg_match('/android\/[0-9.]+ \([^;]+; [^;]+; ([^\)]+)\)$/u', $ua, $match)) {
                    $this->data->device->model = $match[1];
                } elseif (preg_match('/;\+? ?(?:\*\*)?([^;]*[^;\s])\s+[Bb]uild/u', $ua, $match)) {
                    $this->data->device->model = $match[1];
                } elseif (preg_match('/^(?U)([^\/]+)(?U)(?:(?:_CMCC_TD|_CMCC|_TD|_TDLTE|_LTE)?\/[^\/]*)? Linux\/[0-9.+]+ Android\/[0-9.]+/u', $this->removeKnownPrefixes($ua), $match)) {
                    $this->data->device->model = $match[1];
                } elseif (preg_match('/^(?U)([^\/]+)(?U)(?:(?:_CMCC_TD|_CMCC|_TD|_TDLTE|_LTE)?\/[^\/]*)? Android(_OS)?\/[0-9.]+/u', $this->removeKnownPrefixes($ua), $match)) {
                    $this->data->device->model = $match[1];
                } elseif (preg_match('/^(?U)([^\/]+)(?U)(?:(?:_CMCC_TD|_CMCC|_TD|_TDLTE|_LTE)?\/[^\/]*)? Release\/[0-9.]+/u', $this->removeKnownPrefixes($ua), $match)) {
                    $this->data->device->model = $match[1];
                } elseif (preg_match('/Linux;Android [0-9.]+,([^\)]+)\)/u', $ua, $match)) {
                    $this->data->device->model = $match[1];
                } elseif (preg_match('/[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?; ([^;]*[^;\s])\s?;\s+[Bb]uild/u', $ua, $match)) {
                    $this->data->device->model = $match[1];
                } elseif (preg_match('/\(([^;]+);U;Android\/[^;]+;[0-9]+\*[0-9]+;CTC\/2.0\)/u', $ua, $match)) {
                    $this->data->device->model = $match[1];
                } elseif (preg_match('/;\s?([^;]+);\s?[0-9]+\*[0-9]+;\s?CTC\/2.0/u', $ua, $match)) {
                    $this->data->device->model = $match[1];
                } elseif (preg_match('/Android [^;]+; (?:[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?; )?([^)]+)\)/u', $ua, $match)) {
                    if (!preg_match('/[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?/u', $match[1])) {
                        $this->data->device->model = $match[1];
                    }
                }

                /* Sometimes we get a model name that starts with Android, in that case it is a mismatch and we should ignore it */
                if (isset($this->data->device->model) && substr($this->data->device->model, 0, 7) == 'Android') {
                    $this->data->device->model = null;
                }

                /* Sometimes we get a model name that starts with "sprd-", in that case it delete that part */
                if (isset($this->data->device->model) && substr($this->data->device->model, 0, 5) == 'sprd-') {
                    $this->data->device->model = substr($this->data->device->model, 5);
                }

                /* Sometimes we get version and API numbers and display size too */
                if (isset($this->data->device->model) && preg_match('/(.*) - [0-9\.]+ - (?:with Google Apps - )?API [0-9]+ - [0-9]+x[0-9]+/', $this->data->device->model, $matches)) {
                    $this->data->device->model = $matches[1];
                }

                /* Sometimes we get a model that is actually an old style useragent */
                if (isset($this->data->device->model) && preg_match('/([^\/]+?)(?:\/[0-9\.]+)? (?:Android|Release)\//', $this->data->device->model, $matches)) {
                    $this->data->device->model = $matches[1];
                }

                if (isset($this->data->device->model) && $this->data->device->model) {
                    $this->data->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('android', $this->data->device->model);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }

                if (preg_match('/HP eStation/u', $ua)) {
                    $this->data->device->manufacturer = 'HP';
                    $this->data->device->model = 'eStation';
                    $this->data->device->type = Constants\DeviceType::PRINTER;
                    $this->data->device->identified |= Constants\Id::MATCH_UA;
                    $this->data->device->generic = false;
                }
            }
        }

        if (preg_match('/\(Linux; ([^;]+) Build/u', $ua, $match)) {
            $device = Data\DeviceModels::identify('android', $match[1]);
            if ($device->identified) {
                $device->identified |= Constants\Id::PATTERN;
                $device->identified |= $this->data->device->identified;

                $this->data->os->name = 'Android';
                $this->data->device = $device;
            }
        }

        if (preg_match('/\(Linux; U; Linux Ventana; [^;]+; ([^;]+) Build/u', $ua, $match)) {
            $device = Data\DeviceModels::identify('android', $match[1]);
            if ($device->identified) {
                $device->identified |= Constants\Id::PATTERN;
                $device->identified |= $this->data->device->identified;

                $this->data->os->name = 'Android';
                $this->data->device = $device;
            }
        }

        /* Aliyun OS */

        if (preg_match('/Aliyun/u', $ua) || preg_match('/YunOs/ui', $ua)) {
            $this->data->os->name = 'Aliyun OS';
            $this->data->os->family = new Family([ 'name' => 'Android' ]);
            $this->data->os->version = new Version();

            if (preg_match('/YunOs[ \/]([0-9.]+)/iu', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }

            if (preg_match('/AliyunOS ([0-9.]+)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }

            $this->data->device->type = Constants\DeviceType::MOBILE;

            if (preg_match('/; ([^;]*[^;\s])\s+Build/u', $ua, $match)) {
                $this->data->device->model = $match[1];
            }

            if (isset($this->data->device->model)) {
                $this->data->device->identified |= Constants\Id::PATTERN;

                $device = Data\DeviceModels::identify('android', $this->data->device->model);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }
        }

        if (preg_match('/Android/u', $ua)) {
            if (preg_match('/Android v(1.[0-9][0-9])_[0-9][0-9].[0-9][0-9]-/u', $ua, $match)) {
                $this->data->os->name = 'Aliyun OS';
                $this->data->os->family = new Family([ 'name' => 'Android' ]);
                $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }

            if (preg_match('/Android[ \/](1.[0-9].[0-9].[0-9]+)-R?T/u', $ua, $match)) {
                $this->data->os->name = 'Aliyun OS';
                $this->data->os->family = new Family([ 'name' => 'Android' ]);
                $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }

            if (preg_match('/Android ([12].[0-9].[0-9]+)-R-20[0-9]+/u', $ua, $match)) {
                $this->data->os->name = 'Aliyun OS';
                $this->data->os->family = new Family([ 'name' => 'Android' ]);
                $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }

            if (preg_match('/Android 20[0-9]+\./u', $ua, $match)) {
                $this->data->os->name = 'Aliyun OS';
                $this->data->os->family = new Family([ 'name' => 'Android' ]);
                $this->data->os->version = null;
            }
        }

        /* Baidu Yi */

        if (preg_match('/Baidu Yi/u', $ua)) {
            $this->data->os->name = 'Baidu Yi';
            $this->data->os->family = new Family([ 'name' => 'Android' ]);
            $this->data->os->version = null;
        }

        /* Google TV */

        if (preg_match('/GoogleTV/u', $ua)) {
            $this->data->os->name = 'Google TV';
            $this->data->os->family = new Family([ 'name' => 'Android' ]);

            $this->data->device->type = Constants\DeviceType::TELEVISION;

            if (preg_match('/GoogleTV [0-9\.]+; ?([^;]*[^;\s])\s+Build/u', $ua, $match)) {
                $this->data->device->model = $match[1];
            }

            if (isset($this->data->device->model) && $this->data->device->model) {
                $this->data->device->identified |= Constants\Id::PATTERN;

                $device = Data\DeviceModels::identify('android', $this->data->device->model);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }
        }

        /* WoPhone */

        if (preg_match('/WoPhone/u', $ua)) {
            $this->data->os->name = 'WoPhone';
            $this->data->os->family = new Family([ 'name' => 'Android' ]);

            if (preg_match('/WoPhone\/([0-9\.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->device->type = Constants\DeviceType::MOBILE;
        }

        /* COS */

        if (preg_match('/COS[\/ ]?([0-9]\.[0-9.]+)/ui', $ua, $match)) {
            $this->data->os->name = 'COS';
            $this->data->os->family = new Family([ 'name' => 'Android' ]);
            $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
        } elseif (preg_match('/(?:\(|; )Chinese Operating System ([0-9]\.[0-9.]*);/ui', $ua, $match)) {
            $this->data->os->name = 'COS';
            $this->data->os->family = new Family([ 'name' => 'Android' ]);
            $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
        } elseif (preg_match('/COS like Android/ui', $ua, $match)) {
            $this->data->os->name = 'COS';
            $this->data->os->family = new Family([ 'name' => 'Android' ]);
            $this->data->os->version = null;
            $this->data->device->type = Constants\DeviceType::MOBILE;
        } elseif (preg_match('/(COS like Android|COSBrowser\/|\(COS;|\(COS 998;)/ui', $ua, $match)) {
            $this->data->os->name = 'COS';
            $this->data->os->family = new Family([ 'name' => 'Android' ]);
        }
    }

    private function determineAndroidVersionBasedOnBuild($ua)
    {
        if ($this->data->isOs('Linux') || $this->data->isOs('Android')) {
            if (preg_match('/Build\/([^\);]+)/u', $ua, $match)) {
                $version = Data\BuildIds::identify($match[1]);
                if ($version) {
                    if (!isset($this->data->os->version) || $this->data->os->version == null || $this->data->os->version->value == null || $version->toFloat() < $this->data->os->version->toFloat()) {
                        $this->data->os->version = $version;
                    }

                    /* Special case for Android L */
                    if ($version->toFloat() == 5) {
                        $this->data->os->version = $version;
                    }

                    if (!$this->data->isOs('Android')) {
                        $this->data->os->name = 'Android';
                    }
                }

                $this->data->os->build = $match[1];
            }
        }
    }


    /* Windows */

    private function detectWindows($ua)
    {
        if (preg_match('/(Windows|WinNT|WinCE|WinMobile|Win ?[9MX]|Win(16|32))/u', $ua)) {
            $this->data->os->name = 'Windows';
            $this->data->device->type = Constants\DeviceType::DESKTOP;


            /* Windows NT */

            if (preg_match('/Windows 2000/u', $ua)) {
                $this->data->os->version = new Version([ 'value' => '5.0', 'alias' => '2000' ]);
            }

            if (preg_match('/Windows XP/u', $ua) || preg_match('/WinXP/u', $ua)) {
                $this->data->os->version = new Version([ 'value' => '5.1', 'alias' => 'XP' ]);
            }

            if (preg_match('/Windows Vista/u', $ua)) {
                $this->data->os->version = new Version([ 'value' => '6.0', 'alias' => 'Vista' ]);
            }

            if (preg_match('/(?:Windows NT |WinNT)([0-9][0-9]?\.[0-9])/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);

                switch ($match[1]) {
                    case '10.1':
                    case '10.0':
                    case '6.4':
                        $this->data->os->version = new Version([ 'value' => $match[1], 'alias' => '10' ]);
                        break;

                    case '6.3':
                        if (preg_match('/; ARM;/u', $ua)) {
                            $this->data->os->version = new Version([ 'value' => $match[1], 'alias' => 'RT 8.1' ]);
                        } else {
                            $this->data->os->version = new Version([ 'value' => $match[1], 'alias' => '8.1' ]);
                        }
                        break;

                    case '6.2':
                        if (preg_match('/; ARM;/u', $ua)) {
                            $this->data->os->version = new Version([ 'value' => $match[1], 'alias' => 'RT' ]);
                        } else {
                            $this->data->os->version = new Version([ 'value' => $match[1], 'alias' => '8' ]);
                        }
                        break;

                    case '6.1':
                        $this->data->os->version = new Version([ 'value' => $match[1], 'alias' => '7' ]);
                        break;
                    case '6.0':
                        $this->data->os->version = new Version([ 'value' => $match[1], 'alias' => 'Vista' ]);
                        break;
                    case '5.2':
                        $this->data->os->version = new Version([ 'value' => $match[1], 'alias' => 'Server 2003' ]);
                        break;
                    case '5.1':
                        $this->data->os->version = new Version([ 'value' => $match[1], 'alias' => 'XP' ]);
                        break;
                    case '5.0':
                        $this->data->os->version = new Version([ 'value' => $match[1], 'alias' => '2000' ]);
                        break;
                    default:
                        $this->data->os->version = new Version([ 'value' => $match[1], 'alias' => 'NT ' . $match[1] ]);
                        break;
                }
            }


            /* Windows */

            if (preg_match('/Windows 95/u', $ua) || preg_match('/Win95/u', $ua)) {
                $this->data->os->version = new Version([ 'value' => '4.0', 'alias' => '95' ]);
            }

            if (preg_match('/Windows 98/u', $ua) || preg_match('/Win98/u', $ua)) {
                $this->data->os->version = new Version([ 'value' => '4.1', 'alias' => '98' ]);
            }

            if (preg_match('/Windows M[eE]/u', $ua) || preg_match('/WinME/u', $ua)) {
                $this->data->os->version = new Version([ 'value' => '4.9', 'alias' => 'ME' ]);
            }

            if (preg_match('/(?:Windows|Win 9x) (([1234]\.[0-9])[0-9\.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);

                switch ($match[2]) {
                    case '4.0':
                        $this->data->os->version = new Version([ 'value' => '4.0', 'alias' => '95' ]);
                        break;
                    case '4.1':
                        $this->data->os->version = new Version([ 'value' => '4.1', 'alias' => '98' ]);
                        break;
                    case '4.9':
                        $this->data->os->version = new Version([ 'value' => '4.9', 'alias' => 'ME' ]);
                        break;
                }
            }


            /* Windows Mobile and Windows Phone */

            if (preg_match('/WPDesktop/u', $ua)) {
                $this->data->os->name = 'Windows Phone';
                $this->data->os->version = new Version([ 'value' => '8.0', 'details' => 2 ]);
                $this->data->device->type = Constants\DeviceType::MOBILE;
                $this->data->browser->mode = 'desktop';
            }

            if (preg_match('/WP7/u', $ua)) {
                $this->data->os->name = 'Windows Phone';
                $this->data->os->version = new Version([ 'value' => '7', 'details' => 1 ]);
                $this->data->device->type = Constants\DeviceType::MOBILE;
                $this->data->browser->mode = 'desktop';
            }

            if (preg_match('/WinMobile/u', $ua)) {
                $this->data->os->name = 'Windows Mobile';
                $this->data->device->type = Constants\DeviceType::MOBILE;

                if (preg_match('/WinMobile\/([0-9.]*)/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
                }
            }

            if (preg_match('/Windows CE/u', $ua) || preg_match('/WinCE/u', $ua) || preg_match('/WindowsCE/u', $ua)) {
                $this->data->device->type = Constants\DeviceType::MOBILE;

                if (preg_match('/ IEMobile/u', $ua)) {
                    $this->data->os->name = 'Windows Mobile';

                    if (preg_match('/ IEMobile 8/u', $ua)) {
                        $this->data->os->version = new Version([ 'value' => '6.5', 'details' => 2 ]);
                    }

                    if (preg_match('/ IEMobile 7/u', $ua)) {
                        $this->data->os->version = new Version([ 'value' => '6.1', 'details' => 2 ]);
                    }

                    if (preg_match('/ IEMobile 6/u', $ua)) {
                        $this->data->os->version = new Version([ 'value' => '6.0', 'details' => 2 ]);
                    }
                } else {
                    $this->data->os->name = 'Windows CE';

                    if (preg_match('/WindowsCEOS\/([0-9.]*)/u', $ua, $match)) {
                        $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
                    }

                    if (preg_match('/Windows CE ([0-9.]*)/u', $ua, $match)) {
                        $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
                    }
                }


                $model = null;

                if (empty($model) && preg_match('/IEMobile [0-9.]+\)  ?(?:PPC; |SP; |Smartphone; )?(?:[0-9]+[Xx][0-9]+;? )?(?:VZW; )?([^;\(]+)/u', $ua, $match)) {
                    if (!preg_match('/(Profile\/MIDP|UNTRUSTED)/u', $match[1])) {
                        $model = $match[1];
                    }
                }

                if (empty($model) && preg_match('/IEMobile [0-9.]+\) (?:PPC|SP|Smartphone); (?:[0-9]+[Xx][0-9]+;? )([^;]+) Profile\/MIDP/u', $ua, $match)) {
                    $model = $match[1];
                }

                if (empty($model) && preg_match('/MSIE [0-9.]+; Windows CE; (?:PPC|SP|Smartphone); [0-9]+x[0-9]+; ([^;\)]+)\)$/u', $ua, $match)) {
                    $model = $match[1];
                }

                if (empty($model) && preg_match('/MSIE [0-9.]+; Windows CE; (?:PPC|SP|Smartphone); [0-9]+x[0-9]+; ([^;]+); (?:PPC|OpVer)/u', $ua, $match)) {
                    $model = $match[1];
                }

                if (empty($model) && preg_match('/MSIE [0-9.]+; Windows CE; (?:PPC|SP|Smartphone); ([^;]+) Profile\/MIDP/u', $ua, $match)) {
                    $model = $match[1];
                }

                if (empty($model) && preg_match('/MSIE [0-9.]+; Windows CE; (?:PPC|SP|Smartphone) ([^;\(]+)[;\/] [0-9]+x[0-9]+/u', $ua, $match)) {
                    $model = $match[1];
                }

                if (empty($model) && preg_match('/MSIE [0-9.]+; Windows CE; ([^;\(]+); [0-9]+x[0-9]+\)/u', $ua, $match)) {
                    if (!preg_match('/^(Smartphone|PPC$)/u', $match[1])) {
                        $model = $match[1];
                    }
                }

                if (empty($model) && preg_match('/MSIE [0-9.]+; Windows CE; ([^;\(]+);? ?(?:PPC|SP|Smartphone); ?[0-9]+x[0-9]+/u', $ua, $match)) {
                    if (!preg_match('/^(MIDP-2.0)/u', $match[1])) {
                        $model = $match[1];
                    }
                }

                if (empty($model) && preg_match('/MSIE [0-9.]+; Windows CE; ([^;\)]+)(?:; (?:PPC|SP|Smartphone); [0-9]+x[0-9]+)?\)( \[[a-zA-Z\-]+\])?$/u', $ua, $match)) {
                    if (!preg_match('/^(IEMobile|MIDP-2.0|Smartphone|PPC$)/u', $match[1])) {
                        $model = $match[1];
                    }
                }

                if (!empty($model)) {
                    $model = preg_replace('/(HTC\/|Toshiba\/)/', '', $model);

                    $this->data->device->model = $model;
                    $this->data->device->identified |= Constants\Id::PATTERN;
                    $this->data->os->name = 'Windows Mobile';

                    $device = Data\DeviceModels::identify('wm', $model);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }
            }

            if (preg_match('/Microsoft Windows; PPC/u', $ua)) {
                $this->data->os->name = 'Windows Mobile';
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }


            /* Detect models in common places */

            if (preg_match('/Windows ?Mobile/u', $ua)) {
                $this->data->os->name = 'Windows Mobile';
                $this->data->device->type = Constants\DeviceType::MOBILE;

                if (preg_match('/Windows ?Mobile[\/ ]([0-9.]*)/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
                }

                if (preg_match('/Windows Mobile; (?:SHARP\/)?([^;]+); (?:PPC|Smartphone);/u', $ua, $match)) {
                    $this->data->device->model = $match[1];
                    $this->data->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('wm', $match[1]);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }

                if (preg_match('/\(([^;]+); U; Windows Mobile/u', $ua, $match)) {
                    $this->data->device->model = $match[1];
                    $this->data->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('wm', $match[1]);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }
            }

            if (preg_match('/Windows Phone/u', $ua) || preg_match('/WPDesktop/u', $ua) || preg_match('/ZuneWP7/u', $ua)) {
                $this->data->os->name = 'Windows Phone';
                $this->data->device->type = Constants\DeviceType::MOBILE;

                if (preg_match('/Windows Phone(?: OS)?[ \/]([0-9.]*)/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

                    if (intval($match[1]) < 7) {
                        $this->data->os->name = 'Windows Mobile';
                    }
                }

                /* Windows Mobile 6.5 */
                if (preg_match('/Windows NT 5.1; ([^;]+); Windows Phone/u', $ua, $match)) {
                    $this->data->device->model = $match[1];
                    $this->data->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('wm', $match[1]);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }

                /* Windows Phone 7 (buggy) */
                if (preg_match('/Windows Phone OS [^;]+; Trident\/[^;]+; IEMobile\/[^;]+\) ([A-Z\s]+); ?([^\/,]+)/ui', $ua, $match)) {
                    $this->data->device->manufacturer = $match[1];
                    $this->data->device->model = $match[2];
                    $this->data->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('wp', $match[2]);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }

                /* Windows Phone 7 and 8 */
                if (preg_match('/IEMobile\/[^;]+;(?: ARM; Touch; )?(?:rv:[0-9]+; )?(?: WpsLondonTest; )?\s*([^;\s][^;\)]*);\s*([^;\)\s][^;\)]*)[;|\)]/u', $ua, $match)) {
                    $this->data->device->manufacturer = $match[1];
                    $this->data->device->model = $match[2];
                    $this->data->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('wp', $match[2]);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }

                /* Windows Phone 10 */
                if (preg_match('/Windows Phone 1[0-9]\.[0-9]; Android [0-9\.]+; (?:WebView\/[0-9\.]+; )?([^;\s][^;]*);\s*([^;\)\s][^;\)]*)[;|\)]/u', $ua, $match)) {
                    $this->data->device->manufacturer = $match[1];
                    $this->data->device->model = $match[2];
                    $this->data->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('wp', $match[2]);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }

                /* Third party browsers */
                if (preg_match('/IEMobile\/[^;]+;(?: ARM; Touch; )?\s*(?:[^\/]+\/[^\/]+);\s*([^;\s][^;]*);\s*([^;\)\s][^;\)]*)[;|\)]/u', $ua, $match)) {
                    $this->data->device->manufacturer = $match[1];
                    $this->data->device->model = $match[2];
                    $this->data->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('wp', $match[2]);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }

                if (preg_match('/\(Windows Phone OS\/[0-9\.]+; ([^:]+):([^;]+); [a-z]+(?:\-[a-z]+)?\)/iu', $ua, $match)) {
                    $this->data->device->manufacturer = $match[1];
                    $this->data->device->model = $match[2];
                    $this->data->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('wp', $match[2]);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }

                /* Desktop mode of WP 8.1 */
                if (preg_match('/WPDesktop;\s*([^;\)]*)(?:;\s*([^;\)]*))?(?:;\s*([^;\)]*))?\) like Gecko/u', $ua, $match)) {
                    if (preg_match("/^[A-Z]+$/", $match[1])) {
                        $this->data->device->manufacturer = $match[1];
                        $this->data->device->model = $match[2];
                    } else {
                        $this->data->device->model = $match[1];
                    }

                    $this->data->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('wp', $this->data->device->model);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }

                /* Desktop mode of WP 7 */
                if (preg_match('/XBLWP7; ZuneWP7; ([^\)]+)\)/u', $ua, $match)) {
                    $this->data->device->model = $match[1];
                    $this->data->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('wp', $match[1]);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }

                /* Desktop mode of WP 8.0 and 8.1 Update (buggy version) */
                if (preg_match('/Touch; WPDesktop;\s*([^;\)]*)(?:;\s*([^;\)]*))?(?:;\s*([^;\)]*))?\)/u', $ua, $match)) {
                    if (preg_match("/^[A-Z]+$/", $match[1]) && isset($match[2])) {
                        $this->data->device->manufacturer = $match[1];
                        $this->data->device->model = $match[2];
                    } else {
                        $this->data->device->model = $match[1];
                    }

                    $this->data->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('wp', $this->data->device->model);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }

                if (isset($this->data->device->manufacturer) && isset($this->data->device->model)) {
                    if ($this->data->device->manufacturer == 'ARM' && $this->data->device->model == 'Touch') {
                        $this->data->device->manufacturer = null;
                        $this->data->device->model = null;
                        $this->data->device->identified = Constants\Id::NONE;
                    }

                    if ($this->data->device->manufacturer == 'Microsoft' && $this->data->device->model == 'XDeviceEmulator') {
                        $this->data->device->manufacturer = null;
                        $this->data->device->model = null;
                        $this->data->device->type = Constants\DeviceType::EMULATOR;
                        $this->data->device->identified |= Constants\Id::MATCH_UA;
                    }
                }
            }
        } elseif (preg_match('/WMPRO/u', $ua)) {
            $this->data->os->name = 'Windows Mobile';
            $this->data->device->type = Constants\DeviceType::MOBILE;
        }
    }


    /* Jolla Sailfish */

    private function detectSailfish($ua)
    {
        if (preg_match('/Sailfish;/u', $ua)) {
            $this->data->os->name = 'Sailfish';
            $this->data->os->version = null;

            if (preg_match('/Jolla;/u', $ua)) {
                $this->data->device->manufacturer = 'Jolla';
            }

            if (preg_match('/Mobile/u', $ua)) {
                $this->data->device->model = 'Phone';
                $this->data->device->type = Constants\DeviceType::MOBILE;
                $this->data->device->identified = Constants\Id::PATTERN;
            }

            if (preg_match('/Tablet/u', $ua)) {
                $this->data->device->model = 'Tablet';
                $this->data->device->type = Constants\DeviceType::TABLET;
                $this->data->device->identified = Constants\Id::PATTERN;
            }
        }
    }


    /* Bada */

    private function detectBada($ua)
    {
        if (preg_match('/[b|B]ada/u', $ua)) {
            $this->data->os->name = 'Bada';

            if (preg_match('/[b|B]ada[\/ ]([0-9.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            }

            $this->data->device->type = Constants\DeviceType::MOBILE;

            if (preg_match('/\(([^;]+); ([^\/]+)\//u', $ua, $match)) {
                if ($match[1] != 'Bada') {
                    $this->data->device->manufacturer = $match[1];
                    $this->data->device->model = $match[2];
                    $this->data->device->identified = Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('bada', $match[2]);

                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }
            }
        }
    }


    /* Tizen */

    private function detectTizen($ua)
    {
        if (preg_match('/Tizen/u', $ua)) {
            $this->data->os->name = 'Tizen';

            if (preg_match('/Tizen[\/ ]([0-9.]*[0-9])/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
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
                    $this->data->device->manufacturer = $match[1];
                    $this->data->device->model = $match[2];
                    $this->data->device->identified = Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('tizen', $match[2]);

                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
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
                    $this->data->device->model = $match[2];
                    $this->data->device->identified = Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('tizen', $match[2]);

                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }
            }


            if (!$this->data->device->type && preg_match('/Mobile/iu', $ua, $match)) {
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }


            if (preg_match('/\(SMART[ -]TV;/iu', $ua, $match)) {
                $this->data->device->type = Constants\DeviceType::TELEVISION;
                $this->data->device->manufacturer = 'Samsung';
                $this->data->device->series = 'Smart TV';
                $this->data->device->identified = Constants\Id::PATTERN;
            }


            if (preg_match('/(?:Samsung|Tizen ?)Browser\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->name = "Samsung Browser";
                $this->data->browser->channel = null;
                $this->data->browser->stock = true;
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
                $this->data->browser->channel = null;
            }
        }

        if (preg_match('/Linux\; U\; Android [0-9.]+\; ko\-kr\; SAMSUNG\; (NX[0-9]+[^\)]]*)/u', $ua, $match)) {
            $this->data->os->name = 'Tizen';
            $this->data->os->version = null;

            $this->data->device->type = Constants\DeviceType::CAMERA;
            $this->data->device->manufacturer = 'Samsung';
            $this->data->device->model = $match[1];
            $this->data->device->identified = Constants\Id::PATTERN;
        }
    }


    /* Symbian */

    private function detectSymbian($ua)
    {
        /* Series 80 */

        if (preg_match('/Series80\/([0-9.]*)/u', $ua, $match)) {
            $this->data->os->name = 'Series80';
            $this->data->os->version = new Version([ 'value' => $match[1] ]);
            $this->data->os->family = new Family([ 'name' => 'Symbian' ]);
            $this->data->device->type = Constants\DeviceType::MOBILE;
        }

        /* Series 60 */

        if (preg_match('/Symbian\/3/u', $ua)) {
            $this->data->os->name = 'Series60';
            $this->data->os->version = new Version([ 'value' => '5.2' ]);
            $this->data->os->family = new Family([ 'name' => 'Symbian' ]);
            $this->data->device->type = Constants\DeviceType::MOBILE;
        }

        if (preg_match('/Series[ ]?60/u', $ua) || preg_match('/S60[V\/;]/u', $ua)) {
            $this->data->os->name = 'Series60';
            $this->data->os->family = new Family([ 'name' => 'Symbian' ]);
            $this->data->device->type = Constants\DeviceType::MOBILE;

            if (preg_match('/Series60\/([0-9.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            if (preg_match('/S60\/([0-9.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            if (preg_match('/S60V([0-9.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }
        }

        /* UIQ */

        if (preg_match('/UIQ\/([0-9.]*)/u', $ua, $match)) {
            $this->data->os->name = 'UIQ';
            $this->data->os->version = new Version([ 'value' => $match[1] ]);
            $this->data->os->family = new Family([ 'name' => 'Symbian' ]);
            $this->data->device->type = Constants\DeviceType::MOBILE;
        }

        /* Symbian */

        if (preg_match('/Symbian/u', $ua)) {
            $this->data->os->family = new Family([ 'name' => 'Symbian' ]);

            if (preg_match('/SymbianOS\/([0-9.]*)/u', $ua, $match)) {
                $this->data->os->family->version = new Version([ 'value' => $match[1] ]);
            }
        }


        if ($this->data->os->isFamily('Symbian')) {
            if (preg_match('/Nokia-?([^\/;\)\s]+)[\s|\/|;|\)]/u', $ua, $match)) {
                if ($match[1] != 'Browser') {
                    $this->data->device->manufacturer = 'Nokia';
                    $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                    $this->data->device->identified |= Constants\Id::PATTERN;
                }
            }

            if (preg_match('/Symbian(?:\/3)?; U; (?:Nokia)?([^;]+); [a-z][a-z](?:\-[a-z][a-z])?/u', $ua, $match)) {
                $this->data->device->manufacturer = 'Nokia';
                $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                $this->data->device->identified |= Constants\Id::PATTERN;
            }

            if (preg_match('/Vertu([^\/;]+)[\/|;]/u', $ua, $match)) {
                $this->data->device->manufacturer = 'Vertu';
                $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                $this->data->device->identified |= Constants\Id::PATTERN;
            }

            if (preg_match('/Samsung\/([^;]*);/u', $ua, $match)) {
                $this->data->device->manufacturer = 'Samsung';
                $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                $this->data->device->identified |= Constants\Id::PATTERN;
            }

            if (isset($this->data->device->model)) {
                $device = Data\DeviceModels::identify('symbian', $this->data->device->model);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }
        }
    }

    private function detectNokiaOs($ua)
    {
        /* Series 40 */

        if (preg_match('/Series40/u', $ua)) {
            $this->data->os->name = 'Series40';

            if (preg_match('/Nokia([^\/]+)\//u', $ua, $match)) {
                $this->data->device->manufacturer = 'Nokia';
                $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                $this->data->device->identified |= Constants\Id::PATTERN;
            }

            if (isset($this->data->device->model)) {
                $device = Data\DeviceModels::identify('s40', $this->data->device->model);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            if (isset($this->data->device->model)) {
                $device = Data\DeviceModels::identify('asha', $this->data->device->model);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->os->name = 'Nokia Asha Platform';
                    $this->data->os->version = new Version([ 'value' => '1.0' ]);
                    $this->data->device = $device;
                }

                if (preg_match('/java_runtime_version=Nokia_Asha_([0-9_]+);/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
                }
            }

            $this->data->device->type = Constants\DeviceType::MOBILE;
        }

        /* Series 30+ */

        if (preg_match('/Series30Plus/u', $ua)) {
            $this->data->os->name = 'Series30+';

            if (preg_match('/Nokia([^\/]+)\//u', $ua, $match)) {
                $this->data->device->manufacturer = 'Nokia';
                $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                $this->data->device->identified |= Constants\Id::PATTERN;
            }

            if (isset($this->data->device->model)) {
                $device = Data\DeviceModels::identify('s30plus', $this->data->device->model);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            $this->data->device->type = Constants\DeviceType::MOBILE;
        }

        /* Meego */

        if (preg_match('/MeeGo/u', $ua)) {
            $this->data->os->name = 'MeeGo';
            $this->data->device->type = Constants\DeviceType::MOBILE;

            if (preg_match('/Nokia([^\);]+)\)/u', $ua, $match)) {
                $this->data->device->manufacturer = 'Nokia';
                $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                $this->data->device->identified |= Constants\Id::PATTERN;
                $this->data->device->generic = false;
            }
        }

        /* Maemo */

        if (preg_match('/Maemo/u', $ua)) {
            $this->data->os->name = 'Maemo';
            $this->data->device->type = Constants\DeviceType::MOBILE;

            if (preg_match('/(N[0-9]+)/u', $ua, $match)) {
                $this->data->device->manufacturer = 'Nokia';
                $this->data->device->model = $match[1];
                $this->data->device->identified |= Constants\Id::PATTERN;
                $this->data->device->generic = false;
            }
        }

        /* GEOS */

        if (preg_match('/Geos ([0-9.]+)/u', $ua, $match)) {
            $this->data->os->name = 'GEOS';
            $this->data->os->version = new Version([ 'value' => $match[1] ]);
            $this->data->device->type = Constants\DeviceType::MOBILE;

            if (preg_match('/Nokia-([0-9]{4,4}[a-z]?)/u', $ua, $match)) {
                $this->data->device->manufacturer = 'Nokia';
                $this->data->device->model = $match[1];
                $this->data->device->identified |= Constants\Id::PATTERN;
                $this->data->device->generic = false;
            }
        }
    }


    /* WebOS */

    private function detectWebos($ua)
    {
        if (preg_match('/(?:web|hpw)OS\/(?:HP webOS )?([0-9.]*)/u', $ua, $match)) {
            $this->data->os->name = 'webOS';
            $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->device->type = preg_match('/Tablet/iu', $ua) ? Constants\DeviceType::TABLET : Constants\DeviceType::MOBILE;
            $this->data->device->generic = false;
        }

        if (preg_match('/(?:Spark|elite)\/fzz/u', $ua, $match) || preg_match('/webOSBrowser/u', $ua, $match)) {
            $this->data->os->name = 'webOS';
            $this->data->device->type = preg_match('/Tablet/iu', $ua) ? Constants\DeviceType::TABLET : Constants\DeviceType::MOBILE;
            $this->data->device->generic = false;
        }

        if ($this->data->isOs('webOS')) {
            if (preg_match('/Pre\/1.0/u', $ua)) {
                $this->data->device->manufacturer = 'Palm';
                $this->data->device->model = 'Pre';
            }
            if (preg_match('/Pre\/1.1/u', $ua)) {
                $this->data->device->manufacturer = 'Palm';
                $this->data->device->model = 'Pre Plus';
            }
            if (preg_match('/Pre\/1.2/u', $ua)) {
                $this->data->device->manufacturer = 'Palm';
                $this->data->device->model = 'Pre 2';
            }
            if (preg_match('/Pre\/3.0/u', $ua)) {
                $this->data->device->manufacturer = 'Palm';
                $this->data->device->model = 'Pre 3';
            }
            if (preg_match('/Pixi\/1.0/u', $ua)) {
                $this->data->device->manufacturer = 'Palm';
                $this->data->device->model = 'Pixi';
            }
            if (preg_match('/Pixi\/1.1/u', $ua)) {
                $this->data->device->manufacturer = 'Palm';
                $this->data->device->model = 'Pixi Plus';
            }
            if (preg_match('/P160UN?A?\/1.0/u', $ua)) {
                $this->data->device->manufacturer = 'HP';
                $this->data->device->model = 'Veer';
            }
            if (preg_match('/TouchPad\/1.0/u', $ua)) {
                $this->data->device->manufacturer = 'HP';
                $this->data->device->model = 'TouchPad';
            }

            if (preg_match('/Emulator\//u', $ua) || preg_match('/Desktop\//u', $ua)) {
                $this->data->device->type = Constants\DeviceType::EMULATOR;
                $this->data->device->manufacturer = null;
                $this->data->device->model = null;
            }

            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }
    }


    /* BlackBerry */

    private function detectBlackberry($ua)
    {
        /* BlackBerry OS */

        if (preg_match('/RIM([0-9]{3,3})/u', $ua, $match)) {
            $this->data->os->name = 'BlackBerry OS';
            $this->data->device->manufacturer = 'RIM';
            $this->data->device->model = $match[1];
            $this->data->device->type = Constants\DeviceType::MOBILE;
            $this->data->device->identified = Constants\Id::INFER;
        }

        if (preg_match('/BlackBerry/u', $ua) && !preg_match('/BlackBerry Runtime for Android Apps/u', $ua)) {
            $this->data->os->name = 'BlackBerry OS';

            $this->data->device->model = 'BlackBerry';
            $this->data->device->manufacturer = 'RIM';
            $this->data->device->type = Constants\DeviceType::MOBILE;
            $this->data->device->identified = Constants\Id::INFER;

            if (!preg_match('/Opera/u', $ua)) {
                if (preg_match('/BlackBerry([0-9]+[ei]?)\/([0-9.]*)/u', $ua, $match)) {
                    $this->data->device->model = $match[1];
                    $this->data->os->version = new Version([ 'value' => $match[2], 'details' => 2 ]);
                }

                if (preg_match('/; BlackBerry ([0-9]*);/u', $ua, $match)) {
                    $this->data->device->model = $match[1];
                }

                if (preg_match('/; ([0-9]+)[^;\)]+\)/u', $ua, $match)) {
                    $this->data->device->model = $match[1];
                }

                if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
                }

                if (isset($this->data->os->version) && $this->data->os->version->toFloat() >= 10) {
                    $this->data->os->name = 'BlackBerry';
                }

                if ($this->data->device->model) {
                    $device = Data\DeviceModels::identify('blackberry', $this->data->device->model);

                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }
            }
        }

        /* BlackBerry 10 */

        if (preg_match('/\(BB(1[^;]+); ([^\)]+)\)/u', $ua, $match)) {
            $this->data->os->name = 'BlackBerry';
            $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

            $this->data->device->manufacturer = 'BlackBerry';
            $this->data->device->model = $match[2];

            if ($this->data->device->model == 'Kbd') {
                $this->data->device->model = 'Q series or Passport';
            }

            if ($this->data->device->model == 'Touch') {
                $this->data->device->model = 'A or Z series';
            }

            if ($this->data->device->model == 'STL100-2') {
                $this->data->device->model = 'Z10';
            }

            $this->data->device->type = preg_match('/Mobile/u', $ua) ? Constants\DeviceType::MOBILE : Constants\DeviceType::TABLET;
            $this->data->device->identified |= Constants\Id::MATCH_UA;

            if (preg_match('/Version\/([0-9.]+)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            }
        }

        /* BlackBerry Tablet OS */

        if (preg_match('/RIM Tablet OS ([0-9.]*)/u', $ua, $match)) {
            $this->data->os->name = 'BlackBerry Tablet OS';
            $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

            $this->data->device->manufacturer = 'RIM';
            $this->data->device->model = 'BlackBerry PlayBook';
            $this->data->device->type = Constants\DeviceType::TABLET;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        } elseif (preg_match('/\(PlayBook;/u', $ua) && preg_match('/PlayBook Build\/([0-9.]*)/u', $ua, $match)) {
            $this->data->os->name = 'BlackBerry Tablet OS';
            $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

            $this->data->device->manufacturer = 'RIM';
            $this->data->device->model = 'BlackBerry PlayBook';
            $this->data->device->type = Constants\DeviceType::TABLET;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        } elseif (preg_match('/PlayBook/u', $ua) && !preg_match('/Android/u', $ua)) {
            if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
                $this->data->os->name = 'BlackBerry Tablet OS';
                $this->data->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

                $this->data->device->manufacturer = 'RIM';
                $this->data->device->model = 'BlackBerry PlayBook';
                $this->data->device->type = Constants\DeviceType::TABLET;
                $this->data->device->identified |= Constants\Id::MATCH_UA;
            }
        }

        /* Internal versions of BlackBerry 10 running on the Playbook */

        if ($this->data->isOs('BlackBerry Tablet OS', '>=', 10)) {
            $this->data->os->name = 'BlackBerry';
        }
    }


    /* Chrome OS */

    private function detectChromeos($ua)
    {
        /* ChromeCast */

        if (preg_match('/CrKey/u', $ua) && !preg_match('/Espial/u', $ua)) {
            $this->data->device->manufacturer = 'Google';
            $this->data->device->model = 'Chromecast';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }

        /* Chrome OS */

        if (preg_match('/CrOS/u', $ua)) {
            $this->data->os->name = 'Chrome OS';
            $this->data->device->type = Constants\DeviceType::DESKTOP;
        }
    }


    /* Qtopia */

    private function detectQtopia($ua)
    {
        if (preg_match('/Qtopia/u', $ua)) {
            $this->data->os->name = 'Qtopia';

            if (preg_match('/Qtopia\/([0-9.]+)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }
        }
    }


    /* Unix */

    private function detectUnix($ua)
    {
        /* Unix */

        if (preg_match('/Unix/iu', $ua)) {
            $this->data->os->name = 'Unix';
        }

        /* Unix System V */

        if (preg_match('/(?:UNIX_System_V|UNIX_SV) ([0-9.]*)/u', $ua, $match)) {
            $this->data->os->name = 'UNIX System V';
            $this->data->os->family = new Family([ 'name' => 'UNIX' ]);
            $this->data->os->version = new Version([ 'value' => $match[1] ]);
            $this->data->device->type = Constants\DeviceType::DESKTOP;
        }

        /* Digital Unix */

        if (preg_match('/OSF1?[ _]/u', $ua)) {
            $this->data->os->name = 'Digital Unix';
            $this->data->os->family = new Family([ 'name' => 'UNIX' ]);

            if (preg_match('/OSF1?[ _]V?([0-9.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->device->type = Constants\DeviceType::DESKTOP;
        }

        /* Digital ULTRIX */

        if (preg_match('/ULTRIX/u', $ua)) {
            $this->data->os->name = 'ULTRIX';
            $this->data->os->family = new Family([ 'name' => 'BSD' ]);

            if (preg_match('/ULTRIX ([0-9.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->device->type = Constants\DeviceType::DESKTOP;
        }

        /* HP-UX */

        if (preg_match('/HP-UX/u', $ua)) {
            $this->data->os->name = 'HP-UX';
            $this->data->os->family = new Family([ 'name' => 'UNIX' ]);

            if (preg_match('/HP-UX [A-Z].0?([1-9][0-9.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->device->type = Constants\DeviceType::DESKTOP;
        }

        /* Solaris */

        if (preg_match('/SunOS/u', $ua)) {
            $this->data->os->name = 'Solaris';
            $this->data->os->family = new Family([ 'name' => 'UNIX' ]);

            if (preg_match('/SunOS ([1234]\.[0-9\.]+)/u', $ua, $match)) {
                $this->data->os->name = 'SunOS';
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
                $this->data->os->family = new Family([ 'name' => 'BSD' ]);

                if (preg_match('/SunOS 4\.1\.([1234])/u', $ua, $match)) {
                    $this->data->os->name = 'Solaris';

                    switch ($match[1]) {
                        case '1':
                            $this->data->os->version = new Version([ 'value' => '1.0' ]);
                            break;
                        case '2':
                            $this->data->os->version = new Version([ 'value' => '1.0.1' ]);
                            break;
                        case '3':
                            $this->data->os->version = new Version([ 'value' => '1.1' ]);
                            break;
                        case '4':
                            $this->data->os->version = new Version([ 'value' => '1.1.2' ]);
                            break;
                    }
                }
            }

            if (preg_match('/SunOS 5\.([123456](?:\.[0-9\.]*)?) /u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => '2.' . $match[1] ]);
            } else if (preg_match('/SunOS 5\.([0-9\.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->device->type = Constants\DeviceType::DESKTOP;
        }

        if (preg_match('/Solaris(?: ([0-9\.]+))?;/u', $ua, $match)) {
            $this->data->os->name = 'Solaris';
            $this->data->os->family = new Family([ 'name' => 'UNIX' ]);

            if (preg_match('/Solaris ([0-9\.]+);/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->device->type = Constants\DeviceType::DESKTOP;
        }

        /* AIX */

        if (preg_match('/AIX/u', $ua)) {
            $this->data->os->name = 'AIX';
            $this->data->os->family = new Family([ 'name' => 'UNIX' ]);

            if (preg_match('/AIX ([0-9.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->device->type = Constants\DeviceType::DESKTOP;
        }

        /* IRIX */

        if (preg_match('/IRIX/u', $ua)) {
            $this->data->os->name = 'IRIX';
            $this->data->os->family = new Family([ 'name' => 'UNIX' ]);

            if (preg_match('/IRIX ([0-9.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            if (preg_match('/IRIX;?(?:64|32) ([0-9.]*)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->device->type = Constants\DeviceType::DESKTOP;
        }

        /* Sony NEWS OS */

        if (preg_match('/NEWS-OS ([0-9\.]+)/u', $ua, $match)) {
            $this->data->os->name = 'NEWS OS';
            $this->data->os->version = new Version([ 'value' => $match[1] ]);
            $this->data->os->family = new Family([ 'name' => 'BSD' ]);


            if (preg_match('/NEWS-OS [56]/u', $ua)) {
                $this->data->os->family = new Family([ 'name' => 'UNIX' ]);
            }

            $this->data->device->type = Constants\DeviceType::DESKTOP;
        }

        /* NEC EWS-UX */

        if (preg_match('/EWS-UNIX rev ([0-9\.]+)/u', $ua, $match)) {
            $this->data->os->name = 'EWS-UX';
            $this->data->os->version = new Version([ 'value' => $match[1] ]);
            $this->data->os->family = new Family([ 'name' => 'UNIX' ]);

            $this->data->device->type = Constants\DeviceType::DESKTOP;
        }

        /* National Semiconductors GENIX */

        if (preg_match('/GENIX ([0-9\.]+)/u', $ua, $match)) {
            $this->data->os->name = 'GENIX';
            $this->data->os->version = new Version([ 'value' => $match[1] ]);
            $this->data->os->family = new Family([ 'name' => 'BSD' ]);

            $this->data->device->type = Constants\DeviceType::DESKTOP;
        }
    }


    /* BSD */

    private function detectBsd($ua)
    {
        if (preg_match('/BSD/iu', $ua) || preg_match('/DragonFly/iu', $ua)) {
            if (preg_match('/X11/u', $ua)) {
                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            /* BSD/OS */

            if (preg_match('/BSD\/386/u', $ua)) {
                $this->data->os->name = 'BSD/OS';
                $this->data->os->family = new Family([ 'name' => 'BSD' ]);
            }

            if (preg_match('/BSD\/OS/u', $ua)) {
                $this->data->os->name = 'BSD/OS';
                $this->data->os->family = new Family([ 'name' => 'BSD' ]);

                if (preg_match('/BSD\/OS ([0-9.]*)/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1] ]);
                }
            }

            /* FreeBSD */

            if (preg_match('/FreeBSD/iu', $ua)) {
                $this->data->os->name = 'FreeBSD';
                $this->data->os->family = new Family([ 'name' => 'BSD' ]);

                if (preg_match('/FreeBSD[ -\/]?([0-9.]*)/iu', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1] ]);
                }
            }

            /* OpenBSD */

            if (preg_match('/OpenBSD/iu', $ua)) {
                $this->data->os->name = 'OpenBSD';
                $this->data->os->family = new Family([ 'name' => 'BSD' ]);

                if (preg_match('/OpenBSD ?([0-9.]*)/iu', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1] ]);
                }
            }

            /* NetBSD */

            if (preg_match('/NetBSD/iu', $ua)) {
                $this->data->os->name = 'NetBSD';
                $this->data->os->family = new Family([ 'name' => 'BSD' ]);

                if (preg_match('/NetBSD ?([0-9.]*)/iu', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1] ]);
                }
            }

            /* DragonFly */

            if (preg_match('/DragonFly/iu', $ua)) {
                $this->data->os->name = 'DragonFly BSD';
                $this->data->os->family = new Family([ 'name' => 'BSD' ]);
            }
        }
    }


    /* Linux */

    private function detectLinux($ua)
    {
        if (preg_match('/Linux/u', $ua)) {
            $this->data->os->name = 'Linux';

            if (preg_match('/X11/u', $ua)) {
                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/CentOS/u', $ua)) {
                $this->data->os->name = 'CentOS';
                if (preg_match('/CentOS\/[0-9\.\-]+el([0-9_]+)/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
                }

                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Debian/u', $ua)) {
                $this->data->os->name = 'Debian';
                if (preg_match('/Debian\/([0-9.]*)/iu', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1] ]);
                }

                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Fedora/u', $ua)) {
                $this->data->os->name = 'Fedora';
                if (preg_match('/Fedora\/[0-9\.\-]+fc([0-9]+)/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
                }

                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Gentoo/u', $ua)) {
                $this->data->os->name = 'Gentoo';
                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/gNewSense/u', $ua)) {
                $this->data->os->name = 'gNewSense';
                if (preg_match('/gNewSense\/[^\(]+\(([0-9\.]+)/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1] ]);
                }

                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Kubuntu/u', $ua)) {
                $this->data->os->name = 'Kubuntu';
                if (preg_match('/Kubuntu[ \/]([0-9.]*)/iu', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1] ]);
                }

                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Mandriva Linux/u', $ua)) {
                $this->data->os->name = 'Mandriva';
                if (preg_match('/Mandriva Linux\/[0-9\.\-]+mdv([0-9]+)/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1] ]);
                }

                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Mageia/u', $ua)) {
                $this->data->os->name = 'Mageia';
                if (preg_match('/Mageia\/[0-9\.\-]+mga([0-9]+)/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1] ]);
                }

                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Mandriva/u', $ua)) {
                $this->data->os->name = 'Mandriva';
                if (preg_match('/Mandriva\/[0-9\.\-]+mdv([0-9]+)/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1] ]);
                }

                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/moonOS/u', $ua)) {
                $this->data->os->name = 'moonOS';
                if (preg_match('/moonOS\/([0-9.]+)/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1] ]);
                }

                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Red Hat/u', $ua)) {
                $this->data->os->name = 'Red Hat';
                if (preg_match('/Red Hat[^\/]*\/[0-9\.\-]+el([0-9_]+)/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
                }

                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Slackware/u', $ua)) {
                $this->data->os->name = 'Slackware';
                if (preg_match('/Slackware[ \/](1[0-9.]+)/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1] ]);
                }

                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/SUSE/u', $ua)) {
                $this->data->os->name = 'SUSE';
                if (preg_match('/SUSE\/([0-9]\.[0-9]+)/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1] ]);
                }

                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Turbolinux/u', $ua)) {
                $this->data->os->name = 'Turbolinux';
                if (preg_match('/Turbolinux\/([0-9]\.[0-9]+)/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1] ]);
                }

                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Ubuntu/u', $ua)) {
                $this->data->os->name = 'Ubuntu';
                if (preg_match('/Ubuntu\/([0-9.]*)/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1] ]);
                }

                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/《붉은별》\/([0-9.]*)/iu', $ua, $match)) {
                $this->data->os->name = 'Red Star';
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Fedora\/[0-9\.\-]+rs([0-9\.]+)/u', $ua, $match)) {
                $this->data->os->name = 'Red Star';
                $this->data->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }

            if (preg_match('/Linux\/X2\/R1/u', $ua)) {
                $this->data->os->name = 'LiMo';
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }


            if (preg_match('/Linux\/SLP\/([0-9.]+)/u', $ua, $match)) {
                $this->data->os->name = 'Linux SLP';
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }


            if (preg_match('/LinuxOS\//u', $ua) && preg_match('/Software\/R5/u', $ua)) {
                $this->data->os->name = 'EZX Linux';
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }
        }

        if (preg_match('/\(Ubuntu; (Mobile|Tablet)/u', $ua)) {
            $this->data->os->name = 'Ubuntu Touch';

            if (preg_match('/\(Ubuntu; Mobile/u', $ua)) {
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }
            if (preg_match('/\(Ubuntu; Tablet/u', $ua)) {
                $this->data->device->type = Constants\DeviceType::TABLET;
            }
        }

        if (preg_match('/(?:\(|; )Ubuntu ([0-9.]+) like Android/u', $ua, $match)) {
            $this->data->os->name = 'Ubuntu Touch';
            $this->data->os->version = new Version([ 'value' => $match[1] ]);
            $this->data->device->type = Constants\DeviceType::MOBILE;
        }
    }


    /* Brew */

    private function detectBrew($ua)
    {
        if (preg_match('/REX; U/ui', $ua) || preg_match('/REXL4/ui', $ua)) {
            $this->data->os->name = 'REX';

            $this->data->device->type = Constants\DeviceType::MOBILE;

            if (preg_match('/REX; U; [^;]+; ([^;]+); ([^;\/]+)[^;]*; NetFront/u', $ua, $match)) {
                $this->data->device->manufacturer = Data\Manufacturers::identify(Constants\DeviceType::MOBILE, $match[1]);
                $this->data->device->model = $match[2];
                $this->data->device->identified = Constants\Id::PATTERN;

                $device = Data\DeviceModels::identify('brew', $match[2]);

                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }
        }

        if (preg_match('/[\(\s\-;]BREW[\s\/\-;]/ui', $ua) || preg_match('/BMP( [0-9.]*)?; U/u', $ua) || preg_match('/B(?:rew)?MP\/([0-9.]*)/u', $ua)) {
            $this->data->os->name = 'Brew';

            if (preg_match('/BREW MP/iu', $ua) || preg_match('/B(rew)?MP/iu', $ua)) {
                $this->data->os->name = 'Brew MP';
            }

            if (preg_match('/; Brew ([0-9.]+);/iu', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            } elseif (preg_match('/BREW; U; ([0-9.]+)/iu', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            } elseif (preg_match('/[\(;]BREW[\/ ]([0-9.]+)/iu', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            } elseif (preg_match('/BREW MP ([0-9.]*)/iu', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            } elseif (preg_match('/BMP ([0-9.]*); U/iu', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            } elseif (preg_match('/B(?:rew)?MP\/([0-9.]*)/iu', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->device->type = Constants\DeviceType::MOBILE;

            if (preg_match('/(?:Brew MP|BREW|BMP) [^;]+; U; [^;]+; ([^;]+); NetFront[^\)]+\) [^\s]+ ([^\s]+)/u', $ua, $match)) {
                $this->data->device->manufacturer = Data\Manufacturers::identify(Constants\DeviceType::MOBILE, $match[1]);
                $this->data->device->model = $match[2];
                $this->data->device->identified = Constants\Id::PATTERN;

                $device = Data\DeviceModels::identify('brew', $match[2]);

                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            if (preg_match('/\(([^;]+);U;REX\/[^;]+;BREW\/[^;]+;(?:.*;)?[0-9]+\*[0-9]+(?:;CTC\/2.0)?\)/u', $ua, $match)) {
                $this->data->device->model = $match[1];
                $this->data->device->identified = Constants\Id::PATTERN;

                $device = Data\DeviceModels::identify('brew', $match[1]);

                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            if (preg_match('/\(BREW [^;]+; U; [^;]+; [^;]+; ([^;]+); (Polaris|Netfront)\/[0-9\.]+\/(WAP|AMB|INT)\)/ui', $ua, $match)) {
                $this->data->device->model = $match[1];
                $this->data->device->identified = Constants\Id::PATTERN;

                $device = Data\DeviceModels::identify('brew', $match[1]);

                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            if (preg_match('/\(BREW [^;]+; U; [^;]+; [^;]+; Opera Mobi; Presto\/[0-9\.]+\/(?:WAP|AMB|INT)\) ([^\/]+) [^\/]+\//ui', $ua, $match)) {
                $this->data->device->model = $match[1];
                $this->data->device->identified = Constants\Id::PATTERN;

                $device = Data\DeviceModels::identify('brew', $match[1]);

                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }
        }
    }


    /* Remaining operating systems */

    private function detectRemainingOperatingSystems($ua)
    {
        $patterns = [
            [ 'name' => 'BeOS',         'regexp' => [ '/BeOS/iu' ],                                         'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Haiku',        'regexp' => [ '/Haiku/iu' ],                                        'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'AmigaOS',      'regexp' => [ '/AmigaOS/iu', '/AmigaOS ?([0-9.]+)/iu' ],            'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'MorphOS',      'regexp' => [ '/MorphOS(?: ([0-9.]*))?/iu' ],                       'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'AROS',         'regexp' => [ '/AROS/iu' ],                                         'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'OpenVMS',      'regexp' => [ '/OpenVMS/iu', '/OpenVMS V([0-9.]+)/iu' ],            'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'RISC OS',      'regexp' => [ '/RISC OS/iu', '/RISC OS(?:-NC)? ([0-9.]*)/iu' ],     'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Joli OS',      'regexp' => [ '/Joli OS\/([0-9.]*)/iu' ],                           'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'OS/2',         'regexp' => [ '/OS\/2;(?: (?:U; )?Warp ([0-9.]*))?/iu' ],           'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Inferno',      'regexp' => [ '/Inferno/iu' ],                                      'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Syllable',     'regexp' => [ '/Syllable/iu' ],                                     'type' => Constants\DeviceType::DESKTOP ],

            [ 'name' => 'Grid OS',      'regexp' => [ '/Grid OS ([0-9.]*)/iu' ],                            'type' => Constants\DeviceType::TABLET ],

            [ 'name' => 'MRE',          'regexp' => [ '/\(MTK;/iu', '/\/MTK /iu' ],                         'type' => Constants\DeviceType::MOBILE ],
            [ 'name' => 'MRE',          'regexp' => [ '/MRE\\\\/iu' ],                                      'type' => Constants\DeviceType::MOBILE ],
            [ 'name' => 'MRE',          'regexp' => [ '/MAUI[-_ ](?:Browser|Runtime)/iu' ],                 'type' => Constants\DeviceType::MOBILE ],
            [ 'name' => 'MRE',          'regexp' => [ '/Browser\/MAUI/iu' ],                                'type' => Constants\DeviceType::MOBILE ],

            [ 'name' => 'QNX',          'regexp' => [ '/QNX/iu' ],                                          'type' => Constants\DeviceType::MOBILE ],
            [ 'name' => 'VRE',          'regexp' => [ '/\(VRE;/iu' ],                                       'type' => Constants\DeviceType::MOBILE ],
            [ 'name' => 'SpreadTrum',   'regexp' => [ '/\(SpreadTrum;/iu' ],                                'type' => Constants\DeviceType::MOBILE ],

            [ 'name' => 'EPOC',         'regexp' => [ '/EPOC;/iu' ],                                        'type' => Constants\DeviceType::PDA ],

            [ 'name' => 'ThreadX',      'regexp' => [ '/ThreadX(?:_OS)?\/([0-9.]*)/iu' ] ],
        ];

        $count = count($patterns);
        for ($b = 0; $b < $count; $b++) {
            for ($r = 0; $r < count($patterns[$b]['regexp']); $r++) {

                if (preg_match($patterns[$b]['regexp'][$r], $ua, $match)) {
                    $this->data->os->name = $patterns[$b]['name'];

                    $this->data->os->name = $patterns[$b]['name'];

                    if (isset($match[1]) && $match[1]) {
                        $this->data->os->version = new Version([ 'value' => $match[1], 'details' => isset($patterns[$b]['details']) ? $patterns[$b]['details'] : null ]);
                    } else {
                        $this->data->os->version = null;
                    }

                    if (isset($patterns[$b]['type'])) {
                        $this->data->device->type = $patterns[$b]['type'];
                    }
                }
            }
        }
    }
}
