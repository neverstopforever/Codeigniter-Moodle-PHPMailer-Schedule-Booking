<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\Ses\SesClient;
class Options extends MY_Campus_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->lang->load('campus',$this->data['lang']);
		if(!$this->session->userdata('campus_user')){
			redirect('campus/auth/login/', 'refresh');
		}
		$this->load->model('AgendaModel');
		$this->load->library('form_validation');
		$this->data['campus_user'] = (array)$this->session->userdata('campus_user');

		if($this->data['campus_user_role'] == 1){ //teacher
			$this->data['user_id'] = $this->data['campus_user']['INDICE'];
		}else if($this->data['campus_user_role'] == 2){ //student
			$this->data['user_id'] = $this->data['campus_user']['CCODCLI'];
		}else{
			$this->data['user_id'] = null;
		}
	}

	public function assessment(){
		if($this->data['campus_user_role'] == 1) { // for teacher
			$this->load->model('GruposlModel');
			$this->layouts->add_includes('js', 'app/js/campus/options/assessment.js');
			$this->data['groups'] = $this->GruposlModel->getGroupsByTeacher($this->data['user_id']);
			$this->layouts->view('campus/options/assessment', $this->data, $this->layout);
		}else{
			$this->load->model('MatriculatModel');
			$this->layouts->add_includes('js', 'app/js/campus/options/student/assessment.js');
			$this->data['courses'] = $this->MatriculatModel->getEnrollAssignedEval($this->data['user_id']);
			$this->layouts->view('campus/options/student/assessment', $this->data, $this->layout);
		}
	}

	public function getCourses(){
		$courses = array();
		if($this->input->post() && $this->data['campus_user_role'] == 1){ //only for teacher
			$this->load->model('MatriculalModel');
			$group_id = $this->input->post('group_id', true);
			if($group_id){
				$courses = $this->MatriculalModel->courses_assigned_by_group('teacher', $this->data['user_id'], $group_id);
			}
		}
		print_r(json_encode($courses));
		exit;
	}

	public function getNotes(){
		$notes = array();
		if($this->input->post() && $this->data['campus_user_role'] == 1){ //only for teacher
			$this->load->model('MatriculatModel');
			$group_id = $this->input->post('group_id', true);
			$course_id = $this->input->post('course_id', true);
			if($group_id && $course_id){
				$notes = $this->MatriculatModel->getNotes($this->data['user_id'], $group_id, $course_id);
			}
		}
		print_r(json_encode($notes));
		exit;
	}

