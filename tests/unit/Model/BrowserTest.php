<?php
namespace WhichBrowserTest;

use PHPUnit_Framework_TestCase;
use WhichBrowser\Constants;
use WhichBrowser\Model\Browser;
use WhichBrowser\Model\Family;
use WhichBrowser\Model\Using;
use WhichBrowser\Model\Version;

/**
 * @covers WhichBrowser\Model\Browser
 */
class BrowserTest extends PHPUnit_Framework_TestCase
{
    public function testDefaults()
    {
        $browser = new Browser();

        $this->assertEquals(true, $browser->stock);
        $this->assertEquals(false, $browser->hidden);
        $this->assertEquals('', $browser->mode);
        $this->assertEquals('', $browser->type);
    }

    public function testReset()
    {
        $browser = new Browser([
            'stock'     => false,
            'hidden'    => true,
            'mode'      => 'xxxx',
            'type'      => 'xxxx'
        ]);

        $browser->reset();

        $this->assertEquals(true, $browser->stock);
        $this->assertEquals(false, $browser->hidden);
        $this->assertEquals('', $browser->mode);
        $this->assertEquals('', $browser->type);
    }

    public function testGetName()
    {
        $browser = new Browser();

        $this->assertEquals('', $browser->getName());

        $browser->reset([
            'name'      => 'Chrome',
            'version'   => new Version([ 'value' => '47.0.2526.73', 'details' => 1 ])
        ]);

        $this->assertEquals('Chrome', $browser->getName());
    }

    public function testGetVersion()
    {
        $browser = new Browser();

        $this->assertEquals('', $browser->getVersion());

        $browser->reset([
            'name'      => 'Chrome',
            'version'   => new Version([ 'value' => '47.0.2524.23' ])
        ]);

        $this->assertEquals('47.0.2524.23', $browser->getVersion());

        $browser->reset([
            'name'      => 'Chrome',
            'version'   => new Version([ 'value' => '47.0.2526.73', 'details' => 1 ])
        ]);

        $this->assertEquals('47', $browser->getVersion());
    }

    public function testIsDetected()
    {
        $browser = new Browser();

        $this->assertFalse($browser->isDetected());

        $browser->reset([
            'name'      => 'Chrome',
            'version'   => new Version([ 'value' => '47.0.2526.73', 'details' => 1 ])
        ]);

        $this->assertTrue($browser->isDetected());
    }

    public function testIsFamily()
    {
        $browser = new Browser();

        $this->assertFalse($browser->isFamily('Chrome'));

        $browser->reset([
            'name'      => 'Chrome'
        ]);

        $this->assertTrue($browser->isFamily('Chrome'));

        $browser->reset([
            'name'      => 'Opera',
            'family'    => new Family([ 'name' => 'Chrome' ])
        ]);

        $this->assertTrue($browser->isFamily('Chrome'));

        $browser->reset([
            'name'      => 'Opera',
            'family'    => new Family([ 'name' => 'Chrome' ])
        ]);

        $this->assertFalse($browser->isFamily('Firefox'));
    }

    public function testIsToString()
    {
        $browser = new Browser();

        $this->assertEquals('', $browser->toString());

        $browser->reset([
            'name'      => 'Chrome',
            'version'   => new Version([ 'value' => '47.0.2526.73', 'details' => 1 ])
        ]);

        $this->assertEquals('Chrome 47', $browser->toString());

        $browser->reset([
            'name'      => 'Safari',
            'version'   => new Version([ 'value' => '8.0' ]),
            'hidden'    => true
        ]);

        $this->assertEquals('', $browser->toString());

        $browser->reset([
            'name'      => 'TestBrowser',
            'using'     => new Using([ 'name' => 'Crosswalk Webview' ])
        ]);

        $this->assertEquals('TestBrowser', $browser->toString());

        $browser->reset([
            'using'     => new Using([ 'name' => 'Crosswalk Webview' ])
        ]);

        $this->assertEquals('Crosswalk Webview', $browser->toString());

        $browser->reset([
            'name'      => 'BlackBerry Browser',
            'hidden'    => true
        ]);

        $this->assertEquals('', $browser->toString());

    }

    public function testIdentifyVersion()
    {
        $browser = new Browser();

        $browser->identifyVersion('/Chrome\/([0-9\.]+)/u', 'Chrome/47.0.2526.73', [ 'details' => 1 ]);

        $this->assertEquals('47', $browser->getVersion());


        $browser->reset();

        $browser->identifyVersion('/Mozilla\/([0-9\.]+)/u', 'Mozilla/2.03', [ 'type' => 'legacy' ]);

        $this->assertEquals('2.0.3', $browser->getVersion());


        $browser->reset();

        $browser->identifyVersion('/Safari\/([0-9\.]+)/u', 'Chrome\/47.0.2526.73');

        $this->assertEquals('', $browser->getVersion());
    }

    public function testToArray()
    {
        $browser = new Browser();

        $this->assertEquals([], $browser->toArray());

        $browser->set([
            'name'      => ''
        ]);

        $this->assertEquals([], $browser->toArray());

        $browser->reset([
            'name'      => 'Chrome',
            'version'   => new Version([ 'value' => '47.0.2526.73', 'details' => 1 ])
        ]);

        $this->assertEquals([
            'name'      => 'Chrome',
            'version'   => '47'
        ], $browser->toArray());

        $browser->reset([
            'name'      => 'TestBrowser',
            'alias'     => 'Alias'
        ]);

        $this->assertEquals([
            'name'      => 'TestBrowser',
            'alias'     => 'Alias'
        ], $browser->toArray());

        $browser->reset([
            'name'      => 'Opera',
            'family'    => new Family([ 'name' => 'Chrome' ])
        ]);

        $this->assertEquals([
            'name'      => 'Opera',
            'family'    => 'Chrome'
        ], $browser->toArray());

        $browser->reset([
            'name'      => 'TestBrowser',
            'using'     => new Using([ 'name' => 'Crosswalk WebView' ])
        ]);

        $this->assertEquals([
            'name'      => 'TestBrowser',
            'using'     => 'Crosswalk WebView'
        ], $browser->toArray());
    }
}
