<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\S3\S3Client;
/**
 *@property CourseModel $CourseModel
 *@property AlumnoModel $AlumnoModel
 *@property AlumnoTabAdModel $AlumnoTabAdModel
 *@property FormasPagoModel $FormasPagoModel
 *@property AlumnosDocModel $AlumnosDocModel
 *@property DocumentModel $DocumentModel
 *@property AlumnosPrefHModel $AlumnosPrefHModel
 *@property MatriculatModel $MatriculatModel
 *@property ReciboModel $ReciboModel
 *@property LstInformesAlumnosModel $LstInformesAlumnosModel
 *@property AlumnosSeguiModel $AlumnosSeguiModel
 *@property AlumnosTagsModel $AlumnosTagsModel

 */
class Students extends MY_Controller {

	private $user_id = null;
	private $email1 = '';   // for edit form validation
	private $email2 = '';  // for edit form validation
	
	public function __construct(){
		parent::__construct();

		$this->load->model('CourseModel');
		$this->load->model('AlumnoModel');
		$this->load->model('AlumnoTabAdModel');
		$this->load->model('Variables2Model');
		$this->load->model('FormasPagoModel');
		$this->load->model('ClientModel');
		$this->load->model('AlumnosDocModel');
		$this->load->model('DocumentModel');
		$this->load->model('AlumnosPrefHModel');
		$this->load->model('MatriculatModel');
		$this->load->model('ReciboModel');
		$this->load->model('LstInformesAlumnosModel');
		$this->load->model('AlumnosSeguiModel');

		$this->load->library('user_agent');

		$this->load->library('form_validation');
		if(!$this->session->userdata('loggedIn')){
			redirect('/auth/login/', 'refresh');
		}
		$this->user_id = $this->data['userData'][0]->Id;
		$this->data['isOwner']=$this->data['userData'][0]->owner;
	}
	
	public function index(){
        $this->lang->load('quicktips', $this->data['lang']);
        $this->load->model('ErpTagsModel');
		$this->layouts->add_includes('css', 'assets/global/plugins/select2/select2.css');
		$this->layouts->add_includes('js', 'assets/global/plugins/select2/select2.js');
		$this->layouts->add_includes('js', 'app/js/students/index.js');
		$this->data['top_bar_data'] = $this->AlumnoModel->getAlumnoTopData();

		$this->data['tags'] =  $this->ErpTagsModel->getTags();
		$tags_group_by_tag_id = array();
		$tags_for_filter = array();
		if(!empty($this->data['tags'])) {
			foreach ($this->data['tags'] as $tags){
				$tags_group_by_tag_id[$tags->id] = $tags;
				$tags_for_filter[] = array('id' => $tags->id, 'text' => $tags->tag_name,
					'back_color' => $tags->hex_backcolor, 'text_color' => $tags->hex_forecolor);
			}
		}
		$this->data['tags_group_by_tag_id'] = $tags_group_by_tag_id;
		$this->data['tags_for_filter'] = $tags_for_filter;
		$this->layouts->view('students/indexView', $this->data);
	}

	public function getStudentData() {
		$lang = $this->session->userdata('lang');
		$data['page'] = 'Data Records';
		$field = $lang == 'english' ? 'sql_en' : 'sql_es';
		$date_format = $lang == 'english' ? 'Y/m/d' : 'd/m/Y';
		$start =$this->input->post('start',  true);
		$length =$this->input->post('length', true);
		$draw = $this->input->post('draw', true);
		$search =$this->input->post('search', true);
		$order = $this->input->post('order', true);
		$columns = $this->input->post('columns', true);
		$column = $order[0]['column'];
		$total_students = $this->AlumnoModel->getTotalCount();
		//$total_records = $total_students;

		$filter_tags = (object)array(
			'selected_state' => $this->input->post('selected_state', true),
			'tag_ids' => $this->input->post('tag_ids', true),
		);
		
		$student_data = $this->AlumnoModel->getStudensCustomAjax($start, $length, $draw, $search, $order, $columns, $filter_tags);

		$recordsTotal = (int)$student_data->rows;

		$response = array(
			"start"=>$start,
			"length"=>$length,
			"search"=>$search,
			"order"=>$order,
			"column"=>$column,
			"draw"=>$draw,
			"recordsFiltered"=>$recordsTotal,
			"recordsTotal"=>$recordsTotal,
			"data"=>$student_data->items,
			"table_total_rows"=> $total_students
		);
		echo json_encode($response); exit;
	}


