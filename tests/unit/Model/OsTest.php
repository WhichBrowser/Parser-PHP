<?php
namespace WhichBrowserTest;

use PHPUnit_Framework_TestCase;
use WhichBrowser\Constants;
use WhichBrowser\Model\Os;
use WhichBrowser\Model\Family;
use WhichBrowser\Model\Version;

/**
 * @covers WhichBrowser\Model\Os
 */
class OsTest extends PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $os = new Os();

        $this->assertEquals('', $os->getName());

        $os->reset([
            'name'      => 'iOS',
            'version'   => new Version([ 'value' => '8.0' ])
        ]);

        $this->assertEquals('iOS', $os->getName());

        $os->reset([
            'name'      => 'iOS',
            'alias'     => 'iPhone OS',
            'version'   => new Version([ 'value' => '3.0' ])
        ]);

        $this->assertEquals('iPhone OS', $os->getName());
    }

    public function testGetVersion()
    {
        $os = new Os();

        $this->assertEquals('', $os->getVersion());

        $os->reset([
            'name'      => 'iOS',
            'version'   => new Version([ 'value' => '8.0' ])
        ]);

        $this->assertEquals('8.0', $os->getVersion());

        $os->reset([
            'name'      => 'OS X',
            'version'   => new Version([ 'value' => '10.11', 'nickname' => 'El Capitan' ])
        ]);

        $this->assertEquals('El Capitan 10.11', $os->getVersion());

        $os->reset([
            'name'      => 'Windows',
            'version'   => new Version([ 'value' => '5.1', 'alias' => 'XP' ])
        ]);

        $this->assertEquals('XP', $os->getVersion());
    }

    public function testIsDetected()
    {
        $os = new Os();

        $this->assertFalse($os->isDetected());

        $os->reset([
            'name'      => 'iOS',
            'version'   => new Version([ 'value' => '8.0' ])
        ]);

        $this->assertTrue($os->isDetected());
    }

    public function testIsFamily()
    {
        $os = new Os();

        $this->assertFalse($os->isFamily('Android'));

        $os->reset([
            'name'      => 'Android'
        ]);

        $this->assertTrue($os->isFamily('Android'));

        $os->reset([
            'name'      => 'FireOS',
            'family'    => new Family([ 'name' => 'Android' ])
        ]);

        $this->assertTrue($os->isFamily('Android'));

        $os->reset([
            'name'      => 'FireOS',
            'family'    => new Family([ 'name' => 'Android' ])
        ]);

        $this->assertFalse($os->isFamily('iOS'));
    }

    public function testToString()
    {
        $os = new Os();

        $this->assertEquals('', $os->toString());

        $os->reset([
            'name'      => 'iOS',
            'version'   => new Version([ 'value' => '8.0' ])
        ]);

        $this->assertEquals('iOS 8.0', $os->toString());

        $os->reset([
            'name'      => 'iOS',
            'alias'     => 'iPhone OS',
            'version'   => new Version([ 'value' => '3.0' ])
        ]);

        $this->assertEquals('iPhone OS 3.0', $os->toString());


        $os->reset([
            'name'      => 'OS X',
            'version'   => new Version([ 'value' => '10.11', 'nickname' => 'El Capitan' ])
        ]);

        $this->assertEquals('OS X El Capitan 10.11', $os->toString());


        $os->reset([
            'name'      => 'Windows',
            'version'   => new Version([ 'value' => '5.1', 'alias' => 'XP' ])
        ]);

        $this->assertEquals('Windows XP', $os->toString());


        $os->reset([
            'name'      => 'Windows Phone',
            'alias'     => 'Windows',
            'edition'   => 'Mobile',
            'version'   => new Version([ 'value' => '10.0', 'alias' => '10' ])
        ]);

        $this->assertEquals('Windows 10 Mobile', $os->toString());


        $os->reset([
            'name'      => 'webOS',
            'hidden'    => true
        ]);

        $this->assertEquals('', $os->toString());
    }

    public function testIdentifyVersion()
    {
        $os = new Os();

        $os->identifyVersion('/OS ([0-9_]+)/u', 'iPhone OS 9_0_2', [ 'type' => 'underscore' ]);

        $this->assertEquals('9.0.2', $os->getVersion());


        $os->reset();

        $os->identifyVersion('/Android\/([0-9\.]+)/u', 'Android/6.0');

        $this->assertEquals('6.0', $os->getVersion());


        $os->reset();

        $os->identifyVersion('/Tizen\/([0-9\.]+)/u', 'Android/6.0');

        $this->assertEquals('', $os->getVersion());
    }

    public function testToArray()
    {
        $os = new Os();

        $this->assertEquals([], $os->toArray());

        $os->set([
            'name'      => ''
        ]);

        $this->assertEquals([], $os->toArray());

        $os->reset([
            'name'      => 'iOS',
            'version'   => new Version([ 'value' => '8.0' ])
        ]);

        $this->assertEquals([
            'name'      => 'iOS',
            'version'   => '8.0'
        ], $os->toArray());

        $os->reset([
            'name'      => 'iOS',
            'alias'     => 'iPhone OS',
            'version'   => new Version([ 'value' => '3.0' ])
        ]);

        $this->assertEquals([
            'name'      => 'iOS',
            'alias'     => 'iPhone OS',
            'version'   => '3.0'
        ], $os->toArray());

        $os->reset([
            'name'      => 'OS X',
            'version'   => new Version([ 'value' => '10.11', 'nickname' => 'El Capitan' ])
        ]);

        $this->assertEquals([
            'name'      => 'OS X',
            'version'   => [
                'value'     => '10.11',
                'nickname'  => 'El Capitan'
            ]
        ], $os->toArray());

        $os->reset([
            'name'      => 'Windows',
            'version'   => new Version([ 'value' => '5.1', 'alias' => 'XP' ])
        ]);

        $this->assertEquals([
            'name'      => 'Windows',
            'version'   => [
                'value'     => '5.1',
                'alias'     => 'XP'
            ]
        ], $os->toArray());

        $os->reset([
            'name'      => 'Windows Phone',
            'alias'     => 'Windows',
            'edition'   => 'Mobile',
            'version'   => new Version([ 'value' => '10.0', 'alias' => '10' ])
        ]);

        $this->assertEquals([
            'name'      => 'Windows Phone',
            'alias'     => 'Windows',
            'edition'   => 'Mobile',
            'version'   => [
                'value'     => '10.0',
                'alias'     => '10'
            ]
        ], $os->toArray());

        $os->reset([
            'name'      => 'FireOS',
            'family'   => new Family([ 'name' => 'Android' ])
        ]);

        $this->assertEquals([
            'name'      => 'FireOS',
            'family'    => 'Android'
        ], $os->toArray());
    }
}
