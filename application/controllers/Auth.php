<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *@property magaModel $magaModel
 *@property UsuarioModel $UsuarioModel
 *@property ClientesAkaudModel $ClientesAkaudModel
 *@property Variables2Model $Variables2Model
 *@property ClientesUpdatesModel $ClientesUpdatesModel
 *@property ApdateBatchModel $ApdateBatchModel
 *@property ClientesLogModel $ClientesLogModel
 */


class Auth extends Public_Controller {


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
//			if(empty($this->data['lang'])){
//				$this->session->set_userdata('lang', 'spanish');
//				$this->data['lang'] = 'spanish';
//			}
    }

	public function login()
	{
		$this->layouts->add_includes('js', 'app/js/auth/login.js');
		$this->data['page'] = 'login';

		if($this->input->cookie('_cisess', TRUE) || $this->session->has_userdata("_cisess")){
			redirect('/auth/login2', 'refresh');
		}
		if(empty($this->_identity['loggedIn']))
		{
			$this->data['forgot_pass_date_expired'] = $this->session->userdata('forgot_pass_date_expired');
			$this->session->unset_userdata('forgot_pass_date_expired');
//			$this->load->view('loginView');
			$this->layouts->view('auth/login1View', $this->data, $this->layout);
		}
		else
		{
  			redirect('/home/', 'refresh');
		}
	}
	public function login2()
	{
		setcookie('not_show_notification', '0', time() + (86400 * 1), '/');
		$this->layouts->add_includes('js', 'app/js/auth/login2.js');
		$this->lang->load('forget_pass_email', $this->data['lang']);
		$this->data['page'] = 'login';
		if ($this->input->post()) {
			$this->login2_post();
		}
	
		if(!$this->input->cookie('_cisess', TRUE) && !$this->session->has_userdata("_cisess")){
			redirect('/auth/login', 'refresh');
		}

		if(empty($this->_identity['loggedIn']))
		{
			$this->data['forgot_pass_date_expired'] = $this->session->userdata('forgot_pass_date_expired');
			$this->session->unset_userdata('forgot_pass_date_expired');
			$this->layouts->add_includes('js', 'app/js/forgot_password/forgot_password.js');
			$this->layouts->view('auth/login2View', $this->data, $this->layout);

		}
		else
		{
			redirect('/home/', 'refresh');
		}
	}

	public function login2_post()
	{
		$response['active'] = true;
		$response['success'] = false;
		$response['msg'] = false;
		$response['twice_login'] = false;
		if(empty($this->_identity['loggedIn']))
		{
			$username = $this->input->post('username', true);
			$password = $this->input->post('password', true);
			$result = $this->UsuarioModel->varifyLogin($username, $password);
			$start_end_time = $this->Variables2Model->getStartEndtime();

			$start_itme = substr($start_end_time->start_time, 0, -2).':'.substr($start_end_time->start_time, -2);
			$end_time = substr($start_end_time->end_time, 0, -2).':'.substr($start_end_time->end_time, -2);

			if($result){
				if(ENVIRONMENT == "development"){
					if($result[0]->active != '1'){
						$locked_data = array(
							'id' => $result[0]->Id,
							'user_name' => $result[0]->Nombre,
							'email' => $result[0]->email,
							'photo' => $result[0]->foto
						);
						$this->session->set_userdata('userLockedData', $locked_data);
						$response['active'] = false;
					}else{
						$this->load->model('ClientesLogModel');
						$insert_data = array(
							'ccodcli' => $this->_db_details->idcliente,
							'ip' => $this->input->ip_address(),
							'usuario' => $result[0]->USUARIO,
							'url' => base_url().'auth/login2',
							'date_time' => date("Y-m-d H:i:s"),
						);
						
						$this->ClientesLogModel->insertData($insert_data);
						$this->session->set_userdata('loggedIn', true);
						$this->session->set_userdata('logged_as', 'lms');
						$this->session->set_userdata('userData', $result);
						if(empty($this->data['lang'])){
							$this->session->set_userdata('lang', $result[0]->lang);
						}
						$this->session->set_userdata('color', $result[0]->themeColor);
						$this->session->set_userdata('layoutFormat', $result[0]->layoutFormat);
						$this->session->set_userdata('postWriter', $result[0]->post_writer);


						$this->session->set_userdata('start_time', $start_itme);
						$this->session->set_userdata('end_time', $end_time);

						$plan_options = null;
						if(isset($this->_db_details->plan)){
							$plan_options = $this->ClientesPlansRelationModel->getOptions($this->_db_details->plan);
						}
						
						$this->session->set_userdata('_plan_options', $plan_options);
						$this->session->set_userdata('trial_expire', $this->_db_details->trial_expire);

						$this->load->model('InvoiceModel');
						$no_paid_invoices_exist = $this->InvoiceModel->check_no_paid_items($this->_db_details->id);
						$this->session->set_userdata('no_paid_invoices_exist', $no_paid_invoices_exist);
						if(!empty($this->_db_details->trial_expire) && $this->_db_details->paid != 1 && $this->_db_details->plan != 1){
							$your_date = strtotime($this->_db_details->trial_expire);
							$datediff = $your_date - time();
							$remaining_days = floor($datediff/(60*60*24)) + 1;
							$this->session->set_userdata('remaining_days', $remaining_days);
							$this->session->set_userdata('remaining_days_show', 1);
						}elseif(empty($this->_db_details->trial_expire) && $this->_db_details->paid != 1 && $this->_db_details->plan == 1){
							$this->session->set_userdata('remaining_days', 0);
							$this->session->set_userdata('remaining_days_show', 0);
						}elseif(empty($this->_db_details->trial_expire) && $this->_db_details->paid != 1 && $this->_db_details->plan){
							//$this->session->set_userdata('remaining_days', 1);
							$this->session->set_userdata('remaining_days_show', 0);
						}else{
							$this->session->set_userdata('remaining_days', null);
							$this->session->set_userdata('remaining_days_show', 0);
						}

						$response['success'] = true;
						$db_debug = $this->db->db_debug;
						$this->db->db_debug = false;

						$this->executingUpdateVersion();
						$this->executingUpdateBatch();
						$this->db->db_debug = $db_debug;

					}
				}elseif(ENVIRONMENT == "production"){
					$this->load->model('UserSessionModel');
					$user_id = $result[0]->Id;
					$is_user_online = $this->UserSessionModel->checkOnlineUser($user_id);
//					printr($is_user_online);die;
					if($is_user_online){
						$response['twice_login'] = true;
						$response['msg'] = $this->lang->line('login2_logged_yet');
					}else{
						if($result[0]->active != '1'){
							$locked_data = array(
								'id' => $result[0]->Id,
								'user_name' => $result[0]->Nombre,
								'email' => $result[0]->email,
								'photo' => $result[0]->foto
							);
							$this->session->set_userdata('userLockedData', $locked_data);
							$response['active'] = false;
						}else{
							$this->load->model('ClientesLogModel');
							$insert_data = array(
								'ccodcli' => $this->_db_details->idcliente,
								'ip' => $this->input->ip_address(),
								'usuario' => $result[0]->USUARIO,
								'url' => base_url().'auth/login2',
								'date_time' => date("Y-m-d H:i:s"),
							);

							$this->ClientesLogModel->insertData($insert_data);
							$this->session->set_userdata('loggedIn', true);
							$this->session->set_userdata('logged_as', 'lms');
							$this->session->set_userdata('userData', $result);
							if(empty($this->data['lang'])){
								$this->session->set_userdata('lang', $result[0]->lang);
							}
							$this->session->set_userdata('color', $result[0]->themeColor);
							$this->session->set_userdata('layoutFormat', $result[0]->layoutFormat);
							$this->session->set_userdata('postWriter', $result[0]->post_writer);
	
	
							$this->session->set_userdata('start_time', $start_itme);
							$this->session->set_userdata('end_time', $end_time);
	
							$plan_options = null;
							if(isset($this->_db_details->plan)){
								$plan_options = $this->ClientesPlansRelationModel->getOptions($this->_db_details->plan);
							}
							$this->session->set_userdata('_plan_options', $plan_options);
							$this->session->set_userdata('trial_expire', $this->_db_details->trial_expire);


							$this->load->model('InvoiceModel');
							$no_paid_invoices_exist = $this->InvoiceModel->check_no_paid_items($this->_db_details->id);
							$this->session->set_userdata('no_paid_invoices_exist', $no_paid_invoices_exist);

							
							if(!empty($this->_db_details->trial_expire) && $this->_db_details->paid != 1 && $this->_db_details->plan != 1){
								$your_date = strtotime($this->_db_details->trial_expire);
								$datediff = $your_date - time();
								$remaining_days = floor($datediff/(60*60*24));
								$this->session->set_userdata('remaining_days', $remaining_days);
								$this->session->set_userdata('remaining_days_show', 1);
							}elseif(empty($this->_db_details->trial_expire) && $this->_db_details->paid != 1 && $this->_db_details->plan != 1){
								$this->session->set_userdata('remaining_days', 0);
								$this->session->set_userdata('remaining_days_show', 1);
							}else{
								$this->session->set_userdata('remaining_days', null);
								$this->session->set_userdata('remaining_days_show', 0);
							}
	
							$response['success'] = true;
							$db_debug = $this->db->db_debug;
							$this->db->db_debug = false;

							$this->executingUpdateVersion();
							$this->executingUpdateBatch();

							$this->db->db_debug = $db_debug;
						}
					}
				}else{
					$response['msg'] = $this->lang->line('db_err_msg');
				}

			}else{
				$response['msg'] = $this->lang->line('login2_incorrect_details');
			}
		}else{
			$response['msg'] = $this->lang->line('login2_logged_in');
		}
		print_r(json_encode($response));
		exit;
	}

	private function executingUpdateBatch(){
		$this->load->model('ApdateBatchModel');
		$csql_queries = $this->ApdateBatchModel->getCsqls();
		if(!empty($csql_queries)){
			foreach($csql_queries as $query){
				$this->ApdateBatchModel->executingQuery($query->csql);
			}
		}
	}

	private function executingUpdateVersion(){
		$this->load->model('ClientesUpdatesModel');
		$result = false;
		$exist_field = $this->Variables2Model->exist_field('version_akaud');
		if(!$exist_field){
			$result_add = $this->Variables2Model->add_version_akaud_field();
			if(!$result_add){
				return false;
			}
		}
		$version_akaud = $this->Variables2Model->get_version_akaud();
		$update_data = $this->ClientesUpdatesModel->getUpdateByVersion($version_akaud);
		if(!empty($update_data)){
			$latest_version = 0;
			foreach($update_data as $data) {
				try {
					$this->Variables2Model->executingCsql($data->csql);
					$latest_version = $data->version;
				} catch (Exception $e) {
					//echo 'Caught exception: ',  $e->getMessage(), "\n";
					break;
				}
			}
			if($latest_version){
				$result = $this->Variables2Model->updateVersionAkaud($latest_version);
			}
		}
		return 	$result;
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
						$test_connection = $this->_check_db('mysqli',$db_details['DBHost_IPserver'],$db_details['DBHost_user'],$db_details['DBHost_pwd'],$db_details['DBHost_db'],$port = 3306);
						if($test_connection) {
							$plan_options = $this->session->userdata('_plan_options');

							if (empty($plan_options)) {
								if (isset($db_details['plan'])) {
									$plan_options = $this->ClientesPlansRelationModel->getOptions($db_details['plan']);
								}
								$this->session->set_userdata('_plan_options', $plan_options);
							}


//						$db_details_json_base64_encode = base64_encode(json_encode($db_details));
//						setcookie('_cisess', $db_details_json_base64_encode,time() + (86400 * 30), "/"); //30 days
							$key_base64_encode = base64_encode($key);
							setcookie('_cisess', $key_base64_encode, time() + (86400 * 1), "/"); //1 day
							$this->session->set_userdata('_cisess', $db_details);
							$this->session->unset_userdata('loginattempts');
							$response['success'] = true;
							$lang = $this->input->post('lang', true);
							if ($lang == 'english' || $lang == 'spanish') {
								$this->session->set_userdata('lang', $lang);
							}
						}else{
							$response['db_connnection_error'] = $this->lang->line('db_connnection_error');
						}
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
					$response['msg'] = $this->lang->line('keycode_invalid_try') .  (5 - $login_attempts->count_attempt).   $this->lang->line('keycode_invalid_try_time');
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


	public function loginAdmin()
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

		$response['success'] = false;
		$response['msg'] = false;

		if(empty($this->_identity['loggedIn']))
		{
			$username = $this->input->post('username', true);
			$password = $this->input->post('password', true);
			$result = $this->UserAdminModel->verifyLogin($username,$password);

			if($result)
			{
				$this->session->set_userdata('loggedIn', true);
				$this->session->set_userdata('logged_as', 'admin');
				$this->session->set_userdata('userData', $result[0]);
//				$this->session->set_userdata('lang', $result[0]->lang);
//				$this->session->set_userdata('color', $result[0]->themeColor);
//				$this->session->set_userdata('layoutFormat', $result[0]->layoutFormat);
//				$this->session->set_userdata('postWriter', $result[0]->post_writer);


				$this->session->set_userdata('lang', 'spanish');
				$this->session->set_userdata('color', 'default.min');
				$this->session->set_userdata('layoutFormat', 'boxed');
				$this->session->set_userdata('postWriter', '');


				$plan_options = null;
				if(isset($this->_db_details->plan)){
					$plan_options = $this->ClientesPlansRelationModel->getOptions($this->_db_details->plan);
				}
				$this->session->set_userdata('_plan_options', $plan_options);
				$response['success'] = true;
			}else{
				$response['msg'] = $this->lang->line('admin_incorrect_details');
			}
		}else{
			$response['msg'] = $this->lang->line('admin_logged_in');
		}
		print_r(json_encode($response));
		exit;
	}


	public function logout()
	{
		$this->session->sess_destroy();
  		redirect('auth/login', 'refresh');
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