	public function add(){
		$this->layouts
			->add_includes('css', 'assets/global/plugins/typeahead/typeahead.css')
			->add_includes('css', 'assets/global/plugins/typeahead/custom.css')
			->add_includes('js', 'assets/global/plugins/typeahead/handlebars.min.js')
			->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.js')
			->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.min.js')
			->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
			->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
			->add_includes('js', 'app/js/students/add.js');
		$this->data['add_edit'] = $this->lang->line('add');
		$cisess = $this->session->userdata('_cisess');
		$membership_type = $cisess['membership_type'];
		if($membership_type != 'FREE'){
			$this->data['customfields_fields'] = $this->get_customfields_data();
		}
		if($this->input->post()) {
			$post_data = $this->input->post(NULL, true);
		    $personalized_data = $this->get_personalized_data();
			$insert_personalized = array();
			if(!empty($personalized_data)){
				foreach($personalized_data as $personalized){
					if(isset($post_data[$personalized->name])){
						$insert_personalized[$personalized->name] =  $post_data[$personalized->name];
					}

				}
			}

			//$get_image = file_get_contents($_FILES['student_photo']['tmp_name']);
			$this->form_validation->set_rules('first_name', $this->lang->line('first_name'), 'trim|required');
			if(!empty($this->input->post('email1'))) {
				$this->form_validation->set_rules('email1', $this->lang->line('email1'), 'trim|is_unique[alumnos.Email]|is_unique[alumnos.Email2]');
			}
			if(!empty($this->input->post('email2'))) {
				if(empty($this->input->post('email1'))){
					$this->form_validation->set_rules('email1', $this->lang->line('email1'), 'trim|required|is_unique[alumnos.Email]|is_unique[alumnos.Email2]');
				}
				$this->form_validation->set_rules('email2', $this->lang->line('email2'), 'trim|required|is_unique[alumnos.Email]|is_unique[alumnos.Email2]');
			}
			if(!empty($this->data['customfields_fields'])) {
				foreach ($this->data['customfields_fields'] as $field) {
					if ($field['required'] && $field['field_type'] != 'checkbox') {
						$this->form_validation->set_rules('custom_fields[' . $field['id'] . ']', "<b>" . $field['field_name'] . "</b>", "trim|required");
					}
				}
			}
			$this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');
			if ($this->form_validation->run()) {
				if($this->Variables2Model->updateNumStudent()){
					$id = $this->Variables2Model->getNumStudent();
					$post_data['id'] = $id[0]->numalumno;
					if($id[0]->numalumno > 0) {
						$field_data = $this->input->post('custom_fields', true);
						if(!array_filter($field_data)){
							$post_data['custom_fields'] = '';
						}else{
							$post_data['custom_fields'] = json_encode($field_data);
						}
						//$post_data['photo'] = $get_image;
						$insert_data = $this->mackInsertData($post_data);
						$insert_data['FirstUpdate'] = date('Y-m-d');
						$insert_data['LastUpdate'] = date('Y-m-d');
						$insert_personalized['ccodcli'] = $post_data['id'];
						$this->AlumnoTabAdModel->insertFormData($insert_personalized);
						if ($this->AlumnoModel->insertStudent($insert_data)) {
							redirect('students/edit/' . $post_data['id']);
						}
					}
				}

			}
		}

		$this->data['personalized_fields'] = $this->get_personalized_data();
//		$this->data['templates'] = $this->LstPlantillaModel->getByCatId(6);
		$this->data['student'] = array();
		$this->data['company_name'] = false;
		$this->data['documents'] = array();
		$this->data['availability'] = $this->getAvailability();
		$this->data['paymontMethods'] = $this->getPaymontMethods();
		if(!empty($this->form_validation->error_array())) {
			$this->data['_errors'] = $this->form_validation->error_array();
		}
		$this->layouts->view('students/addEditView', $this->data);
	}

public function get_customfields_data() {
       
        $type = 'students';
        $custom_fields = $this->AlumnoModel->getFieldsList($type);
        if(count($custom_fields) > 0){
                
            return $custom_fields;

        }else{
            return false;
        }
       
    }
	public function edit($id = null){
		if($id) {
			$this->layouts
							->add_includes('css', 'assets/global/plugins/typeahead/typeahead.css')
							->add_includes('css', 'assets/global/plugins/typeahead/custom.css')

							->add_includes('css', 'assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css')
							->add_includes('css', 'assets/global/plugins/select2/css/select2.min.css')
							->add_includes('js', 'assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js')
							->add_includes('js', 'assets/global/plugins/select2/js/select2.full.min.js')

							->add_includes('js', 'assets/global/plugins/typeahead/handlebars.min.js')
							->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.js')
							->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.min.js')
							->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
							->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
							->add_includes('js', 'app/js/students/add.js');
			$cisess = $this->session->userdata('_cisess');
			$membership_type = $cisess['membership_type'];
			$this->data['add_edit'] = $this->lang->line('edit');
			$this->data['student'] = $this->AlumnoModel->getStudentById($id);
			$this->data['student']->custom_fields = json_decode($this->data['student']->custom_fields );
			if($membership_type != 'FREE'){
				$this->data['customfields_fields'] = $this->get_customfields_data();
			}
//			printr($this->data['student']); exit;
			if(!empty($this->data['student'])) {
				$this->email1 =  $this->data['student']->email1;
				$this->email2 =  $this->data['student']->email2;
				if ($this->input->post()) {
					$post_data = $this->input->post(NULL, true);
					if(!empty($this->input->post('email1')) && $this->email1 != $this->input->post('email1')){
						$this->form_validation->set_rules('email1', $this->lang->line('email1'), 'trim|required|is_unique[alumnos.Email]|is_unique[alumnos.Email2]');
					}
					if(!empty($this->input->post('email2'))) {
						if ($this->email2 != $this->input->post('email2')) {
							if( empty($this->input->post('email1'))){
								$this->form_validation->set_rules('email1', $this->lang->line('email1'), 'trim|required|is_unique[alumnos.Email]|is_unique[alumnos.Email2]');
							}
							$this->form_validation->set_rules('email2', $this->lang->line('email2'), 'trim|required|is_unique[alumnos.Email]|is_unique[alumnos.Email2]');
						}
					}

					$this->form_validation->set_rules('first_name', $this->lang->line('first_name'), 'trim|required');
					$this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');
					if(!empty($this->data['customfields_fields'])) {
						foreach ($this->data['customfields_fields'] as $field) {
							if ($field['required'] && $field['field_type'] != 'checkbox') {
								$this->form_validation->set_rules('custom_fields[' . $field['id'] . ']', "<b>" . $field['field_name'] . "</b>", "trim|required");
							}
						}
					}
					if ($this->form_validation->run()) {
						$post_data['id'] = $id;
						$field_data = $this->input->post('custom_fields', true);
						if(!array_filter($field_data)){
							$post_data['custom_fields'] = '';
						}else{
							$post_data['custom_fields'] = json_encode($field_data);
						}
//						$post_data['photo'] = file_get_contents();
						$personalized_data = $this->get_personalized_data();
						$personalized_exist_data = $this->AlumnoTabAdModel->getBystudentId($id);
						$insert_personalized = array();
						if(!empty($personalized_data)){
							foreach($personalized_data as $personalized){
								if(isset($post_data[$personalized->name])){
									$insert_personalized[$personalized->name] =  $post_data[$personalized->name];
								}

							}
						}
						if(!empty($personalized_exist_data)){
							$this->AlumnoTabAdModel->updateFormData($insert_personalized, $id);
						}else{
							$insert_personalized['ccodcli'] = $id;
							$this->AlumnoTabAdModel->insertFormData($insert_personalized);
						}

						$update_data = $this->mackInsertData($post_data);
						$update_data['LastUpdate'] = date('Y-m-d');
						if($this->AlumnoModel->updateStudent($id,$update_data)){
							redirect('students');
						}
					}
					$this->data['student'] = $this->AlumnoModel->getStudentById($id);
				}
				$this->data['paymontMethods'] = $this->getPaymontMethods();
				$this->data['invoices_company_data'] = $this->ClientModel->getInvoicesCompany();
				$this->data['documents'] = $this->AlumnosDocModel->getByStudentId($id);
				$this->data['company_name'] = false;
				$this->data['availability'] = $this->getAvailability($id);
				$foloow_up_count = $this->AlumnosSeguiModel->getFollowUpCount($id);
				$this->data['follow_up_count'] = isset($foloow_up_count->f_count) ? $foloow_up_count->f_count : 0;
				$this->data['availability_times'] = $this->getAvailabilityTimaes();

				foreach($this->data['invoices_company_data'] as $company){
					if($company->Id == $this->data['student']->invoices_company){
						$this->data['company_name'] = $company->name;
					}
				}
				if(!empty($this->form_validation->error_array())) {
					$this->data['_errors'] = $this->form_validation->error_array();
				}
				$this->data['personalized_fields'] = $this->get_personalized_data($id);
				if($id) {
					$this->load->model('AlumnosTagsModel');
					$this->load->model('ErpTagsModel');
					$this->data['student_tags'] = $this->AlumnosTagsModel->getTags($id);
					$this->data['student_tag_ids'] = array();
					if (!empty($this->data['student_tags'])) {
						foreach ($this->data['student_tags'] as $tag) {
							$this->data['student_tag_ids'][] = $tag->tag_id;
						}
					}
					//$where_not_in = "SELECT id_tag FROM presupuesto_tags WHERE numpresupuesto ='".$client_id."'";
					$this->data['tags'] = $this->ErpTagsModel->getTagsForfilterBytable();
				}

//				$this->data['templates'] = $this->LstPlantillaModel->getByCatId(6);
				$this->layouts->view('students/addEditView', $this->data);
			}else{
				redirect('students');
			}
		}else{
			redirect('students');
		}
	}

