<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Schedules extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        if(empty($this->_identity['loggedIn'])) {
            redirect('/auth/login/', 'refresh');
        }
        $this->layout = 'schedules';
        $this->lang->load('schedules', $this->data['lang']);
        $this->layouts->add_includes('js', 'app/js/schedules/main.js');
        $this->layouts->add_includes('css', 'app/css/schedules/calendar.css');
        $this->layouts->add_includes('js', 'app/js/schedules/partials/fc-multistaff-view.js');
      
    }

    public function index($action = null){
        $this->lang->load('quicktips', $this->data['lang']);
        $this->data['page'] = 'schedules_index';
        $this->layouts->add_includes('js', 'app/js/schedules/index.js');
        $this->layouts->add_includes('js', 'app/js/schedules/partials/calendar.js');

        $get_action = $this->input->get('action');

        if(empty($action)){
            if(!empty($get_action)){
                $action = $get_action;
            }else{
                $action = "groups";
            }
        }

        $this->data['staffs'] = null;
        $this->data['all_staffs'] = null;
        $this->data['active_groups'] = '';
        $this->data['active_courses'] = '';
        $this->data['active_classrooms'] = '';
        $this->data['active_teachers'] = '';
        $this->data['action'] = $action;

        switch ($action){
            case "groups":
                $this->data['active_groups'] = 'for_list_border_colors_active';
                $this->data['no_staff_selected'] = $this->lang->line('schedules_no_group_selected');
                $this->data['all_staffs'] = $this->lang->line('schedules_all_groups');
                $this->load->model('GrupoModel');
                $items = $this->GrupoModel->getGroupsForSchedule();
                $staffs = array();
                foreach ($items as $k=>$item){
                    $staffs[$k]['id'] = $item->group_id;
                    $staffs[$k]['name'] = $item->group_name;
                    $staffs[$k]['color'] = $item->color;
                }
                $this->data['staffs'] = $staffs;

                break;
            case "courses":
                $this->data['active_courses'] = 'for_list_border_colors_active';
                $this->data['no_staff_selected'] = $this->lang->line('schedules_no_course_selected');
                $this->data['all_staffs'] = $this->lang->line('schedules_all_courses');
                $this->load->model('CursoModel');
                $items = $this->CursoModel->getCoursesForSchedule();
                $staffs = array();
                foreach ($items as $k=>$item){
                    $staffs[$k]['id'] = $item->course_id;
                    $staffs[$k]['name'] = $item->course_name;
                    $staffs[$k]['color'] = $item->color;
                }
                $this->data['staffs'] = $staffs;
                break;
            case "classrooms":
                $this->data['active_classrooms'] = 'for_list_border_colors_active';
                $this->data['no_staff_selected'] = $this->lang->line('schedules_no_classroom_selected');
                $this->data['all_staffs'] = $this->lang->line('schedules_all_classrooms');
                $this->load->model('AulasModel');
                $items = $this->AulasModel->getClassroomsForSchedule();
                $staffs = array();
                foreach ($items as $k=>$item){
                    $staffs[$k]['id'] = $item->classroom_id;
                    $staffs[$k]['name'] = $item->classroom_name;
                    $staffs[$k]['color'] = $item->color;
                }
                $this->data['staffs'] = $staffs;
                break;
            case "teachers":
                $this->data['active_teachers'] = 'for_list_border_colors_active';
                $this->data['no_staff_selected'] = $this->lang->line('schedules_no_teacher_selected');
                $this->data['all_staffs'] = $this->lang->line('schedules_all_teachers');
                $this->load->model('ProfesorModel');
                $items = $this->ProfesorModel->getTeachersForSchedule();
                $staffs = array();
                foreach ($items as $k=>$item){
                    $staffs[$k]['id'] = $item->teacher_id;
                    $staffs[$k]['name'] = $item->teacher_name;
                    $staffs[$k]['color'] = $item->color;
                }
                $this->data['staffs'] = $staffs;
                break;
            default:
                $this->data['active_groups'] = 'active_schedule';
                $this->data['no_staff_selected'] = $this->lang->line('schedules_no_group_selected');
                $this->data['all_staffs'] = $this->lang->line('schedules_all_groups');
                $this->data['action'] = "groups";
                $this->load->model('GrupoModel');
                $items = $this->GrupoModel->getGroupsForSchedule();
                $staffs = array();
                foreach ($items as $k=>$item){
                    $staffs[$k]['id'] = $item->group_id;
                    $staffs[$k]['name'] = $item->group_name;
                    $staffs[$k]['color'] = $item->color;
                }
                $this->data['staffs'] = $staffs;
                break;
        }

        $this->layouts->view('schedules/indexView', $this->data, $this->layout);
    }
    
    public function teachers(){

        $this->data['page'] = 'schedules_teachers';
        $this->layouts->add_includes('js', 'app/js/schedules/teachers.js');
        $this->layouts->add_includes('js', 'app/js/schedules/partials/calendar.js');
        
        $this->load->model('ProfesorModel');
        $this->data['teachers'] = $this->ProfesorModel->getTeachersForSchedule();
        $this->layouts->view('schedules/teachersView', $this->data, $this->layout);
    }
    public function classrooms(){

        $this->data['page'] = 'schedules_classrooms';
        $this->layouts->add_includes('js', 'app/js/schedules/classrooms.js');
        $this->layouts->add_includes('js', 'app/js/schedules/partials/calendar.js');

        $this->load->model('AulasModel');
        $this->data['classrooms'] = $this->AulasModel->getClassroomsForSchedule();
        $this->layouts->view('schedules/classroomsView', $this->data, $this->layout);
    }
    public function groups(){

        $this->data['page'] = 'schedules_groups';
        $this->layouts->add_includes('js', 'app/js/schedules/groups.js');
        $this->layouts->add_includes('js', 'app/js/schedules/partials/calendar.js');

        $this->load->model('GrupoModel');
        $this->data['groups'] = $this->GrupoModel->getGroupsForSchedule();
        $this->layouts->view('schedules/groupsView', $this->data, $this->layout);
    }
    public function courses(){

        $this->data['page'] = 'schedules_courses';
        $this->layouts->add_includes('js', 'app/js/schedules/courses.js');
        $this->layouts->add_includes('js', 'app/js/schedules/partials/calendar.js');

        $this->load->model('CursoModel');
        $this->data['courses'] = $this->CursoModel->getCoursesForSchedule();
        $this->layouts->view('schedules/coursesView', $this->data, $this->layout);
    }
    
    public function getCalendarData(){
        $response['data'] = null;
        if($this->input->is_ajax_request()){
            
            $action = $this->input->get('action', true);
            $start = $this->input->get('start', true);
            $end = $this->input->get('end', true);
            $staff_ids = $this->input->get('staff_ids', true);
            $ids = explode(',', $staff_ids);
            $_ids = array();
            foreach ($ids as $id){
                if(is_numeric($id)){
                    $_ids[] = $id;
                }else{
                    $_ids[] = "'".$id."'";
                }
            }
            $response['staff_ids'] = implode(',', $_ids);
            $response['start'] = date("Y-m-d", strtotime($start));
            $response['end'] = date("Y-m-d", strtotime($end));
            if(!empty($response['staff_ids'])){
                $this->load->model('AgendaModel');
                switch($action){
                    case "teachers":
                        $response['data'] = $this->AgendaModel->getForSchedules_teachers($response['start'], $response['end'], $response['staff_ids']);
                        break;
                    case "classrooms":
                        $response['data'] = $this->AgendaModel->getForSchedules_classrooms($response['start'], $response['end'], $response['staff_ids']);
                        break;
                    case "groups":
                        $response['data'] = $this->AgendaModel->getForSchedules_groups($response['start'], $response['end'], $response['staff_ids']);
                        break;
                    case "courses":
                        $response['data'] = $this->AgendaModel->getForSchedules_courses($response['start'], $response['end'], $response['staff_ids']);
                        break;
                    default:
                        $response['data'] = $this->AgendaModel->getForSchedules_groups($response['start'], $response['end'],  $response['staff_ids']);
                }
//                $response['data'] = $this->AgendaModel->getForSchedules($response['start'], $response['end'], $action, $response['staff_ids']);
            }
        }
        echo json_encode($response);
        exit;
    }
}
