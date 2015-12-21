<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;
use WhichBrowser\Data;

trait Television
{
    private function detectTelevision($ua)
    {
        /* Detect the type based on some common markers */
        $this->detectGenericTelevision($ua);

        /* Try to parse some generic methods to store device information */
        $this->detectGenericTelevisionModels($ua);
        $this->detectGenericInettvBrowser($ua);
        $this->detectGenericHbbTV($ua);

        /* Look for specific manufacturers and models */
        $this->detectPanasonicTelevision($ua);
        $this->detectSharpTelevision($ua);
        $this->detectSamsungTelevision($ua);
        $this->detectSonyTelevision($ua);
        $this->detectPhilipsTelevision($ua);
        $this->detectLgTelevision($ua);
        $this->detectToshibaTelevision($ua);

        /* Try to detect set top boxes from various manufacturers */
        $this->detectSettopboxes($ua);

        /* Improve model names */
        $this->improveModelsOnDeviceTypeTelevision();
    }





    /* Generic markers */

    private function detectGenericTelevision($ua)
    {
        if (preg_match('/SmartTvA\//u', $ua)) {
            $this->data->device->type = Constants\DeviceType::TELEVISION;
        }

        if (preg_match('/NETRANGEMMH/u', $ua)) {
            $this->data->device->type = Constants\DeviceType::TELEVISION;
        }
    }


    /* Toshiba */

    private function detectToshibaTelevision($ua)
    {
        if (preg_match('/Toshiba_?TP\//u', $ua) || preg_match('/TSBNetTV\//u', $ua)) {
            $this->data->device->manufacturer = 'Toshiba';
            $this->data->device->series = 'Smart TV';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }

        if (preg_match('/TOSHIBA;[^;]+;([A-Z]+[0-9]+[A-Z]+);/u', $ua, $match)) {
            $this->data->device->manufacturer = 'Toshiba';
            $this->data->device->model = $match[1];
            $this->data->device->series = 'Smart TV';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }
    }


    /* LG */

    private function detectLgTelevision($ua)
    {
        if (preg_match('/LGSmartTV/u', $ua)) {
            $this->data->device->manufacturer = 'LG';
            $this->data->device->series = 'Smart TV';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }

        if (preg_match('/UPLUSTVBROWSER/u', $ua)) {
            $this->data->device->manufacturer = 'LG';
            $this->data->device->series = 'U+ tv';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }


        /* NetCast */

        if (preg_match('/LG NetCast\.(TV|Media)-([0-9]*)/u', $ua, $match)) {
            $this->data->device->manufacturer = 'LG';
            $this->data->device->series = 'NetCast ' . $match[1] . ' ' . $match[2];
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;

            if (preg_match('/LG Browser\/[0-9.]+\([^;]+; LGE; ([^;]+);/u', $ua, $match)) {
                if (substr($match[1], 0, 6) != 'GLOBAL') {
                    $this->data->device->model = $match[1];
                }
            }
        }

        /* NetCast */

        if ($ua == "Mozilla/5.0 (X11; Linux; ko-KR) AppleWebKit/534.26+ (KHTML, like Gecko) Version/5.0 Safari/534.26+" ||
            $ua == "Mozilla/5.0 (DirectFB; Linux; ko-KR) AppleWebKit/534.26+ (KHTML, like Gecko) Version/5.0 Safari/534.26+") {
            $this->data->device->manufacturer = 'LG';
            $this->data->device->series = 'NetCast TV 2012';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }


        /* NetCast or WebOS */

        if (preg_match('/NetCast/u', $ua) && preg_match('/SmartTV\/([0-9])/u', $ua, $match)) {
            $this->data->device->manufacturer = 'LG';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;

            if (intval($match[1]) < 5) {
                $this->data->device->series = 'NetCast TV';
            } else {
                $this->data->device->series = 'webOS TV';
            }
        }

        /* WebOS */

        if (preg_match('/Web[O0]S/u', $ua) && preg_match('/Large Screen/u', $ua)) {
            $this->data->device->manufacturer = 'LG';
            $this->data->device->series = 'webOS TV';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }

        if (preg_match('/webOS\.TV-([0-9]+)/u', $ua, $match)) {
            $this->data->device->manufacturer = 'LG';
            $this->data->device->series = 'webOS TV';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;

            if (preg_match('/LG Browser\/[0-9.]+\(LGE; ([^;]+);/u', $ua, $match)) {
                if (strtoupper(substr($match[1], 0, 5)) != 'WEBOS') {
                    $this->data->device->model = $match[1];
                }
            }
        }
    }


