<?php

namespace WhichBrowser\Analyser;

use WhichBrowser\Constants;

trait Camouflage
{
    private function &detectCamouflage()
    {
        if (isset($this->options->useragent) && $this->options->useragent != '') {
            if ($this->options->useragent == 'Mozilla/5.0 (X11; U; Linux i686; zh-CN; rv:1.2.3.4) Gecko/') {

                if ($this->data->browser->name != 'UC Browser') {
                    $this->data->browser->name = 'UC Browser';
                    $this->data->browser->version = null;
                    $this->data->browser->stock = false;
                }

                if ($this->data->os->name == 'Windows') {
                    $this->data->os->name = '';
                    $this->data->os->version = null;
                }

                $this->data->engine->name = 'Gecko';
                $this->data->engine->version = null;

                $this->data->device->type = 'mobile';
            }


            if (preg_match('/Mac OS X 10_6_3; ([^;]+); [a-z]{2}-(?:[a-z]{2})?\)/u', $this->options->useragent, $match)) {
                $this->data->browser->name = '';
                $this->data->browser->version = null;
                $this->data->browser->mode = 'desktop';

                $this->data->os->name = 'Android';
                $this->data->os->alias = null;
                $this->data->os->version = null;

                $this->data->engine->name = 'Webkit';
                $this->data->engine->version = null;

                $this->features[] = 'foundDevice';
            }

            if (preg_match('/Linux Ventana; [a-z]{2}-[a-z]{2}; (.+) Build/u', $this->options->useragent, $match)) {
                $this->data->browser->name = '';
                $this->data->browser->version = null;
                $this->data->browser->mode = 'desktop';

                $this->data->os->name = 'Android';
                $this->data->os->version = null;

                $this->data->engine->name = 'Webkit';
                $this->data->engine->version = null;

                $this->features[] = 'foundDevice';
            }

            if (isset($this->data->browser->name) && $this->data->browser->name == 'Safari') {
                preg_match('/AppleWebKit\/([0-9]+.[0-9]+)/iu', $this->options->useragent, $webkitMatch);
                preg_match('/Safari\/([0-9]+.[0-9]+)/iu', $this->options->useragent, $safariMatch);

                if ($this->data->os->name != 'iOS' && $webkitMatch[1] != $safariMatch[1]) {
                    $this->features[] = 'safariMismatch';
                    $this->camouflage = true;
                }

                if ($this->data->os->name == 'iOS' && !preg_match('/^Mozilla/u', $this->options->useragent)) {
                    $this->features[] = 'noMozillaPrefix';
                    $this->camouflage = true;
                }

                if (!preg_match('/Version\/[0-9\.]+/u', $this->options->useragent)) {
                    $this->features[] = 'noVersion';
                    $this->camouflage = true;
                }
            }

            if (isset($this->data->browser->name) && $this->data->browser->name == 'Chrome') {
                if (!preg_match('/(?:Chrome|CrMo|CriOS)\/([0-9]{1,2}\.[0-9]\.[0-9]{3,4}\.[0-9]+)/u', $this->options->useragent)) {
                    $this->features[] = 'wrongVersion';
                    $this->camouflage = true;
                }
            }
        }

        if (isset($this->options->engine)) {
            if (isset($this->data->engine->name) && $this->data->browser->mode != 'proxy') {

                /* If it claims not to be Trident, but it is probably Trident running camouflage mode */
                if ($this->options->engine & Constants\EngineType::TRIDENT) {
                    $this->features[] = 'trident';

                    if ($this->data->engine->name && $this->data->engine->name != 'Trident') {
                        $this->camouflage = !isset($this->data->browser->name) || ($this->data->browser->name != 'Maxthon' && $this->data->browser->name != 'Motorola WebKit');
                    }
                }

                /* If it claims not to be Opera, but it is probably Opera running camouflage mode */
                if ($this->options->engine & Constants\EngineType::PRESTO) {
                    $this->features[] = 'presto';

                    if ($this->data->engine->name && $this->data->engine->name != 'Presto') {
                        $this->camouflage = true;
                    }

                    if (isset($this->data->browser->name) && $this->data->browser->name == 'Internet Explorer') {
                        $this->camouflage = true;
                    }
                }

                /* If it claims not to be Gecko, but it is probably Gecko running camouflage mode */
                if ($this->options->engine & Constants\EngineType::GECKO) {
                    $this->features[] = 'gecko';

                    if ($this->data->engine->name && $this->data->engine->name != 'Gecko') {
                        $this->camouflage = true;
                    }

                    if (isset($this->data->browser->name) && $this->data->browser->name == 'Internet Explorer') {
                        $this->camouflage = true;
                    }
                }

                /* If it claims not to be Webkit, but it is probably Webkit running camouflage mode */
                if ($this->options->engine & Constants\EngineType::WEBKIT) {
                    $this->features[] = 'webkit';

                    if ($this->data->engine->name && ($this->data->engine->name != 'Blink' && $this->data->engine->name != 'Webkit')) {
                        $this->camouflage = true;
                    }

                    if (isset($this->data->browser->name) && $this->data->browser->name == 'Internet Explorer') {
                        $this->camouflage = true;
                    }

                    /* IE 11 on mobile now supports Webkit APIs */
                    if (isset($this->data->browser->name) && $this->data->browser->name == 'Mobile Internet Explorer' &&
                        isset($this->data->browser->version) && $this->data->browser->version->toFloat() >= 11 &&
                        isset($this->data->os->name) && $this->data->os->name == 'Windows Phone') {
                        $this->camouflage = false;
                    }

                    /* IE 11 Developer Preview now supports  Webkit APIs */
                    if (isset($this->data->browser->name) && $this->data->browser->name == 'Internet Explorer' &&
                        isset($this->data->browser->version) && $this->data->browser->version->toFloat() >= 11 &&
                        isset($this->data->os->name) && $this->data->os->name == 'Windows') {
                        $this->camouflage = false;
                    }

                    /* EdgeHTML rendering engine also appears to be WebKit */
                    if (isset($this->data->engine->name) && $this->data->engine->name == 'EdgeHTML') {
                        $this->camouflage = false;
                    }
                }

                if ($this->options->engine & Constants\EngineType::CHROMIUM) {
                    $this->features[] = 'chrome';

                    if ($this->data->engine->name && ($this->data->engine->name != 'EdgeHTML' && $this->data->engine->name != 'Blink' && $this->data->engine->name != 'Webkit')) {
                        $this->camouflage = true;
                    }
                }

                /* If it claims to be Safari and uses V8, it is probably an Android device running camouflage mode */
                if ($this->data->engine->name == 'Webkit' && $this->options->engine & Constants\EngineType::V8) {
                    $this->features[] = 'v8';

                    if (isset($this->data->browser->name) && $this->data->browser->name == 'Safari') {
                        $this->camouflage = true;
                    }
                }

            }
        }

        if (isset($this->options->width) && isset($this->options->height)) {
            if (isset($this->data->device->model)) {
                /* If we have an iPad that is not 768 x 1024, we have an imposter */
                if ($this->data->device->model == 'iPad') {
                    if (($this->options->width != 0 && $this->options->height != 0) && ($this->options->width != 768 && $this->options->height != 1024) && ($this->options->width != 1024 && $this->options->height != 768)) {
                        $this->features[] = 'sizeMismatch';
                        $this->camouflage = true;
                    }
                }

                /* If we have an iPhone or iPod that is not 320 x 480, we have an imposter */
                /*
                if ($this->data->device->model == 'iPhone' || $this->data->device->model == 'iPod') {
                    if (($this->options->width != 0 && $this->options->height != 0) && 
                        ($this->options->width != 320 && $this->options->height != 480) && 
                        ($this->options->width != 480 && $this->options->height != 320)
                    ) {
                        $this->features[] = 'sizeMismatch';
                        $this->camouflage = true;
                    }
                }
                */
            }
        }

        if (isset($this->options->features)) {
            if (isset($this->data->browser->name) && isset($this->data->os->name)) {
                if ($this->data->os->name == 'iOS' && $this->data->browser->name != 'Opera Mini' && $this->data->browser->name != 'UC Browser' && isset($this->data->os->version)) {

                    if ($this->data->os->version->toFloat() < 4.0 && $this->options->features & Constants\Feature::SANDBOX) {
                        $this->features[] = 'foundSandbox';
                        $this->camouflage = true;
                    }

                    if ($this->data->os->version->toFloat() < 4.2 && $this->options->features & Constants\Feature::WEBSOCKET) {
                        $this->features[] = 'foundSockets';
                        $this->camouflage = true;
                    }

                    if ($this->data->os->version->toFloat() < 5.0 && $this->options->features & Constants\Feature::WORKER) {
                        $this->features[] = 'foundWorker';
                        $this->camouflage = true;
                    }

                    if ($this->data->os->version->toFloat() > 2.1 && !$this->options->features & Constants\Feature::APPCACHE) {
                        $this->features[] = 'noAppCache';
                        $this->camouflage = true;
                    }
                }

                if ($this->data->os->name != 'iOS' && $this->data->browser->name == 'Safari' && isset($this->data->browser->version)) {

                    if ($this->data->browser->version->toFloat() < 4.0 && $this->options->features & Constants\Feature::APPCACHE) {
                        $this->features[] = 'foundAppCache';
                        $this->camouflage = true;
                    }

                    if ($this->data->browser->version->toFloat() < 4.1 && $this->options->features & Constants\Feature::HISTORY) {
                        $this->features[] = 'foundHistory';
                        $this->camouflage = true;
                    }

                    if ($this->data->browser->version->toFloat() < 5.1 && $this->options->features & Constants\Feature::FULLSCREEN) {
                        $this->features[] = 'foundFullscreen';
                        $this->camouflage = true;
                    }

                    if ($this->data->browser->version->toFloat() < 5.2 && $this->options->features & Constants\Feature::FILEREADER) {
                        $this->features[] = 'foundFileReader';
                        $this->camouflage = true;
                    }
                }
            }
        }

        return $this;
    }
}
