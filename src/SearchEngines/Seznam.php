<?php

namespace WhichBrowser\SearchEngines;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

class Seznam
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
     * Detect Seznam search engine bots
     *
     * @internal
     *
     * @return array
     */
    public function __construct($ua)
    {
        /* Detect `fake` and `dead` bots before real bots */
        if (preg_match('/(\x5cx|\(\s|\s\;|\+\+|\;http|0\(|seznambots?\.(com|net|info|cz)|seznam\.(com|net|info)|Seznam\sBot)/iu', $ua, $match)) {
            $this->name = 'Fake Seznam Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Seznam Test (place before normal SeznamBot) */
        } elseif (preg_match('/SeznamBot\/([0-9.]*)-test/u', $ua, $match)) {
            $this->name = 'Seznam Test Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Seznam Bot */
        } elseif (preg_match('/SeznamBot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Seznam Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Sklik Bot */
        } elseif (preg_match('/SklikBot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Seznam Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Seznam Homepage Rss Reader */
        } elseif (preg_match('/HomePage(Bot)? Rss Reader ([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Seznam Homepage Rss Reader Bot';
            $this->version = new Version([ 'value' => $match[2] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Seznam Homepage Downloader */
        } elseif (preg_match('/HomePageBot downloader ([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Seznam Homepage Downloader Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Seznam Screenshot Generator */
        } elseif (preg_match('/Seznam screenshot-generator ([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Seznam Screenshot Generator Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Seznam Read Later */
        } elseif (preg_match('/SeznamReadLaterBot/u', $ua, $match)) {
            $this->name = 'Seznam Read Later Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Seznam Email Proxy */
        } elseif (preg_match('/SeznamEmailProxy/u', $ua, $match)) {
            $this->name = 'Seznam Email Proxy Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Seznam Zbozi.cz */
        } elseif (preg_match('/Seznam-Zbozi-robot/u', $ua, $match)) {
            $this->name = 'Seznam Zbozi.cz Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;
        }

        return;
    }
}
