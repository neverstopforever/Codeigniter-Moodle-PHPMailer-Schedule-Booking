<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property TaskModel $TaskModel
 * @property InboxModel $InboxModel
 * @property MensajeModel $MensajeModel
 */
class Home extends MY_controller {

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
//		$this->layout = "home";
		$this->lang->load('contactos_form',$this->data['lang']);
//		$this->output->enable_profiler(false);
		$this->load->helper(array('url', 'text'));
		$this->load->model('TaskModel');
		$this->load->model('InboxModel');
		$this->load->model('MensajeModel');

	 	if(!$this->session->userdata('loggedIn')){
			redirect('/auth/login/', 'refresh');
		}
		$this->layouts->add_includes('js', 'app/js/home/main.js');
	}
	
	public function index(){
  		redirect('/dashboard/', 'refresh');
	}
	
	public function dashboard(){
		$this->load->model('ErpFileSizesModel');
        $user_data = $this->session->userdata('userData');
		$user_id = $user_data[0]->Id;
		$this->data['page']='Dashboard';
		$this->data['leadcount'] =  $this->db->count_all("presupuestot");
//		$this->db->where('estado', 1);
		$this->data['matriculatcount'] =  $this->db->count_all("matriculat");
//		$this->db->where('estado', 0);
		$this->data['cursocount'] =  $this->db->count_all("curso");
		$this->data['alumnoscount'] =  $this->db->count_all("alumnos");
		$this->data['task'] = $this->TaskModel->dashboard_task();
		$this->data['inbox'] = $this->MensajeModel->getUserInbox($user_id);
		$file_space = $this->ErpFileSizesModel->getTotalSize();
		$this->data['file_space'] = $file_space->total;
		$this->data['limit_file_space'] =$this->_db_details->space_limit;
//		$this->load->view('home/dashboard',$this->data);
		$this->layouts->view('home/dashboard',$this->data);
	}
}
