<?php
namespace WhichBrowserTest;

use PHPUnit_Framework_TestCase;
use WhichBrowser\Constants;
use WhichBrowser\Model\Main;
use WhichBrowser\Model\Version;

/**
 * @covers WhichBrowser\Model\Main
 */
class MainTest extends PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $main = new Main();

        $this->assertTrue($main->browser instanceof \WhichBrowser\Model\Browser);
        $this->assertTrue($main->engine instanceof \WhichBrowser\Model\Engine);
        $this->assertTrue($main->os instanceof \WhichBrowser\Model\Os);
        $this->assertTrue($main->device instanceof \WhichBrowser\Model\Device);
    }

    public function testIs()
    {
        $main = new Main();

        $this->assertFalse($main->isBrowser('Chrome'));
        $this->assertFalse($main->isBrowser('Chrome', '=', '40'));
        $this->assertFalse($main->isOs('OS X'));
        $this->assertFalse($main->isEngine('WebKit'));


        $main->browser->set([
            'name'      => 'Chrome',
            'version'   => new Version([ 'value' => '40.0.2214', 'details' => 1 ])
        ]);

        $this->assertTrue($main->isBrowser('Chrome'));

        $this->assertFalse($main->isBrowser());
        $this->assertFalse($main->isBrowser('Safari'));

        $this->assertTrue($main->isBrowser('Chrome', '=', '40'));
        $this->assertTrue($main->isBrowser('Chrome', '>=', '40'));
        $this->assertTrue($main->isBrowser('Chrome', '<=', '40'));
        $this->assertTrue($main->isBrowser('Chrome', '>', '39'));
        $this->assertTrue($main->isBrowser('Chrome', '<', '41'));

        $this->assertFalse($main->isBrowser('Chrome', '=', '39'));
        $this->assertFalse($main->isBrowser('Chrome', '>=', '41'));
        $this->assertFalse($main->isBrowser('Chrome', '<=', '39'));
        $this->assertFalse($main->isBrowser('Chrome', '>', '40'));
        $this->assertFalse($main->isBrowser('Chrome', '<', '40'));


        $main->os->set([
            'name'      => 'OS X',
            'version'   => new Version([ 'value' => '10.11.1', 'details' => 2 ])
        ]);

        $this->assertTrue($main->isOs('OS X'));

        $this->assertTrue($main->isOs('OS X', '=', '10'));
        $this->assertTrue($main->isOs('OS X', '=', '10.11'));
        $this->assertTrue($main->isOs('OS X', '=', '10.11.1'));
        $this->assertTrue($main->isOs('OS X', '=', '10.11.01'));

        $this->assertTrue($main->isOs('OS X', '=', 10));
        $this->assertTrue($main->isOs('OS X', '=', 10.11));

        $this->assertTrue($main->isOs('OS X', '>', '10.1'));
        $this->assertTrue($main->isOs('OS X', '>', '10.01'));
        $this->assertTrue($main->isOs('OS X', '>', '10.10'));

        $this->assertFalse($main->isOs('OS X', '>', '10'));
        $this->assertFalse($main->isOs('OS X', '>', '10.11'));


        $main->engine->set([
            'name'      => 'WebKit'
        ]);

        $this->assertTrue($main->isEngine('WebKit'));
        $this->assertFalse($main->isEngine('WebKit', '=', '523'));
    }

    public function testIsDevice()
    {
        $main = new Main();

        $main->device->setIdentification([
            'manufacturer'  =>  'Sony',
            'model'         =>  'PRS-T2',
            'series'        =>  'Reader'
        ]);

        $this->assertTrue($main->isDevice('Reader'));
        $this->assertTrue($main->isDevice('PRS-T2'));
    }

    public function testIsType()
    {
        $main = new Main();

        $main->device->setIdentification([
            'manufacturer'  =>  'Nintendo',
            'model'         =>  'Wii',
            'type'          =>  Constants\DeviceType::GAMING,
            'subtype'       =>  Constants\DeviceSubType::CONSOLE
        ]);

        $this->assertTrue($main->isType('gaming'));
        $this->assertTrue($main->isType('gaming:console'));

        $this->assertFalse($main->isType('mobile'));
        $this->assertFalse($main->isType('mobile:portable'));
        $this->assertFalse($main->isType('gaming:portable'));

        $this->assertTrue($main->isType('television', 'gaming'));
        $this->assertTrue($main->isType('gaming', 'television', 'gaming'));
        $this->assertTrue($main->isType('gaming:portable', 'gaming:console'));
    }

    public function testGetType()
    {
        $main = new Main();

        $main->device->reset([
            'type'          =>  Constants\DeviceType::GAMING
        ]);

        $this->assertEquals('gaming', $main->getType());

        $main->device->reset([
            'type'          =>  Constants\DeviceType::GAMING,
            'subtype'       =>  Constants\DeviceSubType::CONSOLE
        ]);

        $this->assertEquals('gaming:console', $main->getType());

        $main->device->reset([
            'type'          =>  Constants\DeviceType::GAMING,
            'subtype'       =>  Constants\DeviceSubType::PORTABLE
        ]);

        $this->assertEquals('gaming:portable', $main->getType());

        $main->device->reset([
            'type'          =>  Constants\DeviceType::MOBILE
        ]);

        $this->assertEquals('mobile', $main->getType());

        $main->device->reset([
            'type'          =>  Constants\DeviceType::MOBILE,
            'subtype'       =>  Constants\DeviceSubType::SMART
        ]);

        $this->assertEquals('mobile:smart', $main->getType());

        $main->device->reset([
            'type'          =>  Constants\DeviceType::MOBILE,
            'subtype'       =>  Constants\DeviceSubType::FEATURE
        ]);

        $this->assertEquals('mobile:feature', $main->getType());
    }
}
