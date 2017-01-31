<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *@property magaModel $magaModel
 *@property UsuarioModel $UsuarioModel
 *@property ProfesorModel $ProfesorModel
 *@property AlumnoModel $AlumnoModel
 */

class Auth extends MY_Campus_Controller {


    public function __construct()
	{
            parent::__construct();
            // Your own constructor code
		    $this->load->model('UsuarioModel');
		    $this->load->model('ProfesorModel');
		    $this->load->model('AlumnoModel');
		    $this->load->model('ClientesAkaudModel');
		    $this->load->model('ClientesPlansRelationModel');
			$this->lang->load('campus',$this->session->userdata('lang'));
			$this->data['lang'] = empty($this->session->userdata('lang'))?'english':$this->session->userdata('lang');
			$this->layout = "campus_auth";
			$this->layouts->add_includes('js', 'app/js/campus/auth/main.js');
    }

	public function login2_post()
	{

		$response = array(
			'success' => false,
			'errors' => true,
			'user_role' => false,
			'error_msg' => ''
		);
		if (empty($this->_identity['loggedIn'])) {

			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$user_role = $this->input->post('user_role');

			$validate_role = false;
			if ($user_role == 1) { //teacher
				$res = $this->ProfesorModel->checkProfesorByemail($email, $password);
				$num = $res[0]['num'];
				if($num > 0){
					$validate_role = true;
					$response['user_role'] = 1;
				}else{
					$response['error_msg'][] = $this->lang->line('campus_error_not_teacher');
				}
			} elseif ($user_role == 2) { //student
				$res = $this->AlumnoModel->checkAlumnoByemail($email, $password);
				$num = $res[0]['num'];
				if($num > 0){
					$validate_role = true;
					$response['user_role'] = 2;
				}else{
					$response['error_msg'][] = $this->lang->line('campus_error_not_student');
				}
			}


			if ($validate_role) {
				$result = false;
				if ($user_role == 1) { //teacher
					$result = $this->ProfesorModel->getProfesorByemail($email, $password);
				} elseif ($user_role == 2) { //student
					$result = $this->AlumnoModel->getAlumnoByemail($email, $password);
				}
				if ($result) {
					$this->session->set_userdata('loggedIn', true);
					$this->session->set_userdata('logged_as', 'campus');
					$this->session->set_userdata('campus_user', $result[0]);
					$this->session->set_userdata('lang', $result[0]->lang);
					$this->session->set_userdata('color', $result[0]->themeColor);
					$this->session->set_userdata('layoutFormat', $result[0]->layoutFormat);

					if ($user_role == 1) { //teacher
						$this->session->set_userdata('userId', $result[0]->INDICE);
						$this->session->set_userdata('username', $result[0]->nombre);
					} elseif ($user_role == 2) { //student
						$this->session->set_userdata('userId', $result[0]->CCODCLI);
						$this->session->set_userdata('username', $result[0]->cnomcli);
					}

					$this->session->set_userdata('user_role', $user_role); //Teacher or Student

					$response['success'] = true;
					$response['errors'] = false;
				} else {
					$response['error_msg'][] = $this->lang->line('campus_error_went_wrong');
				}
			} else {
				unset($response['error_msg']);
				$response['error_msg'][] = $this->lang->line('campus_error_user_role');
			}

		}
		print_r(json_encode($response));
		exit;
	}

	public function login()
	{
		$this->layouts->add_includes('js', 'app/js/campus/auth/login.js');
		if($this->input->cookie('_cisess', TRUE) || $this->session->has_userdata("_cisess")){
			redirect('campus/auth/login2', 'refresh');
		}

		if(empty($this->_identity['loggedIn']))
		{
			$this->data['forgot_pass_date_expired'] = $this->session->userdata('forgot_pass_date_expired');
			$this->session->unset_userdata('forgot_pass_date_expired');
			$this->layouts->view('campus/auth/login1View', $this->data, $this->layout);
		}
		else
		{
			redirect('/home/', 'refresh');
		}
	}
	public function login2()
	{
		setcookie('not_show_notification', '0', time() + (86400 * 1), '/');
		$this->layouts->add_includes('js', 'app/js/campus/auth/login2.js');
		$this->lang->load('forget_pass_email', $this->data['lang']);
		if ($this->input->post()) {
			$this->login2_post();
		}
		if(!$this->input->cookie('_cisess', TRUE) && !$this->session->has_userdata("_cisess")){
			redirect('campus/auth/login', 'refresh');
		}

		if(empty($this->_identity['loggedIn']))
		{
			$this->data['forgot_pass_date_expired'] = $this->session->userdata('forgot_pass_date_expired');
			$this->session->unset_userdata('forgot_pass_date_expired');
			$this->layouts->add_includes('js', 'app/js/forgot_password/forgot_password.js');
			$this->layouts->view('campus/auth/login2View', $this->data, $this->layout);
		}
		else
		{
			redirect('/home/', 'refresh');
		}
	}