    /* Philips */

    private function detectPhilipsTelevision($ua)
    {
        if (preg_match('/NETTV\//u', $ua)) {
            $this->data->device->manufacturer = 'Philips';
            $this->data->device->series = 'Net TV';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;

            if (preg_match('/AquosTV/u', $ua)) {
                $this->data->device->manufacturer = 'Sharp';
                $this->data->device->series = 'Aquos TV';
            }

            if (preg_match('/BANGOLUFSEN/u', $ua)) {
                $this->data->device->manufacturer = 'Bang & Olufsen';
                $this->data->device->series = 'Smart TV';
            }

            if (preg_match('/PHILIPS-AVM/u', $ua)) {
                $this->data->device->series = 'Blu-ray Player';
            }
        }
    }


    /* Sony */

    private function detectSonyTelevision($ua)
    {
        if (preg_match('/SonyCEBrowser/u', $ua)) {
            $this->data->device->manufacturer = 'Sony';
            $this->data->device->series = 'Smart TV';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;

            if (preg_match('/SonyCEBrowser\/[0-9.]+ \((?:BDPlayer; |DTV[0-9]+\/)?([^;_]+)/u', $ua, $match)) {
                if ($match[1] != 'ModelName') {
                    $this->data->device->model = $match[1];
                }
            }
        }

        if (preg_match('/SonyDTV/u', $ua)) {
            $this->data->device->manufacturer = 'Sony';
            $this->data->device->series = 'Smart TV';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;

            if (preg_match('/(KDL-?[0-9]+[A-Z]+[0-9]+)/u', $ua, $match)) {
                $this->data->device->model = $match[1];
                $this->data->device->generic = false;
            }

            if (preg_match('/(XBR-?[0-9]+[A-Z]+[0-9]+)/u', $ua, $match)) {
                $this->data->device->model = $match[1];
                $this->data->device->generic = false;
            }
        }

        if (preg_match('/SonyBDP/u', $ua)) {
            $this->data->device->manufacturer = 'Sony';
            $this->data->device->series = "Blu-ray Player";
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }

        if (preg_match('/SmartBD/u', $ua) && preg_match('/(BDP-[A-Z][0-9]+)/u', $ua, $match)) {
            $this->data->device->manufacturer = 'Sony';
            $this->data->device->model = $match[1];
            $this->data->device->series = 'Blu-ray Player';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }

        if (preg_match('/\s+([0-9]+)BRAVIA/u', $ua, $match)) {
            $this->data->device->manufacturer = 'Sony';
            $this->data->device->model = 'Bravia';
            $this->data->device->series = 'Smart TV';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }
    }


    /* Samsung */

    private function detectSamsungTelevision($ua)
    {
        if (preg_match('/(SMART-TV|SmartHub)/u', $ua)) {
            $this->data->device->manufacturer = 'Samsung';
            $this->data->device->series = 'Smart TV';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;

            if (preg_match('/Linux\/SmartTV\+([0-9]*)/u', $ua, $match)) {
                $this->data->device->series = 'Smart TV ' . $match[1];
            } elseif (preg_match('/Maple([0-9]*)/u', $ua, $match)) {
                $this->data->device->series = 'Smart TV ' . $match[1];
            }
        }

        if (preg_match('/Maple_([0-9][0-9][0-9][0-9])/u', $ua, $match)) {
            $this->data->device->manufacturer = 'Samsung';
            $this->data->device->series = 'Smart TV ' . $match[1];
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }

        if (preg_match('/Maple ([0-9]+\.[0-9]+)\.[0-9]+/u', $ua, $match)) {
            $this->data->device->manufacturer = 'Samsung';
            $this->data->device->series = 'Smart TV';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;

            switch ($match[1]) {
                case '5.0':
                    $this->data->device->series = 'Smart TV 2009';
                    break;
                case '5.1':
                    $this->data->device->series = 'Smart TV 2010';
                    break;
                case '6.0':
                    $this->data->device->series = 'Smart TV 2011';
                    break;
            }
        }

        if (preg_match('/Model\/Samsung-(BD-[A-Z][0-9]+)/u', $ua, $match)) {
            $this->data->device->manufacturer = 'Samsung';
            $this->data->device->model = $match[1];
            $this->data->device->series = 'Blu-ray Player';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }

        if (preg_match('/olleh tv;/u', $ua)) {
            $this->data->device->manufacturer = 'Samsung';
            $this->data->device->model = null;
            $this->data->device->series = null;
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;

            if (preg_match('/(SMT-[A-Z0-9]+)/u', $ua, $match)) {
                $this->data->device->model = $match[1];
                $this->data->device->identifier = $match[1];
                $this->data->device->generic = false;
            }

            if ($this->data->device->model == "SMT-E5015") {
                $this->data->device->model = 'Olleh SkyLife Smart Settopbox';
            }
        }
    }


