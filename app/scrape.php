<?php
namespace App\Scrapper;

require_once __DIR__ .'/../autoload.php';
require_once __DIR__ .'/../libs/parser.php';

use Scrape\Libs\Utility;
use Scrape\Libs\Parser;
use Scrape\Exceptions\InvalidHttpException;

class Scrape 
{	
	var $baseUrl;
	var $url;
	var $counter;
	protected $utility;

	function __construct(Utility $utility)
	{
		$this->utility = $utility;
		$this->counter = 0;
		$this->baseUrl = env("BASE_URL");
		$this->url = $this->baseUrl . env("START_URL");
	}


	public function scrape(){
		$parser = new Parser();
		$continue = TRUE;
		while ($continue) {
			try{
				$data = $this->utility->getContent($this->url);
			}catch(InvalidHttpException $e){
				return ["status"=>$e->getCode(),"message"=> $e->getMessage()];
			}
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

		return "Scrapping Completed";

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
			$result[$this->counter]['name'] = $parser->findText('h3 > a');
			$result[$this->counter]['address1'] = $parser->findText('.listingItem-details > .pageMeta > .pageMeta-col > .address');
			$result[$this->counter][ 'phone' ]    = $parser->validateTelephone($parser->findText('.listingItem-details >.pageMeta > .pageMeta-col > .pageMeta-item:eq(1)' ));
			$result[$this->counter][ 'email' ] = $parser->validateEmail($parser->findText('.listingItem-details >.pageMeta > .pageMeta-col > .pageMeta-item > .faaemail' ));
			$result[$this->counter][ 'website' ]  = $parser->findText( '.listingItem-details >.pageMeta > .pageMeta-col > .pageMeta-item > .exLink' );
			$result[$this->counter][ 'about' ]    = $parser->findText( '.listingItem-extra > .pageMeta-item > p' );
			$result[$this->counter][ 'imageUrl' ] = $parser->getImageSource('.listingItem-thumbnail img');
			$result[$this->counter]['services'] = $this->services($o);
			$result[$this->counter] = $parser->filter($result[$this->counter]);
			$this->counter++;
		}
		return $result;
	}

	public function services($o){
		$parser = new Parser();
		$parser->setParser($o);
		$cleanUrl = preg_replace("/\/FindAnArchitect\//",$this->baseUrl,$parser->getLink( 'h3 > a' ));
		try{
			$data = $this->utility->getContent($cleanUrl);
		}catch(InvalidHttpException $e){
			return ["status"=>$e->getCode(),"message"=> $e->getMessage()];
		}
		$parser->setParser($data);
		$desc = $parser->findText('.articleHeader > .articleHeaderTertiary span.metaBlock-data');
		return empty($desc) ? "N/A" : $desc; 
	}
}

?>