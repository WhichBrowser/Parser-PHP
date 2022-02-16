<?php

namespace WhichBrowser\Data;

use WhichBrowser\Constants;

Applications::$OTHERS = [

    Constants\BrowserType::APP_MEDIAPLAYER => [
        [ 'name' => 'iTunes',               'id'    => 'itunes',            'regexp' =>'/iTunes\/(?:xaa.)?([0-9.]*)/u' ],
        [ 'name' => 'iTunes',               'id'    => 'itunes',            'regexp' =>'/iTunes-AppleTV\//u' ],
        [ 'name' => 'QuickTime',            'id'    => 'qt',                'regexp' =>'/\(qtver=([0-9.]*);/u' ],
        [ 'name' => 'Bluefish',             'id'    => 'bluefish',          'regexp' =>'/bluefish ([0-9.]*)/u' ],
        [ 'name' => 'Nightingale',          'id'    => 'nightingale',       'regexp' =>'/Nightingale\/([0-9.]*)/u' ],
        [ 'name' => 'Songbird',             'id'    => 'songbird',          'regexp' =>'/Songbird\/([0-9.]*)/u' ],
        [ 'name' => 'Stagefright',          'id'    => 'stagefright',       'regexp' =>'/stagefright\/([0-9.]*)/u' ],
        [ 'name' => 'SubStream',            'id'    => 'substream',         'regexp' =>'/SubStream\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'VLC',                  'id'    => 'vlc',               'regexp' =>'/VLC media player - version ([0-9.]*)/u' ],
        [ 'name' => 'VLC',                  'id'    => 'vlc',               'regexp' =>'/VLC\/([0-9.]*)/u' ],
        [ 'name' => 'Windows Media Player', 'id'    => 'windows-media',     'regexp' =>'/Windows-Media-Player\/([0-9.]*)/u', 'details' => 1 ],
        [ 'name' => 'CorePlayer',           'id'    => 'coreplayer',        'regexp' =>'/CorePlayer\/([0-9.]*)/u' ],
        [ 'name' => 'FlyCast',              'id'    => 'flycast',           'regexp' =>'/FlyCast\/([0-9.]*)/u' ],
        [ 'name' => 'Boxee',                'id'    => 'boxee',             'regexp' => '/Boxee(?:\/([0-9.]*))?/u', 'type' => Constants\DeviceType::TELEVISION ],
        [ 'name' => 'Kodi',                 'id'    => 'kodi',              'regexp' => '/^Kodi\/([0-9.]+)/u', 'details' => 2 ],
        [ 'name' => 'XBMC',                 'id'    => 'xbmc',              'regexp' => '/^XBMC\/(?:PRE-)?([0-9.]+)/u', 'details' => 2 ],
    ],

    Constants\BrowserType::APP_EMAIL => [
        [ 'name' => 'Lightning',            'id'    => 'lightning',      'regexp' =>'/Lightning\/([0-9.]*)/u' ],
        [ 'name' => 'Thunderbird',          'id'    => 'thunderbird',      'regexp' =>'/Thunderbird[\/ ]([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Microsoft Outlook',    'id'    => 'outlook',      'regexp' =>'/Microsoft Outlook IMO, Build ([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Microsoft Outlook',    'id'    => 'outlook',      'regexp' =>'/Microsoft Outlook ([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Microsoft Outlook Express',    'id'    => 'outlook',      'regexp' =>'/Outlook-Express\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Lotus Notes',          'id'    => 'lotus',      'regexp' =>'/Lotus-Notes\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Postbox',              'id'    => 'postbox',      'regexp' =>'/Postbox[\/ ]([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'The Bat!',             'id'    => 'bat',      'regexp' =>'/The Bat! ([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => 'Yahoo Mail',           'id'    => 'yahoo',      'regexp' =>'/YahooMobile\/1.0 \(mail; ([0-9.]+)\)/u', 'details' => 3 ],
    ],

    Constants\BrowserType::APP_NEWS => [
        [ 'name' => 'Daum',                 'id'    => 'daum',      'regexp' =>'/DaumApps\/([0-9.]*)/u' ],
        [ 'name' => 'Daum',                 'id'    => 'daum',      'regexp' =>'/daumcafe\/([0-9.]*)/u' ],
        [ 'name' => 'Flipboard',            'id'    => 'flipboard',      'regexp' =>'/Flipboard\/([0-9.]+)/u' ],
    ],

    Constants\BrowserType::APP_FEEDREADER => [
        [ 'name' => 'Akregator',            'id'    => 'akregator',      'regexp' =>'/Akregator\/([0-9.]*)/u' ],
        [ 'name' => 'Blogos',               'id'    => 'blogos',      'regexp' =>'/Blogos\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Cococ',                'id'    => 'cococ',      'regexp' =>'/cococ\/([0-9.]*)/u' ],
        [ 'name' => 'FeedDemon',            'id'    => 'feed',      'regexp' =>'/FeedDemon\/([0-9.]*)/u' ],
        [ 'name' => 'Feeddler',             'id'    => 'feed',      'regexp' =>'/FeeddlerRSS[ \/]([0-9.]*)/u' ],
        [ 'name' => 'Feeddler Pro',         'id'    => 'feed',      'regexp' =>'/FeeddlerPro\/([0-9.]*)/u' ],
        [ 'name' => 'Liferea',              'id'    => 'liferea',      'regexp' =>'/Liferea\/([0-9.]*)/u' ],
        [ 'name' => 'NewsBlur',             'id'    => 'news',      'regexp' =>'/NewsBlur\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Newsbeuter',           'id'    => 'news',      'regexp' =>'/newsbeuter\/([0-9.]*)/u' ],
        [ 'name' => 'JetBrains Omea Reader','id'    => 'jetbrains',      'regexp' =>'/JetBrains Omea Reader ([0-9.]*)/u' ],
        [ 'name' => 'RSS Bandit',           'id'    => 'rss',      'regexp' =>'/RssBandit\/([0-9.]*)/u' ],
        [ 'name' => 'RSS Junkie',           'id'    => 'rss',      'regexp' =>'/RSS Junkie Daemon/u' ],
        [ 'name' => 'RSS Owl',              'id'    => 'rss',      'regexp' =>'/RSSOwl\/([0-9.]*)/u' ],
        [ 'name' => 'Reeder',               'id'    => 'reeder',      'regexp' =>'/Reeder\/([0-9.]*)/u' ],
        [ 'name' => 'ReedKit',              'id'    => 'reedkit',      'regexp' =>'/ReedKit\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Rome',                 'id'    => 'rome',      'regexp' =>'/Rome Client/u' ],
        [ 'name' => 'jsRSS++',              'id'    => 'rss',      'regexp' =>'/jsRSS++\/([0-9.]*)/u' ],
        [ 'name' => 'Windows RSS Platorm',  'id'    => 'rss',      'regexp' =>'/Windows-RSS-Platform\/([0-9.]*)/u' ],
    ],

    Constants\BrowserType::APP_PODCAST => [
        [ 'name' => 'Ziepod',              'id'    => 'ziepod',      'regexp' =>'/Ziepod\+? ([0-9.]*)/u' ],
    ],

    Constants\BrowserType::APP_CHAT => [
        [ 'name' => 'Facebook Messenger',   'id'    => 'messenger',      'regexp' =>'/FBAN\/MessengerForiOS/u' ],
        [ 'name' => 'Facebook Messenger',   'id'    => 'messenger',      'regexp' =>'/FB_IAB\/MESSENGER/u' ],
        [ 'name' => 'KakaoTalk',            'id'    => 'kakao',           'regexp' => '/KAKAOTALK ([0-9.]*)/u' ],
        [ 'name' => 'KakaoTalk',            'id'    => 'kakao',           'regexp' => '/KAKAOTALK/u' ],
        [ 'name' => 'Kik',                  'id'    => 'kik',      'regexp' =>'/Kik\/([0-9.]*?)(\.0)?\.[0-9]{3,4}/u' ],
        [ 'name' => 'Line',                 'id'    => 'line',            'regexp' => '/ Line\/([0-9.]*)/u' ],
        [ 'name' => 'Slack',                'id'    => 'slack',            'regexp' => '/ Slack_SSB\/([0-9.]*)/u' ],
        [ 'name' => 'Viber',                'id'    => 'viber',            'regexp' => '/ Viber/u' ],
        [ 'name' => 'Viber',                'id'    => 'viber',            'regexp' => '/Viber\/([0-9.]*)/u' ],
        [ 'name' => 'WeChat',               'id'    => 'messenger',      'regexp' =>'/MicroMessenger\/([0-9.]*)/u' ],
        [ 'name' => 'WhatsApp',             'id'    => 'whatsapp',      'regexp' =>'/WhatsApp\/([0-9.]*)/u' ],
        [ 'name' => 'Wire',                 'id'    => 'wire',      'regexp' =>'/Wire\/([0-9.]*)/u' ],
        [ 'name' => 'Yahoo Messenger',      'id'    => 'yahoo',      'regexp' =>'/YahooMobile\/1.0 \(im; ([0-9.]+)\)/u', 'details' => 3 ],
        [ 'name' => 'Yammer',               'id'    => 'yammer',      'regexp' =>'/Yammer\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Zalo',                 'id'    => 'zalo',           'regexp' => '/Zalo-win32-([0-9.]*)/u' ],
        [ 'name' => 'Zalo',                 'id'    => 'zalo',           'regexp' => '/ Zalo\/([0-9.]*)/u' ],
    ],

    Constants\BrowserType::APP_SOCIAL => [
        [ 'name' => 'Facebook',             'id'    => 'fbios',      'regexp' =>'/FBAN\/FBIOS/u' ],
        [ 'name' => 'Facebook',             'id'    => 'fb4a',      'regexp' =>'/FBAN\/FB4A/u' ],
        [ 'name' => 'Facebook',             'id'    => 'fb4a',      'regexp' =>'/FB_IAB\/FB4A/u' ],
        [ 'name' => 'Google+',              'id'    => 'googleplus',      'regexp' =>'/com.google.GooglePlus/u'  ],
        [ 'name' => 'Instagram',            'id'    => 'instagram',      'regexp' =>'/Instagram ([0-9.]+)/u' ],
        [ 'name' => 'Pinterest',            'id'    => 'pinterest',      'regexp' =>'/\[Pinterest\/(Android|iOS)\]/u' ],
        [ 'name' => 'Pinterest',            'id'    => 'pinterest',      'regexp' =>'/Pinterest\/[0-9.]+/u' ],
        [ 'name' => 'Sina Weibo',           'id'    => 'weibo',      'regexp' =>'/weibo__([0-9.]*)/u' ],
        [ 'name' => 'Tumblr',               'id'    => 'tumblr',      'regexp' =>'/Tumblr\/([0-9.]*)/u' ],
        [ 'name' => 'Twitter',              'id'    => 'twitter',      'regexp' =>'/TwitterAndroid/u' ],
        [ 'name' => 'Twitter',              'id'    => 'twitter',      'regexp' =>'/Twitter for iPhone/u' ],
        [ 'name' => 'WordPress',            'id'    => 'wp-android',      'regexp' =>'/wp-android\/([0-9.]*)/u' ],
        [ 'name' => 'Yelp',                 'id'    => 'yelp',      'regexp' =>'/YelpApp\/([0-9.]*)/u' ],
    ],

    Constants\BrowserType::APP_OFFICE => [
        [ 'name' => 'LibreOffice',          'id'    => 'office',      'regexp' =>'/LibreOffice/u' ],
        [ 'name' => 'Microsoft Office',     'id'    => 'office',      'regexp' =>'/MSOffice ([0-9.]*)/u' ],
        [ 'name' => 'Microsoft Office',     'id'    => 'office',      'regexp' =>'/Microsoft Office Mobile ?\/([0-9.]*)/u' ],
        [ 'name' => 'Microsoft Excel',      'id'    => 'office',      'regexp' =>'/Microsoft Office Excel ([0-9.]*)/u' ],
        [ 'name' => 'Microsoft OneNote',    'id'    => 'office',      'regexp' =>'/Microsoft Office OneNote ([0-9.]*)/u' ],
        [ 'name' => 'Microsoft PowerPoint', 'id'    => 'office',      'regexp' =>'/Microsoft Office PowerPoint ([0-9.]*)/u' ],
        [ 'name' => 'Microsoft Word',       'id'    => 'office',      'regexp' =>'/Microsoft Office Word ([0-9.]*)/u' ],
        [ 'name' => 'OpenOffice',           'id'    => 'office',      'regexp' =>'/OpenOffice\/([0-9.]*)/u' ],
    ],

    Constants\BrowserType::APP_SEARCH => [
        [ 'name' => 'Bing Search',          'id'    => 'bingweb',      'regexp' =>'/BingWeb\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => 'Baidu Hao123',         'id'    => 'hao123',      'regexp' =>'/hao123\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Google Search',        'id'    => 'gsa',      'regexp' =>'/GSA\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => 'NAVER',                'id'    => 'naver',      'regexp' =>'/NAVER\(inapp; search; [0-9]+; ([0-9.]*)\)/u' ],
        [ 'name' => 'Sogou Search',         'id'    => 'sogousearch',      'regexp' =>'/SogouSearch Android(?:[0-9.]*) version([0-9.]*)/u' ],
        [ 'name' => 'Yandex Search',        'id'    => 'yandex',      'regexp' =>'/YandexSearch\/([0-9.]*)/u' ],
    ],

    Constants\BrowserType::APP_EDITOR => [
        [ 'name' => 'Atom',                 'id'    => 'atom',      'regexp' =>'/Atom\/([0-9.]*)/u' ],
        [ 'name' => 'Adobe GoLive',         'id'    => 'golive',      'regexp' =>'/GoLive ([0-9.]*)/u' ],
        [ 'name' => 'Brackets',             'id'    => 'brackets',      'regexp' =>'/Brackets\/([0-9.]*)/u' ],
        [ 'name' => 'iWeb',                 'id'    => 'iweb',      'regexp' =>'/(?:^| )iWeb\/([0-9])/u' ],
        [ 'name' => 'Microsoft FrontPage',  'id'    => 'frontpage',      'regexp' =>'/MS ?FrontPage[ \/]([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'W3C Amaya',            'id'    => 'amaya',      'regexp' =>'/amaya\/([0-9.]*)/u' ],
        [ 'name' => 'IBM WebSphere Homepage Builder', 'id' => 'websphere', 'regexp' =>'/IBM WebSphere Homepage Builder V([0-9.]*)/u' ],
    ],

    Constants\BrowserType::APP_DOWNLOAD => [
        [ 'name' => 'Download Manager',     'id'    => 'download',      'regexp' =>'/AndroidDownloadManager\//u' ],
        [ 'name' => 'Tanso Download Manager',     'id'    => 'tansodl',      'regexp' =>'/TansoDL/u' ],
    ],

    Constants\BrowserType::APP_GAME => [
        [ 'name' => 'EA Origin',            'id'    => 'origin',      'regexp' =>'/Origin\/([0-9.]*)/u' ],
        [ 'name' => 'SecondLife',           'id'    => 'secondlife',      'regexp' =>'/SecondLife\/([0-9.]*)/u' ],
        [ 'name' => 'Valve Steam',          'id'    => 'valve',      'regexp' =>'/Valve Steam/u' ],
        [ 'name' => 'Raptr',                'id'    => 'raptr',      'regexp' =>'/Raptr/u' ],
    ],

    Constants\BrowserType::APP => [
        [ 'name' => 'AliPay',               'id'    => 'alipay',      'regexp' =>'/AlipayClient\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => 'Cooliris',             'id'    => 'cooliris',      'regexp' =>'/Cooliris\/([0-9.]*)/u' ],
        [ 'name' => 'Google Earth',         'id'    => 'google',      'regexp' =>'/Google Earth\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Google Desktop',       'id'    => 'google',      'regexp' =>'/Google Desktop\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Leechcraft',           'id'    => 'leechcraft',      'regexp' =>'/Leechcraft(?:\/([0-9.]*))?/u', 'details' => 2 ],
        [ 'name' => 'Lotus Expeditor',      'id'    => 'expeditor',      'regexp' =>'/Gecko Expeditor ([0-9.]*)/u', 'details' => 3 ],
    ]
];
