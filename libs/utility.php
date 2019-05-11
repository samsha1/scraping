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


}