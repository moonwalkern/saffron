<?php
class ControllerCommonStreetvalidate extends Controller {
	public function index() {
		$this->load->language('common/streetvalidate');
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('tool/upsstreetvalidate');
		
		$candiate = $this->model_tool_upsstreetvalidate->streetValidate();
		$candiates = json_decode($candiate);
		//if the address is not ambigious.....lets not show the result.
		if($candiates == null){
			return null;
		}
		else{
			if (isset($this->request->get['target'])) {
				$data['target'] = $this->request->get['target'];
			} else {
				$data['target'] = '';
			}
			
			$data['addresses'] = array();
			
			$data['button_select'] = $this->language->get('button_select');
			foreach ($candiates as $candiate) {
				if(sizeof($candiate->AddressKeyFormat->AddressLine) == 1){
					$addressline = $candiate->AddressKeyFormat->AddressLine;
					$appt = '';
				}
				else{
					$addressline = $candiate->AddressKeyFormat->AddressLine[0];
					$appt = $candiate->AddressKeyFormat->AddressLine[1];
				}
				
				$data['addresses'][] = array(
						'AddressLine' => $addressline,
						'Appt' => $appt,
						'City' => $candiate->AddressKeyFormat->PoliticalDivision2,
						'County' => $candiate->AddressKeyFormat->PoliticalDivision2,
						'State' => $candiate->AddressKeyFormat->PoliticalDivision1,
						'Zip' => $candiate->AddressKeyFormat->PostcodePrimaryLow,
						'ZipLow	' => $candiate->AddressKeyFormat->PostcodeExtendedLow,
						'Region' => $candiate->AddressKeyFormat->Region,
						'County' => $candiate->AddressKeyFormat->CountryCode,
						'Status' => 'VALID'
						
				);
			}
			
			return $this->response->setOutput($this->load->view('common/streetvalidate', $data));
		}
		
	}
}