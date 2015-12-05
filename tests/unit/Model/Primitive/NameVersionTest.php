<?php
namespace WhichBrowserTest;

use PHPUnit_Framework_TestCase;
use WhichBrowser\Model\Primitive\NameVersion;
use WhichBrowser\Model\Version;

/**
 * @covers WhichBrowser\Model\Primitive\NameVersion
 */
class NameVersionTest extends PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $nameversion = new NameVersion();

        $this->assertEquals('', $nameversion->getName());

        $nameversion->reset([
            'name'      => 'Generic',
            'version'   => new Version([ 'value' => '1.0' ])
        ]);

        $this->assertEquals('Generic', $nameversion->getName());

        $nameversion->reset([
            'name'      => 'Generic',
            'alias'     => 'Alias',
            'version'   => new Version([ 'value' => '1.0' ])
        ]);

        $this->assertEquals('Alias', $nameversion->getName());
    }

    public function testGetVersion()
    {
        $nameversion = new NameVersion();

        $this->assertEquals('', $nameversion->getVersion());

        $nameversion->reset([
            'name'      => 'Generic',
            'version'   => new Version([ 'value' => '1.0' ])
        ]);

        $this->assertEquals('1.0', $nameversion->getVersion());

        $nameversion->reset([
            'name'      => 'Generic',
            'version'   => new Version([ 'value' => '1.0', 'details' => 1 ])
        ]);

        $this->assertEquals('1', $nameversion->getVersion());
    }

    public function testIsDetected()
    {
        $nameversion = new NameVersion();

        $this->assertFalse($nameversion->isDetected());

        $nameversion->reset([
            'name'      => 'Generic',
            'version'   => new Version([ 'value' => '1.0' ])
        ]);

        $this->assertTrue($nameversion->isDetected());
    }

    public function testIsToString()
    {
        $nameversion = new NameVersion();

        $this->assertEquals('', $nameversion->toString());

        $nameversion->reset([
            'name'      => 'Generic',
            'version'   => new Version([ 'value' => '1.0' ])
        ]);

        $this->assertEquals('Generic 1.0', $nameversion->toString());

        $nameversion->reset([
            'name'      => 'Generic',
            'alias'     => 'Alias',
            'version'   => new Version([ 'value' => '1.0' ])
        ]);

        $this->assertEquals('Alias 1.0', $nameversion->toString());
    }

    public function testIdentifyVersion()
    {
        $nameversion = new NameVersion();

        $nameversion->identifyVersion('/Version\/([0-9\.]+)/u', 'Version/1.0');

        $this->assertEquals('1.0', $nameversion->getVersion());


        $nameversion->reset();

        $nameversion->identifyVersion('/Version\/([0-9\.]+)/u', 'Other/1.0');

        $this->assertEquals('', $nameversion->getVersion());


        $nameversion->reset();

        $nameversion->identifyVersion('/Version\/([0-9\.]+)/u', 'Version/1.0', [ 'details' => 1 ]);

        $this->assertEquals('1', $nameversion->getVersion());


        $nameversion->reset();

        $nameversion->identifyVersion('/Version\/([0-9_]+)/u', 'Version/1_0_2', [ 'type' => 'underscore' ]);

        $this->assertEquals('1.0.2', $nameversion->getVersion());


        $nameversion->reset();

        $nameversion->identifyVersion('/Version\/([0-9\.]+)/u', 'Version/1.02', [ 'type' => 'legacy' ]);

        $this->assertEquals('1.0.2', $nameversion->getVersion());
    }
}
