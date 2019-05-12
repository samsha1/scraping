<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../libs/parser.php';
require_once __DIR__ . '/../../libs/exceptions.php';

use Scrape\Libs\Parser;
use Scrape\Exceptions\InvalidHttpException;

class ParserTest extends TestCase{

	var $call;

	protected function setUp()
    {
        $this->call = new Parser();
    }

	public function test_create_ParserTest() {
        $this->assertEquals('Scrape\Libs\Parser', \get_class($this->call));
    }

    public function test_findText_should_return_text_from_htmlDOM(){
           $file =  file_get_contents(__DIR__."/../mock/test.html");
           $this->call->setParser($file);
           $find = $this->call->findText('h3 > a');
           $this->assertEquals("My Link",$find);
    }

    public function test_getLink_source_Should_return_source_from_a_tag(){
        $file =  file_get_contents(__DIR__."/../mock/test.html");
        $this->call->setParser($file);
        $find = $this->call->getLink('h3 > a');
        $this->assertEquals("test.html",$find);

    }

    public function test_getImageSource_should_return_image_location(){
        $file =  file_get_contents(__DIR__."/../mock/test.html");
        $this->call->setParser($file);
        $find = $this->call->getImageSource('.listingItem-thumbnail img');
        $this->assertEquals("/home/abc.jpeg",$find);
    }



}


?>