    /* Sharp */

    private function detectSharpTelevision($ua)
    {
        if (preg_match('/AQUOSBrowser/u', $ua) || preg_match('/AQUOS-(AS|DMP)/u', $ua)) {
            $this->data->device->manufacturer = 'Sharp';
            $this->data->device->series = 'Aquos TV';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;

            if (preg_match('/LC\-([0-9]+[A-Z]+[0-9]+[A-Z]+)/u', $ua, $match)) {
                $this->data->device->model = $match[1];
                $this->data->device->generic = false;
            }
        }
    }


    /* Panasonic */

    private function detectPanasonicTelevision($ua)
    {
        if (preg_match('/Viera/u', $ua)) {
            $this->data->device->manufacturer = 'Panasonic';
            $this->data->device->series = 'Viera';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;

            if (preg_match('/Panasonic\.tv\.([0-9]+)/u', $ua, $match)) {
                $this->data->device->series = 'Viera ' . $match[1];
            }

            if (preg_match('/\(Panasonic, ([0-9]+),/u', $ua, $match)) {
                $this->data->device->series = 'Viera ' . $match[1];
            }

            if (preg_match('/Viera\; rv\:34/u', $ua, $match)) {
                $this->data->device->series = 'Viera 2015';
            }
        }

        if (preg_match('/; Diga;/u', $ua)) {
            $this->data->device->manufacturer = 'Panasonic';
            $this->data->device->series = 'Diga';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }
    }


    /* Various set top boxes */

    private function detectSettopboxes($ua)
    {
        /* Loewe */

        if (preg_match('/LOEWE\/TV/u', $ua)) {
            $this->data->device->manufacturer = 'Loewe';
            $this->data->device->series = 'Smart TV';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;

            if (preg_match('/((?:SL|ID)[0-9]+)/u', $ua, $match)) {
                $this->data->device->model = $match[1];
            }
        }

        /* KreaTV */

        if (preg_match('/KreaTV/u', $ua)) {
            $this->data->os->reset();

            $this->data->device->series = 'KreaTV';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;

            if (preg_match('/Motorola/u', $ua)) {
                $this->data->device->manufacturer = 'Motorola';
            }
        }

        /* ADB */

        if (preg_match('/\(ADB; ([^\)]+)\)/u', $ua, $match)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'ADB';
            $this->data->device->model = ($match[1] != 'Unknown' ? str_replace('ADB', '', $match[1]) . ' ' : '') . 'IPTV receiver';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }

        /* MStar */

        if (preg_match('/Mstar;OWB/u', $ua)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'MStar';
            $this->data->device->model = 'PVR';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;

            $this->data->browser->name = 'Origyn Web Browser';
        }

        /* TechniSat */

        if (preg_match('/TechniSat ([^;]+);/u', $ua, $match)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'TechniSat';
            $this->data->device->model = $match[1];
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }

        /* Technicolor */

        if (preg_match('/Technicolor_([^;]+);/u', $ua, $match)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Technicolor';
            $this->data->device->model = $match[1];
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }

        /* Winbox Evo2 */

        if (preg_match('/Winbox Evo2/u', $ua)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Winbox';
            $this->data->device->model = 'Evo2';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }

        /* DuneHD */

        if (preg_match('/DuneHD\//u', $ua)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Dune HD';
            $this->data->device->model = '';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;

            if (preg_match('/DuneHD\/[0-9.]+ \(([^;]+);/u', $ua, $match)) {
                $this->data->device->model = $match[1];
            }
        }

        /* Roku  */

        if (preg_match('/^Roku\/DVP-([0-9]+)/u', $ua, $match)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Roku';
            $this->data->device->type = Constants\DeviceType::TELEVISION;

            switch ($match[1]) {
                case '2000':
                    $this->data->device->model = 'HD';
                    $this->data->device->generic = false;
                    break;
                case '2050':
                    $this->data->device->model = 'XD';
                    $this->data->device->generic = false;
                    break;
                case '2100':
                    $this->data->device->model = 'XDS';
                    $this->data->device->generic = false;
                    break;
                case '2400':
                    $this->data->device->model = 'LT';
                    $this->data->device->generic = false;
                    break;
                case '3000':
                    $this->data->device->model = '2 HD';
                    $this->data->device->generic = false;
                    break;
                case '3050':
                    $this->data->device->model = '2 XD';
                    $this->data->device->generic = false;
                    break;
                case '3100':
                    $this->data->device->model = '2 XS';
                    $this->data->device->generic = false;
                    break;
            }

            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }

        /* AppleTV */

        if (preg_match('/AppleTV/u', $ua)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Apple';
            $this->data->device->model = 'AppleTV';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }

        /* WebTV */

        if (preg_match('/WebTV\/[0-9.]/u', $ua)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Microsoft';
            $this->data->device->model = 'WebTV';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }

        /* OpenTV */

        if (preg_match('/OpenTV/u', $ua)) {
            $this->data->device->series = 'OpenTV';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
        }

        /* MediStream */

        if (preg_match('/MediStream/u', $ua)) {
            $this->data->os->reset();

            $this->data->device->manufacturer = 'Bewatec';
            $this->data->device->model = 'MediStream';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }
    }


