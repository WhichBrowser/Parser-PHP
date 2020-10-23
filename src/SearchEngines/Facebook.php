<?php

namespace WhichBrowser\SearchEngines;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

class Facebook
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
     * Detect Facebook search engine bots
     *
     * @internal
     *
     * @return array
     */
    public function __construct($ua)
    {
        /* Detect `fake` and `dead` bots before real bots 1 */
        if (preg_match('/(^acebookexternalhit|MSIE\s(2|3|4|5|6|7|8|9|10)|scrap|share|Security|Facebot|Facebook\/|facebook\.(net|info)|facebook\s?bot)/iu', $ua, $match)) {
            $this->name = 'Fake Facebook Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Facebook External Hit Bot */
        } elseif (preg_match('/facebookexternalhit\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Facebook External Hit Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Facebook Platform Bot */
        } elseif (preg_match('/facebookplatform\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Facebook Platform Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Facebook External UA Bot */
        } elseif (preg_match('/facebookexternalua/u', $ua, $match)) {
            $this->name = 'Facebook External UA Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;
        }

        return;
    }
}
