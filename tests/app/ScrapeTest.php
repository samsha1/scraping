<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../libs/utility.php';
require_once __DIR__ . '/../../app/scrape.php';
require_once __DIR__ . '/../../libs/exceptions.php';

use Scrape\Libs\Utility;
use App\Scrapper\Scrape;
use Scrape\Exceptions\InvalidHttpException;

class ScrapeTest extends TestCase{

	var $call;

	protected function setUp()
    {
        $this->call = new Scrape(new Utility);
    }

    public function prepareData(){
        return [
            'name'=>"ZAP Architecture",
            'address1'=>'Butwal',
            'phone'=>'020 376 14996',
            'email'=>'N/A',
            'website'=>'www.zaparchitecture.com',
            'about'=>'Just a Test',
            'imageUrl'=>'N/A',
            'services'=>"N/A"
        ];
    }

    public function test_create_ScrapeTest() {
        $this->assertEquals('App\Scrapper\Scrape', \get_class($this->call));
    }

    public function test_scrape_with_invaldHttpException(){
        
        $start_url = "fake_endpoint.aspx/display=asd?page=2";
        $content = $this->call->scrape($start_url);
        $this->assertEquals(["status"=>0,"message"=>"Could not resolve host: fake_endpoint.aspx"],$content);
    }

    public function test_parse_data_should_parse_html_dom_and_return_parsed_array(){
         $file =  file_get_contents(__DIR__."/../mock/dummy.html");
         $parse = $this->call->parseData($file);
         $this->assertEquals($this->prepareData(),$parse[0]);

    }

}


?>