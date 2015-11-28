<?php

namespace WhichBrowser\Analyser\Header\Useragent;

use WhichBrowser\Constants;
use WhichBrowser\Model\Version;

trait Engine
{
    private function detectEngineFromUseragent($ua)
    {
        $this->detectWebkitFromUseragent($ua);
        $this->detectKHTMLFromUseragent($ua);
        $this->detectGeckoFromUseragent($ua);
        $this->detectPrestoFromUseragent($ua);
        $this->detectTridentFromUseragent($ua);
        $this->detectEdgeHTMLUseragent($ua);
    }




    /* WebKit */

    private function detectWebkitFromUseragent($ua)
    {
        if (preg_match('/WebKit\/([0-9.]*)/iu', $ua, $match)) {
            $this->engine->name = 'Webkit';
            $this->engine->version = new Version([ 'value' => $match[1] ]);

            if (preg_match('/(?:Chrome|Chromium)\/([0-9]*)/u', $ua, $match)) {
                if (intval($match[1]) >= 27) {
                    $this->engine->name = 'Blink';
                }
            }
        }

        if (preg_match('/Browser\/AppleWebKit\/?([0-9.]*)/iu', $ua, $match)) {
            $this->engine->name = 'Webkit';
            $this->engine->version = new Version([ 'value' => $match[1] ]);
        }

        if (preg_match('/AppleWebkit\(like Gecko\)/iu', $ua, $match)) {
            $this->engine->name = 'Webkit';
        }
    }


    /* KHTML */

    private function detectKHTMLFromUseragent($ua)
    {
        if (preg_match('/KHTML\/([0-9.]*)/u', $ua, $match)) {
            $this->engine->name = 'KHTML';
            $this->engine->version = new Version([ 'value' => $match[1] ]);
        }
    }


    /* Gecko */

    private function detectGeckoFromUseragent($ua)
    {
        if (preg_match('/Gecko/u', $ua) && !preg_match('/like Gecko/iu', $ua)) {
            $this->engine->name = 'Gecko';

            if (preg_match('/; rv:([^\);]+)[\);]/u', $ua, $match)) {
                $this->engine->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            }
        }
    }


    /* Presto */

    private function detectPrestoFromUseragent($ua)
    {
        if (preg_match('/Presto\/([0-9.]*)/u', $ua, $match)) {
            $this->engine->name = 'Presto';
            $this->engine->version = new Version([ 'value' => $match[1] ]);
        }
    }


    /* Trident */

    private function detectTridentFromUseragent($ua)
    {
        if (preg_match('/Trident\/([0-9.]*)/u', $ua, $match)) {
            $this->engine->name = 'Trident';
            $this->engine->version = new Version([ 'value' => $match[1] ]);


            if (isset($this->browser->version) && isset($this->browser->name) && $this->browser->name == 'Internet Explorer') {
                if ($this->engine->version->toNumber() == 7 && $this->browser->version->toFloat() < 11) {
                    $this->browser->version = new Version([ 'value' => '11.0' ]);
                    $this->browser->mode = 'compat';
                }

                if ($this->engine->version->toNumber() == 6 && $this->browser->version->toFloat() < 10) {
                    $this->browser->version = new Version([ 'value' => '10.0' ]);
                    $this->browser->mode = 'compat';
                }

                if ($this->engine->version->toNumber() == 5 && $this->browser->version->toFloat() < 9) {
                    $this->browser->version = new Version([ 'value' => '9.0' ]);
                    $this->browser->mode = 'compat';
                }

                if ($this->engine->version->toNumber() == 4 && $this->browser->version->toFloat() < 8) {
                    $this->browser->version = new Version([ 'value' => '8.0' ]);
                    $this->browser->mode = 'compat';
                }
            }

            if (isset($this->os->version) && isset($this->os->name) && $this->os->name == 'Windows Phone' && isset($this->browser->name) && $this->browser->name == 'Mobile Internet Explorer') {
                if ($this->engine->version->toNumber() == 7 && $this->os->version->toFloat() < 8.1) {
                    $this->os->version = new Version([ 'value' => '8.1' ]);
                }

                if ($this->engine->version->toNumber() == 6 && $this->os->version->toFloat() < 8) {
                    $this->os->version = new Version([ 'value' => '8.0' ]);
                }

                if ($this->engine->version->toNumber() == 5 && $this->os->version->toFloat() < 7.5) {
                    $this->os->version = new Version([ 'value' => '7.5' ]);
                }
            }
        }
    }


    /* EdgeHTML */

    private function detectEdgeHTMLUseragent($ua)
    {
        if (preg_match('/Edge\/([0-9.]*)/u', $ua, $match)) {
            $this->engine->name = 'EdgeHTML';
            $this->engine->version = new Version([ 'value' => $match[1], 'details' => 1 ]);
        }
    }
}
