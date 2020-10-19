<?php

namespace WhichBrowser\SearchEngines;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

class Qwantify
{
    /** @var string */
    public $name;
    
    /** @var array */
    public $version;

    /** @var string */
    public $bot;
    
    /** @var string default set to false */
    public $found = false;

    /**
     * Detect Qwantify search engine bots
     *
     * @internal
     *
     * @return array
     */
    public function __construct($ua)
    {
        /* Detect `fake` and `dead` bots before real bots */
        if (preg_match('/(MSIE\s(2|3|4|5|6|7|8|9|10)|qwantbot)/iu', $ua, $match)) {
            $this->name = 'Fake Qwantify Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Qwantify News Bot */
        } elseif (preg_match('/Qwant-news\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Qwantify News Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Qwantify Bleriot Bot */
        } elseif (preg_match('/Qwantify\/Bleriot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Qwantify Bleriot Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Qwantify Ai4eu Bot */
        } elseif (preg_match('/Qwantify\/ai4eu\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Qwantify Ai4eu Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Qwantify Mermoz Bot */
        } elseif (preg_match('/Qwantify\/Mermoz\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Qwantify Mermoz Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Qwantify Vr Bot */
        } elseif (preg_match('/Qwantify\/vR/u', $ua, $match)) {
            $this->name = 'Qwantify Vr Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Qwant Research Bot */
        } elseif (preg_match('/Qwant Research Bot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Qwant Research Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Qwantify Bot 1 (place at end) */
        } elseif (preg_match('/Qwantify Bot ([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Qwantify Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Qwantify Bot 2 (place at end) */
        } elseif (preg_match('/Qwantify\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Qwantify Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;
        }

        return;
    }
}
