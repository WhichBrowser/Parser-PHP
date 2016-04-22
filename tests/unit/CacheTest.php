<?php
namespace WhichBrowserTest;

use PHPUnit_Framework_TestCase;
use WhichBrowser\Parser;
use Cache\Adapter\PHPArray\ArrayCachePool;

/**
 * @covers WhichBrowser\Cache
 * @covers WhichBrowser\Parser::analyse
 */
class CacheTest extends PHPUnit_Framework_TestCase
{
    /**
     * @requires PHP 5.5
     */

    public function testCreatingParserWithoutArgumentsAndCallAnalyse()
    {
        function countCachedItems($pool) {
            $items = 0;

            $reflector = new \ReflectionClass($pool);
            if ($reflector->hasProperty('cache')) {
                $property = $reflector->getProperty('cache');
                $property->setAccessible(true);
                $items = count($property->getValue($pool));
            }

            return $items;
        }

        $pool = new ArrayCachePool();

        $this->assertEquals(0, countCachedItems($pool));

        $parser = new Parser();
        $parser->setCache($pool);
        $parser->analyse("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; InfoPath.1)");
        $result = $parser->toArray();

        $this->assertEquals(1, countCachedItems($pool));
        $this->assertEquals(false, $parser->cached);

        $parser = new Parser();
        $parser->setCache($pool);
        $parser->analyse("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; InfoPath.1)");

        $this->assertEquals($result, $parser->toArray());
        $this->assertEquals(true, $parser->cached);

        $parser = new Parser("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; InfoPath.1)", [ 'cache' => $pool ]);

        $this->assertEquals($result, $parser->toArray());
        $this->assertEquals(true, $parser->cached);

        $parser = new Parser("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; InfoPath.1)", [ 'cache' => $pool, 'cacheExpires' => 0 ]);

        $this->assertEquals($result, $parser->toArray());
        $this->assertEquals(true, $parser->cached);
    }
}
