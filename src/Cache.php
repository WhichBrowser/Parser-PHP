<?php

namespace WhichBrowser;

use Psr\Cache\CacheItemPoolInterface;

trait Cache
{
    private $cache;
    private $expires;

    /**
     * @var boolean     $cached   Was this result retrieve from the cache?
     */

    public $cached = false;


    /**
     * Enable caching of results
     *
     * @param  object   $cache     An PSR-6 cache pool (an object that implements Psr\Cache\CacheItemPoolInterface)
     * @param  int      $expires   Optional the number of seconds after which a cached item expires, default is 15 minutes
     */

    public function setCache($cache, $expires = 900)
    {
        $this->cache = $cache;
        $this->expires = $expires;
    }


    /**
     * Apply cached data to the main Parser object
     *
     * @internal
     *
     * @param  array    $data      An array with a key for every property it needs to apply
     */

    private function applyCachedData($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

        $this->cached = true;
    }


    /**
     * Retrieve the data that can be cached from the main Parser object
     *
     * @internal
     *
     * @return  array    An array with a key for every property that will be cached
     */

    private function retrieveCachedData()
    {
        return [
            'browser' => $this->browser,
            'engine' => $this->engine,
            'os' => $this->os,
            'device' => $this->device,
            'camouflage' => $this->camouflage,
            'features' => $this->features
        ];
    }


    /**
     * Retrieve the result from the cache, or analyse and store in the cache
     *
     * @internal
     *
     * @param  array|string     $headers   An array with all of the headers or a string with just the User-Agent header
     *
     * @return  boolean         did we actually retrieve or analyse results
     */

    private function analyseWithCache($headers, $options = [])
    {
        if (isset($options['cache'])) {
            if (isset($options['cacheExpires'])) {
                $this->setCache($options['cache'], $options['cacheExpires']);
            } else {
                $this->setCache($options['cache']);
            }
        }

        if ($this->cache instanceof CacheItemPoolInterface) {
            $item = $this->cache->getItem('whichbrowser-' . md5(serialize($headers)));

            if ($item->isHit()) {
                $this->applyCachedData($item->get());
            } else {
                $analyser = new Analyser($headers, $options);
                $analyser->setdata($this);
                $analyser->analyse();

                $item->set($this->retrieveCachedData());
                $item->expiresAfter($this->expires);
                $this->cache->save($item);
            }

            return true;
        }
    }
}