    /* Generic model information */

    private function detectGenericTelevisionModels($ua)
    {
        if (preg_match('/\(([^,\(]+),\s*([^,\(]+),\s*(?:[Ww]ired|[Ww]ireless)\)/u', $ua, $match)) {
            $vendorName = Data\Manufacturers::identify(Constants\DeviceType::TELEVISION, $match[1]);
            $modelName = trim($match[2]);

            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->device->identified |= Constants\Id::PATTERN;
            
            if (!isset($this->data->device->series)) {
                $this->data->device->series = 'Smart TV';
            }

            switch ($vendorName) {
                case 'ARRIS':
                    $this->data->device->manufacturer = 'Arris';
                    $this->data->device->model = $modelName;
                    break;

                case 'LG':
                    $this->data->device->manufacturer = 'LG';

                    switch ($modelName) {
                        case 'webOS.TV':
                            $this->data->device->series = 'webOS TV';
                            break;
                        case 'WEBOS1':
                            $this->data->device->series = 'webOS TV';
                            break;
                        case 'GLOBAL-PLAT3':
                            $this->data->device->series = 'NetCast TV 2012';
                            break;
                        case 'GLOBAL-PLAT4':
                            $this->data->device->series = 'NetCast TV 2013';
                            break;
                        case 'GLOBAL-PLAT5':
                            $this->data->device->series = 'NetCast TV 2014';
                            break;
                        default:
                            $this->data->device->model = $modelName;
                            break;
                    }

                    break;

                case 'TiVo':
                    $this->data->device->manufacturer = 'TiVo';
                    $this->data->device->series = 'DVR';
                    break;

                default:
                    $this->data->device->manufacturer = $vendorName;
                    $this->data->device->model = $modelName;
                    break;
            }
        }
    }


    /* InettvBrowser model information */

