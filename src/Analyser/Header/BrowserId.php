<?php

namespace WhichBrowser\Analyser\Header;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Using;
use WhichBrowser\Model\Version;

class BrowserId
{
    public function __construct($header, &$data)
    {
        $this->data =& $data;

        /* The X-Requested-With header is send by the WebView, so our browser name is Chrome it is probably the Chromium WebView which is sometimes misidentified. */

        if (isset($this->data->browser->name) && $this->data->browser->name == 'Chrome') {
            $version = $this->data->browser->getVersion();

            $this->data->browser->reset();
            $this->data->browser->using = new Using([ 'name' => 'Chromium WebView', 'version' => new Version([ 'value' => explode('.', $version)[0] ]) ]);
        }

        /* Detect the correct browser based on the header */

        $browser = Data\BrowserIds::identify($header);
        if ($browser) {
            if (!isset($this->data->browser->name)) {
                $this->data->browser->name = $browser;
            } else {
                if (substr($this->data->browser->name, 0, strlen($browser)) != $browser) {
                    $this->data->browser->name = $browser;
                    $this->data->browser->version = null;
                    $this->data->browser->stock = false;
                } else {
                    $this->data->browser->name = $browser;
                }
            }
        }

        /* The X-Requested-With header is only send from Android devices */

        if (!isset($this->data->os->name) || ($this->data->os->name != 'Android' && (!isset($this->data->os->family) || $this->data->os->family->getName() != 'Android'))) {
            $this->data->os->name = 'Android';
            $this->data->os->alias = null;
            $this->data->os->version = null;

            $this->data->device->manufacturer = null;
            $this->data->device->model = null;
            $this->data->device->identified = Constants\Id::NONE;

            if ($this->data->device->type != Constants\DeviceType::MOBILE && $this->data->device->type != Constants\DeviceType::TABLET) {
                $this->data->device->type = Constants\DeviceType::MOBILE;
            }
        }

        /* The X-Requested-With header is send by the WebKit or Chromium Webview */
        
        if (!isset($this->data->engine->name) || ($this->data->engine->name != 'Webkit' && $this->data->engine->name != 'Blink')) {
            $this->data->engine->name = 'Webkit';
            $this->data->engine->version = null;
        }
    }
}
