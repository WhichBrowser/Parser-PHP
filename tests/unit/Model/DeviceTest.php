<?php
namespace WhichBrowserTest;

use PHPUnit_Framework_TestCase;
use WhichBrowser\Constants;
use WhichBrowser\Model\Device;

/**
 * @covers WhichBrowser\Model\Device
 */
class DeviceTest extends PHPUnit_Framework_TestCase
{
    public function testDefaults()
    {
        $device = new Device();

        $this->assertEquals(true, $device->generic);
        $this->assertEquals(Constants\Id::NONE, $device->identified);
        $this->assertEquals('', $device->type);
        $this->assertEquals('', $device->subtype);
    }

    public function testEmpty()
    {
        $device = new Device();

        $this->assertEquals('', $device->getManufacturer());
        $this->assertEquals('', $device->getModel());
        $this->assertEquals('', $device->getCarrier());
    }

    public function testWithDefaults()
    {
        $device = new Device([ 'model' => 'Wii' ]);

        $this->assertEquals('Wii', $device->getModel());
    }

    public function testSet()
    {
        $device = new Device();

        $device->set([ 'model' => 'Wii' ]);

        $this->assertEquals('Wii', $device->getModel());
    }

    public function testSetIdenfication()
    {
        $device = new Device();

        $device->setIdentification([
            'manufacturer'  =>  'Microsoft',
            'model'         =>  'Xbox One'
        ]);

        $this->assertEquals('Microsoft', $device->getManufacturer());
        $this->assertEquals('Xbox One', $device->getModel());
        $this->assertEquals(false, $device->generic);
    }

    public function testReset()
    {
        $device = new Device();

        $device->setIdentification([
            'manufacturer'  =>  'Nintendo',
            'model'         =>  'Wii'
        ]);

        $this->assertEquals('Nintendo', $device->getManufacturer());
        $this->assertEquals('Wii', $device->getModel());
        $this->assertEquals(false, $device->generic);

        $device->reset();

        $this->assertEquals('', $device->getManufacturer());
        $this->assertEquals('', $device->getModel());

        $this->assertEquals(true, $device->generic);
        $this->assertEquals(Constants\Id::NONE, $device->identified);
        $this->assertEquals('', $device->type);
        $this->assertEquals('', $device->subtype);
    }

    public function testResetWithDefaults()
    {
        $device = new Device();

        $device->setIdentification([ 'model' => 'Wii' ]);

        $this->assertEquals('Wii', $device->getModel());
        $this->assertEquals(false, $device->generic);

        $device->reset([ 'model' => 'Xbox One' ]);

        $this->assertEquals('Xbox One', $device->getModel());
        $this->assertEquals(true, $device->generic);
    }

    public function testModelNoSeries()
    {
        $device = new Device();

        $device->setIdentification([
            'manufacturer'  =>  'Nintendo',
            'model'         =>  'Wii'
        ]);

        $this->assertEquals('Nintendo', $device->getManufacturer());
        $this->assertEquals('Wii', $device->getModel());

        $this->assertEquals('Nintendo', $device->manufacturer);
        $this->assertEquals('Wii', $device->model);
        $this->assertEquals(false, $device->generic);
    }

    public function testSeriesNoModel()
    {
        $device = new Device();

        $device->setIdentification([
            'manufacturer'  =>  'Kobo',
            'series'        =>  'eReader'
        ]);

        $this->assertEquals('Kobo', $device->getManufacturer());
        $this->assertEquals('eReader', $device->getModel());

        $this->assertEquals('Kobo', $device->manufacturer);
        $this->assertEquals('eReader', $device->series);
        $this->assertEquals(true, $device->generic);
    }

    public function testModelAndSeries()
    {
        $device = new Device();

        $device->setIdentification([
            'manufacturer'  =>  'Sony',
            'model'         =>  'PRS-T2',
            'series'        =>  'Reader'
        ]);

        $this->assertEquals('Sony', $device->getManufacturer());
        $this->assertEquals('PRS-T2 Reader', $device->getModel());

        $this->assertEquals('Sony', $device->manufacturer);
        $this->assertEquals('PRS-T2', $device->model);
        $this->assertEquals('Reader', $device->series);
        $this->assertEquals(false, $device->generic);
    }