    private function detectGenericInettvBrowser($ua)
    {
        if (preg_match('/(?:DTVNetBrowser|InettvBrowser|Hybridcast)\/[0-9\.]+[A-Z]? \(/u', $ua, $match)) {
            $this->data->device->type = Constants\DeviceType::TELEVISION;

            $vendorName = null;
            $modelName = null;
            $found = false;

            if (preg_match('/(?:DTVNetBrowser|InettvBrowser)\/[0-9\.]+[A-Z]? \(([^;]*)\s*;\s*([^;]*)\s*;/u', $ua, $match)) {
                $vendorName = trim($match[1]);
                $modelName = trim($match[2]);
                $found = true;
            }

            if (preg_match('/Hybridcast\/[0-9\.]+ \([^;]*;([^;]*)\s*;\s*([^;]*)\s*;/u', $ua, $match)) {
                $vendorName = trim($match[1]);
                $modelName = trim($match[2]);
                $found = true;
            }

            if ($found) {
                $this->data->device->identified |= Constants\Id::PATTERN;
                
                if (!isset($this->data->device->series)) {
                    $this->data->device->series = 'Smart TV';
                }

                switch ($vendorName . '#') {
                    case '000087#':
                        $this->data->device->manufacturer = 'Hitachi';
                        break;

                    case '00E091#':
                        $this->data->device->manufacturer = 'LG';

                        switch ($modelName) {
                            case 'LGE2D2012M':
                                $this->data->device->series = 'NetCast TV 2012';
                                break;
                            case 'LGE3D2012M':
                                $this->data->device->series = 'NetCast TV 2012';
                                break;
                        }

                        break;

                    case '38E08E#':
                        $this->data->device->manufacturer = 'Mitsubishi';
                        break;

                    case '008045#':
                        $this->data->device->manufacturer = 'Panasonic';
                        break;

                    case '00E064#':
                        $this->data->device->manufacturer = 'Samsung';
                        break;

                    case '08001F#':
                        $this->data->device->manufacturer = 'Sharp';
                        break;

                    case '00014A#':
                        $this->data->device->manufacturer = 'Sony';
                        break;

                    case '000039#':
                        $this->data->device->manufacturer = 'Toshiba';
                        break;
                }
            }
        }
    }


    /* HbbTV model information */

