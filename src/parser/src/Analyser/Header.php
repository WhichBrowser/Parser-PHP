<?php

namespace WhichBrowser\Analyser;

trait Header
{
    use Header\Baidu, Header\BrowserId, Header\OperaMini, Header\Puffin,
        Header\UC, Header\Useragent, Header\Wap;

    private function analyseHeaders()
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