//	public function assessment_detail($data = null){ // old version
//		$data_decoded = base64_decode($data);
//		$data_decoded_array = explode(',', $data_decoded);
//		$post_data_array = array();
//		if(!empty($data_decoded_array)){
//			foreach($data_decoded_array as $post_data){
//				$explode_d = explode('=', $post_data);
//				if(isset($explode_d[0]) && $explode_d[0] == 'idm'){
//					$post_data_array['idm'] = isset($explode_d[1]) ? $explode_d[1] : null;
//				}
//				if(isset($explode_d[0]) && $explode_d[0] == 'idml'){
//					$post_data_array['idml'] = isset($explode_d[1]) ? $explode_d[1] : null;
//				}
//				if(isset($explode_d[0]) && $explode_d[0] == 'group_id'){
//					$post_data_array['group_id'] = isset($explode_d[1]) ? $explode_d[1] : null;
//				}
//				if(isset($explode_d[0]) && $explode_d[0] == 'course_id'){
//					$post_data_array['course_id'] = isset($explode_d[1]) ? $explode_d[1] : null;
//				}
//			}
//		}
//		if($post_data_array['group_id'] && $post_data_array['course_id'] && $post_data_array['idml'] && $post_data_array['idm']){
//			$this->load->model('MatriculalModel');
//			$details = $this->MatriculalModel->get_assessment_detail($post_data_array['idml']);
//			if(isset($details[0]) && !empty($details[0])){
//				$this->data['dtlrs'] = $details[0];
//				$this->layouts->view('campus/options/assessment_detail', $this->data, $this->layout);
//			}
//			//vardump($details);exit;
//
//		}else{
//			redirect('campus/options/assessment');
//		}
//	}

	public function getAssessmentDetails(){
		$html = '';
		if($this->input->post() && $this->data['campus_user_role'] == 1){ //only for teacher

			$course_id = $this->input->post('course_id', true);
			$group_id = $this->input->post('group_id', true);
			$idm = $this->input->post('idm', true);
			$idml = $this->input->post('idml', true);
			$st = $this->input->post('st', true);
			if($course_id && $group_id && $idm && $idml) {
				$this->load->model('MatriculalModel');
				$this->load->model('EvalNotasModel');
				$this->load->model('Variables2Model');

				$details = $this->MatriculalModel->get_assessment_detail($idml);
				if (isset($details[0]) && !empty($details[0])) {
					$this->data['notes_data'] = $this->EvalNotasModel->getNotasData($idml);
					$this->data['notes'] = $this->EvalNotasModel->getNotas();
					$this->data['is_option_active'] = $this->Variables2Model->is_option_active('ciclos_formativos');
					$this->data['recoveries_data'] = $this->EvalNotasModel->getRecoveriesData($idml);
					$this->data['dtlrs'] = $details[0];
					$this->data['course_id'] = $course_id;
					$this->data['group_id'] = $group_id;
					$this->data['idm'] = $idm;
					$this->data['idml'] = $idml;
					$this->data['st'] = $st;
					$html = $this->load->view('campus/options/partials/assessment_detail', $this->data, true);
				}
			}
		}
		echo json_encode(array('html' => $html));
		exit;
	}


	public function compareNote(){
		$result = false;
		if($this->input->post() && $this->data['campus_user_role'] == 1){ //only for teacher
			$note = $this->input->post('note', true);
			$note = str_replace(',', '.', $note);
			if(!empty($note) && $note != ',00' && is_numeric($note)) {
				$this->load->model('EvalNotasModel');
				$details = $this->EvalNotasModel->comperNotes($note);
				if(!empty($details)){
					foreach($details as $value){
						if($value->id != NULL && $value->id != ",00" &&  $value->id != ""){
							$result = true;
							break;
						}
					}
				}
			}
		}
		echo json_encode(array('result' => $result));
		exit;
	}

	public function getStateIdByNote(){
		$state_id = '-1';
		if($this->input->post() && $this->data['campus_user_role'] == 1){ // only for teacher
			$note = $this->input->post('note', true);
			$note = str_replace(',', '.', $note);
			if(!empty($note) && $note != ',00' && is_numeric($note)) {
				$this->load->model('EvalNotasModel');
				$ids = $this->EvalNotasModel->getStateIdByNote($note);
				if(!empty($ids)){
					foreach($ids as $id_loc){
						$state_id = $id_loc->id;
					}
				}
			}
		}
		echo json_encode(array('id' => $state_id));
		exit;
	}

	public function updateNotes(){
		$result_1 = false;
		$result_2 = false;
		if($this->input->post() && $this->data['campus_user_role'] == 1){ //only for teacher
			$note = $this->input->post('note', true);
			$state_id = $this->input->post('state_id', true);
			$course_id = $this->input->post('course_id', true);
			$group_id = $this->input->post('group_id', true);
			$idm = $this->input->post('idm', true);
			$idml = $this->input->post('idml', true);
			$note = str_replace(',', '.', $note);
			if(!empty($note) && is_numeric($note)) {
				$this->load->model('Variables2Model');
				$this->load->model('MatriculalModel');
				$result_1 = $this->MatriculalModel->updateNotes($note, $state_id, $idml);
				if($result_1 && $idm && $idml){
					if($this->Variables2Model->is_option_active('ciclos_formativos')){
						$result_2 = $this->MatriculalModel->insert_matriculal_notas_audit($idm, $idml);
					}
				}
			}
		}
		echo json_encode(array('success' => $result_1, 'result_2' => $result_2));
		exit;
	}

