<?php

namespace WhichBrowser\SearchEngines;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

class Ahrefs
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
     * Detect Ahrefs real and fake bots
     *
     * @internal
     *
     * @return array
     */
    public function __construct($ua)
    {
        /* Detect `fake` and `dead` bots before real bots */
        if (preg_match('/^AhrefsBot/iu', $ua, $match)) {
            $this->name = 'Fake Ahrefs Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Ahrefs Feeds Bot */
        } elseif (preg_match('/AhrefsBot\.Feeds v([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Ahrefs Feeds Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Ahrefs Site Audit Bot */
        } elseif (preg_match('/AhrefsSiteAudit\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Ahrefs Site Audit Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Ahrefs News Bot */
        } elseif (preg_match('/AhrefsBot\/([0-9.]*)\; News/u', $ua, $match)) {
            $this->name = 'Ahrefs News Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Ahrefs SA Bot */
        } elseif (preg_match('/AhrefsBot\/([0-9.]*)\; SA/u', $ua, $match)) {
            $this->name = 'Ahrefs SA Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Ahrefs Bot */
        } elseif (preg_match('/AhrefsBot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Ahrefs Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;
        }

        return;
    }
}
