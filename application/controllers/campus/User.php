<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Campus_Controller {
	
	public $pid = "";
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('UsuarioModel');
		$this->load->model('ProfesorModel');
		$this->load->model('AlumnoModel');
		$this->load->library('form_validation');
		$this->lang->load('campus',$this->data['lang']);
		if(!$this->session->userdata('campus_user')){
			redirect('campus/auth/login/', 'refresh');
		}
		$userData= (array)$this->session->userdata('campus_user');
		$this->pid = $userData['INDICE'];
		//Check Authentication
		$this->layouts->add_includes('js', 'app/js/campus/user/main.js');
	}
	
	public function setting(){
		$this->layouts
			->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
			->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
		    ->add_includes('js', 'app/js/campus/user/setting.js');

		$this->data['teacher_id'] = $this->pid;
		$this->data['user'] = $this->ProfesorModel->profile($this->pid);
		$this->layouts->view('campus/users/setting', $this->data, $this->layout);
	}
	
	public function changepassword(){
		if($this->input->post()){
			$this->form_validation->set_rules('old_password', 'Old Password', 'required|callback_oldpass_check');
			$this->form_validation->set_rules('password', 'New Password', 'required|min_length[5]|max_length[25]');
			$this->form_validation->set_rules('new_password', 'Confirm password', 'required|matches[password]');
			
			if ($this->form_validation->run() == false) {
				$this->session->set_flashdata('error', validation_errors());
				//redirect('');
			} else {
				//Check old password right or wrong
				$userData= (array)$this->session->userdata('campus_user');
				$result = $this->ProfesorModel->change_password($userData['INDICE'], $this->input->post('password'));
				if($result){
					//Success
				} else {
					//Error
				}
			}
		}
		redirect('/campus/user/setting');
	}
	
	public function forget_password(){
		//Encrypt password		
		if($this->input->post()){
			$this->form_validation->set_rules('email', 'Email', 'required');
			if ($this->form_validation->run() == false) {
				$this->session->set_flashdata('error', validation_errors());
				//redirect
			} else {
				//soporte4@softaula.com
				$this->ProfesorModel->forget_password($this->input->post('email'));
			}
		}
		redirect('/campus/auth/login#forget');
	}
	
	public function oldpass_check(){
		//Better use primary key id
		$userData = $this->session->userdata('campus_user');
		$result = $this->ProfesorModel->check_password($this->input->post('old_password'),$userData['INDICE']);
		if($result ==0){
			$this->form_validation->set_message('oldpass_check', "%s doesn't match.");
			return FALSE ;  
		}else{
			return TRUE ;
		}
	}
	
	public function getstudentlist(){
		$result = $this->AlumnoModel->listAlumno($this->pid);
		print_r(json_encode($result));
	}


	public function setLayoutFormat(){
		$details = array();
		if ($this->input->post()) {
			$layoutFormat=$this->input->post('layoutFormat', true);
			$campus_user = $this->session->userdata('campus_user');
			$data_layoutFormat = array('layoutFormat'=>$layoutFormat);
			if(is_object($campus_user) && !empty($campus_user)){
				$user_role =$this->session->userdata('user_role');
				if ($user_role == 1) { //teacher
					$details = $this->ProfesorModel->updateItem($data_layoutFormat, $campus_user->INDICE);
				} elseif ($user_role == 2) { //student
					$details = $this->AlumnoModel->updateItem($data_layoutFormat, $campus_user->CCODCLI);
				}
			}
			$this->session->set_userdata('layoutFormat', $layoutFormat);
		}
		print_r($details);
		exit;
	}
	public function setThemeColor(){
		$details = array();
		if ($this->input->post()) {
			$themeColor = $this->input->post('themeColor', true);
			$campus_user = $this->session->userdata('campus_user');
			$data_themeColor = array('themeColor'=>$themeColor);
			if(is_object($campus_user) && !empty($campus_user)){
				$user_role =$this->session->userdata('user_role');
				if ($user_role == 1) { //teacher
					$details = $this->ProfesorModel->updateItem($data_themeColor, $campus_user->INDICE);
				} elseif ($user_role == 2) { //student
					$details = $this->AlumnoModel->updateItem($data_themeColor, $campus_user->CCODCLI);
				}
			}
			$this->session->set_userdata('color', $themeColor);
		}
		print_r($details);
		exit;
	}
	public function setLang(){
		$details = array();
		if ($this->input->post()) {

			$lang = $this->input->post('lang', true);
			$campus_user = $this->session->userdata('campus_user');
			$data_lang = array('lang'=>$lang);
			if(is_object($campus_user) && !empty($campus_user)){
				$user_role =$this->session->userdata('user_role');
				if ($user_role == 1) { //teacher
					$details = $this->ProfesorModel->updateItem($data_lang, $campus_user->INDICE);
				} elseif ($user_role == 2) { //student
					$details = $this->AlumnoModel->updateItem($data_lang, $campus_user->CCODCLI);
				}
			}
			$this->session->set_userdata('lang', $lang);
		}
		print_r($details);
		exit;

	}

	public function updateSettings(){
		if($this->input->post()){
			$result = array();
			$teacher_data = $this->ProfesorModel->getTeacherById($this->pid);
			if(empty($teacher_data)){
				print_r(json_encode($result));
				exit;
			}
			$current_email = $teacher_data->email1;
			$current_email2 = $teacher_data->email2;
			$emial = $this->input->post('email', true);
			$this->config->set_item('language', $this->data['lang']);
			$this->form_validation->set_rules('first_name', $this->lang->line('first_name'), 'trim|required');
			$this->form_validation->set_rules('last_name', $this->lang->line('last_name'), 'trim|required');
			if($emial != $current_email) {
				$this->form_validation->set_rules('email', $this->lang->line('campus_email'), 'trim|required|valid_email|is_unique[profesor.Email]|is_unique[profesor.Email2]');
			}
			if($this->input->post('email_2', true) != '' && $current_email2 != $this->input->post('email_2', true)) {
				$this->form_validation->set_rules('email_2', $this->lang->line('campus_email').' 2', 'trim|required|valid_email|is_unique[profesor.Email]|is_unique[profesor.Email2]');
			}
			if ($this->form_validation->run()) {
				$update_data = array(
					'snombre' => $this->input->post('first_name', true),
					'sapellidos' => $this->input->post('last_name', true),
					'Email' => $emial,
					'Email2' => $this->input->post('email_2', true),
					//'ctfo1cli' => $this->input->post('phone', true),
					'movil' => $this->input->post('mobile', true),
					'Domicilio' => $this->input->post('address', true),
				);
				$result['success'] = $this->ProfesorModel->updateProfileSettings($this->pid, $update_data);
				$result['errors'] = '';
			} else {
				$result['errors'] = $this->form_validation->error_array();
				$result['success'] = false;
			}
			print_r(json_encode($result));
			exit;
		}else{

		}

	}
}