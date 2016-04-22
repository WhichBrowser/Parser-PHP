<?php
namespace WhichBrowserTest;

use PHPUnit_Framework_TestCase;
use WhichBrowser\Analyser;
use WhichBrowser\Model\Main;

/**
 * @covers WhichBrowser\Analyser
 */
class AnalyserTest extends PHPUnit_Framework_TestCase
{
    public function testCreatingAnalyserGetData()
    {
        $analyser = new Analyser([ "User-Agent" => "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; InfoPath.1)" ]);

        $this->assertTrue($analyser instanceof \WhichBrowser\Analyser);

        $analyser->analyse();

        $data = $analyser->getData();

        $this->assertTrue($data instanceof \WhichBrowser\Model\Main);
    }

    public function testCreatingAnalyserSetData()
    {
        $analyser = new Analyser([ "User-Agent" => "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; InfoPath.1)" ]);

        $this->assertTrue($analyser instanceof \WhichBrowser\Analyser);

        $input = new Main();

        $this->assertTrue($input instanceof \WhichBrowser\Model\Main);

        $analyser->setData($input);

        $analyser->analyse();

        $output = $analyser->getData();

        $this->assertTrue($output instanceof \WhichBrowser\Model\Main);
    }
}
