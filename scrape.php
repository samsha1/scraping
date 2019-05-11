<?php
require('phpQuery/phpQuery/phpQuery.php');
require_once __DIR__ .'/libs/utility.php';
require_once __DIR__ .'/libs/parser.php';

use Scrape\Libs\Utility;
use Scrape\Libs\Parser;

class Scrape 
{	
	var $baseUrl = "https://find-an-architect.architecture.com/";
	var $url = "FAAPractices.aspx?display=50&page=73";
	var $counter;
	protected $utility;

	function __construct(Utility $utility)
	{
		$this->utility = $utility;
		$this->counter = 0;
	}


	public function scrape(){
		$this->url = $this->baseUrl.$this->url;
		$getData = [];
		$continue = TRUE;
		while ($continue) {
			$data = $this->utility->getContent($this->url);
			$getData[] = $this->parseData($data);
			$doc = phpQuery::newDocumentHTML($data);
			$nextPage = $doc->find('.sys_flickrpager > .sys_navigation span.sys_navigationnext > a')->attr('href');
			if(strrpos($nextPage,"&page=")){
				$cleanUrl = preg_replace("/\/FindAnArchitect\//","",$nextPage);
				$this->url = $this->baseUrl.$cleanUrl;
			}else{
				break;
			}
		}

		return $this->utility->writeToFile($getData);

	}

	public function parseData($markup){
		$doc = phpQuery::newDocumentHTML($markup);
		$getItems =  $doc->find( '.listingItem' );
		$result  = array();
		foreach ( $getItems as $offer )
		{
			$o = pq($offer);
			$result[$this->counter] = Parser::parse($o);
			$result[$this->counter]['services'] = $this->services($o);
			$this->counter++;
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
$request = $scrape->scrape();
echo ($request) ? "Added Data To File" : "Failed Adding Data To File";
//echo '<pre>' . print_r($request, true ) . '</pre>';
exit(0);

?>