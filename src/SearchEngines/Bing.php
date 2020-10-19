<?php

namespace WhichBrowser\SearchEngines;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

class Bing
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
     * Detect Bing search engine bots
     *
     * @internal
     *
     * @return array
     */
    public function __construct($ua)
    {
        /* Detect `fake` and `dead` bots before real bots 1 */
        if (preg_match('/(^bingbot|msnbot\/(0|1)|bingbot\/([0-9.]+)\s|\;bingbot|MoziMozilla|Baiduspider|librabot|MSIE\s(2|3|4|5|6|7|8|9|10)|msnbot\-(Products|Academic|UDiscovery|NewsBlogs)|renlifangbot|lanshanbot|msrabot|livebot\-searchsense|MJ12bot)/iu', $ua, $match)) {
            $this->name = 'Fake Bing Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Detect `fake` and `dead` bots before real bots 2 (real `bingbot` is all lower case) */
        } elseif (preg_match('/Bingbot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Fake Bing Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Bing AdIdx Bot */
        } elseif (preg_match('/adidxbot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Bing AdIdx Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Bing Preview Bot */
        } elseif (preg_match('/BingPreview\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Bing Preview Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Bing Seo Analyser Bot */
        } elseif (preg_match('/seoanalyzer/u', $ua, $match)) {
            $this->name = 'Bing Seo Analyser Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Bing Msnbot Media Bot */
        } elseif (preg_match('/msnbot-media\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Bing Msnbot Media Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Bing Local Search Bot */
        } elseif (preg_match('/BingLocalSearch/iu', $ua, $match)) {
            $this->name = 'Bing Local Search Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Detect mobile bots (place third to last) */
        } elseif (preg_match('/Mobile/iu', $ua, $match)) {
            /* Bing Mobile Bot */
            if (preg_match('/bingbot\/([0-9.]*)/u', $ua, $match)) {
                $this->name = 'Bing Mobile Bot';
                $this->version = new Version([ 'value' => $match[1] ]);
                $this->bot = Constants\DeviceType::BOT;
                $this->found = true;
            /* Bing Msnbot Mobile Bot */
            } elseif (preg_match('/msnbot\/([0-9.]*)/u', $ua, $match)) {
                $this->name = 'Bing Msnbot Mobile Bot';
                $this->version = new Version([ 'value' => $match[1] ]);
                $this->bot = Constants\DeviceType::BOT;
                $this->found = true;
            }

        /* Bing Msnbot Bot (place second to last) */
        } elseif (preg_match('/msnbot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Bing Msnbot Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Bing Bot (place last) */
        } elseif (preg_match('/bingbot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Bing Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;
        }

        return;
    }
}
