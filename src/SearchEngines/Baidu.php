<?php

namespace WhichBrowser\SearchEngines;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

class Baidu
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
     * Detect Baidu search engine bots
     *
     * @internal
     *
     * @return array
     */
    public function __construct($ua)
    {
        /* Detect `fake` and `dead` bots before real bots */
        if (preg_match('/(\x5cx|\=|\+\+|\;\+|0\(|MSIE\s(2|3|4|5|6|7|8|9|10)|Baiduspider\+|bing|google)/iu', $ua, $match)) {
            $this->name = 'Fake Baiduspider Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Baiduspider Image Bot */
        } elseif (preg_match('/Baiduspider-image\/?([0-9.]*)/u', $ua, $match)) { // Some bots have versions and some do not
            $this->name = 'Baiduspider Image Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Baiduspider Video Bot */
        } elseif (preg_match('/Baiduspider-video\/?([0-9.]*)/u', $ua, $match)) { // Some bots have versions and some do not
            $this->name = 'Baiduspider Video Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Baiduspider News Bot */
        } elseif (preg_match('/Baiduspider-news\/?([0-9.]*)/u', $ua, $match)) { // Some bots have versions and some do not
            $this->name = 'Baiduspider News Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Baiduspider Bookmark Bot */
        } elseif (preg_match('/Baiduspider-cpro\/?([0-9.]*)/u', $ua, $match)) { // Some bots have versions and some do not
            $this->name = 'Baiduspider Bookmark Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Baiduspider Collection Bot */
        } elseif (preg_match('/Baiduspider-favo/u', $ua, $match)) {
            $this->name = 'Baiduspider Collection Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Baiduspider Adverts Bot */
        } elseif (preg_match('/Baiduspider-ads/u', $ua, $match)) {
            $this->name = 'Baiduspider Adverts Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Detect Mobile versions before main bots */
        } elseif (preg_match('/Mobile/iu', $ua, $match)) {
            /* Baiduspider Mobile Render Bot */
            if (preg_match('/Baiduspider-render\/([0-9.]*)/u', $ua, $match)) {
                $this->name = 'Baiduspider Mobile Render Bot';
                $this->version = new Version([ 'value' => $match[1] ]);
                $this->bot = Constants\DeviceType::BOT;
                $this->found = true;

            /* Baiduspider Mobile Bot */
            } elseif (preg_match('/Baiduspider\/([0-9.]*)/u', $ua, $match)) {
                $this->name = 'Baiduspider Mobile Bot';
                $this->version = new Version([ 'value' => $match[1] ]);
                $this->bot = Constants\DeviceType::BOT;
                $this->found = true;
            }

        /* Baiduspider Render Bot (place second to the end) */
        } elseif (preg_match('/Baiduspider-render\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Baiduspider Render Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Baiduspider Bot (place at the end) */
        } elseif (preg_match('/Baiduspider\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Baiduspider Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;
        }

        return;
    }
}
