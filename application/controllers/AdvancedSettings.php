<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\Ses\SesClient;
/**
 *@property magaModel $magaModel
 *@property UserPostModel $UserPostModel
 *@property AdvancedSettingsModel $AdvancedSettingsModel
 *@property ProfesorModel $ProfesorModel
 *@property AlumnoModel $AlumnoModel
 *@property MiempresaModel $MiempresaModel
 *@property ManageMoodleModel $ManageMoodleModel
 */
class AdvancedSettings extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('UserPostModel');
		$this->load->model('UsuarioModel');
		$this->load->model('ProfesorModel');
		$this->load->model('AlumnoModel');
		$this->load->model('ErpMappingOptionModel');
		$this->load->model('ErpMappingAliasModel');
		$this->load->model('ManageMoodleModel');

		$this->load->library('moodle');
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->load->helper('email');
		if(!$this->session->userdata('loggedIn')){
			redirect('/auth/login/', 'refresh');
		}
		$this->lang->load('advanced_settings', $this->data['lang']);
		
		$this->init_moodle();
		
		
	}
	
	public function index(){
		$this->lang->load('quicktips', $this->data['lang']);
		$this->layouts->add_includes('js', '/app/js/advanced_settings/index.js');
		$this->data['campus_teachers_active'] = $this->_db_details->module_campus_teachers_active;
		//$this->data['campus_teachers_max_users'] = $this->_db_details->module_campus_teachers_max_users;
		//$this->data['campus_teachers_expire'] = $this->_db_details->module_campus_teachers_expire;
		$this->data['campus_students_active'] = $this->_db_details->module_campus_students_active;
		//$this->data['campus_students_max_users'] = $this->_db_details->module_campus_students_max_users;
		//$this->data['campus_students_expire'] = $this->_db_details->module_campus_students_expire;
		$this->data['is_super_admin'] = $this->is_super_admin();
		$this->layouts->view('advanced_settings/index', $this->data);

	}

	public function users_list(){
		$this->layouts->add_includes('js', 'app/js/advanced_settings/user_list.js');
		$this->data['users'] = $this->UsuarioModel->get_users();
        $this->lang->load('quicktips', $this->data['lang']);
        $this->data['concurrent_users'] = $this->_db_details->concurrent_users;
		$this->layouts->view('advanced_settings/users_list', $this->data);
	}
	public function e_goi(){
		$this->layout = 'e_goi';
		$this->lang->load('quicktips', $this->data['lang']);
		$this->load->model('SftConfigEgoiModel');
		$this->load->model('ZapEgoiAliasesModel');
		$this->load->model('ZapEgoiMappingModel');
		$this->lang->load('e_goi', $this->data['lang']);
		$this->layouts->add_includes('js', 'app/js/advanced_settings/e_goi.js');
		$mapping_data = $this->ZapEgoiMappingModel->getMapping();
		$mapped_ids_akaud = array();
		$mapped_ids_egoi = array();
		if(!empty($mapping_data)) {
			foreach ($mapping_data as $mapped){
				$mapped_ids_akaud[] = $mapped->alias_id;
				$mapped_ids_egoi[] = $mapped->egoi_list;
			}
		}
		$aliases = $this->ZapEgoiAliasesModel->getAliases($mapped_ids_akaud);
		$group_by_table = array();
		$tables = array();
		if(!empty($aliases)){
			foreach($aliases as $aliase){
				$group_by_table[$aliase->table_name][] = $aliase;
				$tables[$aliase->table_name] = $aliase->table_name_alias;
			}
		}
		$this->data['group_by_table'] = $group_by_table;
		$this->data['tables'] = $tables;

		$this->data['e_goi'] = $this->SftConfigEgoiModel->getEgoiData();
		if(isset($this->data['e_goi']->apikey)){
			$exttra_fields = $this->getExtraList($this->data['e_goi']->apikey);
		}else{
			$exttra_fields = array();
		}

		//vardump($exttra_fields);exit;
		if(isset($exttra_fields[0]['extra_fields'])){
			$exttra_fields = $exttra_fields[0]['extra_fields'];
		}
		if(!empty($exttra_fields) && !empty($mapped_ids_egoi)){
			foreach($exttra_fields as $feald){
				if( !in_array($feald['id'], $mapped_ids_egoi)) {
					$this->data['exttra_fields'][] = $feald;
				}
			}
		}else{
			$this->data['exttra_fields'] = $exttra_fields;
		}
		$this->data['mapping_data'] = $mapping_data;
		//vardump($exttra_fields);exit;
		$this->layouts->view('advanced_settings/e_goi', $this->data, $this->layout);
	}

	public function e_goi_unSet(){
		if($this->input->post('unset')){

			$this->load->model('SftConfigEgoiModel');
			$this->load->model('ZapEgoiMappingModel');
			$result = false;
			if($this->SftConfigEgoiModel->deleteItem()){
				$result = $this->ZapEgoiMappingModel->deleteAllItems();
			}
			echo json_encode(array('success' => $result));
			exit;
		}
	}

	private function getExtraList($api_key){
		$params = array(
			'apikey'    => $api_key
		);
		$client = new SoapClient('http://api.e-goi.com/v2/soap.php?wsdl');
		$result = $client->getLists($params);
		return $result;
	}
	public function e_goi_valid(){
		$user = $this->input->post('user', true);
		$password = $this->input->post('password', true);
		$api_key = $this->input->post('api_key', true);
		$result = array();
		if($api_key){
			$params = array( 'apikey'    => $api_key);
		}elseif($user && $password){
			$params = array( 'username'    => $user, 'password' => $password);
		}
		// using Soap with SoapClient
		if(isset($params)) {
			$client = new SoapClient('http://api.e-goi.com/v2/soap.php?wsdl');
			$result = $client->checklogin($params);
		}
		echo json_encode($result);
		exit;
	}

	public function saveExtraFields(){
		$this->load->model('ZapEgoiMappingModel');
		$alias_id = $this->input->post('alias_id', true);
		$egoi_list = $this->input->post('egoi_list', true);
		$egoi_field = $this->input->post('egoi_field', true);
		$result = false;
		if(!empty($alias_id) && !empty($egoi_list) && !empty($egoi_field)){
			$insert_data = array(
				"alias_id" => $alias_id,
				"egoi_list" => $egoi_list,
				"egoi_field" => $egoi_field,
				"table_id" => '1',
			);
			$result = $this->ZapEgoiMappingModel->insertData($insert_data);
		}
		echo json_encode(array('success' => $result));
		exit;
	}

	public function e_goi_save_data(){
		$user = $this->input->post('user', true);
		$password = $this->input->post('password', true);
		$api_key = $this->input->post('api_key', true);
		$result = false;
		if($api_key){
			$params = array( 'apikey'    => $api_key);
		}elseif($user && $password){
			$params = array( 'username'    => $user, 'password' => $password);
		}
		// using Soap with SoapClient
		if(isset($params)) {
			$this->load->model('SftConfigEgoiModel');
			$client = new SoapClient('http://api.e-goi.com/v2/soap.php?wsdl');
			$result_valid = $client->checklogin($params);
			if(isset($result_valid['RESULT']) &&  $result_valid['RESULT'] == 'OK'){

				$result_e_goi = $this->SftConfigEgoiModel->getEgoiData();
				if(!empty($result_e_goi)) {
					$update_data = array(
						'login' => $user,
						'pwd' => $password,
						'active' => $result_valid['status'],
						'apikey' => $result_valid['apikey'],
					);
					$result = $this->SftConfigEgoiModel->updateEgoiData($update_data);
				}else{
					$insert_data = array(
						'login' => $user,
						'pwd' => $password,
						'active' => $result_valid['status'],
						'apikey' => $result_valid['apikey'],
					);
					$result = $this->SftConfigEgoiModel->insertData($insert_data);
				}
			}
		}
		echo json_encode(array('result' => $result));
		exit;
	}

	public function updateSelectFieldsEgoi(){
		$this->load->model('SftConfigEgoiModel');
		$this->load->model('ZapEgoiAliasesModel');
		$this->load->model('ZapEgoiMappingModel');
		$egoi_fields_result = array();
		$group_by_table = array();
		$mapping_data = $this->ZapEgoiMappingModel->getMapping();
		$mapped_ids_akaud = array();
		$mapped_ids_egoi = array();
		if(!empty($mapping_data)) {
			foreach ($mapping_data as $mapped){
				$mapped_ids_akaud[] = $mapped->alias_id;
				$mapped_ids_egoi[] = $mapped->egoi_list;
			}
		}
		$aliases = $this->ZapEgoiAliasesModel->getAliases($mapped_ids_akaud);
		if(!empty($aliases)){
			foreach($aliases as $aliase){
				$group_by_table[$aliase->table_name][] = $aliase;
			}
		}


		$this->data['e_goi'] = $this->SftConfigEgoiModel->getEgoiData();
		if(isset($this->data['e_goi']->apikey)) {
			$egoi_fields = $this->getExtraList($this->data['e_goi']->apikey);
		}else{
			$egoi_fields = array();
		}

		if(isset($egoi_fields[0]['extra_fields'])){
			$egoi_fields = $egoi_fields[0]['extra_fields'];
		}
		if(!empty($egoi_fields) && !empty($mapped_ids_egoi)){
			foreach($egoi_fields as $feald){
				if( !in_array($feald['id'], $mapped_ids_egoi)) {
					$egoi_fields_result[] = $feald;
				}
			}
		}else{
			$egoi_fields_result = $egoi_fields;
		}
		echo json_encode(array('group_by_table' => $group_by_table, 'egoi_fields' => $egoi_fields_result));
		exit;
	}

	public function deleteMappedField(){
		if($this->input->post()){
			$success = false;
			$mapped_id = $this->input->post('mapped_id', true);
			if($mapped_id){
				$this->load->model('ZapEgoiMappingModel');
				$success = $this->ZapEgoiMappingModel->deleteItem($mapped_id);
			}
			echo json_encode(array('success' => $success));
		}
	}

	public function getEgoiList(){
		$this->load->model('SftConfigEgoiModel');
		$result_e_goi = $this->SftConfigEgoiModel->getEgoiData();
		if(!empty($result_e_goi)) {
			$params = array(
				'apikey' => $result_e_goi->apikey
			);

// using Soap with SoapClient
			$client = new SoapClient('http://api.e-goi.com/v2/soap.php?wsdl');
			$result = $client->getLists($params);
			vardump($result);
		}
	}


	public function moodle(){
		$this->data['webservice'] = false;


		$this->data['configData'] = $this->ManageMoodleModel->SelectRecord("sftconfig_moodle","*","");
		
		$checkWebService = $this->moodle->getServiceInfo();
        $this->lang->load('quicktips', $this->data['lang']);

        if($checkWebService['success']){
			$this->data['webservice'] = true;
		}
		

//		$this->layout = 'moodle';

		$this->lang->load('moodle', $this->data['lang']);

		$this->layouts->add_includes('js', 'app/js/advanced_settings/moodle.js');
		$check = $this->input->post('hidden');
		$id = $this->input->post('id');
		if(!empty($check)){

			$count = $this->ManageMoodleModel->getTotalCount('sftconfig_moodle');

			$array = array('rpc_server'=>$this->input->post('server'),
			'rpc_token'=>$this->input->post('token'),
			'rpc_user'=>$this->input->post('username'),
			'rpc_pwd'=>$this->input->post('password'));

			if($count>0){
				$this->ManageMoodleModel->updateRecord('sftconfig_moodle',$array,array('id'=>$id));
			}else{
				$this->ManageMoodleModel->insertRecord('sftconfig_moodle',$array);
			}

			redirect('advancedSettings/moodle');

		}
		
		$this->data['current_plan'] = $this->_db_details->plan;
		$this->layouts->view('advanced_settings/moodle', $this->data, $this->layout);
    }
	
	
	public function moodle_manage(){
//		$this->layout = 'moodle';
		$this->lang->load('moodle', $this->data['lang']);

		$this->layouts->add_includes('js', 'app/js/advanced_settings/moodle_manage.js');
		$this->layouts->add_includes('js', 'app/js/advanced_settings/partials/moodle_manage/courses.js');
		$this->layouts->add_includes('js', 'app/js/advanced_settings/partials/moodle_manage/teachers.js');
		$this->layouts->add_includes('js', 'app/js/advanced_settings/partials/moodle_manage/students.js');
		$this->layouts->add_includes('js', 'app/js/advanced_settings/partials/moodle_manage/enrollments.js');
		
		
		
		/********************  GET MOODLE COURSE AND CATEGORY DATA ******************/
		


		$Moodlecourse = $this->moodle->getCourse();
		$this->data['moodlecourse'] = $Moodlecourse['success'];
		
		$Moodlecategory = $this->moodle->getCategory();
		$this->data['moodlecategory'] = $Moodlecategory['success'];

		// Search dropdown data
		$this->data['groupData'] = $this->ManageMoodleModel->getGroups();
		$this->data['coursesData'] = $this->ManageMoodleModel->getCourses($this->input->post('group_id'));
		
		$this->layouts->view('advanced_settings/moodle_manage', $this->data, $this->layout);
	}
	
	function init_moodle(){

		$configData = $this->ManageMoodleModel->SelectRecord("sftconfig_moodle","rpc_token,rpc_server","");
		
		$array = array('token'=>$configData['rpc_token'], 'server'=>$configData['rpc_server'], 'dir'=>'');
		
		$this->moodle->init($array);

	}
	
	public function get_course_detail(){
		
		$course_id =$this->input->post('course_id',  true);
		$data = $this->ManageMoodleModel->getCourse($course_id);
		
		echo json_encode($data); exit;
	}
	
	public function insert_course_in_moodle(){
		
		$course_name =$this->input->post('course_name',  true);
		$course_description =$this->input->post('course_description',  true);
		$category =$this->input->post('category',  true);
		$format =$this->input->post('format',  true);
		$number =$this->input->post('number',  true);
		$lms_course_id =$this->input->post('lms_course_id',  true);
		$this->lang->load('moodle', $this->data['lang']);
		
				
		$para = array(array(array(
		'fullname' => trim($course_name),
		'shortname' => trim($course_name),
		'categoryid' => $category,
		'summary' => trim($course_description),
		'format' => trim($format),
		'numsections' => trim($number),
		)));

		$moodledata = $this->moodle->createCourse($para);
		
		
		if(!empty($moodledata['success'])){
			$this->ManageMoodleModel->updateRecord('curso',array('idmoodle'=>$moodledata['success'][0]['id']),array('codigo'=>$lms_course_id));
			echo 'done';
			exit;
		}else{
			echo $moodledata['error'];
			exit;
		}


	}
	
	public function moodle_course_link_to_lms(){
		$this->lang->load('moodle', $this->data['lang']);
		
		$course_id =$this->input->post('course_id',  true);
		$moodle_course_id =$this->input->post('moodle_course_id',  true);
		
		if(!empty($course_id) && !empty($moodle_course_id)){
			$this->ManageMoodleModel->updateRecord('curso',array('idmoodle'=>$moodle_course_id),array('codigo'=>$course_id));
			echo 'done';
			exit;
		}else{
			echo $this->lang->line('moodle_select_moodle_id');
			exit;
		}


	}
	
	public function update_course_in_moodle(){
		$this->lang->load('moodle', $this->data['lang']);
		
		$course_id =$this->input->post('course_id',  true);
		$data = $this->ManageMoodleModel->getCourse($course_id);
		$this->lang->load('moodle', $this->data['lang']);
		
		if($data['moodle_id']>0){
		
			$para = array(array(array(
			'id' => trim($data['moodle_id']),
			'fullname' => trim($data['brief_description']),
			'shortname' => trim($data['courseid']),
			'categoryid' => 1,
			'summary' => trim($data['full_description']),
			)));
			
			$moodledata = $this->moodle->updateCourse($data['moodle_id'],$para);
			
			if(!empty($moodledata['success'])){
				echo 'done';
				exit;
			}else{
				echo $moodledata['error'];
				exit;
			}
			
		}else{
			echo $this->lang->line('moodle_id_is_blank');
			exit;
		}

	}
	
	public function delete_course_in_moodle(){

		
		$course_id =$this->input->post('course_id',  true);
		$this->lang->load('moodle', $this->data['lang']);
		if(!empty($course_id)){
			$this->ManageMoodleModel->updateRecord('curso',array('idmoodle'=>''),array('codigo'=>$course_id));
			echo 'done';
			exit;
		}else{
			echo  $this->lang->line('moodle_select_course_id');
			exit;
		}
		
	}
	
	public function moodle_manage_course(){
		$this->lang->load('moodle', $this->data['lang']);
		$start =$this->input->post('start',  true);
		$length =$this->input->post('length', true);
		$draw = $this->input->post('draw', true);
		$search =$this->input->post('search', true);
		$order = $this->input->post('order', true);
		$columns = $this->input->post('columns', true);
		
		
		
		$total_course = $this->ManageMoodleModel->getCoursesData($start, $length, $draw, $search, $order, $columns,"count");
		$courseData = $this->ManageMoodleModel->getCoursesData($start, $length, $draw, $search, $order, $columns,"");
		
		$column = $order[0]['column'];
		
		$response = array(
			"start"=>$start,
			"length"=>$length,
			"search"=>$search,
			"order"=>$order,
			"column"=>$column,
			"draw"=>$draw,
			"recordsFiltered"=>$total_course,
			"recordsTotal"=>$total_course,
			"data"=>$courseData,
			"table_total_rows"=> $total_course
		);
		echo json_encode($response); exit;
	}
	
	public function insert_student_in_moodle(){
		$this->lang->load('moodle', $this->data['lang']);
		
		$student_id =$this->input->post('student_id',  true);
		
		$user_data = $this->ManageMoodleModel->getUserdetail("alumnos",$student_id);
		
		if($user_data['firstname'] && $user_data['lastname'] && $user_data['email']){
		
				$logindata = $this->ManageMoodleModel->SelectRecord("variables2","moodle_login,moodle_password_alumnos AS password","");
				$username = strtolower(trim($user_data['email']));
				$password = trim($logindata['password']);
				
				$fields = array(
				'username' => $username,
				'password' => $password,
				'firstname' => trim($user_data['firstname']),
				'lastname' => trim($user_data['lastname']),
				'email' => trim($user_data['email']),
				'city' => '',
				'country' => '',
				'preferences' => array(array('type' => 'auth_forcepasswordchange', 'value' => true)), // This forces user to change password on first login.
				);
				
		
				$para = array(array($fields));
				$moodledata = $this->moodle->createUser(5,$para);
				
				if(!empty($moodledata['success'])){
					$this->ManageMoodleModel->updateRecord('alumnos',array('idmoodle'=>$moodledata['success'][0]['id']),array('id'=>$student_id));
					echo 'done';
					exit;
				}else{
					echo $moodledata['error'];
					exit;
				}
		}else{
			echo $this->lang->line('moodle_ussername_password_firstname_require');
			exit;
		}
		
	}
	
	public function update_student_in_moodle(){
		$this->lang->load('moodle', $this->data['lang']);
		$student_id =$this->input->post('student_id',  true);
		
		$user_data = $this->ManageMoodleModel->getUserdetail("alumnos",$student_id);
		
		if($user_data['idmoodle']>0){
		
			$fields = array(
			'id' => $user_data['idmoodle'],
			'firstname' => trim($user_data['firstname']),
			'lastname' => trim($user_data['lastname']),
			'email' => trim($user_data['email']),
			'preferences' => array(array('type' => 'auth_forcepasswordchange', 'value' => true)), // This forces user to change password on first login.
			);
			
			$para = array(array($fields));
	
			
			$moodledata = $this->moodle->updateUser($user_data['idmoodle'],$para);
			
			
			if(!empty($moodledata['success'])){
				echo 'done';
				exit;
			}else{
				echo $moodledata['error'];
				exit;
			}
		}else{
			echo $this->lang->line('moodle_id_is_blank');
			exit;
		}

		
	}
	
	public function delete_student_in_moodle(){
		$this->lang->load('moodle', $this->data['lang']);
		$student_id =$this->input->post('student_id',  true);
		$user_data = $this->ManageMoodleModel->getUserdetail("alumnos",$student_id);
		
		if($user_data['idmoodle']){
		
			$moodledata = $this->moodle->deleteUser($user_data['idmoodle']);

			if(!empty($moodledata['success'])){
			
				$this->ManageMoodleModel->updateRecord('alumnos',array('idmoodle'=>''),array('id'=>$student_id));
				echo "done";
				exit;
			}else{
				echo $moodledata['error'];
				exit;
			}
		}else{
			echo $this->lang->line('moodle_id_is_blank');
			exit;
		}
	}
	
	
	
	public function moodle_manage_student(){
		
		$start =$this->input->post('start',  true);
		$length =$this->input->post('length', true);
		$draw = $this->input->post('draw', true);
		$search =$this->input->post('search', true);
		$order = $this->input->post('order', true);
		$columns = $this->input->post('columns', true);
		
		
		
		$total_student = $this->ManageMoodleModel->getUser('alumnos',$start, $length, $draw, $search, $order, $columns,"count");
		$studentData = $this->ManageMoodleModel->getUser('alumnos',$start, $length, $draw, $search, $order, $columns,'');
		
		$column = $order[0]['column'];

		
		$response = array(
			"start"=>$start,
			"length"=>$length,
			"search"=>$search,
			"order"=>$order,
			"column"=>$column,
			"draw"=>$draw,
			"recordsFiltered"=>$total_student,
			"recordsTotal"=>$total_student,
			"data"=>$studentData,
			"table_total_rows"=> $total_student
		);
		echo json_encode($response); exit;
	}

	public function insert_teacher_in_moodle(){
		$this->lang->load('moodle', $this->data['lang']);
		$teacher_id =$this->input->post('teacher_id',  true);
		
		$user_data = $this->ManageMoodleModel->getUserdetail("profesor",$teacher_id);
		
		$logindata = $this->ManageMoodleModel->SelectRecord("variables2","moodle_login,moodle_password_profesores AS password,","");
		
		if($user_data['firstname'] && $user_data['lastname'] && $user_data['email']){
		
			$username = strtolower(trim($user_data['email']));
			$password = trim($logindata['password']);
			
			$fields = array(
			'username' => trim($username),
			'password' => $password,
			'firstname' => trim($user_data['firstname']),
			'lastname' => trim($user_data['lastname']),
			'email' => trim($user_data['email']),
			'city' => '',
			'country' => '',
			'preferences' => array(array('type' => 'auth_forcepasswordchange', 'value' => true)), // This forces user to change password on first login.
			);
			
			$para = array(array($fields));
			
			
			$moodledata = $this->moodle->createUser(3,$para);
			
			if(!empty($moodledata['success'])){
				
				$this->ManageMoodleModel->updateRecord('profesor',array('idmoodle'=>$moodledata['success'][0]['id']),array('id'=>$teacher_id));
				echo 'done';
				exit;
			}else{
				echo $moodledata['error'];
				exit;
			}
		} else{
			
			echo $this->lang->line('moodle_ussername_password_firstname_require');
			exit;
			
		}

		
	}
	
	public function update_teacher_in_moodle(){
		$this->lang->load('moodle', $this->data['lang']);
		$teacher_id =$this->input->post('teacher_id',  true);
		
		$user_data = $this->ManageMoodleModel->getUserdetail("profesor",$teacher_id);
		
		if($user_data['idmoodle']>0){
		
			$fields = array(
			'id' => $user_data['idmoodle'],
			'firstname' => trim($user_data['firstname'])."1",
			'lastname' => trim($user_data['lastname']),
			'email' => trim($user_data['email']),
			'preferences' => array(array('type' => 'auth_forcepasswordchange', 'value' => true)), // This forces user to change password on first login.
			);
			
			$para = array(array($fields));
	
			
			$moodledata = $this->moodle->updateUser($user_data['idmoodle'],$para);
			
			if(!empty($moodledata['success'])){
				echo 'done';
				exit;
			}else{
				echo $moodledata['error'];
				exit;
			}
		}else{
			echo $this->lang->line('moodle_id_is_blank');
			exit;
		}

		
	}
	
	public function delete_teacher_in_moodle(){
		$this->lang->load('moodle', $this->data['lang']);
		$teacher_id =$this->input->post('teacher_id',  true);
		
		$user_data = $this->ManageMoodleModel->getUserdetail("profesor",$teacher_id);
		
		if($user_data['idmoodle']>0){
		
			$moodledata = $this->moodle->deleteUser($user_data['idmoodle']);

			if(!empty($moodledata['success'])){
			
				$this->ManageMoodleModel->updateRecord('profesor',array('idmoodle'=>''),array('id'=>$teacher_id));
				echo "done";
				exit;
			}else{
				echo $moodledata['error'];
				exit;
			}
		}else{
			echo $this->lang->line('moodle_id_is_blank');
			exit;
		}
	}
	
	public function moodle_manage_teacher(){
		$this->lang->load('moodle', $this->data['lang']);
		$start =$this->input->post('start',  true);
		$length =$this->input->post('length', true);
		$draw = $this->input->post('draw', true);
		$search =$this->input->post('search', true);
		$order = $this->input->post('order', true);
		$columns = $this->input->post('columns', true);
		
		
		
		$total_teacher = $this->ManageMoodleModel->getUser('profesor',$start, $length, $draw, $search, $order, $columns,"count");
		$teacherData = $this->ManageMoodleModel->getUser('profesor',$start, $length, $draw, $search, $order, $columns,"");
		
		$column = $order[0]['column'];
		
		$response = array(
			"start"=>$start,
			"length"=>$length,
			"search"=>$search,
			"order"=>$order,
			"column"=>$column,
			"draw"=>$draw,
			"recordsFiltered"=>$total_teacher,
			"recordsTotal"=>$total_teacher,
			"data"=>$teacherData,
			"table_total_rows"=> $total_teacher
		);
		echo json_encode($response); exit;
	}
	
	public function student_enroll_in_moodle(){
		$this->lang->load('moodle', $this->data['lang']);
		$student_id =$this->input->post('student_id',  true);
		$course_id =$this->input->post('course_id',  true);
		$start_date =$this->input->post('s_date',  true);
		$end_date =$this->input->post('e_date',  true);
		
		$user_data = $this->ManageMoodleModel->getUserdetail("alumnos",$student_id);
		

		if($user_data['idmoodle']>0 && $course_id>0){
			
			$moodledata = $this->moodle->enrollUser($user_data['idmoodle'], $course_id,$start_date,$end_date,5);
			
			if(!empty($moodledata['success'])){
				echo 'done';
				exit;
			}else{
				echo $moodledata['error'];
				exit;
			}
		}else{
			echo $this->lang->line('moodle_cours_id_or_moodle_student_id');
			exit;
		}
	}
	
	public function student_enroll_link_to_lms(){
		$this->lang->load('moodle', $this->data['lang']);
		$student_id =$this->input->post('student_id',  true);
		$course_id =$this->input->post('course_id',  true);
		$enroll_id =$this->input->post('enroll_id',  true);
		$moodle_course_id =$this->input->post('moodle_course_id',  true);
		
			if(!empty($moodle_course_id)){
				
				$this->ManageMoodleModel->updateRecord('matriculal',array('idmoodle'=>$moodle_course_id),array('NumMatricula'=>$enroll_id,'codigocurso'=>$course_id));
				echo 'done';
				exit;
			}else{
				echo $this->lang->line('moodle_select_course_id');
				exit;
			}


	}
	
	public function student_unenroll_in_moodle(){
		$this->lang->load('moodle', $this->data['lang']);
		$student_id =$this->input->post('student_id',  true);
		$course_id =$this->input->post('course_id',  true);
		$enroll_id =$this->input->post('enroll_id',  true);
		
			if(!empty($course_id) && !empty($enroll_id)){
				
				$this->ManageMoodleModel->updateRecord('matriculal',array('idmoodle'=>NULL),array('NumMatricula'=>$enroll_id,'codigocurso'=>$course_id));
				echo 'done';
				exit;
			}else{
				echo $this->lang->line('moodle_please_check_course_id_enroll_id');
				exit;
			}


	}
	

	public function moodle_manage_enroll(){
		
		$start =$this->input->post('start',  true);
		$length =$this->input->post('length', true);
		$draw = $this->input->post('draw', true);
		$search =$this->input->post('search', true);
		$order = $this->input->post('order', true);
		$columns = $this->input->post('columns', true);
		
		
		$filter_tags = array(
			'selected_courses' => $this->input->post('course_id', true),
			'selected_groups' => $this->input->post('group_id', true),
		);
		
		$total_enrollments = $enrollmentData = $this->ManageMoodleModel->getEnrollment($start, $length, $draw, $search, $order, $columns, $filter_tags,"count");
		$enrollmentData = $this->ManageMoodleModel->getEnrollment($start, $length, $draw, $search, $order, $columns, $filter_tags,"");
		
		$column = $order[0]['column'];
		//$recordsTotal = $enrollmentData['rows'];
		
		$response = array(
			"start"=>$start,
			"length"=>$length,
			"search"=>$search,
			"order"=>$order,
			"column"=>$column,
			"draw"=>$draw,
			"recordsFiltered"=>$total_enrollments,
			"recordsTotal"=>$total_enrollments,
			"data"=>$enrollmentData,
			"table_total_rows"=> $total_enrollments
		);
		echo json_encode($response); exit;
	}



	public function livebeep(){
		$this->layout = 'livebeep';

		$this->lang->load('livebeep', $this->data['lang']);
        $this->lang->load('quicktips', $this->data['lang']);
        $this->layouts->add_includes('js', 'app/js/advanced_settings/livebeep.js');
		
		$this->layouts->view('advanced_settings/livebeep', $this->data, $this->layout);
	}
	public function livebeep_manage(){
		$this->layout = 'livebeep';

		$this->lang->load('livebeep', $this->data['lang']);

		$this->layouts->add_includes('js', 'app/js/advanced_settings/livebeep.js');
		$this->layouts->add_includes('js', 'app/js/advanced_settings/partials/livebeep_manage/prospects.js');

		$this->layouts->view('advanced_settings/livebeep_manage', $this->data, $this->layout);
	}

	public function tags(){
		$this->layout = 'tags';
		$this->load->model('ErpTagsModel');
        $this->lang->load('quicktips', $this->data['lang']);
        $this->lang->load('tags', $this->data['lang']);
		$this->layouts
			->add_includes('css', 'assets/global/plugins/spectrum/css/spectrum.css')
			->add_includes('js', 'assets/global/plugins/spectrum/js/spectrum.js')
			->add_includes('js', 'app/js/advanced_settings/tags.js');
		$this->data['tags'] = $this->ErpTagsModel->getTags();
		$this->layouts->view('advanced_settings/tags', $this->data, $this->layout);
	}

	public function addEditTags(){
		if($this->input->is_ajax_request()) {
			$this->load->model('ErpTagsModel');
			$this->lang->load('tags', $this->data['lang']);
			$data = array('errors' => null, 'result' => false);
			$tag_name = $this->input->post('tag_name', true);
			$hax_backcolor = $this->input->post('hax_backcolor', true);
			$hax_forecolor = $this->input->post('hax_forecolor', true);
			$tag_id = $this->input->post('tag_id', true);
			$pattern = "/#([a-f0-9]{3}){1,2}\b/i";

			if(!empty($hax_backcolor)){
				if(preg_match($pattern, $hax_forecolor) === 1){
					$hax_forecolor = $hax_forecolor;
				}else{
					$hax_forecolor = null;
					$data['errors']['tags_text_color'] = $this->lang->line('tags_error_hex_color');
				}
			}
			if(!empty($hax_backcolor)){
				if(preg_match($pattern, $hax_backcolor) === 1){
					$hax_backcolor = $hax_backcolor;
				}else{
					$hax_backcolor = null;
					$data['errors']['tags_back_color'] =  $this->lang->line('tags_error_hex_color');
				}
			}
			$action_type = $this->input->post('action_type', true);
			$this->config->set_item('language', $this->data['lang']);
			if($action_type == 'add') {
				$this->form_validation->set_rules('tag_name', $this->lang->line('tags_tag_name'), 'trim|required|is_unique[erp_tags.tag_name]');
				if ($this->form_validation->run() && empty($data['errors'])) {
					$insert_data = array(
							'tag_name' => $tag_name
					);
					$insert_data['hex_backcolor'] = $hax_backcolor ? $hax_backcolor : '#0C91E0' ;
					$insert_data['hex_forecolor'] = $hax_forecolor ? $hax_forecolor : '#FFFFFF';
					$result = $this->ErpTagsModel->insertItem($insert_data);
					if($result){
						$insert_data['id'] = $result;
						$data['result'] = $insert_data;
					}else{
						$data['errors'] = array('db_err_msg' => $this->lang->line('db_err_msg'));
					}

				}else{
					$data['errors']['tags_tag_name'] =  validation_errors();
				}
			}elseif($action_type == 'edit' && $tag_id){
				$tag_data = $this->ErpTagsModel->getTags($tag_id);
				if(!empty($tag_data)){
					if($tag_data->tag_name != $tag_name){
						$this->form_validation->set_rules('tag_name', $this->lang->line('tags_tag_name'), 'trim|required|is_unique[erp_tags.tag_name]');
					}else{
						$this->form_validation->set_rules('tag_name', $this->lang->line('tags_tag_name'), 'trim|required');
					}
					if ($this->form_validation->run() && empty($data['errors'])) {
						$updae_data = array(
							'tag_name' => $tag_name
						);
						$updae_data['hex_backcolor'] = $hax_backcolor ? $hax_backcolor : '#0C91E0' ;
						$updae_data['hex_forecolor'] = $hax_forecolor ? $hax_forecolor : '#FFFFFF';
						$result = $this->ErpTagsModel->updateItem($updae_data, $tag_id);
						if ($result) {
							$updae_data['id'] = $tag_id;
							$data['result'] = $updae_data;
						} else {
							$data['errors'] = array('db_err_msg' => $this->lang->line('db_err_msg'));
						}
					}else{
						$data['errors']['tags_tag_name'] =  validation_errors();
					}
				}else{
					$data['errors'] = array('db_err_msg' => $this->lang->line('db_err_msg'));
				}
			}
			echo json_encode($data);
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function deleteTags(){
		if($this->input->is_ajax_request()) {
			$this->load->model('ErpTagsModel');
			$tag_id = $this->input->post('tag_id', true);
			$result = false;
			if($tag_id) {
				$result = $this->ErpTagsModel->deleteItemWithRelations($tag_id);
			}
			echo json_encode(array('success' => $result));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

// my custom fields function start
	
	public function update_status() {
      $id = $this->input->post('id');
       if($this->input->post('status') == "1"){
            $status = array('active' => 1);
      }else{
            $status = array('active' => 0);
      }
       $this->load->model('ErpCustomFieldsModel');
       $result = $this->ErpCustomFieldsModel->update_status($id, $status);
       echo json_encode($result);
       exit;
   }
    public function deleteFields(){
		if($this->input->is_ajax_request()) {
			$this->load->model('ErpCustomFieldsModel');
			$field_id = $this->input->post('field_id', true);
			$result = false;
			if($field_id) {
				$result = $this->ErpCustomFieldsModel->deleteFieldWithRelations($field_id);
			}
			echo json_encode(array('success' => $result));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

  public function custom_fields() {
	  $cisess = $this->session->userdata('_cisess');
	  $membership_type = $cisess['membership_type'];
	  if($membership_type != 'FREE'){
		  $this->layout = 'custom_fields';
		  $this->load->model('ErpCustomFieldsModel');
		  $this->lang->load('custom_fields', $this->data['lang']);
		  $this->layouts
			  ->add_includes('css', 'assets/global/plugins/spectrum/css/spectrum.css')
			  ->add_includes('js', 'assets/global/plugins/spectrum/js/spectrum.js')
			  ->add_includes('js', 'app/js/advanced_settings/custom_fields.js');

		  $this->data['tags'] = $this->ErpCustomFieldsModel->getFields();

		  $this->layouts->view('advanced_settings/custom_fields', $this->data, $this->layout);
	  }else{
		  $this->layouts->view('error_404',$this->data, 'error_404');
	  }
    }
    public function add_custom_fields() {
		$cisess = $this->session->userdata('_cisess');
		$membership_type = $cisess['membership_type'];
		if($membership_type != 'FREE') {
			$this->layout = 'custom_fields';
			$this->load->model('ErpCustomFieldsModel');
			$this->lang->load('custom_fields', $this->data['lang']);
			$this->layouts
				->add_includes('css', 'assets/global/plugins/spectrum/css/spectrum.css')
				->add_includes('js', 'assets/global/plugins/spectrum/js/spectrum.js');
			$this->data['tags'] = $this->ErpCustomFieldsModel->getFields();
			$this->layouts->view('advanced_settings/add_custom_fields', $this->data, $this->layout);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
    }

    public function addField() {
        $this->load->model('ErpCustomFieldsModel');

        if($this->input->post()) {
			$this->config->set_item('language', $this->data['lang']);
			$this->form_validation->set_rules('form_type', 'Field Belongs to', 'trim|required');
			$this->form_validation->set_rules('field_name', 'Field Name', 'trim|required');
			$this->form_validation->set_rules('field_type', 'Field Type', 'trim|required');
			if ($this->form_validation->run()) {
				$formData = $this->input->post();
				$formData['form_type'];
				$formData["field_name"];
				$formData["field_type"];
				$formData["disabled"]= (!empty($formData["disabled"])) ? $formData["disabled"] :0;
				$formData["only_admin"]=(!empty($formData["only_admin"])) ? $formData["only_admin"] :0;
				$formData["required"]=(!empty($formData["required"])) ? $formData["required"]:0;
				$formData["allow_students"]=(!empty($formData["allow_students"])) ? $formData["allow_students"]:0;
//				$formData["show_on_table"]=(!empty($formData["show_on_table"])) ? $formData["show_on_table"] :0;
				$formData["created_date"]=date('Y-m-d');
				$formData["active"]=1;

               $result = $this->ErpCustomFieldsModel->insertField($formData);
               $Id= $this->db->insert_id();

				if ($result > 0) {
					redirect('advancedSettings/custom_fields');
//					$this->session->set_flashdata('addMsg', 'Template has been successfully added!');
//					$this->data['editfields'] = $this->ErpCustomFieldsModel->getFields($Id);
					// print_r($this->data['editfields']);die();
//					$this->layouts->view("advanced_settings/edit_custom_fields", $this->data);
				}else{
					$this->data['add_error_msg'] = $this->lang->line('');
				}
            }else{
				$this->data['valid_errors'] = $this->form_validation->error_array();
			}
		}
		$this->lang->load('custom_fields', $this->data['lang']);
		$this->layouts->view("advanced_settings/add_custom_fields", $this->data);
    }
       
    public function updateField() {

        if ($this->uri->segment(3)) {
			$Id = $this->uri->segment(3);
		}

		$this->load->model('ErpCustomFieldsModel');
        if($this->input->post()){
			
			$this->form_validation->set_rules('form_type', 'Field Belongs to', 'trim|required');
			$this->form_validation->set_rules('field_name', 'Field Name', 'trim|required');
			$this->form_validation->set_rules('field_type', 'Field Type', 'trim|required');
			if ($this->form_validation->run()) {
				$formData = $this->input->post();
				$formData['form_type'];
				$formData["field_name"];
				$formData["field_type"];
				$formData["disabled"]= (!empty($formData["disabled"])) ? $formData["disabled"] :0;
				$formData["only_admin"]=(!empty($formData["only_admin"])) ? $formData["only_admin"] :0;
				$formData["required"]=(!empty($formData["required"])) ? $formData["required"]:0;
				$formData["allow_students"]=(!empty($formData["allow_students"])) ? $formData["allow_students"]:0;
//				$formData["show_on_table"]=(!empty($formData["show_on_table"])) ? $formData["show_on_table"] :0;
				$formData["created_date"]=date('Y-m-d');
				$formData["active"]= isset($formData["active_hidden"]) && $formData["active_hidden"] == '1' ? 1 :0;
				unset($formData["active_hidden"]);

				$result = $this->ErpCustomFieldsModel->updateField($formData,$Id);
			  redirect('advancedSettings/custom_fields');
			}
		}
		$this->data['editfields'] = $this->ErpCustomFieldsModel->getFields($Id);
        $this->layouts->view("advanced_settings/edit_custom_fields", $this->data);
    }

    public function editField($id = null) {
		$cisess = $this->session->userdata('_cisess');
		$membership_type = $cisess['membership_type'];
		if($membership_type != 'FREE') {
			$this->layouts->add_includes('js', 'app/js/advanced_settings/edit_custom_fields.js');
			if (!$id || !is_string($id)) {
				redirect('advancedSettings/custom_fields');
			}

			$this->load->model('ErpCustomFieldsModel');
			$this->data['editfields'] = $this->ErpCustomFieldsModel->getFields($id);
			if (empty($this->data['editfields'])) {
				redirect('advancedSettings/custom_fields');
			}
			$this->lang->load('custom_fields', $this->data['lang']);
			// print_r($this->data['editfields']);die();
			$this->layouts->view("advanced_settings/edit_custom_fields", $this->data);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
    }
// custom fields  function end


	public function change_user_status(){
		if($this->input->is_ajax_request()) {
			$user_id = $this->input->post('user_id', true);
			$userData = $this->session->userdata('userData');
			$current_userId = $userData[0]->Id;
			if($this->is_owner() && $current_userId != $user_id) {
				$status = $this->input->post('status', true) == '1' ? '1' : '0';
				$user_limit = $this->_db_details->concurrent_users;
				$count_active_users = $this->UsuarioModel->conut_active_users();
				if (($status == '1' && $count_active_users < $user_limit) || $status == '0') {
					$result = $this->UsuarioModel->change_user_status($user_id, $status);
					if ($result) {
						$data = array('status' => $status, 'msg' => '');
					} else {
						$data = array('status' => false, 'msg' => $this->lang->line('db_err_msg'));
					}
				} else {
					$data = array('status' => false, 'msg' => $this->lang->line('warning_limit_is_finished'));
				}
			}else{
				$data = array('status' => false, 'msg' => $this->lang->line('you_have_not_permission'));
			}
			echo json_encode($data);
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	// Campus Teachers
	public function campus_teachers(){
		$this->data['page'] = 'advanced_settings_campus_teachers';
		$this->data['campus_teachers_active'] = $this->_db_details->module_campus_teachers_active;
        $this->lang->load('quicktips', $this->data['lang']);
        if($this->data['campus_teachers_active'] == '1' || $this->is_super_admin()){

			$this->layouts->add_includes('js', '/app/js/advanced_settings/campus_teachers.js');

			$this->data['campus_teachers'] = $this->ProfesorModel->get_campus_teachers();
			$this->data['campus_teachers_max_users'] = $this->_db_details->module_campus_teachers_max_users;
			$this->layouts->view('advanced_settings/campus_teachers', $this->data);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
	public function change_campus_teachers_status(){
		if($this->input->is_ajax_request()) {
			$teacher_ids = $this->input->post('teacher_ids', true);
			$status = $this->input->post('status', true) == '1' ? 1 : 0;

			$user_limit = $this->_db_details->module_campus_teachers_max_users;
			$count_active_teachers = $this->ProfesorModel->conut_active_teachers();
			if(($status == '1' && (count($teacher_ids) + $count_active_teachers) <= $user_limit) || $status == '0') {
				$data = array();
				if(!empty($teacher_ids) && is_array($teacher_ids)){
					foreach($teacher_ids as $id){
						$data[] = array(
							'INDICE' => $id,
							'enebc' => $status,
							//'active' => '1'
						);
					}
					$result = $this->ProfesorModel->update_teachers_data($data);
				}else{
					$result = null;
				}

				if ($result) {
					$data = array('status' => $status, 'msg' => '');
				} else {
					$data = array('status' => -1, 'msg' => '');
				}
			}else{
				$data = array('status' => -1, 'msg' => 'warning_limit_is_finished');
			}
			echo json_encode($data);
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
	public function send_email_teacher(){
		if($this->input->is_ajax_request()) {
			$this->load->model('ErpEmailModel');
			$email = $this->input->post('email', true);
			$teacher_id = $this->input->post('teacher_id', true);
			$user_id = $this->data['userData'][0]->Id;
			$data = array();
			$teacher_data = $this->ProfesorModel->get_campus_teachers(array('indice' => $teacher_id, 'Activo' => 1, 'enebc' => 1,  'Email' => $email));

			if(!empty($teacher_data) && !empty($email)){
				$expiredate = date('Y-m-d', strtotime('+1 Week'));
				//$expiredate = date('Y-m-d', strtotime('-1 Week'));
				//$activation_code = base64_encode($expiredate . '+' . $email . '+' . $teacher_id);
				//$href = base_url() . 'signUp/teacher_activation/' . urlencode($activation_code);
				//$link = '<a href="' . $href . '"> Click here to activate your account </a>';
				//$message = ' <p>Hi ' . $teacher_data[0]->teacher_name . ', </p> <br>  <p>Welcome to Akaud!</p> <br> ' . $link . '<br> <p>Regards</p><br>  <p>Akaud Team</p>';
				//$expiredate = date('Y-m-d', strtotime('+1 Day'));
				$user_role = 'teacher';
				$user_name = $teacher_data[0]->teacher_name;
				$key_code = $this->_db_details->key;
				$code = base64_encode($expiredate.'+'.$user_role.'+'.$teacher_id.'+'.$email.'+'.$user_name.'+'.$key_code );
				$href = base_url().'forgotPassword/index/'. urlencode($code);
				$company = $this->ProfesorModel->get_company_name();
				//$smtp_conf = (object)$this->config->item('smtp_config');
				$this->data['href'] = $href;
				$this->data['user_name'] = $teacher_data[0]->teacher_name;
				$this->data['keycode'] = $this->session->userdata("_cisess")['key'];
				$this->data['company_name'] = $company[0]->company_name;
				//$this->lang->load('forget_pass_email', $this->data['lang']);

				$message = $this->load->view('forgot_password/partials/activation_email', $this->data, TRUE);

				$insert_data = array(
					'from_userid' => $user_id,
					'id_campaign' => '',
					'email_recipie' => $email,
					'Subject' => $this->lang->line('activation_subject_text1').' ' . $company[0]->company_name,
					'Body' => $message,
					'date' => date("Y-m-d H:i:s"),
				);

				//get plan
				$cisess = $this->session->userdata('_cisess');
				$membership_type = $cisess['membership_type'];
				$smtp_data = $this->UsuarioModel->getSmtpSettings($user_id);
				if($membership_type != 'FREE' && $smtp_data->mail_provider == 1){
					if($smtp_data->auth_method == 0){
						$smtpSecure = 'ssl';
					}elseif($smtp_data->auth_method == 1){
						$smtpSecure = 'ssl';
					}elseif($smtp_data->auth_method == 2){
						$smtpSecure = 'tls';
					}

					$mail = new PHPMailer();

					$mail->IsSMTP();                                      // set mailer to use SMTP
					$mail->Host = $smtp_data->hostname;  // specify main and backup server
					$mail->SMTPAuth = true;     // turn on SMTP authentication
					$mail->Port =  $smtp_data->port;
					$mail->SMTPSecure =  $smtpSecure;
					$mail->Username = $smtp_data->user;  // SMTP username
					$mail->Password = $smtp_data->pwd; // SMTP password

					$mail->From =  $smtp_data->user;
					$mail->FromName = $this->data['company_name'];
					$mail->AddAddress($email);
					$mail->WordWrap = 1000;                                 // set word wrap to 50 characters
					$mail->IsHTML(true);
					// set email format to HTML

					$mail->Subject = $this->lang->line('activation_subject_text1') . ' ' . $company[0]->company_name;
					$mail->Body    =$message;
					$mail->AltBody = "";
					if(!$mail->Send()) {
						$data = array('status' => false);
						$insert_data['sucess'] = '0';
						$insert_data['error_msg'] = null;
					}else {
						$data = array('status' => true);
						$insert_data['sucess'] = '1';
						$insert_data['error_msg'] = null;
					}

					$this->ErpEmailModel->insertEmailData($insert_data);

				}else {
					$emails_limit_daily = $this->_db_details->emails_limit_daily;
					$emails_limit_monthly = $this->_db_details->emails_limit_monthly;
					$count_emails_day = $this->ErpEmailModel->getEmailsCountDay($user_id);
					if($emails_limit_daily > $count_emails_day->count_daily && $emails_limit_monthly > $count_emails_day->count_monthly  ) {

					$email_conf = (object)$this->config->item('email');
					$amazon = $this->config->item('amazon');
					$email_from = $this->config->item('email');

					$client = SesClient::factory(array(
						'version' => 'latest',
						'region' => $amazon['email_region'],
						'credentials' => array(
							'key' => $amazon['AWSAccessKeyId'],
							'secret' => $amazon['AWSSecretKey'],
						),
					));
					$request = array();
					$request['Source'] = $email_from['from'];
					$request['Destination']['ToAddresses'] = array($email);
					$request['Message']['Subject']['Data'] = $this->lang->line('activation_subject_text1') . ' ' . $company[0]->company_name;
					$request['Message']['Subject']['Charset'] = "UTF-8";
					$request['Message']['Body']['Html']['Data'] = $message;
					$request['Message']['Subject']['Charset'] = "UTF-8";

					try {
						$result = $client->sendEmail($request);
						$messageId = $result->get('MessageId');
						//echo("Email sent! Message ID: $messageId"."\n");
						if ($messageId) {
							$data = array('status' => true);
							$insert_data['sucess'] = '1';
							$insert_data['error_msg'] = null;
						} else {
							$data = array('status' => false);
							$insert_data['sucess'] = '0';
							$insert_data['error_msg'] = null;
						}
						$this->ErpEmailModel->insertEmailData($insert_data);
					} catch (Exception $e) {
						//echo("The email was not sent. Error message: ");
						//$response['errors'] = $e->getMessage()."\n";
						$insert_data['sucess'] = '0';
						$insert_data['error_msg'] = $e->getMessage();
						$data = array('status' => false);
						$this->ErpEmailModel->insertEmailData($insert_data);
					}
					}else{
						$data = array('error_msg' => $this->lang->line('emails_limit_daily_msg'));
					}
				}
			}else{
				$data = array('error_msg' => sprintf($this->lang->line('invalid_email'), ''));
			}

			echo json_encode($data);
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function send_email_teachers(){
		if($this->input->is_ajax_request()) {
			$this->load->model('ErpEmailModel');
			$teachers_info = $this->input->post('teachers_info', true);
			$response['success'] = false;
			$response['errors'] = false;
			$user_id =  $this->data['userData'][0]->Id;
			$emails_limit_daily = $this->_db_details->emails_limit_daily;
			$emails_limit_monthly = $this->_db_details->emails_limit_monthly;
			foreach($teachers_info as $teacher){
				$id = isset($teacher['id']) ? $teacher['id'] : null;
				$email = isset($teacher['email']) ? $teacher['email'] : null;
				$teacher_data = $this->ProfesorModel->get_campus_teachers(array('indice' => $id, 'Activo' => 1, 'enebc' => 1, 'Email' => $email));
				if(!empty($teacher_data) && !empty($email)){
					$count_emails_day = $this->ErpEmailModel->getEmailsCountDay($user_id);


						/*$expiredate = date('Y-m-d', strtotime('+1 Week'));
						$activation_code = base64_encode($expiredate . '+' . $email . '+' . $id);
						$href = base_url() . 'signUp/teacher_activation/' . urlencode($activation_code);
						$link = '<a href="' . $href . '"> Click here to activate your account </a>';
						$message = ' <p>Hi ' . $teacher_data[0]->teacher_name . ', </p> <br>  <p>Welcome to Akaud!</p> <br> ' . $link . '<br> <p>Regards</p><br>  <p>Akaud Team</p>';*/
						$expiredate = date('Y-m-d', strtotime('+1 Week'));
						$user_role = 'teacher';
						$user_name = $teacher_data[0]->teacher_name;
						$key_code = $this->_db_details->key;
						$code = base64_encode($expiredate.'+'.$user_role.'+'.$teacher_data[0]->id.'+'.$email.'+'.$user_name.'+'.$key_code );
						$href = base_url().'forgotPassword/index/'. urlencode($code);
						$company = $this->ProfesorModel->get_company_name();
						$this->data['href'] = $href;
						$this->data['user_name'] = $teacher_data[0]->teacher_name;
						$this->data['keycode'] = $this->session->userdata("_cisess")['key'];
						$this->data['company_name'] = $company[0]->company_name;
						//$this->lang->load('forget_pass_email', $this->data['lang']);

						$message = $this->load->view('forgot_password/partials/activation_email', $this->data, TRUE);

						//get plan
						$cisess = $this->session->userdata('_cisess');
						$membership_type = $cisess['membership_type'];
						$smtp_data = $this->UsuarioModel->getSmtpSettings($user_id);
						if($membership_type != 'FREE' && $smtp_data->mail_provider == 1){
							if($smtp_data->auth_method == 0){
								$smtpSecure = 'ssl';
							}elseif($smtp_data->auth_method == 1){
								$smtpSecure = 'ssl';
							}elseif($smtp_data->auth_method == 2){
								$smtpSecure = 'tls';
							}

							$mail = new PHPMailer();

							$mail->IsSMTP();                                      // set mailer to use SMTP
							$mail->Host = $smtp_data->hostname;  // specify main and backup server
							$mail->SMTPAuth = true;     // turn on SMTP authentication
							$mail->Port =  $smtp_data->port;
							$mail->SMTPSecure =  $smtpSecure;
							$mail->Username = $smtp_data->user;  // SMTP username
							$mail->Password = $smtp_data->pwd; // SMTP password

							$mail->From =  $smtp_data->user;
							$mail->FromName = $this->data['company_name'];
							$mail->AddAddress($email);
							$mail->WordWrap = 1000;                                 // set word wrap to 50 characters
							$mail->IsHTML(true);
							// set email format to HTML

							$mail->Subject = $this->lang->line('activation_subject_text1') . ' ' . $company[0]->company_name;
							$mail->Body    =$message;
							$mail->AltBody = "";
							if(!$mail->Send()) {
								$response['errors'][] = sprintf($this->lang->line('advanced_settings_activation_code_no_sent'), $email);
								$insert_data['sucess'] = '0';
								$insert_data['error_msg'] = null;
							}else {
								$response['success'][] = sprintf($this->lang->line('advanced_settings_activation_code_sent'), $email);
								$insert_data['sucess'] = '1';
								$insert_data['error_msg'] = null;
							}

							$this->ErpEmailModel->insertEmailData($insert_data);

						}else {
							if($emails_limit_daily > $count_emails_day->count_daily && $emails_limit_monthly > $count_emails_day->count_monthly) {
								$amazon = $this->config->item('amazon');
								$email_from = $this->config->item('email');

								$client = SesClient::factory(array(
									'version' => 'latest',
									'region' => $amazon['email_region'],
									'credentials' => array(
										'key' => $amazon['AWSAccessKeyId'],
										'secret' => $amazon['AWSSecretKey'],
									),
								));

								$request = array();
								$request['Source'] = $email_from['from'];
								$request['Destination']['ToAddresses'] = array($email);
								$request['Message']['Subject']['Data'] = $this->lang->line('activation_subject_text1') . ' ' . $company[0]->company_name;
								$request['Message']['Subject']['Charset'] = "UTF-8";
								$request['Message']['Body']['Html']['Data'] = $message;
								$request['Message']['Subject']['Charset'] = "UTF-8";

								$insert_data = array(
									'from_userid' => $user_id,
									'id_campaign' => '',
									'email_recipie' => $email,
									'Subject' => $this->lang->line('activation_subject_text1') . ' ' . $company[0]->company_name,
									'Body' => $message,
									'date' => date("Y-m-d H:i:s"),
								);

								try {
									$result = $client->sendEmail($request);
									$messageId = $result->get('MessageId');
									//echo("Email sent! Message ID: $messageId"."\n");
									if ($messageId) {
										$response['success'][] = sprintf($this->lang->line('advanced_settings_activation_code_sent'), $email);
										$insert_data['sucess'] = '1';
										$insert_data['error_msg'] = null;
									} else {
										$response['errors'][] = sprintf($this->lang->line('advanced_settings_activation_code_no_sent'), $email);
										$insert_data['sucess'] = '0';
										$insert_data['error_msg'] = sprintf($this->lang->line('advanced_settings_activation_code_no_sent'), $email);
									}

									$this->ErpEmailModel->insertEmailData($insert_data);
								} catch (Exception $e) {
									//echo("The email was not sent. Error message: ");
									//$response['errors'] = $e->getMessage()."\n";
									$insert_data['sucess'] = '0';
									$insert_data['error_msg'] = $e->getMessage();
									$response['errors'][] = $this->lang->line('advanced_settings_activation_code_for') . $email . " " . $e->getMessage();
									$this->ErpEmailModel->insertEmailData($insert_data);
								}
							} else {
								$response['errors'][] = $this->lang->line('advanced_settings_activation_code_for') . $email . " " . $this->lang->line('emails_limit_daily_msg');
							}
						}
				}else{
					if(!empty($email)){
						$response['errors'][] = sprintf($this->lang->line('advanced_settings_activation_code_locked'), $email);
					}else{
						$response['errors'][] = sprintf($this->lang->line('invalid_email'), '');
					}
				}
			}

			echo json_encode($response);
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
	
	public function system_settings(){
		$this->load->model('MiempresaModel');
        $this->lang->load('quicktips', $this->data['lang']);
        $this->layouts
			->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
			->add_includes('js', 'assets/global/scripts/app.min.js')
			->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js');
		$this->layouts->add_includes('js', 'app/js/advanced_settings/system_settings.js');
		if($this->input->post()){
			$this->config->set_item('language', $this->data['lang']);
		
			$this->form_validation->set_rules('fiscal_name', $this->lang->line('fiscal_name'), 'trim|required');
			$this->form_validation->set_rules('commercial_name', $this->lang->line('commercial_name'), 'trim|required');
			$this->form_validation->set_rules('bank_iban', $this->lang->line('bank_iban'), 'trim|required');
			if ($this->form_validation->run()) {
				$update_data = array(
					'nombrefiscal' => $this->input->post('fiscal_name', true),
					'nombrecomercial' => $this->input->post('commercial_name', true),
					'domicilio' => $this->input->post('address', true),
					'poblacion' => $this->input->post('city', true),
					'provincia' => $this->input->post('province', true),
					'distrito' => $this->input->post('postal_code', true),
					'telefono' => $this->input->post('phone', true),
					'pais' => $this->input->post('country', true),
					'titular' => $this->input->post('incumbent', true),
					'iban' => $this->input->post('bank_iban', true),
					'sufijo' => $this->input->post('bank_sufix', true),
					''
				);
				$result = $this->MiempresaModel->updateCompany($update_data);
			}
		}
		$this->data['company'] = $this->MiempresaModel->getCompany();
		$this->layouts->view('advanced_settings/system_settings', $this->data);
	}


	public function billing_information(){
		$this->load->model('MiempresaModel');
        $this->lang->load('quicktips', $this->data['lang']);


        $this->layouts
			->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
//			->add_includes('js', 'assets/global/scripts/app.min.js')
			->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js');

		$this->layouts->add_includes('js', 'assets/global/plugins/select2/select2.js');
		if($this->data['lang'] == "spanish"){
			$this->layouts->add_includes('js', 'assets/global/plugins/select2/select2_locale_es.js');
		}
		
		$this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js');
		$this->layouts->add_includes('css', 'assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css');
		
		$this->layouts->add_includes('js', 'app/js/advanced_settings/billing_information.js');
		if($this->input->post()){
			$this->config->set_item('language', $this->data['lang']);

			$this->form_validation->set_rules('fiscal_name', $this->lang->line('fiscal_name'), 'trim|required');
			$this->form_validation->set_rules('commercial_name', $this->lang->line('commercial_name'), 'trim|required');
			$this->form_validation->set_rules('bank_iban', $this->lang->line('bank_iban'), 'trim|required');
			if ($this->form_validation->run()) {
				$update_data = array(
					'nombrefiscal' => $this->input->post('fiscal_name', true),
					'nombrecomercial' => $this->input->post('commercial_name', true),
					'domicilio' => $this->input->post('address', true),
					'poblacion' => $this->input->post('city', true),
					'provincia' => $this->input->post('province', true),
					'distrito' => $this->input->post('postal_code', true),
					'telefono' => $this->input->post('phone', true),
					'pais' => $this->input->post('country', true),
					'titular' => $this->input->post('incumbent', true),
					'iban' => $this->input->post('bank_iban', true),
					'sufijo' => $this->input->post('bank_sufix', true),
				);
				$result = $this->MiempresaModel->updateCompany($update_data);
			}
		}
		$this->data['company'] = $this->MiempresaModel->getCompany();
		$this->data['active_tab'] = $this->input->get('tab', true);
		$this->data['plan'] = isset($this->_db_details->plan) ? $this->_db_details->plan : '1';
		$this->data['paid'] = isset($this->_db_details->paid) ? $this->_db_details->paid : '0';
		$this->data['trial_expire'] = isset($this->_db_details->trial_expire) ? $this->_db_details->trial_expire : null;
		$this->data['is_super_admin'] = $this->is_super_admin();
		//vardump($this->_db_details);exit;
//		print_r($this->data['active_tab']);die;
		$this->layouts->view('advanced_settings/billing_information', $this->data);
	}



	public function cancel_subscription(){

		$this->layouts->add_includes('js', 'app/js/advanced_settings/cancel_subscription.js');
		$this->layouts->view('advanced_settings/cancel_subscription', $this->data);
	}




	public function invoice_pdf($invoice_id){
		$this->lang->load('paymentsystem', $this->data['lang']);

		$this->load->model('InvoiceModel');
		$invoice = $this->InvoiceModel->findById($invoice_id);

		$discount = 0;

		if ($invoice) {
			if ($invoice->paid) {
				$this->data['success'] = $this->lang->line('paymentsystem_invoice_paid');
			}
			$this->data['invoice'] = $invoice;
			$this->data['discount'] = $discount;
			$this->data['_coupon'] = $this->InvoiceModel->getCoupon($invoice->coupon_id);

			$this->load->model('ClientesAkaudModel');
			$user = $this->ClientesAkaudModel->getAll(array('id'=>$invoice->owner_id));
			if(isset($user[0]) && !empty($user[0])){
				$user = $user[0];
			}else{
				$user = new ClientesAkaudModel();
			}
			$this->data['owner'] = $user;
			$this->load->model('MiempresaModel');
			$this->data['company'] = $this->MiempresaModel->getCompany();
		}
		if ($this->_db_details->plan != '1') {
			$this->load->model('Variables2Model');
			$logo = $this->Variables2Model->get_logo();
			if (!empty($logo) && isset($logo->logo)) {
				$this->data['customer_logo'] = $logo->logo;
			} else {
				$this->data['customer_logo'] = null;
			}
		}
		$filename = rand() . '.pdf';
		if(isset($invoice->title)){
			$filename = str_replace(' ','-', strtolower(trim($invoice->title))).'.pdf';
		}
		$this->data['payment_perfix'] = $this->config->item('payment_perfix');
		$html = $this->load->view('advanced_settings/partials/billing_information/invoice_pdf', $this->data, TRUE);

		$mpdf = new mPDF('utf-8' , 'A4' , '' , '' , 0 , 0 , 0 , 0 , 0 , 0);
		$mpdf->list_indent_first_level = 1;  // 1 or 0 - whether to indent the first level of a list

		// LOAD a stylesheet
		$stylesheet = file_get_contents('assets/global/plugins/font-awesome/css/font-awesome.min.css');
		$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
		$stylesheet = file_get_contents('assets/global/plugins/simple-line-icons/simple-line-icons.min.css');
		$mpdf->WriteHTML($stylesheet,1);
		$stylesheet = file_get_contents('assets/global/plugins/bootstrap/css/bootstrap.css');
		$mpdf->WriteHTML($stylesheet,1);
		$stylesheet = file_get_contents('assets/global/plugins/uniform/css/uniform.default.css');
		$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
		$stylesheet = file_get_contents('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');
		$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
		$stylesheet = file_get_contents('assets/global/css/components-rounded.css');
		$mpdf->WriteHTML($stylesheet,1); //
		$stylesheet = file_get_contents('assets/global/css/plugins-md.css');
		$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
		$stylesheet = file_get_contents('assets/admin/layout3/css/layout.css');
		$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
		$stylesheet = file_get_contents('assets/admin/layout3/css/custom.css');
		$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
		$stylesheet = file_get_contents('assets/css/main.css');
		$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
		$stylesheet = file_get_contents('assets/admin/layout3/css/themes/light_blue.css');
		$mpdf->WriteHTML($stylesheet,1); //
		$stylesheet = file_get_contents('assets/pages/css/invoice-2.min.css');
		$mpdf->WriteHTML($stylesheet,1); //
		$stylesheet = file_get_contents('app/css/style.css');
		$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text

		$mpdf->WriteHTML($html, 2);
		$mpdf->Output($filename, 'D');
	}
	
	private function getAvailabilityTimaes($off = true){
		//$start_time = $this->session->userData('start_time');
		//$end_time = $this->session->userData('end_time');
		//$start_end_time = $this->Variables2Model->getStartEndtime();

		$start_time = '01:00';//substr($start_end_time->start_time, 0, -2).':'.substr($start_end_time->start_time, -2);
		$end_time = '24:00';//substr($start_end_time->end_time, 0, -2).':'.substr($start_end_time->end_time, -2);
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
			$time_data['-1'] = 'OFF';
		}
		return $time_data;
	}

	public function getGeneralSettings(){
		if($this->input->is_ajax_request()) {
			$user_id =$this->data['userData'][0]->Id;
			$this->load->model('AreasAcademicaModel');
			$this->load->model('Variables2Model');
			$this->data['general_settings'] = $this->Variables2Model->getGeneralSettings($user_id);
			$this->data['academic_year'] = $this->AreasAcademicaModel->getAcademicYears();
//			vardump($this->data['general_settings']);
//			vardump($this->data['academic_year']); exit;
			$this->data['payment_methods'] = array(
				(object)array('id' => 0,
							  'title' => 'cash'
							),(object)array('id' => 1,
							  'title' => 'credit_card'
							),(object)array('id' => 2,
							  'title' => 'direct_debit'
							),(object)array('id' => 3,
							  'title' => 'transfer'
							),(object)array('id' => 4,
							  'title' => 'check'
							),(object)array('id' => 5,
							  'title' => 'financed'
							),(object)array('id' => 6,
							  'title' => 'onLine_payment'
							),
			);
			$this->data['mail_methods'] = array(
				(object)array('id' => '0',
					'title' => 'AWS'
				),(object)array('id' => 1,
					'title' => 'SMTP'
				)
			);
			$this->data['time_fractions'] = array(
				(object)array('id' =>15, 'title' => '15 minutes'),
				(object)array('id' =>30, 'title' => '30 minutes'),
				(object)array('id' =>45, 'title' => '45 minutes'),
				(object)array('id' =>1, 'title' => '1 hour'),
			);
			$this->data['times'] = $this->getAvailabilityTimaes(false);
			$cisess = $this->session->userdata('_cisess');
			$this->data['membership_type'] = $cisess['membership_type'];
			$html = $this->load->view('advanced_settings/partials/general_settings', $this->data, true);
			echo json_encode(array('html' => $html));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
	public function getSubscriptions(){
		if($this->input->is_ajax_request()) {
			$this->load->model('InvoiceModel');
			$this->data['invoices'] = $this->InvoiceModel->get_owner_items($this->_db_details->id);
			$filters = $this->select_invoices_filter_data($this->data['invoices']);
			$this->data['invoice_id_data'] = isset($filters['invoice_id_data']) ? $filters['invoice_id_data'] : array();
			$this->data['state_data'] = isset($filters['state_data']) ? $filters['state_data'] : array();

			$file_path = FCPATH.'app/plan_fields.json';
			$plan_fields = array();
			if(file_exists($file_path)) {
				$plan_json_fields = file_get_contents($file_path);
				$plan_fields = json_decode($plan_json_fields);
			}
			$this->data['plan_fields'] = $plan_fields;
			$this->data['subscription_type'] = isset($this->_db_details->membership_interval) ? $this->lang->line($this->_db_details->membership_interval) : '';
			$this->data['subscription_plan'] = isset($this->_db_details->membership_type) ? $this->lang->line($this->_db_details->membership_type) : '';

			$html = $this->load->view('advanced_settings/partials/billing_information/subscriptions', $this->data, true);
			echo json_encode(array('html' => $html));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function filterSubscriptionInvoicesByTags(){
		if($this->input->is_ajax_request()){
			
			$selected_invoice_id = $this->input->post('selected_invoice_id', true);
			$selected_state = $this->input->post('selected_state', true);
			$selected_date = $this->input->post('selected_date', true);
			$tags = array(
				'selected_invoice_id' => $selected_invoice_id,
				'selected_state' => $selected_state,
				'selected_date' => $selected_date,
			);

			$this->load->model('InvoiceModel');
			$invoices = $this->InvoiceModel->getItemsByTags($tags);
			echo json_encode(array('data' => $invoices));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	private function select_invoices_filter_data($invoices){


		$invoice_id_data_arr = array();
		$state_data_arr = array();
		if($invoices){
			$count_customer_name = 0;
			foreach ($invoices as $k=>$item){

				$invoice_id_data_arr[$k]['id'] = $item->id;
				$invoice_id_data_arr[$k]['text'] = $item->id;
			}
		}

		//State
		$state_data_arr[0]['id'] = "0";
		$state_data_arr[0]['text'] = $this->lang->line('advanced_settings_due');
		$state_data_arr[1]['id'] = "1";
		$state_data_arr[1]['text'] = $this->lang->line('advanced_settings_cashed');

		$filter['invoice_id_data'] = $invoice_id_data_arr;
		$filter['state_data'] = $state_data_arr;

		return $filter;
	}

	public function updateGeneralSettings(){
		if($this->input->is_ajax_request()) {
			$result = false;
			$user_id =$this->data['userData'][0]->Id;
			$this->load->model('AreasAcademicaModel');
			$this->load->model('Variables2Model');
			$update_data = array(
				'idanno' => $this->input->post('academic_year', true),
				'limite_horas' => $this->input->post('limite_horas', true),
				'porcentaje_faltas' => $this->input->post('absences_limit', true),
				'fracciones' => $this->input->post('time_fraction', true),
				'Fp' => $this->input->post('payment_method', true),
				'allow_group_multicourse' => ($this->input->post("allow_group_multicourse", true) == 'on') ? 1 : 0,
				'allow_group_change_startdate' => ($this->input->post("allow_group_change_startdate", true) == 'on') ? 1 : 0,
				'allow_conflicts_calendars' => ($this->input->post("allow_conflicts_calendars", true) == 'on') ? 1 : 0,
				'allow_notification_show' => ($this->input->post("allow_notification_show", true) == 'on') ? 1 : 0,
			);
			$update_mail_provider = ($this->input->post("mail_provider", true) == 'on') ? 1 : 0;


			$first_hour = $this->input->post('first_hour', true);
			$last_hour = $this->input->post('last_hour', true);

			$this->data['times'] = $this->getAvailabilityTimaes();
			if(isset($this->data['times'][$first_hour]) && isset($this->data['times'][$last_hour])){

				if (strtotime($this->data['times'][$last_hour]) >= strtotime($this->data['times'][$first_hour])) {
					$first_hour_loc = explode(':', $this->data['times'][$first_hour]);
					$last_hour_loc = explode(':', $this->data['times'][$last_hour]);

					if(isset($first_hour_loc[0]) && isset($first_hour_loc[1]) && isset($last_hour_loc[0]) && isset($last_hour_loc[1]) ) {
						$update_data['Inicio'] = $first_hour_loc[0].$first_hour_loc[1];
						$update_data['Fin'] = $last_hour_loc[0].$last_hour_loc[1];
					}
				}
			}
			$result1 = $this->Variables2Model->updateGeneralSettings($update_data);
			$result2 = $this->UsuarioModel->update_mail_provider($user_id, $update_mail_provider);
			if($result1 && $result2){
				$result = true;
			}
			echo json_encode(array('success' => $result));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	// Campus students
	public function campus_students(){
		$this->layouts
			->add_includes('css', 'assets/global/plugins/select2/select2.css')
			->add_includes('js', 'assets/global/plugins/select2/select2.js');
		$this->load->model('GrupoModel');
		$this->data['page'] = 'advanced_settings_campus_students';
		$this->data['campus_students_active'] = $this->_db_details->module_campus_students_active;
        $this->lang->load('quicktips', $this->data['lang']);
        if($this->data['campus_students_active'] == '1' || $this->is_super_admin()){
			$this->layouts->add_includes('js', '/app/js/advanced_settings/campus_students.js');

			$this->data['campus_students'] = $this->AlumnoModel->get_campus_students();
			$this->data['campus_students_max_users'] = $this->_db_details->module_campus_students_max_users;
			$this->data['group_data'] = $this->GrupoModel->getGroupsName();
			$this->layouts->view('advanced_settings/campus_students', $this->data);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function getCampusStudents(){
		$start =$this->input->post('start',  true);
		$length =$this->input->post('length', true);
		$draw = $this->input->post('draw', true);
		$search =$this->input->post('search', true);
		$order = $this->input->post('order', true);
		$columns = $this->input->post('columns', true);

		$filter_tags = (object)array(
			'selected_groups' => $this->input->post('selected_groups', true)
		);
		$column = $order[0]['column'];
		$total_students = $this->AlumnoModel->getTotalCount();
		//$total_records = $total_students;

		$student_data = $this->AlumnoModel->get_campus_students_ajax($start, $length, $draw, $search, $order, $columns, $filter_tags);
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

	public function change_campus_students_status(){
		if($this->input->is_ajax_request()) {
			$student_ids = $this->input->post('student_ids', true);
			$status = $this->input->post('status', true) == '1' ? 1 : 0;

			$user_limit = $this->_db_details->module_campus_students_max_users;
			$count_active_students = $this->AlumnoModel->conut_active_students();
			if(($status == '1' && (count($student_ids) + $count_active_students) <= $user_limit) || $status == '0') {

				$data = array();
				if(!empty($student_ids) && is_array($student_ids)){
					foreach($student_ids as $id){
						$data[] = array(
							'ccodcli' => $id,
							'enebc' => $status
						);
					}
					$result = $this->AlumnoModel->update_student_data($data);
				}else{
					$result = false;
				}

				if ($result) {
					$data = array('status' => $status, 'msg' => '');
				} else {
					$data = array('status' => -1, 'msg' => '');
				}
			}else{
				$data = array('status' => -1, 'msg' => 'warning_limit_is_finished');
			}
			echo json_encode($data);
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
	public function send_email_student(){
		if($this->input->is_ajax_request()) {
			$this->load->model('ErpEmailModel');
			$email = $this->input->post('email', true);
			$user_id = $this->data['userData'][0]->Id;
			$student_id = $this->input->post('student_id', true);
			$data = array();
			$student_data = $this->AlumnoModel->get_campus_students(array('ccodcli' => $student_id, 'enebc' => 1, 'Email' => $email));
			if(!empty($student_data) && !empty($email)){
				//$expiredate = date('Y-m-d', strtotime('+1 Week'));
				/*$activation_code = base64_encode($expiredate.'+'.$email.'+'.$student_id);
				$href = base_url().'signUp/student_activation/'. urlencode($activation_code);
				$link = '<a href="'. $href .'"> Click here to activate your account </a>';
				$message = ' <p>Hi '. $student_data[0]->user_name. ', </p> <br>  <p>Welcome to Akaud!</p> <br> '. $link . '<br> <p>Regards</p><br>  <p>Akaud Team</p>';*/
				$expiredate = date('Y-m-d', strtotime('+1 Week'));
				$user_role = 'student';
				$user_name = $student_data[0]->user_name;
				$key_code = $this->_db_details->key;
				$code = base64_encode($expiredate.'+'.$user_role.'+'.$student_data[0]->id.'+'.$email.'+'.$user_name.'+'.$key_code );
				$href = base_url().'forgotPassword/index/'. urlencode($code);
				$company = $this->ProfesorModel->get_company_name();


					$this->data['href'] = $href;
					$this->data['user_name'] = $student_data[0]->user_name;
					$this->data['keycode'] = $this->session->userdata("_cisess")['key'];
					$this->data['company_name'] = $company[0]->company_name;
					//$this->lang->load('forget_pass_email', $this->data['lang']);

					$message = $this->load->view('forgot_password/partials/activation_email', $this->data, TRUE);

					//get plan
					$cisess = $this->session->userdata('_cisess');
					$membership_type = $cisess['membership_type'];
					$smtp_data = $this->UsuarioModel->getSmtpSettings($user_id);
					if($membership_type != 'FREE' && $smtp_data->mail_provider == 1){
							if ($smtp_data->auth_method == 0) {
								$smtpSecure = 'ssl';
							} elseif ($smtp_data->auth_method == 1) {
								$smtpSecure = 'ssl';
							} elseif ($smtp_data->auth_method == 2) {
								$smtpSecure = 'tls';
							}

							$mail = new PHPMailer();
							$mail->IsSMTP();                                      // set mailer to use SMTP
							$mail->Host = $smtp_data->hostname;  // specify main and backup server
							$mail->SMTPAuth = true;     // turn on SMTP authentication
							$mail->Port = $smtp_data->port;
							$mail->SMTPSecure = $smtpSecure;
							$mail->Username = $smtp_data->user;  // SMTP username
							$mail->Password = $smtp_data->pwd; // SMTP password

							$mail->From = $smtp_data->user;
							$mail->FromName = $this->data['company_name'];
							$mail->AddAddress($email);
							$mail->WordWrap = 1000;                                 // set word wrap to 50 characters
							$mail->IsHTML(true);
							// set email format to HTML

							$mail->Subject = $this->lang->line('activation_subject_text1') . ' ' . $company[0]->company_name;
							$mail->Body = $message;
							$mail->AltBody = "";
							if (!$mail->Send()) {
								$data = array('status' => false);
								$insert_data['sucess'] = '0';
								$insert_data['error_msg'] = null;
							} else {
								$data = array('status' => true);
								$insert_data['sucess'] = '1';
								$insert_data['error_msg'] = null;
							}

							$this->ErpEmailModel->insertEmailData($insert_data);

					}else {
						$emails_limit_daily = $this->_db_details->emails_limit_daily;
						$emails_limit_monthly = $this->_db_details->emails_limit_monthly;
						$count_emails_day = $this->ErpEmailModel->getEmailsCountDay($user_id);
						if($emails_limit_daily > $count_emails_day->count_daily && $emails_limit_monthly > $count_emails_day->count_monthly  ) {
							$amazon = $this->config->item('amazon');
							$email_from = $this->config->item('email');
							$client = SesClient::factory(array(
								'version' => 'latest',
								'region' => $amazon['email_region'],
								'credentials' => array(
									'key' => $amazon['AWSAccessKeyId'],
									'secret' => $amazon['AWSSecretKey'],
								),
							));
							$request = array();
							$request['Source'] = $email_from['from'];
							$request['Destination']['ToAddresses'] = array($email);
							$request['Message']['Subject']['Data'] = $this->lang->line('activation_subject_text1') . ' ' . $company[0]->company_name;
							$request['Message']['Subject']['Charset'] = "UTF-8";
							$request['Message']['Body']['Html']['Data'] = $message;
							$request['Message']['Subject']['Charset'] = "UTF-8";

							$insert_data = array(
								'from_userid' => $user_id,
								'id_campaign' => '',
								'email_recipie' => $email,
								'Subject' => $this->lang->line('activation_subject_text1') . ' ' . $company[0]->company_name,
								'Body' => $message,
								'date' => date("Y-m-d H:i:s"),
							);

							try {
								$result = $client->sendEmail($request);
								$messageId = $result->get('MessageId');
								//echo("Email sent! Message ID: $messageId"."\n");
								if ($messageId) {
									$data = array('status' => true);
									$insert_data['sucess'] = '1';
									$insert_data['error_msg'] = null;
								} else {
									$data = array('status' => false);
									$insert_data['sucess'] = '0';
									$insert_data['error_msg'] = null;
								}

								$this->ErpEmailModel->insertEmailData($insert_data);
							} catch (Exception $e) {
								//echo("The email was not sent. Error message: ");
								//$response['errors'] = $e->getMessage()."\n";
								$insert_data['sucess'] = '0';
								$insert_data['error_msg'] = $e->getMessage();
								$data = array('status' => false);
								$this->ErpEmailModel->insertEmailData($insert_data);
							}
						}else{
							$data = array('error_msg' => $this->lang->line('emails_limit_daily_msg'));
						}
					}
			}else{
				$data = array('error_msg' => sprintf($this->lang->line('invalid_email'), ''));
			}

			echo json_encode($data);
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
	public function send_email_students(){
		if($this->input->is_ajax_request()) {
			$this->load->model('ErpEmailModel');
			$students_info = $this->input->post('students_info', true);
			$response['success'] = false;
			$response['errors'] = false;
			$user_id = $this->data['userData'][0]->Id;
			if(!empty($students_info)) {
				foreach ($students_info as $student) {
					$id = isset($student['id']) ? $student['id'] : null;
					$email = isset($student['email']) ? $student['email'] : null;
					$student_data = $this->AlumnoModel->get_campus_students(array('ccodcli' => $id, 'enebc' => 1, 'Email' => $email));
					if (!empty($student_data) && !empty($email)) {
						$count_emails_day = $this->ErpEmailModel->getEmailsCountDay($user_id);

						/*$expiredate = date('Y-m-d', strtotime('+1 Week'));
						$activation_code = base64_encode($expiredate . '+' . $email . '+' . $id);
						$href = base_url() . 'signUp/student_activation/' . urlencode($activation_code);
						$link = '<a href="' . $href . '"> Click here to activate your account </a>';
						$message = ' <p>Hi ' . $student_data[0]->user_name . ', </p> <br>  <p>Welcome to Akaud!</p> <br> ' . $link . '<br> <p>Regards</p><br>  <p>Akaud Team</p>';*/
						$expiredate = date('Y-m-d', strtotime('+1 Week'));
						$user_role = 'student';
						$user_name = $student_data[0]->user_name;
						$key_code = $this->_db_details->key;
						$code = base64_encode($expiredate.'+'.$user_role.'+'.$student_data[0]->id.'+'.$email.'+'.$user_name.'+'.$key_code);
						$href = base_url() . 'forgotPassword/index/' . urlencode($code);

						$company = $this->ProfesorModel->get_company_name();

						$this->data['href'] = $href;
						$this->data['user_name'] = $student_data[0]->user_name;
						$this->data['keycode'] = $this->session->userdata("_cisess")['key'];
						$this->data['company_name'] = $company[0]->company_name;
						//$this->lang->load('forget_pass_email', $this->data['lang']);

						$message = $this->load->view('forgot_password/partials/activation_email', $this->data, TRUE);

						//get plan
						$cisess = $this->session->userdata('_cisess');
						$membership_type = $cisess['membership_type'];
						$smtp_data = $this->UsuarioModel->getSmtpSettings($user_id);
						if($membership_type != 'FREE' && $smtp_data->mail_provider == 1){
								if ($smtp_data->auth_method == 0) {
									$smtpSecure = 'ssl';
								} elseif ($smtp_data->auth_method == 1) {
									$smtpSecure = 'ssl';
								} elseif ($smtp_data->auth_method == 2) {
									$smtpSecure = 'tls';
								}

								$mail = new PHPMailer();
								$mail->IsSMTP();                                      // set mailer to use SMTP
								$mail->Host = $smtp_data->hostname;  // specify main and backup server
								$mail->SMTPAuth = true;     // turn on SMTP authentication
								$mail->Port = $smtp_data->port;
								$mail->SMTPSecure = $smtpSecure;
								$mail->Username = $smtp_data->user;  // SMTP username
								$mail->Password = $smtp_data->pwd; // SMTP password

								$mail->From = $smtp_data->user;
								$mail->FromName = $this->data['company_name'];
								$mail->AddAddress($email);
								$mail->WordWrap = 1000;                                 // set word wrap to 50 characters
								$mail->IsHTML(true);
								// set email format to HTML

								$mail->Subject = $this->lang->line('activation_subject_text1') . ' ' . $company[0]->company_name;
								$mail->Body = $message;
								$mail->AltBody = "";
								if (!$mail->Send()) {
									$response['errors'][] = sprintf($this->lang->line('advanced_settings_activation_code_no_sent'), $email);
									$insert_data['sucess'] = '0';
									$insert_data['error_msg'] = null;
								} else {
									$response['success'][] = sprintf($this->lang->line('advanced_settings_activation_code_sent'), $email);
									$insert_data['sucess'] = '1';
									$insert_data['error_msg'] = null;
								}

								$this->ErpEmailModel->insertEmailData($insert_data);
						}else {
							$emails_limit_daily = $this->_db_details->emails_limit_daily;
							$emails_limit_monthly = $this->_db_details->emails_limit_monthly;
							$count_emails_day = $this->ErpEmailModel->getEmailsCountDay($user_id);
							if($emails_limit_daily > $count_emails_day->count_daily && $emails_limit_monthly > $count_emails_day->count_monthly  ) {
								$amazon = $this->config->item('amazon');
								$email_from = $this->config->item('email');

								$client = SesClient::factory(array(
									'version' => 'latest',
									'region' => $amazon['email_region'],
									'credentials' => array(
										'key' => $amazon['AWSAccessKeyId'],
										'secret' => $amazon['AWSSecretKey'],
									),
								));
								$request = array();
								$request['Source'] = $email_from['from'];
								$request['Destination']['ToAddresses'] = array($email);
								$request['Message']['Subject']['Data'] = $this->lang->line('activation_subject_text1') . ' ' . $company[0]->company_name;
								$request['Message']['Subject']['Charset'] = "UTF-8";
								$request['Message']['Body']['Html']['Data'] = $message;
								$request['Message']['Subject']['Charset'] = "UTF-8";

								$insert_data = array(
									'from_userid' => $user_id,
									'id_campaign' => '',
									'email_recipie' => $email,
									'Subject' => $this->lang->line('activation_subject_text1') . ' ' . $company[0]->company_name,
									'Body' => $message,
									'date' => date("Y-m-d H:i:s"),
								);

								try {
									$result = $client->sendEmail($request);
									$messageId = $result->get('MessageId');
									//echo("Email sent! Message ID: $messageId"."\n");
									if ($messageId) {
										$response['success'][] = sprintf($this->lang->line('advanced_settings_activation_code_sent'), $email);
										$insert_data['sucess'] = '1';
										$insert_data['error_msg'] = null;
									} else {
										$response['errors'][] = sprintf($this->lang->line('advanced_settings_activation_code_no_sent'), $email);
										$insert_data['sucess'] = '0';
										$insert_data['error_msg'] = sprintf($this->lang->line('advanced_settings_activation_code_no_sent'), $email);
									}

									$this->ErpEmailModel->insertEmailData($insert_data);
								} catch (Exception $e) {
									//echo("The email was not sent. Error message: ");
									//$response['errors'] = $e->getMessage()."\n";
									$insert_data['sucess'] = '0';
									$insert_data['error_msg'] = $e->getMessage();
									$response['errors'][] = $this->lang->line('advanced_settings_activation_code_for') . $email . " " . $e->getMessage();
									$this->ErpEmailModel->insertEmailData($insert_data);
								}
							}else{
								$response['errors'][] = $this->lang->line('advanced_settings_activation_code_for') . $email . " " . $this->lang->line('emails_limit_daily_msg');
							}
						}
					} else {
						if (!empty($email)) {
							$response['errors'][] = sprintf($this->lang->line('advanced_settings_activation_code_locked'), $email);
						} else {
							$response['errors'][] = sprintf($this->lang->line('invalid_email'), '');
						}
					}
				}
			}
			echo json_encode($response);
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function import_external_data(){
        $this->lang->load('quicktips', $this->data['lang']);
        $this->data['page']='advanced_settings_import_external_data';
		$this->layouts->add_includes('css', 'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
		$this->layouts->add_includes('css', 'assets/global/css/steps.css');
//		$this->layouts->add_includes('css', 'assets/global/css/plugins.min.css');
		$this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js');
		$this->layouts->add_includes('js', 'app/js/advanced_settings/import_external_data.js');


		$this->layouts->view('advanced_settings/import_external_data', $this->data);
	}
	public function ied_steps(){
		$html = '';
		$step_id = $this->input->post('step_id', true);
		$fields = $this->input->post('form_data', true);
		$import_model_id = $this->input->post('import_model_id', true);

		if(!empty($step_id)){
			$this->data['import_models'] = $this->ErpMappingOptionModel->getImportModels();
			switch ($step_id) {
				case 1:
					$html .= $this->load->view('advanced_settings/partials/ied_steps/step1.php', $this->data, true);
					break;
				case 2:
					$html .= $this->load->view('advanced_settings/partials/ied_steps/step2.php', $this->data, true);
					break;
				case 3:
					$this->data['fields'] = $fields;
					$this->data['import_model_id'] = $import_model_id;
					$html .= $this->load->view('advanced_settings/partials/ied_steps/step3.php', $this->data, true);
					break;
				default:
			}
		}

		print_r(json_encode($html));
		exit;
	}
	
	public function get_file_fields(){
		$response['success'] = false;
		$response['errors'] = false;
		$response['data_arr'] = false;
		$response['_html'] = '';
		$response['fields'] = false;
		if($this->input->is_ajax_request()){
			$import_model_id = $this->input->post('import_model_id', true);
			$delimiter = $this->input->post('delimiter', true);
			if(isset($_FILES['import_file-0'])){
				$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv', 'application/octet-stream');

				if(in_array($_FILES['import_file-0']['type'],$mimes)){

					// Set path to CSV file
					$inputFileName = $_FILES['import_file-0']['tmp_name'];

					//  Read your Excel workbook
					try {
						$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
						$objReader = PHPExcel_IOFactory::createReader($inputFileType);
						if($delimiter == '2') {
							$objReader->setDelimiter(';');
						}
						$objPHPExcel = $objReader->load($inputFileName);
						//  Get worksheet dimensions
						$sheet = $objPHPExcel->getSheet(0);
						$highestRow = $sheet->getHighestRow();
						$highestColumn = $sheet->getHighestColumn();

						//  Loop through each row of the worksheet in turn
						$items_count  = 0;
						for ($row = 1; $row <= $highestRow; $row++){
							//  Read a row of data into an array
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
								NULL,
								TRUE,
								FALSE);
							if(isset($rowData[0])){
								$response['data_arr'][] = $rowData[0];
							}

							//  Insert row data array into your database of choice here
						}
						if(!empty($response['data_arr'][0])){							
							$response['fields'] = array_unique($response['data_arr'][0]);
						}
						$response['items_count'] = $highestRow - 1;
						$this->data['import_data'] = $response;
						$this->data['fields'] = $this->ErpMappingOptionModel->getFieldsById($import_model_id);
						$response['_html'] .= $this->load->view('advanced_settings/partials/ied_mapping_fields.php', $this->data, true);

						$response['success'] = $this->lang->line('advanced_settings_select_columns');

					} catch(Exception $e) {
						$response['errors'][] = $this->lang->line('db_err_msg'). " ".pathinfo($inputFileName,PATHINFO_BASENAME). " " . $e->getMessage();
					}

				} else {
					$response['errors'][] = $this->lang->line('mime_type_not_allowed');
				}
			}else{
				$response['errors'][] = $this->lang->line('db_err_msg');
			}
		}
		echo json_encode($response);
		exit;
	}
	
	public function import_external_data_finish(){
		$response['success'] = false;
		$response['errors'] = false;
		$response['validate_error'] = false;
		$response['inserted_count'] = false;
		$response['updated_count'] = false;
		$response['exist_items'] = 0;
		if($this->input->is_ajax_request()){
			$post_data = $this->input->post(null, true);


			if(isset($post_data['form_data']) && !empty($post_data['form_data'])){
				$items = array();
				foreach ($post_data['data_arr'] as $index => $value) {
					if($index != 0){
						foreach ($value as $index2 => $value2) {
							$items[$index-1][$post_data['data_arr'][0][$index2]] = $value2;
						}
					}
				}

				$insert_db_data = array();
				foreach ($items as $index => $value) {
					foreach ($post_data['form_data'] as $i=>$val){
						if(isset($value[$i]) && !empty($val)){
							$insert_db_data[$index][$val] = $value[$i];
						}
					}
				}
				$cc_fields = null;
				$replace_data = false;
				if(isset($post_data['q1']) && $post_data['q1']){
					if(isset($post_data['cc_fields'])){
						$cc_fields = $post_data['cc_fields'];
						if($post_data['check_fields'] == 1){
							$replace_data = true;
						}
					}
				}
				if(!empty($insert_db_data)){
					if(isset($post_data['import_model_id'])){
						$inserted_count = 0;
						$updated_count = 0;
						foreach ($insert_db_data as $i_data){
							$where = array();
							if($replace_data){
								foreach ($cc_fields as $cc_field){
									if(isset($i_data[$cc_field])){
										$where[$cc_field] = $i_data[$cc_field];
									}
								}
							}

							switch ($post_data['import_model_id']){
								case 1: //Students
									$this->config->set_item('language', $this->data['lang']);
									$this->form_validation->set_data($i_data);
									$this->form_validation->set_rules('snombre', $this->lang->line('first_name'), 'trim|required');
									if ($this->form_validation->run() == false) {
										$response["validate_error"] = validation_errors();
									} else {
										$this->load->model('AlumnoModel');
										$exist_datas = array();
										if(!empty($where)){
											$exist_datas = $this->AlumnoModel->getAll('', $where);
										}
										if(!empty($exist_datas)){
											foreach($exist_datas as $exist_data){
												$update_data = $this->AlumnoModel->makeUpdateData($i_data);
												$updated = $this->AlumnoModel->updateItemById($update_data, $exist_data->Id);
												if($updated){
													$updated_count++;
													if(!$response['success']){
														$response['success'] = $this->lang->line('data_success_saved');
													}
													$response['updated_count'] = $updated_count;
												}
											}
//											$response['exist_items'] += count($exist_datas);
										}else{
											$this->load->model('AlumnoTabAdModel');
											$personalized_data = $this->AlumnoTabAdModel->get_personalized_data();
											$insert_personalized = array();
											if(!empty($personalized_data)){
												foreach($personalized_data as $personalized){
													if(isset($i_data[$personalized->name])){
														$insert_personalized[$personalized->name] =  $i_data[$personalized->name];
													}

												}
											}
											$this->load->model('Variables2Model');
											if($this->Variables2Model->updateNumStudent()){
												$id = $this->Variables2Model->getNumStudent();
												$i_data['ccodcli'] = $id[0]->numalumno;
												//$post_data['photo'] = $get_image;
												$insert_data = $this->AlumnoModel->makeInsertData($i_data);
												if($this->AlumnoModel->insertStudent($insert_data)){
													$inserted_count++;
													if(!$response['success']){
														$response['success'] = $this->lang->line('data_success_saved');
													}
													$response['inserted_count'] = $inserted_count;
													$insert_personalized['ccodcli'] = $i_data['ccodcli'];
													try{
														$this->AlumnoTabAdModel->insertFormData($insert_personalized);
													}catch (\Exception $er){

													}
												}
											}
										}
									}
									break;
								case 2: //Companies
									$this->config->set_item('language', $this->data['lang']);
									$this->form_validation->set_data($i_data);
									$this->form_validation->set_rules('cnomcli', $this->lang->line('fiscal_name'), 'trim|required');
									if ($this->form_validation->run() == false) {
										$response["validate_error"] = validation_errors();
									} else {
										$this->load->model('ClientModel');
										$exist_datas = array();
										if(!empty($where)){
											$exist_datas = $this->ClientModel->getAll('', $where);
										}
										if(!empty($exist_datas)){
											foreach($exist_datas as $exist_data){
												$update_data = $this->ClientModel->makeUpdateData($i_data);
												$updated = $this->ClientModel->updateItem($update_data, $exist_data->CCODCLI);
												if($updated){
													$updated_count++;
													if(!$response['success']){
														$response['success'] = $this->lang->line('data_success_saved');
													}
													$response['updated_count'] = $updated_count;
												}
											}
//											$response['exist_items'] += count($exist_datas);
										}else{
											$this->load->model('ClientesTabAdModel');
											$personalized_data = $this->ClientesTabAdModel->get_personalized_data();
											$insert_personalized = array();
											if(!empty($personalized_data)){
												foreach($personalized_data as $personalized){
													if(isset($i_data[$personalized->name])){
														$insert_personalized[$personalized->name] =  $i_data[$personalized->name];
													}

												}
											}
											$this->load->model('Variables2Model');
											if($this->Variables2Model->updateNumClient()){
												$id = $this->Variables2Model->getNumClient();
												$i_data['ccodcli'] = $id[0]->NumCliente;

												$this->load->model('ClientModel');
												$insert_data = $this->ClientModel->makeInsertData($i_data);
												if($this->ClientModel->insertClient($insert_data)){
													$inserted_count++;
													if(!$response['success']){
														$response['success'] = $this->lang->line('data_success_saved');
													}
													$response['inserted_count'] = $inserted_count;
													$insert_personalized['ccodcli'] = $i_data['ccodcli'];
													try{
														$this->ClientesTabAdModel->insertFormData($insert_personalized);
													}catch (\Exception $er){

													}
												}
											}
										}
									}
									break;
								case 3: //Teachers
									$this->config->set_item('language', $this->data['lang']);
									$this->form_validation->set_data($i_data);
									$this->form_validation->set_rules('snombre', $this->lang->line('first_name'), 'trim|required');
									$this->form_validation->set_rules('sapellidos', $this->lang->line('surname'), 'trim|required');
									if ($this->form_validation->run() == false) {
										$response["validate_error"] = validation_errors();
									} else {

										$this->load->model('ProfesorModel');
										$exist_datas = array();
										if(!empty($where)){
											$exist_datas = $this->ProfesorModel->getAll('', $where);
										}
										if(!empty($exist_datas)){
											foreach($exist_datas as $exist_data){
												$update_data = $this->ProfesorModel->makeUpdateData($i_data);

												$updated = $this->ProfesorModel->updateItem($update_data, $exist_data->INDICE);
												if($updated){
													$updated_count++;
													if(!$response['success']){
														$response['success'] = $this->lang->line('data_success_saved');
													}
													$response['updated_count'] = $updated_count;
												}
											}
//											$response['exist_items'] += count($exist_datas);
										}else{

											$this->load->model('ProfesoresTabAdModel');

											$personalized_data = $this->ProfesoresTabAdModel->get_personalized_data();
											$insert_personalized = array();
											if(!empty($personalized_data)){
												foreach($personalized_data as $personalized){
													if(isset($i_data[$personalized->name])){
														$insert_personalized[$personalized->name] =  $i_data[$personalized->name];
													}

												}
											}
											$this->load->model('Variables2Model');
											if($this->Variables2Model->updateNumProfesor()){
												$id = $this->Variables2Model->getNumProfesor();
												$i_data['indice'] = $id[0]->numprofesor;

												$insert_data = $this->ProfesorModel->makeInsertData($i_data);
												if($this->ProfesorModel->insertTeacher($insert_data)){
													$inserted_count++;
													if(!$response['success']){
														$response['success'] = $this->lang->line('data_success_saved');
													}
													$response['inserted_count'] = $inserted_count;
													$insert_personalized['indice'] = $i_data['indice'];
													try{
														$this->ProfesoresTabAdModel->insertFormData($insert_personalized);
													}catch (\Exception $er){

													}
												}
											}
										}

									}

									break;
								case 4: //Courses
									$this->lang->load('courses', $this->data['lang']);
									$this->config->set_item('language', $this->data['lang']);
									$this->form_validation->set_data($i_data);
									$config = array(
										array(
											'field' => 'codigo',
											'label' => $this->lang->line('courses_reference'),
											'rules' => 'trim|required'
										),
										array(
											'field' => 'curso',
											'label' => $this->lang->line('courses_title_course'),
											'rules' => 'trim|required'
										),
										array(
											'field' => 'horas',
											'label' => $this->lang->line('courses_hours'),
											'rules' => 'trim|is_numeric'
										),
										array(
											'field' => 'creditos',
											'label' => $this->lang->line('courses_credits'),
											'rules' => 'trim|is_numeric'
										)
									);
									$this->form_validation->set_rules($config);									
									if ($this->form_validation->run() == false) {
										$response["validate_error"] = validation_errors();
									} else {

										$this->load->model('CursoModel');
										$exist_datas = array();
										if(!empty($where)){
											$exist_datas = $this->CursoModel->getAll('', $where);
										}
										if(!empty($exist_datas)){
											foreach($exist_datas as $exist_data){
												$update_data = $this->CursoModel->makeUpdateData($i_data);

												$updated = $this->CursoModel->updateItem($exist_data->codigo, $update_data);
												if($updated){
													$updated_count++;
													if(!$response['success']){
														$response['success'] = $this->lang->line('data_success_saved');
													}
													$response['updated_count'] = $updated_count;
												}
											}
//											$response['exist_items'] += count($exist_datas);
										}else{

											$this->load->model('CursoTabAdModel');

											$personalized_data = $this->CursoTabAdModel->get_personalized_data();
											$insert_personalized = array();
											if(!empty($personalized_data)){
												foreach($personalized_data as $personalized){
													if(isset($i_data[$personalized->name])){
														$insert_personalized[$personalized->name] =  $i_data[$personalized->name];
													}
												}
											}

											$insert_data = $this->CursoModel->makeInsertData($i_data);
//										$insert_data['estado'] = 1; //active by default
											$inserted = $this->CursoModel->insertItem($insert_data);
											if($inserted){
												$inserted_count++;
												if(!$response['success']){
													$response['success'] = $this->lang->line('data_success_saved');
												}
												$response['inserted_count'] = $inserted_count;
												$insert_personalized['codigo'] = $i_data['codigo'];
												try{
													$this->CursoTabAdModel->insertFormData($insert_personalized);
												}catch (\Exception $er){

												}
											}	
										}
									}
									break;
								case 5: //Contacts
									$this->config->set_item('language', $this->data['lang']);
									$this->form_validation->set_data($i_data);
									$this->form_validation->set_rules('snombre', $this->lang->line('first_name'), 'trim|required');
									$this->form_validation->set_rules('sapellidos', $this->lang->line('surname'), 'trim|required');
									if ($this->form_validation->run() == false) {
										$response["validate_error"] = validation_errors();
									} else {
										$this->load->model('ContactosModel');
										$exist_datas = array();
										if(!empty($where)){
											$exist_datas = $this->ContactosModel->getAll('', $where);
										}
										if(!empty($exist_datas)){
											foreach($exist_datas as $exist_data){
												$update_data = $this->ContactosModel->makeUpdateData($i_data);
												$updated = $this->ContactosModel->updateItemById($update_data, $exist_data->Id);
												if($updated){
													$updated_count++;
													if(!$response['success']){
														$response['success'] = $this->lang->line('data_success_saved');
													}
													$response['updated_count'] = $updated_count;
												}
											}
										}else{
											$this->load->model('ContactosTabAdModel');
											$personalized_data = $this->ContactosTabAdModel->get_personalized_data();
											$insert_personalized = array();
											if(!empty($personalized_data)){
												foreach($personalized_data as $personalized){
													if(isset($i_data[$personalized->name])){
														$insert_personalized[$personalized->name] =  $i_data[$personalized->name];
													}

												}
											}

											$insert_data = $this->ContactosModel->makeInsertData($i_data);
											$inserted_id = $this->ContactosModel->insertItem($insert_data);
											if($inserted_id){
												$inserted_count++;
												if(!$response['success']){
													$response['success'] = $this->lang->line('data_success_saved');
												}
												$response['inserted_count'] = $inserted_count;
												$insert_personalized['Id'] = $inserted_id;
												try{
													$this->ContactosTabAdModel->insertFormData($insert_personalized);
												}catch (\Exception $er){

												}
											}

										}
									}
									break;
								default:

							}
						}
					}else{
						$response['errors'][] = $this->lang->line('db_err_msg');
					}
				}else{
					$response['errors'][] = $this->lang->line('db_err_msg');
				}

			}else{
				$response['errors'][] = $this->lang->line('db_err_msg');
			}
		}
		echo json_encode($response);
		exit;
	}

	public function email_settings(){
		$this->load->model('ErpEmailModel');
        $this->lang->load('quicktips', $this->data['lang']);
        $this->data['page']='advanced_settings_email_settings';
		$this->layouts
					->add_includes('css', 'assets/global/plugins/jquery-ui/jquery-ui.min.css')

					->add_includes('js', 'assets/global/plugins/amcharts/amcharts/amcharts.js')
					->add_includes('js', 'assets/global/plugins/amcharts/amcharts/serial.js')
					->add_includes('js', 'assets/global/plugins/amcharts/amcharts/pie.js')
					->add_includes('js', 'assets/global/plugins/amcharts/amcharts/radar.js')
					->add_includes('js', 'assets/global/plugins/amcharts/amcharts/themes/light.js')
					->add_includes('js', 'assets/global/plugins/amcharts/amcharts/themes/patterns.js')
					->add_includes('js', 'assets/global/plugins/amcharts/amcharts/themes/chalk.js')
					->add_includes('js', 'assets/global/plugins/amcharts/ammap/ammap.js')
					->add_includes('js', 'assets/global/plugins/amcharts/ammap/maps/js/worldLow.js')
					->add_includes('js', 'assets/global/plugins/amcharts/amstockcharts/amstock.js')
					->add_includes('js', 'assets/global/plugins/jquery-ui/jquery-ui.min.js')
					->add_includes('js', 'app/js/advanced_settings/email_settings.js');


		$user_id = $this->session->userdata('userData')[0]->Id;

		$this->data['emails_limit_daily'] = $this->_db_details->emails_limit_daily;
		$this->data['emails_limit_monthly'] = $this->_db_details->emails_limit_monthly;
		$this->data['count_emails'] = $this->ErpEmailModel->getEmailsCountDay($user_id);
		$this->data['emails_remaining_daily'] = (int)$this->data['emails_limit_daily'] - (int)$this->data['count_emails']->count_daily;
		$this->data['emails_remaining_monthly'] = (int)$this->data['emails_limit_monthly'] - (int)$this->data['count_emails']->count_monthly;
			//vardump($this->data['count_emails']);exit;
		$this->layouts->view('advanced_settings/email_settings', $this->data);
	}

	public function getEmailsByPeriod(){
		if($this->input->is_ajax_request()) {
			$this->load->model('ErpEmailModel');
			$user_id = $this->session->userdata('userData')[0]->Id;

			$this->data['emails_limit_daily'] = $this->_db_details->emails_limit_daily;
			$this->data['emails_limit_monthly'] = $this->_db_details->emails_limit_monthly;
			$this->data['count_emails_day'] = $this->ErpEmailModel->getEmailsCountDay($user_id);

			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$emails_data = array();
			if($this->checkingStartEndDate($start_date, $end_date)){
				$emails_data = $this->ErpEmailModel->getEmailsByPeriod($start_date, $end_date);
			}
			echo json_encode(array('data' => $emails_data));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function getNotSentEmails(){
		if($this->input->is_ajax_request()) {
			$this->load->model('ErpEmailModel');
			$user_id = $this->session->userdata('userData')[0]->Id;
			$emails_data = $this->ErpEmailModel->getNotSentEmails($user_id);
			echo json_encode(array('data' => $emails_data));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	private function checkingStartEndDate($start_date, $end_date){
		if(!empty($start_date) && !empty($end_date)) {
			$format = 'Y-m-d';
			$s_d = DateTime::createFromFormat($format, $start_date);
			$e_d = DateTime::createFromFormat($format, $end_date);
			//Check for valid date in given format
			if ($s_d && $s_d->format($format) == $start_date && $e_d && $e_d->format($format) == $end_date) {
				if (strtotime($start_date) < strtotime($end_date)) {
					return true;
				}
			}
		}
		return false;
	}
	public function getSmtpSettings(){
		if($this->input->is_ajax_request()) {
			$this->load->model('UsuarioModel');
			$user_id = $this->data['userData'][0]->Id;
			if($user_id){
				$result = $this->UsuarioModel->getSmtpSettings($user_id);
				echo json_encode(array('result'=>$result));
			}else{
				echo json_encode(array('session_empty'=>true));
			}
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function setSmtpSettings(){
		if($this->input->is_ajax_request()) {
			$this->load->model('UsuarioModel');
			$user_id = $this->data['userData'][0]->Id;
			if($user_id){
				if($this->input->post()) {
					$this->form_validation->set_rules('hostname', $this->lang->line('advanced_settings_hostname'), 'trim|required');
					$this->form_validation->set_rules('user', $this->lang->line('username'), 'trim|required');
					$this->form_validation->set_rules('pwd', $this->lang->line('password'), 'trim|required');
					$this->form_validation->set_rules('port', $this->lang->line('advanced_settings_port'), 'trim|required');
					if($this->form_validation->run()) {
						$update_data = array(
							'hostuser' => $this->input->post('hostname', true) ? $this->input->post('hostname', true) : '',
							'user' => $this->input->post('user', true) ? $this->input->post('user', true) : '',
							'pwd' => $this->input->post('pwd', true) ? $this->input->post('pwd', true) : '',
							'port' => $this->input->post('port', true) ? $this->input->post('port', true) : '',
							'mail_provider' => 1,
							'autenticado' => $this->input->post('smtp_security', true) ? $this->input->post('smtp_security', true) : '0'
						);
						$result = $this->UsuarioModel->setSmtpSettings($user_id, $update_data);
						echo json_encode(array('success' => $result));
					}else{
						$errors=  $this->form_validation->error_array();
						echo json_encode(array('errors'=>$errors));
					}
				}
			}else{
				echo json_encode(array('session_empty'=>true));
			}
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function sendTestEmail(){
		if($this->input->is_ajax_request()) {
			$response = array();
			$this->load->model('UsuarioModel');
			$user_id = $this->data['userData'][0]->Id;
			if($user_id){
				$this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email');
				$this->form_validation->set_rules('hostname', $this->lang->line('advanced_settings_hostname'), 'trim|required');
				$this->form_validation->set_rules('user', $this->lang->line('username'), 'trim|required');
				$this->form_validation->set_rules('pwd', $this->lang->line('password'), 'trim|required');
				$this->form_validation->set_rules('port', $this->lang->line('advanced_settings_port'), 'trim|required');
				if($this->form_validation->run()) {
					$company = $this->ProfesorModel->get_company_name();
					$school_name = $company[0]->company_name;
					$email = $this->input->post('email', true) ? $this->input->post('email', true) : '';
					$sequre = $this->input->post('smtp_security', true) ? $this->input->post('smtp_security', true) : '';
					$config = array(
						'protocol' => "smtp",
						'smtp_host' => $this->input->post('hostname', true) ? $this->input->post('hostname', true) : '',
						'smtp_user' => $this->input->post('user', true) ? $this->input->post('user', true) : '',
						'smtp_pass' => $this->input->post('pwd', true) ? $this->input->post('pwd', true) : '',
						'smtp_port' => $this->input->post('port', true) ? $this->input->post('port', true) : ''
					);
					if($sequre == 0){
						$config['SMTPSecure']='ssl';
					}else if($sequre == 1){
						$config['SMTPSecure']='ssl';
					}else if($sequre == 2){
						$config['SMTPSecure']='tls';
					}

					$mail = new PHPMailer();

					$mail->IsSMTP();                                      // set mailer to use SMTP
					$mail->Host = $config['smtp_host'];  // specify main and backup server
					$mail->SMTPAuth = true;     // turn on SMTP authentication
					$mail->Port = $config['smtp_port'];
					$mail->SMTPSecure = $config['SMTPSecure'];
					$mail->Username = $config['smtp_user'];  // SMTP username
					$mail->Password = $config['smtp_pass']; // SMTP password

					$mail->From = $config['smtp_user'];
					$mail->FromName = $school_name;
					$mail->AddAddress($email);
					$mail->WordWrap = 50;                                 // set word wrap to 50 characters
					$mail->IsHTML(true);
						// set email format to HTML

					$mail->Subject = $this->lang->line('advanced_settings_test_email_subject');
					$mail->Body    = $this->lang->line('advanced_settings_test_email_body');
					$mail->AltBody = "";
//					$mail->SMTPDebug = 1;
					if(!$mail->Send()) {
						$response['success'] = false;
					}else {
						$response['success'] =true;
					}
				}else{
					$response['errors'] =  $this->form_validation->error_array();
				}
				echo json_encode($response);
			}else{
				echo json_encode(array('session_empty'=>true));
			}
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
}
