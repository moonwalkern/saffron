<?php
class ModelToolUpsstreetvalidate extends Model {
	
	public function streetValidate(){
		 
		$this->load->model('tool/image');
		$this->load->library('log');
		$logger = new Log('swapdeal.log');
		 
		$username = "sreeji.gopal";
		$password = "Cool2700@";
		$token = "6D1EC3EE0D3A16AC";
		$logger->write(print_R($this->request->get,TRUE));
		$buildingName = $this->request->get['building'];
		$addressLine1 = $this->request->get['address1'];
		$city = $this->request->get['city'];
		$state = $this->request->get['state'];
		$zip = $this->request->get['zip'];
		 
		$username = array(
				'Username' => $username,
				'Password' => $password
		);
		 
		$usernameToken = array(
				'UsernameToken' => $username,
				'ServiceAccessToken' => array(
						'AccessLicenseNumber' => $token
				)
		);
		 
		//    		$serviceAccessToken = array(
		//    				'AccessLicenseNumber' => $token,
		//    		);
		
// 		$addressFormat = array(
// 				'ConsigneeName'=> "Sreeji",
// 				'BuildingName'=> "Pearl at Midtown",
// 				'AddressLine'=> "6008 ridgecre rd",
// 				'PoliticalDivision2'=> "Dallas",
// 				'PoliticalDivision1'=> "TX",
// 				'PostcodePrimaryLow'=> "75231",
// 				'CountryCode'=> "US"
// 		);
		$addressFormat = array(
				'ConsigneeName'=> "Sreeji",
				'BuildingName'=> $buildingName,
				'AddressLine'=> $addressLine1,
				'PoliticalDivision2'=> $city,
				'PoliticalDivision1'=> $state,
				'PostcodePrimaryLow'=> $zip,
				'CountryCode'=> "US"
		);
		 
		 
		$request = array(
				'RequestOption' => '1',
				'TransactionReference' => array(
						'CustomerContext' => 'Sreeji'
				),
					
		);
		 
		$category = array(
				'UPSSecurity' => $usernameToken,
				'XAVRequest' => array(
						'Request' => $request,
						'MaximumListSize' => '10',
						'AddressKeyFormat' => $addressFormat)
		);
	
		 
		$logger->write('ups adding data');
		$logger->write(print_r(json_encode($category), TRUE));
		//echo print_R($category,TRUE);
		$url = "https://onlinetools.ups.com/rest/XAV";
		//$response = $this->httpPost($url, $category);
		//$logger->write(print_r(json_encode($response), TRUE));
		$response = "{\"XAVResponse\":{\"Response\":{\"ResponseStatus\":{\"Code\":\"1\",\"Description\":\"Success\"},\"TransactionReference\":{\"CustomerContext\":\"Sreeji\"}},\"AmbiguousAddressIndicator\":\"\",\"Candidate\":[{\"AddressKeyFormat\":{\"ConsigneeName\":\"GATEWOOD APARTMENTS\",\"AddressLine\":\"6008 RIDGECREST RD\",\"PoliticalDivision2\":\"DALLAS\",\"PoliticalDivision1\":\"TX\",\"PostcodePrimaryLow\":\"75231\",\"PostcodeExtendedLow\":\"9388\",\"Region\":\"DALLAS TX 75231-9388\",\"CountryCode\":\"US\"}},{\"AddressKeyFormat\":{\"AddressLine\":[\"6008 RIDGECREST RD\",\"APT 129-153\"],\"PoliticalDivision2\":\"DALLAS\",\"PoliticalDivision1\":\"TX\",\"PostcodePrimaryLow\":\"75231\",\"PostcodeExtendedLow\":\"6736\",\"Region\":\"DALLAS TX 75231-6736\",\"CountryCode\":\"US\"}},{\"AddressKeyFormat\":{\"AddressLine\":[\"6008 RIDGECREST RD\",\"APT 241-350\"],\"PoliticalDivision2\":\"DALLAS\",\"PoliticalDivision1\":\"TX\",\"PostcodePrimaryLow\":\"75231\",\"PostcodeExtendedLow\":\"9349\",\"Region\":\"DALLAS TX 75231-9349\",\"CountryCode\":\"US\"}},{\"AddressKeyFormat\":{\"AddressLine\":[\"6008 RIDGECREST RD\",\"APT 351-453\"],\"PoliticalDivision2\":\"DALLAS\",\"PoliticalDivision1\":\"TX\",\"PostcodePrimaryLow\":\"75231\",\"PostcodeExtendedLow\":\"9350\",\"Region\":\"DALLAS TX 75231-9350\",\"CountryCode\":\"US\"}},{\"AddressKeyFormat\":{\"AddressLine\":[\"6008 RIDGECREST RD\",\"APT 229-240\"],\"PoliticalDivision2\":\"DALLAS\",\"PoliticalDivision1\":\"TX\",\"PostcodePrimaryLow\":\"75231\",\"PostcodeExtendedLow\":\"9393\",\"Region\":\"DALLAS TX 75231-9393\",\"CountryCode\":\"US\"}},{\"AddressKeyFormat\":{\"AddressLine\":[\"6008 RIDGECREST RD\",\"APT 454-456\"],\"PoliticalDivision2\":\"DALLAS\",\"PoliticalDivision1\":\"TX\",\"PostcodePrimaryLow\":\"75231\",\"PostcodeExtendedLow\":\"9517\",\"Region\":\"DALLAS TX 75231-9517\",\"CountryCode\":\"US\"}},{\"AddressKeyFormat\":{\"AddressLine\":[\"6008 RIDGECREST RD\",\"APT 154\"],\"PoliticalDivision2\":\"DALLAS\",\"PoliticalDivision1\":\"TX\",\"PostcodePrimaryLow\":\"75231\",\"PostcodeExtendedLow\":\"9526\",\"Region\":\"DALLAS TX 75231-9526\",\"CountryCode\":\"US\"}}]}}";
		 
		$response_decode = json_decode($response);
		$logger->write($response_decode);
		$logger->write( 'AmbiguousAddressIndicator ->' .isset($response_decode->XAVResponse->AmbiguousAddressIndicator));
		$logger->write( 'ValidAddressIndicator ->' .isset($response_decode->XAVResponse->ValidAddressIndicator));
		if(isset($response_decode->XAVResponse->AmbiguousAddressIndicator)){//check if UPS service returns Ambiguous Address indicator if Yes then list all the address else none.
			$logger->write('We have bad address, and ambiguous address to be listed');
			$candiates = $response_decode->XAVResponse->Candidate;
			$candiate_encode = json_encode($candiates);
		}else{
			$logger->write('We have good address');
			$candiate_encode = null;
		}
		
		return $candiate_encode;
	}
	
	public function httpPost($url, $data)
	{
		// Setup cURL
		$ch = curl_init($url);
		curl_setopt_array($ch, array(
				CURLOPT_POST => TRUE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_HTTPHEADER => array(
						'Content-Type: application/json'
				),
				CURLOPT_POSTFIELDS => json_encode($data),
				CURLOPT_SSL_VERIFYPEER => FALSE
		));
		 
		 
		// Send the request
		$response = curl_exec($ch);
		//echo $response;
		// Check for errors
		if($response === FALSE){
			echo "error";
			die(curl_error($ch));
		}
		 
		// Decode the response
		$responseData = json_decode($response, TRUE);
		return $responseData;
	}
}
