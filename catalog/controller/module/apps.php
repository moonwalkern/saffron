<?php
class ControllerModuleApps extends Controller {
    private $logger;
    protected function index()
    {


    }
    
    
    public function httpGet($url)
    {
    	$ch = curl_init($url); // initialize curl with given url
    	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]); // set  useragent
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
    	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); // max. seconds to execute
    	curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
    	return @curl_exec($ch);
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

    public function firstaccess() {

        $this->load->model('tool/image');
        $this->load->library('log');
        $this->logger = new Log('swapdeal.log');


        $this->logger->write('Apps Service Start:firstaccess');
        $this->logger->write('Get Data ' . print_R($this->request->post,TRUE));
        if ($this->request->server['REQUEST_METHOD'] == 'GET' || $this->request->server['REQUEST_METHOD'] == 'POST') {
            $json['data'] = 'ec2-54-201-107-80.us-west-2.compute.amazonaws.com';
            $this->logger->write('Apps Service End:firstaccess, '.print_r($json['data'],TRUE));
            $this->response->setOutput(json_encode($json));
        }

        $this->logger->write('Apps Service End:firstaccess');
    }

   	public function streetvalidate(){
   		
   		$this->load->model('tool/image');
   		$this->load->library('log');
   		$logger = new Log('swapdeal.log');
   		
   		$username = "sreeji.gopal";
   		$password = "Cool2700@";
   		$token = "6D1EC3EE0D3A16AC";
   		
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
   		
   		$addressFormat = array(
   				'ConsigneeName'=> "Sreeji",
				'BuildingName'=> "Pearl at Midtown",
				'AddressLine'=> "6008 ridgecre rd",
				'PoliticalDivision2'=> "Dallas",
				'PoliticalDivision1'=> "TX",
				'PostcodePrimaryLow'=> "75231",
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
   		$logger->write(print_r(json_encode($response), TRUE));
   		$response = "{\"XAVResponse\":{\"Response\":{\"ResponseStatus\":{\"Code\":\"1\",\"Description\":\"Success\"},\"TransactionReference\":{\"CustomerContext\":\"Sreeji\"}},\"AmbiguousAddressIndicator\":\"\",\"Candidate\":[{\"AddressKeyFormat\":{\"ConsigneeName\":\"GATEWOOD APARTMENTS\",\"AddressLine\":\"6008 RIDGECREST RD\",\"PoliticalDivision2\":\"DALLAS\",\"PoliticalDivision1\":\"TX\",\"PostcodePrimaryLow\":\"75231\",\"PostcodeExtendedLow\":\"9388\",\"Region\":\"DALLAS TX 75231-9388\",\"CountryCode\":\"US\"}},{\"AddressKeyFormat\":{\"AddressLine\":[\"6008 RIDGECREST RD\",\"APT 129-153\"],\"PoliticalDivision2\":\"DALLAS\",\"PoliticalDivision1\":\"TX\",\"PostcodePrimaryLow\":\"75231\",\"PostcodeExtendedLow\":\"6736\",\"Region\":\"DALLAS TX 75231-6736\",\"CountryCode\":\"US\"}},{\"AddressKeyFormat\":{\"AddressLine\":[\"6008 RIDGECREST RD\",\"APT 241-350\"],\"PoliticalDivision2\":\"DALLAS\",\"PoliticalDivision1\":\"TX\",\"PostcodePrimaryLow\":\"75231\",\"PostcodeExtendedLow\":\"9349\",\"Region\":\"DALLAS TX 75231-9349\",\"CountryCode\":\"US\"}},{\"AddressKeyFormat\":{\"AddressLine\":[\"6008 RIDGECREST RD\",\"APT 351-453\"],\"PoliticalDivision2\":\"DALLAS\",\"PoliticalDivision1\":\"TX\",\"PostcodePrimaryLow\":\"75231\",\"PostcodeExtendedLow\":\"9350\",\"Region\":\"DALLAS TX 75231-9350\",\"CountryCode\":\"US\"}},{\"AddressKeyFormat\":{\"AddressLine\":[\"6008 RIDGECREST RD\",\"APT 229-240\"],\"PoliticalDivision2\":\"DALLAS\",\"PoliticalDivision1\":\"TX\",\"PostcodePrimaryLow\":\"75231\",\"PostcodeExtendedLow\":\"9393\",\"Region\":\"DALLAS TX 75231-9393\",\"CountryCode\":\"US\"}},{\"AddressKeyFormat\":{\"AddressLine\":[\"6008 RIDGECREST RD\",\"APT 454-456\"],\"PoliticalDivision2\":\"DALLAS\",\"PoliticalDivision1\":\"TX\",\"PostcodePrimaryLow\":\"75231\",\"PostcodeExtendedLow\":\"9517\",\"Region\":\"DALLAS TX 75231-9517\",\"CountryCode\":\"US\"}},{\"AddressKeyFormat\":{\"AddressLine\":[\"6008 RIDGECREST RD\",\"APT 154\"],\"PoliticalDivision2\":\"DALLAS\",\"PoliticalDivision1\":\"TX\",\"PostcodePrimaryLow\":\"75231\",\"PostcodeExtendedLow\":\"9526\",\"Region\":\"DALLAS TX 75231-9526\",\"CountryCode\":\"US\"}}]}}";
   		
   		$response_decode = json_decode($response);
   		//echo print_R($response_decode,TRUE);
   		$candiates = $response_decode->XAVResponse->Candidate;
   		//echo print_R($candiates,TRUE);
   		echo "-----------------\n";
   		foreach ($candiates as $candiate) {
   			echo print_R($candiate,TRUE);
   		}
   		
   		$candiate_encode = json_encode($candiates);
   		
   		//$logger->write(print_r(json_encode($response), TRUE));
   		//$logger->write('ups encoding json ');
   		$this->response->addHeader('Content-Type: application/json');
   		$this->response->setOutput($candiate_encode);
 		 
   	}
   	
   public function order(){
   	
   		echo "order info";
   		$this->load->model('account/customer');
   		
   		$this->customer->login("sreeji.gopal@gmail.com", '', true);
   		
	   	$this->load->language('account/order');
	   	
	   	
	   	$this->load->model('account/order');
	   	
	   	$order_info = $this->model_account_order->getOrder(1);
	   	
	   	//echo print_R($order_info,TRUE);
	   	$this->response->setOutput('account/order',$order_info);
	   	//$this->response->redirect($this->url->link('account/order/info&order_id=4', '', true));
   		$this->response->redirect($this->url->link('account/order/info&order_id=4', '', false));
   		//echo $html;
	   	//echo $this->response->getOutput();
   }
   
   public function orderhtml(){
   	$page = file_get_contents('http://localhost/saffron/index.php?route=module/apps/order');
   	echo $page;
   }
   
   	
}
?>