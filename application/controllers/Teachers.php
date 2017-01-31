<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\S3\S3Client;
/**
 *@property CourseModel $CourseModel
 *@property ProfesorModel $ProfesorModel
 *@property ProfesoresDocModel $ProfesoresDocModel
 *@property LstInformesProfesorModel $LstInformesProfesorModel
 *@property ProfesoresTabAdModel $ProfesoresTabAdModel
 */
class Teachers extends MY_Controller {

	private $email1 = ''; // for edit form validation
	private $email2 = ''; // for edit form validation
	public function __construct(){
		parent::__construct();

		$this->load->model('CourseModel');
		$this->load->model('ProfesorModel');
		$this->load->model('Variables2Model');
		$this->load->model('ProfesoresDocModel');
		$this->load->model('LstInformesProfesorModel');
		$this->load->model('LstPlantillaModel');
		$this->load->model('ProfesoresTabAdModel');
		$this->load->model('EventModel');
		$this->load->library('user_agent');

		$this->load->library('form_validation');
		$this->data['isOwner']=$this->data['userData'][0]->owner;
		if(!$this->session->userdata('loggedIn')){
			redirect('/auth/login/', 'refresh');
		}
	}
	
	public function index(){
        $this->lang->load('quicktips', $this->data['lang']);
        $this->layouts->add_includes('js', 'app/js/teachers/index.js');
		$this->data['teachers'] = $this->ProfesorModel->getTeachers();
		$this->layouts->view('teachers/indexView', $this->data);
	}

	public function add(){
		$this->layouts
			->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
			->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
			->add_includes('js', 'app/js/teachers/add_edit.js')
			->add_includes('js', 'app/js/teachers/reports.js');
			$this->data['add_edit'] = $this->lang->line('add');
		if($this->input->post()) {
			$post_data = $this->input->post(NULL, true);
			//$get_image = file_get_contents($_FILES['teacher_photo']['tmp_name']);
			$this->form_validation->set_rules('first_name', $this->lang->line('first_name'), 'trim|required');
			$this->form_validation->set_rules('email1', $this->lang->line('email'), 'trim|required|is_unique[profesor.Email]|is_unique[profesor.Email2]');
			if(!empty($this->input->post('email2'))) {
				$this->form_validation->set_rules('email2', $this->lang->line('email'), 'trim|required|is_unique[profesor.Email]|is_unique[profesor.Email2]');
			}
			$this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');

			if ($this->form_validation->run()) {
				if($this->Variables2Model->updateNumProfesor()){
					$id = $this->Variables2Model->getNumProfesor();
					$post_data['id'] = $id[0]->numprofesor;
					if($post_data['id'] > 0) {
						$post_data['custom_fields'] = json_encode($this->input->post('custom_fields', true));
						//$post_data['photo'] = $get_image;
						$insert_data = $this->mackInsertData($post_data);
						$fields = array();
						$form_data = array();
						$fields_list = $this->ProfesoresTabAdModel->getFieldList();
						foreach ($fields_list as $field) {
							$fields[$field->name] = $field->name;
						}
						if (!empty($post_data) && !empty($fields)) {
							foreach ($post_data as $k => $data) {
								if (isset($fields[$k ])) {
									$key = $fields[$k ];
									$form_data[$key] = $data;
								}
							}
						}
						$form_data['Indice'] = $post_data['id'];
						$this->ProfesoresTabAdModel->insertFormData($form_data);
						if ($this->ProfesorModel->insertProfesor($insert_data)) {
							redirect('teachers/edit/' . $post_data['id']);
						}
					}
				}

			}
		}
		$cisess = $this->session->userdata('_cisess');
		$membership_type = $cisess['membership_type'];
		if($membership_type != 'FREE'){
			$this->data['customfields_fields'] = $this->get_customfields_data();
		}
		$this->data['personalized_fields'] = $this->ProfesoresTabAdModel->getFieldList();
		if(($key = array_search('Indice', $this->data['personalized_fields'])) !== false) {
			unset($this->data['personalized_fields'][$key]);
		}
		$this->data['personalized_data'] = array();
		$this->data['templates'] = $this->LstPlantillaModel->getByCatId(6);
		$this->data['calendar_tags'] = $this->ProfesorModel->getTeacherTags();
		$this->data['courses'] = array();

		$this->data['_errors'] = null;
		if ($this->session->userdata('errs') !== FALSE) {
			$this->data['_errors'] = $this->session->userdata('errs');
			$this->session->unset_userdata('errs');
		}

		if(!empty($this->form_validation->error_array())) {
			$this->data['_errors'] = $this->form_validation->error_array();
		}
		$this->layouts->view('teachers/addEditView', $this->data);
	}

