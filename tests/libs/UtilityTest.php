<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../libs/utility.php';
require_once __DIR__ . '/../../libs/exceptions.php';

use Scrape\Libs\Utility;
use Scrape\Exceptions\InvalidHttpException;

class UtilityTest extends TestCase{

	var $call;

	protected function setUp()
    {
        $this->call = new Utility();
    }

	public function test_create_UtilityTest() {
        $this->assertEquals('Scrape\Libs\Utility', \get_class($this->call));
    }

    function createUrl() {
        return $envv=[
            'base_url' => 'https://find-an-architect.architecture.com/',
            'url' => 'FAAPractices.aspx?display=50',
            'fake_url'=>'https://jsonplaceholder.typicode.com/todos/1'
        ];
    }

    public function sampleTestData(){
    	$cars = array
  			(
  				array("Volvo",22,18),
  				array("BMW",15,13),
  				array("Saab",5,2),
  				array("Land Rover",17,15)
  			);
  		return $cars;
    }

    public function test_getContent_should_return_some_bulk_response(){
    	$envv = $this->createUrl();
    	$url = $envv['fake_url'];
    	$content = $this->call->getContent($url);
    	$this->assertEquals(1,json_decode($content,true)['id']);

    }

    public function test_getContent_InvalidHttpException_should_throw_exception_on_invalid_url(){
    	$envv = $this->createUrl();
    	$invalidUrl = $envv['base_url'].'invalid_url';
    	$this->expectException(InvalidHttpException::class);
    	$content = $this->call->getContent($invalidUrl);
    }

    public function test_writeToFile_should_create_file_and_write(){
    	$data = $this->sampleTestData();
    	$dir = __DIR__ .'/../../data.csv';
    	$write = $this->call->writeToFile($data);
    	$this->assertTrue(file_exists($dir));

    }

    public function test_writeToFile_by_checking_data_format_must_separate_value_by_semicolon(){
    	$data = $this->sampleTestData();
    	$dir = __DIR__ .'/../../data.csv';
    	$write = $this->call->writeToFile($data);
    	$readFile = fopen($dir,'r');
    	$line=fgets($readFile);
    	$count = substr_count($line,";");
    	$this->assertTrue($count>1);


    }



}


?>