	public function key_code()
	{
		$response['success'] = false;
		$response['msg'] = false;

		if($this->input->post()){
			$max_time = 900; // 900 Seconds waiting time for login
			$login_attempts_data = $this->session->userdata('loginattempts');
			$remaning_time = isset($login_attempts_data->time) ? (float)(($max_time - (time() - $login_attempts_data->time))/60) : 0;
			if($remaning_time <= 0 && isset($login_attempts_data->count_attempt) && $login_attempts_data->count_attempt >= 5){
				$this->session->unset_userdata('loginFinal');
				$this->session->unset_userdata('loginattempts');
				$login_attempts_data = null;
			}
			if(empty($this->_identity['loggedIn']) && !$this->session->userdata('loginFinal'))
			{
				$key = $this->input->post('key', true);
				$res = $this->ClientesAkaudModel->getByKey($key);

				if(isset($res[0])){
					if($res[0]->active == 0){
						$response['msg'] = $this->lang->line('key_code_inactive');
					}else if($res[0]->start_date > date('Y-m-d') ||  $res[0]->end_date < date('Y-m-d')){
						$response['msg'] = $this->lang->line('key_code_dates_msg');
					}else{
						$db_details = (array)$res[0];
						$plan_options = $this->session->userdata('_plan_options');

						if(empty($plan_options)){
							if(isset($db_details['plan'])){
								$plan_options = $this->ClientesPlansRelationModel->getOptions($db_details['plan']);
							}
							$this->session->set_userdata('_plan_options', $plan_options);
						}

//						$db_details_json_base64_encode = base64_encode(json_encode($db_details));
//						setcookie('_cisess', $db_details_json_base64_encode,time() + (86400 * 30), "/"); //30 days

						$key_base64_encode = base64_encode($res[0]->key);
						setcookie('_cisess', $key_base64_encode,time() + (86400 * 1), "/"); //1 day
						
						$this->session->set_userdata('_cisess', $db_details);
						$this->session->unset_userdata('loginattempts');
						$response['success'] = true;
					}
				}else{
					$login_attempts = (object)array(
						'count_attempt' => isset($login_attempts_data->count_attempt) ? $login_attempts_data->count_attempt + 1 : 1,
						'time' => isset($login_attempts_data->count_attempt) && ($login_attempts_data->count_attempt >= 4)  ? !$login_attempts_data->time ?  time() : $login_attempts_data->time : null
					);
					$this->session->set_userdata('loginattempts', $login_attempts);
					if($login_attempts->count_attempt >= 5 ){
						$this->session->set_userdata('loginFinal', true);
					}
					$response['msg'] = $this->lang->line('keycode_invalid_try') . (5 - $login_attempts->count_attempt).  $this->lang->line('keycode_invalid_try_time');
					$response['success'] = false;
				}
			} else {
				$remaning_time =  (float)(($max_time - (time() - $login_attempts_data->time))/60);
				$response['msg'] = "You can try login after ". round($remaning_time) ." minits";
				$response['success'] = false;
			}
		}
		print_r(json_encode($response));
		exit;
	}

	public function logout()
	{
		$this->session->sess_destroy();
  		redirect('campus/auth/login/', 'refresh');
	}

	public function profileFoto() {
		$this->load->model('MensajeModel');
		$campus_user = $this->session->userdata('campus_user');
		$userId = $this->session->userdata('userId');
		$username = $this->session->userdata('username');
		$user_role = $this->session->userdata('user_role');
		if($userId){
			$message_count = $this->MensajeModel->getNewMessages($userId, $user_role);
		}
		$data['message_count'] = isset($message_count->num) ? $message_count->num : 0;
		$data['userId'] = $userId;
		$data['username'] = $username;
		if($user_role == '1') {
			$photo_url = $this->ProfesorModel->getTeacherPhotoLink($userId);
		}elseif($user_role == '2'){
			$photo_url = $this->AlumnoModel->getStudentPhotoLink($userId);
		}else{
			$photo_url = null;
		}

		$data['imageUrl'] = isset($photo_url->photo_link) && !empty($photo_url->photo_link) ? $photo_url->photo_link : (!empty($campus_user->foto) ? 'data:image/jpeg;base64,'.base64_encode($campus_user->foto) : null);
        if(empty($data['imageUrl'])){
			$data['imageUrl'] = base_url().'assets/img/dummy-image.jpg';
		}
		print_r(json_encode($data));
	}

	public function checkConnection(){
		print_r(json_encode(array('success'=>true)));
		exit;
	}
	
	public function setLang(){
		if($this->input->post('lang')){
			$lang = ($this->input->post('lang')==1)?'english':'spanish';
			$this->session->set_userdata('lang',$lang);
			return true;
		}
	}
}
