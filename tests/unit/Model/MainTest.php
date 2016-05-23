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

    public function testIsDetected()
    {
        $main = new Main();

        $this->assertFalse($main->isDetected());

        $main->browser->set([ 'name' => 'Chrome', 'version' => new Version([ 'value' => '47.0.2526.73', 'details' => 1 ]) ]);

        $this->assertTrue($main->isDetected());
    }

    public function testIsMobile()
    {
        $main = new Main();

        $main->device->setIdentification([
            'type'          =>  Constants\DeviceType::GAMING,
            'subtype'       =>  Constants\DeviceSubType::CONSOLE
        ]);

        $this->assertFalse($main->isMobile());

        $main->device->reset([
            'type'          =>  Constants\DeviceType::GAMING,
            'subtype'       =>  Constants\DeviceSubType::PORTABLE
        ]);

        $this->assertTrue($main->isMobile());

        $main->device->reset([
            'type'          =>  Constants\DeviceType::MOBILE,
            'subtype'       =>  Constants\DeviceSubType::SMART
        ]);

        $this->assertTrue($main->isMobile());

        $main->device->reset([
            'type'          =>  Constants\DeviceType::MOBILE,
            'subtype'       =>  Constants\DeviceSubType::FEATURE
        ]);

        $this->assertTrue($main->isMobile());

        $main->device->reset([
            'type'          =>  Constants\DeviceType::DESKTOP,
        ]);

        $this->assertFalse($main->isMobile());
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

    public function testToString()
    {
        $main = new Main();
        $this->assertEquals('an unknown browser', $main->toString());

        $main = new Main();
        $main->device->set([ 'type' => Constants\DeviceType::BOT ]);
        $this->assertEquals('an unknown bot', $main->toString());

        $main = new Main();
        $main->browser->set([ 'name' => 'Chrome', 'version' => new Version([ 'value' => '47.0.2526.73', 'details' => 1 ]) ]);
        $main->engine->set([ 'name' => 'Blink' ]);
        $main->os->set([ 'name' => 'OS X', 'version' => new Version([ 'value' => '10.11', 'nickname' => 'El Capitan' ]) ]);

        $this->assertEquals('Chrome 47 on OS X El Capitan 10.11', $main->toString());


        $main = new Main();
        $main->engine->set([ 'name' => 'WebKit' ]);
        $main->os->set([ 'name' => 'Tizen', 'version' => new Version([ 'value' => '2.0' ]) ]);

        $this->assertEquals('Tizen 2.0', $main->toString());


        $main = new Main();
        $main->browser->set([ 'name' => 'Chrome', 'version' => new Version([ 'value' => '47.0.2526.73', 'details' => 1 ]) ]);

        $this->assertEquals('Chrome 47', $main->toString());


        $main->browser->set([ 'name' => 'Safari', 'version' => new Version([ 'value' => '8.0' ]) ]);
        $main->engine->set([ 'name' => 'WebKit' ]);
        $main->os->set([ 'name' => 'iOS', 'version' => new Version([ 'value' => '8.0' ]) ]);
        $main->device->setIdentification([ 'manufacturer' => 'Apple', 'model' => 'iPhone 6', 'type' => Constants\DeviceType::MOBILE ]);

        $this->assertEquals('Safari 8.0 on an Apple iPhone 6 running iOS 8.0', $main->toString());


        $main = new Main();
        $main->browser->set([ 'name' => 'Chrome', 'version' => new Version([ 'value' => '47.0.2526.73', 'details' => 1 ]) ]);
        $main->os->set([ 'name' => 'Android', 'version' => new Version([ 'value' => '4.4' ]) ]);
        $main->device->set([ 'model' => 'SM-A300', 'type' => Constants\DeviceType::MOBILE ]);
        $this->assertEquals('Chrome 47 on an unrecognized device (SM-A300) running Android 4.4', $main->toString());


        $main = new Main();
        $main->browser->set([ 'stock' => true ]);
        $main->engine->set([ 'name' => 'Blink' ]);

        $this->assertEquals('an unknown browser based on Blink', $main->toString());


        $main = new Main();
        $main->engine->set([ 'name' => 'Blink' ]);
        $main->os->set([ 'name' => 'OS X', 'version' => new Version([ 'value' => '10.11', 'nickname' => 'El Capitan' ]) ]);
        $main->device->set([ 'type' => Constants\DeviceType::DESKTOP ]);

        $this->assertEquals('an unknown browser based on Blink running on OS X El Capitan 10.11', $main->toString());


        $main = new Main();
        $main->browser->set([ 'name' => 'Safari', 'version' => new Version([ 'value' => '8.0' ]) ]);
        $main->device->setIdentification([ 'manufacturer' => 'Apple', 'model' => 'iPhone 6', 'type' => Constants\DeviceType::MOBILE ]);

        $this->assertEquals('Safari 8.0 on an Apple iPhone 6', $main->toString());


        $main = new Main();
        $main->os->set([ 'name' => 'iOS', 'version' => new Version([ 'value' => '8.0' ]) ]);
        $main->device->setIdentification([ 'manufacturer' => 'Apple', 'model' => 'iPhone 6', 'type' => Constants\DeviceType::MOBILE ]);

        $this->assertEquals('an Apple iPhone 6 running iOS 8.0', $main->toString());


        $main = new Main();
        $main->device->setIdentification([ 'manufacturer' => 'Apple', 'model' => 'iPhone 6', 'type' => Constants\DeviceType::MOBILE ]);

        $this->assertEquals('an Apple iPhone 6', $main->toString());


        $main = new Main();
        $main->device->setIdentification([ 'type' => Constants\DeviceType::TELEVISION ]);

        $this->assertEquals('a television', $main->toString());


        $main = new Main();
        $main->device->setIdentification([ 'type' => Constants\DeviceType::EMULATOR ]);

        $this->assertEquals('an emulator', $main->toString());
    }

    public function testToJavaScript()
    {
        $main = new Main();
        $expected = <<<'EOD'
this.browser = new Browser({ stock: true, hidden: false, mode: "", type: "" });
this.engine = new Engine({  });
this.os = new Os({ hidden: false });
this.device = new Device({ type: "", subtype: "", identified: 0, generic: true, hidden: false });
this.camouflage = false;
this.features = [];

EOD;

        $this->assertEquals($expected, $main->toJavaScript());
    }

    public function testToArray()
    {
        $main = new Main();
        $this->assertEquals([], $main->toArray());

        $main->browser->set([ 'name' => 'Safari', 'version' => new Version([ 'value' => '8.0' ]) ]);
        $main->engine->set([ 'name' => 'WebKit' ]);
        $main->os->set([ 'name' => 'iOS', 'version' => new Version([ 'value' => '8.0' ]) ]);
        $main->device->setIdentification([ 'manufacturer' => 'Apple', 'model' => 'iPhone 6', 'type' => Constants\DeviceType::MOBILE ]);
        $this->assertEquals([
            'browser' => [
                'name'      => 'Safari',
                'version'   => '8.0'
            ],
            'engine' => [
                'name'      => 'WebKit'
            ],
            'os' => [
                'name'      => 'iOS',
                'version'   => '8.0'
            ],
            'device' => [
                'type'          => 'mobile',
                'manufacturer'  => 'Apple',
                'model'         => 'iPhone 6'
            ]
        ], $main->toArray());
    }
}
