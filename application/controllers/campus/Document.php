<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends MY_Campus_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('DocumentModel');
		$this->load->library('form_validation');
		//better check this logged in session in main construct
		$this->lang->load('campus',$this->data['lang']);
		if(!$this->session->userdata('campus_user')){
			redirect('campus/auth/login/', 'refresh');
		}
		$this->layouts->add_includes('js', 'app/js/campus/document/main.js');
	}
	
	public function index(){
		$this->layouts
			          ->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
			          ->add_includes('js', 'assets/global/scripts/app.min.js')
			          ->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
					  ->add_includes('js', 'app/js/campus/document/index.js');
		//checkrole and call model either teacher or student
		$userData = (array)$this->session->userdata('campus_user');
		$result = $this->DocumentModel->get_profesor_document($userData['INDICE']);
		$this->data['json_document'] = json_encode($result);
		$this->data['teacherid'] = $userData['INDICE'];
		$this->layouts->view('campus/documents/index', $this->data, $this->layout);
	}
	
	public function download($fid=null){
		if(!empty($fid)){
			$userData = (array)$this->session->userdata('campus_user');
			$result = (array)$this->DocumentModel->profesor_download($userData['INDICE'],$fid);
			$docname=str_replace(" ","_",$result['documento']);
			header ("Content-Disposition: attachment; filename=".$docname." ");
			header ("Content-Type: application/octet-stream");
			header ("Content-Length: ".$result['blob']);
			echo $result['docblob'];
			exit();
		}
	}
}