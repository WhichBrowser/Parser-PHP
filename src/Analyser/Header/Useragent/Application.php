<?php

namespace WhichBrowser\Analyser\Header\Useragent;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Family;
use WhichBrowser\Model\Using;
use WhichBrowser\Model\Version;

trait Application
{
    private function &detectApplication($ua)
    {
        /* Detect applications */
        $this->detectSpecificApplications($ua);
        $this->detectRemainingApplications($ua);

        return $this;
    }



    private function detectSpecificApplications($ua)
    {
        /* Sony Updatecenter */

        if (preg_match('/^(.*) Build\/.* (?:com.sonyericsson.updatecenter|UpdateCenter)\/[A-Z0-9\.]+$/iu', $ua, $match)) {
            $this->data->browser->name = 'Sony Update Center';
            $this->data->browser->version = null;
            $this->data->browser->type = Constants\BrowserType::APP;

            $this->data->os->reset([
                'name'      => 'Android'
            ]);

            $this->data->device->model = $match[1];
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->type = Constants\DeviceType::MOBILE;

            $device = Data\DeviceModels::identify('android', $match[1]);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
            }
        }

        /* Sony Select SDK */

        if (preg_match('/Android [0-9\.]+; (.*) Sony\/.*SonySelectSDK\/([0-9\.]+)/iu', $ua, $match)) {
            $this->data->browser->reset();
            $this->data->browser->type = Constants\BrowserType::APP;
            $this->data->browser->using = new \WhichBrowser\Model\Using([
                'name' => 'Sony Select SDK',
                'version' => new Version([ 'value' => $match[2], 'details' => 2 ])
            ]);

            $this->data->device->model = $match[1];
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->type = Constants\DeviceType::MOBILE;

            $device = Data\DeviceModels::identify('android', $match[1]);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
            }
        }

        /* Samsung Mediahub */

        if (preg_match('/^Stamhub [^\/]+\/([^;]+);.*:([0-9\.]+)\/[^\/]+\/[^:]+:user\/release-keys$/iu', $ua, $match)) {
            $this->data->browser->name = 'Mediahub';
            $this->data->browser->version = null;
            $this->data->browser->type = Constants\BrowserType::APP_MEDIAPLAYER;

            $this->data->os->reset([
                'name'      => 'Android',
                'version'   => new Version([ 'value' => $match[2] ])
            ]);

            $this->data->device->model = $match[1];
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->type = Constants\DeviceType::MOBILE;

            $device = Data\DeviceModels::identify('android', $match[1]);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
            }
        }

        /* "Android Application" */

        if (preg_match('/Android Application/iu', $ua)) {
            if (preg_match('/^(.+) Android Application \([0-9]+, .+ v[0-9\.]+\) - [a-z-]+ (.*) [a-z_-]+ - [0-9A-F]{8,8}-[0-9A-F]{4,4}-[0-9A-F]{4,4}-[0-9A-F]{4,4}-[0-9A-F]{12,12}$/iu', $ua, $match)) {
                $this->data->browser->name = $match[1];
                $this->data->browser->version = null;
                $this->data->browser->type = Constants\BrowserType::APP;

                $this->data->os->reset([
                    'name'      => 'Android'
                ]);

                $this->data->device->model = $match[2];
                $this->data->device->identified |= Constants\Id::PATTERN;
                $this->data->device->type = Constants\DeviceType::MOBILE;

                $device = Data\DeviceModels::identify('android', $match[2]);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            if (preg_match('/^(.+) Android Application - (.*) Build\/(.+)  - [0-9A-F]{8,8}-[0-9A-F]{4,4}-[0-9A-F]{4,4}-[0-9A-F]{4,4}-[0-9A-F]{12,12}$/iu', $ua, $match)) {
                $this->data->browser->name = $match[1];
                $this->data->browser->version = null;
                $this->data->browser->type = Constants\BrowserType::APP;

                $this->data->os->reset([
                    'name'      => 'Android'
                ]);

                $version = Data\BuildIds::identify($match[3]);
                if ($version) {
                    $this->data->os->version = $version;
                }

                $this->data->device->model = $match[2];
                $this->data->device->identified |= Constants\Id::PATTERN;
                $this->data->device->type = Constants\DeviceType::MOBILE;

                $device = Data\DeviceModels::identify('android', $match[2]);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            if (preg_match('/^(.+) Android Application - [a-z-]+ (.*) [a-z_-]+$/iu', $ua, $match)) {
                $this->data->browser->name = $match[1];
                $this->data->browser->version = null;
                $this->data->browser->type = Constants\BrowserType::APP;

                $this->data->os->reset([
                    'name'      => 'Android'
                ]);

                $this->data->device->model = $match[2];
                $this->data->device->identified |= Constants\Id::PATTERN;
                $this->data->device->type = Constants\DeviceType::MOBILE;

                $device = Data\DeviceModels::identify('android', $match[2]);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }
        }

        /* AiMeiTuan */

        if (preg_match('/^AiMeiTuan \/[^\-]+\-([0-9\.]+)\-(.*)\-[0-9]+x[0-9]+\-/iu', $ua, $match)) {
            $this->data->browser->name = 'AiMeiTuan';
            $this->data->browser->version = null;
            $this->data->browser->type = Constants\BrowserType::APP;

            $this->data->os->reset([
                'name'      => 'Android',
                'version'   => new Version([ 'value' => $match[1] ])
            ]);

            $this->data->device->model = $match[2];
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->type = Constants\DeviceType::MOBILE;

            $device = Data\DeviceModels::identify('android', $match[2]);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
            }
        }

        /* Instagram */

        if (preg_match('/^Instagram ([0-9\.]+) Android (?:IC )?\([0-9]+\/([0-9\.]+); [0-9]+dpi; [0-9]+x[0-9]+; [^;]+; ([^;]*);/iu', $ua, $match)) {
            $this->data->browser->name = 'Instagram';
            $this->data->browser->version = new Version([ 'value' => $match[1] ]);
            $this->data->browser->type = Constants\BrowserType::APP_SOCIAL;

            $this->data->os->reset([
                'name'      => 'Android',
                'version'   => new Version([ 'value' => $match[2] ])
            ]);

            $this->data->device->model = $match[3];
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->type = Constants\DeviceType::MOBILE;

            $device = Data\DeviceModels::identify('android', $match[3]);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
            }
        }

        /* Pinterest */

        if (preg_match('/^Pinterest for Android( Tablet)?\/([0-9\.]+) \(([^;]+); ([0-9\.]+)\)/iu', $ua, $match)) {
            $this->data->browser->name = 'Pinterest';
            $this->data->browser->version = new Version([ 'value' => $match[2] ]);
            $this->data->browser->type = Constants\BrowserType::APP_SOCIAL;

            $this->data->os->reset([
                'name'      => 'Android',
                'version'   => new Version([ 'value' => $match[4] ])
            ]);

            $this->data->device->model = $match[3];
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->type = $match[1] == ' Tablet' ? Constants\DeviceType::TABLET : Constants\DeviceType::MOBILE;

            $device = Data\DeviceModels::identify('android', $match[3]);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
            }
        }

        /* Dr. Web Anti-Virus */

        if (preg_match('/Dr\.Web anti\-virus Light Version: ([0-9\.]+) Device model: (.*) Firmware version: ([0-9\.]+)/u', $ua, $match)) {
            $this->data->browser->name = 'Dr. Web Light';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::APP_ANTIVIRUS;

            $this->data->os->reset([
                'name'      => 'Android',
                'version'   => new Version([ 'value' => $match[3] ])
            ]);

            $this->data->device->type = Constants\DeviceType::MOBILE;

            $device = Data\DeviceModels::identify('android', $match[2]);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
            }
        }

        /* Google Earth */

        if (preg_match('/GoogleEarth\/([0-9\.]+)\(Android;Android \((.+)\-[^\-]+\-user-([0-9\.]+)\);/u', $ua, $match)) {
            $this->data->browser->name = 'Google Earth';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::APP;

            $this->data->os->reset([
                'name'      => 'Android',
                'version'   => new Version([ 'value' => $match[3] ])
            ]);

            $this->data->device->type = Constants\DeviceType::MOBILE;

            $device = Data\DeviceModels::identify('android', $match[2]);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
            }
        }

        /* Groupon */

        if (preg_match('/Groupon\/([0-9\.]+) \(Android ([0-9\.]+); [^\/]+ \/ [A-Z][a-z]+ ([^;]*);/u', $ua, $match)) {
            $this->data->browser->name = 'Groupon';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::APP_SHOPPING;

            $this->data->os->reset([
                'name'      => 'Android',
                'version'   => new Version([ 'value' => $match[2] ])
            ]);

            $this->data->device->type = Constants\DeviceType::MOBILE;
            $this->data->device->model = $match[3];

            $device = Data\DeviceModels::identify('android', $match[3]);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
            }
        }

        /* Whatsapp */

        if (preg_match('/WhatsApp\+?\/([0-9\.]+) (Android|S60Version|WP7)\/([0-9\.\_]+) Device\/([^\-]+)\-(.*)(?:-\([0-9]+\.[0-9]+\))?(?:\-H[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)?$/uU', $ua, $match)) {
            $this->data->browser->name = 'WhatsApp';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::APP_CHAT;

            $this->data->device->type = Constants\DeviceType::MOBILE;
            $this->data->device->manufacturer = $match[4];
            $this->data->device->model = $match[5];
            $this->data->device->identified |= Constants\Id::PATTERN;

            if ($match[2] == 'Android') {
                $this->data->os->reset([
                    'name'      => 'Android',
                    'version'   => new Version([ 'value' => str_replace('_', '.', $match[3]) ])
                ]);

                $device = Data\DeviceModels::identify('android', $match[5]);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            if ($match[2] == 'WP7') {
                $this->data->os->reset([
                    'name'      => 'Windows Phone',
                    'version'   => new Version([ 'value' => $match[3], 'details' => 2 ])
                ]);

                $device = Data\DeviceModels::identify('wp', $match[5]);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            if ($match[2] == 'S60Version') {
                $this->data->os->reset([
                    'name'      => 'Series60',
                    'version'   => new Version([ 'value' => $match[3] ]),
                    'family'    => new Family([ 'name' => 'Symbian' ])
                ]);

                $device = Data\DeviceModels::identify('symbian', $match[5]);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            if ($match[2] == 'WP7') {
                $this->data->os->reset([
                    'name'      => 'Windows Phone',
                    'version'   => new Version([ 'value' => $match[3], 'details' => 2 ])
                ]);

                $device = Data\DeviceModels::identify('wp', $match[5]);
                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }
        }

        /* Yahoo */

        if (preg_match('/YahooMobile(?:Messenger|Mail|Weather)\/1.0 \(Android (Messenger|Mail|Weather); ([0-9\.]+)\) \([^;]+; ?[^;]+; ?([^;]+); ?([0-9\.]+)\/[^\;\)\/]+\)/u', $ua, $match)) {
            $this->data->browser->name = 'Yahoo ' . $match[1];
            $this->data->browser->version = new Version([ 'value' => $match[2], 'details' => 3 ]);

            switch ($match[1]) {
                case 'Messenger':
                    $this->data->browser->type = Constants\BrowserType::APP_CHAT;
                    break;
                case 'Mail':
                    $this->data->browser->type = Constants\BrowserType::APP_EMAIL;
                    break;
                case 'Weather':
                    $this->data->browser->type = Constants\BrowserType::APP_NEWS;
                    break;
            }

            $this->data->os->reset([
                'name'      => 'Android',
                'version'   => new Version([ 'value' => $match[4] ])
            ]);

            $this->data->device->type = Constants\DeviceType::MOBILE;

            $device = Data\DeviceModels::identify('android', $match[3]);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
            }
        }

        /* Yahoo Mobile App */

        if (preg_match('/YahooJMobileApp\/[0-9\.]+ \(Android [a-z]+; ([0-9\.]+)\) \([^;]+; ?[^;]+; ?[^;]+; ?([^;]+); ?([0-9\.]+)\/[^\;\)\/]+\)/u', $ua, $match)) {
            $this->data->browser->name = 'Yahoo Mobile';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            $this->data->browser->type = Constants\BrowserType::APP_SEARCH;

            $this->data->os->reset([
                'name'      => 'Android',
                'version'   => new Version([ 'value' => $match[3] ])
            ]);

            $this->data->device->type = Constants\DeviceType::MOBILE;

            $device = Data\DeviceModels::identify('android', $match[2]);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
            }
        }

        /* ICQ */

        if (preg_match('/ICQ_Android\/([0-9\.]+) \(Android; [0-9]+; ([0-9\.]+); [^;]+; ([^;]+);/u', $ua, $match)) {
            $this->data->browser->name = 'ICQ';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
            $this->data->browser->type = Constants\BrowserType::APP_CHAT;

            $this->data->os->reset([
                'name'      => 'Android',
                'version'   => new Version([ 'value' => $match[2] ])
            ]);

            $this->data->device->type = Constants\DeviceType::MOBILE;

            $device = Data\DeviceModels::identify('android', $match[3]);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
            }
        }

        /* Facebook for Android */

        if (preg_match('/^\[FBAN\/(FB4A|PAAA);.*FBDV\/([^;]+);.*FBSV\/([0-9\.]+);/u', $ua, $match)) {
            if ($match[1] == 'FB4A') {
                $this->data->browser->name = 'Facebook';
                $this->data->browser->version = null;
                $this->data->browser->type = Constants\BrowserType::APP_SOCIAL;
            }

            if ($match[1] == 'PAAA') {
                $this->data->browser->name = 'Facebook Pages';
                $this->data->browser->version = null;
                $this->data->browser->type = Constants\BrowserType::APP_SOCIAL;
            }

            $this->data->os->reset([
                'name'      => 'Android',
                'version'   => new Version([ 'value' => $match[3] ])
            ]);

            $this->data->device->type = Constants\DeviceType::MOBILE;

            $device = Data\DeviceModels::identify('android', $match[2]);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
            }
        }

        /* VK */

        if (preg_match('/^VKAndroidApp\/([0-9\.]+)-[0-9]+ \(Android ([^;]+); SDK [^;]+; [^;]+; [a-z]+ ([^;]+);/iu', $ua, $match)) {
            $this->data->browser->name = 'VK';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::APP_SOCIAL;

            $this->data->os->reset([
                'name'      => 'Android',
                'version'   => new Version([ 'value' => $match[2] ])
            ]);

            $this->data->device->model = $match[3];
            $this->data->device->identified |= Constants\Id::PATTERN;
            $this->data->device->type = Constants\DeviceType::MOBILE;

            $device = Data\DeviceModels::identify('android', $match[3]);
            if ($device->identified) {
                $device->identified |= $this->data->device->identified;
                $this->data->device = $device;
            }
        }
    }

    private function detectRemainingApplications($ua)
    {
        if ($data = Data\Applications::identifyOther($ua)) {
            $this->data->browser->set($data['browser']);

            if (!empty($data['device'])) {
                $this->data->device->set($data['device']);
            }
        }
    }
}
