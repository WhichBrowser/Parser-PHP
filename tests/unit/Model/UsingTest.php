<?php
namespace WhichBrowserTest;

use PHPUnit_Framework_TestCase;
use WhichBrowser\Constants;
use WhichBrowser\Model\Using;
use WhichBrowser\Model\Version;

/**
 * @covers WhichBrowser\Model\Using
 */
class UsingTest extends PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $using = new Using();

        $this->assertEquals('', $using->getName());

        $using->reset([
            'name'      => 'Crosswalk WebView',
            'version'   => new Version([ 'value' => '11' ])
        ]);

        $this->assertEquals('Crosswalk WebView', $using->getName());
    }

    public function testGetVersion()
    {
        $using = new Using();

        $this->assertEquals('', $using->getVersion());

        $using->reset([
            'name'      => 'Crosswalk WebView',
            'version'   => new Version([ 'value' => '11' ])
        ]);

        $this->assertEquals('11', $using->getVersion());
    }

    public function testIsToString()
    {
        $using = new Using();

        $this->assertEquals('', $using->toString());

        $using->reset([
            'name'      => 'Crosswalk WebView',
            'version'   => new Version([ 'value' => '11' ])
        ]);

        $this->assertEquals('Crosswalk WebView 11', $using->toString());
    }

    public function testToArray()
    {
        $using = new Using();

        $this->assertEquals([], $using->toArray());

        $using->set([
            'name'      => 'Crosswalk WebView',
            'version'   => new Version([ 'value' => '11' ])
        ]);

        $this->assertEquals([
            'name'      => 'Crosswalk WebView',
            'version'   => '11'
        ], $using->toArray());
    }
}