    private function detectGenericHbbTV($ua)
    {
        if (preg_match('/(?:HbbTV|SmartTV)\/[0-9\.]+ \(/iu', $ua, $match)) {
            $this->data->device->type = Constants\DeviceType::TELEVISION;

            $vendorName = null;
            $modelName = null;
            $found = false;

            if (preg_match('/HbbTV\/[0-9\.]+ \(([^;]*);\s*([^;]*)\s*;\s*([^;]*)\s*;/u', $ua, $match)) {
                if (trim($match[1]) == "" || trim($match[1]) == "PVR" || strpos($match[1], '+') !== false) {
                    $vendorName = Data\Manufacturers::identify(Constants\DeviceType::TELEVISION, $match[2]);
                    $modelName = trim($match[3]);
                } else {
                    $vendorName = Data\Manufacturers::identify(Constants\DeviceType::TELEVISION, $match[1]);
                    $modelName = trim($match[2]);
                }

                $found = true;
            }

            if (preg_match('/(?:^|\s)SmartTV\/[0-9\.]+ \(([^;]*)\s*;\s*([^;]*)\s*;/u', $ua, $match)) {
                $vendorName = Data\Manufacturers::identify(Constants\DeviceType::TELEVISION, $match[1]);
                $modelName = trim($match[2]);
                $found = true;
            }

            if ($found) {
                $this->data->device->identified |= Constants\Id::PATTERN;

                switch ($vendorName) {
                    case 'LG':
                        $this->data->device->manufacturer = 'LG';

                        switch ($modelName) {
                            case 'GLOBAL_PLAT3':
                                $this->data->device->series = 'NetCast TV 2012';
                                break;
                            case 'GLOBAL_PLAT4':
                                $this->data->device->series = 'NetCast TV 2013';
                                break;
                            case 'GLOBAL_PLAT5':
                                $this->data->device->series = 'NetCast TV 2014';
                                break;
                            case 'NetCast 2.0':
                                $this->data->device->series = 'NetCast TV 2011';
                                break;
                            case 'NetCast 3.0':
                                $this->data->device->series = 'NetCast TV 2012';
                                break;
                            case 'NetCast 4.0':
                                $this->data->device->series = 'NetCast TV 2013';
                                break;
                            case 'NetCast 4.5':
                                $this->data->device->series = 'NetCast TV 2014';
                                break;
                            default:
                                $this->data->device->model = $modelName;
                                break;
                        }

                        break;

                    case 'SAMSUNG':
                    case 'Samsung':
                        $this->data->device->manufacturer = 'Samsung';

                        switch ($modelName) {
                            case 'SmartTV2012':
                                $this->data->device->series = 'Smart TV 2012';
                                break;
                            case 'SmartTV2013':
                                $this->data->device->series = 'Smart TV 2013';
                                break;
                            case 'SmartTV2014':
                                $this->data->device->series = 'Smart TV 2014';
                                break;
                            case 'OTV-SMT-E5015':
                                $this->data->device->model = 'Olleh SkyLife Smart Settopbox';
                                unset($this->data->device->series);
                                break;
                            default:
                                $this->data->device->model = $modelName;
                                break;
                        }

                        break;

                    case 'Panasonic':
                        $this->data->device->manufacturer = 'Panasonic';

                        switch ($modelName) {
                            case 'VIERA 2011':
                                $this->data->device->series = 'Viera 2011';
                                break;
                            case 'VIERA 2012':
                                $this->data->device->series = 'Viera 2012';
                                break;
                            case 'VIERA 2013':
                                $this->data->device->series = 'Viera 2013';
                                break;
                            case 'VIERA 2014':
                                $this->data->device->series = 'Viera 2014';
                                break;
                            case 'VIERA 2015':
                                $this->data->device->series = 'Viera 2015';
                                break;
                            default:
                                $this->data->device->model = $modelName;
                                break;
                        }

                        break;

                    case 'TV2N':
                        $this->data->device->manufacturer = 'TV2N';

                        switch ($modelName) {
                            case 'videoweb':
                                $this->data->device->model = 'Videoweb';
                                break;
                            default:
                                $this->data->device->model = $modelName;
                                break;
                        }

                        break;

                    default:
                        if ($vendorName != '' && $vendorName != 'vendorName') {
                            $this->data->device->manufacturer = $vendorName;
                        }

                        if ($modelName != '' && $modelName != 'modelName') {
                            $this->data->device->model = $modelName;
                        }

                        break;
                }

                switch ($modelName) {
                    case 'hdr1000s':
                        $this->data->device->manufacturer = 'Humax';
                        $this->data->device->model = 'HDR-1000S';
                        $this->data->device->identified |= Constants\Id::MATCH_UA;
                        $this->data->device->generic = false;
                        break;

                    case 'hms1000s':
                    case 'hms1000sph2':
                        $this->data->device->manufacturer = 'Humax';
                        $this->data->device->model = 'HMS-1000S';
                        $this->data->device->identified |= Constants\Id::MATCH_UA;
                        $this->data->device->generic = false;
                        break;
                }
            }
        }

        if (preg_match('/HbbTV\/[0-9.]+;CE-HTML\/[0-9.]+;([^\s;]+)\s[^\s;]+;/u', $ua, $match)) {
            $this->data->device->manufacturer = Data\Manufacturers::identify(Constants\DeviceType::TELEVISION, $match[1]);
            if (!isset($this->data->device->series)) {
                $this->data->device->series = 'Smart TV';
            }
        }

        if (preg_match('/HbbTV\/[0-9.]+;CE-HTML\/[0-9.]+;Vendor\/([^\s;]+);/u', $ua, $match)) {
            $this->data->device->manufacturer = Data\Manufacturers::identify(Constants\DeviceType::TELEVISION, $match[1]);
            if (!isset($this->data->device->series)) {
                $this->data->device->series = 'Smart TV';
            }
        }
    }


    /* Try to reformat some of the detected generic models */

