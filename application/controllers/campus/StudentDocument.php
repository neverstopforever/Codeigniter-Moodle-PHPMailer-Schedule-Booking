<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StudentDocument extends MY_Campus_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('DocumentModel');
		$this->load->library('form_validation');
		//better check this logged in session in main construct
		$this->lang->load('campus',$this->data['lang']);
		if(!$this->session->userdata('campus_user') || ($this->session->userdata('campus_user') && $this->data['campus_user_role'] != 2)){ //no user or not student
			redirect('campus/auth/login/', 'refresh');
		}
		$this->data['campus_user'] = (array)$this->session->userdata('campus_user');
		$this->data['user_id'] = $this->data['campus_user']['CCODCLI'];
		$this->layouts->add_includes('js', 'app/js/campus/document/main.js');
	}
	
	public function index(){
		$this->layouts
			          ->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
			          ->add_includes('js', 'assets/global/scripts/app.min.js')
			          ->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
					  ->add_includes('js', 'app/js/campus/student_document/index.js');
		//checkrole and call model either teacher or student
		$result = $this->DocumentModel->get_student_document($this->data['user_id']);
		$this->data['json_document'] = json_encode($result);
		$this->data['student_id'] = $this->data['user_id'];
		$this->layouts->view('campus/student_documents/index', $this->data, $this->layout);
	}
	
	public function download($fid=null){
		if(!empty($fid)){
			$result = (array)$this->DocumentModel->profesor_download($this->data['user_id'],$fid);
			$docname=str_replace(" ","_",$result['documento']);
			header ("Content-Disposition: attachment; filename=".$docname." ");
			header ("Content-Type: application/octet-stream");
			header ("Content-Length: ".$result['blob']);
			echo $result['docblob'];
			exit();
		}
	}
}