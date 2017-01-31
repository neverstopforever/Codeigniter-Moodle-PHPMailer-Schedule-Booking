<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *@property magaModel $magaModel
 *@property UsuarioModel $UsuarioModel
 */
class User extends MY_Controller {

    public function __construct()
       {
            parent::__construct();
            // Your own constructor code
		    $this->load->model('UsuarioModel');
    }
    public function account_get()
	{
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			$data=array();
			$data['page']='account';
			$this->load->view('accountView', $data);
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}
	}
	public function profile_get()
	{

		
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			$data=array();
			$data['page']='profile';
			$this->load->view('profileView', $data);
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}
	}
	public function help_get()
	{
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			$data=array();
			$data['page']='help';
			$this->load->view('helpView', $data);
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}
	}

	public function faqs_get()
	{
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			$data=array();
			$data['page']='faqs';
			$this->load->view('faqsView', $data);
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}
	}
	public function contact_get()
	{
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			$data=array();
			$data['page']='Contact';
			$this->load->view('contactView', $data);
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}
	}

	public function users_get()
	{
		$userData=$this->session->userdata('userData');
		$usuario=$userData[0]->USUARIO;
		$details = $this->UsuarioModel->getUsers($usuario);
		print_r(json_encode($details));
	}
	public function profileInfo_get(){

		$userData=$this->session->userdata('userData');
		$usuario=$userData[0]->USUARIO;
		$CLAVEACCESO=md5($userData[0]->CLAVEACCESO);
		$details = $this->UsuarioModel->getProfileInfo($usuario);
		$details[0]->chabi = $CLAVEACCESO;
    	print_r(json_encode($details[0]));
	}
	
	
	public function setLayoutFormat_post()
	{
		$userData=$this->session->userdata('userData');
		$usuario=$userData[0]->USUARIO;
		$layoutFormat=$this->post('layoutFormat');
		$details=$this->magaModel->update('usuarios',array('layoutFormat'=>$layoutFormat),array('usuario'=>$usuario));
		$this->session->set_userdata('layoutFormat', $layoutFormat);
		print_r($details);
	}
	public function setThemeColor_post()
	{
		$userData=$this->session->userdata('userData');
		$usuario=$userData[0]->USUARIO;
		$themeColor=$this->post('themeColor');
		$details=$this->magaModel->update('usuarios',array('themeColor'=>$themeColor),array('usuario'=>$usuario));
		$this->session->set_userdata('color', $themeColor);
		print_r($details);
	}
	public function setLang_post()
	{
		$userData=$this->session->userdata('userData');
		$usuario=$userData[0]->USUARIO;
		$lang=$this->post('lang');
		$details=$this->magaModel->update('usuarios',array('lang'=>$lang),array('usuario'=>$usuario));
		$this->session->set_userdata('lang', $lang);
		print_r($details);
	}
	public function profileFotoUpload_post(){
		$userData=$this->session->userdata('userData');
		$usuario=$userData[0]->USUARIO;
		$get_image = file_get_contents($_FILES['file']['tmp_name']);
		$details=$this->magaModel->update('usuarios',array('foto'=>$get_image),array('usuario'=>$usuario));
		print_r($details);
	}
	public function profileInfo_post()
	{
		$userData=$this->session->userdata('userData');
		$usuario=$userData[0]->USUARIO;
		$phone = $this->post('phone');
		$email = $this->post('email');
		$about = $this->post('about');
		$detail = $this->magaModel->update('usuarios',array('Telefono'=>$phone,'about'=>$about,'email'=>$email),array('usuario'=>$usuario));
		print_r($detail);
	}
	public function updatePassword_post()
	{
		$userData=$this->session->userdata('userData');
		$usuario=$userData[0]->USUARIO;
		$password = $this->post('password');
		$detail = $this->magaModel->update('usuarios',array('CLAVEACCESO'=>$password),array('usuario'=>$usuario));
		print_r($detail);	
	}

}
