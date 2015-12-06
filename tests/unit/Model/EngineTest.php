<?php
namespace WhichBrowserTest;

use PHPUnit_Framework_TestCase;
use WhichBrowser\Constants;
use WhichBrowser\Model\Engine;
use WhichBrowser\Model\Version;

/**
 * @covers WhichBrowser\Model\Engine
 */
class EngineTest extends PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $engine = new Engine();

        $this->assertEquals('', $engine->getName());

        $engine->reset([
            'name'      => 'WebKit',
            'version'   => new Version([ 'value' => '601.3.9' ])
        ]);

        $this->assertEquals('WebKit', $engine->getName());

        $engine->reset([
            'name'      => 'WebKit',
            'alias'     => 'Blink',
            'version'   => new Version([ 'value' => '601.3.9' ])
        ]);

        $this->assertEquals('Blink', $engine->getName());
    }

    public function testGetVersion()
    {
        $engine = new Engine();

        $this->assertEquals('', $engine->getVersion());

        $engine->reset([
            'name'      => 'WebKit',
            'version'   => new Version([ 'value' => '601.3.9' ])
        ]);

        $this->assertEquals('601.3.9', $engine->getVersion());

        $engine->reset([
            'name'      => 'WebKit',
            'version'   => new Version([ 'value' => '601.3.9', 'details' => 1 ])
        ]);

        $this->assertEquals('601', $engine->getVersion());
    }

    public function testIsDetected()
    {
        $engine = new Engine();

        $this->assertFalse($engine->isDetected());

        $engine->reset([
            'name'      => 'WebKit',
            'version'   => new Version([ 'value' => '601.3.9' ])
        ]);

        $this->assertTrue($engine->isDetected());
    }

    public function testIsToString()
    {
        $engine = new Engine();

        $this->assertEquals('', $engine->toString());

        $engine->reset([
            'name'      => 'WebKit',
            'version'   => new Version([ 'value' => '601.3.9' ])
        ]);

        $this->assertEquals('WebKit 601.3.9', $engine->toString());

        $engine->reset([
            'name'      => 'WebKit',
            'alias'     => 'Blink',
            'version'   => new Version([ 'value' => '601.3.9' ])
        ]);

        $this->assertEquals('Blink 601.3.9', $engine->toString());
    }

    public function testIdentifyVersion()
    {
        $engine = new Engine();

        $engine->identifyVersion('/AppleWebKit\/([0-9\.]+)/u', 'AppleWebKit/601.3.9');

        $this->assertEquals('601.3.9', $engine->getVersion());


        $engine->reset();

        $engine->identifyVersion('/AppleWebKit\/([0-9\.]+)/u', 'Gecko/19.0');

        $this->assertEquals('', $engine->getVersion());


        $engine->reset();

        $engine->identifyVersion('/AppleWebKit\/([0-9\.]+)/u', 'AppleWebKit/601.3.9', [ 'details' => 1]);

        $this->assertEquals('601', $engine->getVersion());
    }

    public function testToArray()
    {
        $engine = new Engine();

        $this->assertEquals([], $engine->toArray());

        $engine->set([
            'name'      => null
        ]);

        $this->assertEquals([], $engine->toArray());

        $engine->reset([
            'name'      => 'WebKit',
            'version'   => new Version([ 'value' => '601.3.9' ])
        ]);

        $this->assertEquals([
            'name'      => 'WebKit',
            'version'   => '601.3.9'
        ], $engine->toArray());
    }
}
