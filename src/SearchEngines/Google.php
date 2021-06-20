<?php

namespace WhichBrowser\SearchEngines;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

class Google
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
     * Detect Google search engine bots
     *
     * @internal
     *
     * @return array
     */
    public function __construct($ua)
    {
        /*
         * Detect `fake` and `dead` bots before real bots
         * This filters a small amount of fake bots to properly
         * check for fake bots use a reverse dns lookup.
         */
        if (preg_match('/(\x5cx|\(\s|\s\;|\+\+|\;\+|\;http|0\(|googlebot\.com|^googlebot$|guuggle|googloe|googIe|https:\/\/www\.google)/iu', $ua, $match)) {
            $this->name = 'Fake Google Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google APIs Bot */
        } elseif (preg_match('/Google-SMTP-STS/u', $ua, $match)) {
            $this->name = 'Google MTA-STS Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google APIs Bot */
        } elseif (preg_match('/APIs-Google/u', $ua, $match)) {
            $this->name = 'Google APIs Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google AdSense Bot */
        } elseif (preg_match('/Mediapartners-Google\/?([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Google AdSense Bot';
            $this->version = new Version([ 'value' => $match[1] ]) ?? '';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Mobile Apps Bot 1 (before `Google Ads Mobile Bot`) */
        } elseif (preg_match('/AdsBot-Google-Mobile-Apps\/?([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Google Mobile Apps Bot';
            $this->version = new Version([ 'value' => $match[1] ]) ?? '';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Ads Mobile Bot 2 (before `Google Ads Bot`) */
        } elseif (preg_match('/AdsBot-Google-Mobile\/?([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Google Ads Mobile Bot';
            $this->version = new Version([ 'value' => $match[1] ]) ?? '';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Ads Bot 3 */
        } elseif (preg_match('/AdsBot-Google\/?([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Google Ads Bot';
            $this->version = new Version([ 'value' => $match[1] ]) ?? '';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Image Bot */
        } elseif (preg_match('/Googlebot-Image\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Google Image Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google News Bot */
        } elseif (preg_match('/Googlebot-News\/?([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Google News Bot';
            $this->version = new Version([ 'value' => $match[1] ]) ?? '';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Video Bot */
        } elseif (preg_match('/Googlebot-Video\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Google Video Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Feedfetcher Bot */
        } elseif (preg_match('/FeedFetcher-Google/iu', $ua, $match)) {
            $this->name = 'Google Feedfetcher Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Read Aloud Bot */
        } elseif (preg_match('/Google-Read-Aloud/u', $ua, $match)) {
            $this->name = 'Google Read Aloud Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Duplex Bot */
        } elseif (preg_match('/DuplexWeb-Google\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Google Duplex Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Favicon Bot */
        } elseif (preg_match('/Google Favicon/u', $ua, $match)) {
            $this->name = 'Google Favicon Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Web Light Bot */
        } elseif (preg_match('/googleweblight/u', $ua, $match)) {
            $this->name = 'Google Web Light Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Web Preview Analytics Bot 1 */
        } elseif (preg_match('/Google Web Preview Analytics/u', $ua, $match)) {
            $this->name = 'Google Web Preview Analytics Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Web Preview Bot 2 */
        } elseif (preg_match('/Google Web Preview/u', $ua, $match)) {
            $this->name = 'Google Web Preview Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Site Verification Bot */
        } elseif (preg_match('/Google-Site-Verification\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Google Site Verification Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Image Proxy Bot */
        } elseif (preg_match('/GoogleImageProxy/u', $ua, $match)) {
            $this->name = 'Google Image Proxy Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Page Speed Insights Bot */
        } elseif (preg_match('/Google Page Speed Insights/u', $ua, $match)) {
            $this->name = 'Google Page Speed Insights Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Structured Data Testing Tool Bot */
        } elseif (preg_match('/Google-Structured-Data-Testing-Tool/u', $ua, $match)) {
            $this->name = 'Google Structured Data Testing Tool Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Adsense Snapshot Bot */
        } elseif (preg_match('/Adsense-Snapshot-Google/u', $ua, $match)) {
            $this->name = 'Google Adsense Snapshot Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Sitemaps Bot */
        } elseif (preg_match('/Google-Sitemaps\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Google Sitemaps Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Font Analysis Bot */
        } elseif (preg_match('/Google-FontAnalysis\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Google Font Analysis Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Rich Snippets Bot */
        } elseif (preg_match('/Googlebot-richsnippets/u', $ua, $match)) {
            $this->name = 'Google Rich Snippets Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Play Newsstand Bot */
        } elseif (preg_match('/GoogleProducer/u', $ua, $match)) {
            $this->name = 'Google Play Newsstand Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google YouTube Sample Bot */
        } elseif (preg_match('/Google-YouTubeSample\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Google YouTube Sample Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Shopping Bot */
        } elseif (preg_match('/google-xrawler/u', $ua, $match)) {
            $this->name = 'Google Shopping Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Shopping Quality Bot */
        } elseif (preg_match('/Google-Shopping-Quality/u', $ua, $match)) {
            $this->name = 'Google Shopping Quality Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Snapchat - This needs to be listed before Google App Engine */
        } elseif (preg_match('/snapchat\-proxy/u', $ua, $match)) {
            $this->name = 'Snapchat Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google App Engine Bot */
        } elseif (preg_match('/AppEngine-Google/u', $ua, $match)) {
            $this->name = 'Google App Engine Bot';
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Mobile Bot 1 (place third to last) */
        } elseif (preg_match('/Googlebot-Mobile\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Google Mobile Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;

        /* Google Mobile Bot 2 (place second to last) */
        } elseif (preg_match('/Mobile/iu', $ua, $match)) {
            /* Google Mobile Bot */
            if (preg_match('/Googlebot\/([0-9.]*)/u', $ua, $match)) {
                $this->name = 'Google Mobile Bot';
                $this->version = new Version([ 'value' => $match[1] ]);
                $this->bot = Constants\DeviceType::BOT;
                $this->found = true;
            }

        /* Google Bot (place last) */
        } elseif (preg_match('/Googlebot\/([0-9.]*)/u', $ua, $match)) {
            $this->name = 'Google Bot';
            $this->version = new Version([ 'value' => $match[1] ]);
            $this->bot = Constants\DeviceType::BOT;
            $this->found = true;
        }

        return;
    }
}