	private function mackInsertData($post_data){
		$insert_data = array(
			'custom_fields' => $post_data['custom_fields'],
			'ccodcli' => isset($post_data['id']) ? $post_data['id'] : '',
			'snombre' => isset($post_data["first_name"]) ? $post_data["first_name"] : '',
			'sapellidos' => isset($post_data["sur_name"]) ? $post_data["sur_name"] : '' ,
			'cnomcli' => isset($post_data["first_name"]) ? $post_data["first_name"].' '. (isset($post_data["sur_name"]) ? $post_data["sur_name"] : '') : '' ,
			'cdomicilio' => isset($post_data["address"]) ? $post_data["address"] : '',
			'cpobcli' => isset($post_data["city"]) ? $post_data["city"] : '' ,
			'cptlcli' => isset($post_data["postal_code"]) ? $post_data["postal_code"] : '',
			'ccodprov' => isset($post_data["provincia"]) ? $post_data["provincia"] : '' ,
			'cnaccli' => isset($post_data["country"]) ? $post_data["country"] : '',
			'LugarNacimiento' => isset($post_data["place_birth"]) ? $post_data["place_birth"] : '',
			'tipodoc' => isset($post_data["doc_type"]) ? $post_data["doc_type"] : '',
			'cdnicif' => isset($post_data["dni"]) ? $post_data["dni"] : '',
			'idsexo' => isset($post_data["sex"]) ? $post_data["sex"] : '',
			'COBSCLI' => isset($post_data["social_security"]) ? $post_data["social_security"] : '',
			'nacimiento' => (isset($post_data["birthday"]) && strtotime($post_data['birthday']) < strtotime(date("Y-m-d")) ) ? date('Y-m-d', strtotime($post_data["birthday"])) : null,
			'ctfo1cli' => isset($post_data["phone1"]) ? $post_data["phone1"] : '',
			'ctfo2cli' => isset($post_data["phone2"]) ? $post_data["phone2"] : '',
			'movil' => isset($post_data["mobile"]) ? $post_data["mobile"] : '',
			'email' => isset($post_data["email1"]) ? $post_data["email1"] : '',
			'email2' => isset($post_data["email2"]) ? $post_data["email2"] : '',
         // Tutor 1 data
			'tut1_nombre' => isset($post_data["tutor1_firstname"]) ? $post_data["tutor1_firstname"].' '.(isset($post_data["tutor1_firstsurname"])  ? $post_data["tutor1_firstsurname"] : '' ) : '',
			'tut1_snombre' => isset($post_data["tutor1_firstname"]) ? $post_data["tutor1_firstname"] : '',
			'tut1_idparentesco' => isset($post_data["tutor1_relationship"]) ? $post_data["tutor1_relationship"] : '',
			'tut1_sapellido1' => isset($post_data["tutor1_firstsurname"]) ? $post_data["tutor1_firstsurname"] : '',
			'tut1_sapellido2' => isset($post_data["tutor1_lastsurname"]) ? $post_data["tutor1_lastsurname"] : '',
			'tut1_direccion' => isset($post_data["tutor1_address"]) ? $post_data["tutor1_address"] : '',
			'tut1_poblacion' => isset($post_data["tutor1_city"]) ? $post_data["tutor1_city"] : '',
			'tut1_cp' => isset($post_data["tutor1_postal_code"]) ? $post_data["tutor1_postal_code"] : '',
			'tut1_provincia' => isset($post_data["tutor1_provincia"]) ? $post_data["tutor1_provincia"] : '',
			'tut1_pais' => isset($post_data["tutor1_country"]) ? $post_data["tutor1_country"] : '',
			'tut1_dni' => isset($post_data["tutor1_dni"]) ? $post_data["tutor1_dni"] : '',
			'tut1_tfno1' => isset($post_data["tutor1_phone1"]) ? $post_data["tutor1_phone1"] : '',
			'tut1_tfno2' => isset($post_data["tutor1_phone2"]) ? $post_data["tutor1_phone2"] : '',
			'tut1_movil' => isset($post_data["tutor1_mobile"]) ? $post_data["tutor1_mobile"] : '',
			'tut1_email1' => isset($post_data["tutor1_email1"]) ? $post_data["tutor1_email1"] : '',
			'tut1_email2' => isset($post_data["tutor1_email2"]) ? $post_data["tutor1_email2"] : '',
			'tut1_tipodoc' => isset($post_data["tutor1_doc_type"]) ? $post_data["tutor1_doc_type"] : '',
			// Tutor 2 data
			'tut2_nombre' => isset($post_data["tutor2_firstname"]) ? $post_data["tutor2_firstname"].' '. (isset($post_data["tutor2_firstsurname"]) ? $post_data["tutor2_firstsurname"] : '') : '',
			'tut2_snombre' => isset($post_data["tutor2_firstname"]) ? $post_data["tutor2_firstname"] : '',
			'tut2_idparentesco' => isset($post_data["tutor2_relationship"]) ? $post_data["tutor2_relationship"] : '',
			'tut2_sapellido1' => isset($post_data["tutor2_firstsurname"]) ? $post_data["tutor2_firstsurname"] : '',
			'tut2_sapellido2' => isset($post_data["tutor2_lastsurname"]) ? $post_data["tutor2_lastsurname"] : '',
			'tut2_direccion' => isset($post_data["tutor2_address"]) ? $post_data["tutor2_address"] : '',
			'tut2_poblacion' => isset($post_data["tutor2_city"]) ? $post_data["tutor2_city"] : '',
			'tut2_cp' => isset($post_data["tutor2_postal_code"]) ? $post_data["tutor2_postal_code"] : '',
			'tut2_provincia' => isset($post_data["tutor2_provincia"]) ? $post_data["tutor2_provincia"] : '',
			'tut2_pais' => isset($post_data["tutor2_country"]) ? $post_data["tutor2_country"] : '',
			'tut2_dni' => isset($post_data["tutor2_dni"]) ? $post_data["tutor2_dni"] : '',
			'tut2_tipodoc' => isset($post_data["tutor2_doc_type"]) ? $post_data["tutor2_doc_type"] : '',
			'tut2_tfno1' => isset($post_data["tutor2_phone1"]) ? $post_data["tutor2_phone1"] : '',
			'tut2_tfno2' => isset($post_data["tutor2_phone2"]) ? $post_data["tutor2_phone2"] : '',
			'tut2_movil' => isset($post_data["tutor2_mobile"]) ? $post_data["tutor2_mobile"] : '',
			'tut2_email1' => isset($post_data["tutor2_email1"]) ? $post_data["tutor2_email1"] : '',
			'tut2_email2' => isset($post_data["tutor2_email2"]) ? $post_data["tutor2_email2"] : '',
		);
		return $insert_data;
	}

