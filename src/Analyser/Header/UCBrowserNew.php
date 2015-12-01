<?php

namespace WhichBrowser\Analyser\Header;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

class UCBrowserNew
{
    public function __construct($header, &$data)
    {
        $this->data =& $data;

        if (preg_match('/pr\(UCBrowser\/([0-9\.]+)/u', $header, $match)) {
            $this->data->browser->name = 'UC Browser';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->stock = false;
        }

        /* Find os */
        if (preg_match('/ov\(Android ([0-9\.]+)/u', $header, $match)) {
            $this->data->os->name = 'Android';
            $this->data->os->version = new Version([ 'value' => $match[1] ]);
        }

        if (preg_match('/pf\(Symbian\)/u', $header) && preg_match('/ov\(S60V5/u', $header)) {
            if (!isset($this->data->os->name) || $this->data->os->name != 'Series60') {
                $this->data->os->name = 'Series60';
                $this->data->os->version = new Version([ 'value' => 5 ]);
            }
        }

        if (preg_match('/pf\(Windows\)/u', $header) && preg_match('/ov\(wds ([0-9\.]+)/u', $header, $match)) {
            if (!isset($this->data->os->name) || $this->data->os->name != 'Windows Phone') {
                $this->data->os->name = 'Windows Phone';

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
        }

        if (preg_match('/pf\((?:42|44)\)/u', $header) && preg_match('/ov\((?:iPh OS )?(?:iOS )?([0-9\_]+)/u', $header, $match)) {
            if (!isset($this->data->os->name) || $this->data->os->name != 'iOS') {
                $this->data->os->name = 'iOS';
                $this->data->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
            }
        }

        /* Find engine */
        if (preg_match('/re\(AppleWebKit\/([0-9\.]+)/u', $header, $match)) {
            $this->data->engine->name = 'Webkit';
            $this->data->engine->version = new Version([ 'value' => $match[1] ]);
        }

        /* Find device */
        if (isset($this->data->os->name) && $this->data->os->name == 'Android') {
            if (preg_match('/dv\((.*)\)/uU', $header, $match)) {
                $match[1] = preg_replace("/\s+Build/u", '', $match[1]);
                $device = Data\DeviceModels::identify('android', $match[1]);

                if ($device) {
                    $this->data->device = $device;
                }
            }
        }

        if (isset($this->data->os->name) && $this->data->os->name == 'Series60') {
            if (preg_match('/dv\((?:Nokia)?([^\)]*)\)/u', $header, $match)) {
                $device = Data\DeviceModels::identify('s60', $match[1]);

                if ($device) {
                    $this->data->device = $device;
                }
            }
        }

        if (isset($this->data->os->name) && $this->data->os->name == 'Windows Phone') {
            if (preg_match('/dv\(([^\)]*)\)/u', $header, $match)) {
                $device = Data\DeviceModels::identify('wp', substr(strstr($match[1], ' '), 1));

                if ($device) {
                    $this->data->device = $device;
                }
            }
        }

        if (isset($this->data->os->name) && $this->data->os->name == 'iOS') {
            if (preg_match('/dv\(([^\)]*)\)/u', $header, $match)) {
                $device = Data\DeviceModels::identify('ios', $match[1]);

                if ($device) {
                    $this->data->device = $device;
                }
            }
        }
    }
}