	public function edit($id = null){
		if($id) {
			$this->layouts
				->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
				->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
			    ->add_includes('js', 'app/js/teachers/add_edit.js')
			    ->add_includes('js', 'app/js/teachers/reports.js');
				$this->data['add_edit'] = $this->lang->line('edit');
			$this->data['data'] = $this->ProfesorModel->getTeacherById($id);
            if(!empty($this->data['data'])) {
				$this->email1 = $this->data['data']->email1;
				$this->email2 = $this->data['data']->email2;
				if ($this->input->post()) {
					$post_data = $this->input->post(NULL, true);
					if($this->email1 != $this->input->post('email1')){
						$this->form_validation->set_rules('email1', $this->lang->line('email'), 'trim|required|is_unique[profesor.Email]|is_unique[profesor.Email2]');
					}
					if(empty($this->email1) && empty($this->input->post('email1'))){
						$this->form_validation->set_rules('email1', $this->lang->line('email'), 'trim|required|is_unique[profesor.Email]|is_unique[profesor.Email2]');
					}
					if(!empty($this->input->post('email2'))) {
						if ($this->email2 != $this->input->post('email2')) {
							$this->form_validation->set_rules('email2', $this->lang->line('email'), 'trim|required|is_unique[profesor.Email]|is_unique[profesor.Email2]');
						}
					}
					$this->form_validation->set_rules('first_name', $this->lang->line('first_name'), 'trim|required');
					$this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');
					if ($this->form_validation->run()) {
						$post_data['id'] = $id;
						$post_data['custom_fields'] = json_encode($this->input->post('custom_fields', true));
//						$post_data['photo'] = file_get_contents();
						$update_data = $this->mackUpdateData($post_data);
						//vardump($update_data);exit;
						if($this->ProfesorModel->updateProfesor($id,$update_data)){
							$fields = array();
							$form_data = array();
							$fields_list = $this->ProfesoresTabAdModel->getFieldList();
							foreach ($fields_list as $field) {
								$fields[$field->name] = $field->name;
							}
							if (!empty($post_data) && !empty($fields)) {
								foreach ($post_data as $k => $data) {
									if (isset($fields[$k ])) {
										$key = $fields[$k ];
										$form_data[$key] = $data;
									}
								}
							}
							$this->ProfesoresTabAdModel->updateFormData($form_data, $id);

							redirect('teachers');
						};

					}
					//$this->data['data'] = $this->ProfesorModel->getTeacherById($id);
				}
				$cisess = $this->session->userdata('_cisess');
				$membership_type = $cisess['membership_type'];
				if($membership_type != 'FREE'){
					$this->data['data']->custom_fields = json_decode($this->data['data']->custom_fields);
					$this->data['customfields_fields'] = $this->get_customfields_data();
				}
				$this->data['personalized_data'] = $this->ProfesoresTabAdModel->getByTeacherId($id);
				if(isset($this->data['personalized_data']->Indice)) {
					unset($this->data['personalized_data']->Indice);
				}
				$this->data['personalized_fields'] = $this->ProfesoresTabAdModel->getFieldList();
				if(($key = array_search('Indice', $this->data['personalized_fields'])) !== false) {
					unset($this->data['personalized_fields'][$key]);
				}
				$this->data['calendar_tags'] = $this->ProfesorModel->getTeacherTags();
				$this->data['courses'] = $this->ProfesorModel->getCourses($id);
				$this->data['templates'] = $this->LstPlantillaModel->getByCatId(6);

				$this->data['_errors'] = null;
				if ($this->session->userdata('errs') !== FALSE) {
					$this->data['_errors'] = $this->session->userdata('errs');
					$this->session->unset_userdata('errs');
				}
				if(!empty($this->form_validation->error_array())) {
					$this->data['_errors'] = $this->form_validation->error_array();
				}
				$this->data['event'] = $this->EventModel->getevent('','',$id,'','');
				$this->layouts->view('teachers/addEditView', $this->data);
			}else{
				redirect('teachers');
			}
		}else{
			redirect('teachers/add');
		}
	}

public function get_customfields_data() {
       
        $type = 'teachers';
        $custom_fields = $this->ProfesorModel->getFieldsList($type);
        if(count($custom_fields) > 0){
                
            return $custom_fields;

        }else{
            return false;
        }
       
    }
	private function mackInsertData($post_data){
		$insert_data = array(
			'custom_fields' => $post_data['custom_fields'],
			'INDICE' => $post_data['id'],
			'snombre' => $post_data['first_name'],
			'sapellidos' => $post_data['sur_name'],
			'nombre' => $post_data['first_name'].' '.$post_data['sur_name'],
			'POBLACION' => $post_data['city'],
			'PROVINCIA' => $post_data['provincia'],
			'DISTRITO' => $post_data['postal_code'],
			'DNI' => $post_data['passport'],
			'TFO1' => $post_data['phone1'],
			'TFO2' => $post_data['phone2'],
			'movil' => $post_data['mobile'],
			'skypeprofesor' => $post_data['skype'],
			'FirstUpdate' => date('Y-m-d'),
			'LastUpdate' => date('Y-m-d'),
			'activo' => $post_data['active'] == '1' ? 1 : 0,
			'Email' => $post_data['email1'],
			'Email2' => $post_data['email2'],
			//'Foto' => $post_data['photo'],
			'numss' => $post_data['social_security'],
			'nacionalidad' => $post_data['nacionality'],
			'nacimiento' => empty($post_data['birth_date']) ? null : date('Y-m-d', strtotime($post_data['birth_date'])),
		);
		return $insert_data;
	}

