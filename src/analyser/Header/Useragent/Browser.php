<?php

namespace WhichBrowser\Analyser\Header\Useragent;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Family;
use WhichBrowser\Model\Using;
use WhichBrowser\Model\Version;

trait Browser
{
    private function &detectBrowser($ua)
    {
        /* Detect major browsers */
        $this->detectSafari($ua);
        $this->detectExplorer($ua);
        $this->detectFirefox($ua);
        $this->detectChrome($ua);
        $this->detectEdge($ua);
        $this->detectOpera($ua);
        
        /* Detect other browsers */
        $this->detectUC($ua);
        $this->detectNetfront($ua);
        $this->detectObigo($ua);

        /* Detect other specific desktop browsers */
        $this->detectSeamonkey($ua);
        $this->detectModernNetscape($ua);
        $this->detectKonqueror($ua);

        /* Detect other various mobile browsers */
        $this->detectNokiaBrowser($ua);
        $this->detectSilk($ua);
        $this->detectSailfishBrowser($ua);
        $this->detectWebOSBrowser($ua);
        $this->detectDolfin($ua);
        $this->detectIris($ua);

        /* Detect other various television browsers */
        $this->detectEspial($ua);
        $this->detectMachBlue($ua);
        $this->detectAnt($ua);

        /* Detect other browses */
        $this->detectSpecficBrowsers($ua);
        $this->detectRemainingBrowsers($ua);


        return $this;
    }

    private function &refineBrowser($ua)
    {
        $this->detectUCEngine($ua);
        $this->detectLegacyNetscape($ua);
 
        return $this;
    }




    /* Safari */

    private function detectSafari($ua)
    {
        if (preg_match('/Safari/u', $ua)) {

            if (isset($this->data->os->name) && $this->data->os->name == 'iOS') {
                $this->data->browser->stock = true;
                $this->data->browser->hidden = true;
                $this->data->browser->name = 'Safari';
                $this->data->browser->version = null;

                if (preg_match('/Version\/([0-9\.]+)/u', $ua, $match)) {
                    $this->data->browser->version = new Version([ 'value' => $match[1], 'hidden' => true ]);
                }
            }

            if (isset($this->data->os->name) && ($this->data->os->name == 'OS X' || $this->data->os->name == 'Windows')) {
                $this->data->browser->name = 'Safari';
                $this->data->browser->stock = $this->data->os->name == 'OS X';

                if (preg_match('/Version\/([0-9\.]+)/u', $ua, $match)) {
                    $this->data->browser->version = new Version([ 'value' => $match[1] ]);
                }

                if (preg_match('/AppleWebKit\/[0-9\.]+\+/u', $ua)) {
                    $this->data->browser->name = 'WebKit Nightly Build';
                    $this->data->browser->version = null;
                }
            }


            if (isset($this->data->os->name) && $this->data->os->name == 'Darwin') {
                if (preg_match("/^MobileSafari/iu", $ua)) {
                    $this->data->browser->name = 'Safari';
                    $this->data->browser->version = null;
                    $this->data->browser->stock = true;
                    $this->data->browser->hidden = true;

                    $this->data->device->type = Constants\DeviceType::MOBILE;
                } elseif (preg_match("/^Safari/iu", $ua)) {
                    $this->data->browser->name = 'Safari';
                    $this->data->browser->version = null;
                    $this->data->browser->stock = true;

                    $this->data->device->type = Constants\DeviceType::DESKTOP;
                }
            }
        }

        if (preg_match('/(?:Apple-PubSub|AppleSyndication)\//u', $ua)) {
            $this->data->browser->stock = true;
            $this->data->browser->name = 'Safari RSS';
            $this->data->browser->version = null;

            $this->data->os->name = 'OS X';
            $this->data->os->version = null;

            $this->data->device->type = Constants\DeviceType::DESKTOP;
        }
    }


    /* Chrome */

