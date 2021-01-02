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
        [ 'name' => '37abc Browser',        'id'    => '37abc',       'regexp' => '/ 37abc\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => '360 Extreme Explorer', 'id'    => 'qihu',      'regexp' =>'/QIHU 360EE/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => '1st Browser',          'id'    => '1stbrowser',  'regexp' => '/1stBrowser\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => '360 Safe Explorer',    'id'    => 'qihu',      'regexp' =>'/QIHU 360SE/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => '7Star',                'id'    => '7star',      'regexp' =>'/7Star\/([0-9.]*)/u' ],                                                                // see: http://www.qixing123.com
        [ 'name' => 'ABrowse',              'id'    => 'abrowse',      'regexp' =>'/A[Bb]rowse ([0-9.]*)/u' ],                                                            // browser for the Syllable OS
        [ 'name' => 'Abrowser',             'id'    => 'abrowse',      'regexp' =>'/Abrowser\/([0-9.]*)/u' ],                                                             // unbranded version of Firefox
        [ 'name' => 'Acorn Browse',         'id'    => 'acorn',      'regexp' =>'/Acorn Browse ([0-9.]+)/u'  ],
        [ 'name' => 'Acorn Browse',         'id'    => 'acorn',      'regexp' =>'/Acorn Phoenix ([0-9.]+)/u'  ],
        [ 'name' => 'Acoo Browser',         'id'    => 'acoo',       'regexp' =>'/Acoo Browser/u' ],
        [ 'name' => 'Amigo Browser',        'id'    => 'amigo',       'regexp' => '/ Amigo\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                       // see: https://amigo.mail.ru/
        [ 'name' => 'AOL Desktop',          'id'    => 'aol',      'regexp' =>'/AOL ([0-9.]*); AOLBuild/i' ],
        [ 'name' => 'AOL Browser',          'id'    => 'america',      'regexp' =>'/America Online Browser (?:[0-9.]*); rev([0-9.]*);/i' ],
        [ 'name' => 'APUS Browser',         'id'    => 'apus',        'regexp' => '/APUSBrowser\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                  // see: https://www.apusapps.com/en/browser/
        [ 'name' => 'Arachne',              'id'    => 'arachne',      'regexp' =>'/xChaos_Arachne\/[0-9]\.([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],       // see: www.glennmcc.org
        [ 'name' => 'Arora',                'id'    => 'arora',      'regexp' =>'/[Aa]rora\/([0-9.]*)/u' ],                                                             // see: www.arora-browser.org
        [ 'name' => 'AWeb',                 'id'    => 'aweb',      'regexp' =>'/Amiga-AWeb(?:\/([0-9.]*))?/u' ],
        [ 'name' => 'AvantGo',              'id'    => 'avant',      'regexp' =>'/AvantGo ([0-9.]+)/u' ],
        [ 'name' => 'Avant Browser',        'id'    => 'avant',      'regexp' =>'/Avant Browser/u' ],
        [ 'name' => 'Avant Browser',        'id'    => 'avant',      'regexp' =>'/Avant TriCore/u' ],
        [ 'name' => 'Avast SafeZone',       'id'    => 'asw',      'regexp' =>'/ASW\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'AVG Secure Browser',   'id'    => 'avg',      'regexp' =>'/ AVG\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                            // see: https://www.avg.com/secure-browser
        [ 'name' => 'Aviator',              'id'    => 'aviator',      'regexp' =>'/Aviator\/([0-9.]*)/u', 'details' => 1 ],                                              // see: https://github.com/WhiteHatSecurity/Aviator
        [ 'name' => 'Avira Scout',          'id'    => 'avira',       'regexp' => '/AviraScout\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                   // see: https://www.avira.com/en/avira-scout
        [ 'name' => 'Baidu Browser',        'id'    => 'flyflow',      'regexp' =>'/FlyFlow\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Baidu Browser',        'id'    => 'bdbrowser',      'regexp' =>'/bdbrowser\/([0-9.]*)/i' ],
        [ 'name' => 'Baidu Browser',        'id'    => 'bdbrowser',      'regexp' =>'/bdbrowser_i18n\/([0-9.]*)/i' ],
        [ 'name' => 'Baidu Spark',          'id'    => 'bdspark',      'regexp' =>'/BDSpark\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Basilisk',             'id'    => 'basilisk',    'regexp' => '/ Basilisk\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                    // see: https://basilisk-browser.org/
        [ 'name' => 'Beamrise',             'id'    => 'beamrise',      'regexp' =>'/Beamrise\/([0-9.]*)/u' ],                                                             // see: http://beamrise.com
        [ 'name' => 'Beonex',               'id'    => 'beonex',      'regexp' =>'/Beonex\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                        // see: https://www.beonex.com/
        [ 'name' => 'Black Wren',           'id'    => 'blackwren',      'regexp' =>'/BlackWren\/([0-9.]*)/u', 'details' => 2 ],                                            // see: https://github.com/conmarap/jetbrowser
        [ 'name' => 'Black Hawk',           'id'    => 'blackhawk',   'regexp' => '/BlackHawk\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                   // see: http://www.netgate.sk/blackhawk/help/welcome-to-blackhawk-web-browser.html
        [ 'name' => 'Bolt Browser',         'id'    => 'bolt',        'regexp' => '/ Bolt\/([0-9.]*)/i', 'type' => Constants\DeviceType::DESKTOP ],                        // see: http://www.boltbrowser.com/
        [ 'name' => 'Blackbird',            'id'    => 'blackbird',      'regexp' =>'/Blackbird\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                  // see: http://www.blackbirdbrowser.com/
        [ 'name' => 'Brave',                'id'    => 'brave',      'regexp' =>'/brave\/([0-9.]*)/u' ],
        [ 'name' => 'Brisk Bard',           'id'    => 'brisk',       'regexp' => '/BriskBard\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                    // see: https://www.briskbard.com/index.php?lang=en
        [ 'name' => 'BrowseX',              'id'    => 'browsex',     'regexp' => '/BrowseX \(([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                     // see: https://dev.pdqi.com/fossil/browsex/doc/tip/index.html
        [ 'name' => 'Browzar',              'id'    => 'browzar',     'regexp' => '/Browzar/u', 'type' => Constants\DeviceType::DESKTOP ],                                 // see: http://browzar.com/
        [ 'name' => 'Byffox',               'id'    => 'byffox',      'regexp' =>'/Byffox\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Camino',               'id'    => 'camino',      'regexp' =>'/Camino\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Canure',               'id'    => 'canure',      'regexp' =>'/Canure\/([0-9.]*)/u', 'details' => 3 ],                                               // see: http://canure.weebly.com/index.html
        [ 'name' => 'CCleaner Browser',     'id'    => 'ccleaner',    'regexp' => '/CCleaner\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                     // see: https://www.ccleaner.com/ccleaner/browser
        [ 'name' => 'Cent Browser',         'id'    => 'cent',        'regexp' => '/ Cent\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                        // see: https://www.centbrowser.com/
        [ 'name' => 'Charon',               'id'    => 'charon',      'regexp' =>'/Charon/' ],                                                                           // see: http://www.vitanuova.com/inferno/man/1/charon.html
        [ 'name' => 'Chedot',               'id'    => 'chedot',      'regexp' => '/ Chedot\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                      // see: http://landing.chedot.com/
        [ 'name' => 'Cheshire',             'id'    => 'cheshire',    'regexp' => '/ Cheshire\/([0-9.A-Z]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Chim Lac',             'id'    => 'chimlac',     'regexp' => '/chimlac_browser\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],              // see: https://chimlac.com.vn/
        [ 'name' => 'Chimera',              'id'    => 'chimera',     'regexp' => '/ Chimera\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'ChromePlus',           'id'    => 'chromeplus',      'regexp' =>'/ChromePlus(?:\/([0-9.]*))?$/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Colibri',              'id'    => 'colibri',     'regexp' => '/Colibri\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                      // see: https://colibri.opqr.co/
        [ 'name' => 'Columbus',             'id'    => 'columbus',      'regexp' =>'/Columbus\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'CometBird',            'id'    => 'cometbird',      'regexp' =>'/CometBird\/([0-9.]*)/u' ],                                                            // see: http://www.cometbird.com
        [ 'name' => 'Comodo Dragon',        'id'    => 'comodo',      'regexp' =>'/Comodo_Dragon\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Comodo Dragon',        'id'    => 'dragon',      'regexp' =>'/Dragon\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Comodo IceDragon',     'id'    => 'dragon',      'regexp' =>'/IceDragon\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Conkeror',             'id'    => 'conkeror',      'regexp' =>'/[Cc]onkeror\/([0-9.]*)/u' ],
        [ 'name' => 'Coc Coc',              'id'    => 'coc',      'regexp' => '/coc_coc_browser\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],              // see: https://coccoc.com/en/
        [ 'name' => 'CoolNovo',             'id'    => 'coolnovo',      'regexp' =>'/(?:CoolNovo|CoolNovoChromePlus)\/([0-9.]*)/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Corom Browser',        'id'    => 'corom',         'regexp' => '/ CoRom\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],                       // see: https://apkpure.com/corom-browser-for-android/com.coccoc.corom
        [ 'name' => 'Crazy Browser',        'id'    => 'crazy',       'regexp' => '/Crazy Browser ([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Crusta',               'id'    => 'crusta',      'regexp' => '/ Crusta\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                       // see: https://github.com/Tarptaeya/Crusta
        [ 'name' => 'Cunaguaro',            'id'    => 'cunaguaro',      'regexp' =>'/Cunaguaro\/([0-9.]*)/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Cyberdog',             'id'    => 'cyberdog',      'regexp' =>'/Cyberdog\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Cyberfox',             'id'    => 'cyberfox',      'regexp' =>'/Cyberfox\/([0-9.]*)/u', 'details' => 2 ],                                             // see: https://cyberfox.8pecxstudios.com
        [ 'name' => 'Daedalus',             'id'    => 'daedalus',      'regexp' =>'/Daedalus ([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Deg-degan',            'id'    => 'degan',       'regexp' => '/Degdegan\/([0-9.]*)/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Demeter',              'id'    => 'demeter',      'regexp' =>'/Demeter\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'DeskBrowse',           'id'    => 'deskbrowse',      'regexp' =>'/DeskBrowse\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Diigo Browser',        'id'    => 'diigo',         'regexp' => '/DiigoBrowser/u', 'type' => Constants\DeviceType::MOBILE ],                            // see: https://apps.apple.com/us/app/diigo-annotator-for-safari/id933773981
        [ 'name' => 'Dillo',                'id'    => 'dillo',      'regexp' =>'/Dillo\/([0-9.]*)/u' ],                                                                // see: http://www.dillo.org
        [ 'name' => 'DocZilla',             'id'    => 'doczilla',      'regexp' =>'/DocZilla\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Doga Rhodonit',        'id'    => 'rhodonit',      'regexp' =>'/DogaRhodonit/u' ],
        [ 'name' => 'DPlus Browser',        'id'    => 'dplus',      'regexp' =>'/ DPlus ([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Elements Browser',     'id'    => 'elements',    'regexp' => '/Elements Browser\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ], 
        [ 'name' => 'EudoraWeb',            'id'    => 'eudoraweb',      'regexp' =>'/EudoraWeb ([0-9.]*)/u' ],
        [ 'name' => 'Falkon',               'id'    => 'falkon',      'regexp' => '/ Falkon\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                      // see: https://www.falkon.org/
        [ 'name' => 'FlameSky',             'id'    => 'flamesky',    'regexp' => '/FlameSky\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                     // see: https://github.com/flameskyofficial/flamesky
        [ 'name' => 'Flock',                'id'    => 'flock',      'regexp' =>'/Flock\/([0-9.]*)/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Framafox',             'id'    => 'framafox',    'regexp' => '/Framafox\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                     // see: https://framakey.org/telecharger/applications-portables-libres#internet
        [ 'name' => 'Freeu Browser',        'id'    => 'freeu',       'regexp' => '/ Free[Uu]\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                    // see: https://play.google.com/store/apps/details?id=com.freeuvpn.android&hl=en
        [ 'name' => 'Galeon',               'id'    => 'galeon',      'regexp' =>'/Galeon\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => 'GlobalMojo',           'id'    => 'globalmojo',      'regexp' =>'/GlobalMojo\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'GNOME Web',            'id'    => 'epiphany',      'regexp' =>'/Epiphany\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'GreenBrowser',         'id'    => 'greenbrowser',      'regexp' =>'/GreenBrowser/u', 'type' => Constants\DeviceType::DESKTOP ],       
        [ 'name' => 'Hola Browser',         'id'    => 'hola',        'regexp' => '/ Hola\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                        // see: https://play.google.com/store/apps/details?id=org.hola&hl=en
        [ 'name' => 'Hydra Browser',        'id'    => 'hydra',      'regexp' =>'/Hydra Browser/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'IBrowse',              'id'    => 'ibrowse',      'regexp' =>'/IBrowse[\/ ]([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'iCab',                 'id'    => 'icab',      'regexp' =>'/iCab(?: J)?[\/ ](?:Pre)?([0-9.]*)/u' ],
        [ 'name' => 'Iceape',               'id'    => 'iceape',      'regexp' =>'/Iceape\/([0-9.]*)/u' ],
        [ 'name' => 'IceCat',               'id'    => 'icecat',      'regexp' =>'/IceCat[ \/]([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                   // see: https://www.gnu.org/software/gnuzilla/
        [ 'name' => 'Icedove',              'id'    => 'icedove',     'regexp' => '/ Icedove\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                     // see: https://wiki.debian.org/Icedove
        [ 'name' => 'Iceweasel',            'id'    => 'iceweasel',      'regexp' =>'/Iceweasel\/([0-9.]*)/iu', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'iRider Browser',       'id'    => 'irider',      'regexp' =>'/iRider ([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Iridium',              'id'    => 'iridium',      'regexp' =>'/Iridium\/([0-9.]*)/u', 'details' => 2 ],                                                 // see: http://www.srware.net/en/software_srware_iron.php
        [ 'name' => 'Iron',                 'id'    => 'iron',      'regexp' =>'/Iron\/([0-9.]*)/u', 'details' => 2 ],                                                 // see: http://www.srware.net/en/software_srware_iron.php
        [ 'name' => 'Kapiko',               'id'    => 'kapiko',      'regexp' => '/ Kapiko\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                      // see: https://sites.google.com/site/kapikoproject/
        [ 'name' => 'Kazehakase',           'id'    => 'kazehakase',      'regexp' =>'/Kazehakase\/([0-9.]*)/u' ],                                                           // see: http://kazehakase.osdn.jp
        [ 'name' => 'KChrome',              'id'    => 'kchrome',      'regexp' =>'/KChrome\/([0-9.]*)/u', 'details' => 3 ],                                              // see: http://www.kchrome.com
        [ 'name' => 'Kinza',                'id'    => 'kinza',       'regexp' => '/ Kinza\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                       // see: https://www.kinza.jp/en/
        [ 'name' => 'KKMAN',                'id'    => 'kkman',       'regexp' => '/ KKman([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                         // see: https://www.kkbox.com/kkman/
        [ 'name' => 'Klondike',             'id'    => 'klondike',    'regexp' => '/Klondike\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Kylo',                 'id'    => 'kylo',        'regexp' => '/ Kylo\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                        // see: http://kylo.tv/
        [ 'name' => 'K-Meleon',             'id'    => 'meleon',      'regexp' =>'/K-Meleon\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                    // see: http://kmeleonbrowser.org
        [ 'name' => 'LBrowser',             'id'    => 'lbrowser',      'regexp' =>'/LBrowser\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ], 
        [ 'name' => 'LieBao',               'id'    => 'lbbrowser',      'regexp' =>'/LBBROWSER/u' ],                                                                       // see: http://www.liebao.cn
        [ 'name' => 'Light',                'id'    => 'light',       'regexp' => '/ Light\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                       // see: https://en.wikipedia.org/wiki/Light_(web_browser)
        [ 'name' => 'Lobo',                 'id'    => 'lobo',      'regexp' =>'/Lobo\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                        // see: http://sourceforge.net/projects/xamj/files/Lobo%20Browser/
        [ 'name' => 'Lolifox',              'id'    => 'lolifox',     'regexp' => '/lolifox\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                      // see: https://ja.wikipedia.org/wiki/Lolifox
        [ 'name' => 'Lovense',              'id'    => 'lovense',     'regexp' => '/Lovense\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                      // see: https://www.lovense.com/cam-model/guides/pc-phone
        [ 'name' => 'Lunascape',            'id'    => 'lunascape',      'regexp' =>'/ Lunascape[\/| ]([0-9.]*)/u', 'details' => 3 ],                                        // see: http://www.lunascape.tv
        [ 'name' => 'Naenara',              'id'    => 'naenara',      'regexp' =>'/NaenaraBrowser\/([0-9.]*)/u', 'details' => 2 ],                                       // Firefox based browser used with Red Star OS
        [ 'name' => 'NetCaptor',            'id'    => 'netcaptor',      'regexp' =>'/NetCaptor ([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                        // see: https://en.wikipedia.org/wiki/NetCaptor
        [ 'name' => 'Madfox',               'id'    => 'madfox',      'regexp' =>'/Madfox\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ], 
        [ 'name' => 'Maxthon',              'id'    => 'mxbrowser',      'regexp' =>'/MxBrowser\/([0-9.]*)/u' ],
        [ 'name' => 'Maxthon',              'id'    => 'mxbrowser',      'regexp' =>'/MxBrowser-iPhone\/([0-9.]*)/u' ],
        [ 'name' => 'Min Browser',          'id'    => 'min',         'regexp' => '/ min\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                         // see: https://minbrowser.github.io/min/
        [ 'name' => 'Mini Browser',         'id'    => 'mini',        'regexp' => '/ MiniBrowser\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                  // see: http://dmkho.tripod.com/mb/index.html
        [ 'name' => 'MixShark',             'id'    => 'mixshark',      'regexp' =>'/MixShark\/([0-9.]*)/u' ],                                                             // see: http://terbaddo.free.fr/mixshark.php
        [ 'name' => 'mlbrowser',            'id'    => 'mlbrowser',      'regexp' =>'/mlbrowser/u' ],                                                                       // see: https://github.com/Topguy/mlbrowser
        [ 'name' => 'Mypal Browser',        'id'    => 'mypal',       'regexp' => '/ Mypal\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                       // see: https://github.com/Feodor2/Mypal
        [ 'name' => 'Multi-Browser XP',     'id'    => 'multixp',      'regexp' =>'/Multi-Browser ([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],  
        [ 'name' => 'NetPositive',          'id'    => 'netpositive',      'regexp' =>'/NetPositive\/([0-9.]*)/u' ],
        [ 'name' => 'Nichrome',             'id'    => 'nichrome',    'regexp' => '/Nichrome\/self\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Origyn',               'id'    => 'origyn',      'regexp' =>'/Origyn Web Browser/u' ],
        [ 'name' => 'Odyssey',              'id'    => 'owb',      'regexp' =>'/OWB\/([0-9.]*)/u' ],
        [ 'name' => 'Open Live Writer',     'id'    => 'live',      'regexp' =>'/Open Live Writer ([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],             // see: http://openlivewriter.org/  
        [ 'name' => 'Orange Browser',       'id'    => 'juzi',      'regexp' =>'/JuziBrowser/u', 'type' => Constants\DeviceType::DESKTOP ],                        // see: http://www.123juzi.com/
        [ 'name' => 'Orca',                 'id'    => 'orca',      'regexp' =>'/Orca\/([0-9.]*)/u' ],
        [ 'name' => 'Oregano',              'id'    => 'oregano',      'regexp' =>'/Oregano ([0-9.]*)/u' ],                                                               // see: http://www.xat.nl/en/riscos/sw/oregano/
        [ 'name' => 'Otter',                'id'    => 'otter',      'regexp' =>'/Otter(?: Browser)?\/([0-9.]*)/u' ],                                                   // see: https://otter-browser.org
        [ 'name' => 'Pale Moon',            'id'    => 'palemoon',      'regexp' =>'/Pale[mM]oon\/([0-9.]*)/u' ],                                                          // see: https://www.palemoon.org
        [ 'name' => 'Patriott Browser',     'id'    => 'patriott',      'regexp' =>'/Patriott\:\:Browser\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],        // see: 	http://madgroup.x10.mx/patriott1.php
        [ 'name' => 'Perk',                 'id'    => 'perk',      'regexp' =>'/ Perk\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                         // see: http://www.perk.com/
        [ 'name' => 'Polarity',             'id'    => 'polarity',      'regexp' =>'/Polarity\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Privacy Browser',      'id'    => 'privacy',     'regexp' => '/PrivacyBrowser\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],               // see: https://www.stoutner.com/privacy-browser/
        [ 'name' => 'Qihoo 360',            'id'    => 'qihu',      'regexp' =>'/QIHU THEWORLD/u' ],
        [ 'name' => 'Qiyu Browser',         'id'    => 'qiyu',        'regexp' => '/Qiyu\/([0-9.]*)/i', 'type' => Constants\DeviceType::DESKTOP ],                         // see: https://apps.apple.com/cn/app/qi-yu-liu-lan-qi/id959447103
        [ 'name' => 'QtWeb',                'id'    => 'qtweb',      'regexp' =>'/QtWeb Internet Browser\/([0-9.]*)/u' ],
        [ 'name' => 'Quick Look',           'id'    => 'quicklook',   'regexp' => '/QuickLook\/([0-9.]*)/u' ],                                                             // see: https://en.wikipedia.org/wiki/Quick_Look
        [ 'name' => 'QupZilla',             'id'    => 'qupzilla',      'regexp' =>'/QupZilla\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Qute Browser',         'id'    => 'qute',        'regexp' => '/qutebrowser\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                  // see: https://github.com/qutebrowser/qutebrowser
        [ 'name' => 'rekonq',               'id'    => 'rekonq',      'regexp' =>'/rekonq(?:\/([0-9.]*))?/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Ryouko',               'id'    => 'ryouko',      'regexp' =>'/Ryouko\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                      // see: https://github.com/foxhead128/ryouko
        [ 'name' => 'Sylera',               'id'    => 'sylera',      'regexp' =>'/Sylera\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                      // Needs to be discovered before SeaMonkey Browser, see: https://ja.wikipedia.org/wiki/Sylera
        [ 'name' => 'SaaYaa Explorer',      'id'    => 'saayaa',      'regexp' =>'/SaaYaa/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'SalamWeb',             'id'    => 'salam',       'regexp' => '/SalamWeb\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                     // see: https://salamweb.com/
        [ 'name' => 'SalamWeb',             'id'    => 'salam',       'regexp' => '/Salam Browser/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Shiira',               'id'    => 'shiira',      'regexp' => '/Shiira/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Sielo Browser',        'id'    => 'sielo',       'regexp' => '/ Sielo\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                       // see: https://github.com/SieloBrowser/sielo-legacy
        [ 'name' => 'SiteKiosk',            'id'    => 'sitekiosk',   'regexp' => '/SiteKiosk ([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                     // see: https://www.provisio.com/web/us/products/windows-kiosk-software-sitekiosk
        [ 'name' => 'Sleipnir',             'id'    => 'sleipnir',      'regexp' =>'/Sleipnir\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => 'Slimjet',              'id'    => 'slimjet',     'regexp' => '/ Slimjet\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                     // see: https://www.slimjet.com/
        [ 'name' => 'Sogou Explorer',       'id'    => 'metasr',      'regexp' =>'/SE 2.X MetaSr/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Sparrow',              'id'    => 'sparrow',      'regexp' =>'/Sparrow\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Sputnik',              'id'    => 'sputnik',     'regexp' => '/SputnikBrowser\/([0-9.]*)/u' ],                                                         // see: https://browser.sputnik.ru/
        [ 'name' => 'Stainless',            'id'    => 'stainless',      'regexp' =>'/Stainless\/([0-9.]*)/u' ],                                                            // see: http://www.stainlessapp.com
        [ 'name' => 'Station Browser',      'id'    => 'station',     'regexp' => '/ Station\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                     // see: https://getstation.com/
        [ 'name' => 'SunChrome',            'id'    => 'sunchrome',      'regexp' =>'/SunChrome\/([0-9.]*)/u' ],
        [ 'name' => 'Sundance',             'id'    => 'sundance',      'regexp' =>'/Sundance\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Sundial',              'id'    => 'sundial',      'regexp' =>'/Sundial\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                      // see: http://www.sundialbrowser.com/
        [ 'name' => 'Superbird',            'id'    => 'superbird',      'regexp' =>'/Super[Bb]ird\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Swiftweasel',          'id'    => 'swiftweasel',      'regexp' =>'/Swiftweasel\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],            // see: http://swiftweasel.tuxfamily.org/
        [ 'name' => 'Swiftfox',             'id'    => 'swiftfox',      'regexp' =>'/Swiftfox/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Swing Browser',        'id'    => 'swing',      'regexp' =>'/Swing(?:\(And\))?\/([0-9.]*)/u', 'details' => 3 ],                                    // see: http://swing-browser.com
        [ 'name' => 't-online.de',          'id'    => 'to-browser',      'regexp' =>'/TO-Browser\/TOB([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],              // see: https://www.t-online.de/computer/browser/
        [ 'name' => 't-online.de',          'id'    => 'to-browser',      'regexp' =>'/TO-Browser/u', 'type' => Constants\DeviceType::DESKTOP ], 
        [ 'name' => 'Tencent Traveler',     'id'    => 'tencent',      'regexp' =>'/TencentTraveler ([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'TenFourFox',           'id'    => 'tenfourfox',      'regexp' =>'/TenFourFox\//u' ],
        [ 'name' => 'The World',            'id'    => 'theworld',      'regexp' =>'/TheWorld(?: ([0-9.]*))?/u' ],
        [ 'name' => 'Tulip Chain',          'id'    => 'tulip',      'regexp' =>'/TulipChain\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                      // see: http://ostermiller.org/tulipchain/
        [ 'name' => 'Tungsten Browser',     'id'    => 'tungsten',      'regexp' =>'/TungstenBrowser\/([0-9.]*)/u' ],
        [ 'name' => 'UltraBrowser',         'id'    => 'ultrab',      'regexp' =>'/UltraBrowser ([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                  // see: http://www.ultrabrowser.com/
        [ 'name' => 'Usejump',              'id'    => 'usejump',      'regexp' =>'/Usejump\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Vimprobable',          'id'    => 'vimprobable',      'regexp' =>'/Vimprobable\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Vivaldi',              'id'    => 'vivaldi',      'regexp' =>'/Vivaldi\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'VMware Workspace ONE', 'id'    => 'airwatch',      'regexp' => '/Air[Ww]atch Browser v([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Vonkeror',             'id'    => 'vonkeror',      'regexp' =>'/Vonkeror\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Voyager',              'id'    => 'voyager',      'regexp' =>'/AmigaVoyager\/([0-9.]*)/u' ],
        [ 'name' => 'Waterfox',             'id'    => 'waterfox',      'regexp' =>'/Waterfox\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Whale Browser',        'id'    => 'whale',       'regexp' => '/ Whale\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                       // see: https://whale.naver.com/
        [ 'name' => 'WinWAP Browser',       'id'    => 'winwap',      'regexp' => '/WinWAP\/([0-9]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                        // see: https://www.winwap.com/mobile_applications/winwap_browser.php
        [ 'name' => 'WinWAP Browser',       'id'    => 'winwap',      'regexp' => '/WinWAP-SPBE\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],
        [ 'name' => 'Xvast',                'id'    => 'xvast',      'regexp' =>'/Xvast\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                            // see: http://www.xvast.com/
        [ 'name' => 'Yandex Browser',       'id'    => 'yabrowser',      'regexp' =>'/YaBrowser\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Zvu Browser',          'id'    => 'zvu',         'regexp' => '/ Zvu\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                         // see: http://zvu.com/
        [ 'name' => 'ZipZap',               'id'    => 'zipzap',      'regexp' =>'/ZipZap ([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                             // see: http://www.zipzaphome.com/
        [ 'name' => 'Zombie.js',            'id'    => 'zombie',      'regexp' =>'/Zombie\.js\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                    // see: http://zombie.js.org/

        /* Mobile browsers */
        [ 'name' => '1Browser',             'id'    => '1password',      'regexp' =>'/1Password\/([0-9.]*)/u' ],
        [ 'name' => '2345 Browser',         'id'    => '2345',      'regexp' =>'/Mb2345Browser\/([0-9.]*)/u' ],
        [ 'name' => '3G Explorer',          'id'    => '3g explorer',      'regexp' =>'/3G Explorer\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => '4G Explorer',          'id'    => '4g explorer',      'regexp' =>'/4G Explorer\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => 'Aloha Browser',        'id'    => 'aloha',         'regexp' => '/AlohaBrowser\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],                 // see: https://alohabrowser.com/
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
        [ 'name' => 'Ecosia Browser',       'id'    => 'ecosia',        'regexp' => '/Ecosia\sandroid\@([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],              // see: https://play.google.com/store/apps/details?id=com.ecosia.android
        [ 'name' => 'Ecosia Browser',       'id'    => 'ecosia',        'regexp' => '/Ecosia\sios\@([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],                  // see: https://apps.apple.com/us/app/ecosia/id670881887
        [ 'name' => 'EMOBILE Browser',      'id'    => 'www browser',      'regexp' =>'/WWW Browser\/ver([0-9.]*)/u' ],
        [ 'name' => 'Epic Browser',         'id'    => 'epic',          'regexp' => '/ Epic\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],                        // see: https://en.wikipedia.org/wiki/Epic_(web_browser)
        [ 'name' => 'EUI Browser',          'id'    => 'eui',      'regexp' =>'/EUI Browser\/[^0-9\s]*([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Go.Web',               'id'    => 'go\.web',      'regexp' =>'/Go\.Web\/([0-9.]*)/u' ],                                                              // used on early Blackberry, by GoAmerica
        [ 'name' => 'Helium',               'id'    => 'helium',      'regexp' =>'/HeliumMobileBrowser\/([0-9.]*)/u' ],
        [ 'name' => 'HeyTap Browser',       'id'    => 'heytap',        'regexp' => '/HeyTapBrowser\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Huohou Browser',       'id'    => 'huohoubrowser',      'regexp' =>'/HuohouBrowser\/([0-9.]*)/u' ],
        [ 'name' => 'iCab',                 'id'    => 'icab',      'regexp' =>'/iCabMobile\/([0-9.]*)/u' ],
        [ 'name' => 'iLunascape',           'id'    => 'lunascape',      'regexp' =>'/iLunascape\/([0-9.]*)/u', 'details' => 3 ],                                           // see: http://www.lunascape.tv
        [ 'name' => 'InternetSurfboard',    'id'    => 'surfboard',      'regexp' =>'/InternetSurfboard\/([0-9.]*)/u' ],
        [ 'name' => 'iSurf',                'id'    => 'isurf',      'regexp' =>'/iSurf version \/v([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Jig Browser',          'id'    => 'jig browser',      'regexp' =>'/jig browser(?: web| core|9i?)?;? ?([0-9.]+)?/u', 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Jumanji',              'id'    => 'jumanji',      'regexp' =>'/jumanji/u' ],                                                                         // see: jumanji browser ubuntu
        [ 'name' => 'K.Browser',            'id'    => 'tnsbrowser',      'regexp' => '/TNSBrowser\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],                   // see: https://play.google.com/store/apps/details?id=com.tnsua.browser
        [ 'name' => 'Kiosk',                'id'    => 'kiosk',      'regexp' =>'/Kiosk\/([0-9.]*)/u' ],                                                                // see: http://www.kioskbrowser.net
        [ 'name' => 'Kiwi Browser',         'id'    => 'kiwi',          'regexp' => '/Kiwi Chrome\/([0-9.A-Z]*)/u' ],                                                       // see: https://kiwibrowser.com
        [ 'name' => 'LeBrowser',            'id'    => 'lebrowser',      'regexp' =>'/LeBrowser\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'LieBaoFast',           'id'    => 'liebao',      'regexp' =>'/LieBaoFast\/([0-9.]*)/u' ],                                                           // see: http://www.liebao.cn
        [ 'name' => 'MaCross Mobile',       'id'    => 'macross',      'regexp' =>'/MaCross\/([0-9.]*)/u' ],
        [ 'name' => 'Mammoth',              'id'    => 'mammoth',      'regexp' =>'/Mammoth\/([0-9.]*)/u' ],                                                              // see: https://itunes.apple.com/cn/app/meng-ma-liu-lan-qi/id403760998?mt=8
        [ 'name' => 'mCent Browser',        'id'    => 'mcent',      'regexp' =>'/mCent\/([0-9.]*)/u' ],
        [ 'name' => 'Mint Browser',              'id'    => 'mint',          'regexp' => '/XiaoMi\/Mint Browser\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],         // see: http://www.mintbrowser.com/
        [ 'name' => 'Mobicip',                   'id'    => 'mobicip',       'regexp' => '/ Mobicip\//u', 'type' => Constants\DeviceType::MOBILE ],                     // see: https://www.mobicip.com/
        [ 'name' => 'Motorola Internet Browser', 'id'    => 'mib',      'regexp' =>'/MIB\/([0-9.]*)/u' ],
        [ 'name' => 'Motorola Internet Browser', 'id'    => 'mib',      'regexp' =>'/MIB([0-9.]+)\//u' ],
        [ 'name' => 'Motorola Internet Browser', 'id'    => 'cmcs',      'regexp' =>'/Browser\/CMCS([0-9.]*)/u' ],
        [ 'name' => 'Motorola WebKit',      'id'    => 'motorola',      'regexp' =>'/MotorolaWebKit(?:\/([0-9.]*))?/u', 'details' => 3 ],
        [ 'name' => 'MultiZilla',           'id'    => 'multizilla',  'regexp' => '/MultiZilla\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP ],                   // see: https://sourceforge.net/projects/multizilla/
        [ 'name' => 'NetFront Life Browser', 'id'    => 'netfrontlife',      'regexp' =>'/NetFrontLifeBrowser\/([0-9.]*)/u' ],
        [ 'name' => 'OneBrowser',           'id'    => 'onebrowser',      'regexp' =>'/OneBrowser\/([0-9.]*)/u' ],
        [ 'name' => 'OnePlus Browser',      'id'    => 'oneplus',       'regexp' => '/OnePlusBrowser\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],               // see: https://www.oneplus.com/
        [ 'name' => 'PocketLink',           'id'    => 'plink',      'regexp' =>'/PLink ([0-9.]+)/iu', 'details' => 2 ],
        [ 'name' => 'Polaris',              'id'    => 'polaris',      'regexp' =>'/Polaris[\/ ]v?([0-9.]*)/iu', 'details' => 2 ],
        [ 'name' => 'Polaris',              'id'    => 'polaris',      'regexp' =>'/POLARIS([0-9.]+)/u', 'details' => 2 ],
        [ 'name' => 'Pure Browser',         'id'    => 'pure',      'regexp' =>'/PureBrowser\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Openwave',             'id'    => 'openwave',      'regexp' =>'/Open[Ww]ave\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Openwave',             'id'    => 'openwave',      'regexp' =>'/Openwave Mobile Browser ([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Openwave',             'id'    => 'openwave',      'regexp' =>'/Browser\/OpenWave([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Openwave',             'id'    => 'up',      'regexp' =>'/UP\. ?Browser(?:\/([a-z0-9.]*))?/iu', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Openwave',             'id'    => 'km',      'regexp' =>'/KM\.Browser\/([0-9.]+)/iu', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Openwave',             'id'    => 'up',      'regexp' =>'/UP\/([0-9.]+)/u', 'details' => 2, 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'Oppo Browser',         'id'    => 'oppo',      'regexp' =>'/OppoBrowser\/([0-9.]+)/iu' ],
        [ 'name' => 'Quark Browser',        'id'    => 'quark',      'regexp' =>'/Quark\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => 'Realme Browser',       'id'    => 'realme',      'regexp' =>'/RealmeBrowser\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],
        
        [ 'name' => 'SEMC Browser',         'id'    => 'semc',      'regexp' =>'/SEMC-Browser\/([0-9.]*)/u' ],
        [ 'name' => 'STNC HitchHiker' ,     'id'    => 'stnc',      'regexp' =>'/STNC-WTL\/[0-9.]*/u' ],
        [ 'name' => 'Sogou Mobile',         'id'    => 'sogou',      'regexp' =>'/SogouMobileBrowser\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Swing Browser',        'id'    => 'swing',      'regexp' =>'/Swing\(And\)\/([0-9.]*)/u', 'details' => 3 ],
        [ 'name' => 'Symphony',             'id'    => 'symphony',      'regexp' =>'/Symphony ([0-9.]+)$/u' ],
        [ 'name' => 'Tenta Browser',        'id'    => 'tenta',         'regexp' => '/ Tenta\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],                       // see: https://play.google.com/store/apps/details?id=com.tenta.android&hl=en
        [ 'name' => 'TinY',                 'id'    => 'ucpro',      'regexp' =>'/ucpro\/([0-9.]+)/iu' ],
        [ 'name' => 'Vivo Browser',         'id'    => 'vivo',      'regexp' =>'/VivoBrowser\/([0-9.]+)/iu' ],
        [ 'name' => 'WebLite',              'id'    => 'weblite',      'regexp' =>'/WebLite\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],
        [ 'name' => 'WK Browser',           'id'    => 'wk',            'regexp' => '/wkbrowser ([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],                     // see: https://github.com/keanulee/WKBrowser
        [ 'name' => 'Yaani Browser',        'id'    => 'yaani',         'regexp' => '/YaaniBrowser\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE ],                 // see: https://www.yaani.com.tr/

        /* Television browsers */
        [ 'name' => 'AltiBrowser',          'id'    => 'alti',      'regexp' =>'/AltiBrowser\/([0-9.]*)/i' ],
        [ 'name' => 'Aplix',                'id'    => 'aplix',      'regexp' =>'/Aplix_SANYO_browser\/([0-9](?:.[0-9.]+)?)/u' ],                                    // browser for the Sega Saturn
        [ 'name' => 'AwoX',                 'id'    => 'awox',      'regexp' =>'/AwoX(?:\/([0-9.]*))? Browser/i' ],
        [ 'name' => 'Isis',                 'id'    => 'browserserver',      'regexp' =>'/BrowserServer/u' ],
        [ 'name' => 'Isis',                 'id'    => 'isis',      'regexp' =>'/ISIS\/([0-9.]*)/u', 'details' => 2 ],
        [ 'name' => 'Netbox',               'id'    => 'netbox',      'regexp' =>'/Netbox\/([0-9.]*)/u', 'type' => Constants\DeviceType::TELEVISION ],
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
        [ 'name' => 'Taobao Browser',       'id'    => 'tao',      'regexp' =>'/TaoBrowser\/([0-9.]*)/u', 'details' => 2 ],
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