	private function getAvailabilityTimaes($off = true){
		//$start_time = $this->session->userData('start_time');
		//$end_time = $this->session->userData('end_time');
		$start_end_time = $this->Variables2Model->getStartEndtime();

		$start_time = substr($start_end_time->start_time, 0, -2).':'.substr($start_end_time->start_time, -2);
		$end_time = substr($start_end_time->end_time, 0, -2).':'.substr($start_end_time->end_time, -2);
        $time_data = array();
		$period = new DatePeriod(
			new DateTime($start_time),
			new DateInterval('PT1H'),
			new DateTime($end_time)
		);
		foreach ($period as $date) {
			$time_data[] = trim($date->format("H:i\n"));
		}
		array_push($time_data, $end_time);
		if($off) {
			$time_data['-1'] = ' ';
		}
		return $time_data;
	}


	private function get_personalized_data($id = null) {
		$result_data = array();
		$personalized_data = array();
		if($id) {
			$personalized_data = (array)$this->AlumnoTabAdModel->getBystudentId($id);
		}

		$personalized_fields = $this->AlumnoTabAdModel->getFieldList();

		if(count($personalized_fields) > 1){
			foreach($personalized_fields as $fields) {
				if (!$fields->primary_key){
					switch ($fields->type) {
						case "longtext":
							$type = "textarea";
							break;
						case "date":
							$type = "date";
							break;
						default:
							$type = "text";
					}
					$result_data[] = (object)array(
						'name' => $fields->name,
						'type' => $type,
						'value' => isset($personalized_data[$fields->name]) ? $personalized_data[$fields->name] : ''

					);
				}
			}
		}
		return $result_data;
	}

