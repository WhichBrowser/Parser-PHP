<?php

namespace WhichBrowser;

use WhichBrowser\Model\Main;

class Parser extends Main
{
    use Cache;

    /**
     * Create a new object that contains all the detected information
     *
     * @param  array|string   $headers   Optional, an array with all of the headers or a string with just the User-Agent header
     * @param  array          $options   Optional, an array with configuration options
     */

    public function __construct($headers = null, $options = [])
    {
        parent::__construct();

        if (!is_null($headers)) {
            $this->analyse($headers, $options);
        }
    }

    /**
     * Create a new Parser instance from a user agent string
     *
     * @param  string   $agent     Required, a string containing the raw User-Agent
     * @param  array    $options   Optional, an array with configuration options
     */
    public static function fromUserAgent($agent, array $options = [])
    {
        return new static($agent, $options);
    }

    /**
     * Create a new Parser instance from a user agent string
     *
     * @param  array    $headers    Required, an array with all of the headers
     * @param  array    $options    Optional, an array with configuration options
     */
    public static function fromHeaders(array $headers, array $options = [])
    {
        return new static($headers, $options);
    }

    /**
     * Analyse the provided headers or User-Agent string
     *
     * @param  array|string   $headers   An array with all of the headers or a string with just the User-Agent header
     */

    public function analyse($headers, $options = [])
    {
        $o = $options;

        if (is_string($headers)) {
            $h = [ 'User-Agent' => $headers ];
        } else {
            if (isset($headers['headers'])) {
                $h = $headers['headers'];

                unset($headers['headers']);
                $o = array_merge($headers, $options);
            } else {
                $h = $headers;
            }
        }

        if ($this->analyseWithCache($h, $o)) {
            return;
        }

        $analyser = new Analyser($h, $o);
        $analyser->setdata($this);
        $analyser->analyse();
    }
}
