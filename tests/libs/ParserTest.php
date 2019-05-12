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

    public function test_validateTelephone(){
        $invalidNumber = "723#@gyd 5325$6362";
        $valid = $this->call->validateTelephone($invalidNumber);
        $this->assertEquals("723 532 56362",$valid);
    }

    public function test_validateEmail(){
        $validEmail = "sam@abc.com";
        $valid = $this->call->validateEmail($validEmail);
        $this->assertEquals($validEmail,$valid);
        $invalid = ".ds#ghjsdb@f76.8fdsf798";
        $valid = $this->call->validateEmail($invalid);
        $this->assertEquals("N/A",$valid);

    }

    public function test_filter_Data_should_assign_na_on_empty_key_value(){
        $arr = [
            "name" => "sam",
            "age" => null
        ];
        $filter = $this->call->filter($arr);
        $this->assertEquals($filter['age'],"N/A");
        $this->assertEquals($filter['name'],$arr['name']);

    }




}


?>