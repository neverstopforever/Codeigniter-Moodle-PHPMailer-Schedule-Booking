<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StudentReport extends MY_Campus_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('LstInformesAlumnosModel');
		$this->load->library('form_validation');

		$this->lang->load('campus',$this->data['lang']);
		if(!$this->session->userdata('campus_user') || ($this->session->userdata('campus_user') && $this->data['campus_user_role'] != 2)){ //no user or not student
			redirect('campus/auth/login/', 'refresh');
		}
		$this->data['campus_user'] = (array)$this->session->userdata('campus_user');
		$this->data['user_id'] = $this->data['campus_user']['CCODCLI'];
		$this->layouts->add_includes('js', 'app/js/campus/reports/main.js');
	}
	
	public function index(){
		$this->layouts->add_includes('js', 'app/js/campus/student_reports/index_2.js');
		$this->data['lst_inform_student'] = $this->LstInformesAlumnosModel->getlist();
		$this->data['student_id'] = $this->data['user_id'];
		$this->layouts->view('campus/student_reports/index_2View', $this->data, 'campus_reports');
	}

	public function get_categories(){

		$result = $this->LstInformesAlumnosModel->getlist();
		echo json_encode( $result);
		exit;

	}
	
	public function getReport(){
		if($this->input->post()) {
			$id = $this->input->post('id', true);
			$data['data'] = $this->LstInformesAlumnosModel->report($id, $this->data['user_id']);
			$data['status'] = true;
			echo json_encode($data);
			exit;
		}
	}
}