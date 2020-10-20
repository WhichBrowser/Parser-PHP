<?php

namespace WhichBrowser\SearchEngines;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

class Mailru
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
     * Detect Mail.ru search engine bots
     *
     * @internal
     *
     * @return array
     */
    public function __construct($ua)
    {
        /* Detect `fake` and `dead` bots before real bots */
        if (preg_match('/(MSIE\s(2|3|4|5|6|7|8|9|10)|mail\.(net|com|info)|RU\_Bots)/iu', $ua, $match)) {
            $this->name = 'Fake Mail.ru Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Mail.ru Fast Bot */
        } elseif (preg_match('/Mail\.RU\_Bot\/Fast\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Mail.ru Fast Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Mail.ru Image Bot */
        } elseif (preg_match('/Mail\.RU\_Bot\/Img\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Mail.ru Image Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Mail.ru Video Bot */
        } elseif (preg_match('/Mail\.RU\_Bot\/Video\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Mail.ru Video Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Mail.ru Robots.txt Bot */
        } elseif (preg_match('/Mail\.RU\_Bot\/Robots\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Mail.ru Robots.txt Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Mail.ru Mail Bot */
        } elseif (preg_match('/Mail\.RU\_Bot\/Mail\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Mail.ru Mail Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Mail.ru Bot (place at end) */
        } elseif (preg_match('/Mail\.RU\_Bot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Mail.ru Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;
        }

        return;
    }
}
