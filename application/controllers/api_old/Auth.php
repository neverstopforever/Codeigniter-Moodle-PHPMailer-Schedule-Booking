<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *@property magaModel $magaModel
 *@property UsuarioModel $UsuarioModel
 *@property ClientesAkaudModel $ClientesAkaudModel
 */


class Auth extends MY_Controller {


    public function __construct()
	{
            parent::__construct();
            // Your own constructor code
		    $this->load->model('UsuarioModel');
		    $this->load->model('ClientesAkaudModel');
    }

	public function login_get()
	{
		if($this->input->cookie('_cisess', TRUE) || $this->session->has_userdata("_cisess")){
			redirect('/auth/login2', 'refresh');
		}

		if(empty($this->_identity['loggedIn']))
		{

//			$this->load->view('loginView');
			$this->load->view('auth/login1View', $this->data);
		}
		else
		{
  			redirect('/home/', 'refresh');
		}
	}
	public function login2_get()
	{
		if(!$this->input->cookie('_cisess', TRUE) && !$this->session->has_userdata("_cisess")){
			redirect('/auth/login', 'refresh');
		}

		if(empty($this->_identity['loggedIn']))
		{
			$this->load->view('auth/login2View', $this->data);
		}
		else
		{
			redirect('/home/', 'refresh');
		}
	}

	public function login2_post()
	{
		$response['success'] = false;
		$response['msg'] = false;
		if(empty($this->_identity['loggedIn']))
		{
			$username=$this->post('username');
			$password=$this->post('password');
			$result=$this->magaModel->varifyLogin('usuarios',array('usuario'=>$username,'claveacceso'=>$password));
			if($result)
			{
				$this->session->set_userdata('loggedIn', true);
				$this->session->set_userdata('userData', $result);
				$this->session->set_userdata('lang', $result[0]->lang);
				$this->session->set_userdata('color', $result[0]->themeColor);
				$this->session->set_userdata('layoutFormat', $result[0]->layoutFormat);
				$this->session->set_userdata('postWriter', $result[0]->post_writer);

				$response['success'] = true;
			}else{
				$response['msg'] = $this->lang->line('login2_incorrect_details');
			}
		}else{
			$response['msg'] = $this->lang->line('login2_logged_in');
		}
		print_r(json_encode($response));
		exit;
	}

	public function login_post()
	{
		if(empty($this->_identity['loggedIn']))
		{
			$key=$this->post('key');
			$username=$this->post('username');
			$password=$this->post('password');
			$result=$this->magaModel->varifyLogin('usuarios',array('usuario'=>$username,'claveacceso'=>$password));
			if($result)
			{
				$this->session->set_userdata('loggedIn', true);
				$this->session->set_userdata('userData', $result);
				$this->session->set_userdata('lang', $result[0]->lang);
				$this->session->set_userdata('color', $result[0]->themeColor);
				$this->session->set_userdata('layoutFormat', $result[0]->layoutFormat);
				$this->session->set_userdata('postWriter', $result[0]->post_writer);

				echo 'true';
			}
			else
			{
				echo 'false';
			}
		}
		else
		{
			return 'false';
		}
	}


	public function key_code_post()
	{
		$response['success'] = false;
		$response['msg'] = false;

		if(empty($this->_identity['loggedIn']))
		{
			$key = $this->post('key');
			$res = $this->ClientesAkaudModel->getByKey($key);

			if(isset($res[0])){
				if($res[0]->active == 0){
					$response['msg'] = $this->lang->line('key_code_inactive');
				}else if($res[0]->start_date > date('Y-m-d') ||  $res[0]->end_date < date('Y-m-d')){
					$response['msg'] = $this->lang->line('key_code_dates_msg');
				}else{
					$db_details = (array)$res[0];
					$db_details_json_base64_encode = base64_encode(json_encode($db_details));
					setcookie('_cisess', $db_details_json_base64_encode,time() + (86400 * 30), "/"); //30 days
					$this->session->set_userdata('_cisess', $db_details);
					$response['success'] = true;
				}
			}else{
				$response['success'] = false;
			}
		} else {
			$response['success'] = false;
		}
		print_r(json_encode($response));
		exit;
	}

	public function logout_get()
	{
		$this->session->sess_destroy();
  		redirect('/auth/login/', 'refresh');
	}

	public function profileFoto_get() {
		$userData = $this->session->userdata('userData');
		$USUARIO = $userData[0]->USUARIO;
		$details = $this->UsuarioModel->getProfileFoto($USUARIO);
		$data = array();
		$data['USUARIO'] = $USUARIO;
		$data['imageUrl'] = 'data:image/jpeg;base64,'.base64_encode($details[0]->foto);
		print_r(json_encode($data));
	}

	public function checkConnection_get(){
		print_r(json_encode(array('success'=>true)));
		exit;
	}
}
