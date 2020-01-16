<?php

namespace WhichBrowser\Analyser\Header\ClientHints;

use WhichBrowser\Constants;
use WhichBrowser\Data;

trait Platform
{
    private function &detectPlatform($ch)
    {
        if (preg_match('/Mac OS X/u', $ch, $matches)) {
            $this->data->os->reset([
                'name'  => 'OS X',
                'alias' => 'macOS',
                'type'  => Constants\DeviceType::DESKTOP
            ]);
        }

        return $this;
    }
}
