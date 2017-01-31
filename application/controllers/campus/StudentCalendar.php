<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StudentCalendar extends MY_Campus_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CourseModel');
		$this->load->model('EventModel');
		$this->load->model('ErpCustomFieldsModel');
		$this->load->library('form_validation');
		$this->data['user_role'] = $this->session->userdata('user_role');
		$this->lang->load('campus',$this->data['lang']);
		if(!$this->session->userdata('campus_user') || ($this->session->userdata('campus_user') && $this->data['campus_user_role'] != 2)){ //no user or not student
			redirect('campus/auth/login/', 'refresh');
		}
		$this->layouts->add_includes('js', 'app/js/campus/calender/main.js');
		$this->data['user_data'] = (array)$this->session->userdata('campus_user');
		$this->data['student_id'] = $this->data['user_data']['CCODCLI'];
	}
	
	public function index(){
		$this->layouts->add_includes('js', 'app/js/campus/calender/student_calendar.js');
		$this->data['event'] = json_encode($this->EventModel->getStudentEvents($this->data['student_id'],'',''));
		$this->data['customfields_fields'] = array();
		$cisess = $this->session->userdata('_cisess');
		$membership_type = $cisess['membership_type'];
		if($membership_type != 'FREE'){
			$this->data['customfields_fields'] = $this->ErpCustomFieldsModel->getFieldsList('events');
		}
		$this->layouts->view('campus/calenders/studentCalendarView', $this->data, $this->layout);

	}
	

}