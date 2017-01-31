<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calender extends MY_Campus_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CourseModel');
		$this->load->model('EventModel');
		$this->load->model('ErpCustomFieldsModel');
		$this->load->library('form_validation');
		$this->data['user_role'] = $this->session->userdata('user_role');
		$this->lang->load('campus',$this->data['lang']);
		if(!$this->session->userdata('loggedIn')){
			redirect('campus/auth/login/', 'refresh');
		}
		$this->layouts->add_includes('js', 'app/js/campus/calender/main.js');
	}
	
	public function index(){
		$this->layouts->add_includes('js', 'app/js/campus/calender/index.js');
		$userData = (array)$this->session->userdata('campus_user');
		$this->data['teacherid'] = $userData['INDICE'];
		$this->data['course'] = $this->CourseModel->getcourse($this->data['teacherid']);
		$this->data['group'] = json_encode($this->CourseModel->getgroup($this->data['teacherid']));
		$this->data['event'] = json_encode($this->EventModel->getevent('','',$this->data['teacherid'],'',''));
		$this->data['customfields_fields'] = array();
		$cisess = $this->session->userdata('_cisess');
		$membership_type = $cisess['membership_type'];
		if($membership_type != 'FREE'){
			$this->data['customfields_fields'] = $this->ErpCustomFieldsModel->getFieldsList('events');
		}
		$this->layouts->view('campus/calenders/index', $this->data, $this->layout);
	}
	
	public function getEvent(){
		$userData = (array)$this->session->userdata('campus_user');
		$this->data['teacherid'] = $userData['INDICE'];
		$event = array();
		if($this->input->post()){
			$courseId = $this->input->post('idactividad', true);
			$groupId = $this->input->post('Idgrupo', true);
			$event = $this->EventModel->getevent($courseId,$groupId,$this->data['teacherid'],'','');
		}
		print_r(json_encode($event));
		exit;
	}
	public function saveEventCustomField($group_id='', $event_id=''){
		if($this->input->is_ajax_request()){
			$this->load->model('ErpCustomFieldsModel');
			$this->load->model('AgendaGrupoModel');
			$result = false;
			$error = array();
			$validation = false;
			$field_data_json ='';
			$this->lang->load('clientes_form', $this->data['lang']);
			//get custom fields
			$fields = $this->ErpCustomFieldsModel->getFieldsList('events');
			if($this->input->post('custom_fields', true)) {
				$this->config->set_item('language', $this->data['lang']);
				$field_data = $this->input->post('custom_fields', true);
				foreach ($fields as $field) {
					if($field['required'] && $field['field_type'] != 'checkbox') {
						$validation = true;
						$this->form_validation->set_rules('custom_fields[' . $field['id'] . ']', "<b>" . $field['field_name'] . "</b>", "trim|required");
					}
				}
				if(!$validation || $this->form_validation->run()){
					if(!array_filter($field_data)){
						$field_data_json = '';
					}else{
						$field_data_json = json_encode($field_data);
					}
					$update_data = array('custom_fields'=>$field_data_json);
					$result = $this->AgendaGrupoModel->updateEventData($group_id, $event_id, $update_data);
				}else{
					$error = $this->form_validation->error_array();
				}
			}
			echo json_encode(array('success'=>$result, 'update_data'=>$field_data_json,  'error'=>$error));
			exit;
		}
	}
}