    private function detectChrome($ua)
    {
        if (preg_match('/(?:Chrome|CrMo|CriOS)\/[0-9]/u', $ua) || preg_match('/Browser\/Chrome[0-9]/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Chrome';

            $version = '';
            if (preg_match('/(?:Chrome|CrMo|CriOS)\/([0-9.]*)/u', $ua, $match)) {
                $version = $match[1];
            }
            if (preg_match('/Browser\/Chrome([0-9.]*)/u', $ua, $match)) {
                $version = $match[1];
            }
            $this->data->browser->version = new Version([ 'value' => $version ]);

            if (isset($this->data->os->name) && $this->data->os->name == 'Android') {
                $channel = Data\Chrome::getChannel('mobile', $this->data->browser->version->value);

                if ($channel == 'stable') {
                    if (explode('.', $version)[1] == '0') {
                        $this->data->browser->version->details = 1;
                    } else {
                        $this->data->browser->version->details = 2;
                    }
                } elseif ($channel == 'beta') {
                    $this->data->browser->channel = 'Beta';
                } else {
                    $this->data->browser->channel = 'Dev';
                }


                /* Webview for Android 4.4 and higher */
                if (implode('.', array_slice(explode('.', $version), 1, 2)) == '0.0' && preg_match('/Version\//u', $ua)) {
                    $this->data->browser->using = new Using([ 'name' => 'Chromium WebView', 'version' => new Version([ 'value' => explode('.', $version)[0] ]) ]);
                    $this->data->browser->stock = true;
                    $this->data->browser->name = null;
                    $this->data->browser->version = null;
                    $this->data->browser->channel = null;
                }

                /* Webview for Android 5 */
                if (preg_match('/; wv\)/u', $ua)) {
                    $this->data->browser->using = new Using([ 'name' => 'Chromium WebView', 'version' => new Version([ 'value' => explode('.', $version)[0] ]) ]);
                    $this->data->browser->stock = true;
                    $this->data->browser->name = null;
                    $this->data->browser->version = null;
                    $this->data->browser->channel = null;
                }

                /* LG Chromium based browsers */
                if (isset($this->data->device->manufacturer) && $this->data->device->manufacturer == 'LG') {
                    if (in_array($version, [ '30.0.1599.103', '34.0.1847.118', '38.0.2125.0', '38.0.2125.102' ]) && preg_match('/Version\/4/u', $ua) && !preg_match('/; wv\)/u', $ua)) {
                        $this->data->browser->name = "LG Browser";
                        $this->data->browser->channel = null;
                        $this->data->browser->stock = true;
                        $this->data->browser->version = null;
                    }
                }

                /* Samsung Chromium based browsers */
                if (isset($this->data->device->manufacturer) && $this->data->device->manufacturer == 'Samsung') {

                    /* Version 1.0 */
                    if ($version == '18.0.1025.308' && preg_match('/Version\/1.0/u', $ua)) {
                        $this->data->browser->name = "Samsung Browser";
                        $this->data->browser->channel = null;
                        $this->data->browser->stock = true;
                        $this->data->browser->version = new Version([ 'value' => '1.0' ]);
                    }

                    /* Version 1.5 */
                    if ($version == '28.0.1500.94' && preg_match('/Version\/1.5/u', $ua)) {
                        $this->data->browser->name = "Samsung Browser";
                        $this->data->browser->channel = null;
                        $this->data->browser->stock = true;
                        $this->data->browser->version = new Version([ 'value' => '1.5' ]);
                    }

                    /* Version 1.6 */
                    if ($version == '28.0.1500.94' && preg_match('/Version\/1.6/u', $ua)) {
                        $this->data->browser->name = "Samsung Browser";
                        $this->data->browser->channel = null;
                        $this->data->browser->stock = true;
                        $this->data->browser->version = new Version([ 'value' => '1.6' ]);
                    }

                    /* Version 2.0 */
                    if ($version == '34.0.1847.76' && preg_match('/Version\/2.0/u', $ua)) {
                        $this->data->browser->name = "Samsung Browser";
                        $this->data->browser->channel = null;
                        $this->data->browser->stock = true;
                        $this->data->browser->version = new Version([ 'value' => '2.0' ]);
                    }

                    /* Version 2.1 */
                    if ($version == '34.0.1847.76' && preg_match('/Version\/2.1/u', $ua)) {
                        $this->data->browser->name = "Samsung Browser";
                        $this->data->browser->channel = null;
                        $this->data->browser->stock = true;
                        $this->data->browser->version = new Version([ 'value' => '2.1' ]);
                    }
                }

                /* Samsung Chromium based browsers */
                if (preg_match('/SamsungBrowser\/([0-9.]*)/u', $ua, $match)) {
                    $this->data->browser->name = "Samsung Browser";
                    $this->data->browser->channel = null;
                    $this->data->browser->stock = true;
                    $this->data->browser->version = new Version([ 'value' => $match[1] ]);
                }
            } else {
                $channel = Data\Chrome::getChannel('desktop', $version);

                if ($channel == 'stable') {
                    if (explode('.', $version)[1] == '0') {
                        $this->data->browser->version->details = 1;
                    } else {
                        $this->data->browser->version->details = 2;
                    }
                } elseif ($channel == 'beta') {
                    $this->data->browser->channel = 'Beta';
                } else {
                    $this->data->browser->channel = 'Dev';
                }
            }

            if ($this->data->device->type == '') {
                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }
        }

        /* Google Chromium */

        if (preg_match('/Chromium/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->channel = '';
            $this->data->browser->name = 'Chromium';

            if (preg_match('/Chromium\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            if ($this->data->device->type == '') {
                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }
        }

        /* Chrome Content Shell */

        if (preg_match('/Chrome\/[0-9]+\.77\.34\.5/u', $ua)) {
            $this->data->browser->using = new Using([ 'name' => 'Chrome Content Shell' ]);

            $this->data->browser->stock = false;
            $this->data->browser->name = null;
            $this->data->browser->version = null;
            $this->data->browser->channel = null;
        }

        /* Chromium WebView by Amazon */

        if (preg_match('/AmazonWebAppPlatform\//u', $ua)) {
            $this->data->browser->using = new Using([ 'name' => 'Amazon WebView' ]);

            $this->data->browser->stock = false;
            $this->data->browser->name = null;
            $this->data->browser->version = null;
            $this->data->browser->channel = null;
        }

        /* Chromium WebView by Crosswalk */

        if (preg_match('/Crosswalk\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->using = new Using([ 'name' => 'Crosswalk WebView', 'version' => new Version([ 'value' => $match[1], 'details' => 1 ]) ]);

            $this->data->browser->stock = false;
            $this->data->browser->name = null;
            $this->data->browser->version = null;
            $this->data->browser->channel = null;
        }

        /* Set the browser family */

        if ($this->data->isBrowser('Chrome')) {
            $this->data->browser->family = new Family([ 'name' => $this->data->browser->name, 'version' => new Version([ 'value' => $this->data->browser->version->getMajor() ]) ]);
        }
    }


    /* Internet Explorer */

    private function detectExplorer($ua)
    {
        if (preg_match('/MSIE/u', $ua)) {
            $this->data->browser->name = 'Internet Explorer';

            if (preg_match('/IEMobile/u', $ua) || preg_match('/Windows CE/u', $ua) || preg_match('/Windows Phone/u', $ua) || preg_match('/WP7/u', $ua) || preg_match('/WPDesktop/u', $ua)) {
                $this->data->browser->name = 'Mobile Internet Explorer';

                if (isset($this->data->device->model) && ($this->data->device->model == 'Xbox 360' || $this->data->device->model == 'Xbox One')) {
                    $this->data->browser->name = 'Internet Explorer';
                }
            }

            if (preg_match('/MSIE ([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => preg_replace("/\.([0-9])([0-9])/", '.$1.$2', $match[1]) ]);
            }

            if (preg_match('/Mac_/u', $ua)) {
                $this->data->os->name = 'Mac OS';
                $this->data->engine->name = 'Tasman';
                $this->data->device->type = Constants\DeviceType::DESKTOP;

                if ($this->data->browser->version->toFloat() >= 5.11 && $this->data->browser->version->toFloat() <= 5.13) {
                    $this->data->os->name = 'OS X';
                }

                if ($this->data->browser->version->toFloat() >= 5.2) {
                    $this->data->os->name = 'OS X';
                }
            }
        }

        if (preg_match('/\(IE ([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Internet Explorer';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
        }

        if (preg_match('/Browser\/IE([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Internet Explorer';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
        }

        if (preg_match('/Trident\/[789][^\)]+; rv:([0-9.]*)\)/u', $ua, $match)) {
            $this->data->browser->name = 'Internet Explorer';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
        }

        if (preg_match('/Trident\/[789][^\)]+; Touch; rv:([0-9.]*);\s+IEMobile\//u', $ua, $match)) {
            $this->data->browser->name = 'Mobile Internet Explorer';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
        }

        if (preg_match('/Trident\/[789][^\)]+; Touch; rv:([0-9.]*); WPDesktop/u', $ua, $match)) {
            $this->data->browser->mode = 'desktop';
            $this->data->browser->name = 'Mobile Internet Explorer';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
        }


        /* Set the browser family */

        if ($this->data->isBrowser('Internet Explorer') || $this->data->isBrowser('Mobile Internet Explorer')) {
            unset($this->data->browser->family);
        }
    }


    /* Edge */

    private function detectEdge($ua)
    {
        if (preg_match('/Edge\/([0-9]+)/u', $ua, $match)) {
            $this->data->browser->name = 'Edge';
            $this->data->browser->alias = 'Edge ' . $match[1];
            $this->data->browser->channel = '';
            $this->data->browser->version = null;
        }


        /* Set the browser family */

        if ($this->data->isBrowser('Edge')) {
            unset($this->data->browser->family);
        }
    }


    /* Opera */

    private function detectOpera($ua)
    {
        if (preg_match('/OPR\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->stock = false;
            $this->data->browser->channel = '';
            $this->data->browser->name = 'Opera';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

            if (preg_match('/Edition Developer/u', $ua)) {
                $this->data->browser->channel = 'Developer';
            }

            if (preg_match('/Edition Next/u', $ua)) {
                $this->data->browser->channel = 'Next';
            }

            if (preg_match('/Edition beta/u', $ua)) {
                $this->data->browser->channel = 'Beta';
            }

            if ($this->data->device->type == Constants\DeviceType::MOBILE) {
                $this->data->browser->name = 'Opera Mobile';
            }
        }

        if (preg_match('/OMI\/([0-9]+\.[0-9]+)/u', $ua, $match)) {
            $this->data->browser->name = 'Opera Devices';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);

            $this->data->device->type = Constants\DeviceType::TELEVISION;

            unset($this->data->os->name);
            unset($this->data->os->version);
        }

        if (preg_match('/Opera[\/\-\s]/iu', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Opera';

            if (preg_match('/Opera[\/| ]([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
                if (floatval($match[1]) >= 10) {
                    $this->data->browser->version = new Version([ 'value' => $match[1] ]);
                } else {
                    $this->data->browser->version = null;
                }
            }

            if (isset($this->data->browser->version) && preg_match('/Edition Labs/u', $ua)) {
                $this->data->browser->channel = 'Labs';
            }

            if (isset($this->data->browser->version) && preg_match('/Edition Next/u', $ua)) {
                $this->data->browser->channel = 'Next';
            }

            if (preg_match('/Opera Tablet/u', $ua)) {
                $this->data->browser->name = 'Opera Mobile';
                $this->data->device->type = Constants\DeviceType::TABLET;
            }

            if (preg_match('/Opera Mobi/u', $ua)) {
                $this->data->browser->name = 'Opera Mobile';
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }

            if (preg_match('/Opera Mini;/u', $ua)) {
                $this->data->browser->name = 'Opera Mini';
                $this->data->browser->version = null;
                $this->data->browser->mode = 'proxy';
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }

            if (preg_match('/Opera Mini\/(?:att\/)?([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->name = 'Opera Mini';
                $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => (intval(substr(strrchr($match[1], '.'), 1)) > 99 ? -1 : null) ]);
                $this->data->browser->mode = 'proxy';
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }

            if ($this->data->browser->name == 'Opera' && $this->data->device->type == Constants\DeviceType::MOBILE) {
                $this->data->browser->name = 'Opera Mobile';

                if (preg_match('/BER/u', $ua)) {
                    $this->data->browser->name = 'Opera Mini';
                    $this->data->browser->version = null;
                }
            }

            if (preg_match('/InettvBrowser/u', $ua)) {
                $this->data->device->type = Constants\DeviceType::TELEVISION;
            }

            if (preg_match('/Opera[ -]TV/u', $ua)) {
                $this->data->browser->name = 'Opera';
                $this->data->device->type = Constants\DeviceType::TELEVISION;
            }

            if (preg_match('/Linux zbov/u', $ua)) {
                $this->data->browser->name = 'Opera Mobile';
                $this->data->browser->mode = 'desktop';

                $this->data->device->type = Constants\DeviceType::MOBILE;

                $this->data->os->name = null;
                $this->data->os->version = null;
            }

            if (preg_match('/Linux zvav/u', $ua)) {
                $this->data->browser->name = 'Opera Mini';
                $this->data->browser->version = null;
                $this->data->browser->mode = 'desktop';

                $this->data->device->type = Constants\DeviceType::MOBILE;

                $this->data->os->name = null;
                $this->data->os->version = null;
            }

            if ($this->data->device->type == '') {
                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }
        }

        if (preg_match('/OPiOS\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Opera Mini';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
        }

        if (preg_match('/Coast\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Coast by Opera';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
        }
    }


    /* Firefox */

    private function detectFirefox($ua)
    {
        if (preg_match('/Firefox/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Firefox';

            if (preg_match('/Firefox\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);

                if (preg_match('/a/u', $match[1])) {
                    $this->data->browser->channel = 'Aurora';
                }

                if (preg_match('/b/u', $match[1])) {
                    $this->data->browser->channel = 'Beta';
                }
            }

            if (preg_match('/Aurora\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->channel = 'Aurora';
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            if (preg_match('/Fennec/u', $ua)) {
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }

            if (preg_match('/Mobile;(?: ([^;]+);)? rv/u', $ua, $match)) {
                $this->data->device->type = Constants\DeviceType::MOBILE;

                if (isset($match[1])) {
                    $device = Data\DeviceModels::identify('firefoxos', $match[1]);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->os->name = 'Firefox OS';
                        $this->data->device = $device;
                    }
                }
            }

            if (preg_match('/Tablet;(?: ([^;]+);)? rv/u', $ua, $match)) {
                $this->data->device->type = Constants\DeviceType::TABLET;

                if (isset($match[1])) {
                    $device = Data\DeviceModels::identify('firefoxos', $match[1]);
                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->os->name = 'Firefox OS';
                        $this->data->device = $device;
                    }
                }
            }

            if (preg_match('/Viera;(?: ([^;]+);)? rv/u', $ua, $match)) {
                $this->data->device->type = Constants\DeviceType::TELEVISION;
                $this->data->os->name = 'Firefox OS';
            }

            if ($this->data->device->type == Constants\DeviceType::MOBILE || $this->data->device->type == Constants\DeviceType::TABLET) {
                $this->data->browser->name = 'Firefox Mobile';
            }

            if ($this->data->device->type == '') {
                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }
        }

        if (preg_match('/Namoroka/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Firefox';

            if (preg_match('/Namoroka\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->browser->channel = 'Namoroka';
        }

        if (preg_match('/Shiretoko/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Firefox';

            if (preg_match('/Shiretoko\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->browser->channel = 'Shiretoko';
        }

        if (preg_match('/Minefield/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Firefox';

            if (preg_match('/Minefield\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->browser->channel = 'Minefield';
        }

        if (preg_match('/BonEcho/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Firefox';

            if (preg_match('/BonEcho\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->browser->channel = 'BonEcho';
        }

        if (preg_match('/Firebird/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Firebird';

            if (preg_match('/Firebird\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }
        }

        if (preg_match('/FxiOS\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Firefox';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
        }


        /* Set the browser family */

        if ($this->data->isBrowser('Firefox')) {
            $this->data->browser->family = new Family([ 'name' => $this->data->browser->name, 'version' => $this->data->browser->version ]);
        }
    }


    /* Seamonkey */

    private function detectSeamonkey($ua)
    {
        if (preg_match('/SeaMonkey/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'SeaMonkey';

            if (preg_match('/SeaMonkey\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            if ($this->data->device->type == '') {
                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }
        }

        if (preg_match('/PmWFx\/([0-9ab.]*)/u', $ua, $match)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'SeaMonkey';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
        }
    }


    /* Netscape */

    private function detectLegacyNetscape($ua)
    {
        if ($this->data->device->type == Constants\DeviceType::DESKTOP && $this->data->browser->getName() == '') {
            if (!preg_match('/compatible;/u', $ua)) {
                if (preg_match('/Mozilla\/([123].[0-9]+)/u', $ua, $match)) {
                    $this->data->browser->name = 'Netscape Navigator';
                    $this->data->browser->version = new Version([ 'value' => preg_replace("/([0-9])([0-9])/", '$1.$2', $match[1]) ]);
                }

                if (preg_match('/Mozilla\/(4.[0-9]+)/u', $ua, $match)) {
                    $this->data->browser->name = 'Netscape Communicator';
                    $this->data->browser->version = new Version([ 'value' => preg_replace("/([0-9])([0-9])/", '$1.$2', $match[1]) ]);
                }
            }
        }
    }

    private function detectModernNetscape($ua)
    {
        if (preg_match('/Netscape/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Netscape';

            if (preg_match('/Netscape[0-9]?\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }
        }
    }


    /* UC Browser */

    private function detectUC($ua)
    {
        if (preg_match('/UCWEB/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'UC Browser';

            unset($this->data->browser->channel);

            if (preg_match('/UCWEB\/?([0-9]*[.][0-9]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }

            if (!$this->data->device->type) {
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }

            if (isset($this->data->os->name) && $this->data->os->name == 'Linux') {
                $this->data->os->name = '';
            }

            if (preg_match('/^IUC ?\(U; ?iOS ([0-9\._]+);/u', $ua, $match)) {
                $this->data->os->name = 'iOS';
                $this->data->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
            }

            if (preg_match('/^JUC ?\(Linux; ?U; ?(?:Android)? ?([0-9\.]+)[^;]*; ?[^;]+; ?([^;]*[^\s])\s*; ?[0-9]+\*[0-9]+;?\)/u', $ua, $match)) {
                $this->data->os->name = 'Android';
                $this->data->os->version = new Version([ 'value' => $match[1] ]);

                $this->data->device = Data\DeviceModels::identify('android', $match[2]);
            }

            if (preg_match('/; Adr ([0-9\.]+)(?:-update[0-9])?; [^;]+; ([^;]*[^\s])\)/u', $ua, $match)) {
                $this->data->os->name = 'Android';
                $this->data->os->version = new Version([ 'value' => $match[1] ]);

                $this->data->device = Data\DeviceModels::identify('android', $match[2]);
            }

            if (preg_match('/\((?:iOS|iPhone);/u', $ua)) {
                $this->data->os->name = 'iOS';
                $this->data->os->version = new Version([ 'value' => '1.0' ]);

                if (preg_match('/OS[_ ]([0-9_]*);/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
                }

                if (preg_match('/; ([^;]+)\)/u', $ua, $match)) {
                    $device = Data\DeviceModels::identify('ios', $match[1]);

                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }
            }

            if (preg_match('/\(Windows;/u', $ua)) {
                $this->data->os->name = 'Windows Phone';
                $this->data->os->version = null;

                if (preg_match('/wds ([0-9]\.[0-9])/u', $ua, $match)) {
                    switch ($match[1]) {
                        case '7.0':
                            $this->data->os->version = new Version([ 'value' => '7.0' ]);
                            break;
                        case '7.1':
                            $this->data->os->version = new Version([ 'value' => '7.5' ]);
                            break;
                        case '8.0':
                            $this->data->os->version = new Version([ 'value' => '8.0' ]);
                            break;
                    }
                }

                if (preg_match('/; ([^;]+); ([^;]+)\)/u', $ua, $match)) {
                    $this->data->device->manufacturer = $match[1];
                    $this->data->device->model = $match[2];
                    $this->data->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('wp', $match[2]);

                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }
            }
        }

        if (preg_match('/Ucweb\/([0-9]*[.][0-9]*)/u', $ua, $match)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'UC Browser';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
        }

        if (preg_match('/ucweb-squid/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'UC Browser';

            unset($this->data->browser->channel);
        }

        if (preg_match('/\) ?UC /u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'UC Browser';

            unset($this->data->browser->version);
            unset($this->data->browser->channel);
            unset($this->data->browser->mode);

            if (!$this->data->device->type) {
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }

            if ($this->data->device->type == Constants\DeviceType::DESKTOP) {
                $this->data->device->type = Constants\DeviceType::MOBILE;
                $this->data->browser->mode = 'desktop';
            }
        }

        if (preg_match('/UC ?Browser\/?([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'UC Browser';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

            unset($this->data->browser->channel);

            if (!$this->data->device->type) {
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }
        }

        if (preg_match('/UBrowser\/?([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'UC Browser';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

            unset($this->data->browser->channel);
        }

        /* U2 is the Proxy service used by UC Browser on low-end phones */
        if (preg_match('/U2\//u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'UC Browser';
            $this->data->browser->mode = 'proxy';

            $this->data->engine->name = 'Gecko';

            /* UC Browser running on Windows 8 is identifing itself as U2, but instead its a Trident Webview */
            if (isset($this->data->os->name) && isset($this->data->os->version)) {
                if ($this->data->os->name == 'Windows Phone' && $this->data->os->version->toFloat() >= 8) {
                    $this->data->engine->name = 'Trident';
                    $this->data->browser->mode = '';
                }
            }

            if (!$this->data->device->identified && preg_match('/; ([^;]*)\) U2\//u', $ua, $match)) {
                $device = Data\DeviceModels::identify('android', $match[1]);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;

                    if (!isset($this->data->os->name) || ($this->data->os->name != 'Android' && (!isset($this->data->os->family) || $this->data->os->family->getName() != 'Android'))) {
                        $this->data->os->name = 'Android';
                    }
                }
            }
        }

        /* U3 is the Webkit based Webview used on Android phones */
        if (preg_match('/U3\//u', $ua)) {
            $this->data->engine->name = 'Webkit';
        }
    }

    private function detectUCEngine($ua)
    {
        if (isset($this->data->browser->name)) {
            if ($this->data->browser->name == 'UC Browser') {
                if (!preg_match("/UBrowser\//", $ua) && ($this->data->device->type == 'desktop' || (isset($this->data->os->name) && ($this->data->os->name == 'Windows' || $this->data->os->name == 'OS X')))) {
                    $this->data->device->type = Constants\DeviceType::MOBILE;

                    $this->data->browser->mode = 'desktop';

                    unset($this->data->engine->name);
                    unset($this->data->engine->version);
                    unset($this->data->os->name);
                    unset($this->data->os->version);
                } elseif (!isset($this->data->os->name) || ($this->data->os->name != 'iOS' && $this->data->os->name != 'Windows Phone' && $this->data->os->name != 'Windows' && $this->data->os->name != 'Android' && (!isset($this->data->os->family) || $this->data->os->family->getName() != 'Android'))) {
                    $this->data->engine->name = 'Gecko';
                    unset($this->data->engine->version);
                    $this->data->browser->mode = 'proxy';
                }

                if (isset($this->data->engine->name) && $this->data->engine->name == 'Presto') {
                    $this->data->engine->name = 'Webkit';
                    unset($this->data->engine->version);
                }
            }
        }
    }


    /* Netfront */

    private function detectNetfront($ua)
    {
        if (preg_match('/Net[fF]ront/u', $ua)) {
            $this->data->browser->name = 'NetFront';
            $this->data->device->type = Constants\DeviceType::MOBILE;

            if (preg_match('/NetFront\/?([0-9.]*)/ui', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            if (preg_match('/(InettvBrowser|HbbTV)/u', $ua)) {
                $this->data->device->type = Constants\DeviceType::TELEVISION;
            }

            if (preg_match('/Kindle/u', $ua)) {
                $this->data->device->type = Constants\DeviceType::EREADER;
            }
        }

        if (preg_match('/Browser\/NF([0-9.]*)/ui', $ua, $match)) {
            $this->data->browser->name = 'NetFront';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->device->type = Constants\DeviceType::MOBILE;
        }

        if (preg_match('/Browser\/NetFont-([0-9.]*)/ui', $ua, $match)) {
            $this->data->browser->name = 'NetFront';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->device->type = Constants\DeviceType::MOBILE;
        }

        if (preg_match('/NX\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'NetFront NX';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

            if (!isset($this->data->device->type) || !$this->data->device->type) {
                if (preg_match('/(DTV|HbbTV)/iu', $ua)) {
                    $this->data->device->type = Constants\DeviceType::TELEVISION;
                } elseif (preg_match('/mobile/iu', $ua)) {
                    $this->data->device->type = Constants\DeviceType::MOBILE;
                } else {
                    $this->data->device->type = Constants\DeviceType::DESKTOP;
                }
            }

            $this->data->os->name = '';
            $this->data->os->version = null;
        }
    }


    /* Obigo */

    private function detectObigo($ua)
    {
        if (preg_match('/(?:Obigo|Teleca)/ui', $ua)) {
            $this->data->browser->name = 'Obigo';

            if (preg_match('/Obigo\/0?([0-9.]+)/iu', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            } elseif (preg_match('/TelecaBrowser\/([A-Z]+)0?([0-9.]+)/iu', $ua, $match)) {
                $this->data->browser->name = 'Obigo ' . $match[1];
                $this->data->browser->version = new Version([ 'value' => $match[2] ]);
            } elseif (preg_match('/(?:Obigo(?:InternetBrowser|[- ]Browser)?|Teleca)\/([A-Z]+)0?([0-9.]+)/ui', $ua, $match)) {
                $this->data->browser->name = 'Obigo ' . $match[1];
                $this->data->browser->version = new Version([ 'value' => $match[2] ]);
            } elseif (preg_match('/(?:Obigo|Teleca)[- ]([A-Z]+)0?([0-9.]+)(?:[A-Z][0-9])?(?:[\/;]|$)/ui', $ua, $match)) {
                $this->data->browser->name = 'Obigo ' . $match[1];
                $this->data->browser->version = new Version([ 'value' => $match[2] ]);
            } elseif (preg_match('/Browser\/(?:Obigo|Teleca)[_-](?:Browser\/)?([A-Z]+)0?([0-9.]+)/ui', $ua, $match)) {
                $this->data->browser->name = 'Obigo ' . $match[1];
                $this->data->browser->version = new Version([ 'value' => $match[2] ]);
            }
        }
    }


    /* ANT Galio and ANT Fresco */

    private function detectAnt($ua)
    {
        if (preg_match('/ANTFresco\/([0-9.]+)/iu', $ua, $match)) {
            $this->data->browser->name = 'ANT Fresco';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
        }

        if (preg_match('/ANTGalio\/([0-9.]+)/iu', $ua, $match)) {
            $this->data->browser->name = 'ANT Galio';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
        }
    }


    /* MachBlue */

    private function detectMachBlue($ua)
    {
        if (preg_match('/mbxtWebKit\/([0-9.]*)/u', $ua, $match)) {
            $this->data->os->name = '';
            $this->data->browser->name = 'MachBlue XT';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->device->type = Constants\DeviceType::TELEVISION;
        }

        if ($ua == 'MachBlue') {
            $this->data->os->name = '';
            $this->data->browser->name = 'MachBlue XT';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
        }
    }


    /* Espial */

    private function detectEspial($ua)
    {
        if (preg_match('/Espial/u', $ua)) {
            $this->data->browser->name = 'Espial';

            $this->data->os->name = '';
            $this->data->os->version = null;

            if ($this->data->device->type != Constants\DeviceType::TELEVISION) {
                $this->data->device->type = Constants\DeviceType::TELEVISION;
                $this->data->device->manufacturer = null;
                $this->data->device->model = null;
            }

            if (preg_match('/Espial\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            if (preg_match('/;L7200/u', $ua)) {
                $this->data->device->manufacturer = 'Toshiba';
                $this->data->device->model = 'Regza L7200';
                $this->data->device->series = 'Smart TV';
                $this->data->device->identified |= Constants\Id::MATCH_UA;
                $this->data->device->generic = false;
            }
        }
    }


    /* Iris */

    private function detectIris($ua)
    {
        if (preg_match('/Iris[ \/]/u', $ua)) {
            $this->data->browser->name = 'Iris';

            $this->data->device->type = Constants\DeviceType::MOBILE;
            $this->data->device->manufacturer = null;
            $this->data->device->model = null;

            $this->data->os->name = 'Windows Mobile';
            $this->data->os->version = null;

            if (preg_match('/Iris\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            if (preg_match('/ WM([0-9]) /u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] . '.0' ]);
            } else {
                $this->data->browser->mode = 'desktop';
            }
        }
    }


    /* Dolfin */

    private function detectDolfin($ua)
    {
        if (preg_match('/Dolfin/u', $ua) || preg_match('/Jasmine/u', $ua)) {
            $this->data->browser->name = 'Dolfin';

            if (preg_match('/Dolfin\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            if (preg_match('/Browser\/Dolfin([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            if (preg_match('/Jasmine\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }
        }
    }


    /* WebOS */

    private function detectWebOSBrowser($ua)
    {
        if (preg_match('/wOSBrowser/u', $ua)) {
            $this->data->browser->name = 'webOS Browser';

            if ($this->data->os->name != 'webOS') {
                $this->data->os->name = 'webOS';
            }
        }
    }


    /* Sailfish */

    private function detectSailfishBrowser($ua)
    {
        if (preg_match('/Sailfish ?Browser/u', $ua)) {
            $this->data->browser->name = 'Sailfish Browser';
            $this->data->browser->stock = true;

            if (preg_match('/Sailfish ?Browser\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            }
        }
    }


    /* Silk */

    private function detectSilk($ua)
    {
        if (preg_match('/Silk/u', $ua)) {
            if (preg_match('/Silk-Accelerated/u', $ua) || !preg_match('/PlayStation/u', $ua)) {
                $this->data->browser->name = 'Silk';
                $this->data->browser->channel = null;

                if (preg_match('/Silk\/([0-9.]*)/u', $ua, $match)) {
                    $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
                }

                if (preg_match('/; ([^;]*[^;\s])\s+Build/u', $ua, $match)) {
                    $this->data->device = Data\DeviceModels::identify('android', $match[1]);
                }

                if (!$this->data->device->identified) {
                    $this->data->device->manufacturer = 'Amazon';
                    $this->data->device->model = 'Kindle Fire';
                    $this->data->device->type = Constants\DeviceType::TABLET;
                    $this->data->device->identified |= Constants\Id::INFER;

                    if (isset($this->data->os->name) && ($this->data->os->name != 'Android' || $this->data->os->name != 'FireOS')) {
                        $this->data->os->name = 'FireOS';
                        $this->data->os->family = new Family([ 'name' => 'Android' ]);
                        $this->data->os->alias = null;
                        $this->data->os->version = null;
                    }
                }
            }
        }
    }


    /* Nokia */

    private function detectNokiaBrowser($ua)
    {
        /* Nokia Browser */

        if (preg_match('/BrowserNG/u', $ua)) {
            $this->data->browser->name = 'Nokia Browser';

            if (preg_match('/BrowserNG\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3, 'builds' => false ]);
            }
        }

        if (preg_match('/NokiaBrowser/u', $ua)) {
            $this->data->browser->name = 'Nokia Browser';
            $this->data->browser->channel = null;

            if (preg_match('/NokiaBrowser\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }
        }


        /* Nokia Xpress for S30+, S40 and Windows Phone */

        if (preg_match('/OSRE/u', $ua)) {
            $this->data->browser->name = 'Nokia Xpress';
            $this->data->browser->mode = 'proxy';
            $this->data->device->type = Constants\DeviceType::MOBILE;

            $this->data->os->name = null;
            $this->data->os->version = null;
        }

        if (preg_match('/S40OviBrowser/u', $ua)) {
            $this->data->browser->name = 'Nokia Xpress';
            $this->data->browser->mode = 'proxy';

            if (preg_match('/S40OviBrowser\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }

            if (preg_match('/Nokia([^\/]+)\//u', $ua, $match)) {
                $this->data->device->manufacturer = 'Nokia';
                $this->data->device->model = $match[1];
                $this->data->device->identified |= Constants\Id::PATTERN;

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


                        if (preg_match('/java_runtime_version=Nokia_Asha_([0-9_]+);/u', $ua, $match)) {
                            $this->data->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
                        }
                    }
                }
            }

            if (preg_match('/NOKIALumia([0-9]+)/u', $ua, $match)) {
                $this->data->device->manufacturer = 'Nokia';
                $this->data->device->model = $match[1];
                $this->data->device->identified |= Constants\Id::PATTERN;

                $device = Data\DeviceModels::identify('wp', $this->data->device->model);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                    $this->data->os->name = 'Windows Phone';
                }
            }
        }


        /* MicroB - the default browser for maemo */

        if (preg_match('/Maemo[ |_]Browser/u', $ua)) {
            $this->data->browser->name = 'MicroB';

            if (preg_match('/Maemo[ |_]Browser[ |_]([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }
        }
    }


    /* Konqueror */

    private function detectKonqueror($ua)
    {
        if (preg_match('/[k|K]onqueror\//u', $ua)) {
            $this->data->browser->name = 'Konqueror';

            if (preg_match('/[k|K]onqueror\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            if ($this->data->device->type == '') {
                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }
        }
    }


    /* Other browsers */

    private function detectSpecficBrowsers($ua)
    {
        /* Boxee */

        if (preg_match('/Boxee/u', $ua)) {
            $this->data->browser->name = 'Boxee';
            $this->data->device->type = Constants\DeviceType::TELEVISION;

            if (preg_match('/Boxee\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }
        }

        /* XBMC */

        if (preg_match('/^XBMC\/(?:PRE-)?([0-9.]+)/u', $ua, $match)) {
            $this->data->browser->name = 'XBMC';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
        }

        /* Kodi */

        if (preg_match('/^Kodi\/([0-9.]+)/u', $ua, $match)) {
            $this->data->browser->name = 'Kodi';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
        }

        /* Sraf TV Browser */

        if (preg_match('/sraf_tv_browser/u', $ua)) {
            $this->data->browser->name = 'Sraf TV Browser';
            $this->data->browser->version = null;
            $this->data->device->type = Constants\DeviceType::TELEVISION;
        }

        /* LG Browser */

        if (preg_match('/LG Browser\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'LG Browser';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->device->type = Constants\DeviceType::TELEVISION;
        }

        if (preg_match('/NetCast/u', $ua) && preg_match('/SmartTV\//u', $ua)) {
            unset($this->data->browser->name);
            unset($this->data->browser->version);
        }

        /* Sony Browser */

        if (preg_match('/SonyBrowserCore\/([0-9.]*)/u', $ua, $match)) {
            unset($this->data->browser->name);
            unset($this->data->browser->version);
            $this->data->device->type = Constants\DeviceType::TELEVISION;
        }

        /* NineSky */

        if (preg_match('/Ninesky(?:-android-mobile(?:-cn)?)?\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'NineSky';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);

            if (isset($this->data->device->manufacturer) && $this->data->device->manufacturer == 'Apple') {
                unset($this->data->device->manufacturer);
                unset($this->data->device->model);
                unset($this->data->device->identifier);
                $this->data->device->identified = Constants\Id::NONE;
            }

            if (isset($this->data->os->name) && $this->data->os->name != 'Android') {
                $this->data->os->name = 'Android';
                $this->data->os->version = null;
            }
        }

        /* Skyfire */

        if (preg_match('/Skyfire\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Skyfire';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);

            $this->data->device->type = Constants\DeviceType::MOBILE;

            $this->data->os->name = 'Android';
            $this->data->os->version = null;
        }

        /* Dolphin HD */

        if (preg_match('/Dolphin(?:HDCN)?\/(?:INT|CN)?-?([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Dolphin';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);

            $this->data->device->type = Constants\DeviceType::MOBILE;
        }

        /* QQ Browser */

        if (preg_match('/(M?QQBrowser)\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'QQ Browser';

            $version = $match[2];
            if (preg_match('/^[0-9][0-9]$/u', $version)) {
                $version = $version[0] . '.' . $version[1];
            }

            $this->data->browser->version = new Version([ 'value' => $version, 'details' => 2 ]);
            $this->data->browser->channel = '';

            if (!isset($this->data->os->name) && $match[1] == 'QQBrowser') {
                $this->data->os->name = 'Windows';
            }
        }

        if (preg_match('/MQQBrowser\/Mini([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'QQ Browser Mini';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->channel = '';
        }

        /* 360 Phone Browser */

        if (preg_match('/360 (?:Aphone|Android Phone) Browser \((?:Version |V)?([0-9.]*)(?:beta)?\)/u', $ua, $match)) {
            $this->data->browser->name = '360 Phone Browser';
            $this->data->browser->channel = '';
            $this->data->browser->version = null;
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            
            if (preg_match('/360\(android/u', $ua) && (!isset($this->data->os->name) || ($this->data->os->name != 'Android' && (!isset($this->data->os->family) || $this->data->os->family->getName() != 'Android')))) {
                $this->data->os->name = 'Android';
                $this->data->os->version = null;
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }
        }

        /* iBrowser */

        if (preg_match('/(iBrowser)\/([0-9.]*)/u', $ua, $match) && !preg_match('/OviBrowser/u', $ua)) {
            $this->data->browser->name = 'iBrowser';

            $version = $match[2];
            if (preg_match('/^[0-9][0-9]$/u', $version)) {
                $version = $version[0] . '.' . $version[1];
            }

            $this->data->browser->version = new Version([ 'value' => $version, 'details' => 2 ]);
            $this->data->browser->channel = '';
        }

        if (preg_match('/iBrowser\/Mini([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'iBrowser Mini';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->channel = '';
        }

        /* Puffin */

        if (preg_match('/Puffin\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Puffin';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->mode = 'proxy';
            $this->data->browser->channel = '';

            $this->data->device->type = Constants\DeviceType::MOBILE;

            if ($this->data->os->name == 'Linux') {
                $this->data->os->name = null;
                $this->data->os->version = null;
            }
        }

        /* Midori */

        if (preg_match('/Midori\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Midori';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);

            $this->data->device->manufacturer = null;
            $this->data->device->model = null;
            $this->data->device->type = Constants\DeviceType::DESKTOP;

            if (isset($this->data->os->name) && $this->data->os->name == 'OS X') {
                $this->data->os->name = null;
                $this->data->os->version = null;
            }
        }

        if (preg_match('/midori(?:\/[0-9.]*)?$/u', $ua)) {
            $this->data->browser->name = 'Midori';
            $this->data->device->type = Constants\DeviceType::DESKTOP;

            if (preg_match('/midori\/([0-9.]*)$/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }
        }

        /* MiniBrowser Mobile */

        if (preg_match('/MiniBr?owserM(?:obile)?\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'MiniBrowser';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);

            $this->data->os->name = 'Series60';
            $this->data->os->version = null;
        }

        /* Maxthon */

        if (preg_match('/Maxthon/iu', $ua, $match)) {
            $this->data->browser->name = 'Maxthon';
            $this->data->browser->channel = '';
            $this->data->browser->version = null;
            
            if (preg_match('/Maxthon[\/\' ]\(?([0-9.]*)\)?/iu', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }

            if (isset($this->data->os->name) && $this->data->browser->version && $this->data->os->name == 'Windows' && $this->data->browser->version->toFloat() < 4) {
                $this->data->browser->version->details = 1;
            }
        }

        if (preg_match('/MxNitro/iu', $ua, $match)) {
            $this->data->browser->name = 'Maxthon Nitro';
            $this->data->browser->channel = '';
            $this->data->browser->version = null;
            
            if (preg_match('/MxNitro\/([0-9.]*)/iu', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }
        }

        /* WebPositive */

        if (preg_match('/WebPositive/u', $ua, $match)) {
            $this->data->browser->name = 'WebPositive';
            $this->data->browser->channel = '';
            $this->data->browser->version = null;

            if (preg_match('/WebPositive\/([0-9]\.[0-9.]+)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }
        }

        /* WorldWideweb */

        if (preg_match('/WorldWideweb \(NEXT\)/u', $ua, $match)) {
            $this->data->browser->name = 'WorldWideWeb';
            $this->data->browser->channel = '';
            $this->data->browser->version = null;

            $this->data->os->name = 'NextStep';
        }

        /* Sogou Mobile */

        if (preg_match('/SogouAndroidBrowser\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Sogou Mobile';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);

            if (isset($this->data->device->manufacturer) && $this->data->device->manufacturer == 'Apple') {
                unset($this->data->device->manufacturer);
                unset($this->data->device->model);
                unset($this->data->device->identifier);
                $this->data->device->identified = Constants\Id::NONE;
            }

            if (isset($this->data->os->name) && $this->data->os->name != 'Android') {
                $this->data->os->name = 'Android';
                $this->data->os->version = null;
            }
        }

        /* Xiino */

        if (preg_match('/Xiino\/([^;]+);/u', $ua, $match)) {
            $this->data->browser->name = 'Xiino';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->os->name = 'Palm OS';
            $this->data->device->type = Constants\DeviceType::MOBILE;
        }

        /* WebPro */

        if (preg_match('/WebPro/u', $ua) && preg_match('/PalmOS/u', $ua)) {
            $this->data->browser->name = 'WebPro';
            $this->data->browser->version = null;

            if (preg_match('/WebPro\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }
        }
    }

    private function detectRemainingBrowsers($ua)
    {
        $browsers = [
            [ 'name' => 'AdobeAIR',             'regexp' => '/AdobeAIR\/([0-9.]*)/u' ],
            [ 'name' => 'Awesomium',            'regexp' => '/Awesomium\/([0-9.]*)/u' ],
            [ 'name' => 'Bsalsa Embedded',      'regexp' => '/EmbeddedWB ([0-9.]*)/u' ],
            [ 'name' => 'Bsalsa Embedded',      'regexp' => '/bsalsa\.com/u' ],
            [ 'name' => 'Bsalsa Embedded',      'regexp' => '/Embedded Web Browser/u' ],
            [ 'name' => 'Canvace',              'regexp' => '/Canvace Standalone\/([0-9.]*)/u' ],
            [ 'name' => 'Ekioh',                'regexp' => '/Ekioh\/([0-9.]*)/u' ],
            [ 'name' => 'JavaFX',               'regexp' => '/JavaFX\/([0-9.]*)/u' ],
            [ 'name' => 'GFXe',                 'regexp' => '/GFXe\/([0-9.]*)/u' ],
            [ 'name' => 'LuaKit',               'regexp' => '/luakit/u' ],
            [ 'name' => 'Titanium',             'regexp' => '/Titanium\/([0-9.]*)/u' ],
            [ 'name' => 'OpenWebKitSharp',      'regexp' => '/OpenWebKitSharp/u' ],
            [ 'name' => 'Prism',                'regexp' => '/Prism\/([0-9.]*)/u' ],
            [ 'name' => 'Qt',                   'regexp' => '/Qt\/([0-9.]*)/u' ],
            [ 'name' => 'Qt',                   'regexp' => '/QtWebEngine\/([0-9.]*)/u' ],
            [ 'name' => 'QtEmbedded',           'regexp' => '/QtEmbedded/u' ],
            [ 'name' => 'QtEmbedded',           'regexp' => '/QtEmbedded.*Qt\/([0-9.]*)/u' ],
            [ 'name' => 'ReqwirelessWeb',       'regexp' => '/ReqwirelessWeb\/([0-9.]*)/u' ],
            [ 'name' => 'RhoSimulator',         'regexp' => '/RhoSimulator/u' ],
            [ 'name' => 'UWebKit',              'regexp' => '/UWebKit\/([0-9.]*)/u' ],
            [ 'name' => 'Node-WebKit',          'regexp' => '/nw-tests\/([0-9.]*)/u' ],
            [ 'name' => 'WebKit2.NET',          'regexp' => '/WebKit2.NET/u' ],

            [ 'name' => 'PhantomJS',            'regexp' => '/PhantomJS\/([0-9.]*)/u' ],

            [ 'name' => 'Google Earth',         'regexp' => '/Google Earth\/([0-9.]*)/u' ],
            [ 'name' => 'Google Desktop',       'regexp' => '/Google Desktop\/([0-9.]*)/u', 'details' => 2 ],

            [ 'name' => 'EA Origin',            'regexp' => '/Origin\/([0-9.]*)/u' ],
            [ 'name' => 'SecondLife',           'regexp' => '/SecondLife\/([0-9.]*)/u' ],
            [ 'name' => 'Valve Steam',          'regexp' => '/Valve Steam/u' ],

            /* Media players */
            [ 'name' => 'iTunes',               'regexp' => '/iTunes\/(?:xaa.)?([0-9.]*)/u' ],
            [ 'name' => 'QuickTime',            'regexp' => '/QuickTime[\/\\\\](?:xaa.)?([0-9.]*)/u' ],
            [ 'name' => 'Bluefish',             'regexp' => '/bluefish ([0-9.]*)/u' ],
            [ 'name' => 'Songbird',             'regexp' => '/Songbird\/([0-9.]*)/u' ],
            [ 'name' => 'Stagefright',              'regexp' => '/stagefright\/([0-9.]*)/u' ],
            [ 'name' => 'SubStream',            'regexp' => '/SubStream\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],

            /* Email clients */
            [ 'name' => 'Lightning',            'regexp' => '/Lightning\/([0-9.]*)/u' ],
            [ 'name' => 'Thunderbird',          'regexp' => '/Thunderbird[\/ ]([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Microsoft FrontPage',  'regexp' => '/MS FrontPage ([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Microsoft Outlook',    'regexp' => '/Microsoft Outlook IMO, Build ([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Microsoft Outlook',    'regexp' => '/Microsoft Outlook ([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Microsoft Outlook Express',    'regexp' => '/Outlook-Express\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Lotus Notes',          'regexp' => '/Lotus-Notes\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Postbox',              'regexp' => '/Postbox[\/ ]([0-9.]*)/u', 'details' => 2 ],

            /* Feed readers */
            [ 'name' => 'Akregator',            'regexp' => '/Akregator\/([0-9.]*)/u' ],
            [ 'name' => 'Blogos',               'regexp' => '/Blogos\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],
            [ 'name' => 'FeedDemon',            'regexp' => '/FeedDemon\/([0-9.]*)/u' ],
            [ 'name' => 'Feeddler',             'regexp' => '/FeeddlerRSS\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],
            [ 'name' => 'Feeddler Pro',         'regexp' => '/FeeddlerPro\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],
            [ 'name' => 'Liferea',              'regexp' => '/Liferea\/([0-9.]*)/u' ],
            [ 'name' => 'NewsBlur',             'regexp' => '/NewsBlur\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],
            [ 'name' => 'Newsbeuter',           'regexp' => '/newsbeuter\/([0-9.]*)/u' ],
            [ 'name' => 'Rss Bandit',           'regexp' => '/RssBandit\/([0-9.]*)/u' ],
            [ 'name' => 'Rss Owl',              'regexp' => '/RSSOwl\/([0-9.]*)/u' ],
            [ 'name' => 'Reeder',               'regexp' => '/Reeder\/([0-9.]*)/u' ],
            [ 'name' => 'ReedKit',              'regexp' => '/ReedKit\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],

            /* Social apps */
            [ 'name' => 'Facebook',             'regexp' => '/FBAN\/FBIOS/u' ],
            [ 'name' => 'Facebook',             'regexp' => '/FBAN\/FB4A/u' ],
            [ 'name' => 'Facebook',             'regexp' => '/FB_IAB\/FB4A/u' ],
            [ 'name' => 'Google+',              'regexp' => '/com.google.GooglePlus/u'  ],
            [ 'name' => 'WeChat',               'regexp' => '/MicroMessenger\/([0-9.]*)/u' ],
            [ 'name' => 'Sina Weibo',           'regexp' => '/weibo__([0-9.]*)/u' ],
            [ 'name' => 'Twitter',              'regexp' => '/TwitterAndroid/u' ],
            [ 'name' => 'Kik',                  'regexp' => '/Kik\/([0-9.]*)/u' ],
            [ 'name' => 'WordPress',            'regexp' => '/wp-android\/([0-9.]*)/u' ],

            /* Office suite */
            [ 'name' => 'Microsoft Office',     'regexp' => '/MSOffice ([0-9.]*)/u' ],


            /* Search */
            [ 'name' => 'NAVER',                'regexp' => '/NAVER\(inapp; search; [0-9]+; ([0-9.]*)\)/u' ],

            /* Media players */
            [ 'name' => 'CorePlayer',           'regexp' => '/CorePlayer\/([0-9.]*)/u' ],
            [ 'name' => 'FlyCast',              'regexp' => '/FlyCast\/([0-9.]*)/u' ],

            /* Editors */
            [ 'name' => 'W3C Amaya',            'regexp' => '/amaya\/([0-9.]*)/u' ],

            /* Browsers */
            [ 'name' => '1Browser',             'regexp' => '/1Password\/([0-9.]*)/u' ],
            [ 'name' => '2345 Browser',         'regexp' => '/Mb2345Browser\/([0-9.]*)/u' ],
            [ 'name' => '3G Explorer',          'regexp' => '/3G Explorer\/([0-9.]*)/u', 'details' => 3 ],
            [ 'name' => '4G Explorer',          'regexp' => '/4G Explorer\/([0-9.]*)/u', 'details' => 3 ],
            [ 'name' => '360 Aphone Browser',   'regexp' => '/360 Aphone Browser\(([0-9.]*)\)/u' ],
            [ 'name' => '360 Extreme Explorer', 'regexp' => '/QIHU 360EE/u', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => '360 Safe Explorer',    'regexp' => '/QIHU 360SE/u', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'ABrowse',              'regexp' => '/A[Bb]rowse ([0-9.]*)/u' ],
            [ 'name' => 'Abrowser',             'regexp' => '/Abrowser\/([0-9.]*)/u' ],
            [ 'name' => 'Acorn Browse',         'regexp' => '/Acorn Browse ([0-9.]+)/u'  ],
            [ 'name' => 'AltiBrowser',          'regexp' => '/AltiBrowser\/([0-9.]*)/i' ],
            [ 'name' => 'AOL Desktop',          'regexp' => '/AOL ([0-9.]*); AOLBuild/i' ],
            [ 'name' => 'AOL Browser',          'regexp' => '/America Online Browser (?:[0-9.]*); rev([0-9.]*);/i' ],
            [ 'name' => 'Arachne',              'regexp' => '/Arachne\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Arora',                'regexp' => '/[Aa]rora\/([0-9.]*)/u' ],                         // see: www.arora-browser.org
            [ 'name' => 'Avant Browser',        'regexp' => '/Avant Browser/u' ],
            [ 'name' => 'Avant Browser',        'regexp' => '/Avant TriCore/u' ],
            [ 'name' => 'Aviator',              'regexp' => '/Aviator\/([0-9.]*)/u', 'details' => 1 ],
            [ 'name' => 'Awakening',            'regexp' => '/Awakening Browser\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'AWeb',                 'regexp' => '/Amiga-AWeb(?:\/([0-9.]*))?/u' ],
            [ 'name' => 'Baidu Browser',        'regexp' => '/bdbrowser\/([0-9.]*)/i' ],
            [ 'name' => 'Baidu Browser',        'regexp' => '/bdbrowser_i18n\/([0-9.]*)/i' ],
            [ 'name' => 'Baidu Browser',        'regexp' => '/M?BaiduBrowser\/([0-9.]*)/i' ],
            [ 'name' => 'Baidu Browser',        'regexp' => '/BdMobile\/([0-9.]*)/i' ],
            [ 'name' => 'Baidu Browser',        'regexp' => '/FlyFlow\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Baidu Browser',        'regexp' => '/BIDUBrowser[ \/]([0-9.]*)/u' ],
            [ 'name' => 'Baidu Browser',        'regexp' => '/BaiduHD\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Baidu Spark',          'regexp' => '/BDSpark\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Baidu Hao123',         'regexp' => '/hao123\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Black Wren',           'regexp' => '/BlackWren\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Blazer',               'regexp' => '/Blazer\/([0-9.]*)/u' ],
            [ 'name' => 'BrightSign',           'regexp' => '/BrightSign\/([0-9.]*)/u', 'type' => Constants\DeviceType::SIGNAGE ],
            [ 'name' => 'Bunjalloo',            'regexp' => '/Bunjalloo\/([0-9.]*)/u' ],                                                            // Browser for the Nintento DS
            [ 'name' => 'Byffox',               'regexp' => '/Byffox\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Camino',               'regexp' => '/Camino\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Canure',               'regexp' => '/Canure\/([0-9.]*)/u', 'details' => 3 ],
            [ 'name' => 'CometBird',            'regexp' => '/CometBird\/([0-9.]*)/u' ],
            [ 'name' => 'Comodo Dragon',        'regexp' => '/Comodo_Dragon\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Comodo Dragon',        'regexp' => '/Dragon\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Conkeror',             'regexp' => '/[Cc]onkeror\/([0-9.]*)/u' ],
            [ 'name' => 'CoolNovo',             'regexp' => '/(?:CoolNovo|CoolNovoChromePlus)\/([0-9.]*)/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'ChromePlus',           'regexp' => '/ChromePlus(?:\/([0-9.]*))?$/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Cunaguaro',            'regexp' => '/Cunaguaro\/([0-9.]*)/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'CuteBrowser',          'regexp' => '/CuteBrowser\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Cyberfox',             'regexp' => '/Cyberfox\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Daedalus',             'regexp' => '/Daedalus ([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Daum',                 'regexp' => '/DaumApps\/([0-9.]*)/u' ],
            [ 'name' => 'Daum',                 'regexp' => '/daumcafe\/([0-9.]*)/u' ],
            [ 'name' => 'Dillo',                'regexp' => '/Dillo\/([0-9.]*)/u' ],
            [ 'name' => 'Demobrowser',          'regexp' => '/demobrowser\/([0-9.]*)/u' ],
            [ 'name' => 'Doga Rhodonit',        'regexp' => '/DogaRhodonit/u' ],
            [ 'name' => 'Dorado',               'regexp' => '/Browser\/Dorado([0-9.]*)/u' ],
            [ 'name' => 'Dooble',               'regexp' => '/Dooble(?:\/([0-9.]*))?/u' ],
            [ 'name' => 'Dorothy',              'regexp' => '/Dorothy$/u' ],
            [ 'name' => 'DWB',                  'regexp' => '/dwb(?:-hg)?(?:\/([0-9.]*))?/u' ],
            [ 'name' => 'GNOME Web',            'regexp' => '/Epiphany\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'ELinks',               'regexp' => '/ELinks\/([0-9.]*[0-9])/u', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'EVM Browser',          'regexp' => '/EVMBrowser\/([0-9.]*)/u' ],
            [ 'name' => 'FireWeb',              'regexp' => '/FireWeb\/([0-9.]*)/u' ],
            [ 'name' => 'Flock',                'regexp' => '/Flock\/([0-9.]*)/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Galeon',               'regexp' => '/Galeon\/([0-9.]*)/u', 'details' => 3 ],
            [ 'name' => 'Helium',               'regexp' => '/HeliumMobileBrowser\/([0-9.]*)/u' ],
            [ 'name' => 'Hive Explorer',        'regexp' => '/HiveE/u' ],
            [ 'name' => 'IBrowse',              'regexp' => '/IBrowse[\/ ]([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'iCab',                 'regexp' => '/iCab\/([0-9.]*)/u' ],
            [ 'name' => 'Iceape',               'regexp' => '/Iceape\/([0-9.]*)/u' ],
            [ 'name' => 'IceCat',               'regexp' => '/IceCat[ \/]([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Comodo IceDragon',     'regexp' => '/IceDragon\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Iceweasel',            'regexp' => '/Iceweasel\/([0-9.]*)/iu', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'InternetSurfboard',    'regexp' => '/InternetSurfboard\/([0-9.]*)/u' ],
            [ 'name' => 'Iron',                 'regexp' => '/Iron\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Isis',                 'regexp' => '/BrowserServer/u' ],
            [ 'name' => 'Isis',                 'regexp' => '/ISIS\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Jumanji',              'regexp' => '/jumanji/u' ],
            [ 'name' => 'Kazehakase',           'regexp' => '/Kazehakase\/([0-9.]*)/u' ],
            [ 'name' => 'KChrome',              'regexp' => '/KChrome\/([0-9.]*)/u', 'details' => 3 ],
            [ 'name' => 'Kiosk',                'regexp' => '/Kiosk\/([0-9.]*)/u' ],
            [ 'name' => 'K-Meleon',             'regexp' => '/K-Meleon\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Lbbrowser',            'regexp' => '/LBBROWSER/u' ],
            [ 'name' => 'Leechcraft',           'regexp' => '/Leechcraft(?:\/([0-9.]*))?/u', 'details' => 2 ],
            [ 'name' => 'LieBaoFast',           'regexp' => '/LieBaoFast\/([0-9.]*)/u' ],
            [ 'name' => 'Lobo',                 'regexp' => '/Lobo\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Lotus Expeditor',      'regexp' => '/Gecko Expeditor ([0-9.]*)/u', 'details' => 3 ],
            [ 'name' => 'Lunascape',            'regexp' => '/Lunascape[\/| ]([0-9.]*)/u', 'details' => 3 ],
            [ 'name' => 'Lynx',                 'regexp' => '/Lynx\/([0-9.]*)/u' ],
            [ 'name' => 'iLunascape',           'regexp' => '/iLunascape\/([0-9.]*)/u', 'details' => 3 ],
            [ 'name' => 'Intermec Browser',     'regexp' => '/Intermec\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Jig Browser',          'regexp' => '/jig browser(?: core|9i?)/u' ],
            [ 'name' => 'MaCross Mobile',       'regexp' => '/MaCross\/([0-9.]*)/u' ],
            [ 'name' => 'Mammoth',              'regexp' => '/Mammoth\/([0-9.]*)/u' ],                                      // see: https://itunes.apple.com/cn/app/meng-ma-liu-lan-qi/id403760998?mt=8
            [ 'name' => 'Maxthon',              'regexp' => '/MxBrowser\/([0-9.]*)/u' ],
            [ 'name' => 'Mercury Browser',      'regexp' => '/Mercury\/([0-9.]*)/u' ],
            [ 'name' => 'MixShark',             'regexp' => '/MixShark\/([0-9.]*)/u' ],
            [ 'name' => 'mlbrowser',            'regexp' => '/mlbrowser/u' ],
            [ 'name' => 'Motorola WebKit',      'regexp' => '/MotorolaWebKit(?:\/([0-9.]*))?/u', 'details' => 3 ],
            [ 'name' => 'NetFront Life Browser', 'regexp' => '/NetFrontLifeBrowser\/([0-9.]*)/u' ],
            [ 'name' => 'NetPositive',          'regexp' => '/NetPositive\/([0-9.]*)/u' ],
            [ 'name' => 'Netscape Navigator',   'regexp' => '/Navigator\/([0-9.]*)/u', 'details' => 3 ],
            [ 'name' => 'Odyssey',              'regexp' => '/OWB\/([0-9.]*)/u' ],
            [ 'name' => 'OmniWeb',              'regexp' => '/OmniWeb/u', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'OneBrowser',           'regexp' => '/OneBrowser\/([0-9.]*)/u' ],
            [ 'name' => 'Openwave',             'regexp' => '/Openwave\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
            [ 'name' => 'Openwave',             'regexp' => '/UP\.Browser\/([a-z0-9.]*)/iu', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
            [ 'name' => 'Opera Oupeng',         'regexp' => '/Oupeng\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Oregano',              'regexp' => '/Oregano ([0-9.]*)/u' ],
            [ 'name' => 'Orca',                 'regexp' => '/Orca\/([0-9.]*)/u' ],
            [ 'name' => 'Origyn',               'regexp' => '/Origyn Web Browser/u' ],
            [ 'name' => 'Otter',                'regexp' => '/Otter Browser\/([0-9.]*)/u' ],
            [ 'name' => 'Pale Moon',            'regexp' => '/Pale[mM]oon\/([0-9.]*)/u' ],
            [ 'name' => 'Phantom',              'regexp' => '/Phantom\/V([0-9.]*)/u' ],
            [ 'name' => 'Polaris',              'regexp' => '/Polaris[\/ ]v?([0-9.]*)/iu', 'details' => 2 ],
            [ 'name' => 'Polaris',              'regexp' => '/POLARIS([0-9.]+)/u', 'details' => 2 ],
            [ 'name' => 'Qihoo 360',            'regexp' => '/QIHU THEWORLD/u' ],
            [ 'name' => 'QtCreator',            'regexp' => '/QtCreator\/([0-9.]*)/u' ],
            [ 'name' => 'QtQmlViewer',          'regexp' => '/QtQmlViewer/u' ],
            [ 'name' => 'QtTestBrowser',        'regexp' => '/QtTestBrowser\/([0-9.]*)/u' ],
            [ 'name' => 'QtWeb',                'regexp' => '/QtWeb Internet Browser\/([0-9.]*)/u' ],
            [ 'name' => 'QupZilla',             'regexp' => '/QupZilla\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Ryouko',               'regexp' => '/Ryouko\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                      // see: https://github.com/foxhead128/ryouko
            [ 'name' => 'Roccat',               'regexp' => '/Roccat\/([0-9]\.[0-9.]*)/u' ],
            [ 'name' => 'Raven for Mac',        'regexp' => '/Raven for Mac\/([0-9.]*)/u' ],
            [ 'name' => 'rekonq',               'regexp' => '/rekonq(?:\/([0-9.]*))?/u', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'RockMelt',             'regexp' => '/RockMelt\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'SaaYaa Explorer',      'regexp' => '/SaaYaa/u', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'SEMC Browser',         'regexp' => '/SEMC-Browser\/([0-9.]*)/u' ],
            [ 'name' => 'Sleipnir',             'regexp' => '/Sleipnir\/([0-9.]*)/u', 'details' => 3 ],
            [ 'name' => 'SlimBoat',             'regexp' => '/SlimBoat\/([0-9.]*)/u' ],
            [ 'name' => 'SMBrowser',            'regexp' => '/SMBrowser/u' ],
            [ 'name' => 'Sogou Explorer',       'regexp' => '/SE 2.X MetaSr/u', 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Sogou Mobile',         'regexp' => '/SogouMobileBrowser\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Snowshoe',             'regexp' => '/Snowshoe\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Sputnik',              'regexp' => '/Sputnik\/([0-9.]*)/iu', 'details' => 3 ],
            [ 'name' => 'Stainless',            'regexp' => '/Stainless\/([0-9.]*)/u' ],
            [ 'name' => 'SunChrome',            'regexp' => '/SunChrome\/([0-9.]*)/u' ],
            [ 'name' => 'Superbird',            'regexp' => '/Superbird\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Surf',                 'regexp' => '/Surf\/([0-9.]*)/u' ],
            [ 'name' => 'The World',            'regexp' => '/TheWorld ([0-9.]*)/u' ],
            [ 'name' => 'TaoBrowser',           'regexp' => '/TaoBrowser\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'TaomeeBrowser',        'regexp' => '/TaomeeBrowser\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'TazWeb',               'regexp' => '/TazWeb/u' ],
            [ 'name' => 'Tencent Traveler',     'regexp' => '/TencentTraveler ([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Uzbl',                 'regexp' => '/^Uzbl/u' ],
            [ 'name' => 'Viera Browser',        'regexp' => '/Viera\/([0-9.]*)/u' ],
            [ 'name' => 'Villanova',            'regexp' => '/Villanova\/([0-9.]*)/u', 'details' => 3 ],
            [ 'name' => 'Vimb',                 'regexp' => '/vimb\/([0-9.]*)/u' ],
            [ 'name' => 'Vivaldi',              'regexp' => '/Vivaldi\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Voyager',              'regexp' => '/AmigaVoyager\/([0-9.]*)/u' ],
            [ 'name' => 'WADA Browser',         'regexp' => '/WadaBrowser\/([0-9.]*)/u' ],
            [ 'name' => 'Waterfox',             'regexp' => '/Waterfox\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
            [ 'name' => 'Wavelink Velocity',    'regexp' => '/Wavelink Velocity Browser\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'WebLite',              'regexp' => '/WebLite\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],
            [ 'name' => 'WebRender',            'regexp' => '/WebRender/u' ],
            [ 'name' => 'Webster',              'regexp' => '/Webster ([0-9.]*)/u' ],
            [ 'name' => 'Wear Internet Browser','regexp' => '/WIB\/([0-9.]*)/u' ],
            [ 'name' => 'Wyzo',                 'regexp' => '/Wyzo\/([0-9.]*)/u', 'details' => 3 ],
            [ 'name' => 'Miui Browser',         'regexp' => '/XiaoMi\/MiuiBrowser\/([0-9.]*)/u' ],
            [ 'name' => 'Yandex Browser',       'regexp' => '/YaBrowser\/([0-9.]*)/u', 'details' => 2 ],
            [ 'name' => 'Yelang',               'regexp' => '/Yelang\/([0-9.]*)/u', 'details' => 3 ],                           // see: wellgo.org
            [ 'name' => 'YRC Weblink',          'regexp' => '/YRCWeblink\/([0-9.]*)/u' ],
            [ 'name' => 'Zetakey',              'regexp' => '/Zetakey Webkit\/([0-9.]*)/u' ],
            [ 'name' => 'Zetakey',              'regexp' => '/Zetakey\/([0-9.]*)/u' ],
            [ 'name' => '冲浪浏览器',            'regexp' => '/CMSurfClient-Android/u' ],

            [ 'name' => 'Nimbus',               'regexp' => '/Nimbus\/([0-9.]*)/u' ],

            [ 'name' => 'McAfee Web Gateway',   'regexp' => '/Webwasher\/([0-9.]*)/u' ],
            [ 'name' => 'Android Download Manager', 'regexp' => '/AndroidDownloadManager\/([0-9.]*)/u' ],

            [ 'name' => 'Open Sankoré',         'regexp' => '/Open-Sankore\/([0-9.]*)/u', 'type' => Constants\DeviceType::WHITEBOARD ],
            [ 'name' => 'Coship MMCP',          'regexp' => '/Coship_MMCP_([0-9.]*)/u', 'type' => Constants\DeviceType::SIGNAGE ],
        ];

        for ($b = 0; $b < count($browsers); $b++) {
            if (preg_match($browsers[$b]['regexp'], $ua, $match)) {
                $this->data->browser->name = $browsers[$b]['name'];
                $this->data->browser->channel = '';
                $this->data->browser->hidden = false;
                $this->data->browser->stock = false;

                if (isset($match[1]) && $match[1]) {
                    $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => isset($browsers[$b]['details']) ? $browsers[$b]['details'] : null ]);
                } else {
                    $this->data->browser->version = null;
                }

                if (isset($browsers[$b]['type'])) {
                    $this->data->device->type = $browsers[$b]['type'];
                }
            }
        }
    }
}