	private function mackUpdateData($post_data){
		$insert_data = array(
			'custom_fields' => $post_data['custom_fields'],
			'snombre' => $post_data['first_name'],
			'sapellidos' => $post_data['sur_name'],
			'nombre' => $post_data['first_name'].' '.$post_data['sur_name'],
			'POBLACION' => $post_data['city'],
			'PROVINCIA' => $post_data['provincia'],
			'DISTRITO' => $post_data['postal_code'],
			'DNI' => $post_data['passport'],
			'TFO1' => $post_data['phone1'],
			'TFO2' => $post_data['phone2'],
			'movil' => $post_data['mobile'],
			'skypeprofesor' => $post_data['skype'],
			'LastUpdate' => date('Y-m-d'),
			'activo' => $post_data['active'] == '1' ? 1 : 0,
			'Email' => $post_data['email1'],
			'Email2' => $post_data['email2'],
			//'Foto' => $post_data['photo'],
			'numss' => $post_data['social_security'],
			'nacionalidad' => $post_data['nacionality'],
			'nacimiento' => empty($post_data['birth_date']) ? null : date('Y-m-d', strtotime($post_data['birth_date'])),
		);
		return $insert_data;
	}


//Courses

	public function getNotExistCourses(){
		if($this->input->is_ajax_request()) {
			$id = $this->input->post('id', true);
			$exist_ids = $this->ProfesorModel->getExistCourses($id);
			$exist_data = array();
			if(!empty($exist_ids)){
				foreach($exist_ids as $exist){
					$exist_data[] = $exist->id;
				}
			}
			$courses = $this->ProfesorModel->getNotExistCourses($exist_data);
			echo json_encode(array('data' => $courses));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function saveCoursesData(){
		if($this->input->is_ajax_request()){
			$data = array(
				'success' => false,
				'error' => ''
			);
			$teacher_id = $this->input->post('teacher_id', true);
			$course_ids = $this->input->post('course_ids', true);
			$check_id = $teacher_id ? $this->ProfesorModel->getTeacherById($teacher_id) : null;
			if(!empty($check_id) && !empty($course_ids)) {
				$checked_course_ids = $this->CourseModel->getCourseIds($course_ids);
				if (!empty($checked_course_ids)) {
					foreach ($checked_course_ids as $course_id) {
						$insert_data[] = array('Indice' => $teacher_id, 'codcurso' => $course_id->codigo);
					}

					if ($this->ProfesorModel->insertCourses($insert_data)) {
						$data['success'] = true;
						$data['insert_data'] = $checked_course_ids;
					} else {
						$data['success'] = 'Insert doues not success!';
					}
				}
			}
			echo json_encode($data);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function deleteCourse(){
		if($this->input->is_ajax_request()){
			$data = array(
				'success' => false,
				'error' => ''
			);
			$teacher_id = $this->input->post('teacher_id', true);
			$course_id = $this->input->post('course_id', true);
			$check_id = $teacher_id ? $this->ProfesorModel->getTeacherById($teacher_id) : null;
			if(!empty($check_id)){
				if($this->ProfesorModel->deleteCourse(array('Indice' => $teacher_id, 'codcurso' => $course_id))) {
					$data['success'] = true;
				}
			}
			echo json_encode($data);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function deleteTeacher(){
		if($this->input->is_ajax_request()){
			$data = array(
				'success' => false,
				'error' => ''
			);
			$teacher_id = $this->input->post('teacher_id', true);
			$exist_teacher_link = $this->ProfesorModel->existTeacherLink($teacher_id);
			if(isset($exist_teacher_link[0]->count_link) && $exist_teacher_link[0]->count_link >= 1){
				$data['success'] = false;
			}else{
				if($this->ProfesorModel->deleteTeacher($teacher_id)){
					$this->ProfesoresTabAdModel->deleteTeacher($teacher_id);
					$data['success'] = true;
				}
			}

			echo json_encode($data);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

 //Documents

	public function getDocuments(){
		if($this->input->is_ajax_request()){
			$data = array(
				'success' => false,
				'error' => ''
			);
			$teacher_id = $this->input->post('teacher_id', true);
			$check_id = $teacher_id ? $this->ProfesorModel->getTeacherById($teacher_id) : null;
			if(!empty($check_id)){
				$amazon = $this->config->item('amazon');
				$aws_bucket = $amazon['bucket'];
				$documents = $this->ProfesoresDocModel->getDocuments($teacher_id);
				if(!empty($documents)){
					foreach($documents as $key=>&$document){
						$document->aws_bucket = $aws_bucket;
						$document->aws_key = isset(explode($aws_bucket."/", $document->doclink)[1]) ? explode($aws_bucket."/", $document->doclink)[1] : null ;
					}
				}
				$data['documents'] = $documents;
				$data['success'] = true;
			}
			echo json_encode($data);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	// Reports

	public function getReportCotegories(){
		if($this->input->post()) {
			$result = $this->LstInformesProfesorModel->getlist();
			echo json_encode($result);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
	public function getReports(){
		if($this->input->post()) {
			$id = $this->input->post('id', true);
			$teacher_id = $this->input->post('teacher_id', true);
			$data['data'] = $this->LstInformesProfesorModel->report($id, $teacher_id);
			$data['status'] = true;
			echo json_encode($data);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
	public function printTemplate() {

		/*$view = $this->load->view('teachers/printTemplate', $this->data, true);
		echo json_encode(array('html' => $view));exit;*/
		$errors = array();
		$errors[] = $this->lang->line('db_err_msg');
		$formData = $this->input->post(NULL, true);
		if (isset($formData["templateId"]) && $formData["templateId"] > 0) {
			$result = $this->LstPlantillaModel->getById($formData["templateId"]);
			if(isset($result[0]) && !empty($result[0])){
				$result = $result[0];
				$filename = isset($result->DocAsociado) ? str_replace(" ", "-", $result->DocAsociado) : rand(). '.docx';
				$fullpath = 'crm/downloads/' . $filename;

				if($result->aws_link){
					$file = file_get_contents($result->aws_link);
				}else{
					$file = $result->documento;
				}
				file_put_contents($fullpath, $file);
				chmod($fullpath, 0777);
							$companyDataFields = (array)$this->ProfesorModel->getTeacherDataFields($formData['teacherId']);

							$PHPWord = new \PhpOffice\PhpWord\PhpWord();
							try{
								$document = $PHPWord->loadTemplate($fullpath);
								foreach ($companyDataFields as $fk=>$fv) {
									$document->setValue('{'.$fk.'}', $fv);
								}

								$document->saveAs($fullpath);
								chmod($fullpath, 0777);

								//aws s3
								$amazon = $this->config->item('amazon');
								$client = new S3Client(array(
									'version' => 'latest',
									'credentials' => array(
										'key'       => $amazon['AWSAccessKeyId'],
										'secret'    => $amazon['AWSSecretKey'],
									),
									'region' => $amazon['region'],
									'client_defaults' => ['verify' => false]
								));


								$unique_name = md5(uniqid(rand(), true)) . '-' . $filename;
								$key = $this->_db_details->idcliente .'/LMS/temp/templates/'.$formData["templateId"].'/'. $unique_name;

								try{
									$res = $client->putObject(array(
										'Bucket' =>  $amazon['bucket'],
										'Key' => $key,
										'SourceFile' => $fullpath,
										'ACL' => 'public-read',
										'ContentType' => 'text/plain'
									));
									if(isset($res['ObjectURL'])){
										unlink($fullpath);
										redirect($res['ObjectURL']);
									}else{

									}
								}catch(\Aws\S3\Exception\S3Exception $e){
									$errors[] = $e->getMessage();
								}
								//aws s3 end

							}catch(\PhpOffice\PhpWord\Exception\Exception $er){
								$errors[] = $er->getMessage();
							}
			}else{
				//err message
			}
		}else{
			//err message
		}
		if(!empty($errors) && isset($fullpath)){
			unlink($fullpath);
		}
		$this->session->set_userdata('errs', $errors);
//		$this->session->set_flashdata('errors', $errors );
		redirect($this->agent->referrer());
	}

	public function printTemplate_old(){
		$errors = array();
		$errors[] = $this->lang->line('db_err_msg');
		$form_data = $this->input->post();
		if (isset($form_data["template_id"]) && $form_data["template_id"] > 0) {
			$result = $this->LstPlantillaModel->getById($form_data["template_id"]);
			if (isset($result[0]) && !empty($result[0])) {
				$result = $result[0];
				$filename = isset($result->DocAsociado) ? str_replace(" ", "-", $result->DocAsociado) : rand() . '.docx';
				$filename =  'test.doc';//str_replace(".doc", ".docx", $filename);
				$fullpath = 'crm/downloads/' . $filename;
				if ($result->aws_link) {
					$file = file_get_contents($result->aws_link);
				} else {
					$file = $result->documento;
				}
				file_put_contents($fullpath, $file);
				//chmod($fullpath, 0777);
				/*$dir_path = './crm/downloads/teachers';
				$this->deleteDirectory($dir_path);
				if (!is_dir($dir_path)) {
					mkdir($dir_path);
				}
				chmod($dir_path, 0777);
				$fullpath = $dir_path . '/'.$filename;

				if ($result->aws_link) {
					$file = file_get_contents($result->aws_link);
				} else {
					$file = $result->documento;
				}
				file_put_contents($fullpath, $file);
				chmod($fullpath, 0777);*/
				$PHPWord = new \PhpOffice\PhpWord\PhpWord();
				try{
					$teacherDataFields = (array)$this->ProfesorModel->getTeacherDataFields($form_data['teacher_id']);

					$document = $PHPWord->loadTemplate($fullpath);
					foreach ($teacherDataFields as $fk=>$fv) {
						var_dump($fk, $fv);exit;
						$document->setValue('{'.$fk.'}', $fv);
					}

					$document->saveAs($fullpath);
					chmod($fullpath, 0777);

					//aws s3
					$amazon = $this->config->item('amazon');
					$client = new S3Client(array(
						'version' => 'latest',
						'credentials' => array(
							'key'       => $amazon['AWSAccessKeyId'],
							'secret'    => $amazon['AWSSecretKey'],
						),
						'region' => $amazon['region'],
						'client_defaults' => ['verify' => false]
					));


					$unique_name = md5(uniqid(rand(), true)) . '-' . $filename;
					$key = $this->_db_details->idcliente .'/LMS/temp/templates/'.$form_data["template_id"].'/'. $unique_name;
var_dump($key);exit;
					try{
						$res = $client->putObject(array(
							'Bucket' =>  $amazon['bucket'],
							'Key' => $key,
							'SourceFile' => $fullpath,
							'ACL' => 'public-read',
							'ContentType' => 'text/plain'
						));
						if(isset($res['ObjectURL'])){
							unlink($fullpath);

							var_dump($res['ObjectURL'], $fullpath);exit;
							redirect($res['ObjectURL']);
						}else{

						}
					}catch(\Aws\S3\Exception\S3Exception $e){
						$errors[] = $e->getMessage();
					}
					//aws s3 end

				}catch(\PhpOffice\PhpWord\Exception\Exception $er){
					$errors[] = $er->getMessage();
				}
				echo json_encode($errors);
				exit;
			}
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function unlikDownloadPath(){
		if($this->input->post()) {
			$dir_path = './crm/downloads/teachers';
			//$this->deleteDirectory($dir_path);
			$data['status'] = true;
			echo json_encode($data);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	private  function deleteDirectory($dir) {
		if (!file_exists($dir)) {
			return true;
		}

		if (!is_dir($dir)) {
			return unlink($dir);
		}

		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..') {
				continue;
			}

			if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
				return false;
			}

		}

		return rmdir($dir);
	}

	//Personalized

	public function savePersonalized(){
		if($this->input->post()) {
			$res_data = array('status' => false);
			$teacher_id = $this->input->post('teacher_id', true);
			$personalized_form_data = $this->input->post('ersonalized_data', true);
			$check_teacher_id = $this->ProfesorModel->getTeacherById($teacher_id);
			if(!empty($check_teacher_id)) {
				$form_data = array();
				$fields = array();
				$check_id_exist = $this->ProfesoresTabAdModel->getByTeacherId($teacher_id);
				$fields_list = $this->ProfesoresTabAdModel->getFieldList();
				foreach ($fields_list as $field) {
					$fields[$field] = $field;
				}
				if (!empty($personalized_form_data) && !empty($fields)) {
					foreach ($personalized_form_data as $k => $data) {
						if (isset($fields[$data['name']])) {
							$key = $fields[$data['name']];
							$form_data[$key] = $data['value'];
						}
					}
				}
				if (!empty($check_id_exist)) {
					$result = $this->ProfesoresTabAdModel->updateFormData($form_data, $teacher_id);
					if ($result) {
						$res_data['status'] = true;
					}
				} else {
					$form_data['Indice'] = $teacher_id;
					$result = $this->ProfesoresTabAdModel->insertFormData($form_data);
					if ($result) {
						$res_data['status'] = true;
					}

				}
			}
			echo json_encode($res_data);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
}
