<?php

namespace WhichBrowser\Analyser\Header\Useragent;

use WhichBrowser\Model\Version;

trait Using
{
    private function &detectUsing($ua)
    {
        if (!preg_match('/(AdobeAIR|Awesomium|Embedded|bsalsa|Canvace|Ekioh|AtomShell|Electron|JavaFX|GFXe|luakit|Titanium|OpenWebKitSharp|Prism|Qt|Reqwireless|RhoSimulator|UWebKit|nw-tests|WebKit2)/ui', $ua)) {
            return $this;
        }

        $items = [
            [ 'name' => 'AdobeAIR',                         'regexp' => '/AdobeAIR\/([0-9.]*)/u' ],
            [ 'name' => 'Awesomium',                        'regexp' => '/Awesomium\/([0-9.]*)/u' ],
            [ 'name' => 'Delphi Embedded Web Browser',      'regexp' => '/EmbeddedWB ([0-9.]*)/u' ],
            [ 'name' => 'Delphi Embedded Web Browser',      'regexp' => '/bsalsa\.com/u' ],
            [ 'name' => 'Delphi Embedded Web Browser',      'regexp' => '/Embedded Web Browser/u' ],
            [ 'name' => 'Canvace',                          'regexp' => '/Canvace Standalone\/([0-9.]*)/u' ],
            [ 'name' => 'Ekioh',                            'regexp' => '/Ekioh\/([0-9.]*)/u' ],
            [ 'name' => 'Electron',                         'regexp' => '/AtomShell\/([0-9.]*)/u' ],
            [ 'name' => 'Electron',                         'regexp' => '/Electron\/([0-9.]*)/u' ],
            [ 'name' => 'JavaFX',                           'regexp' => '/JavaFX\/([0-9.]*)/u' ],
            [ 'name' => 'GFXe',                             'regexp' => '/GFXe\/([0-9.]*)/u' ],
            [ 'name' => 'LuaKit',                           'regexp' => '/luakit/u' ],
            [ 'name' => 'Titanium',                         'regexp' => '/Titanium\/([0-9.]*)/u' ],
            [ 'name' => 'OpenWebKitSharp',                  'regexp' => '/OpenWebKitSharp/u' ],
            [ 'name' => 'Prism',                            'regexp' => '/Prism\/([0-9.]*)/u' ],
            [ 'name' => 'Qt',                               'regexp' => '/Qt\/([0-9.]*)/u' ],
            [ 'name' => 'Qt',                               'regexp' => '/QtWebEngine\/([4-9][0-9.]*)?/u' ],
            [ 'name' => 'Qt',                               'regexp' => '/QtEmbedded/u' ],
            [ 'name' => 'Qt',                               'regexp' => '/QtEmbedded.*Qt\/([0-9.]*)/u' ],
            [ 'name' => 'ReqwirelessWeb',                   'regexp' => '/ReqwirelessWeb\/([0-9.]*)/u' ],
            [ 'name' => 'RhoSimulator',                     'regexp' => '/RhoSimulator/u' ],
            [ 'name' => 'UWebKit',                          'regexp' => '/UWebKit\/([0-9.]*)/u' ],
            [ 'name' => 'Node-WebKit',                      'regexp' => '/nw-tests\/([0-9.]*)/u' ],
            [ 'name' => 'WebKit2.NET',                      'regexp' => '/WebKit2.NET/u' ],
        ];

        $count = count($items);
        for ($i = 0; $i < $count; $i++) {
            if (preg_match($items[$i]['regexp'], $ua, $match)) {
                $this->data->browser->using = new \WhichBrowser\Model\Using([
                    'name' => $items[$i]['name']
                ]);

                if (isset($match[1]) && $match[1]) {
                    $this->data->browser->using->version = new Version([ 'value' => $match[1], 'details' => isset($items[$i]['details']) ? $items[$i]['details'] : null ]);
                }

                break;
            }
        }

        return $this;
    }
}