    public function testCarrier()
    {
        $device = new Device();

        $device->setIdentification([
            'manufacturer'  =>  'NEC',
            'model'         =>  'N2002',
            'carrier'       =>  'DoCoMo',
        ]);

        $this->assertEquals('DoCoMo', $device->getCarrier());
        $this->assertEquals('DoCoMo', $device->carrier);
        $this->assertEquals(false, $device->generic);
    }


    public function testSetWithoutIdentified()
    {
        $device = new Device();

        $device->set([
            'manufacturer'  =>  'Microsoft',
            'model'         =>  'Xbox One',
        ]);

        $this->assertEquals('', $device->getManufacturer());
        $this->assertEquals('Xbox One', $device->getModel());
        $this->assertEquals(true, $device->generic);
    }

    public function testToString()
    {
        $device = new Device();

        $this->assertEquals('', $device->toString());

        $device->setIdentification([
            'manufacturer'  =>  'Kobo',
            'series'        =>  'eReader'
        ]);

        $this->assertEquals('Kobo eReader', $device->toString());

        $device->setIdentification([
            'manufacturer'  =>  'Nintendo',
            'model'         =>  'Wii'
        ]);

        $this->assertEquals('Nintendo Wii', $device->toString());

        $device->setIdentification([
            'manufacturer'  =>  'Sony',
            'model'         =>  'PRS-T2',
            'series'        =>  'Reader'
        ]);

        $this->assertEquals('Sony PRS-T2 Reader', $device->toString());

        $device->setIdentification([
            'manufacturer'  =>  'Apple',
            'model'         =>  'AppleTV'
        ]);

        $this->assertEquals('AppleTV', $device->toString());

        $device->setIdentification([
            'manufacturer'  =>  'OUYA',
            'model'         =>  'OUYA'
        ]);

        $this->assertEquals('OUYA', $device->toString());
        
        $device->setIdentification([
            'manufacturer'  =>  'Apple',
            'model'         =>  'Macintosh',
            'hidden'        =>  true
        ]);

        $this->assertEquals('', $device->toString());
    }

    public function testDetected()
    {
        $device = new Device();

        $this->assertFalse($device->isDetected());

        $device->set([
            'manufacturer'  =>  'Microsoft',
            'model'         =>  'Xbox One',
        ]);

        $this->assertTrue($device->isDetected());

        $device->reset();

        $this->assertFalse($device->isDetected());

        $device->set([ 'model' => 'Xbox One' ]);

        $this->assertTrue($device->isDetected());

        $device->set([ 'manufacturer' => 'Microsoft' ]);

        $this->assertTrue($device->isDetected());
    }

    public function testToArray()
    {
        $device = new Device();

        $this->assertEquals([], $device->toArray());

        $device->setIdentification([
            'manufacturer'  =>  'Sony',
            'model'         =>  'Playstation 4',
            'type'          =>  Constants\DeviceType::GAMING,
            'subtype'       =>  Constants\DeviceSubType::CONSOLE
        ]);

        $this->assertEquals([
            'manufacturer'  =>  'Sony',
            'model'         =>  'Playstation 4',
            'type'          =>  Constants\DeviceType::GAMING,
            'subtype'       =>  Constants\DeviceSubType::CONSOLE
        ], $device->toArray());


        $device->setIdentification([
            'manufacturer'  =>  'NEC',
            'model'         =>  'N2002',
            'carrier'       =>  'DoCoMo',
            'type'          =>  Constants\DeviceType::MOBILE,
            'subtype'       =>  Constants\DeviceSubType::FEATURE
        ]);

        $this->assertEquals([
            'manufacturer'  =>  'NEC',
            'model'         =>  'N2002',
            'carrier'       =>  'DoCoMo',
            'type'          =>  Constants\DeviceType::MOBILE,
            'subtype'       =>  Constants\DeviceSubType::FEATURE
        ], $device->toArray());
    }
}
