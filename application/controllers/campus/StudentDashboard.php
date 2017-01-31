<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StudentDashboard extends MY_Campus_Controller {

	 public function __construct(){
		parent::__construct();
		$this->data['user_role'] = $this->session->userdata('user_role');
		$this->lang->load('campus',$this->data['lang']);
		if(!$this->session->userdata('campus_user') || ($this->session->userdata('campus_user') && $this->data['campus_user_role'] != 2)){ //no user or not student
			redirect('campus/auth/login/', 'refresh');
		}

		 $this->data['campus_user'] = (array)$this->session->userdata('campus_user');
		 $this->data['user_id'] = $this->data['campus_user']['CCODCLI'];

		 $this->load->model('EventModel');
		 $this->load->model('AlumnoModel');
		 $this->load->model('ErpEventoModel');
		 $this->load->model('ErpCustomFieldsModel');

		 $this->load->library('form_validation');
		$this->layouts->add_includes('js', 'app/js/campus/student_dashboard/main.js');
	}

	public function index(){
		$this->layouts->add_includes('js', 'app/js/campus/student_dashboard/index.js');
		$student_id = $this->data['user_id'];
		$this->data['page']='student_dashboard';
		$agenda_event = $this->EventModel->getStudentEvents($student_id,'','');
		if(!empty($agenda_event)){
			$this->data['agenda_event'] = json_encode($agenda_event);
		}else{
			$this->data['agenda_event'] = json_encode(array());
		}
		$this->data['customfields_fields'] = array();
		$cisess = $this->session->userdata('_cisess');
		$membership_type = $cisess['membership_type'];
		if($membership_type != 'FREE'){
			$this->data['customfields_fields'] = $this->ErpCustomFieldsModel->getFieldsList('events');
		}

		$this->layouts->view('campus/student_dashboard/indexView',$this->data, $this->layout);
	}

	public function get_events(){
		$html = '';
		if ($this->input->is_ajax_request()) {
			$events_type = $this->input->post('events_type', true);
			$show_more = $this->input->post('show_more', true);
			$events = $this->ErpEventoModel->getItems($events_type, 5, $show_more);
			if(isset($events) && !empty($events)){
				foreach($events as $event){

					$event_type_class = 'public_event';
					if($event->public != 1){
						$event_type_class = 'private_event';
					}

					$html .= ' <div class="row" data-event_id="'.$event->id .'">
                                    <div class="col-sm-4 xs-margin-bottom-10">
                                        <div class="box_event text-center '.$event_type_class.'">
                                            <p>'.date("j",strtotime($event->event_date))." ". date("F",strtotime($event->event_date)).'</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 box_event_text text-xs-center">
                                        <h4>'.$event->title.'</h4>
                                        <p style="word-break: normal;" class="role_type_mess_send">'.$event->content.'</p>
                                    </div>
                                </div>';
					$html .= '<hr>';
				}
				$html .= '<button type="button"  id="show_more"  class="btn btn-primary btn-circle">'.$this->lang->line('campus_display_more').'</button>';
			}else{
				$html .= '<p style="color:red">'.$this->lang->line('campus_no_any_data').'</p>';
			}
		}

		print_r(json_encode($html));
		exit;
	}

	public function settings(){
		$this->layouts
			->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
			->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
			->add_includes('js', 'app/js/campus/student_dashboard/student_setting.js');
		$this->data['user'] = $this->AlumnoModel->getProfileSetting($this->data['user_id']);
		if(isset($this->data['user'][0]) && !empty($this->data['user'][0])){
			$this->data['user'] = $this->data['user'][0];
		}
		$this->layouts->view('campus/student_dashboard/studnetSettingView', $this->data, $this->layout);
	}

	public function updateSettings(){
		if($this->input->post()){
			$result = array();
			$student_data = $this->AlumnoModel->get_student_by_id($this->data['user_id']);
			if(empty($student_data)){
				print_r(json_encode($result));
				exit;
			}
			$current_email = $student_data->student_email;
			$current_email2 = $student_data->email2;
			$emial = $this->input->post('email', true);
			$this->config->set_item('language', $this->data['lang']);
			$this->form_validation->set_rules('first_name', $this->lang->line('first_name'), 'trim|required');
			$this->form_validation->set_rules('last_name', $this->lang->line('last_name'), 'trim|required');
			if($emial != $current_email) {
				$this->form_validation->set_rules('email', $this->lang->line('campus_email'), 'trim|required|valid_email|is_unique[alumnos.email]|is_unique[alumnos.email2]');
			}
			if($this->input->post('email_2', true) != '' && $current_email2 != $this->input->post('email_2', true)) {
				$this->form_validation->set_rules('email_2', $this->lang->line('campus_email').' 2', 'trim|required|valid_email|is_unique[alumnos.email]|is_unique[alumnos.email2]');
			}
			if ($this->form_validation->run()) {
				$update_data = array(
								'snombre' => $this->input->post('first_name', true),
								'sapellidos' => $this->input->post('last_name', true),
								'email' => $emial,
								'email2' => $this->input->post('email_2', true),
								'ctfo1cli' => $this->input->post('phone', true),
								'movil' => $this->input->post('mobile', true),
				);
				$this->data['user_id'];
				$result['success'] = $this->AlumnoModel->updateProfileSettings($this->data['user_id'], $update_data);
				$result['errors'] = '';
			} else {
				//Check old password right or wrong
				$result['errors'] = $this->form_validation->error_array();
				$result['success'] = false;
			}
			print_r(json_encode($result));
			exit;
		}else{

		}

	}

	public function changepassword(){
		if($this->input->post()){
			$result = array();

			$this->form_validation->set_rules('old_password',$this->lang->line('old_password'), 'required|callback_oldpass_check');
			$this->form_validation->set_rules('password', $this->lang->line('new_password'), 'required|min_length[5]|max_length[25]');
			$this->form_validation->set_rules('new_password', $this->lang->line('confirm_password'), 'required|matches[password]');

			if ($this->form_validation->run()) {
				$update_data = array(
					'clave' => $this->input->post('password', true),
				);
				$this->data['user_id'];
				$result['success'] = $this->AlumnoModel->updateProfileSettings($this->data['user_id'], $update_data);
				$result['errors'] = '';
			} else {
				$result['success'] = false;
				$result['errors'] = $this->form_validation->error_array();
			}
			print_r(json_encode($result));
			exit;
		}
	}

	public function oldpass_check(){
		//Better use primary key id
		$userData = $this->session->userdata('campus_user');
		$result = $this->AlumnoModel->check_password($this->input->post('old_password', true),$userData->CCODCLI);
		if($result == 0){
			$this->form_validation->set_message('oldpass_check', "%s doesn't match.");
			return FALSE ;
		}else{
			return TRUE ;
		}
	}

}
