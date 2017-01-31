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
	}
	
	public function index_get(){
		$this->data['source_state'] = $this->ApiPortalesModel->getSourceState();
		$this->load->view('leadsConfigView', $this->data);
	}

	public function customize_source_post(){
		$state = $this->post('active');
		$id = $this->post('id');
		$updateSource = $this->ApiPortalesModel->updateSource($state, $id);
		print_r(json_encode(array('response'=>$updateSource)));
		exit;
	}
}
