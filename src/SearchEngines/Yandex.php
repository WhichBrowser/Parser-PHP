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
        /* YandexBot MirrorDetector (place before normal Yandex Bot) */
        if (preg_match('/YandexBot\/([0-9.]*); MirrorDetector/u', $ua, $match)) {
            $this->name = 'Yandex Bot Mirror Detector';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Bot */
        } elseif (preg_match('/YandexBot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Anti Virus */
        } elseif (preg_match('/YandexAntivirus\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Anti Virus';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Blogs */
        } elseif (preg_match('/YandexBlogs\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Blogs';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Direct */
        } elseif (preg_match('/YandexDirect\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Direct';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Favicons */
        } elseif (preg_match('/YandexFavicons\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Favicons';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Image Resizer */
        } elseif (preg_match('/YandexImageResizer\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Image Resizer';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Images */
        } elseif (preg_match('/YandexImages\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Images';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Metrika */
        } elseif (preg_match('/YandexMetrika\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Metrika';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex News */
        } elseif (preg_match('/YandexNews\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex News';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Yandex Newslinks */
        } elseif (preg_match('/YandexNewslinks(?:\/([0-9.]*))?/u', $ua, $match)) {
            $this->name = 'Yandex Newslinks';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* YandexMobileBot */
        } elseif (preg_match('/YandexMobileBot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Mobile Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* YandexAccessibilityBot */
        } elseif (preg_match('/YandexAccessibilityBot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Accessibility Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* YandexMedia */
        } elseif (preg_match('/YandexMedia\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Media';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* YandexVideo */
        } elseif (preg_match('/YandexVideo\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Video';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* YandexVideoParser */
        } elseif (preg_match('/YandexVideoParser\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Video Parser';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* YandexPagechecker */
        } elseif (preg_match('/YandexPagechecker\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Page Checker';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* YandexDirectDyn */
        } elseif (preg_match('/YandexDirectDyn\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Direct Dyn';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* YandexRCA */
        } elseif (preg_match('/YandexRCA\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex RCA';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* YandexCatalog */
        } elseif (preg_match('/YandexCatalog\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Yandex Catalog';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;
        }

        return;
    }
}
