<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Campus_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('LstInformesProfesorModel');
		$this->load->library('form_validation');
		$this->lang->load('campus',$this->data['lang']);
		if(!$this->session->userdata('campus_user')){
			redirect('campus/auth/login/', 'refresh');
		}
		$this->data['campus_user'] = (array)$this->session->userdata('campus_user');
		$this->data['user_id'] = $this->data['campus_user']['INDICE'];
		$this->layouts->add_includes('js', 'app/js/campus/reports/main.js');
	}
	
	public function index(){
//		$this->layouts->add_includes('js', 'app/js/campus/reports/index.js');
		$this->layouts->add_includes('js', 'app/js/campus/reports/index_2.js');
		$this->data['lstinformprofesr'] = $this->LstInformesProfesorModel->getlist();
		$userData = (array)$this->session->userdata('campus_user');
		$this->data['teacherid'] = $userData['INDICE'];
		$this->layouts->view('campus/reports/index_2View', $this->data, 'campus_reports');
	}

	public function getCotegories(){
		$result = $this->LstInformesProfesorModel->getlist();
		echo json_encode($result);
	}
	public function getReport(){
		if($this->input->post()) {
			$id = $this->input->post('id', true);
			$data['data'] = $this->LstInformesProfesorModel->report($id, $this->data['user_id']);
			$data['status'] = true;
			echo json_encode($data);
		}
	}
}