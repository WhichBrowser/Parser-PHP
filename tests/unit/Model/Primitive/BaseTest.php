<?php
namespace WhichBrowserTest;

use PHPUnit_Framework_TestCase;
use WhichBrowser\Model\Primitive\Base;
use WhichBrowser\Model\Version;

/**
 * @covers WhichBrowser\Model\Base
 */
class BaseTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $base = new Base([
            'name'      => 'Generic',
        ]);

        $this->assertEquals('Generic', $base->name);
    }

    public function testSet()
    {
        $base = new Base();
        $base->set([
            'name'      => 'Generic',
        ]);

        $this->assertEquals('Generic', $base->name);
    }
}
