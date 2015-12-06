<?php
namespace WhichBrowserTest;

use PHPUnit_Framework_TestCase;
use WhichBrowser\Model\Primitive\Base;
use WhichBrowser\Model\Family;
use WhichBrowser\Model\Using;
use WhichBrowser\Model\Version;

/**
 * @covers WhichBrowser\Model\Primitive\Base
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

    public function testToJavaScript()
    {
        $base = new Base();
        $base->set([
            'name'      => 'Generic',
            'hidden'    => true,
            'count'     => 10,
            'version'   => new Version([ 'value' => '1.0' ]),
            'family'    => new Family([ 'name' => 'Generic' ]),
            'using'     => new Using([ 'name' => 'Generic' ])
        ]);

        $this->assertEquals('name: "Generic", hidden: true, count: 10, version: new Version({ value: "1.0", hidden: false }), family: new Family({ name: "Generic" }), using: new Using({ name: "Generic" })', $base->toJavaScript());
    }
}
