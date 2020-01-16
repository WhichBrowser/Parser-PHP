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
            $this->data->browser->reset([
                'name'      => 'Chrome',
                'type'      => Constants\BrowserType::BROWSER,
                'stock'     => false,
                'version'   => new Version([ 'value' => $matches[1] ])
            ]);
        }

        return $this;
    }
}
