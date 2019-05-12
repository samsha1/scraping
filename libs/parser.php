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

	public function parse(){
			$result = [];
			$result[ 'name' ]     = $this->findText('h3 > a');
			$result[ 'address1' ] = $this->findText('.listingItem-details > .pageMeta > .pageMeta-col > .address');
			$result[ 'phone' ]    = $this->validateTelephone($this->findText('.listingItem-details >.pageMeta > .pageMeta-col > .pageMeta-item:eq(1)' ));
			$result[ 'email' ]    = $this->validateEmail($this->findText('.listingItem-details >.pageMeta > .pageMeta-col > .pageMeta-item > .faaemail' ));
			$result[ 'website' ]  = $this->findText( '.listingItem-details >.pageMeta > .pageMeta-col > .pageMeta-item > .exLink' );
			$result[ 'about' ]    = $this->findText( '.listingItem-extra > .pageMeta-item > p' );
			foreach ($this->findElement('.listingItem-thumbnail img') as $image) {
				$result[ 'imageUrl' ]     = urldecode(pq($image)->attr('src'));
			}

			return $result;

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

	private function validateTelephone($number) {

	  	$numberOnly = preg_replace('/[^0-9]/', '', $number);
	  	$format = preg_replace('#(\d{3})(\d{3})(\d{4})#', '$1 $2 $3',$numberOnly);
		return $format ?: "N/A";
	}

	private function validateEmail($email){
		return (preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $email)) ? $email : "N/A";
	}




}

?>