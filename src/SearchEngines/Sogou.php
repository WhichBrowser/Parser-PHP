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
        /* Detect `fake` and `dead` bots before real bots */
        if (preg_match('/(MSIE\s(2|3|4|5|6|7|8|9|10)|sogou\sspider$|Sogou\sPic\sAgent$|Sogou-Test-Spider|Sogou\s(blog|head|Orion)|New-Sogou)/iu', $ua, $match)) {
            $this->name = 'Fake Sogou Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Sogou Image Bot */
        } elseif (preg_match('/Sogou Pic Spider\/([0-9.]*)/iu', $ua, $match)) {
            $this->name = 'Sogou Image Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Sogou News Bot */
        } elseif (preg_match('/Sogou News Spider\/([0-9.]*)/iu', $ua, $match)) {
            $this->name = 'Sogou News Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Sogou Video Bot */
        } elseif (preg_match('/Sogou Video Spider\/([0-9.]*)/iu', $ua, $match)) {
            $this->name = 'Sogou Video Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Sogou Push Bot */
        } elseif (preg_match('/Sogou Push Spider\/([0-9.]*)/iu', $ua, $match)) {
            $this->name = 'Sogou Push Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Sogou Mobile Bot 1 */
        } elseif (preg_match('/Sogou mobile spider\/([0-9.]*)/iu', $ua, $match)) {
            $this->name = 'Sogou Mobile Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Sogou Mobile Bot 2 */
        } elseif (preg_match('/Sogou wap spider/iu', $ua, $match)) {
            $this->name = 'Sogou Mobile Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;
            
        /* Sogou Bot 1 */
        } elseif (preg_match('/Sogou inst spider\/([0-9.]*)/iu', $ua, $match)) {
            $this->name = 'Sogou Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;
            
        /* Sogou Bot 2 */
        } elseif (preg_match('/Sogou web spider\/([0-9.]*)/iu', $ua, $match)) {
            $this->name = 'Sogou Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Sogou Bot 3 */
        } elseif (preg_match('/Sogou spider/iu', $ua, $match)) {
            $this->name = 'Sogou Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;
        }

        return;
    }
}