	public function saveBillingData(){
		if($this->input->is_ajax_request()){
			$student_id = (int)$this->input->post('student_id', true);
			$form_data = $this->input->post('form_data', true);
			$invoices_company_id = $this->input->post('invoices_company_id', true);
			$new_form_data = array();
			$result_data['success'] = false;
			if(!empty($form_data)){
				foreach($form_data as $f_data){
					$new_form_data[$f_data['name']] = $f_data['value'];
				}
			}

			if($student_id ) {

               $update_data = array(
				   				'IdFP' => isset($new_form_data['id_payment_method']) ? $new_form_data['id_payment_method'] : '',
				   				'ccodpago' => isset($new_form_data['payment_description']) ? $new_form_data['payment_description'] : '',
				   				'dto' => isset($new_form_data['special_discount']) ? $new_form_data['special_discount'] : '',
				   				'precio_hora' => isset($new_form_data['hour_rate']) ? $new_form_data['hour_rate'] : '0.000',
				   				'DniTitular' => isset($new_form_data['fiscal_code']) ? $new_form_data['fiscal_code'] : '',
				   				'CNBRBCO' => isset($new_form_data['account_holder']) ? $new_form_data['account_holder'] : '',
				   				'nacionalidad_titular' => isset($new_form_data['nationality']) ? $new_form_data['nationality'] : '',
				   				'titular_email`' => isset($new_form_data['headline_email']) ? $new_form_data['headline_email'] : '',
				   				'IBAN`' => isset($new_form_data['bank_account']) ? $new_form_data['bank_account'] : '',
				   				'firmado_sepa`' => isset($new_form_data['signed_sepa']) ? $new_form_data['signed_sepa'] : '',
				   				'FacturarA`' => $invoices_company_id,
			   );

				if($this->AlumnoModel->updateStudentBilling($student_id, $update_data)){
					$result_data['success'] = true;
				};
			}
			echo json_encode(array('result' => $result_data));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function unassignCompany(){
		if($this->input->is_ajax_request()){
			$student_id = (int)$this->input->post('student_id', true);
			$result = false;
			if($student_id) {
				if($this->AlumnoModel->updateStudentBilling($student_id, array('FacturarA' => ''))){
					$result = true;
				};

			}

			echo json_encode(array('success' => $result));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}


	private function getPaymontMethods(){
		return array(
			(object)array(
						'id' => 0,
						'descripcion' => $this->lang->line('cash')
					),(object)array(
						'id' => 1,
						'descripcion' => $this->lang->line('credit_card')
					),(object)array(
						'id' => 2,
						'descripcion' => $this->lang->line('bank_debit')
					),(object)array(
						'id' => 3,
						'descripcion' => $this->lang->line('transfer')
					),(object)array(
						'id' => 4,
						'descripcion' => $this->lang->line('bank_check')
					),(object)array(
						'id' => 5,
						'descripcion' => $this->lang->line('funded')
					),
		);
	}

	//Documents
	public function getDocuments(){
		if($this->input->is_ajax_request()){
            $student_id = (int)$this->input->post('student_id', true);
			$documents = array();
			if($student_id) {
				$documents = $this->AlumnosDocModel->getByStudentId($student_id);

			}

			echo json_encode(array('data' => $documents));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function changeDocumentVisible(){
		if($this->input->is_ajax_request()){
            $student_id = (int)$this->input->post('student_id', true);
            $document_id = (int)$this->input->post('document_id', true);
			$visible = (int)$this->input->post('visible', true);
			if($student_id) {
				$_visible = $visible == '1' ? 1 : 0;
				 $this->AlumnosDocModel->update('alumnos_doc', array('visible' => $_visible), array('idalumno' => $student_id, 'id' => $document_id));

			}

			echo json_encode(array('success' => true));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function downloadDoc($student_id = null, $fid=null){
		if(!empty($fid) && !empty($student_id)){
			$result = (array)$this->DocumentModel->student_download($student_id,$fid);
			$docname=str_replace(" ","_",$result['documento']);
			header ("Content-Disposition: attachment; filename=".$docname." ");
			header ("Content-Type: application/octet-stream");
			header ("Content-Length: ".$result['blob']);
			echo $result['docblob'];
			exit();
		}
	}

   //Availability

	public function saveAvailability(){
		if($this->input->is_ajax_request()){
			$post_data = $this->input->post(NULL, true);
			$result = false;
			$student_data = isset($post_data['student_id']) ? $this->AlumnoModel->getStudentById($post_data['student_id']) : null;

			if(!empty($student_data)){
				$student_id = $post_data['student_id'];
				$st_availability = $this->AlumnosPrefHModel->getAvailability($student_id);
				if(!empty($st_availability)){
					$update_data = $this->makeAvailabilityInsertData($post_data);
					$result = $this->AlumnosPrefHModel->updateHoursData($student_id, $update_data);
				}else{
					$insert_data = $this->makeAvailabilityInsertData($post_data);
					$insert_data['ccodcli'] = $student_id;
					$result = $this->AlumnosPrefHModel->insertHoursData($insert_data);
				}
			}

			echo json_encode(array('success' => $result));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	private function getAvailability($id = null){
		$availability = $id ? $this->AlumnosPrefHModel->getAvailability($id) : array();
		$availability_array = array();
		if(empty($availability)) {
			$availability = array(
				'monday_moorning_start' => '00:00:00',
				'monday_moorning_end' => '00:00:00',
				'monday_afternoon_start' => '00:00:00',
				'monday_afternoon_end' => '00:00:00',

				'thuesday_moorning_start' => '00:00:00',
				'thuesday_moorning_end' => '00:00:00',
				'thuesday_afternoon_start' => '00:00:00',
				'thuesday_afternoon_end' => '00:00:00',

				'wednesday_moorning_start' => '00:00:00',
				'wednesday_moorning_end' => '00:00:00',
				'wednesday_afternoon_start' => '00:00:00',
				'wednesday_afternoon_end' => '00:00:00',

				'thursday_moorning_start' => '00:00:00',
				'thursday_moorning_end' => '00:00:00',
				'thursday_afternoon_start' => '00:00:00',
				'thursday_afternoon_end' => '00:00:00',

				'friday_moorning_start' => '00:00:00',
				'friday_moorning_end' => '00:00:00',
				'friday_afternoon_start' => '00:00:00',
				'friday_afternoon_end' => '00:00:00',

				'saturday_moorning_start' => '00:00:00',
				'saturday_moorning_end' => '00:00:00',
				'saturday_afternoon_start' => '00:00:00',
				'saturday_afternoon_end' => '00:00:00',

				'sunday_moorning_start' => '00:00:00',
				'sunday_moorning_end' => '00:00:00',
				'sunday_afternoon_start' => '00:00:00',
				'sunday_afternoon_end' => '00:00:00',
			);

		}
		foreach ($availability as $key => $value) {
			$array_key = explode('_', $key);
			$availability_array[$array_key[0]][$key] = $value;
		}

		return $availability_array;

	}


	private function makeAvailabilityInsertData($post_data){
		$time_data = $this->getAvailabilityTimaes(false);
		$result_post_data = array();
		foreach($post_data as $key=> $time_key){
			$result_post_data[$key] = isset($time_data[$time_key]) ? $time_data[$time_key] : '00:00:00';

		}

		return array(

			'lu_inicio_m' => isset($result_post_data['monday_moorning_start']) ? $result_post_data['monday_moorning_start'] : '00:00:00',
			'lu_fin_m' => isset($result_post_data['monday_moorning_end']) && ((int)date('H', strtotime($result_post_data['monday_moorning_end'])) > (int)date('H', strtotime($result_post_data['monday_moorning_start']))) ? $result_post_data['monday_moorning_end'] : '00:00:00',
			'lu_inicio_t' => isset($result_post_data['monday_afternoon_start']) ? $result_post_data['monday_afternoon_start'] : '00:00:00',
			'lu_fin_t' => isset($result_post_data['monday_afternoon_end']) && ((int)date('H', strtotime($result_post_data['monday_afternoon_end'])) > (int)date('H', strtotime($result_post_data['monday_afternoon_start']))) ? $result_post_data['monday_afternoon_end'] : '00:00:00',

			'ma_inicio_m' => isset($result_post_data['thuesday_moorning_start']) ? $result_post_data['thuesday_moorning_start'] : '00:00:00',
			'ma_fin_m' => isset($result_post_data['thuesday_moorning_end']) && ((int)date('H', strtotime($result_post_data['thuesday_moorning_end'])) > (int)date('H', strtotime($result_post_data['thuesday_moorning_start']))) ? $result_post_data['thuesday_moorning_end'] : '00:00:00',
			'ma_inicio_t' => isset($result_post_data['thuesday_afternoon_start']) ? $result_post_data['thuesday_afternoon_start'] : '00:00:00',
			'ma_fin_t' => isset($result_post_data['thuesday_afternoon_end']) && ((int)date('H', strtotime($result_post_data['thuesday_afternoon_end'])) > (int)date('H', strtotime($result_post_data['thuesday_afternoon_start']))) ? $result_post_data['thuesday_afternoon_end'] : '00:00:00',

			'Mi_inicio_m' => isset($result_post_data['wednesday_moorning_start']) ? $result_post_data['wednesday_moorning_start'] : '00:00:00',
			'Mi_fin_m' => isset($result_post_data['wednesday_moorning_end']) && ((int)date('H', strtotime($result_post_data['wednesday_moorning_end'])) > (int)date('H', strtotime($result_post_data['wednesday_moorning_start']))) ? $result_post_data['wednesday_moorning_end'] : '00:00:00',
			'Mi_inicio_t' => isset($result_post_data['wednesday_afternoon_start']) ? $result_post_data['wednesday_afternoon_start'] : '00:00:00',
			'Mi_fin_t' => isset($result_post_data['wednesday_afternoon_end']) && ((int)date('H', strtotime($result_post_data['wednesday_afternoon_end'])) > (int)date('H', strtotime($result_post_data['wednesday_afternoon_start']))) ? $result_post_data['wednesday_afternoon_end'] : '00:00:00',

			'Ju_inicio_m' => isset($result_post_data['thursday_moorning_start']) ? $result_post_data['thursday_moorning_start'] : '00:00:00',
			'Ju_fin_m' => isset($result_post_data['thursday_moorning_end']) && ((int)date('H', strtotime($result_post_data['thursday_moorning_end'])) > (int)date('H', strtotime($result_post_data['thursday_moorning_start']))) ? $result_post_data['thursday_moorning_end'] : '00:00:00',
			'Ju_inicio_t' => isset($result_post_data['thursday_afternoon_start']) ? $result_post_data['thursday_afternoon_start'] : '00:00:00',
			'Ju_fin_t' => isset($result_post_data['thursday_afternoon_end']) && ((int)date('H', strtotime($result_post_data['thursday_afternoon_end'])) > (int)date('H', strtotime($result_post_data['thursday_afternoon_start']))) ? $result_post_data['thursday_afternoon_end'] : '00:00:00',

			'vi_inicio_m' => isset($result_post_data['friday_moorning_start']) ? $result_post_data['friday_moorning_start'] : '00:00:00',
			'vi_fin_m' => isset($result_post_data['friday_moorning_end']) && ((int)date('H', strtotime($result_post_data['friday_moorning_end'])) > (int)date('H', strtotime($result_post_data['friday_moorning_start']))) ? $result_post_data['friday_moorning_end'] : '00:00:00',
			'vi_inicio_t' => isset($result_post_data['friday_afternoon_start']) ? $result_post_data['friday_afternoon_start'] : '00:00:00',
			'vi_fin_t' => isset($result_post_data['friday_afternoon_end']) && ((int)date('H', strtotime($result_post_data['friday_afternoon_end'])) > (int)date('H', strtotime($result_post_data['friday_afternoon_start']))) ? $result_post_data['friday_afternoon_end'] : '00:00:00',

			'sa_inicio_m' => isset($result_post_data['saturday_moorning_start']) ? $result_post_data['saturday_moorning_start'] : '00:00:00',
			'sa_fin_m' => isset($result_post_data['saturday_moorning_end']) && ((int)date('H', strtotime($result_post_data['saturday_moorning_end'])) > (int)date('H', strtotime($result_post_data['saturday_moorning_start']))) ? $result_post_data['saturday_moorning_end'] : '00:00:00',
			'sa_inicio_t' => isset($result_post_data['saturday_afternoon_start']) ? $result_post_data['saturday_afternoon_start'] : '00:00:00',
			'sa_fin_t' => isset($result_post_data['saturday_afternoon_end']) && ((int)date('H', strtotime($result_post_data['saturday_afternoon_end'])) > (int)date('H', strtotime($result_post_data['saturday_afternoon_start']))) ? $result_post_data['saturday_afternoon_end'] : '00:00:00',

			'do_inicio_m' => isset($result_post_data['sunday_moorning_start']) ? $result_post_data['sunday_moorning_start'] : '00:00:00',
			'do_fin_m' => isset($result_post_data['sunday_moorning_end']) && ((int)date('H', strtotime($result_post_data['sunday_moorning_end'])) > (int)date('H', strtotime($result_post_data['sunday_moorning_start']))) ? $result_post_data['sunday_moorning_end'] : '00:00:00',
			'do_inicio_t' => isset($result_post_data['sunday_afternoon_start']) ? $result_post_data['sunday_afternoon_start'] : '00:00:00',
			'do_fin_t' => isset($result_post_data['sunday_afternoon_end']) && ((int)date('H', strtotime($result_post_data['sunday_afternoon_end'])) > (int)date('H', strtotime($result_post_data['sunday_afternoon_start']))) ? $result_post_data['sunday_afternoon_end'] : '00:00:00',
		);
	}

    // Reports

    public function getEnrollments(){
		if($this->input->is_ajax_request()){
			$student_id = (int)$this->input->post('student_id', true);
             $enrollments = array();
			if($student_id){
				$enrollments = $this->MatriculatModel->getEnrollments($student_id);
			}

			echo json_encode(array('data' => $enrollments));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function getAccounting(){
		if($this->input->is_ajax_request()){
			$student_id = (int)$this->input->post('student_id', true);
			$accounting = array();
			if($student_id){
				$accounting = $this->ReciboModel->getAccounting($student_id);
			}

			echo json_encode(array('data' => $accounting));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function getReportsList(){
		if($this->input->is_ajax_request()){
			$reports_list = $this->LstInformesAlumnosModel->getlist();

			echo json_encode(array('data' => $reports_list));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}

	}

	public function getReports(){
		if($this->input->is_ajax_request()){
			$student_id = (int)$this->input->post('student_id', true);
			$report_id = (int)$this->input->post('report_id', true);
			$reports = array();
			if($student_id && $report_id){
				$reports = $this->LstInformesAlumnosModel->report($report_id, $student_id);
			}

			echo json_encode(array('data' => $reports));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	// Follow Up  start

	public function getFollowUp(){
		if($this->input->is_ajax_request()){
			$student_id = (int)$this->input->post('student_id', true);
			$follow_up = array();
			if($student_id){
				$follow_up = $this->AlumnosSeguiModel->getByStudentId($student_id);
			}

			echo json_encode(array('data' => $follow_up));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function saveFollowUp(){
		if($this->input->is_ajax_request()){
			$result = false;
			$last_id = false;

			$student_id = (int)$this->input->post('student_id', true);
			$follow_up_id = (int)$this->input->post('follow_up_id', true);
			$title = $this->input->post('title', true);
			$date = $this->validateDate($this->input->post('date', true)) ? $this->input->post('date', true) : date('Y-m-d') ;

			$comment = $this->input->post('comment', true);
			if($student_id && $title){
				if($follow_up_id){
					$follow_up_data = $this->AlumnosSeguiModel->getFolloUpById($follow_up_id, $student_id);
					if(!empty($follow_up_data)){
						$update_data = array(
							  'fecha' => $date,
							  'titulo' => $title,
							  'comentarios' => $comment,
							  'id_user' => $this->user_id,
						);
						$result = $this->AlumnosSeguiModel->updateFollowUp($follow_up_id, $update_data);
					}
				}else{
                    $insert_data = array(
						'ccodcli' => $student_id,
						'fecha' => $date,
						'titulo' => $title,
						'comentarios' => $comment,
						'id_user' => $this->user_id,
					);
					$last_id = $this->AlumnosSeguiModel->insertFollowUp($insert_data);
					if($last_id){
						$result = true;
					}
				}
			}

			echo json_encode(array('success' => $result, 'id' => $last_id, 'date' => $date));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function deleteFollowUp(){
		if($this->input->is_ajax_request()){
			$result = false;
			$follow_up_id = (int)$this->input->post('follow_up_id', true);
			if($follow_up_id){
				$result = $this->AlumnosSeguiModel->deleteFollowUp($follow_up_id);
			}

			echo json_encode(array('success' => $result));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	private function validateDate($date){

		$d = DateTime::createFromFormat('Y-m-d', $date);
		return $d && $d->format('Y-m-d') == $date;
	}

	// Follow Up  end


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
	
	// tagging
	public function update_tags(){
		if($this->input->is_ajax_request()){
			$this->load->model('AlumnosTagsModel');
			$this->load->model('ErpTagsModel');
			$student_id = $this->input->post('student_id', true);
			$tags_ids = $this->input->post('value', true);
			$tags_ids = trim($tags_ids, ',');
			$result = false;
			$tags_ids_array = array();
			if($student_id){
				$tags_ids_array = explode(',', $tags_ids);
				$this->AlumnosTagsModel->deleteAllItems($student_id);

				if (!empty($tags_ids_array)) {
					$checking_ids = $this->ErpTagsModel->getNotExistTags($tags_ids_array, $student_id, 'alumnos_tags', 'ccodcli'); // alumnos_tags is table name  and ccodcli is foreign key column name
					$insert_data = array();
					if (!empty($checking_ids)) {
						foreach ($checking_ids as $tag) {
							if (empty($tag->current_table_tag_id) && empty($tag->nummatricula)) {
								$insert_data[] = array('ccodcli' => $student_id, 'id_tag' => $tag->tag_id);
							}
						}
					}
					$result = $this->AlumnosTagsModel->insertBatch($insert_data);
				}

			}
			echo json_encode(array('result' => $result, 'tag_ids' => $tags_ids_array));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
	

}
