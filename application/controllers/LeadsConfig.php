<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *@property ApiPortalesModel $ApiPortalesModel
 */
class LeadsConfig extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('ApiPortalesModel');

        if(empty($this->_identity['loggedIn'])){
			redirect('/auth/login/', 'refresh');
		}
		$this->layout = 'leads_config';
		$this->layouts->add_includes('js', 'app/js/leads_config/main.js');
	}
	
	public function index(){
        $this->lang->load('quicktips', $this->data['lang']);
		$this->layouts->add_includes('js', 'app/js/leads_config/index.js');
		$this->data['source_state'] = $this->ApiPortalesModel->getSourceState();
		$this->layouts->view('leadsConfigView', $this->data, $this->layout);
	}

	public function getAddApikeyData(){
		$source = $this->ApiPortalesModel->getNotExistMedios();
		$type_of_source = $this->ApiPortalesModel->getNotExistTypeOfSource();
		echo json_encode(array('source' => $source, 'type_of_source' => $type_of_source));
		exit;
	}

	public function createNewApikey(){
		if($this->input->post()){
			$success = false;
			$insert_data = array();
			$title = $this->input->post('title', true);
			$source = $this->input->post('source', true);
			$type_of_source = $this->input->post('type_of_source', true);
			if(!empty($title) && !empty($source) && !empty($type_of_source) ){
				$checking_source = $this->ApiPortalesModel->getNotExistMedios(array('IdMedio' => $source));  // checking media exist or not
				$checking_source_type = $this->ApiPortalesModel->getNotExistTypeOfSource(array('idportal' => $type_of_source));  // checking media exist or not
				if(!empty($checking_source) && !empty($checking_source_type)){
					$type_of_source_str = strlen($type_of_source) == 1 ? '0'.$type_of_source : $type_of_source;
					$length = 256 - (strlen($type_of_source_str) + 1);
					$apikey = $this->generateApikey($length);
					$apikey = $type_of_source_str.'-'.$apikey;
					$insert_data = array(
						'apikey' => strlen($apikey) > 256 ? $this->generateApikey(256) : $apikey,
						'idportal' => $type_of_source,
						'activo' => '0',
						'idmedio' => $source,
						'title' => $title,
					);
					$result = $this->ApiPortalesModel->insertData($insert_data);
					if($result) {
						$insert_data['last_id'] = $result;
						$success = true;
					}
				}
			}
			echo json_encode(array('success' => $success, 'insert_data' => $insert_data));
			exit;
		}
	}

	public function updateSource(){
		if($this->input->post()){
			$success = false;
			$title = $this->input->post('title', true);
			$source = $this->input->post('source', true);
			$type_of_source = $this->input->post('type_of_source', true);
			$source_id = $this->input->post('source_id', true);
			if(!empty($title) && !empty($source) && !empty($type_of_source && !empty($source_id)) ){
				//if(!empty($checking_source) && !empty($checking_source_type)){
					$update_data = array(
						'idportal' => $type_of_source,
						'idmedio' => $source,
						'title' => $title,
					);
					$where =  array('id' => $source_id);
					$result = $this->ApiPortalesModel->updateItem($update_data, $where);
					if($result) {
						$success = true;
					}
				//}
			}
			echo json_encode(array('success' => $success));
			exit;
		}
	}

	public function deleteSource(){
		if($this->input->post()){
			$source_id = $this->input->post('source_id', true);
			$result = $this->ApiPortalesModel->deleteItem($source_id);
			echo json_encode(array('success' => $result));
			exit;
		}
	}

	public function getSourceById(){
		if($this->input->post()){
			$source_id = $this->input->post('source_id');
			$source_data = $this->ApiPortalesModel->getSourceBiId($source_id);
			$source = array();
			$type_of_source = array();
			if(!empty($source_data)){
				$source = $this->ApiPortalesModel->getNotExistMedios(array(), array('IdMedio' => $source_data->idmedio));
				$type_of_source = $this->ApiPortalesModel->getNotExistTypeOfSource(array(), array('idportal' => $source_data->idportal));
			}
			echo json_encode(array(
				'source_data' => $source_data,
				'source' => $source,
				'type_of_source' => $type_of_source));
			exit;
		}
	}



	private function generateApikey($length){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function customize_source(){

		$updateSource = '';
		if ($this->input->post()) {
			$state = $this->input->post('active');
			$id = $this->input->post('id');
			$updateSource = $this->ApiPortalesModel->updateSource($state, $id);
		}
		print_r(json_encode(array('response'=>$updateSource)));
		exit;
	}
}
