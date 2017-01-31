<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Campus_Controller {

	 public function __construct(){
		parent::__construct();
		$this->output->enable_profiler(false);
		$this->load->helper(array('url', 'text'));
		$this->data['user_role'] = $this->session->userdata('user_role');
	 	$this->lang->load('campus',$this->data['lang']);
		if(!$this->session->userdata('campus_user')){
			redirect('campus/auth/login/', 'refresh');
		}
		$this->layouts->add_includes('js', 'app/js/campus/home/main.js');
	}
	
	public function index(){
		if($this->data['user_role'] == 1){
			redirect('/campus/teacher-dashboard/', 'refresh');
		}elseif($this->data['user_role'] == 2){
			redirect('/campus/student-dashboard/', 'refresh');
		}else{
			redirect('/campus/dashboard/', 'refresh');
		}

	}
	
	public function dashboard(){
		$this->layouts->add_includes('js', 'app/js/campus/home/dashboard.js');
		$this->data['page']='Dashboard';
		$this->layouts->view('campus/homeView',$this->data, $this->layout);
	}
}
