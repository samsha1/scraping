<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../libs/parser.php';
require_once __DIR__ . '/../../libs/utility.php';
require_once __DIR__ . '/../../app/scrape.php';
require_once __DIR__ . '/../../libs/exceptions.php';

use Scrape\Libs\Parser;
use Scrape\Libs\Utility;
use App\Scrapper\Scrape;
use Scrape\Exceptions\InvalidHttpException;

class ScrapeTest extends TestCase{

	var $call;

	protected function setUp()
    {
        $this->call = new Scrape(new Utility);
    }

	public function test_create_ScrapeTest() {
        $this->assertEquals('App\Scrapper\Scrape', \get_class($this->call));
    }

}


?>