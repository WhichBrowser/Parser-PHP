<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

trait Mobile
{
    private function detectMobile($ua)
    {
        /* Detect the type based on some common markers */
        $this->detectGenericMobile($ua);

        /* Look for specific manufacturers and models */
        $this->detectKin($ua);

        /* Try to parse some generic methods to store device information */
        $this->detectGenericMobileModels($ua);
    }






    /* Generic markers */

    private function detectGenericMobile($ua)
    {
        if (preg_match('/MIDP/u', $ua)) {
            $this->data->device->type = Constants\DeviceType::MOBILE;
        }
    }


    /* Microsoft KIN */

    private function detectKin($ua)
    {
        if (preg_match('/KIN\.(One|Two) ([0-9.]*)/ui', $ua, $match)) {
            $this->data->os->name = 'Kin OS';
            $this->data->os->version = new Version([ 'value' => $match[2], 'details' => 2 ]);

            switch ($match[1]) {
                case 'One':
                    $this->data->device->manufacturer = 'Microsoft';
                    $this->data->device->model = 'Kin ONE';
                    $this->data->device->identified |= Constants\Id::MATCH_UA;
                    $this->data->device->generic = false;
                    break;

                case 'Two':
                    $this->data->device->manufacturer = 'Microsoft';
                    $this->data->device->model = 'Kin TWO';
                    $this->data->device->identified |= Constants\Id::MATCH_UA;
                    $this->data->device->generic = false;
                    break;
            }
        }
    }


    /* Model information not in a fixed place */

