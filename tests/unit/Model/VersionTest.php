<?php
namespace WhichBrowserTest;

use PHPUnit_Framework_TestCase;
use WhichBrowser\Constants;
use WhichBrowser\Model\Version;

/**
 * @covers WhichBrowser\Model\Version
 */
class VersionTest extends PHPUnit_Framework_TestCase
{
    public function testIs()
    {
        $version = new Version([ 'value' => '40.0.2214' ]);

        $this->assertFalse($version->is());
        $this->assertFalse($version->is('39'));
        $this->assertTrue($version->is('40'));

        $version = new Version([ 'value' => '40.0.2214' ]);

        $this->assertTrue($version->is('=', '40'));
        $this->assertTrue($version->is('>=', '40'));
        $this->assertTrue($version->is('<=', '40'));
        $this->assertTrue($version->is('>', '39'));
        $this->assertTrue($version->is('<', '41'));

        $this->assertFalse($version->is('=', '39'));
        $this->assertFalse($version->is('>=', '41'));
        $this->assertFalse($version->is('<=', '39'));
        $this->assertFalse($version->is('>', '40'));
        $this->assertFalse($version->is('<', '40'));


        $version = new Version([ 'value' => '10.11.1' ]);

        $this->assertTrue($version->is('=', '10'));
        $this->assertTrue($version->is('=', '10.11'));
        $this->assertTrue($version->is('=', '10.11.1'));
        $this->assertTrue($version->is('=', '10.11.01'));

        $this->assertTrue($version->is('=', 10));
        $this->assertTrue($version->is('=', 10.11));

        $this->assertTrue($version->is('>', '10.1'));
        $this->assertTrue($version->is('>', '10.01'));
        $this->assertTrue($version->is('>', '10.10'));

        $this->assertFalse($version->is('>', '10'));
        $this->assertFalse($version->is('>', '10.11'));
    }

    public function testGetParts()
    {
        $version = new Version();

        $version->value = '';
        $this->assertEquals((object) [ 'major' => 0, 'minor' => 0, 'patch' => 0 ], $version->getParts());

        $version->value = '4';
        $this->assertEquals((object) [ 'major' => 4, 'minor' => 0, 'patch' => 0 ], $version->getParts());

        $version->value = '4.1';
        $this->assertEquals((object) [ 'major' => 4, 'minor' => 1, 'patch' => 0 ], $version->getParts());

        $version->value = '4.1.2';
        $this->assertEquals((object) [ 'major' => 4, 'minor' => 1, 'patch' => 2 ], $version->getParts());

        $version->value = '5';
        $this->assertEquals((object) [ 'major' => 5, 'minor' => 0, 'patch' => 0 ], $version->getParts());

        $version->value = '5.6';
        $this->assertEquals((object) [ 'major' => 5, 'minor' => 6, 'patch' => 0 ], $version->getParts());

        $version->value = '5.6.7';
        $this->assertEquals((object) [ 'major' => 5, 'minor' => 6, 'patch' => 7 ], $version->getParts());
    }

    public function testGetMajor()
    {
        $version = new Version();

        $version->value = '4';
        $this->assertEquals(4, $version->getMajor());

        $version->value = '4.1';
        $this->assertEquals(4, $version->getMajor());

        $version->value = '4.1.1';
        $this->assertEquals(4, $version->getMajor());
    }

    public function testGetMinor()
    {
        $version = new Version();

        $version->value = '4';
        $this->assertEquals(0, $version->getMinor());

        $version->value = '4.1';
        $this->assertEquals(1, $version->getMinor());

        $version->value = '4.1.1';
        $this->assertEquals(1, $version->getMinor());
    }

    public function testGetPatch()
    {
        $version = new Version();

        $version->value = '4';
        $this->assertEquals(0, $version->getPatch());

        $version->value = '4.1';
        $this->assertEquals(0, $version->getPatch());

        $version->value = '4.1.1';
        $this->assertEquals(1, $version->getPatch());
    }

    public function testToValue() {
        $version = new Version();

        $version->value = '4';
        $this->assertEquals(4, $this->invokeMethod($version, 'toValue'));

        $version->value = '4.1';
        $this->assertEquals(4.0001, $this->invokeMethod($version, 'toValue'));

        $version->value = '4.1.1';
        $this->assertEquals(4.00010001, $this->invokeMethod($version, 'toValue'));

        $version->value = '10.10.3';
        $this->assertEquals(10.00100003, $this->invokeMethod($version, 'toValue'));
    }