// notes params part

	public function getNoteParams(){
		$html = '';
		if($this->input->post() && $this->data['campus_user_role'] == 1){ //only for teacher
			$course_id = $this->input->post('course_id', true);
			$group_id = $this->input->post('group_id', true);
			$idm = $this->input->post('idm', true);
			$idml = $this->input->post('idml', true);
			$ide = $this->input->post('ide', true);
			$st = $this->input->post('st', true);
			if($course_id && $group_id && $idm && $idml && $ide) {
				$this->load->model('MatriculalModel');
				$this->load->model('EvalNotasModel');
				$this->load->model('Variables2Model');
				$this->load->model('EvalNotasParamsModel');
				$details = $this->MatriculalModel->get_assessment_detail($idml);
				if (isset($details[0]) && !empty($details[0])) {

//					//$this->data['notes_data'] = $this->EvalNotasModel->getNotasData($idml);
//
//					$this->data['is_option_active'] = $this->Variables2Model->is_option_active('ciclos_formativos');
					$this->data['dtlrs'] = $details[0];
					$this->data['note_data'] = $this->EvalNotasModel->getNotasDataById($ide);
					$this->data['note_paramas'] = $this->EvalNotasParamsModel->getNotesParams($ide);
					$this->data['delete_paramas'] = $this->Variables2Model->getTeacherCanDelParams();
					$this->data['notes'] = $this->EvalNotasModel->getNotas();
//					$this->data['course_id'] = $course_id;
//					$this->data['group_id'] = $group_id;
					$this->data['idm'] = $idm;
					$this->data['idml'] = $idml;
					$this->data['st'] = $st;
					$this->data['ide'] = $ide;
					//$this->data['Max_Params'] = $this->Variables2Model->getMaxParams();
				}
				$html = $this->load->view('campus/options/partials/notes_params', $this->data, true);

			}
		}
		echo json_encode(array('html' => $html));
		exit;
	}

	public function updateNoteData($ide = null){
		$success = false;
		$error_msg = array();
		$updated_data = array();
		if($this->input->post() && $ide && $this->data['campus_user_role'] == 1) { //only for teacher
			$this->load->model('EvalNotasModel');
			$this->load->helper('security');
			$format = 'Y-m-d';
			if($this->data['lang'] == 'spanish'){
				$format = 'd-m-Y';
			}
			$error_msg = array();
			$note_detail = $this->input->post('note_detail', true);
			$note_date = $this->input->post('note_date', true);
			$note = $this->input->post('note', true);
			$note = $note ? str_replace(",", ".", $note) : '0.00';
			$select_type_note = $this->input->post('select_type_note', true);
			$note_peso = $this->input->post('note_peso', true);
			$note_peso = $note_peso ? str_replace(",", ".", $note_peso) : '100.00';
			$select_approval = $this->input->post('select_approval', true);
			$note_comment = $this->input->post('note_comment', true);
			$select_state = $this->input->post('select_state', true);
			$this->config->set_item('language', $this->data['lang']);
			$this->form_validation->set_message('checkDateFormat', $this->lang->line('date_is_not_valid'));
			$this->form_validation->set_rules('note_detail', $this->lang->line('detail'), 'trim|required|max_length[250]');
//			$this->form_validation->set_rules('note_date', $this->lang->line('date'), 'trim|required|callback_checkDateFormat');
			if (!empty($note) && $note != '0.00' && is_numeric($note)) {
				$note = $note;
			} elseif (!is_numeric($note)) {
				$error_msg[] = $this->lang->line('note_is_not_valid');
			}

			if (!empty($note_peso) && $note_peso != '0.00' && is_numeric($note_peso)) {
				$note_peso = $note_peso;
			} elseif (!is_numeric($note_peso)) {
				$error_msg[] = $this->lang->line('weight_is_not_valid');
			}

			if (!empty($note_comment)) {
				$this->form_validation->set_rules('note_comment', $this->lang->line('comment'), 'trim');
			}
			if ($this->form_validation->run() && empty($error_msg)) {
				$update_data = array(
					'descripcion' => $note_detail,
					'fecha' => $note_date,
					'nota' => $note,
					'idestado' => $select_state,
					'reqaprov' => $select_type_note,
					'peso' => $note_peso,
					'observaciones' => $note_comment,
				);
				$success = $this->EvalNotasModel->updateItem($update_data, $ide);
				$updated_data = $update_data;
				$updated_data['fecha'] = date($format, strtotime($note_date));
			} else {
				if(!empty(validation_errors())) {
					$error_msg[] = validation_errors();
				}
			}
		}
		echo json_encode(array('success' => $success, 'errors' => $error_msg, 'updated_data' => $updated_data));
		exit;
	}

	public function updateNoteParamsData($id_param = null, $ide = null){
		$success = false;
		$error_msg = array();
		$updated_data = array();
		if($this->input->post() && $id_param && $ide && $this->data['campus_user_role'] == 1) { //only for teacher
			$this->load->model('EvalNotasParamsModel');
			$this->load->helper('security');
			$error_msg = array();
			$note_param_detail = $this->input->post('note_param_detail', true);
			$note_param_note = $this->input->post('note_param_note', true);
			$note_param_note = $note_param_note ? str_replace(",", ".", $note_param_note) : '0.00';
			$note_param_peso = $this->input->post('note_param_peso', true);
			$note_param_peso = $note_param_peso ? str_replace(",", ".", $note_param_peso) : '0.00';
			$note_param_comment = $this->input->post('note_param_comment', true);
			$this->config->set_item('language', $this->data['lang']);
//			$this->form_validation->set_rules('note_param_detail', $this->lang->line('detail'), 'trim|required|max_length[250]');
			if (!empty($note_param_note) && $note_param_note != '0.00' && is_numeric($note_param_note)) {
				$note_param_note = $note_param_note;
			} elseif (!is_numeric($note_param_note)) {
				$error_msg[] = $this->lang->line('note_is_not_valid');
			}

			if (!empty($note_param_peso) && $note_param_peso != '0.00' && is_numeric($note_param_peso)) {
				$note_param_peso = $note_param_peso;
			} elseif (!is_numeric($note_param_peso)) {
				$error_msg[] = $this->lang->line('weight_is_not_valid');
			}

			if (!empty($note_param_comment)) {
				$note_param_comment = trim($note_param_comment);
//				$this->form_validation->set_rules('note_param_comment', $this->lang->line('comment'), 'trim');
			}
			if (empty($error_msg)) {
				$editable = $this->EvalNotasParamsModel->getEditable($id_param);
				if($editable->editable == 1){
					$update_data = array(
						'descripcion' => $note_param_detail,
						'nota' => $note_param_note,
						'peso' => $note_param_peso,
						'comentarios' => $note_param_comment,
					);
					
				}else {
					$update_data = array(
						'comentarios' => $note_param_comment,
						'nota' => $note_param_note,
					);
				}
				$success = $this->EvalNotasParamsModel->updateItem($update_data, $id_param, $ide);
				$updated_data = $this->EvalNotasParamsModel->getParamsBiId($id_param, $ide);
			} else {
				if(!empty(validation_errors())) {
					$error_msg[] = validation_errors();
				}
			}
		}
		echo json_encode(array('success' => $success, 'errors' => $error_msg, 'updated_data' => $updated_data));
		exit;
	}

	public function checkDateFormat($date) {
		if($this->data['lang'] == 'spanish' && $date) {
			$date_array = explode('-', $date);
			if (isset($date_array[0]) && isset($date_array[1]) && isset($date_array[2])) {
				if (checkdate($date_array[1], $date_array[0], $date_array[2])) {
					return true;
				}
				else {
					return false;
				}
			} else {
				return false;
			}
		}elseif($date){
			$date_array = explode('-', $date);
			if (isset($date_array[0]) && isset($date_array[1]) && isset($date_array[2])) {
				if (checkdate($date_array[1], $date_array[2], $date_array[0])) {
					return true;
				}
				else {
					return false;
				}
			} else {
				return false;
			}
		}
	}

	public function updateRecoveryData($id_recovery = null){
		$success = false;
		$error_msg = array();
		$updated_data = array();
		if($this->input->post() && $id_recovery && $this->data['campus_user_role'] == 1) { //only for teacher
			$this->load->model('EvalNotasModel');
			$this->load->helper('security');
			$error_msg = array();
			$recovery_note = $this->input->post('recovery_note', true);
			$recovery_note = $recovery_note ? str_replace(",", ".", $recovery_note) : '0.00';
			$recovery_comment = $this->input->post('recovery_comment', true);
			$select_state = $this->input->post('recovery_select_state', true);
			$this->config->set_item('language', $this->data['lang']);
			if (!empty($recovery_note) && $recovery_note != '0.00' && is_numeric($recovery_note)) {
				$recovery_note = $recovery_note;
			} elseif (!is_numeric($recovery_note)) {
				$error_msg[] = $this->lang->line('note_is_not_valid');
			}

			if (!empty($recovery_comment)) {
				$this->form_validation->set_rules('recovery_comment', $this->lang->line('comment'), 'trim');
			}
			if ($this->form_validation->run() && empty($error_msg)) {
				$update_data = array(
					'idestado' => $select_state,
					'nota' => $recovery_note,
					'observaciones' => $recovery_comment,
				);
				$success = $this->EvalNotasModel->updateRecoveriesData($update_data, $id_recovery);
				$updated_data = $this->EvalNotasModel->getRecoveriesDataById($id_recovery);
				$updated_data = isset($updated_data[0]) ? $updated_data[0] : array();
			} else {
				if(!empty(validation_errors())) {
					$error_msg[] = validation_errors();
				}
			}
		}
		echo json_encode(array('success' => $success, 'errors' => $error_msg, 'updated_data' => $updated_data));
		exit;
	}


	// Students part start

	public function getStudentsAssessmentDetails(){
		$html = '';
		if($this->input->post() && $this->data['campus_user_role'] == 2){ //only for student

			$course_id = $this->input->post('course_id', true);
			$user_id = $this->data['user_id'];
			if($course_id ) {
				$this->load->model('MatriculalModel');
				$this->load->model('MatriculatModel');
				$this->load->model('EvalNotasModel');
				$this->load->model('Variables2Model');

				$details = $this->MatriculalModel->get_student_assessment_detail($course_id, $user_id);
				if (isset($details[0]) && !empty($details[0])) {
					$matricula_data = $this->MatriculatModel->get_matricula($user_id, $course_id);

					$enroll_id = isset($matricula_data[0]->matricula) ? $matricula_data[0]->matricula : null;
					$this->data['notes_data'] = $enroll_id ? $this->EvalNotasModel->getStudentNotesData($enroll_id, $course_id) : array();
					$this->data['notes'] = $this->EvalNotasModel->getNotas();
					$this->data['recoveries_data'] = $enroll_id ? $this->EvalNotasModel->getStudentRecoveriesData($enroll_id, $course_id) : array();
					$this->data['dtlrs'] = $details[0];
					$this->data['course_id'] = $course_id;
					$this->data['enroll_id'] = $enroll_id;
					$html = $this->load->view('campus/options/partials/student/assessment_detail', $this->data, true);
				}
			}
		}
		echo json_encode(array('html' => $html));
		exit;
	}

	public function getStudentNoteParams(){
		$html = '';
		if($this->input->post() && $this->data['campus_user_role'] == 2){ //only for student

			$course_id = $this->input->post('course_id', true);
			$id = $this->input->post('id', true);
			$evaluacion = $this->input->post('evaluacion', true);
			$enroll_id = $this->input->post('enroll_id', true);
			$user_id = $this->data['user_id'];
			if($course_id && $id && $enroll_id) {
				$this->load->model('EvalNotasParamsModel');
				$this->load->model('EvalNotasModel');

				$this->data['note_paramas'] =  $this->EvalNotasParamsModel->getNotesParams($id);
				$note_data = $this->EvalNotasModel->getNotasDataById($id);
				$this->data['note_data'] = isset($note_data[0]) && !empty($note_data[0]) ? $note_data[0] : array();
				$this->data['course_id'] = $course_id;
				$this->data['enroll_id'] = $enroll_id;
				$this->data['evaluacion'] = $evaluacion;
				$html = !empty($note_data) ? $this->load->view('campus/options/partials/student/notes_params', $this->data, true) : '';

			}
		}
		echo json_encode(array('html' => $html));
		exit;
	}

}