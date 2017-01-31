<?php defined('BASEPATH') OR exit('No direct script access allowed');

class StudentResource extends MY_Campus_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('ResourceModel');
        $this->load->model('CourseModel');
        $this->lang->load('campus',$this->data['lang']);
        if(!$this->session->userdata('campus_user')){
                redirect('campus/auth/login/', 'refresh');
        }
        $this->layouts->add_includes('js', 'app/js/campus/student_resource/main.js');
        $this->data['student_id'] = isset($this->data['campus_user']['CCODCLI']) ? $this->data['campus_user']['CCODCLI'] : null;
    }

    public function index(){
        redirect('/campus/student-resource/my_courses');
    }

    public function my_courses(){
        $this->layouts->add_includes('js', 'app/js/campus/student_resource/my_courses.js');
        $this->data['courses'] = $this->CourseModel->getCoursesByStudentId($this->data['student_id']);
        $this->layouts->view('campus/student_resource/my_courses', $this->data, $this->layout);
    }

    public function resources($ml_id = null){

        if(!$ml_id){
            redirect('/campus/student-resource/my_courses');
        }
        $this->layouts
            ->add_includes('js', 'app/js/campus/student_resource/resources.js');
        $this->data['page'] = 'student_resource_resources';
        $course = $this->CourseModel->getCoursesByStudentId($this->data['student_id'], $ml_id);
        $this->data['course'] = null;
        $this->data['resources'] = null;
        $this->data['c_type'] = null;

        if(isset($course[0])){

            $this->data['course'] = $course[0];
            $resource_group_id = $course[0]->resource_group_id;
            $resource_individual_id = $course[0]->resource_individual_id;
            
            if(!empty($course[0]->group_id) && $resource_group_id){
                $this->data['c_type'] = 'group';

                $this->load->model('ScResourceGroupItemsModel');
                $this->data['resources'] = $this->ScResourceGroupItemsModel->getListByResourceGroupId($resource_group_id);

                $this->load->model('ScResourcePostGroupModel');
                $this->data['comments'] = $this->ScResourcePostGroupModel->get_post($resource_group_id, $course[0]->teacher_id);

            }elseif($resource_individual_id) {
                $this->data['c_type'] = 'individual';
//                $this->load->model('ScResourceIndividualItemsModel');
//                $this->data['resources'] = $this->ScResourceIndividualItemsModel->getListByResourceIndividualId($resource_individual_id);

                $this->load->model('ScResourcePostIndividualModel');
                $this->data['comments'] = $this->ScResourcePostIndividualModel->get_post($resource_individual_id, $course[0]->teacher_id, $this->data['student_id']);
            }
            
        }
        $this->layouts->view('campus/student_resource/resources', $this->data, $this->layout);
    }

    /*** Comment ***/
    public function comment(){

        $response['success'] = false;
        $response['errors'] = array();
        $response["result"] = null;
        //Add Ajax request case
        if($this->input->post()){
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules("comment",$this->lang->line('student_resource_g_comment'),"trim|required");

            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $data['comments'] = $this->input->post('comment', true);
                $data['resource_individual_id'] = $this->input->post('resource_individual_id', true);
                $data['course_id'] = $this->input->post('course_id', true);
                $data['teacher_id'] = $this->input->post('teacher_id', true);
                $data['student_id'] = $this->data['student_id'];
                $id = $this->ScResourcePostIndividualModel->add($data);
                if($id){
                    $response["result"] = $this->ScResourcePostGroupModel->getInfoWithProfesor($id);
                    $response['success'] = $this->lang->line('teacher_resource_g_comment_added_success');
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }

        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }
}