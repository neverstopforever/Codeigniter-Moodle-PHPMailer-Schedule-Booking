<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Base_api_public {


    public function __construct()
	{
            parent::__construct();
            // Your own constructor code
		    $this->load->model('UsuarioModel');
		    $this->load->model('ClientesAkaudModel');
		    $this->load->model('ClientesPlansRelationModel');
		    $this->load->model('Variables2Model');

			$this->layout = 'auth';
			$this->layouts->add_includes('js', 'app/js/auth/main.js');
			if(empty($this->data['lang'])){
				$this->session->set_userdata('lang', 'spanish');
				$this->data['lang'] = 'spanish';
			}
    }

	public function login_get()
	{
		$this->layouts->add_includes('js', 'app/js/auth/login.js');
		$this->data['page'] = 'login';
		if($this->input->cookie('_cisess', TRUE) || $this->session->has_userdata("_cisess")){
			redirect('/auth/login2', 'refresh');
		}
		if(empty($this->_identity['loggedIn']))
		{

//			$this->load->view('loginView');
			$this->layouts->view('api/auth/login1View', $this->data, $this->layout);
		}
		else
		{
  			redirect('/home/', 'refresh');
		}
	}

	public function login_post() {
		//lang, key
		$lang = $this->post('lang');
		if ($lang == 'english' || $lang == 'spanish') {
			$this->session->set_userdata('lang', $lang);
		}
		$response['message'] = $this->lang->line('db_err_msg');
		$response['status'] = false;

		$http_code = null;

		$max_time = 900; // 900 Seconds waiting time for login
		$login_attempts_data = $this->session->userdata('loginattempts');
		$remaning_time = isset($login_attempts_data->time) ? (float)(($max_time - (time(
					) - $login_attempts_data->time)) / 60) : 0;
		if ($remaning_time <= 0 && isset($login_attempts_data->count_attempt) && $login_attempts_data->count_attempt >= 5) {
			$this->session->unset_userdata('loginFinal');
			$this->session->unset_userdata('loginattempts');
			$login_attempts_data = null;
		}
		if (empty($this->_identity['loggedIn']) && !$this->session->userdata('loginFinal')) {
			$key = $this->post('key');
			$res = $this->ClientesAkaudModel->getByKey($key);

			if (isset($res[0])) {
				if ($res[0]->active == 0) {
					$response['status'] = array(
						'status' => false,
						'message' => $this->lang->line('key_code_inactive')
					);
					$http_code = REST_Controller::HTTP_UNAUTHORIZED;

				} else {
					if ($res[0]->start_date > date('Y-m-d') || $res[0]->end_date < date('Y-m-d')) {
						$response['status'] = array(
							'status' => false,
							'message' => $this->lang->line('key_code_dates_msg')
						);
						$http_code = REST_Controller::HTTP_UNAUTHORIZED;

					} else {
						$db_details = (array)$res[0];
						$plan_options = $this->session->userdata('_plan_options');

						if (empty($plan_options)) {
							if (isset($db_details['plan'])) {
								$plan_options = $this->ClientesPlansRelationModel->getOptions($db_details['plan']);
							}
							$this->session->set_userdata('_plan_options', $plan_options);
						}

//						$db_details_json_base64_encode = base64_encode(json_encode($db_details));
//						setcookie('_cisess', $db_details_json_base64_encode, time() + (86400 * 30), "/"); //30 days

						$key_base64_encode = base64_encode($res[0]->key);
						setcookie('_cisess', $key_base64_encode,time() + (86400 * 1), "/"); //1 day
						
						$this->session->set_userdata('_cisess', $db_details);
						$this->session->unset_userdata('loginattempts');

						$response['status'] = true;
						$response['message'] = 'OK';
//						$response['_cisess'] = $db_details_json_base64_encode; //???
						$http_code = REST_Controller::HTTP_OK;
					}
				}
			} else {
				$response['message'] = $this->lang->line('api_auth_invalid_key_code');
				$http_code = REST_Controller::HTTP_UNAUTHORIZED;
			}
		}else{
			$remaning_time =  (float)(($max_time - (time() - $login_attempts_data->time))/60);
			$response['message'] = sprintf($this->lang->line('api_auth_try_login_after'), round($remaning_time));
		}
		//Set the response and exit.
		$this->response($response,$http_code);
	}

	public function login2_get()
	{
		$this->layouts->add_includes('js', 'app/js/auth/login2.js');
//		if ($this->input->post()) {
//			$this->login2_post();
//		}
		if(!$this->input->cookie('_cisess', TRUE) && !$this->session->has_userdata("_cisess")){
			redirect('/auth/login', 'refresh');
		}

		if(empty($this->_identity['loggedIn']))
		{
			$this->layouts->add_includes('js', 'app/js/forgot_password/forgot_password.js');
			$this->layouts->view('auth/login2View', $this->data, $this->layout);
		}
		else
		{
			redirect('/home/', 'refresh');
		}
	}

	public function login2_post(){
		$http_code = null;
		$response['active'] = true;
		$response['status'] = false;
		$response['message'] = false;
		$response['twice_login'] = false;

		if (empty($this->_identity['loggedIn'])) {
			$username = $this->post('username');
			$password = $this->post('password');
			$result = $this->UsuarioModel->varifyLogin($username, $password);
			$start_end_time = $this->Variables2Model->getStartEndtime();

			$start_itme = substr($start_end_time->start_time, 0, -2).':'.substr($start_end_time->start_time, -2);
			$end_time = substr($start_end_time->end_time, 0, -2).':'.substr($start_end_time->end_time, -2);

			if ($result) {
				$this->load->model('UserSessionModel');
//				$user_id = $result[0]->Id;
//				$is_user_online = $this->UserSessionModel->checkOnlineUser($user_id);
//
//				if($is_user_online){
//					$response['twice_login'] = true;
//					$response['message'] = $this->lang->line('login2_logged_yet');
//					$http_code = REST_Controller::HTTP_OK;
//				}else{
					if ($result[0]->active != '1') {
						$locked_data = array(
							'id' => $result[0]->Id,
							'user_name' => $result[0]->Nombre,
							'email' => $result[0]->email,
							'photo' => $result[0]->foto,
						);
						$this->session->set_userdata('userLockedData', $locked_data);
						$response['active'] = false;
						$http_code = REST_Controller::HTTP_LOCKED;
					} else {

						$this->session->set_userdata('loggedIn', true);
						$this->session->set_userdata('logged_as', 'lms');
						$this->session->set_userdata('userData', $result);
						if (empty($this->data['lang'])) {
							$this->session->set_userdata('lang', $result[0]->lang);
						}
						$this->session->set_userdata('color', $result[0]->themeColor);
						$this->session->set_userdata('layoutFormat', $result[0]->layoutFormat);
						$this->session->set_userdata('postWriter', $result[0]->post_writer);


						$this->session->set_userdata('start_time', $start_itme);
						$this->session->set_userdata('end_time', $end_time);

						$plan_options = null;
						if (isset($this->_db_details->plan)) {
							$plan_options = $this->ClientesPlansRelationModel->getOptions($this->_db_details->plan);
						}
						$this->session->set_userdata('_plan_options', $plan_options);

						$response['status'] = true;
						$response['message'] = "OK";
						$http_code = REST_Controller::HTTP_OK;
					}
//				}

			} else {
				$response['message'] = $this->lang->line('login2_incorrect_details');
				$http_code = REST_Controller::HTTP_NOT_FOUND;
			}
		} else {
			$response['message'] = $this->lang->line('login2_logged_in');
			$http_code = REST_Controller::HTTP_OK;
		}
		//Set the response and exit.
		$this->response($response, $http_code);
	}

	public function keyCodeLogin_post(){
		$http_code = null;
		$response['active'] = true;
		$response['status'] = false;
		$response['message'] = false;
		$response['twice_login'] = false;

		$lang = $this->post('lang');
		if ($lang == 'english' || $lang == 'spanish') {
			$this->session->set_userdata('lang', $lang);
		}



		if (empty($this->_identity['loggedIn'])) {

			$key_code = $this->post('key_code');
			$res = $this->ClientesAkaudModel->getByKey($key_code);

			if (isset($res[0])) {
				if ($res[0]->active == 0) {
					$response['status'] = array(
						'status' => false,
						'message' => $this->lang->line('key_code_inactive')
					);
					$http_code = REST_Controller::HTTP_UNAUTHORIZED;

				} else {
					if ($res[0]->start_date > date('Y-m-d') || $res[0]->end_date < date('Y-m-d')) {
						$response['status'] = array(
							'status' => false,
							'message' => $this->lang->line('key_code_dates_msg')
						);
						$http_code = REST_Controller::HTTP_UNAUTHORIZED;

					} else {
						$db_details = (array)$res[0];
						$plan_options = $this->session->userdata('_plan_options');

						if (empty($plan_options)) {
							if (isset($db_details['plan'])) {
								$plan_options = $this->ClientesPlansRelationModel->getOptions($db_details['plan']);
							}
							$this->session->set_userdata('_plan_options', $plan_options);
						}


//						$db_details_json_base64_encode = base64_encode(json_encode($db_details));
//						setcookie('_cisess', $db_details_json_base64_encode, time() + (86400 * 30), "/"); //30 days

						$key_base64_encode = base64_encode($res[0]->key);
						setcookie('_cisess', $key_base64_encode,time() + (86400 * 1), "/"); //1 day
						
						$this->session->set_userdata('_cisess', $db_details);

						$username = $this->post('username');
						$password = $this->post('password');
						$result = $this->UsuarioModel->varifyLogin($username, $password);
						$start_end_time = $this->Variables2Model->getStartEndtime();

						$start_itme = substr($start_end_time->start_time, 0, -2).':'.substr($start_end_time->start_time, -2);
						$end_time = substr($start_end_time->end_time, 0, -2).':'.substr($start_end_time->end_time, -2);

						if ($result) {
							$this->load->model('UserSessionModel');
//				$user_id = $result[0]->Id;
//				$is_user_online = $this->UserSessionModel->checkOnlineUser($user_id);
//
//				if($is_user_online){
//					$response['twice_login'] = true;
//					$response['message'] = $this->lang->line('login2_logged_yet');
//					$http_code = REST_Controller::HTTP_OK;
//				}else{
							if ($result[0]->active != '1') {
								$locked_data = array(
									'id' => $result[0]->Id,
									'user_name' => $result[0]->Nombre,
									'email' => $result[0]->email,
									'photo' => $result[0]->foto,
								);
								$this->session->set_userdata('userLockedData', $locked_data);
								$response['active'] = false;
								$http_code = REST_Controller::HTTP_LOCKED;
							} else {

								$this->session->set_userdata('loggedIn', true);
								$this->session->set_userdata('userData', $result);
								if (empty($this->data['lang'])) {
									$this->session->set_userdata('lang', $result[0]->lang);
								}
								$this->session->set_userdata('color', $result[0]->themeColor);
								$this->session->set_userdata('layoutFormat', $result[0]->layoutFormat);
								$this->session->set_userdata('postWriter', $result[0]->post_writer);


								$this->session->set_userdata('start_time', $start_itme);
								$this->session->set_userdata('end_time', $end_time);

								$plan_options = null;
								if (isset($this->_db_details->plan)) {
									$plan_options = $this->ClientesPlansRelationModel->getOptions($this->_db_details->plan);
								}
								$this->session->set_userdata('_plan_options', $plan_options);

								$response['status'] = true;
								$response['message'] = "OK";
								$http_code = REST_Controller::HTTP_OK;
							}
//				}

						} else {
							$response['message'] = $this->lang->line('login2_incorrect_details');
							$http_code = REST_Controller::HTTP_NOT_FOUND;
						}
					}
				}
			} else {
				$response['message'] = $this->lang->line('api_auth_invalid_key_code');
				$http_code = REST_Controller::HTTP_UNAUTHORIZED;
			}
		} else {
			$response['message'] = $this->lang->line('login2_logged_in');
			$http_code = REST_Controller::HTTP_OK;
		}
		//Set the response and exit.
		$this->response($response, $http_code);
	}




	public function loginAdmin_get()
	{
		$this->data['page'] = 'login';
		$this->layouts->add_includes('js', 'app/js/auth/login_admin.js');
		if ($this->input->post()) {
			$this->loginAdmin_post();
		}

		if(empty($this->_identity['loggedIn']))
		{
			$this->layouts->view('auth/loginAdminView', $this->data, $this->layout);
		}
		else
		{
			redirect('/cpanel/', 'refresh');
		}
	}

	public function loginAdmin_post()
	{
		$this->load->model('UserAdminModel');

		$response['status'] = false;
		$response['message'] = false;
		$http_code = null;
		if(empty($this->_identity['loggedIn']))
		{
			$username = $this->post('username');
			$password = $this->post('password');
			$result = $this->UserAdminModel->verifyLogin($username,$password);

			if($result)
			{
				$this->session->set_userdata('loggedIn', true);
				$this->session->set_userdata('userData', $result[0]);
//				$this->session->set_userdata('lang', $result[0]->lang);
//				$this->session->set_userdata('color', $result[0]->themeColor);
//				$this->session->set_userdata('layoutFormat', $result[0]->layoutFormat);
//				$this->session->set_userdata('postWriter', $result[0]->post_writer);


				$this->session->set_userdata('lang', 'spanish');
				$this->session->set_userdata('color', 'blue-hoki');
				$this->session->set_userdata('layoutFormat', 'boxed');
				$this->session->set_userdata('postWriter', '');


				$plan_options = null;
				if(isset($this->_db_details->plan)){
					$plan_options = $this->ClientesPlansRelationModel->getOptions($this->_db_details->plan);
				}
				$this->session->set_userdata('_plan_options', $plan_options);
				$response['status'] = true;
				$http_code = REST_Controller::HTTP_OK;
			}else{
				$response['message'] = $this->lang->line('admin_incorrect_details');
				$http_code = REST_Controller::HTTP_NOT_FOUND;
			}
		}else{
			$response['message'] = $this->lang->line('admin_logged_in');
			$http_code = REST_Controller::HTTP_UNAUTHORIZED;
		}
		//Set the response and exit.
		$this->response($response, $http_code);
	}


	public function logout()
	{
		$this->session->sess_destroy();
  		redirect('/auth/login/', 'refresh');
	}

	public function profileFoto() {
		$userData = $this->session->userdata('userData');
		$USUARIO = $userData[0]->USUARIO;
		$details = $this->UsuarioModel->getProfileFoto($USUARIO);
		$data = array();
		$data['USUARIO'] = $USUARIO;
		$data['imageUrl'] = 'data:image/jpeg;base64,'.base64_encode($details[0]->foto);
		print_r(json_encode($data));
	}

	public function checkConnection(){
		print_r(json_encode(array('success'=>true)));
		exit;
	}

	public function setLang(){
		$res = array();
		$res['success'] = false;
		if ($this->input->post()) {
			$lang = $this->input->post('lang', true);
			if($lang == 'english' || $lang == 'spanish'){
				$this->session->set_userdata('lang', $lang);
				$res['success'] = true;
			}
		}
		print_r(json_encode($res));
		exit;
	}

	public function checkUserStatus(){
		if($this->input->is_ajax_request()) {
			$result = true;
			$user_details = isset($this->data['userData'][0]) ? (object)$this->data['userData'][0] : null;
			if (!empty($user_details)) {
				$user_data = $this->UsuarioModel->get_users(array('Id' => $user_details->Id));
				if (!empty($user_data) && isset($user_data[0]->status)) {
					$status = $user_data[0]->status;
					if ($status != '1') {
						$result = false;
						$this->session->unset_userdata('loggedIn');
						$this->session->unset_userdata('userData');
						$this->session->unset_userdata('lang');
						$this->session->unset_userdata('color');
						$this->session->unset_userdata('layoutFormat');
						$this->session->unset_userdata('postWriter');
						$this->session->unset_userdata('userLockedData');
						$this->session->set_userdata('userLockedData', $user_data[0]);
					}
				}
			}
			echo json_encode((array('result' => $result)));
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
	
}
