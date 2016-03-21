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

        if (preg_match('/^(.*) Build\/.* com.sonyericsson.updatecenter\/[A-Z0-9\.]+$/iu', $ua, $match)) {
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

        if (preg_match('/^(.+) Android Application \([0-9]+, .+ v([0-9\.]+)\) - [a-z]+ (.*) [a-z]+ - [0-9A-F]{8,8}-[0-9A-F]{4,4}-[0-9A-F]{4,4}-[0-9A-F]{4,4}-[0-9A-F]{12,12}$/iu', $ua, $match)) {
            $this->data->browser->name = $match[1];
            $this->data->browser->version = null;
            $this->data->browser->type = Constants\BrowserType::APP;

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

        if (preg_match('/^Instagram ([0-9\.]+) Android \([0-9]+\/([0-9\.]+); [0-9]+dpi; [0-9]+x[0-9]+; [^;]+; ([^;]*);/iu', $ua, $match)) {
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

        if (preg_match('/Groupon\/([0-9\.]+) \(Android ([0-9\.]+); [^\/]+ \/ ([^;]*);/u', $ua, $match)) {
            $this->data->browser->name = 'Groupon';
            $this->data->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
            $this->data->browser->type = Constants\BrowserType::APP_SHOPPING;

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

    }

    private function detectRemainingApplications($ua)
    {
        $items = [

            Constants\BrowserType::APP_MEDIAPLAYER => [
                [ 'name' => 'iTunes',               'regexp' => '/iTunes\/(?:xaa.)?([0-9.]*)/u' ],
                [ 'name' => 'iTunes',               'regexp' => '/iTunes-AppleTV\//u' ],
                [ 'name' => 'QuickTime',            'regexp' => '/\(qtver=([0-9.]*);/u' ],
                [ 'name' => 'Bluefish',             'regexp' => '/bluefish ([0-9.]*)/u' ],
                [ 'name' => 'Nightingale',          'regexp' => '/Nightingale\/([0-9.]*)/u' ],
                [ 'name' => 'Songbird',             'regexp' => '/Songbird\/([0-9.]*)/u' ],
                [ 'name' => 'Stagefright',          'regexp' => '/stagefright\/([0-9.]*)/u' ],
                [ 'name' => 'SubStream',            'regexp' => '/SubStream\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],
                [ 'name' => 'VLC',                  'regexp' => '/VLC media player - version ([0-9.]*)/u' ],
                [ 'name' => 'Windows Media Player', 'regexp' => '/Windows-Media-Player\/([0-9.]*)/u', 'details' => 1 ],
                [ 'name' => 'CorePlayer',           'regexp' => '/CorePlayer\/([0-9.]*)/u' ],
                [ 'name' => 'FlyCast',              'regexp' => '/FlyCast\/([0-9.]*)/u' ],
            ],

            Constants\BrowserType::APP_EMAIL => [
                [ 'name' => 'Lightning',            'regexp' => '/Lightning\/([0-9.]*)/u' ],
                [ 'name' => 'Thunderbird',          'regexp' => '/Thunderbird[\/ ]([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Microsoft Outlook',    'regexp' => '/Microsoft Outlook IMO, Build ([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Microsoft Outlook',    'regexp' => '/Microsoft Outlook ([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Microsoft Outlook Express',    'regexp' => '/Outlook-Express\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Lotus Notes',          'regexp' => '/Lotus-Notes\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Postbox',              'regexp' => '/Postbox[\/ ]([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'The Bat!',             'regexp' => '/The Bat! ([0-9.]*)/u', 'details' => 3 ],
                [ 'name' => 'Yahoo Mail',           'regexp' => '/YahooMobile\/1.0 \(mail; ([0-9.]+)\)/u', 'details' => 3 ],
            ],

            Constants\BrowserType::APP_NEWS => [
                [ 'name' => 'Daum',                 'regexp' => '/DaumApps\/([0-9.]*)/u' ],
                [ 'name' => 'Daum',                 'regexp' => '/daumcafe\/([0-9.]*)/u' ],
            ],

            Constants\BrowserType::APP_FEEDREADER => [
                [ 'name' => 'Akregator',            'regexp' => '/Akregator\/([0-9.]*)/u' ],
                [ 'name' => 'Blogos',               'regexp' => '/Blogos\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],
                [ 'name' => 'Cococ',                'regexp' => '/cococ\/([0-9.]*)/u' ],
                [ 'name' => 'FeedDemon',            'regexp' => '/FeedDemon\/([0-9.]*)/u' ],
                [ 'name' => 'Feeddler',             'regexp' => '/FeeddlerRSS[ \/]([0-9.]*)/u' ],
                [ 'name' => 'Feeddler Pro',         'regexp' => '/FeeddlerPro\/([0-9.]*)/u' ],
                [ 'name' => 'Liferea',              'regexp' => '/Liferea\/([0-9.]*)/u' ],
                [ 'name' => 'NewsBlur',             'regexp' => '/NewsBlur\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],
                [ 'name' => 'Newsbeuter',           'regexp' => '/newsbeuter\/([0-9.]*)/u' ],
                [ 'name' => 'JetBrains Omea Reader','regexp' => '/JetBrains Omea Reader ([0-9.]*)/u' ],
                [ 'name' => 'RSS Bandit',           'regexp' => '/RssBandit\/([0-9.]*)/u' ],
                [ 'name' => 'RSS Junkie',           'regexp' => '/RSS Junkie Daemon/u' ],
                [ 'name' => 'RSS Owl',              'regexp' => '/RSSOwl\/([0-9.]*)/u' ],
                [ 'name' => 'Reeder',               'regexp' => '/Reeder\/([0-9.]*)/u' ],
                [ 'name' => 'ReedKit',              'regexp' => '/ReedKit\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'Rome',                 'regexp' => '/Rome Client/u' ],
                [ 'name' => 'jsRSS++',              'regexp' => '/jsRSS++\/([0-9.]*)/u' ],
                [ 'name' => 'Windows RSS Platorm',  'regexp' => '/Windows-RSS-Platform\/([0-9.]*)/u' ],
            ],

            Constants\BrowserType::APP_PODCAST => [
                [ 'name' => 'Ziepod',              'regexp' => '/Ziepod\+? ([0-9.]*)/u' ],
            ],

            Constants\BrowserType::APP_CHAT => [
                [ 'name' => 'Facebook Messenger',   'regexp' => '/FBAN\/MessengerForiOS/u' ],
                [ 'name' => 'Kik',                  'regexp' => '/Kik\/([0-9.]*)/u' ],
                [ 'name' => 'WeChat',               'regexp' => '/MicroMessenger\/([0-9.]*)/u' ],
                [ 'name' => 'Yahoo Messenger',      'regexp' => '/YahooMobile\/1.0 \(im; ([0-9.]+)\)/u', 'details' => 3 ],
                [ 'name' => 'Yammer',               'regexp' => '/Yammer\/([0-9.]*)/u', 'details' => 2 ],
            ],

            Constants\BrowserType::APP_SOCIAL => [
                [ 'name' => 'Facebook',             'regexp' => '/FBAN\/FBIOS/u' ],
                [ 'name' => 'Facebook',             'regexp' => '/FBAN\/FB4A/u' ],
                [ 'name' => 'Facebook',             'regexp' => '/FB_IAB\/FB4A/u' ],
                [ 'name' => 'Google+',              'regexp' => '/com.google.GooglePlus/u'  ],
                [ 'name' => 'Instagram',            'regexp' => '/Instagram ([0-9.]+)/u' ],
                [ 'name' => 'Sina Weibo',           'regexp' => '/weibo__([0-9.]*)/u' ],
                [ 'name' => 'Twitter',              'regexp' => '/TwitterAndroid/u' ],
                [ 'name' => 'Twitter',              'regexp' => '/Twitter for iPhone/u' ],
                [ 'name' => 'WordPress',            'regexp' => '/wp-android\/([0-9.]*)/u' ],
            ],

            Constants\BrowserType::APP_OFFICE => [
                [ 'name' => 'Microsoft Office',     'regexp' => '/MSOffice ([0-9.]*)/u' ],
            ],

            Constants\BrowserType::APP_SEARCH => [
                [ 'name' => 'Baidu Hao123',         'regexp' => '/hao123\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Google Search',        'regexp' => '/GSA\/([0-9.]*)/u', 'details' => 3 ],
                [ 'name' => 'NAVER',                'regexp' => '/NAVER\(inapp; search; [0-9]+; ([0-9.]*)\)/u' ],
            ],

            Constants\BrowserType::APP_EDITOR => [
                [ 'name' => 'Atom',                 'regexp' => '/Atom\/([0-9.]*)/u' ],
                [ 'name' => 'Adobe GoLive',         'regexp' => '/GoLive ([0-9.]*)/u' ],
                [ 'name' => 'Brackets',             'regexp' => '/Brackets\/([0-9.]*)/u' ],
                [ 'name' => 'iWeb',                 'regexp' => '/iWeb\/([0-9])/u' ],
                [ 'name' => 'Microsoft FrontPage',  'regexp' => '/MS FrontPage ([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
                [ 'name' => 'W3C Amaya',            'regexp' => '/amaya\/([0-9.]*)/u' ],
            ],

            Constants\BrowserType::APP_DOWNLOAD => [
                [ 'name' => 'Download Manager',     'regexp' => '/AndroidDownloadManager\//u' ],
            ],

            Constants\BrowserType::APP_GAME => [
                [ 'name' => 'EA Origin',            'regexp' => '/Origin\/([0-9.]*)/u' ],
                [ 'name' => 'SecondLife',           'regexp' => '/SecondLife\/([0-9.]*)/u' ],
                [ 'name' => 'Valve Steam',          'regexp' => '/Valve Steam/u' ],
                [ 'name' => 'Raptr',                'regexp' => '/Raptr/u' ],
            ],

            Constants\BrowserType::APP => [
                [ 'name' => 'Cooliris',             'regexp' => '/Cooliris\/([0-9.]*)/u' ],
                [ 'name' => 'Google Earth',         'regexp' => '/Google Earth\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Google Desktop',       'regexp' => '/Google Desktop\/([0-9.]*)/u', 'details' => 2 ],
                [ 'name' => 'Leechcraft',           'regexp' => '/Leechcraft(?:\/([0-9.]*))?/u', 'details' => 2 ],
                [ 'name' => 'Lotus Expeditor',      'regexp' => '/Gecko Expeditor ([0-9.]*)/u', 'details' => 3 ],
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
                }
            }
        }
    }
}
