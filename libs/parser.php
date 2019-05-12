<?php
namespace Scrape\Libs;

require_once __DIR__ .'/../phpQuery/phpQuery/phpQuery.php';

use phpQuery;

class Parser 
{
	protected $query;

	public function setParser($query){
		$this->query = phpQuery::newDocumentHTML($query);
		return TRUE;
	}

	public function findText($context){
		return $this->findElement($context)->text();
	}

	public function getLink($element){
		return $this->findElement($element)->attr('href');
	}

	public function findElement($element){
		return $this->query->find($element);
	}

	public function getImageSource($element){
		foreach ($this->findElement($element) as $image) {
			return urldecode(pq($image)->attr('src'));
		}
		return "N/A";
	}

	public function validateTelephone($number) {

	  	$numberOnly = preg_replace('/[^0-9]/', '', $number);
	  	$format = preg_replace('#(\d{3})(\d{3})(\d{4})#', '$1 $2 $3',$numberOnly);
		return $format ?: "N/A";
	}

	public function validateEmail($email){
		return (preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $email)) ? $email : "N/A";
	}

	public function filter($result){

		$filter = array_map(function($value) {
   			return empty($value) ? "N/A" : $value;
		}, $result);
		
		return $filter;
	}

}

?>