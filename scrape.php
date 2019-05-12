<?php
require_once __DIR__ .'/libs/utility.php';
require_once __DIR__ .'/libs/parser.php';

use Scrape\Libs\Utility;
use Scrape\Libs\Parser;

class Scrape 
{	
	var $baseUrl = "https://find-an-architect.architecture.com/";
	var $url = "FAAPractices.aspx?display=50&page=70";
	var $counter;
	protected $utility;

	function __construct(Utility $utility)
	{
		$this->utility = $utility;
		$this->counter = 0;
	}


	public function scrape(){
		$this->url = $this->baseUrl.$this->url;
		$parser = new Parser();
		$continue = TRUE;
		while ($continue) {
			$data = $this->utility->getContent($this->url);
			$parser->setParser($data);
			$getData = $this->parseData($data);
			$nextPage = $parser->getLink('.sys_flickrpager > .sys_navigation span.sys_navigationnext > a');
			$this->utility->writeToFile($getData);
			if(strrpos($nextPage,"&page=")){
				$cleanUrl = preg_replace("/\/FindAnArchitect\//","",$nextPage);
				$this->url = $this->baseUrl.$cleanUrl;
			}else{
				break;
			}
		}

		return TRUE;

	}

	public function parseData($markup){
		$parser = new Parser();
		$parser->setParser($markup);
		$getItems =  $parser->findElement( '.listingItem' );
		$result  = [];
		foreach ( $getItems as $offer )
		{
			$o = pq($offer);
			$parser->setParser($o);
			$result[$this->counter] = $parser->parse();
			$result[$this->counter]['services'] = $this->services($o);
			$this->counter++;
		}
		return $result;
	}

	public function services($o){
		$parser = new Parser();
		$parser->setParser($o);
		$cleanUrl = preg_replace("/\/FindAnArchitect\//",$this->baseUrl,$parser->getLink( 'h3 > a' ));
		$data = $this->utility->getContent($cleanUrl);
		$parser->setParser($data);
		$desc = $parser->findText('.articleHeader > .articleHeaderTertiary span.metaBlock-data');
		return empty($desc) ? "N/A" : $desc; 
	}
}


$scrape = new Scrape(new Utility);
$request = $scrape->scrape();
echo ($request) ? "Added Data To File" : "Failed Adding Data To File";
//echo '<pre>' . print_r($request, true ) . '</pre>';
exit(0);

?>