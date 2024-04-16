<?php
namespace WhichBrowserTest;

use PHPUnit\Framework\TestCase;
use WhichBrowser\Parser;

/**
 * @covers WhichBrowser\Parser
 */
class ParserTest extends TestCase
{
    public function testCreatingParserWithString()
    {
        $parser = new Parser("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; InfoPath.1)");

        $this->assertTrue($parser->isBrowser('Internet Explorer', '=', '6.0'));
    }

    public function testCreatingParserWithHeaders()
    {
        $parser = new Parser([
            'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; InfoPath.1)'
        ]);

        $this->assertTrue($parser->isBrowser('Internet Explorer', '=', '6.0'));
    }

    public function testCreatingParserWithOptions()
    {
        $parser = new Parser([
            'headers' => [
                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; InfoPath.1)'
            ]
        ]);

        $this->assertTrue($parser->isBrowser('Internet Explorer', '=', '6.0'));
    }

    public function testCreatingParserWithoutArgumentsAndCallAnalyse()
    {
        $parser = new Parser();
        $parser->analyse("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; InfoPath.1)");

        $this->assertTrue($parser->isBrowser('Internet Explorer', '=', '6.0'));
    }

    public function testCreatingParserFromUserAgent()
    {
        $parser = Parser::fromUserAgent('Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; InfoPath.1)');

        $this->assertTrue($parser instanceof \WhichBrowser\Parser);

        $this->assertTrue($parser->isBrowser('Internet Explorer', '=', '6.0'));
    }

    public function testCreatingParserFromHeaderArray()
    {
        $parser = Parser::fromHeaders([
            'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; InfoPath.1)'
        ]);

        $this->assertTrue($parser instanceof \WhichBrowser\Parser);

        $this->assertTrue($parser->isBrowser('Internet Explorer', '=', '6.0'));
    }
}
