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

    /**
     * Detect Seznam search engine bots
     *
     * @internal
     *
     * @return array
     */
    public function __construct($ua)
    {
        /* SeznamBot Test (place before normal SeznamBot) */
        if (preg_match('/SeznamBot\/([0-9.]*)-test/u', $ua, $match)) {
            $this->name = 'SeznamBot Test';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;

        /* SeznamBot */
        } elseif (preg_match('/SeznamBot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'SeznamBot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;

        /* SklikBot */
        } elseif (preg_match('/SklikBot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'SeznamBot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;

        /* Seznam HomePageBot Rss Reader */
        } elseif (preg_match('/HomePage(Bot)? Rss Reader ([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Seznam HomePageBot Rss Reader';
            $this->version = new Version([ 'value' => $match[2] ]);
            $this->bot = Constants\DeviceType::BOT;

        /* Seznam HomePageBot Downloader */
        } elseif (preg_match('/HomePageBot downloader ([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Seznam HomePageBot Downloader';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;

        /* Seznam Screenshot Generator */
        } elseif (preg_match('/Seznam screenshot-generator ([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Seznam Screenshot Generator';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;

        /* SeznamReadLaterBot */
        } elseif (preg_match('/SeznamReadLaterBot/u', $ua, $match)) {
            $this->name = 'SeznamReadLaterBot';
            $this->bot = Constants\DeviceType::BOT;

        /* Seznam Email Proxy */
        } elseif (preg_match('/SeznamEmailProxy/u', $ua, $match)) {
            $this->name = 'Seznam Email Proxy';
            $this->bot = Constants\DeviceType::BOT;

        /* Seznam Zbozi.cz */
        } elseif (preg_match('/Seznam-Zbozi-robot/u', $ua, $match)) {
            $this->name = 'Seznam Zbozi.cz';

            $this->bot = Constants\DeviceType::BOT;
        }

        return;
    }
}
