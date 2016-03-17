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

        /* Detect other various mobile browsers */
        $this->detectNokiaBrowser($ua);
        $this->detectSilk($ua);
        $this->detectSailfishBrowser($ua);
        $this->detectWebOSBrowser($ua);
        $this->detectDolfin($ua);
        $this->detectIris($ua);

        /* Detect other browsers */
        $this->detectUC($ua);
        $this->detectObigo($ua);
        $this->detectNetfront($ua);

        /* Detect other specific desktop browsers */
        $this->detectSeamonkey($ua);
        $this->detectModernNetscape($ua);
        $this->detectMosaic($ua);
        $this->detectKonqueror($ua);

        /* Detect other various television browsers */
        $this->detectEspial($ua);
        $this->detectMachBlue($ua);
        $this->detectAnt($ua);
        $this->detectSraf($ua);

        /* Detect other browsers */
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
            $falsepositive = false;

            if (preg_match('/Qt/u', $ua)) {
                $falsepositive = true;
            }

            if (!$falsepositive) {
                if (isset($this->data->os->name) && $this->data->os->name == 'iOS') {
                    $this->data->browser->name = 'Safari';
                    $this->data->browser->type = Constants\BrowserType::BROWSER;
                    $this->data->browser->version = null;
                    $this->data->browser->stock = true;

                    if (preg_match('/Version\/([0-9\.]+)/u', $ua, $match)) {
                        $this->data->browser->version = new Version([ 'value' => $match[1], 'hidden' => true ]);
                    }
                }

                if (isset($this->data->os->name) && ($this->data->os->name == 'OS X' || $this->data->os->name == 'Windows')) {
                    $this->data->browser->name = 'Safari';
                    $this->data->browser->type = Constants\BrowserType::BROWSER;
                    $this->data->browser->stock = $this->data->os->name == 'OS X';

                    if (preg_match('/Version\/([0-9\.]+)/u', $ua, $match)) {
                        $this->data->browser->version = new Version([ 'value' => $match[1] ]);
                    }

                    if (preg_match('/AppleWebKit\/[0-9\.]+\+/u', $ua)) {
                        $this->data->browser->name = 'WebKit Nightly Build';
                        $this->data->browser->version = null;
                    }
                }
            }
        }

        if (preg_match('/(?:Apple-PubSub|AppleSyndication)\//u', $ua)) {
            $this->data->browser->name = 'Safari RSS';
            $this->data->browser->type = Constants\BrowserType::APP_FEEDREADER;
            $this->data->browser->version = null;
            $this->data->browser->stock = true;

            $this->data->os->name = 'OS X';
            $this->data->os->version = null;

            $this->data->device->type = Constants\DeviceType::DESKTOP;
        }
    }


    /* Chrome */

    private function detectChrome($ua)
    {
        if (preg_match('/(?:Chrome|CrMo|CriOS)\/[0-9]/u', $ua) || preg_match('/Browser\/Chrome[0-9]/u', $ua)) {
            $this->data->browser->name = 'Chrome';
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->browser->stock = false;

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
                    $this->data->browser->version->details = 1;
                } elseif ($channel == 'beta') {
                    $this->data->browser->channel = 'Beta';
                } else {
                    $this->data->browser->channel = 'Dev';
                }


                /* Webview for Android 4.4 and higher */
                if (implode('.', array_slice(explode('.', $version), 1, 2)) == '0.0' && (preg_match('/Version\//u', $ua) || preg_match('/Release\//u', $ua))) {
                    $this->data->browser->using = new Using([ 'name' => 'Chromium WebView', 'version' => new Version([ 'value' => explode('.', $version)[0] ]) ]);
                    $this->data->browser->type = Constants\BrowserType::UNKNOWN;
                    $this->data->browser->stock = true;
                    $this->data->browser->name = null;
                    $this->data->browser->version = null;
                    $this->data->browser->channel = null;
                }

                /* Webview for Android 5 */
                if (preg_match('/; wv\)/u', $ua)) {
                    $this->data->browser->using = new Using([ 'name' => 'Chromium WebView', 'version' => new Version([ 'value' => explode('.', $version)[0] ]) ]);
                    $this->data->browser->type = Constants\BrowserType::UNKNOWN;
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
                        $this->data->browser->name = "Samsung Internet";
                        $this->data->browser->channel = null;
                        $this->data->browser->stock = true;
                        $this->data->browser->version = new Version([ 'value' => '1.0' ]);
                    }

                    /* Version 1.5 */
                    if ($version == '28.0.1500.94' && preg_match('/Version\/1.5/u', $ua)) {
                        $this->data->browser->name = "Samsung Internet";
                        $this->data->browser->channel = null;
                        $this->data->browser->stock = true;
                        $this->data->browser->version = new Version([ 'value' => '1.5' ]);
                    }

                    /* Version 1.6 */
                    if ($version == '28.0.1500.94' && preg_match('/Version\/1.6/u', $ua)) {
                        $this->data->browser->name = "Samsung Internet";
                        $this->data->browser->channel = null;
                        $this->data->browser->stock = true;
                        $this->data->browser->version = new Version([ 'value' => '1.6' ]);
                    }

                    /* Version 2.0 */
                    if ($version == '34.0.1847.76' && preg_match('/Version\/2.0/u', $ua)) {
                        $this->data->browser->name = "Samsung Internet";
                        $this->data->browser->channel = null;
                        $this->data->browser->stock = true;
                        $this->data->browser->version = new Version([ 'value' => '2.0' ]);
                    }

                    /* Version 2.1 */
                    if ($version == '34.0.1847.76' && preg_match('/Version\/2.1/u', $ua)) {
                        $this->data->browser->name = "Samsung Internet";
                        $this->data->browser->channel = null;
                        $this->data->browser->stock = true;
                        $this->data->browser->version = new Version([ 'value' => '2.1' ]);
                    }
                }

                /* Samsung Chromium based browsers */
                if (preg_match('/SamsungBrowser\/([0-9.]*)/u', $ua, $match)) {
                    $this->data->browser->name = "Samsung Internet";
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
            $this->data->browser->type = Constants\BrowserType::BROWSER;

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

            $this->data->browser->type = Constants\BrowserType::UNKNOWN;
            $this->data->browser->stock = false;
            $this->data->browser->name = null;
            $this->data->browser->version = null;
            $this->data->browser->channel = null;
        }

        /* Chromium WebView by Amazon */

        if (preg_match('/AmazonWebAppPlatform\//u', $ua)) {
            $this->data->browser->using = new Using([ 'name' => 'Amazon WebView' ]);

            $this->data->browser->type = Constants\BrowserType::UNKNOWN;
            $this->data->browser->stock = false;
            $this->data->browser->name = null;
            $this->data->browser->version = null;
            $this->data->browser->channel = null;
        }

        /* Chromium WebView by Crosswalk */

        if (preg_match('/Crosswalk\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->using = new Using([ 'name' => 'Crosswalk WebView', 'version' => new Version([ 'value' => $match[1], 'details' => 1 ]) ]);

            $this->data->browser->type = Constants\BrowserType::UNKNOWN;
            $this->data->browser->stock = false;
            $this->data->browser->name = null;
            $this->data->browser->version = null;
            $this->data->browser->channel = null;
        }

        /* Set the browser family */

        if ($this->data->isBrowser('Chrome') || $this->data->isBrowser('Chromium')) {
            $this->data->browser->family = new Family([
                'name'      => 'Chrome',
                'version'   => !empty($this->data->browser->version) ? new Version([ 'value' => $this->data->browser->version->getMajor() ]) : null
            ]);
        }
    }


    /* Internet Explorer */

    private function detectExplorer($ua)
    {
        if (preg_match('/\(IE ([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Internet Explorer';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }

        if (preg_match('/Browser\/IE([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Internet Explorer';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }

        if (preg_match('/MSIE/u', $ua)) {
            $this->data->browser->name = 'Internet Explorer';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

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

                if (!empty($this->data->browser->version)) {
                    if ($this->data->browser->version->is('>=', '5.1.1') && $this->data->browser->version->is('<=', '5.1.3')) {
                        $this->data->os->name = 'OS X';
                    }

                    if ($this->data->browser->version->is('>=', '5.2')) {
                        $this->data->os->name = 'OS X';
                    }
                }
            }
        }

        if (preg_match('/Trident\/[789][^\)]+; rv:([0-9.]*)\)/u', $ua, $match)) {
            $this->data->browser->name = 'Internet Explorer';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }

        if (preg_match('/Trident\/[789][^\)]+; Touch; rv:([0-9.]*);\s+IEMobile\//u', $ua, $match)) {
            $this->data->browser->name = 'Mobile Internet Explorer';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }

        if (preg_match('/Trident\/[789][^\)]+; Touch; rv:([0-9.]*); WPDesktop/u', $ua, $match)) {
            $this->data->browser->mode = 'desktop';
            $this->data->browser->name = 'Mobile Internet Explorer';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }

        /* Old versions of Pocket Internet Explorer */

        if ($this->data->isBrowser('Mobile Internet Explorer', '<', 6)) {
            $this->data->browser->name = 'Pocket Internet Explorer';
        }

        if (preg_match('/Microsoft Pocket Internet Explorer\//u', $ua)) {
            $this->data->browser->name = 'Pocket Internet Explorer';
            $this->data->browser->version = new Version([ 'value' => '1.0' ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }

        if (preg_match('/MSPIE ([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Pocket Internet Explorer';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }

        /* Microsoft Mobile Explorer */

        if (preg_match('/MMEF([0-9])([0-9])/u', $ua, $match)) {
            $this->data->browser->name = 'Microsoft Mobile Explorer';
            $this->data->browser->version = new Version([ 'value' => $match[1] . '.' . $match[2] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }


        /* Set the browser family */

        if ($this->data->isBrowser('Internet Explorer') || $this->data->isBrowser('Mobile Internet Explorer') || $this->data->isBrowser('Pocket Internet Explorer')) {
            unset($this->data->browser->family);
        }
    }


    /* Edge */

    private function detectEdge($ua)
    {
        if (preg_match('/Edge\/([0-9]+)/u', $ua, $match)) {
            $this->data->browser->name = 'Edge';
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->browser->channel = '';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 1 ]);
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
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/Edition Developer/iu', $ua)) {
                $this->data->browser->channel = 'Developer';
            }

            if (preg_match('/Edition Next/iu', $ua)) {
                $this->data->browser->channel = 'Next';
            }

            if (preg_match('/Edition Beta/iu', $ua)) {
                $this->data->browser->channel = 'Beta';
            }

            if ($this->data->device->type == Constants\DeviceType::MOBILE) {
                $this->data->browser->name = 'Opera Mobile';
            }
        }

        if (preg_match('/OMI\/([0-9]+\.[0-9]+)/u', $ua, $match)) {
            $this->data->browser->name = 'Opera Devices';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            $this->data->device->type = Constants\DeviceType::TELEVISION;

            unset($this->data->os->name);
            unset($this->data->os->version);
        }

        if ((preg_match('/Opera[\/\-\s]/iu', $ua) || preg_match('/Browser\/Opera/iu', $ua)) && !preg_match('/Opera Software/iu', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Opera';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/Opera[\/| ]?([0-9.]*)/u', $ua, $match)) {
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
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Opera Mini';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }

        if (preg_match('/Coast\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Coast by Opera';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }

        if (preg_match('/Oupeng(?:HD)?[\/-]([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Opera Oupeng';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }
    }


    /* Firefox */

    private function detectFirefox($ua)
    {
        if (preg_match('/Firefox/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Firefox';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

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
                        $this->data->os->reset([ 'name' => 'Firefox OS' ]);
                        $this->data->device = $device;
                    }
                }
            }

            if (preg_match('/Tablet;(?: ([^;]+);)? rv/u', $ua, $match)) {
                $this->data->device->type = Constants\DeviceType::TABLET;
            }

            if (preg_match('/Viera;(?: ([^;]+);)? rv/u', $ua, $match)) {
                $this->data->device->type = Constants\DeviceType::TELEVISION;
                $this->data->os->reset([ 'name' => 'Firefox OS' ]);
            }

            if ($this->data->device->type == Constants\DeviceType::MOBILE || $this->data->device->type == Constants\DeviceType::TABLET) {
                $this->data->browser->name = 'Firefox Mobile';
            }

            if ($this->data->device->type == '') {
                $this->data->device->type = Constants\DeviceType::DESKTOP;
            }
        }


        if (preg_match('/GranParadiso/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Firefox';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/GranParadiso\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->browser->channel = 'Gran Paradiso';
        }

        if (preg_match('/Namoroka/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Firefox';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/Namoroka\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->browser->channel = 'Namoroka';
        }

        if (preg_match('/Shiretoko/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Firefox';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/Shiretoko\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->browser->channel = 'Shiretoko';
        }

        if (preg_match('/Minefield/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Firefox';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/Minefield\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->browser->channel = 'Minefield';
        }

        if (preg_match('/BonEcho/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Firefox';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/BonEcho\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->browser->channel = 'BonEcho';
        }

        if (preg_match('/Fennec/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Firefox Mobile';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/Fennec\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->browser->channel = 'Fennec';
        }

        if (preg_match('/Minimo/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Minimo';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/Minimo\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }
        }

        if (preg_match('/Phoenix/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Phoenix';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/Phoenix\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }
        }

        if (preg_match('/Firebird/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Firebird';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/Firebird\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }
        }

        if (preg_match('/FxiOS\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Firefox';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }


        /* Set the browser family */

        if ($this->data->isBrowser('Firefox') || $this->data->isBrowser('Firefox Mobile') || $this->data->isBrowser('Firebird')) {
            $this->data->browser->family = new Family([ 'name' => 'Firefox', 'version' => $this->data->browser->version ]);
        }

        if ($this->data->isBrowser('Minimo')) {
            $this->data->browser->family = new Family([ 'name' => 'Firefox' ]);
        }
    }


    /* Seamonkey */

    private function detectSeamonkey($ua)
    {
        if (preg_match('/SeaMonkey/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'SeaMonkey';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/SeaMonkey\/([0-9ab.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }
        }

        if (preg_match('/PmWFx\/([0-9ab.]*)/u', $ua, $match)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'SeaMonkey';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
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
                    $this->data->browser->type = Constants\BrowserType::BROWSER;
                }

                if (preg_match('/Mozilla\/(4.[0-9]+)/u', $ua, $match)) {
                    $this->data->browser->name = 'Netscape Communicator';
                    $this->data->browser->version = new Version([ 'value' => preg_replace("/([0-9])([0-9])/", '$1.$2', $match[1]) ]);
                    $this->data->browser->type = Constants\BrowserType::BROWSER;

                    if (preg_match('/Nav\)/u', $ua)) {
                        $this->data->browser->name = 'Netscape Navigator';
                    }
                }
            }
        }
    }

    private function detectModernNetscape($ua)
    {
        if (preg_match('/Netscape/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Netscape';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/Netscape[0-9]?\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }
        }

        if (preg_match('/ Navigator\/(9\.[0-9.]*)/u', $ua, $match)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'Netscape Navigator';
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
        }
    }


    /* Mosaic */

    private function detectMosaic($ua)
    {
        if (preg_match('/(?:NCSA[ _])?Mosaic(?:\(tm\))?(?: for the X Window System| for Windows)?\/(?:Version )?([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'NCSA Mosaic';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->family = new Family([ 'name' => 'Mosaic' ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->browser->stock = false;
        }

        if (preg_match('/AIR_Mosaic(?:\(16bit\))?\/v([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'AIR Mosaic';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->family = new Family([ 'name' => 'Mosaic' ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->browser->stock = false;
        }

        if (preg_match('/(?:MosaicView|Spyglass[ _]Mosaic)\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Spyglass Mosaic';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->family = new Family([ 'name' => 'Mosaic' ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->browser->stock = false;
        }

        if (preg_match('/SPRY_Mosaic(?:\(16bit\))?\/v([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'SPRY Mosaic';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->family = new Family([ 'name' => 'Mosaic' ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->browser->stock = false;
        }

        if (preg_match('/DCL SuperMosaic\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'SuperMosaic';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->family = new Family([ 'name' => 'Mosaic' ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->browser->stock = false;
        }

        if (preg_match('/VMS_Mosaic\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'VMS Mosaic';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->family = new Family([ 'name' => 'Mosaic' ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->browser->stock = false;
        }

        if (preg_match('/mMosaic\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'mMosaic';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->family = new Family([ 'name' => 'Mosaic' ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->browser->stock = false;
        }

        if (preg_match('/Quarterdeck Mosaic Version ([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Quarterdeck Mosaic';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->family = new Family([ 'name' => 'Mosaic' ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->browser->stock = false;
        }

        if (preg_match('/WinMosaic\/Version ([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'WinMosaic';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->family = new Family([ 'name' => 'Mosaic' ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->browser->stock = false;
        }
    }


    /* UC Browser */

    private function detectUC($ua)
    {
        if (preg_match('/UCWEB/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'UC Browser';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            unset($this->data->browser->channel);

            if (preg_match('/UCWEB\/?([0-9]*[.][0-9]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }

            if (!$this->data->device->type) {
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }

            if (isset($this->data->os->name) && $this->data->os->name == 'Linux') {
                $this->data->os->reset();
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

            if (preg_match('/\(MIDP-2.0; U; [^;]+; ([^;]*[^\s])\)/u', $ua, $match)) {
                $this->data->os->name = 'Android';

                $this->data->device->model = $match[1];
                $this->data->device->identified |= Constants\Id::PATTERN;

                $device = Data\DeviceModels::identify('android', $match[1]);

                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            if (preg_match('/\((?:Linux|MIDP-2.0); U; Adr ([0-9\.]+)(?:-update[0-9])?; [^;]+; ([^;]*[^\s])\)/u', $ua, $match)) {
                $this->data->os->name = 'Android';
                $this->data->os->version = new Version([ 'value' => $match[1] ]);

                $this->data->device->model = $match[2];
                $this->data->device->identified |= Constants\Id::PATTERN;

                $device = Data\DeviceModels::identify('android', $match[2]);

                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
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

            if (preg_match('/\(Symbian;/u', $ua)) {
                $this->data->os->name = 'Series60';
                $this->data->os->version = null;
                $this->data->os->family = new Family([ 'name' => 'Symbian' ]);

                if (preg_match('/S60 V([0-9])/u', $ua, $match)) {
                    $this->data->os->version = new Version([ 'value' => $match[1] ]);
                }

                if (preg_match('/; Nokia([^;]+)\)/iu', $ua, $match)) {
                    $this->data->device->model = $match[1];
                    $this->data->device->identified |= Constants\Id::PATTERN;

                    $device = Data\DeviceModels::identify('symbian', $match[1]);

                    if ($device->identified) {
                        $device->identified |= $this->data->device->identified;
                        $this->data->device = $device;
                    }
                }
            }

            if (preg_match('/\(Windows;/u', $ua)) {
                $this->data->os->name = 'Windows Phone';
                $this->data->os->version = null;

                if (preg_match('/wds ([0-9]+\.[0-9])/u', $ua, $match)) {
                    switch ($match[1]) {
                        case '7.1':
                            $this->data->os->version = new Version([ 'value' => '7.5' ]);
                            break;
                        case '8.0':
                            $this->data->os->version = new Version([ 'value' => '8.0' ]);
                            break;
                        case '8.1':
                            $this->data->os->version = new Version([ 'value' => '8.1' ]);
                            break;
                        case '10.0':
                            $this->data->os->version = new Version([ 'value' => '10.0' ]);
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
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }

        if (preg_match('/ucweb-squid/u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'UC Browser';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            unset($this->data->browser->channel);
        }

        if (preg_match('/\) ?UC /u', $ua)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'UC Browser';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            unset($this->data->browser->version);
            unset($this->data->browser->channel);
            unset($this->data->browser->mode);

            if ($this->data->device->type == Constants\DeviceType::DESKTOP) {
                $this->data->device->type = Constants\DeviceType::MOBILE;
                $this->data->browser->mode = 'desktop';
            }
        }

        if (preg_match('/UC ?Browser\/?([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'UC Browser';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            unset($this->data->browser->channel);

            if (!$this->data->device->type) {
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }
        }

        if (preg_match('/UBrowser\/?([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->stock = false;
            $this->data->browser->name = 'UC Browser';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;

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

            if ($this->data->device->identified < Constants\Id::MATCH_UA && preg_match('/; ([^;]*)\) U2\//u', $ua, $match)) {
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
                    $this->data->engine->reset();
                    $this->data->os->reset();
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
        /* Compact NetFront */

        if (preg_match('/CNF\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Compact NetFront';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->device->type = Constants\DeviceType::MOBILE;
        }

        /* NetFront */

        if (preg_match('/Net[fF]ront/u', $ua) && !preg_match('/NetFrontNX/u', $ua)) {
            $this->data->browser->name = 'NetFront';
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            unset($this->data->browser->channel);

            if (preg_match('/NetFront[ \/]?([0-9.]*)/ui', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            /* Detect device type based on NetFront identifier */

            if (preg_match('/MobilePhone/u', $ua)) {
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }

            if (preg_match('/DigitalMediaPlayer/u', $ua)) {
                $this->data->device->type = Constants\DeviceType::MEDIA;
            }

            if (preg_match('/PDA/u', $ua)) {
                $this->data->device->type = Constants\DeviceType::PDA;
            }

            if (preg_match('/MFP/u', $ua)) {
                $this->data->device->type = Constants\DeviceType::PRINTER;
            }

            if (preg_match('/(InettvBrowser|HbbTV|DTV|NetworkAVTV|BDPlayer)/u', $ua)) {
                $this->data->device->type = Constants\DeviceType::TELEVISION;
            }

            if (preg_match('/Kindle/u', $ua)) {
                $this->data->device->type = Constants\DeviceType::EREADER;
            }

            if (empty($this->data->device->type)) {
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }

            /* Detect OS based on NetFront identifier */

            if (preg_match('/NF[0-9][0-9](?:WMPRO|PPC)\//ui', $ua, $match)) {
                if (!$this->data->isOs('Windows Mobile')) {
                    $this->data->os->reset([
                        'name' => 'Windows Mobile'
                    ]);
                }
            }
        }

        if (preg_match('/(?:Browser\/(?:NF|NetFr?ont-)|NF-Browser\/|ACS-NF\/|NetFront FullBrowser\/)([0-9.]*)/ui', $ua, $match)) {
            $this->data->browser->name = 'NetFront';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            unset($this->data->browser->channel);

            $this->data->device->type = Constants\DeviceType::MOBILE;
        }

        /* AVE-Front */

        if (preg_match('/(?:AVE-Front|AveFront)\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'NetFront';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/Category=([^\);]+)[\);]/u', $ua, $match)) {
                switch ($match[1]) {
                    case 'WebPhone':
                        $this->data->device->type = Constants\DeviceType::MOBILE;
                        $this->data->device->subtype = Constants\DeviceSubType::DESKTOP;
                        break;
                    case 'WP':
                    case 'Home Mail Tool':
                    case 'PDA':
                        $this->data->device->type = Constants\DeviceType::PDA;
                        break;
                    case 'STB':
                        $this->data->device->type = Constants\DeviceType::TELEVISION;
                        break;
                    case 'GAME':
                        $this->data->device->type = Constants\DeviceType::GAMING;
                        $this->data->device->subtype = Constants\DeviceSubType::CONSOLE;
                        break;
                }
            }

            if (preg_match('/Product=([^\);]+)[\);]/u', $ua, $match)) {
                if (in_array($match[1], [ 'ACCESS/NFPS', 'SUNSOFT/EnjoyMagic' ])) {
                    $this->data->device->setIdentification([
                        'manufacturer'  =>  'Sony',
                        'model'         =>  'Playstation 2',
                        'type'          =>  Constants\DeviceType::GAMING,
                        'subtype'       =>  Constants\DeviceSubType::CONSOLE
                    ]);
                }
            }
        }

        /* Netfront NX */

        if (preg_match('/NX\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'NetFront NX';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            unset($this->data->browser->channel);

            if (empty($this->data->device->type) || $this->data->isType('desktop')) {
                if (preg_match('/(DTV|HbbTV)/iu', $ua)) {
                    $this->data->device->type = Constants\DeviceType::TELEVISION;
                } else {
                    $this->data->device->type = Constants\DeviceType::DESKTOP;
                }
            }

            $this->data->os->reset();
        }

        /* The Sony Mylo 2 identifies as Firefox 2, but is NetFront */

        if (preg_match('/Sony\/COM2/u', $ua, $match)) {
            $this->data->browser->reset([
                'name' => 'NetFront',
                'type' => Constants\BrowserType::BROWSER
            ]);
        }
    }


    /* Obigo */

    private function detectObigo($ua)
    {
        $processObigoVersion = function ($version) {
            $result = [
                'value' => $version
            ];

            if (preg_match('/[0-9.]+/', $version, $match)) {
                $result['details'] = 2;
            }

            if (preg_match('/([0-9])[A-Z]/', $version, $match)) {
                $result['value'] = intval($match[1]);
                $result['alias'] = $version;
            }

            return $result;
        };

        if (preg_match('/(?:Obigo|Teleca|AU-MIC|MIC\/WAP)/ui', $ua)) {
            $this->data->browser->name = 'Obigo';
            $this->data->browser->version = null;
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/Obigo\/0?([0-9.]+)/iu', $ua, $match)) {
                $this->data->browser->version = new Version($processObigoVersion($match[1]));
            } elseif (preg_match('/(?:MIC|TelecaBrowser)\/(WAP|[A-Z])?0?([0-9.]+[A-Z]?)/iu', $ua, $match)) {
                $this->data->browser->version = new Version($processObigoVersion($match[2]));
                if (!empty($match[1])) {
                    $this->data->browser->name = 'Obigo ' . strtoupper($match[1]);
                }
            } elseif (preg_match('/(?:Obigo(?:InternetBrowser|[- ]Browser)?|Teleca)\/(WAP|[A-Z])?[0O]?([0-9.]+[A-Z]?)/ui', $ua, $match)) {
                $this->data->browser->version = new Version($processObigoVersion($match[2]));
                if (!empty($match[1])) {
                    $this->data->browser->name = 'Obigo ' . strtoupper($match[1]);
                }
            } elseif (preg_match('/(?:Obigo|Teleca)[- ]([WAP|[A-Z])?0?([0-9.]+[A-Z]?)(?:[0-9])?(?:[\/;]|$)/ui', $ua, $match)) {
                $this->data->browser->version = new Version($processObigoVersion($match[2]));
                if (!empty($match[1])) {
                    $this->data->browser->name = 'Obigo ' . strtoupper($match[1]);
                }
            } elseif (preg_match('/Browser\/(?:Obigo|Teleca)[_-]?(?:Browser\/)?(WAP|[A-Z])?0?([0-9.]+[A-Z]?)/ui', $ua, $match)) {
                $this->data->browser->version = new Version($processObigoVersion($match[2]));
                if (!empty($match[1])) {
                    $this->data->browser->name = 'Obigo ' . strtoupper($match[1]);
                }
            } elseif (preg_match('/Obigo Browser (WAP|[A-Z])?0?([0-9.]+[A-Z]?)/ui', $ua, $match)) {
                $this->data->browser->version = new Version($processObigoVersion($match[2]));
                if (!empty($match[1])) {
                    $this->data->browser->name = 'Obigo ' . strtoupper($match[1]);
                }
            }
        }

        if (preg_match('/(Q)0?([0-9][A-Z])/u', $ua, $match)) {
            $this->data->browser->name = 'Obigo ' . $match[1];
            $this->data->browser->version = new Version($processObigoVersion($match[2]));
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }
    }


    /* ANT Galio and ANT Fresco */

    private function detectAnt($ua)
    {
        if (preg_match('/ANTFresco\/([0-9.]+)/iu', $ua, $match)) {
            $this->data->browser->name = 'ANT Fresco';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }

        if (preg_match('/ANTGalio\/([0-9.]+)/iu', $ua, $match)) {
            $this->data->browser->name = 'ANT Galio';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }
    }


    /* Seraphic Sraf */

    private function detectSraf($ua)
    {
        if (preg_match('/sraf_tv_browser/u', $ua)) {
            $this->data->browser->name = 'Seraphic Sraf';
            $this->data->browser->version = null;
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->device->type = Constants\DeviceType::TELEVISION;
        }

        if (preg_match('/SRAF\/([0-9.]+)/iu', $ua, $match)) {
            $this->data->browser->name = 'Seraphic Sraf';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->device->type = Constants\DeviceType::TELEVISION;
        }
    }


    /* MachBlue */

    private function detectMachBlue($ua)
    {
        if (preg_match('/mbxtWebKit\/([0-9.]*)/u', $ua, $match)) {
            $this->data->os->name = '';
            $this->data->browser->name = 'MachBlue XT';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->device->type = Constants\DeviceType::TELEVISION;
        }

        if ($ua == 'MachBlue') {
            $this->data->os->name = '';
            $this->data->browser->name = 'MachBlue XT';
            $this->data->device->type = Constants\DeviceType::TELEVISION;
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }
    }


    /* Espial */

    private function detectEspial($ua)
    {
        if (preg_match('/Espial/u', $ua)) {
            $this->data->browser->name = 'Espial';
            $this->data->browser->channel = null;
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            $this->data->os->name = '';
            $this->data->os->version = null;

            if ($this->data->device->type != Constants\DeviceType::TELEVISION) {
                $this->data->device->type = Constants\DeviceType::TELEVISION;
                $this->data->device->manufacturer = null;
                $this->data->device->model = null;
            }

            if (preg_match('/Espial(?: Browser|TVBrowser)?\/(?:sig)?([0-9.]*)/u', $ua, $match)) {
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
        if (preg_match('/Iris\//u', $ua)) {
            $this->data->browser->name = 'Iris';
            $this->data->browser->hidden = false;
            $this->data->browser->stock = false;
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/Iris\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            if (preg_match('/ WM([0-9]) /u', $ua, $match)) {
                $this->data->device->reset();
                $this->data->device->type = Constants\DeviceType::MOBILE;

                $this->data->os->reset();
                $this->data->os->name = 'Windows Mobile';
                $this->data->os->version = new Version([ 'value' => $match[1] . '.0' ]);
            }

            if (preg_match('/Windows NT/u', $ua, $match)) {
                $this->data->browser->mode = 'desktop';

                $this->data->device->reset();
                $this->data->device->type = Constants\DeviceType::MOBILE;

                $this->data->os->reset();
                $this->data->os->name = 'Windows Mobile';
            }
        }
    }


    /* Dolfin */

    private function detectDolfin($ua)
    {
        if (preg_match('/Dolfin/u', $ua) || preg_match('/Jasmine/u', $ua)) {
            $this->data->browser->name = 'Dolfin';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

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
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if ($this->data->os->name != 'webOS') {
                $this->data->os->name = 'webOS';
            }

            if (isset($this->data->device->manufacturer) && $this->data->device->manufacturer == 'Apple') {
                unset($this->data->device->manufacturer);
                unset($this->data->device->model);
                unset($this->data->device->identifier);
                $this->data->device->identified = Constants\Id::NONE;
            }
        }
    }


    /* Sailfish */

    private function detectSailfishBrowser($ua)
    {
        if (preg_match('/Sailfish ?Browser/u', $ua)) {
            $this->data->browser->name = 'Sailfish Browser';
            $this->data->browser->stock = true;
            $this->data->browser->type = Constants\BrowserType::BROWSER;

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
                $this->data->browser->type = Constants\BrowserType::BROWSER;

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
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/BrowserNG\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3, 'builds' => false ]);
            }
        }

        if (preg_match('/NokiaBrowser/u', $ua)) {
            $this->data->browser->name = 'Nokia Browser';
            $this->data->browser->channel = null;
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/NokiaBrowser\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }
        }

        if (preg_match('/Nokia-Communicator-WWW-Browser/u', $ua)) {
            $this->data->browser->name = 'Nokia Browser';
            $this->data->browser->channel = null;
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/Nokia-Communicator-WWW-Browser\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }
        }


        /* Nokia Xpress for S30+, S40 and Windows Phone */

        if (preg_match('/OSRE/u', $ua)) {
            $this->data->browser->name = 'Nokia Xpress';
            $this->data->browser->mode = 'proxy';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            $this->data->device->type = Constants\DeviceType::MOBILE;

            $this->data->os->name = null;
            $this->data->os->version = null;
        }

        if (preg_match('/S40OviBrowser/u', $ua)) {
            $this->data->browser->name = 'Nokia Xpress';
            $this->data->browser->mode = 'proxy';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

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
            $this->data->browser->type = Constants\BrowserType::BROWSER;

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
            $this->data->browser->type = Constants\BrowserType::BROWSER;

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
            $this->data->browser->type = Constants\BrowserType::APP_MEDIAPLAYER;

            $this->data->device->type = Constants\DeviceType::TELEVISION;

            if (preg_match('/Boxee\/([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }
        }

        /* XBMC */

        if (preg_match('/^XBMC\/(?:PRE-)?([0-9.]+)/u', $ua, $match)) {
            $this->data->browser->name = 'XBMC';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::APP_MEDIAPLAYER;
        }

        /* Kodi */

        if (preg_match('/^Kodi\/([0-9.]+)/u', $ua, $match)) {
            $this->data->browser->name = 'Kodi';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::APP_MEDIAPLAYER;
        }

        /* Web on Roku */

        if (preg_match('/Roku/u', $ua) && preg_match('/Web\/([0-9.]+)/u', $ua, $match)) {
            $this->data->browser->name = 'Web';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }

        /* LG Browser */

        if (preg_match('/LG Browser\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'LG Browser';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
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
            $this->data->browser->reset();
            $this->data->browser->name = 'NineSky';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (isset($this->data->device->manufacturer) && $this->data->device->manufacturer == 'Apple') {
                $this->data->device->reset();
            }

            if (!$this->data->os->isFamily('Android')) {
                $this->data->os->reset();
                $this->data->os->name = 'Android';
            }

            $this->data->device->type = Constants\DeviceType::MOBILE;
        }

        /* Skyfire */

        if (preg_match('/Skyfire\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Skyfire';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            $this->data->device->type = Constants\DeviceType::MOBILE;

            $this->data->os->name = 'Android';
            $this->data->os->version = null;
        }

        /* Dolphin HD */

        if (preg_match('/Dolphin(?:HDCN)?\/(?:INT|CN)?-?([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Dolphin';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;

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
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->browser->channel = '';

            if (!isset($this->data->os->name) && $match[1] == 'QQBrowser') {
                $this->data->os->name = 'Windows';
            }

            if (preg_match('/MQQBrowser\/[0-9\.]+\/Adr \(Linux; U; ([0-9\.]+); [^;]+; (.+) Build/u', $ua, $match)) {
                $this->data->os->reset([
                    'name'      => 'Android',
                    'version'   => new Version([ 'value' => $match[1] ])
                ]);

                $this->data->device->type = Constants\DeviceType::MOBILE;
                $this->data->device->model = $match[2];
                $this->data->device->identified |= Constants\Id::PATTERN;

                $device = Data\DeviceModels::identify('android', $match[2]);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            if (preg_match('/MQQBrowser\/[0-9\.]+\/WP7 \([^;]+;WPOS:([0-9]\.[0-9])[0-9\.]*;([^;]+); ([^\)]+)\)/u', $ua, $match)) {
                $this->data->os->reset([
                    'name'      => 'Windows Phone',
                    'version'   => new Version([ 'value' => $match[1] ])
                ]);

                $this->data->device->type = Constants\DeviceType::MOBILE;
                $this->data->device->manufacturer = $match[2];
                $this->data->device->model = $match[3];
                $this->data->device->identified |= Constants\Id::PATTERN;

                $device = Data\DeviceModels::identify('wp', $match[3]);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }
        }

        if (preg_match('/MQQBrowser\/Mini([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'QQ Browser Mini';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->browser->channel = '';
        }

        if (preg_match('/QQ\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'QQ Browser';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
            $this->data->browser->channel = '';
        }

        /* 360 Phone Browser */

        if (preg_match('/360 (?:Aphone|Android Phone) Browser \((?:Version |V)?([0-9.]*)(?:beta)?\)/u', $ua, $match)) {
            $this->data->browser->name = 'Qihoo 360 Browser';
            $this->data->browser->family = null;
            $this->data->browser->channel = '';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (!$this->data->os->isFamily('Android')) {
                $this->data->device->type = Constants\DeviceType::MOBILE;
                $this->data->os->reset([
                    'name' => 'Android'
                ]);
            }
        }

        if (preg_match('/360%20(?:Browser|Lite)\/([0-9\.]+)/u', $ua, $match)) {
            $this->data->browser->name = 'Qihoo 360 Browser';
            $this->data->browser->family = null;
            $this->data->browser->channel = '';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }

        if (preg_match('/QHBrowser\/([0-9\.]+)/u', $ua, $match)) {
            $version = $match[1];
            if (preg_match('/^[0-9][0-9][0-9]$/u', $version)) {
                $version = $version[0] . '.' . $version[1] . '.' . $version[2];
            }

            $this->data->browser->name = 'Qihoo 360 Browser';
            $this->data->browser->channel = '';
            $this->data->browser->version = new Version([ 'value' => $version ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (!$this->data->isOs('iOS')) {
                $this->data->device->type = Constants\DeviceType::MOBILE;
                $this->data->os->reset([
                    'name' => 'iOS'
                ]);
            }
        }

        /* Mercury */

        if (preg_match('/(?:^| )Mercury\/([0-9\.]+)/u', $ua, $match)) {
            $version = $match[1];
            if (preg_match('/^[0-9][0-9][0-9]$/u', $version)) {
                $version = $version[0] . '.' . $version[1] . '.' . $version[2];
            }

            $this->data->browser->name = 'Mercury Browser';
            $this->data->browser->channel = '';
            $this->data->browser->version = new Version([ 'value' => $version ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }

        /* iBrowser */

        if (preg_match('/(?:^| )iBrowser\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'iBrowser';

            $version = $match[1];
            if (preg_match('/^[0-9][0-9]$/u', $version)) {
                $version = $version[0] . '.' . $version[1];
            }

            $this->data->browser->version = new Version([ 'value' => $version, 'details' => 2 ]);
            $this->data->browser->channel = '';
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }

        if (preg_match('/iBrowser\/Mini([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'iBrowser Mini';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->channel = '';
            $this->data->browser->type = Constants\BrowserType::BROWSER;
        }

        /* Puffin */

        if (preg_match('/Puffin\/([0-9.]+)([IA])?([PT])?/u', $ua, $match)) {
            $this->data->browser->name = 'Puffin';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => (intval(substr(strrchr($match[1], '.'), 1)) > 99 ? -1 : null) ]);
            $this->data->browser->mode = 'proxy';
            $this->data->browser->channel = '';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (isset($match[2])) {
                switch ($match[2]) {
                    case 'A':
                        if (!$this->data->isOs('Android')) {
                            $this->data->os->reset([ 'name' => 'Android' ]);
                        }
                        break;

                    case 'I':
                        if (!$this->data->isOs('iOS')) {
                            $this->data->os->reset([ 'name' => 'iOS' ]);
                        }
                        break;
                }
            }

            if (isset($match[3])) {
                switch ($match[3]) {
                    case 'P':
                        $this->data->device->type = Constants\DeviceType::MOBILE;
                        if ($this->data->os->name == 'iOS' && empty($this->data->device->model)) {
                            $this->data->device->manufacturer = 'Apple';
                            $this->data->device->model = 'iPhone';
                            $this->data->device->identified = Constants\Id::MATCH_UA;
                        }
                        break;

                    case 'T':
                        $this->data->device->type = Constants\DeviceType::TABLET;
                        if ($this->data->os->name == 'iOS' && empty($this->data->device->model)) {
                            $this->data->device->manufacturer = 'Apple';
                            $this->data->device->model = 'iPad';
                            $this->data->device->identified = Constants\Id::MATCH_UA;
                        }
                        break;
                }
            }
        }

        /* Midori */

        if (preg_match('/Midori\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Midori';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;

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
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            $this->data->device->type = Constants\DeviceType::DESKTOP;

            if (preg_match('/midori\/([0-9.]*)$/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }
        }

        /* MiniBrowser Mobile */

        if (preg_match('/MiniBr?owserM(?:obile)?\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'MiniBrowser';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            $this->data->device->type = Constants\DeviceType::MOBILE;

            if (!$this->data->isOs('Series60')) {
                $this->data->os->name = 'Series60';
                $this->data->os->version = null;
            }
        }

        /* Maxthon */

        if (preg_match('/Maxthon/iu', $ua, $match)) {
            $this->data->browser->name = 'Maxthon';
            $this->data->browser->channel = '';
            $this->data->browser->version = null;
            $this->data->browser->type = Constants\BrowserType::BROWSER;

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
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/MxNitro\/([0-9.]*)/iu', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }
        }

        /* WebPositive */

        if (preg_match('/WebPositive/u', $ua, $match)) {
            $this->data->browser->name = 'WebPositive';
            $this->data->browser->channel = '';
            $this->data->browser->version = null;
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/WebPositive\/([0-9]\.[0-9.]+)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }
        }

        /* IBM WebExplorer */

        if (preg_match('/IBM[- ]WebExplorer[ -]?(DLL ?|Window API ?)?/u', $ua)) {
            $this->data->browser->name = 'IBM WebExplorer';
            $this->data->browser->channel = '';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/IBM[- ]WebExplorer[ -]?(?:DLL ?|Window API ?)?\/v([0-9]\.[0-9\.]+)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }

            $this->data->os->name = 'OS/2';
            $this->data->device->type = 'desktop';
        }

        /* WorldWideweb */

        if (preg_match('/WorldWideweb \(NEXT\)/u', $ua, $match)) {
            $this->data->browser->name = 'WorldWideWeb';
            $this->data->browser->channel = '';
            $this->data->browser->version = null;
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            $this->data->os->name = 'NextStep';
            $this->data->device->type = 'desktop';
        }

        /* Sogou Mobile */

        if (preg_match('/SogouAndroidBrowser\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Sogou Mobile';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (isset($this->data->device->manufacturer) && $this->data->device->manufacturer == 'Apple') {
                unset($this->data->device->manufacturer);
                unset($this->data->device->model);
                unset($this->data->device->identifier);
                $this->data->device->identified = Constants\Id::NONE;
            }
        }

        /* Xiino */

        if (preg_match('/Xiino\/([0-9.]+)/u', $ua, $match)) {
            $this->data->browser->name = 'Xiino';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            $this->data->device->type = Constants\DeviceType::PDA;

            $this->data->os->name = 'Palm OS';

            if (preg_match('/\(v. ([0-9.]+)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }
        }

        /* Palmscape */

        if (preg_match('/Palmscape\/(?:PR)?([0-9.]+)/u', $ua, $match)) {
            $this->data->browser->name = 'Palmscape';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            $this->data->device->type = Constants\DeviceType::PDA;

            $this->data->os->name = 'Palm OS';

            if (preg_match('/\(v. ([0-9.]+)/u', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }
        }

        /* Novarra WebPro */

        if (preg_match('/WebPro/u', $ua) && preg_match('/PalmOS/u', $ua)) {
            $this->data->browser->name = 'WebPro';
            $this->data->browser->version = null;
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/WebPro\/?([0-9.]*)/u', $ua, $match)) {
                $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            }
        }

        /* Novarra Vision */

        if (preg_match('/(?:Vision-Browser|Novarra-Vision)\/?([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Novarra Vision';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->family = null;
            $this->data->browser->mode = 'proxy';
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if ($this->data->device->type != Constants\DeviceType::MOBILE) {
                $this->data->os->reset();
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }
        }

        if (preg_match('/DreamKey\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Dreamkey';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            $this->data->device->setIdentification([
                'manufacturer'  =>  'Sega',
                'model'         =>  'Dreamcast',
                'type'          =>  Constants\DeviceType::GAMING,
                'subtype'       =>  Constants\DeviceSubType::CONSOLE
            ]);
        }

        if (preg_match('/DreamPassport\/([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Dream Passport';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            $this->data->device->setIdentification([
                'manufacturer'  =>  'Sega',
                'model'         =>  'Dreamcast',
                'type'          =>  Constants\DeviceType::GAMING,
                'subtype'       =>  Constants\DeviceSubType::CONSOLE
            ]);
        }

        if (preg_match('/Planetweb\/v?([0-9.]*)/u', $ua, $match)) {
            $this->data->browser->name = 'Planetweb';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::BROWSER;

            if (preg_match('/Dreamcast/u', $ua, $match)) {
                $this->data->device->setIdentification([
                    'manufacturer'  =>  'Sega',
                    'model'         =>  'Dreamcast',
                    'type'          =>  Constants\DeviceType::GAMING,
                    'subtype'       =>  Constants\DeviceSubType::CONSOLE
                ]);
            }

            if (preg_match('/SPS/u', $ua, $match)) {
                $this->data->device->setIdentification([
                    'manufacturer'  =>  'Sony',
                    'model'         =>  'Playstation 2',
                    'type'          =>  Constants\DeviceType::GAMING,
                    'subtype'       =>  Constants\DeviceSubType::CONSOLE
                ]);
            }
        }
    }

    private function detectRemainingBrowsers($ua)
    {
        $items = [

            Constants\BrowserType::BROWSER => [

                /* Desktop browsers */
                [ 'name' => '115 Browser',          'regexp' => '/115Browser\/([0-9.]*)/u' ],
                [ 'name' => '115 Chrome',           'regexp' => '/115Chrome\/([0-9.]*)/u' ],
                [ 'name' => '126 Browser',          'regexp' => '/126BROWSER/u' ],
                [ 'name' => '2345 Explorer',        'regexp' => '/2345Explorer\/([0-9.]*)/u', 'details' => 3 ],
                [ 'name' => '2345 Explorer',        'regexp' => '/2345Explorer v([0-9.]*)/u', 'details' => 3 ],
                [ 'name' => '2345 Chrome',          'regexp' => '/2345chrome v([0-9.]*)/u', 'details' => 3 ],
                [ 'name' => '360 Extreme Explorer', 'regexp' => '/QIHU 360EE/u', 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => '360 Safe Explorer',    'regexp' => '/QIHU 360SE/u', 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => '7Star',                'regexp' => '/7Star\/([0-9.]*)/u' ],                                                                // see: http://www.qixing123.com
                [ 'name' => 'ABrowse',              'regexp' => '/A[Bb]rowse ([0-9.]*)/u' ],                                                            // browser for the Syllable OS
                [ 'name' => 'Abrowser',             'regexp' => '/Abrowser\/([0-9.]*)/u' ],                                                             // unbranded version of Firefox
                [ 'name' => 'Acorn Browse',         'regexp' => '/Acorn Browse ([0-9.]+)/u'  ],
                [ 'name' => 'Acorn Browse',         'regexp' => '/Acorn Phoenix ([0-9.]+)/u'  ],
                [ 'name' => 'AOL Desktop',          'regexp' => '/AOL ([0-9.]*); AOLBuild/i' ],
                [ 'name' => 'AOL Browser',          'regexp' => '/America Online Browser (?:[0-9.]*); rev([0-9.]*);/i' ],
                [ 'name' => 'Arachne',              'regexp' => '/xChaos_Arachne\/[0-9]\.([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],       // see: www.glennmcc.org
                [ 'name' => 'Arora',                'regexp' => '/[Aa]rora\/([0-9.]*)/u' ],                                                             // see: www.arora-browser.org
                [ 'name' => 'AWeb',                 'regexp' => '/Amiga-AWeb(?:\/([0-9.]*))?/u' ],
                [ 'name' => 'AvantGo',              'regexp' => '/AvantGo ([0-9.]+)/u' ],
                [ 'name' => 'Avant Browser',        'regexp' => '/Avant Browser/u' ],
                [ 'name' => 'Avant Browser',        'regexp' => '/Avant TriCore/u' ],
                [ 'name' => 'Aviator',              'regexp' => '/Aviator\/([0-9.]*)/u', 'details' => 1 ],                                              // see: https://github.com/WhiteHatSecurity/Aviator
                [ 'name' => 'Baidu Browser',        'regexp' => '/bdbrowser\/([0-9.]*)/i' ],
                [ 'name' => 'Baidu Browser',        'regexp' => '/bdbrowser_i18n\/([0-9.]*)/i' ],
                [ 'name' => 'Baidu Spark',          'regexp' => '/BDSpark\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Beamrise',             'regexp' => '/Beamrise\/([0-9.]*)/u' ],                                                             // see: http://beamrise.com
                [ 'name' => 'Black Wren',           'regexp' => '/BlackWren\/([0-9.]*)/u', 'details' => 2 ],                                            // see: https://github.com/conmarap/jetbrowser
                [ 'name' => 'Brave',                'regexp' => '/brave\/([0-9.]*)/u' ],
                [ 'name' => 'Byffox',               'regexp' => '/Byffox\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Camino',               'regexp' => '/Camino\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Canure',               'regexp' => '/Canure\/([0-9.]*)/u', 'details' => 3 ],                                               // see: http://canure.weebly.com/index.html
                [ 'name' => 'Charon',               'regexp' => '/Charon/' ],                                                                           // see: http://www.vitanuova.com/inferno/man/1/charon.html
                [ 'name' => 'ChromePlus',           'regexp' => '/ChromePlus(?:\/([0-9.]*))?$/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'CometBird',            'regexp' => '/CometBird\/([0-9.]*)/u' ],                                                            // see: http://www.cometbird.com
                [ 'name' => 'Comodo Dragon',        'regexp' => '/Comodo_Dragon\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Comodo Dragon',        'regexp' => '/Dragon\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Comodo IceDragon',     'regexp' => '/IceDragon\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Conkeror',             'regexp' => '/[Cc]onkeror\/([0-9.]*)/u' ],
                [ 'name' => 'CoolNovo',             'regexp' => '/(?:CoolNovo|CoolNovoChromePlus)\/([0-9.]*)/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Cunaguaro',            'regexp' => '/Cunaguaro\/([0-9.]*)/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Cyberfox',             'regexp' => '/Cyberfox\/([0-9.]*)/u', 'details' => 2 ],                                             // see: https://cyberfox.8pecxstudios.com
                [ 'name' => 'Daedalus',             'regexp' => '/Daedalus ([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Dillo',                'regexp' => '/Dillo\/([0-9.]*)/u' ],                                                                // see: http://www.dillo.org
                [ 'name' => 'Doga Rhodonit',        'regexp' => '/DogaRhodonit/u' ],
                [ 'name' => 'EudoraWeb',            'regexp' => '/EudoraWeb ([0-9.]*)/u' ],
                [ 'name' => 'Flock',                'regexp' => '/Flock\/([0-9.]*)/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Galeon',               'regexp' => '/Galeon\/([0-9.]*)/u', 'details' => 3 ],
                [ 'name' => 'GNOME Web',            'regexp' => '/Epiphany\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'IBrowse',              'regexp' => '/IBrowse[\/ ]([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'iCab',                 'regexp' => '/iCab(?: J)?\/([0-9.]*)/u' ],
                [ 'name' => 'Iceape',               'regexp' => '/Iceape\/([0-9.]*)/u' ],
                [ 'name' => 'IceCat',               'regexp' => '/IceCat[ \/]([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                   // see: https://www.gnu.org/software/gnuzilla/
                [ 'name' => 'Iceweasel',            'regexp' => '/Iceweasel\/([0-9.]*)/iu', 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Iridium',              'regexp' => '/Iridium\/([0-9.]*)/u', 'details' => 2 ],                                                 // see: http://www.srware.net/en/software_srware_iron.php
                [ 'name' => 'Iron',                 'regexp' => '/Iron\/([0-9.]*)/u', 'details' => 2 ],                                                 // see: http://www.srware.net/en/software_srware_iron.php
                [ 'name' => 'Kazehakase',           'regexp' => '/Kazehakase\/([0-9.]*)/u' ],                                                           // see: http://kazehakase.osdn.jp
                [ 'name' => 'KChrome',              'regexp' => '/KChrome\/([0-9.]*)/u', 'details' => 3 ],                                              // see: http://www.kchrome.com
                [ 'name' => 'K-Meleon',             'regexp' => '/K-Meleon\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                    // see: http://kmeleonbrowser.org
                [ 'name' => 'LieBao',               'regexp' => '/LBBROWSER/u' ],                                                                       // see: http://www.liebao.cn
                [ 'name' => 'Lobo',                 'regexp' => '/Lobo\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                        // see: http://sourceforge.net/projects/xamj/files/Lobo%20Browser/
                [ 'name' => 'Lunascape',            'regexp' => '/Lunascape[\/| ]([0-9.]*)/u', 'details' => 3 ],                                        // see: http://www.lunascape.tv
                [ 'name' => 'Naenara',              'regexp' => '/NaenaraBrowser\/([0-9.]*)/u', 'details' => 2 ],                                       // Firefox based browser used with Red Star OS
                [ 'name' => 'Maxthon',              'regexp' => '/MxBrowser\/([0-9.]*)/u' ],
                [ 'name' => 'Maxthon',              'regexp' => '/MxBrowser-iPhone\/([0-9.]*)/u' ],
                [ 'name' => 'MixShark',             'regexp' => '/MixShark\/([0-9.]*)/u' ],                                                             // see: http://terbaddo.free.fr/mixshark.php
                [ 'name' => 'mlbrowser',            'regexp' => '/mlbrowser/u' ],                                                                       // see: https://github.com/Topguy/mlbrowser
                [ 'name' => 'NetPositive',          'regexp' => '/NetPositive\/([0-9.]*)/u' ],
                [ 'name' => 'Odyssey',              'regexp' => '/OWB\/([0-9.]*)/u' ],
                [ 'name' => 'OmniWeb',              'regexp' => '/OmniWeb/u', 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Orca',                 'regexp' => '/Orca\/([0-9.]*)/u' ],
                [ 'name' => 'Oregano',              'regexp' => '/Oregano ([0-9.]*)/u' ],                                                               // see: http://www.xat.nl/en/riscos/sw/oregano/
                [ 'name' => 'Origyn',               'regexp' => '/Origyn Web Browser/u' ],
                [ 'name' => 'Otter',                'regexp' => '/Otter(?: Browser)?\/([0-9.]*)/u' ],                                                   // see: https://otter-browser.org
                [ 'name' => 'Pale Moon',            'regexp' => '/Pale[mM]oon\/([0-9.]*)/u' ],                                                          // see: https://www.palemoon.org
                [ 'name' => 'Qihoo 360',            'regexp' => '/QIHU THEWORLD/u' ],
                [ 'name' => 'QtWeb',                'regexp' => '/QtWeb Internet Browser\/([0-9.]*)/u' ],
                [ 'name' => 'QupZilla',             'regexp' => '/QupZilla\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'rekonq',               'regexp' => '/rekonq(?:\/([0-9.]*))?/u', 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Ryouko',               'regexp' => '/Ryouko\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                      // see: https://github.com/foxhead128/ryouko
                [ 'name' => 'SaaYaa Explorer',      'regexp' => '/SaaYaa/u', 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Sleipnir',             'regexp' => '/Sleipnir\/([0-9.]*)/u', 'details' => 3 ],
                [ 'name' => 'Sogou Explorer',       'regexp' => '/SE 2.X MetaSr/u', 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Stainless',            'regexp' => '/Stainless\/([0-9.]*)/u' ],                                                            // see: http://www.stainlessapp.com
                [ 'name' => 'SunChrome',            'regexp' => '/SunChrome\/([0-9.]*)/u' ],
                [ 'name' => 'Superbird',            'regexp' => '/Super[Bb]ird\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Swing Browser',        'regexp' => '/Swing(?:\(And\))?\/([0-9.]*)/u', 'details' => 3 ],                                    // see: http://swing-browser.com
                [ 'name' => 'Tencent Traveler',     'regexp' => '/TencentTraveler ([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'TenFourFox',           'regexp' => '/TenFourFox\//u' ],
                [ 'name' => 'The World',            'regexp' => '/TheWorld(?: ([0-9.]*))?/u' ],
                [ 'name' => 'Tungsten Browser',     'regexp' => '/TungstenBrowser\/([0-9.]*)/u' ],
                [ 'name' => 'Vivaldi',              'regexp' => '/Vivaldi\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Voyager',              'regexp' => '/AmigaVoyager\/([0-9.]*)/u' ],
                [ 'name' => 'Waterfox',             'regexp' => '/Waterfox\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Yandex Browser',       'regexp' => '/YaBrowser\/([0-9.]*)/u', 'details' => 2 ],

                /* Mobile browsers */
                [ 'name' => '1Browser',             'regexp' => '/1Password\/([0-9.]*)/u' ],
                [ 'name' => '2345 Browser',         'regexp' => '/Mb2345Browser\/([0-9.]*)/u' ],
                [ 'name' => '3G Explorer',          'regexp' => '/3G Explorer\/([0-9.]*)/u', 'details' => 3 ],
                [ 'name' => '4G Explorer',          'regexp' => '/4G Explorer\/([0-9.]*)/u', 'details' => 3 ],
                [ 'name' => 'Atomic',               'regexp' => '/AtomicLite\/([0-9.]*)/u' ],                                                           // see: http://atomicwebbrowser.com
                [ 'name' => 'AU',                   'regexp' => '/(?:^| )AU(?:.Browser)?\/([0-9.]+)/u' ],
                [ 'name' => 'Awakening',            'regexp' => '/Awakening Browser\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Baidu Browser',        'regexp' => '/M?BaiduBrowser\/([0-9.]*)/i' ],
                [ 'name' => 'Baidu Browser',        'regexp' => '/BdMobile\/([0-9.]*)/i' ],
                [ 'name' => 'Baidu Browser',        'regexp' => '/FlyFlow\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Baidu Browser',        'regexp' => '/BIDUBrowser[ \/]([0-9.]*)/u' ],
                [ 'name' => 'Baidu Browser',        'regexp' => '/BaiduHD\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
                [ 'name' => 'Blazer',               'regexp' => '/Blazer\/([0-9.]*)/u' ],
                [ 'name' => 'Cornowser',            'regexp' => '/Cornowser\/([0-9.]*)/u' ],
                [ 'name' => 'CuteBrowser',          'regexp' => '/CuteBrowser\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Digia @Web',           'regexp' => '/Digia @Web\/([0-9.]*)/u' ],
                [ 'name' => 'Dorado',               'regexp' => '/Browser\/Dorado([0-9.]*)/u' ],
                [ 'name' => 'Dorothy',              'regexp' => '/Dorothy$/u' ],
                [ 'name' => 'EMOBILE Browser',      'regexp' => '/WWW Browser\/ver([0-9.]*)/u' ],
                [ 'name' => 'Go.Web',               'regexp' => '/Go\.Web\/([0-9.]*)/u' ],                                                              // used on early Blackberry, by GoAmerica
                [ 'name' => 'Helium',               'regexp' => '/HeliumMobileBrowser\/([0-9.]*)/u' ],
                [ 'name' => 'iCab',                 'regexp' => '/iCabMobile\/([0-9.]*)/u' ],
                [ 'name' => 'iLunascape',           'regexp' => '/iLunascape\/([0-9.]*)/u', 'details' => 3 ],                                           // see: http://www.lunascape.tv
                [ 'name' => 'InternetSurfboard',    'regexp' => '/InternetSurfboard\/([0-9.]*)/u' ],
                [ 'name' => 'iSurf',                'regexp' => '/iSurf version \/v([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Jig Browser',          'regexp' => '/jig browser(?: web| core|9i?)?;? ?([0-9.]+)?/u', 'type' => Constants\DeviceType::MOBILE ],
                [ 'name' => 'Jumanji',              'regexp' => '/jumanji/u' ],                                                                         // see: jumanji browser ubuntu
                [ 'name' => 'Kiosk',                'regexp' => '/Kiosk\/([0-9.]*)/u' ],                                                                // see: http://www.kioskbrowser.net
                [ 'name' => 'LieBaoFast',           'regexp' => '/LieBaoFast\/([0-9.]*)/u' ],                                                           // see: http://www.liebao.cn
                [ 'name' => 'MaCross Mobile',       'regexp' => '/MaCross\/([0-9.]*)/u' ],
                [ 'name' => 'Mammoth',              'regexp' => '/Mammoth\/([0-9.]*)/u' ],                                                              // see: https://itunes.apple.com/cn/app/meng-ma-liu-lan-qi/id403760998?mt=8
                [ 'name' => 'Motorola Internet Browser', 'regexp' => '/MIB\/([0-9.]*)/u' ],
                [ 'name' => 'Motorola Internet Browser', 'regexp' => '/MIB([0-9.]+)\//u' ],
                [ 'name' => 'Motorola Internet Browser', 'regexp' => '/Browser\/CMCS([0-9.]*)/u' ],
                [ 'name' => 'Motorola WebKit',      'regexp' => '/MotorolaWebKit(?:\/([0-9.]*))?/u', 'details' => 3 ],
                [ 'name' => 'MIUI Browser',         'regexp' => '/MiuiBrowser\/([0-9.]*)/u' ],
                [ 'name' => 'NetFront Life Browser', 'regexp' => '/NetFrontLifeBrowser\/([0-9.]*)/u' ],
                [ 'name' => 'OneBrowser',           'regexp' => '/OneBrowser\/([0-9.]*)/u' ],
                [ 'name' => 'Openwave',             'regexp' => '/Browser\/OpenWave([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
                [ 'name' => 'Openwave',             'regexp' => '/Open[Ww]ave\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
                [ 'name' => 'Openwave',             'regexp' => '/Openwave Mobile Browser ([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
                [ 'name' => 'Openwave',             'regexp' => '/UP\. ?Browser(?:\/([a-z0-9.]*))?/iu', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
                [ 'name' => 'Openwave',             'regexp' => '/KM\.Browser\/([0-9.]+)/iu', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
                [ 'name' => 'Openwave',             'regexp' => '/UP\/([0-9.]+)/u', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
                [ 'name' => 'Polaris',              'regexp' => '/Polaris[\/ ]v?([0-9.]*)/iu', 'details' => 2 ],
                [ 'name' => 'Polaris',              'regexp' => '/POLARIS([0-9.]+)/u', 'details' => 2 ],
                [ 'name' => 'SEMC Browser',         'regexp' => '/SEMC-Browser\/([0-9.]*)/u' ],
                [ 'name' => 'Sogou Mobile',         'regexp' => '/SogouMobileBrowser\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Swing Browser',        'regexp' => '/Swing\(And\)\/([0-9.]*)/u', 'details' => 3 ],
                [ 'name' => 'Symphony',             'regexp' => '/Symphony ([0-9.]+)$/u' ],
                [ 'name' => 'WebLite',              'regexp' => '/WebLite\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],

                /* Television browsers */
                [ 'name' => 'AltiBrowser',          'regexp' => '/AltiBrowser\/([0-9.]*)/i' ],
                [ 'name' => 'Aplix',                'regexp' => '/Aplix_SANYO_browser\/([0-9](?:.[0-9.]+)?)/u' ],                                    // browser for the Sega Saturn
                [ 'name' => 'AwoX',                 'regexp' => '/AwoX(?:\/([0-9.]*))? Browser/i' ],
                [ 'name' => 'Isis',                 'regexp' => '/BrowserServer/u' ],
                [ 'name' => 'Isis',                 'regexp' => '/ISIS\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Spyglass',             'regexp' => '/Spyglass ([0-9.]+); OpenTV/u' ],
                [ 'name' => 'Oregan Browser',       'regexp' => '/OreganMediaBrowser(?:\/([0-9.]*))?/u', 'details' => 2 ],
                [ 'name' => 'Viera Browser',        'regexp' => '/Viera\/([0-9.]*)/u' ],
                [ 'name' => 'Zetakey',              'regexp' => '/Zetakey Webkit\/([0-9.]*)/u' ],
                [ 'name' => 'Zetakey',              'regexp' => '/Zetakey\/([0-9.]*)/u' ],

                /* Gaming browsers */
                [ 'name' => 'Aplix',                'regexp' => '/Aplix_SEGASATURN_browser\/([0-9](?:.[0-9.]+)?)/u' ],                                    // browser for the Sega Saturn
                [ 'name' => 'Bunjalloo',            'regexp' => '/Bunjalloo\/([0-9.]*)/u' ],                                                            // browser for the Nintento DS
                [ 'name' => 'Nintendo Web Framework', 'regexp' => '/NWF\/([0-9.]*)/u', 'details' => 2 ],                                                        // browser for the Sega Dreamcast
                [ 'name' => 'Nuanti Meta',          'regexp' => '/Nuanti(?:Meta)?\/([0-9.]*)/u' ],                                                      // browser for the Playstation

                /* Other browsers */
                [ 'name' => 'Wear Internet Browser','regexp' => '/WIB\/([0-9.]*)/u' ],

                /* Unsorted */
                [ 'name' => 'Demobrowser',          'regexp' => '/demobrowser\/([0-9.]*)/u' ],
                [ 'name' => 'Dooble',               'regexp' => '/Dooble(?:\/([0-9.]*))?/u' ],                                                          // see: http://dooble.sourceforge.net
                [ 'name' => 'DWB',                  'regexp' => '/dwb(?:-hg)?(?:\/([0-9.]*))?/u' ],
                [ 'name' => 'EVM Browser',          'regexp' => '/EVMBrowser\/([0-9.]*)/u' ],
                [ 'name' => 'FireWeb',              'regexp' => '/FireWeb\/([0-9.]*)/u' ],
                [ 'name' => 'Hive Explorer',        'regexp' => '/HiveE/u' ],
                [ 'name' => 'Intermec Browser',     'regexp' => '/Intermec\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Phantom',              'regexp' => '/Phantom\/V([0-9.]*)/u' ],
                [ 'name' => 'QtCreator',            'regexp' => '/QtCreator\/([0-9.]*)/u' ],
                [ 'name' => 'QtQmlViewer',          'regexp' => '/QtQmlViewer/u' ],
                [ 'name' => 'QtMiniBrowser',        'regexp' => '/QtMiniBrowser\/([0-9.]*)/u' ],
                [ 'name' => 'QtTestBrowser',        'regexp' => '/QtTestBrowser\/([0-9.]*)/u' ],
                [ 'name' => 'Roccat',               'regexp' => '/Roccat\/([0-9]\.[0-9.]*)/u' ],
                [ 'name' => 'Raven for Mac',        'regexp' => '/Raven for Mac\/([0-9.]*)/u' ],
                [ 'name' => 'RockMelt',             'regexp' => '/RockMelt\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Scope',                'regexp' => '/Scope\/([0-9.]*)/u', 'details' => 2 ],                                                // see: http://www.programmer.co.jp/scope.shtml
                [ 'name' => 'SlimBoat',             'regexp' => '/SlimBoat\/([0-9.]*)/u' ],
                [ 'name' => 'SlimBrowser',          'regexp' => '/SlimBrowser(?:\/([0-9.]*))?/u' ],
                [ 'name' => 'SMBrowser',            'regexp' => '/SMBrowser/u' ],
                [ 'name' => 'Snowshoe',             'regexp' => '/Snowshoe\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Sputnik',              'regexp' => '/Sputnik\/([0-9.]*)/iu', 'details' => 3 ],
                [ 'name' => 'Surf',                 'regexp' => '/Surf\/([0-9.]*)/u' ],
                [ 'name' => 'TaoBrowser',           'regexp' => '/TaoBrowser\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'TaomeeBrowser',        'regexp' => '/TaomeeBrowser\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'TazWeb',               'regexp' => '/TazWeb/u' ],
                [ 'name' => 'Uzbl',                 'regexp' => '/^Uzbl/u' ],
                [ 'name' => 'Villanova',            'regexp' => '/Villanova\/([0-9.]*)/u', 'details' => 3 ],
                [ 'name' => 'Vimb',                 'regexp' => '/vimb\/([0-9.]*)/u' ],
                [ 'name' => 'WADA Browser',         'regexp' => '/WadaBrowser\/([0-9.]*)/u' ],
                [ 'name' => 'Wavelink Velocity',    'regexp' => '/Wavelink Velocity Browser\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'WebRender',            'regexp' => '/WebRender/u' ],
                [ 'name' => 'Webster',              'regexp' => '/Webster ([0-9.]*)/u' ],
                [ 'name' => 'Wyzo',                 'regexp' => '/Wyzo\/([0-9.]*)/u', 'details' => 3 ],
                [ 'name' => 'Yelang',               'regexp' => '/Yelang\/([0-9.]*)/u', 'details' => 3 ],                           // see: wellgo.org
                [ 'name' => 'YRC Weblink',          'regexp' => '/YRCWeblink\/([0-9.]*)/u' ],
                [ 'name' => '冲浪浏览器',             'regexp' => '/CMSurfClient-Android/u' ],
            ],

            Constants\BrowserType::BROWSER_TEXT => [
                [ 'name' => 'CERN LineMode',        'regexp' => '/CERN-LineMode\/([0-9.]*)/u' ],
                [ 'name' => 'Lynx',                 'regexp' => '/Lynx\/([0-9.]*)/u' ],
                [ 'name' => 'Links',                'regexp' => '/Links \(([0-9.]*)/u' ],
                [ 'name' => 'ELinks',               'regexp' => '/E[Ll]inks(?:\/| \()([0-9.]*[0-9])/u', 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'w3m',                  'regexp' => '/w3m\/([0-9.]*)/u' ],
            ],

            Constants\BrowserType::UNKNOWN => [
                [ 'name' => 'PhantomJS',            'regexp' => '/PhantomJS\/([0-9.]*)/u' ],
                [ 'name' => 'Nimbus',               'regexp' => '/Nimbus\/([0-9.]*)/u' ],
                [ 'name' => 'McAfee Web Gateway',   'regexp' => '/Webwasher\/([0-9.]*)/u' ],
                [ 'name' => 'Open Sankoré',         'regexp' => '/Open-Sankore\/([0-9.]*)/u', 'type' => Constants\DeviceType::WHITEBOARD ],
                [ 'name' => 'Adapi',                'regexp' => '/ ADAPI\/([0-9.]*)/u', 'hidden' => true, 'type' => Constants\DeviceType::SIGNAGE ],
                [ 'name' => 'BrightSign',           'regexp' => '/BrightSign\/([0-9.]*)/u', 'type' => Constants\DeviceType::SIGNAGE ],
                [ 'name' => 'Coship MMCP',          'regexp' => '/Coship_MMCP_([0-9.]*)/u', 'type' => Constants\DeviceType::SIGNAGE ],
            ]
        ];


        foreach ($items as $type => $browsers) {
            $count = count($browsers);
            for ($b = 0; $b < $count; $b++) {
                if (preg_match($browsers[$b]['regexp'], $ua, $match)) {
                    $this->data->browser->name = $browsers[$b]['name'];
                    $this->data->browser->channel = '';
                    $this->data->browser->hidden = isset($browsers[$b]['hidden']) ? $browsers[$b]['hidden'] : false;
                    $this->data->browser->stock = false;
                    $this->data->browser->type = $type;

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
}
