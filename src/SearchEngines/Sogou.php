<?php

namespace WhichBrowser\SearchEngines;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

class Sogou
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
     * Detect Sogou search engine bots
     *
     * @internal
     *
     * @return array
     */
    public function __construct($ua)
    {
        /* Sogou Web Spider */
        if (preg_match('/Sogou web spider\/([0-9.]*)/iu', $ua, $match)) {
            $this->name = 'Sogou Web Spider';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Sogou Mobile Spider */
        } elseif (preg_match('/Sogou mobile spider\/([0-9.]*)/iu', $ua, $match)) {
            $this->name = 'Sogou Mobile Spider';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Sogou Pic Spider */
        } elseif (preg_match('/Sogou Pic Spider\/([0-9.]*)/iu', $ua, $match)) {
            $this->name = 'Sogou Pic Spider';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Sogou Inst Spider */
        } elseif (preg_match('/Sogou inst spider\/([0-9.]*)/iu', $ua, $match)) {
            $this->name = 'Sogou Inst Spider';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Sogou News Spider */
        } elseif (preg_match('/Sogou News Spider\/([0-9.]*)/iu', $ua, $match)) {
            $this->name = 'Sogou News Spider';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;
        }

        return;
    }
}
