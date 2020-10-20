<?php

namespace WhichBrowser\SearchEngines;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

class Yandex
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
     * Detect Yandex search engine bots
     *
     * @internal
     *
     * @return array
     */
    public function __construct($ua)
    {
        /* Detect `fake` and `dead` bots before real bots */
        if (preg_match('/(MSIE\s(2|3|4|5|6|7|8|9|10)|google|bing|baidu|yandex\.(info|net|ru)|yandexbots|yandexbot\.com)/iu', $ua, $match)) {
            $this->name = 'Fake Yandex Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Mirror Detector (place before normal Yandex Bot) */
        } elseif (preg_match('/YandexBot\/([0-9.]*); MirrorDetector/u', $ua, $match)) {
            $this->name = 'Yandex Mirror Detector Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Direct Dyn */
        } elseif (preg_match('/YandexDirectDyn\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Direct Dyn Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Direct */
        } elseif (preg_match('/YandexDirect\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Direct Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Ad Net */
        } elseif (preg_match('/YandexAdNet\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Ad Net Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Anti Virus */
        } elseif (preg_match('/YandexAntivirus\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Anti Virus Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Blogs */
        } elseif (preg_match('/YandexBlogs\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Blogs Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Calendar */
        } elseif (preg_match('/YandexCalendar\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Calendar Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Calendar */
        } elseif (preg_match('/YandexCalendar\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Calendar Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex For Domain */
        } elseif (preg_match('/YandexForDomain\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex For Domain Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Market */
        } elseif (preg_match('/YandexMarket\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Market Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Mobile Screen Shot */
        } elseif (preg_match('/YandexMobileScreenShotBot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Mobile Screen Shot Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Onto DB */
        } elseif (preg_match('/YandexOntoDB\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Onto DB Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Onto DB API */
        } elseif (preg_match('/YandexOntoDBAPI\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Onto DB API Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Partner */
        } elseif (preg_match('/YandexPartner\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Partner Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Search Shop */
        } elseif (preg_match('/YandexSearchShop\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Search Shop Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Sitelinks */
        } elseif (preg_match('/YandexSitelinks/u', $ua, $match)) {
            $this->name = 'Yandex Sitelinks Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Sprav */
        } elseif (preg_match('/YandexSpravBot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Sprav Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Tracker */
        } elseif (preg_match('/YandexTracker\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Tracker Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Turbo */
        } elseif (preg_match('/YandexTurbo\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Turbo Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Vertis */
        } elseif (preg_match('/YandexVertis\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Vertis Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Verticals */
        } elseif (preg_match('/YandexVerticals\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Verticals Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Webmaster */
        } elseif (preg_match('/YandexWebmaster\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Webmaster Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Screenshot */
        } elseif (preg_match('/YandexScreenshotBot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Screenshot Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Favicons */
        } elseif (preg_match('/YandexFavicons\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Favicons Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Image Resizer */
        } elseif (preg_match('/YandexImageResizer\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Image Resizer Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Images */
        } elseif (preg_match('/YandexImages\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Images Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Metrika */
        } elseif (preg_match('/YandexMetrika\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Metrika Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Newslinks */
        } elseif (preg_match('/YandexNewslinks(?:\/([0-9.]*))?/u', $ua, $match)) {
            $this->name = 'Yandex Newslinks Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex News */
        } elseif (preg_match('/YandexNews\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex News Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Accessibility */
        } elseif (preg_match('/YandexAccessibilityBot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Accessibility Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Media */
        } elseif (preg_match('/YandexMedia\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Media Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Video */
        } elseif (preg_match('/YandexVideo\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Video Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Video Parser */
        } elseif (preg_match('/YandexVideoParser\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Video Parser Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Page Checker */
        } elseif (preg_match('/YandexPagechecker\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Page Checker Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex RCA */
        } elseif (preg_match('/YandexRCA\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex RCA Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Catalog */
        } elseif (preg_match('/YandexCatalog\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Catalog Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Direct Fetcher */
        } elseif (preg_match('/YaDirectFetcher\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Direct Fetcher Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Mobile Bot */
        } elseif (preg_match('/YandexMobileBot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Mobile Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Bot (place last) */
        } elseif (preg_match('/YandexBot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;
        }

        return;
    }
}