    private function detectGenericMobileModels($ua)
    {
        if (!isset($this->data->device->model) && !isset($this->data->device->manufacturer)) {
            $candidates = [];

            if (!preg_match('/^(Mozilla|Opera)/u', $ua)) {
                if (preg_match('/^(?:MQQBrowser\/[0-9\.]+\/)?([^\s]+)/u', $ua, $match)) {
                    $match[1] = preg_replace('/_TD$/u', '', $match[1]);
                    $match[1] = preg_replace('/_CMCC$/u', '', $match[1]);
                    $match[1] = preg_replace('/[_ ]Mozilla$/u', '', $match[1]);
                    $match[1] = preg_replace('/ Linux$/u', '', $match[1]);
                    $match[1] = preg_replace('/ Opera$/u', '', $match[1]);
                    $match[1] = preg_replace('/\/[0-9].*$/u', '', $match[1]);

                    array_push($candidates, $match[1]);
                }
            }

            if (preg_match('/^((?:SAMSUNG|TCL|ZTE) [^\s]+)/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/(Samsung (?:GT|SCH|SGH|SHV|SHW|SPH)-[A-Z-0-9]+)/ui', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/[0-9]+x[0-9]+; ([^;]+)/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/[0-9]+x[0-9]+; [^;]+; ([^;]+)/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/\s*([^;]*[^\s])\s*; [0-9]+\*[0-9]+\)/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/[0-9]+X[0-9]+ ([^;\/\(\)]+)/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/Windows NT 5.1; ([^;]+); Windows Phone/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/\) PPC; (?:[0-9]+x[0-9]+; )?([^;\/\(\)]+)/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/Windows Mobile; ([^;]+); PPC;/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/\(([^;]+); U; Windows Mobile/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/MSIEMobile [0-9.]+\) ([^\s]+)/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/Series60\/[0-9\.]+ ([^\s]+) Profile/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/Vodafone\/1.0\/([^\/]+)/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/Huawei\/1.0\/0?([^\s]+)/u', $ua, $match)) {
                array_push($candidates, 'HUAWEI-' . $match[1]);
            }

            if (preg_match('/^(DoCoMo[^(]+)/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/\ ([^\s]+)$/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/; ([^;\)]+)\)/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/^(.*)\/UCWEB/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/^([^\s]+\s[^\s]+)\s+Opera/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/^([a-z0-9\.\_\-\+\/ ]+) Linux/iu', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/^([a-z0-9\.\_\-\+\/ ]+) Android/iu', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/\(([a-z0-9\.\_\-\+\/ ]+) Browser/iu', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/^([a-z0-9\.\_\-\+\/ ]+) Release/iu', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/Mozilla\/[0-9.]+ ([a-z0-9\.\-\_\+\/ ]+) Browser/iu', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/ \(([^\)]+)\)/u', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/([a-z][a-z0-9\_]+)\/[a-z]/iu', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/^([a-z0-9\.\_\+\/ ]+)_TD\//iu', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/^$([a-z0-9\.\_\+ ]+)\//iu', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/^([a-z]+\s[a-z0-9\-\_\.]+)/iu', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (preg_match('/(?:DDIPOCKET|WILLCOM);([a-z]+\/[^\/]+)/iu', $ua, $match)) {
                array_push($candidates, $match[1]);
            }

            if (isset($this->data->os->name)) {
                for ($i = 0; $i < count($candidates); $i++) {
                    if (!isset($this->data->device->model) && !isset($this->data->device->manufacturer)) {
                        if (isset($this->data->os->name) && ($this->data->os->name == 'Android' || $this->data->os->name == 'Linux')) {
                            $device = Data\DeviceModels::identify('android', $candidates[$i]);
                            if ($device->identified) {
                                $device->identified |= $this->data->device->identified;
                                $this->data->device = $device;

                                if ($this->data->os->name != 'Android') {
                                    $this->data->os->name = 'Android';
                                    $this->data->os->version = null;
                                }
                            }
                        }

                        if (!isset($this->data->os->name) || $this->data->os->name == 'Windows' || $this->data->os->name == 'Windows Mobile' || $this->data->os->name == 'Windows CE') {
                            $device = Data\DeviceModels::identify('wm', $candidates[$i]);
                            if ($device->identified) {
                                $device->identified |= $this->data->device->identified;
                                $this->data->device = $device;

                                if (isset($this->data->os->name) && $this->data->os->name != 'Windows Mobile') {
                                    $this->data->os->name = 'Windows Mobile';
                                    $this->data->os->version = null;
                                }
                            }
                        }
                    }
                }
            }

            if (!isset($this->data->device->model) && !isset($this->data->device->manufacturer)) {
                $identified = false;

                for ($i = 0; $i < count($candidates); $i++) {
                    if (!$this->data->device->identified) {
                        if (preg_match('/^acer_([^\/]*)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Acer';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^AIRNESS-([^\/]*)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Airness';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^ALCATEL[_-]([^\/]*)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Alcatel';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;

                            if (preg_match('/^TRIBE ([^\s]+)/ui', $this->data->device->model, $match)) {
                                $this->data->device->model = 'One Touch Tribe ' . $match[1];
                            } elseif (preg_match('/^ONE TOUCH ([^\s]*)/ui', $this->data->device->model, $match)) {
                                $this->data->device->model = 'One Touch ' . $match[1];
                            } elseif (preg_match('/^OT[-\s]*([^\s]*)/ui', $this->data->device->model, $match)) {
                                $this->data->device->model = 'One Touch ' . $match[1];
                            }

                            $identified = true;
                        }

                        if (preg_match('/^BenQ-([^\/]*)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'BenQ';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^Bird[ _]([^\/]*)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Bird';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^(?:YL-|YuLong-)?COOLPAD([^\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Coolpad';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^CELKON\.([^\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Celkon';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^Coship ([^\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Coship';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^Cricket-([^\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Cricket';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^DESAY[ _]([^\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'DESAY';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^Diamond_([^\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Diamond';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^DoCoMo\/[0-9\.]+[ \/]([^\s\/]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'DoCoMo';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^dopod[-_]?([^\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Dopod';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^FLY_]?([^\s\/]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Fly';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^GIONEE[-_ ]([^\s\/]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Gionee';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^GIONEE([A-Z0-9]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Gionee';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^HIKe_([^\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'HIKe';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^Hisense[ -](?:HS-)?([^\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Hisense';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^HS-([^\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Hisense';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^HTC[_-]?([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'HTC';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^HUAWEI[\s_-]?([^\/]*)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Huawei';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^Karbonn ([^\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Karbonn';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^KDDI-([^\s;]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'KDDI';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^KYOCERA\/([^\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Kyocera';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^KONKA[-_]?([^\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Konka';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^TIANYU-KTOUCH\/([^\/]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'K-Touch';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^K-Touch_?([^\/]*)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'K-Touch';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^Lenovo-([^\/]*)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Lenovo';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^Lephone_([^\/]*)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Lephone';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/(?:^|\()LGE?(?:\/|-|_|\s)([^\s]*)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'LG';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^Micromax([^\)]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Micromax';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^MOT-([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Motorola';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^Motorola_([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Motorola';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^Nokia-?([^\/]+)(?:\/|$)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Nokia';

                            if ($match[1] != 'Browser') {
                                $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                                $this->data->device->type = Constants\DeviceType::MOBILE;
                                $this->data->device->identified = false;
                                $this->data->device->generic = false;
                                $identified = true;

                                if (!$this->data->device->identified) {
                                    $device = Data\DeviceModels::identify('s60', $this->data->device->model);
                                    if ($device->identified) {
                                        $device->identified |= $this->data->device->identified;
                                        $this->data->device = $device;

                                        if (!isset($this->data->os->name) || $this->data->os->name != 'Series60') {
                                            $this->data->os->name = 'Series60';
                                            $this->data->os->version = null;
                                        }
                                    }
                                }

                                if (!$this->data->device->identified) {
                                    $device = Data\DeviceModels::identify('s40', $this->data->device->model);
                                    if ($device->identified) {
                                        $device->identified |= $this->data->device->identified;
                                        $this->data->device = $device;

                                        if (!isset($this->data->os->name) || $this->data->os->name != 'Series40') {
                                            $this->data->os->name = 'Series40';
                                            $this->data->os->version = null;
                                        }
                                    }
                                }

                                if (!$this->data->device->identified) {
                                    $device = Data\DeviceModels::identify('asha', $this->data->device->model);
                                    if ($device->identified) {
                                        $device->identified |= $this->data->device->identified;
                                        $this->data->device = $device;

                                        if (!isset($this->data->os->name) || $this->data->os->name != 'Nokia Asha Platform') {
                                            $this->data->os->name = 'Nokia Asha Platform';
                                            $this->data->os->version = new Version([ 'value' => '1.0' ]);

                                            if (preg_match('/java_runtime_version=Nokia_Asha_([0-9_]+);/u', $ua, $match)) {
                                                $this->data->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        if (preg_match('/^Nexian([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Nexian';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^NGM_([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'NGM';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^OPPO_([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Oppo';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^Pantech-?([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Pantech';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^Philips([^\/_\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Philips';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^sam-([A-Z][0-9]+)$/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Samsung';
                            $this->data->device->model = Data\DeviceModels::cleanup('sam-' . $match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->identified = false;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^SANYO\/([^\/]+)$/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Sanyo';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->identified = false;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^(SH[0-9]+[A-Z])$/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Sharp';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->identified = false;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^SE([A-Z][0-9]+[a-z])$/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Sony Ericsson';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->identified = false;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^SonyEricsson([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Sony Ericsson';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->identified = false;
                            $this->data->device->generic = false;
                            $identified = true;

                            if (preg_match('/^[a-z][0-9]+/u', $this->data->device->model)) {
                                $this->data->device->model[0] = strtoupper($this->data->device->model[0]);
                            }

                            if (isset($this->data->os->name) && $this->data->os->name == 'Series60') {
                                $device = Data\DeviceModels::identify('s60', $this->data->device->model);
                                if ($device->identified) {
                                    $device->identified |= $this->data->device->identified;
                                    $this->data->device = $device;
                                }
                            }
                        }

                        if (preg_match('/^Spice\s?([A-Z][0-9]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Spice';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^Tecno([^\/]*)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Tecno';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^T-smart_([^\/]*)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'T-smart';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^TCL[-_ ]([^\/]*)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'TCL';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^Tiphone ([^\/]*)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'TiPhone';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^Toshiba[\/-]([^\/-]*)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Toshiba';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^SHARP[-_\/]([^\/]*)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Sharp';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^SAMSUNG[-\/ ]?([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Samsung';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->identified = false;
                            $this->data->device->generic = false;
                            $identified = true;

                            if (isset($this->data->os->name) && $this->data->os->name == 'Bada') {
                                $device = Data\DeviceModels::identify('bada', $this->data->device->model);
                                if ($device->identified) {
                                    $device->identified |= $this->data->device->identified;
                                    $this->data->device = $device;
                                }
                            } elseif (isset($this->data->os->name) && $this->data->os->name == 'Series60') {
                                $device = Data\DeviceModels::identify('s60', $this->data->device->model);
                                if ($device->identified) {
                                    $device->identified |= $this->data->device->identified;
                                    $this->data->device = $device;
                                }
                            } elseif (preg_match('/Jasmine\/([0-9.]*)/u', $ua, $match)) {
                                $version = $match[1];

                                $device = Data\DeviceModels::identify('touchwiz', $this->data->device->model);
                                if ($device->identified) {
                                    $device->identified |= $this->data->device->identified;
                                    $this->data->device = $device;
                                    $this->data->os->name = 'Touchwiz';

                                    switch ($version) {
                                        case '0.8':
                                            $this->data->os->version = new Version([ 'value' => '1.0' ]);
                                            break;
                                        case '1.0':
                                            $this->data->os->version = new Version([ 'value' => '2.0', 'alias' => '2.0 or earlier' ]);
                                            break;
                                        case '2.0':
                                            $this->data->os->version = new Version([ 'value' => '3.0' ]);
                                            break;
                                    }
                                }
                            } elseif (preg_match('/(?:Dolfin\/([0-9.]*)|Browser\/Dolfin([0-9.]*))/u', $ua, $match)) {
                                $version = $match[1] || $match[2];

                                $device = Data\DeviceModels::identify('bada', $this->data->device->model);
                                if ($device->identified) {
                                    $device->identified |= $this->data->device->identified;
                                    $this->data->device = $device;
                                    $this->data->os->name = 'Bada';

                                    switch ($version) {
                                        case '2.0':
                                            $this->data->os->version = new Version([ 'value' => '1.0' ]);
                                            break;
                                        case '2.2':
                                            $this->data->os->version = new Version([ 'value' => '1.2' ]);
                                            break;
                                        case '3.0':
                                            $this->data->os->version = new Version([ 'value' => '2.0' ]);
                                            break;
                                    }
                                } else {
                                    $device = Data\DeviceModels::identify('touchwiz', $this->data->device->model);
                                    if ($device->identified) {
                                        $device->identified |= $this->data->device->identified;
                                        $this->data->device = $device;
                                        $this->data->os->name = 'Touchwiz';

                                        switch ($version) {
                                            case '1.5':
                                                $this->data->os->version = new Version([ 'value' => '2.0' ]);
                                                break;
                                            case '2.0':
                                                $this->data->os->version = new Version([ 'value' => '3.0' ]);
                                                break;
                                        }
                                    }
                                }
                            }
                        }

                        if (preg_match('/^Spice\s([^\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Spice';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^UTStar-([^\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'UTStar';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^vk-(vk[0-9]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'VK Mobile';
                            $this->data->device->model = Data\DeviceModels::cleanup(strtoupper($match[1]));
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^Xiaomi[_]?([^\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'Xiaomi';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }

                        if (preg_match('/^ZTE[-_]?([^\s]+)/ui', $candidates[$i], $match)) {
                            $this->data->device->manufacturer = 'ZTE';
                            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
                            $this->data->device->type = Constants\DeviceType::MOBILE;
                            $this->data->device->generic = false;
                            $identified = true;
                        }
                    }
                }

                if ($identified && !$this->data->device->identified) {
                    if (!$this->data->device->identified) {
                        $device = Data\DeviceModels::identify('bada', $this->data->device->model);
                        if ($device->identified) {
                            $device->identified |= $this->data->device->identified;
                            $this->data->device = $device;
                            $this->data->os->name = 'Bada';
                        }
                    }

                    if (!$this->data->device->identified) {
                        $device = Data\DeviceModels::identify('touchwiz', $this->data->device->model);
                        if ($device->identified) {
                            $device->identified |= $this->data->device->identified;
                            $this->data->device = $device;
                            $this->data->os->name = 'Touchwiz';
                        }
                    }

                    if (!$this->data->device->identified) {
                        $device = Data\DeviceModels::identify('wp', $this->data->device->model);
                        if ($device->identified) {
                            $device->identified |= $this->data->device->identified;
                            $this->data->device = $device;
                            $this->data->os->name = 'Windows Phone';
                        }
                    }

                    if (!$this->data->device->identified) {
                        $device = Data\DeviceModels::identify('wm', $this->data->device->model);
                        if ($device->identified) {
                            $device->identified |= $this->data->device->identified;
                            $this->data->device = $device;
                            $this->data->os->name = 'Windows Mobile';
                        }
                    }

                    if (!$this->data->device->identified) {
                        $device = Data\DeviceModels::identify('android', $this->data->device->model);
                        if ($device->identified) {
                            $device->identified |= $this->data->device->identified;
                            $this->data->device = $device;

                            if (!isset($this->data->os->name) || ($this->data->os->name != 'Android' && (!isset($this->data->os->family) || $this->data->os->family != 'Android'))) {
                                $this->data->os->name = 'Android';
                            }
                        }
                    }

                    if (!$this->data->device->identified) {
                        $device = Data\DeviceModels::identify('brew', $this->data->device->model);
                        if ($device->identified) {
                            $device->identified |= $this->data->device->identified;
                            $this->data->device = $device;
                            $this->data->os->name = 'Brew';
                        }
                    }

                    if (!$this->data->device->identified) {
                        $device = Data\DeviceModels::identify('feature', $this->data->device->model);
                        if ($device->identified) {
                            $device->identified |= $this->data->device->identified;
                            $this->data->device = $device;
                        }
                    }
                }

                if ($identified && !$this->data->device->identified) {
                    if (!$this->data->device->identified) {
                        $device = Data\DeviceModels::identify('bada', $this->data->device->manufacturer . ' ' . $this->data->device->model);
                        if ($device->identified) {
                            $device->identified |= $this->data->device->identified;
                            $this->data->device = $device;
                            $this->data->os->name = 'Bada';
                        }
                    }

                    if (!$this->data->device->identified) {
                        $device = Data\DeviceModels::identify('touchwiz', $this->data->device->manufacturer . ' ' . $this->data->device->model);
                        if ($device->identified) {
                            $device->identified |= $this->data->device->identified;
                            $this->data->device = $device;
                            $this->data->os->name = 'Touchwiz';
                        }
                    }

                    if (!$this->data->device->identified) {
                        $device = Data\DeviceModels::identify('wp', $this->data->device->manufacturer . ' ' . $this->data->device->model);
                        if ($device->identified) {
                            $device->identified |= $this->data->device->identified;
                            $this->data->device = $device;
                            $this->data->os->name = 'Windows Phone';
                        }
                    }

                    if (!$this->data->device->identified) {
                        $device = Data\DeviceModels::identify('wm', $this->data->device->manufacturer . ' ' . $this->data->device->model);
                        if ($device->identified) {
                            $device->identified |= $this->data->device->identified;
                            $this->data->device = $device;
                            $this->data->os->name = 'Windows Mobile';
                        }
                    }

                    if (!$this->data->device->identified) {
                        $device = Data\DeviceModels::identify('android', $this->data->device->manufacturer . ' ' . $this->data->device->model);
                        if ($device->identified) {
                            $device->identified |= $this->data->device->identified;
                            $this->data->device = $device;

                            if (!isset($this->data->os->name)) {
                                $this->data->os->name = 'Android';
                            }
                        }
                    }

                    if (!$this->data->device->identified) {
                        $device = Data\DeviceModels::identify('feature', $this->data->device->manufacturer . ' ' . $this->data->device->model);
                        if ($device->identified) {
                            $device->identified |= $this->data->device->identified;
                            $this->data->device = $device;
                        }
                    }
                }

                if ($identified) {
                    $this->data->device->identified |= Constants\Id::PATTERN;
                }
            }
        }


        if (preg_match('/\(([A-Z]+[0-9]+[A-Z])[^;]*; ?FOMA/ui', $ua, $match)) {
            $this->data->device->manufacturer = 'DoCoMo';
            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
            $this->data->device->type = Constants\DeviceType::MOBILE;
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->generic = false;
        }

        if (preg_match('/DoCoMo\/[0-9.]+\/([A-Z][0-9]+[A-Z])[^\/]*\//ui', $ua, $match)) {
            $this->data->device->manufacturer = 'DoCoMo';
            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
            $this->data->device->type = Constants\DeviceType::MOBILE;
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->generic = false;
        }

        if (preg_match('/Vodafone\/[0-9.]+\/V([0-9]+[A-Z]+)[^\/]*\//ui', $ua, $match)) {
            $this->data->device->manufacturer = 'Vodafone';
            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
            $this->data->device->type = Constants\DeviceType::MOBILE;
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->generic = false;
        }

        if (preg_match('/J-PHONE\/[^\/]+\/([^\/]+)(?:\/|$)/u', $ua, $match)) {
            $this->data->device->manufacturer = 'Softbank';
            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
            $this->data->device->type = Constants\DeviceType::MOBILE;
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->generic = false;
        }

        if (preg_match('/SoftBank\/[^\/]+\/([^\/]+)\//u', $ua, $match)) {
            $this->data->device->manufacturer = 'Softbank';
            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
            $this->data->device->type = Constants\DeviceType::MOBILE;
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->generic = false;
        }

        if (preg_match('/^T-Mobile ([^\/]+)\//u', $ua, $match)) {
            $this->data->device->manufacturer = 'T-Mobile';
            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
            $this->data->device->type = Constants\DeviceType::MOBILE;
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->generic = false;
        }

        if (preg_match('/HP(iPAQ[0-9]+)\//u', $ua, $match)) {
            $this->data->device->manufacturer = 'HP';
            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
            $this->data->device->type = Constants\DeviceType::MOBILE;
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->generic = false;

            $device = Data\DeviceModels::identify('wm', $this->data->device->model);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
            }
        }

        if (preg_match('/\((?:LG[-|\/])(.*) (?:Browser\/)?AppleWebkit/u', $ua, $match)) {
            $this->data->device->manufacturer = 'LG';
            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
            $this->data->device->type = Constants\DeviceType::MOBILE;
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->generic = false;
        }

        if (preg_match('/^Mozilla\/5.0 \((?:Nokia|NOKIA)(?:\s?)([^\)]+)\)UC AppleWebkit\(like Gecko\) Safari\/530$/u', $ua, $match)) {
            $this->data->device->manufacturer = 'Nokia';
            $this->data->device->model = Data\DeviceModels::cleanup($match[1]);
            $this->data->device->type = Constants\DeviceType::MOBILE;
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->generic = false;

            if (! ($this->data->device->identified & Constants\Id::MATCH_UA)) {
                $device = Data\DeviceModels::identify('s60', $this->data->device->model);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;

                    if (!isset($this->data->os->name) || $this->data->os->name != 'Series60') {
                        $this->data->os->name = 'Series60';
                        $this->data->os->version = null;
                    }
                }
            }

            if (! ($this->data->device->identified & Constants\Id::MATCH_UA)) {
                $device = Data\DeviceModels::identify('s40', $this->data->device->model);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;

                    if (!isset($this->data->os->name) || $this->data->os->name != 'Series40') {
                        $this->data->os->name = 'Series40';
                        $this->data->os->version = null;
                    }
                }
            }
        }
    }
}
