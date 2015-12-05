<?php
namespace WhichBrowserTest;

use PHPUnit_Framework_TestCase;
use WhichBrowser\Constants;
use WhichBrowser\Model\Family;
use WhichBrowser\Model\Version;

/**
 * @covers WhichBrowser\Model\Family
 */
class FamilyTest extends PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $family = new Family();

        $this->assertEquals('', $family->getName());

        $family->reset([
            'name'      => 'Android',
            'version'   => new Version([ 'value' => '4.1.1' ])
        ]);

        $this->assertEquals('Android', $family->getName());
    }

    public function testGetVersion()
    {
        $family = new Family();

        $this->assertEquals('', $family->getVersion());

        $family->reset([
            'name'      => 'Android',
            'version'   => new Version([ 'value' => '4.1.1' ])
        ]);

        $this->assertEquals('4.1.1', $family->getVersion());
    }

    public function testIsToString()
    {
        $family = new Family();

        $this->assertEquals('', $family->toString());

        $family->reset([
            'name'      => 'Android',
            'version'   => new Version([ 'value' => '4.1.1' ])
        ]);

        $this->assertEquals('Android 4.1.1', $family->toString());
    }

    public function testToArray()
    {
        $family = new Family();

        $this->assertEquals([], $family->toArray());

        $family->set([
            'name'      => 'Android',
            'version'   => new Version([ 'value' => '4.1.1' ])
        ]);

        $this->assertEquals([
            'name'      => 'Android',
            'version'   => '4.1.1'
        ], $family->toArray());
    }
}