    public function testToFloat() {
        $version = new Version();

        $version->value = '4.1.1';
        $this->assertEquals(4.1, $version->toFloat());

        $version->value = '10.10.3';
        $this->assertEquals(10.1, $version->toFloat());
    }

    public function testToNumber() {
        $version = new Version();

        $version->value = '4.1.1';
        $this->assertEquals(4, $version->toNumber());

        $version->value = '10.10.3';
        $this->assertEquals(10, $version->toNumber());
    }

    public function testToString() {
        $version = new Version();

        $version->set([ 'value' => '4.1.1' ]);
        $this->assertEquals('4.1.1', $version->toString());

        $version->set([ 'value' => '4.1' ]);
        $this->assertEquals('4.1', $version->toString());

        $version->set([ 'value' => '4.0a4' ]);
        $this->assertEquals('4.0a4', $version->toString());

        $version->set([ 'value' => '4.0b2' ]);
        $this->assertEquals('4.0b2', $version->toString());


        $version = new Version();

        $version->set([ 'value' => '4.1.1', 'details' => 0 ]);
        $this->assertEquals('4.1.1', $version->toString());

        $version->set([ 'value' => '4.1.1', 'details' => 1 ]);
        $this->assertEquals('4', $version->toString());

        $version->set([ 'value' => '4.1.1', 'details' => 2 ]);
        $this->assertEquals('4.1', $version->toString());

        $version->set([ 'value' => '4.1.1', 'details' => 3 ]);
        $this->assertEquals('4.1.1', $version->toString());

        $version->set([ 'value' => '4.1.1', 'details' => 4 ]);
        $this->assertEquals('4.1.1', $version->toString());

        $version->set([ 'value' => '4.1', 'details' => 3 ]);
        $this->assertEquals('4.1', $version->toString());

        $version->set([ 'value' => '4.1.1', 'details' => -1 ]);
        $this->assertEquals('4.1', $version->toString());

        $version->set([ 'value' => '4.1.1', 'details' => -2 ]);
        $this->assertEquals('4', $version->toString());

        $version->set([ 'value' => '4.1.1', 'details' => -3 ]);
        $this->assertEquals('', $version->toString());

        $version->set([ 'value' => '4.1.1', 'details' => -4 ]);
        $this->assertEquals('', $version->toString());


        $version = new Version();

        $version->set([ 'value' => '5.0.2.999', 'builds' => false ]);
        $this->assertEquals('5.0.2.999', $version->toString());

        $version->set([ 'value' => '5.0.2.1000', 'builds' => false ]);
        $this->assertEquals('5.0.2', $version->toString());

        $version->set([ 'value' => '5.0.2.4428', 'builds' => false ]);
        $this->assertEquals('5.0.2', $version->toString());

        $version->set([ 'value' => '5.0.4428', 'builds' => false ]);
        $this->assertEquals('5.0', $version->toString());

        $version->set([ 'value' => '5.4428', 'builds' => false ]);
        $this->assertEquals('5', $version->toString());

        $version->set([ 'value' => '4428', 'builds' => false ]);
        $this->assertEquals('', $version->toString());


        $version = new Version();

        $version->set([ 'value' => '5.1', 'alias' => 'XP' ]);
        $this->assertEquals('XP', $version->toString());


        $version = new Version();

        $version->set([ 'value' => '10.11', 'nickname' => 'El Capitan' ]);
        $this->assertEquals('El Capitan 10.11', $version->toString());

        $version->set([ 'value' => '10.11.2', 'nickname' => 'El Capitan', 'details' => 2 ]);
        $this->assertEquals('El Capitan 10.11', $version->toString());
    }



    public function testToArray()
    {
        $version = new Version();

        $this->assertEquals([], $version->toArray());

        $version->set([ 'value' => '4.1.1' ]);
        $this->assertEquals('4.1.1', $version->toArray());

        $version->set([ 'value' => '4.1.1', 'details' => 2 ]);
        $this->assertEquals('4.1', $version->toArray());

        $version = new Version();

        $version->set([ 'value' => '5.1', 'alias' => 'XP' ]);
        $this->assertEquals([
            'value'     => '5.1',
            'alias'     => 'XP'
        ], $version->toArray());

        $version = new Version();

        $version->set([ 'value' => '10.11', 'nickname' => 'El Capitan' ]);
        $this->assertEquals([
            'value'     => '10.11',
            'nickname'  => 'El Capitan'
        ], $version->toArray());
    }


    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
