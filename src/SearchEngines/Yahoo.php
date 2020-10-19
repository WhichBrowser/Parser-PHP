<?php

namespace WhichBrowser\SearchEngines;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

class Yahoo
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
     * Detect Yahoo search engine bots
     *
     * @internal
     *
     * @return array
     */
    public function __construct($ua)
    {
        /* Detect `fake` and `dead` bots before real bots */
        if (preg_match('/(siteexplorer|Slingstone|MMAudVid|Mindset|SiteChecker|MSIE\s(2|3|4|5|6|7|8|9|10)|Yahoo(FeedSeeker|YSMcm|VideoSearch)|Yahoo\sPipes|Nutch|Yahoo\s?Bot|Slurp\;http)/iu', $ua, $match)) {
            $this->name = 'Fake Yahoo! Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yahoo! Slurp China Bot (needs to be placed before `Yahoo! Slurp Bot`) */
        } elseif (preg_match('/Yahoo\! Slurp China\/?([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yahoo! Slurp China Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yahoo! Slurp Bot 1 */
        } elseif (preg_match('/Yahoo\! Slurp\/?([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yahoo! Slurp Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yahoo! Slurp Bot 2 */
        } elseif (preg_match('/Yahoo\! DE Slurp\/?([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yahoo! Slurp Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yahoo! Cache System Bot */
        } elseif (preg_match('/YahooCacheSystem/u', $ua, $match)) {
            $this->name = 'Yahoo! Cache System Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yahoo! Japan Bot */
        } elseif (preg_match('/Y\!J-([a-zA-Z]+)\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yahoo! Japan Bot';
            $this->version = new Version([ 'value' => $match[2] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yahoo! Seeker Testing Bot 1 */
        } elseif (preg_match('/YahooSeeker-Testing\/v([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yahoo! Seeker Testing Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yahoo! Seeker Testing Bot 2 */
        } elseif (preg_match('/yahooseeker-jp-mobile/u', $ua, $match)) {
            $this->name = 'Yahoo! Seeker Testing Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yahoo! Seeker Testing Bot 3 */
        } elseif (preg_match('/YahooSeeker(?:\/([0-9.]*))?/u', $ua, $match)) {
            $this->name = 'Yahoo! Seeker Testing Bot';
            $this->version = new Version([ 'value' => $match[1] ]) ?? '';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yahoo! Ad Monitoring */
        } elseif (preg_match('/Yahoo Ad Monitoring/iu', $ua, $match)) {
            $this->name = 'Yahoo! Ad Monitoring';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yahoo! Link Preview Bot */
        } elseif (preg_match('/Yahoo Link Preview/u', $ua, $match)) {
            $this->name = 'Yahoo! Link Preview Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yahoo! Mail Proxy Bot */
        } elseif (preg_match('/YahooMailProxy/u', $ua, $match)) {
            $this->name = 'Yahoo! Mail Proxy Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yahoo! Image Bot */
        } elseif (preg_match('/Yahoo-MMCrawler\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yahoo! Image Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;
        }

        return;
    }
}
