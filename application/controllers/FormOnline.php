<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FormOnline extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		if(empty($this->_identity['loggedIn'])){
			redirect('/auth/login/', 'refresh');
		}
		$this->load->model('ClientesPortalesModel');
        $this->lang->load('quicktips', $this->data['lang']);
        $this->load->model('ContactosTabAdModel');
		$this->load->model('PresupuestosTabAdModel');
		$this->load->model('CursoModel');
		$this->load->model('MedioModel');
		$this->load->model('ApiPortalesModel');
		$this->load->model('PresupuestoTagsModel');
		$this->layouts->add_includes('js', 'app/js/form_online/main.js');
	}
	
	public function index(){
		$this->layouts->add_includes('js', 'app/js/form_online/index.js')
			->add_includes('css', 'assets/global/plugins/select2/select2.css')
			->add_includes('js', 'assets/global/plugins/select2/select2.js');
		$this->data['page']='form_online';
		if(isset($this->_db_details->idcliente)){
			$this->data['sources'] = $this->ApiPortalesModel->getSources();
		}else{
			$this->data['sources'] = null;
		}

		$this->layouts->view('form_online/index', $this->data, $this->layout);
	}

	public function get_form_fields(){

		$response['success'] = false;
		$response['errors'] = array();
		$response['html_fields'] = '';
		$this->data['tags'] = array();
		$this->data['courses'] = array();
		if($this->input->is_ajax_request()){
			$api_key = $this->input->post('api_key', true);
			$form_type = $this->input->post('form_type', true);
			if(!empty($api_key)){
				if(isset($this->_db_details->idcliente)){
//					$check_api_key = $this->ClientesPortalesModel->getCheckApiKey($this->_db_details->idcliente, $api_key);
//					if($check_api_key){ //api key correct
						$this->data['api_key'] = $api_key;
						$select_fields = array(
							'nombre'=> $this->lang->line('first_name'),
							'apellidos'=> $this->lang->line('sur_name'),
							'email'=> $this->lang->line('email'),
							'domicilio'=> $this->lang->line('address'),
							'cp'=> $this->lang->line('postal_code'),
							'problacion'=> $this->lang->line('city'),
							'provincia'=> $this->lang->line('province'),
							'telefono'=> $this->lang->line('phone'),
							'Movil'=> $this->lang->line('mobile'),
							'comentarios'=> $this->lang->line('comentarios')
						);

						$this->data['medios'] = $this->MedioModel->getAll();

						$contactos_fields = array();
						$presupuestos_fields = array();
						if($form_type == 'leads'){
							$presupuestos_tab_ad_fields = $this->PresupuestosTabAdModel->get_fields();
							foreach($presupuestos_tab_ad_fields as $k=>$field){
								if($k != 0){
									$presupuestos_fields[$field] = 'pt-'.$field;
								}
							}
							$contactos_tab_ad_fields = $this->ContactosTabAdModel->get_fields();
							foreach($contactos_tab_ad_fields as $k=>$field){
								if($k != 0){
									$contactos_fields[$field] = 'co-'.$field;
								}
							}
							$this->data['courses'] = $this->CursoModel->getForSelect();
							$this->data['tags'] = $this->PresupuestoTagsModel->getAllTags();
						}elseif($form_type == 'contactos'){
							$contactos_tab_ad_fields = $this->ContactosTabAdModel->get_fields();
							foreach($contactos_tab_ad_fields as $k=>$field){
								if($k != 0){
									$contactos_fields[$field] = 'co-'.$field;
								}
							}
						}
						foreach($presupuestos_fields as $k=>$presupuestos_field){
							$select_fields[$presupuestos_field] = ucwords($k);
						}
						foreach($contactos_fields as $k=>$contactos_field){
							$select_fields[$contactos_field] = ucwords($k);
						}

						$this->data['select_fields'] = $select_fields;
						$response['html_fields'] = $this->load->view('form_online/partials/html_fields',$this->data, true);
						$response['success'] = true;
//					}else{
//						$response['errors'][] = $this->lang->line('db_err_msg');
//					}
				}else{
					$response['errors'][] = $this->lang->line('db_err_msg');
				}
			}else{
				$response['errors'][] = $this->lang->line('db_err_msg');
			}
		}

		print_r(json_encode($response));
		exit;
	}
	public function getAllCourses(){
		if($this->input->is_ajax_request()){
			$courses = $this->CursoModel->getForSelect();
			echo json_encode(array('result'=>$courses)); exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
	public function getAllTags(){
		if($this->input->is_ajax_request()){
			$prospect_tags = $this->PresupuestoTagsModel->getAllTags();
			echo json_encode(array('tags' =>$prospect_tags)); exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function check_api_key(){
		$response['success'] = false;
		$response['errors'] = array();
		if($this->input->is_ajax_request()) {
			$api_key = $this->input->post('api_key', true);
			if (!empty($api_key)) {
				if (isset($this->_db_details->idcliente)) {
					$check_api_key = $this->ClientesPortalesModel->getCheckApiKey(
						$this->_db_details->idcliente,
						$api_key
					);
					if ($check_api_key) { //api key correct
						$response['success'] = true;
					}else{
						$response['errors'][] = $this->lang->line('db_err_msg');
					}
				}
			}
		}
		print_r(json_encode($response));
		exit;
	}

	public function generate_page(){
		$response['success'] = false;
		$response['errors'] = array();
		$response['generated_page_link'] = '';
		if($this->input->is_ajax_request()) {
			$generated_form = $this->input->post('generated_form', false);
			$this->data['generated_form'] = $generated_form;

			$form_html = $this->load->view('form_online/partials/generated_form', $this->data, true);

			$user_id = isset($this->data['userData'][0]->Id) ? $this->data['userData'][0]->Id : '';
			$idcliente = isset($this->_db_details->idcliente) ? $this->_db_details->idcliente : '';
			$unique_html_name = md5(uniqid(rand(), true)) . '-' . $idcliente . '-'. $user_id . '.html';
			$webforms_dir = FCPATH . "app/webforms";
			if (!is_dir($webforms_dir)) {
				mkdir($webforms_dir, 0777, true);
			}
			$html_file = FCPATH . "app/webforms/".$unique_html_name;
			touch($html_file);
			chmod($html_file, 0777);
			$myfile = fopen($html_file, "w");
			if(fwrite($myfile, $form_html) === false){
				$response['errors'][] = $this->lang->line('db_err_msg');
			}else{
				$response['success'] = true;
				$response['generated_page_link'] = base_url() . "app/webforms/".$unique_html_name;
			}
			fclose($myfile);

		}
		print_r(json_encode($response));
		exit;
	}

}