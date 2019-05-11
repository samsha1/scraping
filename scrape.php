<?php
require('phpQuery/phpQuery/phpQuery.php');
require_once __DIR__ .'/libs/utility.php';
require_once __DIR__ .'/libs/parser.php';

use Scrape\Libs\Utility;
use Scrape\Libs\Parser;

class Scrape 
{	
	var $baseUrl = "https://find-an-architect.architecture.com/";
	var $url = "FAAPractices.aspx?display=50";
	protected $utility;

	function __construct(Utility $utility)
	{
		$this->utility = $utility;
	}


	public function scrape(){
		$homeUrl = $this->baseUrl.$this->url;
		$data = $this->utility->getContent($homeUrl);
		return $this->parseData($data);
	}

	public function parseData($markup){
		$doc = phpQuery::newDocumentHTML($markup);
		$getItems =  $doc->find( '.listingItem' );
		$result  = array();
		$counter = 0;
		foreach ( $getItems as $offer )
		{
			$o = pq($offer);
			$result[$counter] = Parser::parse($o);
			$result[$counter]['services'] = $this->services($o);
			$counter++;
		}

		return $result;
	}

	public function services($o){
		$href = $o->find( 'h3 > a' );
		$cleanUrl = preg_replace("/\/FindAnArchitect\//",$this->baseUrl,$href->attr('href'));
		$data = $this->utility->getContent($cleanUrl);
		$doc = phpQuery::newDocumentHTML($data);
		return Parser::serviceParser($doc);
	}
}


$scrape = new Scrape(new Utility);
try {
	$request = $scrape->scrape();
	echo '<pre>' . print_r($request, true ) . '</pre>';
} catch (InvalidHttpException $e) {
	return ["status"=>$e->getCode(),"message"=> $e->getMessage()];
}

return $request;

?>