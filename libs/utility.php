<?php

namespace Scrape\Libs;
require_once __DIR__ . '/exceptions.php';

use Scrape\Exceptions\InvalidHttpException;

class Utility
{
	var $first = 0 ;

	public function getContent($url = null){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_CUSTOMREQUEST => "GET",
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response=curl_exec($curl);

		$httpstatus=curl_getinfo($curl,CURLINFO_HTTP_CODE);

		if($httpstatus!=200){
			throw new InvalidHttpException(curl_error($curl),$httpstatus);
		}
		curl_close($curl);
		return $response;
	}

	public function writeToFile($data){
		$file = $this->fileOpen();
		foreach ($data as $key => $value) {
			$row = [];
			foreach ($value as $key2 => $value2) {
				
					$row[] = trim($value2);
				}
				fputcsv($file, $row,';', '"');	
			}

		fclose($file);
		return TRUE;
	}

	private function fileOpen(){
		if($this->first > 0){
			$file = fopen(__DIR__ . '/../data.csv', 'a') or die("Can't create file");

		}else{
			$header = array("Name","Address","Phone","Email","Website","About","Image","services");
			$file = fopen(__DIR__ . '/../data.csv', 'w') or die("Can't create file");
			fputcsv ($file, $header,';');
			$this->first = 1;

		}

		return $file;

	}


}