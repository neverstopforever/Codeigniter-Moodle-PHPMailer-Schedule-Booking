<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//use Aws\S3\S3Client;
/**
 *@property AlumnoModel $AlumnoModel

 */
class Resources extends MY_Controller {

	private $user_id = null;

	public function __construct(){
		parent::__construct();

		$this->load->model('AlumnoModel');

		//$this->load->library('user_agent');

		$this->load->library('form_validation');
		if(!$this->session->userdata('loggedIn')){
			redirect('/auth/login/', 'refresh');
		}
		$this->user_id = $this->data['userData'][0]->Id;
	}
	
	public function index(){
		//$this->layouts->add_includes('js', 'app/js/resources/index.js');

		$this->layouts->view('resources/indexView', $this->data);
	}








	public function delete(){
		if($this->input->is_ajax_request()){
			$result = false;
			$student_id = (int)$this->input->post('student_id', true);
			if($student_id){
				$check_links = $this->AlumnoModel->getStudentLinks($student_id);
				if(isset($check_links[0]->count_link) && $check_links[0]->count_link >= 1) {
					$result = false;
				}else{
					$result = $this->AlumnoModel->deleteStudent($student_id);
				}

			}
			echo json_encode(array('success' => $result));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

}
