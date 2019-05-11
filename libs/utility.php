<?php

namespace Scrape\Libs;
require_once __DIR__ . '/exceptions.php';

use Scrape\Exceptions\InvalidHttpException;

class Utility
{

	public function getContent($url = null){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_CUSTOMREQUEST => "GET",
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response=curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	public function writeToFile($data){
		//print_r($data);
		$header = array("Name","Address1","Phone","Email","Website","About","Image","services");
		$file = fopen(__DIR__ . '/../data.csv', 'w') or die("Can't create file");
		fputcsv ($file, $header, "\t");
		foreach ($data as $key => $value) {
			
			foreach ($value as $key2 => $value2) {
				$row = [];
				foreach ($value2 as $key3 => $value3) {
					$row[] = trim($value3);
				}
				fputcsv($file, $row,';', '"');	
			}

			//print_r($row);	
		}

		fclose($file);
		return TRUE;
	}


}