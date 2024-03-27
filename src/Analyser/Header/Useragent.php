<?php

namespace WhichBrowser\Analyser\Header;

class Useragent
{
    use Useragent\Os, Useragent\Device, Useragent\Browser, Useragent\Application, Useragent\Using, Useragent\Engine, Useragent\Bot;

    private $data;
    private $options;

    public function __construct(string $header, object $data, object $options)
    {
        $this->setData($data);
        $this->setOptions($options);

        /* Make sure we do not have a duplicate concatenated useragent string */
        $header = preg_replace("/^(Mozilla\/[0-9]\.[0-9].{20,})\s+Mozilla\/[0-9]\.[0-9].*$/iu", '$1', $header);

        /* Detect the basic information */
        $this->detectOperatingSystem($header)
            ->detectDevice($header)
            ->detectBrowser($header)
            ->detectApplication($header)
            ->detectUsing($header)
            ->detectEngine($header);

        /* Detect bots */
        if (!isset($this->options->detectBots) || $this->options->detectBots === true) {
            $this->detectBot($header);
        }

        /* Refine some of the information */
        $this->refineBrowser($header)
            ->refineOperatingSystem($header);
    }

    private function setData(object $data): void
    {
        $this->data = $data;
    }

    private function setOptions(object $options): void
    {
        $this->options = $options;
    }
}
