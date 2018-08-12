<?php

namespace WhichBrowser\Analyser;

use WhichBrowser\Constants;
use WhichBrowser\Parser;

trait Header
{
    private function &analyseHeaders()
    {
        /* Analyse the main useragent header */

        if ($header = $this->getHeader('User-Agent')) {
            $this->analyseUserAgent($header);
        }


        /* Analyse secondary useragent headers */

        if ($header = $this->getHeader('X-Original-User-Agent')) {
            $this->additionalUserAgent($header);
        }
        
        if ($header = $this->getHeader('X-Device-User-Agent')) {
            $this->additionalUserAgent($header);
        }
        
        if ($header = $this->getHeader('Device-Stock-UA')) {
            $this->additionalUserAgent($header);
        }
        
        if ($header = $this->getHeader('X-OperaMini-Phone-UA')) {
            $this->additionalUserAgent($header);
        }

        if ($header = $this->getHeader('X-UCBrowser-Device-UA')) {
            $this->additionalUserAgent($header);
        }
        

        /* Analyse browser specific headers */

        if ($header = $this->getHeader('X-OperaMini-Phone')) {
            $this->analyseOperaMiniPhone($header);
        }
        
        if ($header = $this->getHeader('X-UCBrowser-Phone-UA')) {
            $this->analyseOldUCUserAgent($header);
        }
        
        if ($header = $this->getHeader('X-UCBrowser-UA')) {
            $this->analyseNewUCUserAgent($header);
        }
        
        if ($header = $this->getHeader('X-Puffin-UA')) {
            $this->analysePuffinUserAgent($header);
        }
        
        if ($header = $this->getHeader('Baidu-FlyFlow')) {
            $this->analyseBaiduHeader($header);
        }
        

        /* Analyse Android WebView browser ids */

        if ($header = $this->getHeader('X-Requested-With')) {
            $this->analyseBrowserId($header);
        }
        

        /* Analyse WAP profile header */

        if ($header = $this->getHeader('X-Wap-Profile')) {
            $this->analyseWapProfile($header);
        }

        return $this;
    }



    private function analyseUserAgent($header)
    {
        new Header\Useragent($header, $this->data, $this->options);
    }

    private function analyseBaiduHeader($header)
    {
        new Header\Baidu($header, $this->data);
    }

    private function analyseOperaMiniPhone($header)
    {
        new Header\OperaMini($header, $this->data);
    }

    private function analyseBrowserId($header)
    {
        new Header\BrowserId($header, $this->data);
    }

    private function analysePuffinUserAgent($header)
    {
        new Header\Puffin($header, $this->data);
    }

    private function analyseNewUCUserAgent($header)
    {
        new Header\UCBrowserNew($header, $this->data);
    }

    private function analyseOldUCUserAgent($header)
    {
        new Header\UCBrowserOld($header, $this->data);
    }

    private function analyseWapProfile($header)
    {
        new Header\Wap($header, $this->data);
    }


    private function additionalUserAgent($ua)
    {
        $extra = new Parser($ua);

        if ($extra->device->type != Constants\DeviceType::DESKTOP) {
            if (isset($extra->os->name)) {
                $this->data->os = $extra->os;
            }
            
            if ($extra->device->identified) {
                $this->data->device = $extra->device;
            }
        }
    }


    private function getHeader($h)
    {
        foreach ($this->headers as $k => $v) {
            if (strtolower($h) == strtolower($k)) {
                return $v;
            }
        }
    }
}
