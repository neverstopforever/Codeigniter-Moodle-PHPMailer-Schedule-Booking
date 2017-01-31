<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *@property magaModel $magaModel
 *@property UsuarioModel $UsuarioModel
 */
class User extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->model('UsuarioModel');
		$this->load->model('ProfesorModel');
		$this->load->model('AlumnoModel');
		$this->layouts->add_includes('js', 'app/js/user/main.js');
		if (empty($this->_identity['loggedIn'])) {
			redirect('/auth/login/', 'refresh');
		}
	}
    public function account()
	{

		$this->load->model('ErpFileSizesModel');
        $this->layouts->add_includes('js', 'assets/global/scripts/app.min.js');
		$this->layouts->add_includes('js', 'assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js');
		$this->layouts->add_includes('js', 'app/js/user/account.js');
		$this->layouts->add_includes('css', 'assets/pages/css/pricing.min.css');
		$this->data['page'] = 'account';
		$this->data['plan_data'] = array();
		$file_path = FCPATH.'app/plan_desc.json';
		if(file_exists($file_path)) {
			$plan_json_data = file_get_contents($file_path);
			$this->data['plan_data'] = json_decode($plan_json_data);
		}

		$this->data['max_users'] = $this->_db_details->concurrent_users;
		$this->data['users'] = count($this->UsuarioModel->get_users('active=1'));
		$this->data['users_procent'] = $this->data['users'] &&  $this->data['max_users'] ? ($this->data['users'] * 100)/$this->data['max_users'] : 0;


		$this->data['max_file_space'] = $this->formatBytes($this->_db_details->space_limit);
		$file_space = $this->ErpFileSizesModel->getTotalSize();
		$this->data['all_file_space'] = $file_space->total ?  (($file_space->total/1024)/1024)/1024 : 0;
		$this->data['file_space_procent'] = $this->data['all_file_space'] >= 1 ? ($this->data['all_file_space']*100 )/ $this->data['max_file_space'] : 0;
		$this->data['total_file_space'] = $file_space->total > 0 ? $this->formatBytes($file_space->total) : 0;
		$this->data['records_limit'] = $this->_db_details->records_limit;

		$this->data['used_records'] = $this->UsuarioModel->getRecords($this->_db_details->DBHost_db);
		$this->data['used_records'] = isset($this->data['used_records'][0]->Num_rows) ? $this->data['used_records'][0]->Num_rows : 1;
		$this->data['records_procent'] = ($this->data['used_records']*100)/$this->data['records_limit'] > 0 ? ($this->data['used_records']*100)/$this->data['records_limit'] : 0;
		$this->data['records_limit'] = $this->formatRecords($this->data['records_limit']);
		$this->data['used_records'] = $this->formatRecords($this->data['used_records']);

		$this->data['user_plan'] = isset($this->_db_details->plan) ? $this->_db_details->plan : null;
		//exit;
		$this->layouts->view('accountView', $this->data);

	}

	private function formatBytes($bytes, $precision = 2){
		//$units = array('B', 'KB', 'MB', 'GB', 'TB');
		$s = array('B', 'Kb', 'MB', 'GB', 'TB', 'PB');
		$e = floor(log($bytes)/log(1024));
		$result = $bytes/pow(1024, floor($e));
		$result_exp = explode('.', $result);
		$type = '%.2d';
		if(isset($result_exp[1]) && $result_exp[1]){
			$type = '%.2f';
		}
		return sprintf($type.$s[$e], ($bytes/pow(1024, floor($e))));

	}

	private function formatRecords($records){
		$result = $records;
		if($records > 1000 && $records < 1000000){
			$result = round($records/1000).'K';
		}elseif($records > 1000000 ){
			$result = round($records/1000000).'M';
		}
		return $result;
	}

	public function profile($id)
	{
		if($id) {
			$this->layouts->add_includes('css', 'assets/css/jasny-bootstrap.min.css');
			$this->layouts
				->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
				->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
				->add_includes('js', 'app/js/user/profile.js');
			$this->data['page'] = 'profile';
			$this->data['id'] = $id;
			$this->data['is_owner'] = $this->is_owner();
			$userData = $this->session->userdata('userData');
			$this->data['current_id'] = $userData[0]->Id;
			$this->layouts->view('profileView', $this->data);
		}else{
			redirect('advancedSettings/users_list');
		}
	}
	public function help()
	{
		$this->layouts->add_includes('js', 'app/js/user/help.js');
		$this->data['page']='help';
		$this->layouts->view('helpView', $this->data);
	}

	public function faqs()
	{
		$this->layouts->add_includes('js', 'app/js/user/faqs.js');
		$this->data['page']='faqs';
		$this->layouts->view('faqsView', $this->data);
	}
	public function contact()
	{
		$this->layouts->add_includes('js', 'app/js/user/contact.js');
		$this->data['page']='Contact';
		$this->layouts->view('contactView', $this->data);
	}

	public function users()
	{
		$userData=$this->session->userdata('userData');
		$usuario=$userData[0]->USUARIO;
		$details = $this->UsuarioModel->getUsers($usuario);
		print_r(json_encode($details));
	}
	public function profileInfo(){
		if ($this->input->post()) {
			$this->profileInfo_post();
		}
		$result = array();
		$userData = $this->session->userdata('userData');
		$user_id = $this->input->get('user_id', true); //$userData[0]->USUARIO;
		//$CLAVEACCESO = md5($userData[0]->CLAVEACCESO);
		$details = $this->UsuarioModel->getProfileInfo($user_id);
		if(!empty($details)) {
			$details[0]->chabi = md5($details[0]->chabi);
			$result = $details[0];
		}
    	print_r(json_encode($result));
	}

	
	public function setLayoutFormat()
	{
		$details = array();
		if ($this->input->post()) {
			$userData = $this->session->userdata('userData');
			$layoutFormat=$this->input->post('layoutFormat', true);
			$campus_user = $this->session->userdata('campus_user');
			$data_layoutFormat = array('layoutFormat'=>$layoutFormat);
			if(is_array($userData) && isset($userData[0]->USUARIO)){
				$usuario=$userData[0]->USUARIO;
				$details=$this->magaModel->update('usuarios', $data_layoutFormat,array('usuario'=>$usuario));
			}elseif(is_object($campus_user) && !empty($campus_user)){
				$user_role =$this->session->userdata('user_role');
				if ($user_role == 1) { //teacher
					$details = $this->ProfesorModel->updateItem($data_layoutFormat, $campus_user->INDICE);
				} elseif ($user_role == 2) { //student
					$details = $this->AlumnoModel->updateItem($data_layoutFormat, $campus_user->CCODCLI);
				}
			}
			$this->session->set_userdata('layoutFormat', $layoutFormat);			
		}
		print_r($details);
		exit;
	}
	public function setThemeColor()
	{
		$details = array();
		if ($this->input->post()) {
			$userData = $this->session->userdata('userData');
			$themeColor = $this->input->post('themeColor', true);
			$campus_user = $this->session->userdata('campus_user');
			$data_themeColor = array('themeColor'=>$themeColor);
			if(is_array($userData) && isset($userData[0]->USUARIO)){
				$usuario=$userData[0]->USUARIO;
				$details=$this->magaModel->update('usuarios',array('themeColor'=>$themeColor),array('usuario'=>$usuario));
			}elseif(is_object($campus_user) && !empty($campus_user)){
				$user_role =$this->session->userdata('user_role');
				if ($user_role == 1) { //teacher
					$details = $this->ProfesorModel->updateItem($data_themeColor, $campus_user->INDICE);
				} elseif ($user_role == 2) { //student
					$details = $this->AlumnoModel->updateItem($data_themeColor, $campus_user->CCODCLI);
				}
			}
			$this->session->set_userdata('color', $themeColor);
		}
		print_r($details);
		exit;
	}
	public function setLang()
	{
		$details = array();
		if ($this->input->post()) {

			$userData = $this->session->userdata('userData');
			$lang = $this->input->post('lang', true);
			$campus_user = $this->session->userdata('campus_user');
			$data_lang = array('lang'=>$lang);
			if(is_array($userData) && isset($userData[0]->USUARIO)){
				$usuario = $userData[0]->USUARIO;
				$details = $this->magaModel->update('usuarios', $data_lang,array('usuario'=>$usuario));
			}elseif(is_object($campus_user) && !empty($campus_user)){
				$user_role =$this->session->userdata('user_role');
				if ($user_role == 1) { //teacher
					$details = $this->ProfesorModel->updateItem($data_lang, $campus_user->INDICE);
				} elseif ($user_role == 2) { //student
					$details = $this->AlumnoModel->updateItem($data_lang, $campus_user->CCODCLI);
				}
			}
			$this->session->set_userdata('lang', $lang);
		}
		print_r($details);
		exit;

	}
	public function profileFotoUpload(){
		$details = array();
		if ($this->input->post()) {
			$userData=$this->session->userdata('userData');
			$usuario=$userData[0]->USUARIO;
			$get_image = file_get_contents($_FILES['file']['tmp_name']);
			$details=$this->magaModel->update('usuarios',array('foto'=>$get_image),array('usuario'=>$usuario));
		}
		print_r($details);
		exit;
	}
	public function profileInfo_post()
	{
		//$userData=$this->session->userdata('userData');
		//$usuario=$userData[0]->USUARIO;
		$detail = false;
		$error_msg = '';
		$user_id = $this->input->post('user_id', true);
		$userData = $this->session->userdata('userData');
		$current_userId = $userData[0]->Id;
		if($this->is_owner() || $user_id == $current_userId) {
			$phone = $this->input->post('phone', true);
			$email = $this->input->post('email', true);
			$about = $this->input->post('about', true);
			$user_name = $this->input->post('user_name', true);
			$detail = $this->magaModel->update('usuarios', array('Telefono' => $phone, 'about' => $about, 'email' => $email, 'nombre' => $user_name), array('id' => $user_id));

		}else{
			$error_msg = $this->lang->line('you_have_not_permission');
		}
		echo json_encode(array('detail' => $detail, 'error_msg' => $error_msg));
		exit;
	}

	public function change_user_massaging(){
		$detail = false;
		$error_msg = $this->lang->line('error');
		$user_id = $this->input->post('user_id', true);
		//$userData = $this->session->userdata('userData');
		//$current_userId = $userData[0]->Id;
		if($this->is_owner()) {
			$status = $this->input->post('status', true) == '1' ? '1' : '0';
			$for_type = $this->input->post('for_type', true);
			if($for_type == 'student') {
				$detail = $this->magaModel->update('usuarios', array('allow_messaging_students' => $status), array('id' => $user_id));
			}elseif($for_type == 'teacher'){
				$detail = $this->magaModel->update('usuarios', array('allow_messaging_teachers' => $status), array('id' => $user_id));
			}
		}else{
			$error_msg = $this->lang->line('you_have_not_permission');
		}
		echo json_encode(array('detail' => $detail, 'error_msg' => $error_msg));
		exit;
	}

	public function updatePassword()
	{
		$details = false;
		$error_msg = '';
		if ($this->input->post()) {
			$userData = $this->session->userdata('userData');
			$current_userId = $userData[0]->Id;
			$user_id = $this->input->post('user_id', true);
			if($this->is_owner() || $user_id == $current_userId) {
				$userData = $this->session->userdata('userData');
				$usuario = $userData[0]->USUARIO;
				$password = $this->input->post('password', true);
				if (!empty($password)) {
					$details = $this->magaModel->update('usuarios', array('CLAVEACCESO' => $password), array('id' => $user_id));
				} else {
					$details = false;
				}
			}else{
				$error_msg = $this->lang->line('you_have_not_permission');
			}
		}
		echo json_encode(array('details' => $details, 'error_msg' => $error_msg));
		exit;
	}


}
