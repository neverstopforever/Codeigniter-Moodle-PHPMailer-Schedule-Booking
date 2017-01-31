<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *@property AulasModel $AulasModel
 *@property AulaDModel $AulaDModel
 *@property CourseModel $CourseModel
 */
class Classroom extends MY_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('AulasModel');
		$this->load->model('AulaDModel');
		$this->load->model('CourseModel');
		$this->load->model('Variables2Model');
		
		$this->load->library('form_validation');
		if(!$this->session->userdata('loggedIn')){
			redirect('/auth/login/', 'refresh');
		}
	}
	
	public function index(){
		$this->lang->load('quicktips', $this->data['lang']);
		$this->layouts->add_includes('css', '/assets/css/evol.colorpicker.min.css');
		$this->layouts->add_includes('js', '/assets/js/evol.colorpicker.min.js');
		$this->layouts->add_includes('js', 'app/js/classrooms/index.js');
		$this->data['classrooms'] = $this->AulasModel->getClassroomList();
		$this->layouts->view('classroom/indexView', $this->data);

	}

	public function getClassrooms(){
		if($this->input->is_ajax_request()) {
			$classrooms = $this->AulasModel->getClassroomList();
			echo json_encode(array('data' => $classrooms));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
 	public function getCourses(){
		if($this->input->is_ajax_request()) {
			$id = $this->input->post('id', true);
			$courses = $this->AulasModel->getClassroomCourses($id);
			echo json_encode(array('data' => $courses));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function getNotExistCourses(){
		if($this->input->is_ajax_request()) {
			$id = $this->input->post('id', true);
			$exist_ids = $this->AulasModel->getExistCourses($id);
			$exist_data = array();
			if(!empty($exist_ids)){
				foreach($exist_ids as $exist){
					$exist_data[] = $exist->id;
				}
			}
			$courses = $this->AulasModel->getNotExistCourses($exist_data);
			echo json_encode(array('data' => $courses));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
	public function saveGeneralData(){
		if($this->input->is_ajax_request()){
			$data = array('success' => false,
						 'error' => ''
				);
			$color = $this->input->post('color', true);
			$capacity = $this->input->post('capacity', true);
            $classroom_name = $this->input->post('classroom_name', true);
//			$idcentro = $this->input->post('idcentro', true);
			$active = $this->input->post('active', true) == 'active' ? 1 : 0;
			$color = trim($color, '#');
			$color = hexdec($color);
			$type = $this->input->post('type', true);
			$this->form_validation->set_rules('classroom_name', $this->lang->line('classroom_section_general_name'), 'trim|required');
			if ($this->form_validation->run()) {
				if ($type == 'add') {
					if ($this->Variables2Model->updateNumaula()) {
						$id = $this->Variables2Model->getNumaula();
						if (isset($id[0]->numaula)) {
							$insert_data = array(
								'IdAula' => $id[0]->numaula,
								'Nombre' => $classroom_name,
								'Capacidad' => $capacity,
								'IdColor' => $color,
								'Activo' => $active,
//							'IdCentro' => $idcentro,

							);
							$insert_id = $this->AulasModel->insertData($insert_data);
							if ($insert_id) {
								$data['success'] = true;
								$data['classroom_id'] = $id[0]->numaula;
							} else {
								$data['success'] = 'Insert doues not success!';
							}
						}
					}
				} elseif ($type == 'edit') {
					$classroom_id = $this->input->post('classroom_id', true);
					$check_id = $classroom_id ? $this->AulasModel->getClassrooms($classroom_id) : null;
					if ($check_id && !empty($check_id)) {
						$update_data = array(
							'Nombre' => $classroom_name,
							'Capacidad' => $capacity,
							'IdColor' => $color,
							'Activo' => $active,
//						'IdCentro' => $idcentro,

						);
						$result = $this->AulasModel->updateClassroom($classroom_id, $update_data);
						if ($result) {
							$data['success'] = true;
						}
					}
				}
				$data['classrooms'] = $this->AulasModel->getClassroomList();
			}
			$data['errors'] = $this->form_validation->error_array();
			echo json_encode($data);
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
			$classroom_id = $this->input->post('classroom_id', true);
			$course_ids = $this->input->post('course_ids', true);
			$check_id = $classroom_id ? $this->AulasModel->getClassrooms($classroom_id) : null;
			if(!empty($check_id) && !empty($course_ids)) {
					$checked_course_ids = $this->CourseModel->getCourseIds($course_ids);
					if (!empty($checked_course_ids)) {
						foreach ($checked_course_ids as $course_id) {
							$insert_data[] = array('Indice' => $classroom_id, 'codcurso' => $course_id->codigo);
						}

					if ($this->AulaDModel->insertAulas($insert_data)) {
						$data['success'] = true;
						$data['insert_data'] = $checked_course_ids;
					} else {
						$data['success'] = 'Insert doues not success!';
					}
				}
			}
			$data['courses'] = $this->AulasModel->getClassroomCourses($classroom_id);
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
			$classroom_id = $this->input->post('classroom_id', true);
			$course_id = $this->input->post('course_id', true);
			$check_id = $classroom_id ? $this->AulasModel->getClassroomData($classroom_id) : null;
			if(!empty($check_id)){
				if($this->AulaDModel->deleteAulas(array('Indice' => $classroom_id, 'codcurso' => $course_id))) {
				$data['success'] = true;
				}
			}
			echo json_encode($data);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function editClassroom(){
		if($this->input->is_ajax_request()){
			$data = array(
				'success' => false,
				'error' => ''
			);
			$classroom_id = $this->input->post('classroom_id', true);
			$check_id = $classroom_id ? $this->AulasModel->getClassroomData($classroom_id) : null;
			if(!empty($check_id)){
				$data['courses'] = $this->AulasModel->getClassroomCourses($classroom_id);
				$data['general'] = $check_id;
				$data['calendar'] = $this->AulasModel->getCalendar($classroom_id);
			}

			echo json_encode($data);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function deleteClassroom(){
		if($this->input->is_ajax_request()){
			$data = array(
				'success' => false,
				'error' => ''
			);
			$classroom_id = $this->input->post('classroom_id', true);
			$exist_classroom_link = $this->AulasModel->existClassroomLink($classroom_id);
			if(isset($exist_classroom_link[0]->count_link) && $exist_classroom_link[0]->count_link >= 1){
               $data['success'] = false;
			}else{
				if($this->AulasModel->deleteClassroom($classroom_id)){
					$data['success'] = true;
				}
			}

			echo json_encode($data);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

}