    private function improveModelsOnDeviceTypeTelevision()
    {
        if ($this->data->device->type != Constants\DeviceType::TELEVISION) {
            return;
        }


        if (isset($this->data->device->model) && isset($this->data->device->manufacturer)) {

            if ($this->data->device->manufacturer == 'Dune HD') {
                if (preg_match('/tv([0-9]+[a-z]?)/u', $this->data->device->model, $match)) {
                    $this->data->device->model = 'TV-' . strtoupper($match[1]);
                }

                if ($this->data->device->model == 'connect') {
                    $this->data->device->model = 'Connect';
                }
            }

            if ($this->data->device->manufacturer == 'Humax') {
                $this->data->device->series = "Digital Receiver";
            }

            if ($this->data->device->manufacturer == 'Inverto') {
                if (preg_match('/IDL[ -]?([0-9]+.*)/u', $this->data->device->model, $match)) {
                    $this->data->device->model = 'IDL ' . $match[1];
                }

                if (preg_match('/MBN([0-9]+)/u', $this->data->device->model, $match)) {
                    $this->data->device->model = 'MBN ' . $match[1];
                }
            }

            if ($this->data->device->manufacturer == 'HyperPanel') {
                $this->data->device->model = strtok(strtoupper($this->data->device->model), ' ');
            }

            if ($this->data->device->manufacturer == 'LG') {
                if (preg_match('/(?:ATSC|DVB)-(.*)/u', $this->data->device->model, $match)) {
                    $this->data->device->model = $match[1];
                    $this->data->device->generic = false;
                }

                if (preg_match('/[0-9][0-9]([A-Z][A-Z][0-9][0-9][0-9][0-9A-Z])/u', $this->data->device->model, $match)) {
                    $this->data->device->model = $match[1];
                    $this->data->device->generic = false;
                }

                if (preg_match('/Media\/(.*)/u', $this->data->device->model, $match)) {
                    $this->data->device->model = $match[1];
                    $this->data->device->generic = false;
                }
            }

            if ($this->data->device->manufacturer == 'Loewe') {
                $this->data->device->series = 'Smart TV';

                if (preg_match('/((?:ID|SL)[0-9]+)/u', $this->data->device->model, $match)) {
                    $this->data->device->model = 'Connect '.  $match[1];
                    $this->data->device->generic = false;
                }
            }

            if ($this->data->device->manufacturer == 'Philips') {
                if (preg_match('/[0-9][0-9]([A-Z][A-Z][A-Z][0-9][0-9][0-9][0-9])/u', $this->data->device->model, $match)) {
                    $this->data->device->model = $match[1];
                    $this->data->device->generic = false;
                }

                if (preg_match('/(MT[0-9]+)/u', $this->data->device->model, $match)) {
                    $this->data->device->model = $match[1];
                    $this->data->device->series = "Digital Receiver";
                    $this->data->device->generic = false;
                }

                if (preg_match('/(BDP[0-9]+)/u', $this->data->device->model, $match)) {
                    $this->data->device->model = $match[1];
                    $this->data->device->series = "Blu-ray Player";
                    $this->data->device->generic = false;
                }
            }

            if ($this->data->device->manufacturer == 'Toshiba') {
                if (preg_match('/DTV_(.*)/u', $this->data->device->model, $match)) {
                    $this->data->device->model = 'Regza ' . $match[1];
                    $this->data->device->generic = false;
                }

                if (preg_match('/[0-9][0-9]([A-Z][A-Z][0-9][0-9][0-9])/u', $this->data->device->model, $match)) {
                    $this->data->device->model = 'Regza ' . $match[1];
                    $this->data->device->generic = false;
                }

                if (preg_match('/[0-9][0-9](ZL[0-9])/u', $this->data->device->model, $match)) {
                    $this->data->device->model = $match[1] . ' Cevo';
                    $this->data->device->generic = false;
                }

                if (preg_match('/(BDX[0-9]+)/u', $this->data->device->model, $match)) {
                    $this->data->device->model = $match[1];
                    $this->data->device->series = "Blu-ray Player";
                    $this->data->device->generic = false;
                }
            }

            if ($this->data->device->manufacturer == 'Selevision') {
                $this->data->device->model = str_replace('Selevision ', '', $this->data->device->model);
            }

            if ($this->data->device->manufacturer == 'Sharp') {
                if (preg_match('/[0-9][0-9]([A-Z]+[0-9]+[A-Z]+)/u', $this->data->device->model, $match)) {
                    $this->data->device->model = $match[1];
                    $this->data->device->generic = false;
                }
            }

            if ($this->data->device->manufacturer == 'Sony') {
                if (preg_match('/(BDP[0-9]+G)/u', $this->data->device->model, $match)) {
                    $this->data->device->model = $match[1];
                    $this->data->device->series = "Blu-ray Player";
                    $this->data->device->generic = false;
                }

                if (preg_match('/KDL?-?[0-9]*([A-Z]+[0-9]+)[A-Z]*/u', $this->data->device->model, $match)) {
                    $this->data->device->model = 'Bravia ' . $match[1];
                    $this->data->device->series = 'Smart TV';
                    $this->data->device->generic = false;
                }
            }

            if ($this->data->device->manufacturer == 'Pioneer') {
                if (preg_match('/(BDP-[0-9]+)/u', $this->data->device->model, $match)) {
                    $this->data->device->model = $match[1];
                    $this->data->device->series = "Blu-ray Player";
                    $this->data->device->generic = false;
                }
            }
        }
    }
}
