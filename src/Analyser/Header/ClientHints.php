<?php

namespace WhichBrowser\Analyser\Header;

class ClientHints
{
    use ClientHints\Browser, ClientHints\Platform;

    public function __construct($headers, &$data)
    {
        $this->headers =& $headers;
        $this->data =& $data;

        if ($header = $this->getHeader('Sec-CH-UA')) {
            $this->detectBrowser($header);
        }

        if ($header = $this->getHeader('Sec-CH-UA-Platform')) {
            $this->detectPlatform($header);
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
