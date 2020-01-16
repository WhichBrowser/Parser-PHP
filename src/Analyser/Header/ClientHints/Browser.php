<?php

namespace WhichBrowser\Analyser\Header\ClientHints;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

trait Browser
{
    private function &detectBrowser($ch)
    {
        if (preg_match('/Google Chrome ([0-9.]*)/u', $ch, $matches)) {
            $version = $matches[1];
            
            $this->data->browser->reset([
                'name'      => 'Chrome',
                'type'      => Constants\BrowserType::BROWSER,
                'stock'     => false,
                'version'   => new Version([ 'value' => $version ])
            ]);

            if (preg_match('/[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+/u', $version)) {
                $channel = Data\Chrome::getChannel('desktop', $version);

                if ($channel == 'stable') {
                    $this->data->browser->version->details = 1;
                } elseif ($channel == 'beta') {
                    $this->data->browser->channel = 'Beta';
                } else {
                    $this->data->browser->channel = 'Dev';
                }
            }
        }

        return $this;
    }
}
