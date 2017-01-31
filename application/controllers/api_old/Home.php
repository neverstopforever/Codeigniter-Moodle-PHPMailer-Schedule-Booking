<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'Base_controller.php';
/**
 * @property TaskModel $TaskModel
 * @property InboxModel $InboxModel
 */
class Home extends Base_controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 public function __construct(){
		parent::__construct();
		$this->lang->load('contactos_form',$this->data['lang']);
//		$this->output->enable_profiler(false);
		$this->load->helper(array('url', 'text'));
		$this->load->model('TaskModel');
		$this->load->model('InboxModel');
	 	if(!$this->session->userdata('loggedIn')){
			redirect('/auth/login/', 'refresh');
		}
	}
	
	public function index(){
  		redirect('/dashboard/', 'refresh');
	}
	
	public function dashboard(){
		$data['page']='Dashboard';
		$data['leadcount'] =  $this->db->count_all("presupuestot");
		$this->db->where('estado', 1);
		$data['matriculatcount'] =  $this->db->count_all("matriculat");
		$this->db->where('estado', 0);
		$data['cursocount'] =  $this->db->count_all("curso");
		$data['alumnoscount'] =  $this->db->count_all("alumnos");
		$data['task'] = $this->TaskModel->dashboard_task();
		$data['inbox'] = $this->InboxModel->dashboard_inbox();
		$this->load->view('dashboard',$data);
	}
}
