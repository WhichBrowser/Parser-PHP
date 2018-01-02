<?php

namespace WhichBrowser\Data;

use WhichBrowser\Constants;

Applications::$BROWSERS = [

    Constants\BrowserType::BROWSER => [

        /* Desktop browsers */
        [ 'name' => '115 Browser',          'id'    => '115',      'regexp' =>'/115Browser\/([0-9.]*)/u' ],
        [ 'name' => '115 Chrome',           'id'    => '115',      'regexp' =>'/115Chrome\/([0-9.]*)/u' ],
        [ 'name' => '126 Browser',          'id'    => '126',      'regexp' =>'/126BROWSER/u' ],
        [ 'name' => '2345 Explorer',        'id'    => '2345',      'regexp' =>'/2345Explorer\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => '2345 Explorer',        'id'    => '2345',      'regexp' =>'/2345Explorer v([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => '2345 Chrome',          'id'    => '2345',      'regexp' =>'/2345chrome v([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => '360 Extreme Explorer', 'id'    => 'qihu',      'regexp' =>'/QIHU 360EE/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => '360 Safe Explorer',    'id'    => 'qihu',      'regexp' =>'/QIHU 360SE/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => '7Star',                'id'    => '7star',      'regexp' =>'/7Star\/([0-9.]*)/u' ],                                                                // see: http://www.qixing123.com
        [ 'name' => 'ABrowse',              'id'    => 'abrowse',      'regexp' =>'/A[Bb]rowse ([0-9.]*)/u' ],                                                            // browser for the Syllable OS
        [ 'name' => 'Abrowser',             'id'    => 'abrowse',      'regexp' =>'/Abrowser\/([0-9.]*)/u' ],                                                             // unbranded version of Firefox
        [ 'name' => 'Acorn Browse',         'id'    => 'acorn',      'regexp' =>'/Acorn Browse ([0-9.]+)/u'  ],
        [ 'name' => 'Acorn Browse',         'id'    => 'acorn',      'regexp' =>'/Acorn Phoenix ([0-9.]+)/u'  ],
        [ 'name' => 'Acoo Browser',         'id'    => 'acoo',       'regexp' =>'/Acoo Browser/u' ],
        [ 'name' => 'AOL Desktop',          'id'    => 'aol',      'regexp' =>'/AOL ([0-9.]*); AOLBuild/i' ],
        [ 'name' => 'AOL Browser',          'id'    => 'america',      'regexp' =>'/America Online Browser (?:[0-9.]*); rev([0-9.]*);/i' ],
        [ 'name' => 'Arachne',              'id'    => 'arachne',      'regexp' =>'/xChaos_Arachne\/[0-9]\.([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],       // see: www.glennmcc.org
        [ 'name' => 'Arora',                'id'    => 'arora',      'regexp' =>'/[Aa]rora\/([0-9.]*)/u' ],                                                             // see: www.arora-browser.org
        [ 'name' => 'AWeb',                 'id'    => 'aweb',      'regexp' =>'/Amiga-AWeb(?:\/([0-9.]*))?/u' ],
        [ 'name' => 'AvantGo',              'id'    => 'avant',      'regexp' =>'/AvantGo ([0-9.]+)/u' ],
        [ 'name' => 'Avant Browser',        'id'    => 'avant',      'regexp' =>'/Avant Browser/u' ],
        [ 'name' => 'Avant Browser',        'id'    => 'avant',      'regexp' =>'/Avant TriCore/u' ],
        [ 'name' => 'Avast SafeZone',       'id'    => 'asw',      'regexp' =>'/ASW\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Aviator',              'id'    => 'aviator',      'regexp' =>'/Aviator\/([0-9.]*)/u', 'details' => 1 ],                                              // see: https://github.com/WhiteHatSecurity/Aviator
        [ 'name' => 'Baidu Browser',        'id'    => 'flyflow',      'regexp' =>'/FlyFlow\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Baidu Browser',        'id'    => 'bdbrowser',      'regexp' =>'/bdbrowser\/([0-9.]*)/i' ],
        [ 'name' => 'Baidu Browser',        'id'    => 'bdbrowser',      'regexp' =>'/bdbrowser_i18n\/([0-9.]*)/i' ],
        [ 'name' => 'Baidu Spark',          'id'    => 'bdspark',      'regexp' =>'/BDSpark\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Beamrise',             'id'    => 'beamrise',      'regexp' =>'/Beamrise\/([0-9.]*)/u' ],                                                             // see: http://beamrise.com
        [ 'name' => 'Black Wren',           'id'    => 'blackwren',      'regexp' =>'/BlackWren\/([0-9.]*)/u', 'details' => 2 ],                                            // see: https://github.com/conmarap/jetbrowser
        [ 'name' => 'Brave',                'id'    => 'brave',      'regexp' =>'/brave\/([0-9.]*)/u' ],
        [ 'name' => 'Byffox',               'id'    => 'byffox',      'regexp' =>'/Byffox\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Camino',               'id'    => 'camino',      'regexp' =>'/Camino\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Canure',               'id'    => 'canure',      'regexp' =>'/Canure\/([0-9.]*)/u', 'details' => 3 ],                                               // see: http://canure.weebly.com/index.html
        [ 'name' => 'Charon',               'id'    => 'charon',      'regexp' =>'/Charon/' ],                                                                           // see: http://www.vitanuova.com/inferno/man/1/charon.html
        [ 'name' => 'ChromePlus',           'id'    => 'chromeplus',      'regexp' =>'/ChromePlus(?:\/([0-9.]*))?$/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'CometBird',            'id'    => 'cometbird',      'regexp' =>'/CometBird\/([0-9.]*)/u' ],                                                            // see: http://www.cometbird.com
        [ 'name' => 'Comodo Dragon',        'id'    => 'comodo',      'regexp' =>'/Comodo_Dragon\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Comodo Dragon',        'id'    => 'dragon',      'regexp' =>'/Dragon\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Comodo IceDragon',     'id'    => 'dragon',      'regexp' =>'/IceDragon\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Conkeror',             'id'    => 'conkeror',      'regexp' =>'/[Cc]onkeror\/([0-9.]*)/u' ],
        [ 'name' => 'CoolNovo',             'id'    => 'coolnovo',      'regexp' =>'/(?:CoolNovo|CoolNovoChromePlus)\/([0-9.]*)/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Cunaguaro',            'id'    => 'cunaguaro',      'regexp' =>'/Cunaguaro\/([0-9.]*)/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Cyberfox',             'id'    => 'cyberfox',      'regexp' =>'/Cyberfox\/([0-9.]*)/u', 'details' => 2 ],                                             // see: https://cyberfox.8pecxstudios.com
        [ 'name' => 'Daedalus',             'id'    => 'daedalus',      'regexp' =>'/Daedalus ([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Dillo',                'id'    => 'dillo',      'regexp' =>'/Dillo\/([0-9.]*)/u' ],                                                                // see: http://www.dillo.org
        [ 'name' => 'Doga Rhodonit',        'id'    => 'rhodonit',      'regexp' =>'/DogaRhodonit/u' ],
        [ 'name' => 'EudoraWeb',            'id'    => 'eudoraweb',      'regexp' =>'/EudoraWeb ([0-9.]*)/u' ],
        [ 'name' => 'Flock',                'id'    => 'flock',      'regexp' =>'/Flock\/([0-9.]*)/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Galeon',               'id'    => 'galeon',      'regexp' =>'/Galeon\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => 'GNOME Web',            'id'    => 'epiphany',      'regexp' =>'/Epiphany\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'IBrowse',              'id'    => 'ibrowse',      'regexp' =>'/IBrowse[\/ ]([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'iCab',                 'id'    => 'icab',      'regexp' =>'/iCab(?: J)?[\/ ](?:Pre)?([0-9.]*)/u' ],
        [ 'name' => 'Iceape',               'id'    => 'iceape',      'regexp' =>'/Iceape\/([0-9.]*)/u' ],
        [ 'name' => 'IceCat',               'id'    => 'icecat',      'regexp' =>'/IceCat[ \/]([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                   // see: https://www.gnu.org/software/gnuzilla/
        [ 'name' => 'Iceweasel',            'id'    => 'iceweasel',      'regexp' =>'/Iceweasel\/([0-9.]*)/iu', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Iridium',              'id'    => 'iridium',      'regexp' =>'/Iridium\/([0-9.]*)/u', 'details' => 2 ],                                                 // see: http://www.srware.net/en/software_srware_iron.php
        [ 'name' => 'Iron',                 'id'    => 'iron',      'regexp' =>'/Iron\/([0-9.]*)/u', 'details' => 2 ],                                                 // see: http://www.srware.net/en/software_srware_iron.php
        [ 'name' => 'Kazehakase',           'id'    => 'kazehakase',      'regexp' =>'/Kazehakase\/([0-9.]*)/u' ],                                                           // see: http://kazehakase.osdn.jp
        [ 'name' => 'KChrome',              'id'    => 'kchrome',      'regexp' =>'/KChrome\/([0-9.]*)/u', 'details' => 3 ],                                              // see: http://www.kchrome.com
        [ 'name' => 'K-Meleon',             'id'    => 'meleon',      'regexp' =>'/K-Meleon\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                    // see: http://kmeleonbrowser.org
        [ 'name' => 'LieBao',               'id'    => 'lbbrowser',      'regexp' =>'/LBBROWSER/u' ],                                                                       // see: http://www.liebao.cn
        [ 'name' => 'Lobo',                 'id'    => 'lobo',      'regexp' =>'/Lobo\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                        // see: http://sourceforge.net/projects/xamj/files/Lobo%20Browser/
        [ 'name' => 'Lunascape',            'id'    => 'lunascape',      'regexp' =>'/ Lunascape[\/| ]([0-9.]*)/u', 'details' => 3 ],                                        // see: http://www.lunascape.tv
        [ 'name' => 'Naenara',              'id'    => 'naenara',      'regexp' =>'/NaenaraBrowser\/([0-9.]*)/u', 'details' => 2 ],                                       // Firefox based browser used with Red Star OS
        [ 'name' => 'Maxthon',              'id'    => 'mxbrowser',      'regexp' =>'/MxBrowser\/([0-9.]*)/u' ],
        [ 'name' => 'Maxthon',              'id'    => 'mxbrowser',      'regexp' =>'/MxBrowser-iPhone\/([0-9.]*)/u' ],
        [ 'name' => 'MixShark',             'id'    => 'mixshark',      'regexp' =>'/MixShark\/([0-9.]*)/u' ],                                                             // see: http://terbaddo.free.fr/mixshark.php
        [ 'name' => 'mlbrowser',            'id'    => 'mlbrowser',      'regexp' =>'/mlbrowser/u' ],                                                                       // see: https://github.com/Topguy/mlbrowser
        [ 'name' => 'NetPositive',          'id'    => 'netpositive',      'regexp' =>'/NetPositive\/([0-9.]*)/u' ],
        [ 'name' => 'Origyn',               'id'    => 'origyn',      'regexp' =>'/Origyn Web Browser/u' ],
        [ 'name' => 'Odyssey',              'id'    => 'owb',      'regexp' =>'/OWB\/([0-9.]*)/u' ],
        [ 'name' => 'Orca',                 'id'    => 'orca',      'regexp' =>'/Orca\/([0-9.]*)/u' ],
        [ 'name' => 'Oregano',              'id'    => 'oregano',      'regexp' =>'/Oregano ([0-9.]*)/u' ],                                                               // see: http://www.xat.nl/en/riscos/sw/oregano/
        [ 'name' => 'Otter',                'id'    => 'otter',      'regexp' =>'/Otter(?: Browser)?\/([0-9.]*)/u' ],                                                   // see: https://otter-browser.org
        [ 'name' => 'Pale Moon',            'id'    => 'palemoon',      'regexp' =>'/Pale[mM]oon\/([0-9.]*)/u' ],                                                          // see: https://www.palemoon.org
        [ 'name' => 'Qihoo 360',            'id'    => 'qihu',      'regexp' =>'/QIHU THEWORLD/u' ],
        [ 'name' => 'QtWeb',                'id'    => 'qtweb',      'regexp' =>'/QtWeb Internet Browser\/([0-9.]*)/u' ],
        [ 'name' => 'QupZilla',             'id'    => 'qupzilla',      'regexp' =>'/QupZilla\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'rekonq',               'id'    => 'rekonq',      'regexp' =>'/rekonq(?:\/([0-9.]*))?/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Ryouko',               'id'    => 'ryouko',      'regexp' =>'/Ryouko\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                      // see: https://github.com/foxhead128/ryouko
        [ 'name' => 'SaaYaa Explorer',      'id'    => 'saayaa',      'regexp' =>'/SaaYaa/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Sleipnir',             'id'    => 'sleipnir',      'regexp' =>'/Sleipnir\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => 'Sogou Explorer',       'id'    => 'metasr',      'regexp' =>'/SE 2.X MetaSr/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Stainless',            'id'    => 'stainless',      'regexp' =>'/Stainless\/([0-9.]*)/u' ],                                                            // see: http://www.stainlessapp.com
        [ 'name' => 'SunChrome',            'id'    => 'sunchrome',      'regexp' =>'/SunChrome\/([0-9.]*)/u' ],
        [ 'name' => 'Superbird',            'id'    => 'superbird',      'regexp' =>'/Super[Bb]ird\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Swing Browser',        'id'    => 'swing',      'regexp' =>'/Swing(?:\(And\))?\/([0-9.]*)/u', 'details' => 3 ],                                    // see: http://swing-browser.com
        [ 'name' => 'Tencent Traveler',     'id'    => 'tencent',      'regexp' =>'/TencentTraveler ([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'TenFourFox',           'id'    => 'tenfourfox',      'regexp' =>'/TenFourFox\//u' ],
        [ 'name' => 'The World',            'id'    => 'theworld',      'regexp' =>'/TheWorld(?: ([0-9.]*))?/u' ],
        [ 'name' => 'Tungsten Browser',     'id'    => 'tungsten',      'regexp' =>'/TungstenBrowser\/([0-9.]*)/u' ],
        [ 'name' => 'Vivaldi',              'id'    => 'vivaldi',      'regexp' =>'/Vivaldi\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Voyager',              'id'    => 'voyager',      'regexp' =>'/AmigaVoyager\/([0-9.]*)/u' ],
        [ 'name' => 'Waterfox',             'id'    => 'waterfox',      'regexp' =>'/Waterfox\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Yandex Browser',       'id'    => 'yabrowser',      'regexp' =>'/YaBrowser\/([0-9.]*)/u', 'details' => 2 ],

        /* Mobile browsers */
        [ 'name' => '1Browser',             'id'    => '1password',      'regexp' =>'/1Password\/([0-9.]*)/u' ],
        [ 'name' => '2345 Browser',         'id'    => '2345',      'regexp' =>'/Mb2345Browser\/([0-9.]*)/u' ],
        [ 'name' => '3G Explorer',          'id'    => '3g explorer',      'regexp' =>'/3G Explorer\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => '4G Explorer',          'id'    => '4g explorer',      'regexp' =>'/4G Explorer\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => 'Atomic',               'id'    => 'atomiclite',      'regexp' =>'/AtomicLite\/([0-9.]*)/u' ],                                                           // see: http://atomicwebbrowser.com
        [ 'name' => 'AU',                   'id'    => 'au',      'regexp' =>'/(?:^| )AU(?:.Browser)?\/([0-9.]+)/u' ],
        [ 'name' => 'Awakening',            'id'    => 'awakening',      'regexp' =>'/Awakening Browser\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Baidu Browser',        'id'    => 'baidu',      'regexp' =>'/M?BaiduBrowser\/([0-9.]*)/i' ],
        [ 'name' => 'Baidu Browser',        'id'    => 'bdmobile',      'regexp' =>'/BdMobile\/([0-9.]*)/i' ],
        [ 'name' => 'Baidu Browser',        'id'    => 'bidu',      'regexp' =>'/BIDUBrowser[ \/]([0-9.]*)/u' ],
        [ 'name' => 'Baidu Browser',        'id'    => 'baidu',      'regexp' =>'/BaiduHD\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Baidu Browser',        'id'    => 'baiduboxapp',      'regexp' =>'/baiduboxapp\/([0-9.]*)/i' ],
        [ 'name' => 'Baidu Browser',        'id'    => 'browser',      'regexp' =>'/ browser\/([0-9.]*) \(; P1/i' ],
        [ 'name' => 'Blazer',               'id'    => 'blazer',      'regexp' =>'/Blazer\/([0-9.]*)/u' ],
        [ 'name' => 'CM Browser',           'id'    => 'acheetahi',      'regexp' =>'/ACHEETAHI\//u' ],
        [ 'name' => 'Cornowser',            'id'    => 'cornowser',      'regexp' =>'/Cornowser\/([0-9.]*)/u' ],
        [ 'name' => 'Cool Market',          'id'    => 'coolmarket',      'regexp' =>'/CoolMarket\/([0-9.]*)/u' ],
        [ 'name' => 'CuteBrowser',          'id'    => 'cute',      'regexp' =>'/CuteBrowser\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Digia @Web',           'id'    => 'digia',      'regexp' =>'/Digia @Web\/([0-9.]*)/u' ],
        [ 'name' => 'Doris',                'id'    => 'doris',      'regexp' =>'/Doris\/([0-9.]*)/u' ],
        [ 'name' => 'Dorothy',              'id'    => 'doroty',      'regexp' =>'/Dorothy$/u' ],
        [ 'name' => 'EMOBILE Browser',      'id'    => 'www browser',      'regexp' =>'/WWW Browser\/ver([0-9.]*)/u' ],
        [ 'name' => 'EUI Browser',          'id'    => 'eui',      'regexp' =>'/EUI Browser\/[^0-9\s]*([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Go.Web',               'id'    => 'go\.web',      'regexp' =>'/Go\.Web\/([0-9.]*)/u' ],                                                              // used on early Blackberry, by GoAmerica
        [ 'name' => 'Helium',               'id'    => 'helium',      'regexp' =>'/HeliumMobileBrowser\/([0-9.]*)/u' ],
        [ 'name' => 'Huohou Browser',       'id'    => 'huohoubrowser',      'regexp' =>'/HuohouBrowser\/([0-9.]*)/u' ],
        [ 'name' => 'iCab',                 'id'    => 'icab',      'regexp' =>'/iCabMobile\/([0-9.]*)/u' ],
        [ 'name' => 'iLunascape',           'id'    => 'lunascape',      'regexp' =>'/iLunascape\/([0-9.]*)/u', 'details' => 3 ],                                           // see: http://www.lunascape.tv
        [ 'name' => 'InternetSurfboard',    'id'    => 'surfboard',      'regexp' =>'/InternetSurfboard\/([0-9.]*)/u' ],
        [ 'name' => 'iSurf',                'id'    => 'isurf',      'regexp' =>'/iSurf version \/v([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Jig Browser',          'id'    => 'jig browser',      'regexp' =>'/jig browser(?: web| core|9i?)?;? ?([0-9.]+)?/u', 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Jumanji',              'id'    => 'jumanji',      'regexp' =>'/jumanji/u' ],                                                                         // see: jumanji browser ubuntu
        [ 'name' => 'Kiosk',                'id'    => 'kiosk',      'regexp' =>'/Kiosk\/([0-9.]*)/u' ],                                                                // see: http://www.kioskbrowser.net
        [ 'name' => 'LeBrowser',            'id'    => 'lebrowser',      'regexp' =>'/LeBrowser\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'LieBaoFast',           'id'    => 'liebao',      'regexp' =>'/LieBaoFast\/([0-9.]*)/u' ],                                                           // see: http://www.liebao.cn
        [ 'name' => 'MaCross Mobile',       'id'    => 'macross',      'regexp' =>'/MaCross\/([0-9.]*)/u' ],
        [ 'name' => 'Mammoth',              'id'    => 'mammoth',      'regexp' =>'/Mammoth\/([0-9.]*)/u' ],                                                              // see: https://itunes.apple.com/cn/app/meng-ma-liu-lan-qi/id403760998?mt=8
        [ 'name' => 'mCent Browser',        'id'    => 'mcent',      'regexp' =>'/mCent\/([0-9.]*)/u' ],
        [ 'name' => 'Motorola Internet Browser', 'id'    => 'mib',      'regexp' =>'/MIB\/([0-9.]*)/u' ],
        [ 'name' => 'Motorola Internet Browser', 'id'    => 'mib',      'regexp' =>'/MIB([0-9.]+)\//u' ],
        [ 'name' => 'Motorola Internet Browser', 'id'    => 'cmcs',      'regexp' =>'/Browser\/CMCS([0-9.]*)/u' ],
        [ 'name' => 'Motorola WebKit',      'id'    => 'motorola',      'regexp' =>'/MotorolaWebKit(?:\/([0-9.]*))?/u', 'details' => 3 ],
        [ 'name' => 'NetFront Life Browser', 'id'    => 'netfrontlife',      'regexp' =>'/NetFrontLifeBrowser\/([0-9.]*)/u' ],
        [ 'name' => 'OneBrowser',           'id'    => 'onebrowser',      'regexp' =>'/OneBrowser\/([0-9.]*)/u' ],
        [ 'name' => 'PocketLink',           'id'    => 'plink',      'regexp' =>'/PLink ([0-9.]+)/iu', 'details' => 2 ],
        [ 'name' => 'Polaris',              'id'    => 'polaris',      'regexp' =>'/Polaris[\/ ]v?([0-9.]*)/iu', 'details' => 2 ],
        [ 'name' => 'Polaris',              'id'    => 'polaris',      'regexp' =>'/POLARIS([0-9.]+)/u', 'details' => 2 ],
        [ 'name' => 'Openwave',             'id'    => 'openwave',      'regexp' =>'/Open[Ww]ave\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Openwave',             'id'    => 'openwave',      'regexp' =>'/Openwave Mobile Browser ([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Openwave',             'id'    => 'openwave',      'regexp' =>'/Browser\/OpenWave([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Openwave',             'id'    => 'up',      'regexp' =>'/UP\. ?Browser(?:\/([a-z0-9.]*))?/iu', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Openwave',             'id'    => 'km',      'regexp' =>'/KM\.Browser\/([0-9.]+)/iu', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Openwave',             'id'    => 'up',      'regexp' =>'/UP\/([0-9.]+)/u', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Quark Browser',         'id'    => 'quark',      'regexp' =>'/Quark\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => 'SEMC Browser',         'id'    => 'semc',      'regexp' =>'/SEMC-Browser\/([0-9.]*)/u' ],
        [ 'name' => 'STNC HitchHiker' ,     'id'    => 'stnc',      'regexp' =>'/STNC-WTL\/[0-9.]*/u' ],
        [ 'name' => 'Sogou Mobile',         'id'    => 'sogou',      'regexp' =>'/SogouMobileBrowser\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Swing Browser',        'id'    => 'swing',      'regexp' =>'/Swing\(And\)\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => 'Symphony',             'id'    => 'symphony',      'regexp' =>'/Symphony ([0-9.]+)$/u' ],
        [ 'name' => 'TinY',                 'id'    => 'ucpro',      'regexp' =>'/ucpro\/([0-9.]+)/iu' ],
        [ 'name' => 'WebLite',              'id'    => 'weblite',      'regexp' =>'/WebLite\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],

        /* Television browsers */
        [ 'name' => 'AltiBrowser',          'id'    => 'alti',      'regexp' =>'/AltiBrowser\/([0-9.]*)/i' ],
        [ 'name' => 'Aplix',                'id'    => 'aplix',      'regexp' =>'/Aplix_SANYO_browser\/([0-9](?:.[0-9.]+)?)/u' ],                                    // browser for the Sega Saturn
        [ 'name' => 'AwoX',                 'id'    => 'awox',      'regexp' =>'/AwoX(?:\/([0-9.]*))? Browser/i' ],
        [ 'name' => 'Isis',                 'id'    => 'browserserver',      'regexp' =>'/BrowserServer/u' ],
        [ 'name' => 'Isis',                 'id'    => 'isis',      'regexp' =>'/ISIS\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Spyglass',             'id'    => 'spyglass',      'regexp' =>'/Spyglass ([0-9.]+); OpenTV/u' ],
        [ 'name' => 'Oregan Browser',       'id'    => 'oregan',      'regexp' =>'/OreganMediaBrowser(?:\/([0-9.]*))?/u', 'details' => 2 ],
        [ 'name' => 'Viera Browser',        'id'    => 'viera',      'regexp' =>'/Viera\/([0-9.]*)/u' ],
        [ 'name' => 'Zetakey',              'id'    => 'zetakey',      'regexp' =>'/Zetakey Webkit\/([0-9.]*)/u', 'type' => Constants\DeviceType::TELEVISION ],
        [ 'name' => 'Zetakey',              'id'    => 'zetakey',      'regexp' =>'/Zetakey\/([0-9.]*)/u', 'type' => Constants\DeviceType::TELEVISION ],

        /* Gaming browsers */
        [ 'name' => 'Aplix',                'id'    => 'aplix',      'regexp' =>'/Aplix_SEGASATURN_browser\/([0-9](?:.[0-9.]+)?)/u' ],                                    // browser for the Sega Saturn
        [ 'name' => 'Bunjalloo',            'id'    => 'bunjalloo',      'regexp' =>'/Bunjalloo\/([0-9.]*)/u' ],                                                            // browser for the Nintento DS
        [ 'name' => 'Nintendo Web Framework', 'id'    => 'nwf',      'regexp' =>'/NWF\/([0-9.]*)/u', 'details' => 2 ],                                                        // browser for the Sega Dreamcast
        [ 'name' => 'Nuanti Meta',          'id'    => 'nuanti',      'regexp' =>'/Nuanti(?:Meta)?\/([0-9.]*)/u' ],                                                      // browser for the Playstation

        /* Other browsers */
        [ 'name' => 'Wear Internet Browser','id'    => 'wib',      'regexp' =>'/WIB\/([0-9.]*)/u' ],

        /* PDF renderers */
        [ 'name' => 'Prince',               'id'    => 'prince',      'regexp' =>'/Prince\/([0-9.]*)/u' ],

        /* Unsorted */
        [ 'name' => 'Demobrowser',          'id'    => 'demobrowser',      'regexp' =>'/demobrowser\/([0-9.]*)/u' ],
        [ 'name' => 'Dooble',               'id'    => 'dooble',      'regexp' =>'/Dooble(?:\/([0-9.]*))?/u' ],                                                          // see: http://dooble.sourceforge.net
        [ 'name' => 'DWB',                  'id'    => 'dwb',      'regexp' =>'/dwb(?:-hg)?(?:\/([0-9.]*))?/u' ],
        [ 'name' => 'EVM Browser',          'id'    => 'evm',      'regexp' =>'/EVMBrowser\/([0-9.]*)/u' ],
        [ 'name' => 'FireWeb',              'id'    => 'fireweb',      'regexp' =>'/FireWeb\/([0-9.]*)/u' ],
        [ 'name' => 'Hive Explorer',        'id'    => 'hive',      'regexp' =>'/HiveE/u' ],
        [ 'name' => 'Intermec Browser',     'id'    => 'intermec',      'regexp' =>'/Intermec\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Phantom',              'id'    => 'phantom',      'regexp' =>'/Phantom\/V([0-9.]*)/u' ],
        [ 'name' => 'QtCreator',            'id'    => 'qt',      'regexp' =>'/QtCreator\/([0-9.]*)/u' ],
        [ 'name' => 'QtQmlViewer',          'id'    => 'qt',      'regexp' =>'/QtQmlViewer/u' ],
        [ 'name' => 'QtMiniBrowser',        'id'    => 'qt',      'regexp' =>'/QtMiniBrowser\/([0-9.]*)/u' ],
        [ 'name' => 'QtTestBrowser',        'id'    => 'qt',      'regexp' =>'/QtTestBrowser\/([0-9.]*)/u' ],
        [ 'name' => 'Roccat',               'id'    => 'roccat',      'regexp' =>'/Roccat\/([0-9]\.[0-9.]*)/u' ],
        [ 'name' => 'Raven for Mac',        'id'    => 'raven',      'regexp' =>'/Raven for Mac\/([0-9.]*)/u' ],
        [ 'name' => 'RockMelt',             'id'    => 'rockmelt',      'regexp' =>'/RockMelt\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Scope',                'id'    => 'scope',      'regexp' =>'/Scope\/([0-9.]*)/u', 'details' => 2 ],                                                // see: http://www.programmer.co.jp/scope.shtml
        [ 'name' => 'SlimBoat',             'id'    => 'slim',      'regexp' =>'/SlimBoat\/([0-9.]*)/u' ],
        [ 'name' => 'SlimBrowser',          'id'    => 'slim',      'regexp' =>'/SlimBrowser(?:\/([0-9.]*))?/u' ],
        [ 'name' => 'SMBrowser',            'id'    => 'smbrowser',      'regexp' =>'/SMBrowser/u' ],
        [ 'name' => 'Snowshoe',             'id'    => 'snowshoe',      'regexp' =>'/Snowshoe\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Sputnik',              'id'    => 'sputnik',      'regexp' =>'/Sputnik\/([0-9.]*)/iu', 'details' => 3 ],
        [ 'name' => 'Surf',                 'id'    => 'surf',      'regexp' =>'/Surf\/([0-9.]*)/u' ],
        [ 'name' => 'TaoBrowser',           'id'    => 'tao',      'regexp' =>'/TaoBrowser\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'TaomeeBrowser',        'id'    => 'tao',      'regexp' =>'/TaomeeBrowser\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'TazWeb',               'id'    => 'taz',      'regexp' =>'/TazWeb/u' ],
        [ 'name' => 'Uzbl',                 'id'    => 'uzbl',      'regexp' =>'/^Uzbl/u' ],
        [ 'name' => 'Villanova',            'id'    => 'villanova',      'regexp' =>'/Villanova\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => 'Vimb',                 'id'    => 'vimb',      'regexp' =>'/vimb\/([0-9.]*)/u' ],
        [ 'name' => 'WADA Browser',         'id'    => 'wada',      'regexp' =>'/WadaBrowser\/([0-9.]*)/u' ],
        [ 'name' => 'Wavelink Velocity',    'id'    => 'wavelink',      'regexp' =>'/Wavelink Velocity Browser\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'WebRender',            'id'    => 'webrender',      'regexp' =>'/WebRender/u' ],
        [ 'name' => 'Webster',              'id'    => 'webster',      'regexp' =>'/Webster ([0-9.]*)/u' ],
        [ 'name' => 'Wyzo',                 'id'    => 'wyzo',      'regexp' =>'/Wyzo\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => 'Yelang',               'id'    => 'yelang',      'regexp' =>'/Yelang\/([0-9.]*)/u', 'details' => 3 ],                           // see: wellgo.org
        [ 'name' => 'YRC Weblink',          'id'    => 'yrcweb',      'regexp' =>'/YRCWeblink\/([0-9.]*)/u' ],
        [ 'name' => '冲浪浏览器',             'id'    => 'surf',      'regexp' =>'/CMSurfClient-Android/u' ],
    ],

    Constants\BrowserType::BROWSER_TEXT => [
        [ 'name' => 'CERN LineMode',        'id'    => 'linemode',      'regexp' =>'/CERN-LineMode\/([0-9.]*)/u' ],
        [ 'name' => 'Lynx',                 'id'    => 'lynx',      'regexp' =>'/Lynx\/([0-9.]*)/u' ],
        [ 'name' => 'Lynx',                 'id'    => 'lynx',      'regexp' =>'/Lynx \(textmode\)/u' ],
        [ 'name' => 'ELinks',               'id'    => 'links',      'regexp' =>'/E[Ll]inks(?:\/| \()([0-9.]*[0-9])/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Links',                'id'    => 'links',      'regexp' =>'/Links \(([0-9.]*)/u' ],
        [ 'name' => 'w3m',                  'id'    => 'w3m',      'regexp' =>'/w3m\/([0-9.]*)/u' ],
    ],

    Constants\BrowserType::UNKNOWN => [
        [ 'name' => 'PhantomJS',            'id'    => 'phantom',      'regexp' =>'/PhantomJS\/([0-9.]*)/u' ],
        [ 'name' => 'Nimbus',               'id'    => 'nimbus',      'regexp' =>'/Nimbus\/([0-9.]*)/u' ],
        [ 'name' => 'McAfee Web Gateway',   'id'    => 'Webwasher',      'regexp' =>'/Webwasher\/([0-9.]*)/u' ],
        [ 'name' => 'Open Sankoré',         'id'    => 'sankore',      'regexp' =>'/Open-Sankore\/([0-9.]*)/u', 'type' => Constants\DeviceType::WHITEBOARD ],
        [ 'name' => 'Adapi',                'id'    => 'adapi',      'regexp' =>'/ ADAPI\/([0-9.]*)/u', 'hidden' => true, 'type' => Constants\DeviceType::SIGNAGE ],
        [ 'name' => 'BrightSign',           'id'    => 'brightsign',      'regexp' =>'/BrightSign\/([0-9.]*)/u', 'type' => Constants\DeviceType::SIGNAGE ],
        [ 'name' => 'Coship MMCP',          'id'    => 'coship',      'regexp' =>'/Coship_MMCP_([0-9.]*)/u', 'type' => Constants\DeviceType::SIGNAGE ],
    ]
];
