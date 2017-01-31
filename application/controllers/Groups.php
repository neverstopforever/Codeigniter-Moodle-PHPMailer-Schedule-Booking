<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\Ses\SesClient;
/**
 * @property CursosModel $CursosModel
 * @property GruposTabAdModel $GruposTabAdModel
 * @property Variables2Model $Variables2Model
 * @property ArticulosModel $ArticulosModel
 * @property GmateriallModel $GmateriallModel
 * @property LstInformesGruposModel $LstInformesGruposModel
 * @property FestividadesModel $FestividadesModel
 * @property ErpCustomFieldsModel $ErpCustomFieldsModel
 * */
class Groups extends MY_Controller
{

    private $sql_week_days = array(
        0 => 6,
        1 => 0,
        2 => 1,
        3 => 2,
        4 => 3,
        5 => 4,
        6 => 5,
    );

    public function __construct()
    {
        parent::__construct();

        if (empty($this->_identity['loggedIn'])) {
            redirect('/auth/login/', 'refresh');
        }
        $this->lang->load('groups', $this->data['lang']);

        $this->load->model('GrupoModel');
        $this->load->model('AreasAcademicaModel');
        $this->load->model('CursosModel');
        $this->load->model('GruposTabAdModel');
        $this->load->model('Variables2Model');
        $this->load->model('GruposlModel');
        $this->load->model('CursoModel');
        $this->load->model('EventModel');
        $this->load->model('AgendaGrupoModel');
        $this->load->model('ProfesorModel');
        $this->load->model('GruposDocModel');
        $this->load->model('GmateriallModel');
        $this->load->model('ArticulosModel');
        $this->load->model('ErpCustomFieldsModel');
        $this->load->helper('htmlpurifier');
        $this->load->library('form_validation');
        $this->layouts->add_includes('js', 'app/js/groups/main.js');
        $this->layouts->add_includes('css', 'assets/global/css/steps.css');
    }

    public function index()
    {
        $this->lang->load('quicktips', $this->data['lang']);
        $this->data['page'] = 'groups_index';
        $this->layouts->add_includes('js', 'app/js/groups/index.js');

        $this->data['groups'] = $this->GrupoModel->get_groups();

        $this->layouts->view('groups/indexView', $this->data);
    }

    public function get_groups()
    {
        $response['groups'] = null;
        if ($this->input->is_ajax_request()) {
            $response['groups'] = $this->GrupoModel->get_groups();
        }
        print_r(json_encode($response));
        exit;
    }


    public function add(){


        $this->layouts
            ->add_includes('css', 'assets/global/plugins/typeahead/typeahead.css')
            ->add_includes('css', 'assets/global/plugins/jquery-ui/jquery-ui.min.css')
            ->add_includes('js', 'assets/global/plugins/jquery-ui/jquery-ui.min.js')
            ->add_includes('js', 'assets/global/plugins/jquery-ui/ui/i18n/datepicker-es.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/handlebars.min.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.min.js')
            ->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
            ->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')

            ->add_includes('css', 'assets/global/plugins/spectrum/css/spectrum.css')
            ->add_includes('js', 'assets/global/plugins/spectrum/js/spectrum.js')
            ->add_includes('js', 'app/vendor/ckeditor/ckeditor/ckeditor.js')
            ->add_includes('js', 'app/js/groups/add_edit.js');

        $id = $this->get_group_id();


        if($this->input->post()){


            $this->config->set_item('language', $this->data['lang']);
            $config = array(
                array(
                    'field' => 'id',
                    'label' => $this->lang->line('groups_reference'),
                    'rules' => 'trim|required|is_unique[grupos.codigogrupo]|alpha_numeric'
                ),
                array(
                    'field' => 'title',
                    'label' => $this->lang->line('groups_name'),
                    'rules' => 'trim|required'
                ),
            );
            $this->form_validation->set_rules($config);
            $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');


            if ($this->form_validation->run()) {
                $post_data = array();
//                $post_data['custom_fields'] = implode(',',$this->input->post('custom_fields', true));
                $post_data['custom_fields'] = json_encode($this->input->post('custom_fields', true));
                $post_data['id'] = $this->input->post('id', true);
                $post_data['color'] = $this->input->post('color', true);
                $post_data['title'] = $this->input->post('title', true);
                $post_data['group_description'] = $this->input->post('group_description');
                $post_data['academic_year'] = $this->input->post('academic_year', true);
                $post_data['academic_area'] = $this->input->post('academic_area', true);
                $post_data['category'] = $this->input->post('category', true);
                $post_data['max_seats'] = $this->input->post('max_seats', true);
                $post_data['min_seats'] = $this->input->post('min_seats', true);
                $post_data['group_time_short_desc'] = $this->input->post('group_time_short_desc', true);

                $personalized_post_data = $this->input->post(NULL, true);
                $personalized_data = $this->get_personalized_data();
                if($post_data['id'] && $post_data['id'] != $id){
                    $id = $post_data['id'];
                }
                $insert_personalized = array();
                if(!empty($personalized_data)){
                    foreach($personalized_data as $personalized){
                        if(isset($personalized_post_data[$personalized->name])){
                            $insert_personalized[$personalized->name] =  trim($personalized_post_data[$personalized->name]);
                        }

                    }
                }
                if($id != '0') {
                    $insert_data = $this->makeInsertData($post_data);
                    if(!isset($insert_data['Estado'])){
                        $insert_data['Estado'] = 1;
                    }
                    $insert_data['codigogrupo'] = $id;
                    $insert_personalized['codigogrupo'] = $id;
                    $this->GruposTabAdModel->insertFormData($insert_personalized);

                    if ($this->GrupoModel->insertGroup($insert_data)) {
                        redirect('groups/edit/' . $id);
                    }
                }else{
                    $this->data['error_id'] = '<div class="text-danger err">The reference cannot be 0 or null</div>>';
                }

            }else{
                $this->session->set_flashdata('errors', $this->form_validation->error_array() );
            }

        }
        $this->data['isOwner']=$this->data['userData'][0]->owner;
        $this->data['add_edit'] = $this->lang->line('add');
        $this->data['group_id'] = $id;
        $this->data['personalized_fields'] = $this->get_personalized_data();
        $cisess = $this->session->userdata('_cisess');
        $membership_type = $cisess['membership_type'];
        if($membership_type != 'FREE'){
            $this->data['customfields_fields'] = $this->get_customfields_data();
        }
        $this->data['academic_area'] = $this->AreasAcademicaModel->getAreaAcademica();
        $this->data['categories'] = $this->CursosModel->getCourses();
        $this->data['academic_years'] = $this->AreasAcademicaModel->getAcademicYears();
        $this->layouts->view('groups/addEditView', $this->data);
    }


    public function edit($id = null){
        if($id) {
            $this->layouts
                ->add_includes('css', 'assets/global/plugins/typeahead/typeahead.css')
                ->add_includes('css', 'assets/global/plugins/jquery-ui/jquery-ui.min.css')
                ->add_includes('js', 'assets/global/plugins/jquery-ui/jquery-ui.min.js')
                ->add_includes('js', 'assets/global/plugins/typeahead/handlebars.min.js')
                ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.js')
                ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.min.js')
                ->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
                ->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
                ->add_includes('css', 'assets/global/plugins/spectrum/css/spectrum.css')
                ->add_includes('js', 'assets/global/plugins/spectrum/js/spectrum.js')
                ->add_includes('js', 'app/vendor/ckeditor/ckeditor/ckeditor.js')
                ->add_includes('js', 'app/js/groups/add_edit.js');
            if($this->data['lang'] == 'spanish'){
                $this->layouts->add_includes('js', 'assets/global/plugins/jquery-ui/ui/i18n/datepicker-es.js');
            }
            $this->data['group'] = $this->GrupoModel->getGroupById($id);
//            $this->data['group']
//            printr( $this->data['group']->custom_fields);exit;
            if(!empty($this->data['group'])) {
                $this->data['group']->custom_fields = json_decode($this->data['group']->custom_fields);
                if ($this->input->post()) {

                    $this->config->set_item('language', $this->data['lang']);
                    $config = array(
                        array(
                            'field' => 'title',
                            'label' => $this->lang->line('groups_name'),
                            'rules' => 'trim|required'
                        ),
                    );
                    $this->form_validation->set_rules($config);
                    $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');
                    if ($this->form_validation->run()) {
                        $post_data = array();
//                         $post_data['custom_fields'] = implode(',',$this->input->post('custom_fields', true));
                        $post_data['custom_fields'] = json_encode($this->input->post('custom_fields', true));
                        $post_data['color'] = $this->input->post('color', true);
                        $post_data['title'] = $this->input->post('title', true);
                        $post_data['group_description'] = $this->input->post('group_description');
                        $post_data['academic_year'] = $this->input->post('academic_year', true);
                        $post_data['academic_area'] = $this->input->post('academic_area', true);
                        $post_data['category'] = $this->input->post('category', true);
                        $post_data['max_seats'] = $this->input->post('max_seats', true);
                        $post_data['min_seats'] = $this->input->post('min_seats', true);
                        $post_data['group_time_short_desc'] = $this->input->post('group_time_short_desc', true);

                        $update_data = $this->makeInsertData($post_data);

                        $personalized_post_data = $this->input->post(NULL, true);
                        $personalized_data = $this->get_personalized_data();
                        $personalized_exist_data = $this->GruposTabAdModel->getByGroupId($id);
                        if(!empty($personalized_data)){
                            foreach($personalized_data as $personalized){
                                if(isset($personalized_post_data[$personalized->name])){
                                    $insert_personalized[$personalized->name] =  $personalized_post_data[$personalized->name];
                                }

                            }
                        }
                        if(!empty($personalized_exist_data)){
                            $this->GruposTabAdModel->updateFormData($insert_personalized, $id);
                        }else{
                            $insert_personalized['codigogrupo'] = $id;
                            $this->GruposTabAdModel->insertFormData($insert_personalized);
                        }


                        $this->GrupoModel->updateGroup($id,$update_data);
                    }
                    $this->updateGroupDate($id);
                    $this->data['group'] = $this->GrupoModel->getGroupById($id);
                    $this->data['group']->custom_fields = json_decode($this->data['group']->custom_fields);
                }
                $this->data['isOwner']=$this->data['userData'][0]->owner;
                $this->data['add_edit'] = $this->lang->line('edit');
                $this->data['personalized_fields'] = $this->get_personalized_data($id);
                $cisess = $this->session->userdata('_cisess');
                $membership_type = $cisess['membership_type'];
                if($membership_type != 'FREE'){
                    $this->data['customfields_fields'] = $this->get_customfields_data();
                }
                $this->data['academic_area'] = $this->AreasAcademicaModel->getAreaAcademica();
                $this->data['categories'] = $this->CursosModel->getCourses();
                $this->data['documents'] = $this->GruposDocModel->getByGroupId($id);
                $this->data['academic_years'] = $this->AreasAcademicaModel->getAcademicYears();
                $this->layouts->view('groups/addEditView', $this->data);
            }else{
                redirect('groups');
            }
        }else{
            redirect('groups');
        }
    }


    public function delete() {

        $response['success'] = false;
        $response['errors'] = array();
        if ($this->input->is_ajax_request()) {
            $id_group = $this->input->post('id_group', true);
            $check_group = $this->GrupoModel->getGroupsFromMatriculal($id_group);
            if(isset($check_group->group_count) ){
                if($check_group->group_count >= 1){
                    $response['errors'][] = $this->lang->line('groups_cannot_delete_mtl');
                }else{
                    $deleted = $this->GrupoModel->deleteItem($id_group);
                    $deleted_tab = $this->GruposTabAdModel->deleteItem($id_group);
                    $delete_relations = $this->GrupoModel->deleteRelations($id_group);
                    if($deleted && $deleted_tab){
                        $response['success'] = $this->lang->line('groups_deleted_success');
                    }else{
                        $response['errors'][] = $this->lang->line('db_err_msg');
                    }
                }
            }else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    private function makeInsertData($post_data){
        if(isset($post_data['color'])){
            $color = trim($post_data['color'], '#');
            $color = hexdec($post_data['color']);
        }else{
            $color = 0;
        }
        return array(
                'custom_fields' => $post_data['custom_fields'],
                'IdColor' => $color,
                'Descripcion' => $post_data['title'],
                'html_description' => $post_data['group_description'],
                'IdPeriodo' => $post_data['academic_year'],
                'IdAreaAcademica' => $post_data['academic_area'],
                'idcurso' => $post_data['category'],
                'NumAlumnos' => ($post_data['max_seats'] > 0 && $post_data['max_seats'] <= 300  ?  $post_data['max_seats'] : 1),
                'Minimo' => ($post_data['min_seats'] > 0 && $post_data['min_seats'] <= 300  ?  $post_data['min_seats'] : 1),
                'DescripcionHorario' => $post_data['group_time_short_desc'],
        );
    }

    public function change_state() {

        $response['success'] = false;
        $response['errors'] = array();
        if ($this->input->is_ajax_request()) {
            $id_group = $this->input->post('id_group', true);
            $new_state = $this->input->post('new_state', true);
            $updated = $this->GrupoModel->updateItem($id_group, array('Estado'=>$new_state));
            if($updated){
                $response['success'] = $this->lang->line('groups_updated_success');
                if($new_state == '3'){
                    $this->load->model('ProfesorModel');
                    $users = $this->ProfesorModel->getStudentsTeachersByGroup($id_group);
                    if(!empty($users)) {
                        foreach($users as $user_data) {
                            if (!empty($user_data)) {
                                $replace_data = array(
                                    'FIRSTNAME' => $user_data->first_name,
                                    'SURNAME' => $user_data->sur_name,
                                    'FULLNAME' => $user_data->full_name,
                                    'PHONE1' => $user_data->phone1,
                                    'MOBILE' => $user_data->mobile,
                                    'EMAIL1' => $user_data->email,
                                    //'COURSE_NAME' => $course_data->course_name,
                                    'START_DATE' => date('"F j, Y'),
                                    'END_DATE' => date('"F j, Y'),
                                );
                                $this->sendEmailPart($replace_data, $user_data->email);
                                if(!empty($user_data->tut1_email1)){
                                    $this->sendEmailPart($replace_data, $user_data->tut1_email1);
                                }
                                if(!empty($user_data->tut2_email1)){
                                    $this->sendEmailPart($replace_data, $user_data->tut2_email1);
                                }

                            }
                        }

                    }
                }

            }else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    private function sendEmailPart($replace_data,$email){
        $result = null;
        $this->load->model('ErpEmailsAutomatedModel');
        $template = $this->ErpEmailsAutomatedModel->getByTemplateId('12', array('notify_student' => 1));
        if (!empty($template) && !empty($email)) {
            $email_subject = replaceTemplateBody($template->Subject, $replace_data);
            $email_body = replaceTemplateBody($template->Body, $replace_data);
            $result = $this->send_automated_email($email, $email_subject, $email_body, $template->from_email);
        }
        return $result;
    }


    private function get_group_id(){
        $num = $this->Variables2Model->getNumGroup();
        $new_id = $num[0]->numgrupo;
        if($new_id == '0'){
            $this->Variables2Model->updateNumGroup();
            return $this->get_group_id();
        }
        $check_id = $this->GrupoModel->getGroupById($new_id);
        if(!empty($check_id)){
            $this->Variables2Model->updateNumGroup();
           return $this->get_group_id();
        }else{
            return $new_id;
        }

    }

    private function get_personalized_data($id = null) {
        $result_data = array();
        $personalized_data = array();
        if($id) {
            $personalized_data = (array)$this->GruposTabAdModel->getByGroupId($id);
        }

        $personalized_fields = $this->GruposTabAdModel->getFieldList();

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

 public function get_customfields_data($id = null) {
       
        $type = 'groups';
        $custom_fields = $this->ErpCustomFieldsModel->getFieldsList($type);
        if(count($custom_fields) > 0){
                
            return $custom_fields;

        }else{
            return false;
        }
       
    }
    // Courses  Start

    public function getCourses(){
        if($this->input->is_ajax_request()){
            $html = '';
            $group_id = $this->input->post('group_id', true);
            if(!empty($group_id)) {
                $courses = $this->GruposlModel->getCourses($group_id);
                $this->data['allow_group_multicourse'] = $this->Variables2Model->get_allow_group_multicourse();
                $this->data['courses'] = $courses;
                $this->data['group_id'] = $group_id;

                $html = $this->load->view('groups/partials/coursesView', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getNotExistCourses(){
        if($this->input->is_ajax_request()){
            $group_id = $this->input->post('group_id', true);
            if(!empty($group_id)){
                $ExistCoursesIds = $this->GruposlModel->getExistCoursesIds($group_id);
                $ids = isset($ExistCoursesIds->ids) ? $ExistCoursesIds->ids : null;
                $courses = $this->CursoModel->getNotExistCourses($ids);
            }

            echo json_encode(array('data' => $courses));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function addCourse(){
        if($this->input->is_ajax_request()){
            $course_id = $this->input->post('course_id', true);
            $group_id = $this->input->post('group_id', true);
            $insert_data = array();
            if(!empty($course_id) && $group_id){
                $course_data = $this->CursoModel->getCourseById($course_id);
                $check_exist_course = $this->GruposlModel->getExistCourse($course_id, $group_id);
                if(!empty($course_data) && empty($check_exist_course) && $this->is_allow_group_multicourse($group_id)){
                    $insert_data = array(
                        'codigocurso' => trim($course_data->codigo),
                        'codigogrupo' => $group_id,
                        'descripcion' => $course_data->curso,
                        'horas' => $course_data->horas,
                        'precio' => $course_data->precio,
                        'idprofesor' => $course_data->idprofesor,
                        'idaula' => $course_data->idaula,
                        'tipo' => $course_data->tipo,
                        'iddivisa' => '0',
                        'idtipologia' => $course_data->idmodalidadtipologia,
                        'idperiodo' => '0',
                        'idaño' => '-1',
                    );
                    $this->GruposlModel->insertCourse($insert_data);
                    $insert_data['teacher'] = $course_data->teacher;
                    $insert_data['classroom'] = $course_data->classroom;

                }
            }

            echo json_encode(array('data' => $insert_data));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    private function is_allow_group_multicourse($group_id){
        $courses = $this->GruposlModel->getCourses($group_id);
        $allow_group_multicourse = $this->Variables2Model->get_allow_group_multicourse();
        if($allow_group_multicourse == '1'){
            return true;
        }elseif($allow_group_multicourse == '0' && count($courses) == 0){
            return true;
        }else{
            return false;
        }
    }

    public function editCourse(){
        $this->load->model('MatriculalModel');
        if($this->input->is_ajax_request()){
            $course_id = $this->input->post('course_id', true);
            $group_id = $this->input->post('group_id', true);
            $hours = $this->input->post('gr_edit_course_hours', true);
            $teacher_id = $this->input->post('gr_edit_course_teacher', true);
            $classroom_id = $this->input->post('gr_edit_course_classroom', true);
            $second_teacher1 = $this->input->post('select_second_teacher_1', true);
            $second_teacher2 = $this->input->post('select_second_teacher_2', true);
            $second_teacher3 = $this->input->post('select_second_teacher_3', true);
            if(!empty($course_id) && $group_id){
                $edit_data = array(
                    'horas' => $hours,
                    'idprofesor' => $teacher_id,
                    'idaula' => $classroom_id,
                    'idprofesoraux'  => $second_teacher1,
                    'idprofesoraux2' => $second_teacher2,
                    'idprofesoraux3' => $second_teacher3
                );
                $where = array(
                    'codigocurso' => $course_id,
                    'codigogrupo' => $group_id
                );
                $whereMl = array(
                    'codigocurso' => $course_id,
                    'IdGrupo' => $group_id
                );
                $this->GruposlModel->updateCourse($edit_data, $where);
                $this->MatriculalModel->updateCourse($edit_data, $whereMl);
            }
            $course_data = $courses = $this->GruposlModel->getCourses($group_id, $course_id);
            echo json_encode(array('data' => $course_data));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    
    public function getCourseForEdit(){

        if($this->input->is_ajax_request()){
            $html = "";
            $course_id = $this->input->post('course_id', true);
            $group_id = $this->input->post('group_id', true);
            $course = $this->GruposlModel->getCourses($group_id, $course_id);
            $this->data['course'] = isset($course[0]) ? $course[0] : null;
            
            if($this->data['course']){
                $this->data['teachers'] = $this->ProfesorModel->getAll("INDICE as teacher_id, CONCAT(profesor.sapellidos,', ',profesor.snombre) AS teacher_name");
                $this->load->model('AulasModel');
                $this->data['classrooms'] = $this->AulasModel->getAll("IdAula as classroom_id, Nombre as classroom_name");

                $html = $this->load->view('groups/partials/group_edit_course', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function deleteCourse(){
        if($this->input->is_ajax_request()){
            $result = false;
            $course_id = $this->input->post('course_id', true);
            $group_id = $this->input->post('group_id', true);
            $get_course_links = $this->GruposlModel->getCourseLinks($group_id, $course_id);
            if(isset($get_course_links[0]->count_links) && $get_course_links[0]->count_links >= 1){

            }else{
               $result = $this->GruposlModel->deleteCourse($group_id, $course_id);
                if($result){
                    $this->AgendaGrupoModel->deleteByCourseId($course_id);
                }
            }
            echo json_encode(array('success' => $result));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    // Courses  End

    // Calendar  Start

    public function getCalendarTimetable(){

        if($this->input->is_ajax_request()){
            $html = '';
            $this->data['customfields_fields'] = array();
            $cisess = $this->session->userdata('_cisess');
            $membership_type = $cisess['membership_type'];
            $this->data['disable'] = 'disable';
            $group_id = $this->input->post('group_id', true);
            if(!empty($group_id)) {
                $this->load->model('Variables2Model');
                $this->load->model('AulasModel');
                $start_end_time = $this->Variables2Model->getStartEndtime();

                $this->data['def_start_time'] = substr($start_end_time->start_time, 0, -2).':'.substr($start_end_time->start_time, -2);
                $this->data['def_end_time'] = substr($start_end_time->end_time, 0, -2).':'.substr($start_end_time->end_time, -2);
                $this->data['time_fractions'] = $start_end_time->time_fractions == '1' ? 60 : $start_end_time->time_fractions;

                $this->data['group_id'] = $group_id;
                $this->data['courses'] = $this->GruposlModel->getCourses($group_id);
                //$this->data['courses_group'] = $this->GruposlModel->getCoursesByGroup($group_id);
                $this->data['teachers'] = $this->ProfesorModel->getTeacherBygroup($group_id);
                $this->data['teachers_for_events'] = $this->ProfesorModel->getTeacherForEvents($group_id);
                $this->data['classrooms'] = $this->AulasModel->getAll("IdAula as  id, Nombre as classroom");
//                $this->data['classrooms'] = $this->GruposlModel->getClassrooms($group_id);
                $this->data['events'] = $this->AgendaGrupoModel->getEvents($group_id);
                //if not free plan get custom fields
                if($membership_type != 'FREE'){
                    $this->data['isOwner']=$this->data['userData'][0]->owner;
                    $this->data['customfields_fields'] = $this->ErpCustomFieldsModel->getFieldsList('events');
                }
                $this->data['periods'] = $this->getAvailabilityTimaes(false);
                if(count($this->data['courses']) == 1){
                    $course_id = $this->data['courses'][0]->courseid;
                    $this->data['one_course_data'] =$this->GruposlModel->getCourses($group_id, $course_id)[0];
                    $this->data['disable'] = '';
                } else{
                    $this->data['disable'] = 'disabled';
                }
                $start_end_date = $this->GrupoModel->getStartEndDate($group_id);
                $format = 'Y-m-d';
                if($this->data['lang'] =='spanish'){
                    $format = 'd-m-Y';
                }
                $this->data['start_date'] =convert_date($start_end_date->start_date, 'Y-m-d H:i:s', $format);
                $this->data['end_date'] =convert_date($start_end_date->end_date, 'Y-m-d H:i:s', $format);

                $html = $this->load->view('groups/partials/calendarView', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }



    public function getAvailabilityTimaes($off = true){
        $this->load->model('Variables2Model');
        $start_end_time = $this->Variables2Model->getStartEndtime();
        if($start_end_time->time_fractions == '1'){
            $interval = '60';
        }else{
            $interval =  $start_end_time->time_fractions;
        }

        $start_time = substr($start_end_time->start_time, 0, -2).':'.substr($start_end_time->start_time, -2);
        $end_time = substr($start_end_time->end_time, 0, -2).':'.substr($start_end_time->end_time, -2);
        //$start_time = $this->session->userData('start_time');
        //$end_time = $this->session->userData('end_time');
        $time_data = array();
        $period = new DatePeriod(
            new DateTime($start_time),
            new DateInterval('PT'.$interval.'M'),
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

    public function getEvents(){

        if($this->input->is_ajax_request()){
            $events = array();
            if($this->input->post()){
                $courseId = $this->input->post('course_id', true);
                $groupId = $this->input->post('Idgrupo', true);
                $events = $this->AgendaGrupoModel->getEvents($groupId, $courseId);
            }
            echo json_encode(array('data' => $events));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getEventTeachers(){
        if($this->input->is_ajax_request()){
            $groupId = $this->input->get('group_id',true);
            $search = $this->input->get('item',true);
            $event_id = $this->input->get('event_id',true);
            $teacher = $this->input->get('event_teacher_id',true);
            $teacher_1 = $this->input->get('event_teacher_id1',true);
            $teacher_2 = $this->input->get('event_teacher_id2',true);
            $teacher_3 = $this->input->get('event_teacher_id3',true);
            $where_not_in = array();
            if($teacher){
                $where_not_in[] = "'" . $teacher . "'";
            }
            if($teacher_1){
                $where_not_in[] = "'" .$teacher_1. "'";
            }
            if($teacher_2){
                $where_not_in[] = "'" . $teacher_2. "'";
            }
            if($teacher_3){
                $where_not_in[] = "'" . $teacher_3. "'";
            }
            $where_not_in_string = implode(",", $where_not_in);
            $teachers = array();
            if($groupId) {
                $teachers = $this->ProfesorModel->getTeacherBygroup($groupId, $search, $event_id, $where_not_in_string);
            }

            echo json_encode( $teachers);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function unassignEventTeacher(){
        $this->load->model('AgendaModel');
        if($this->input->is_ajax_request()){
            $result = false;
            if($this->input->post('teacher_id', true)){
                $teacher_type = 'IProfesor';
            }elseif($this->input->post('teacher_1_id', true)){
                $teacher_type = 'idprofesoraux';
            }elseif($this->input->post('teacher_2_id', true)){
                $teacher_type = 'idprofesoraux2';
            }elseif($this->input->post('teacher_3_id', true)){
                $teacher_type = 'idprofesoraux3';
            }else{
                $teacher_type = false;
            }

            $groupId = $this->input->post('group_id', true);
            $event_id = $this->input->post('event_id', true);
            if($groupId && $event_id && $teacher_type) {
//                $Linking_data = $this->AgendaModel->CheckLinkingEvents($event_id);
                $Linking_data = $this->AgendaModel->CheckLinkingEventsById($event_id);
                $result = $this->AgendaGrupoModel->unassignEventTeacher($groupId, $event_id, $teacher_type);
                if($Linking_data) {
                    if($teacher_type == 'IProfesor'){
                        $update_data = array($teacher_type=>0, 'idprofesoraux'=>0, 'idprofesoraux2'=>0, 'idprofesoraux3'=>0);
                    }else{
                        $update_data = array($teacher_type=>0);
                    }
                    foreach($Linking_data as $agenda){
                        $where_ids[] = $agenda->INDICE;
                    }
                    $this->AgendaModel->updateStudentEvent($where_ids, $update_data);
//                    $this->AgendaModel->unassignEventTeacher($groupId, $event_id, $teacher_type);
                }
            }

            echo json_encode(array('success' => $result));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function unassignEventClassroom(){
        $this->load->model('AgendaModel');
        if($this->input->is_ajax_request()){
            $result = false;

            $groupId = $this->input->post('group_id', true);
            $event_id = $this->input->post('event_id', true);
            if($groupId && $event_id ) {
//                $Linking_data = $this->AgendaModel->CheckLinkingEvents($event_id);
                $Linking_data = $this->AgendaModel->CheckLinkingEventsById($event_id);
                $result = $this->AgendaGrupoModel->unassignEventClassroom($groupId, $event_id);
                if($Linking_data) {
                    foreach ($Linking_data as $agenda) {
                        $where_ids[] = $agenda->INDICE;
                    }
                    $this->AgendaModel->updateStudentEvent($where_ids, array('Aula' => '0'));
                }
            }

            echo json_encode(array('success' => $result));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }


    public function getEventsList(){
        if($this->input->is_ajax_request()){
            $event_list = array();

            $groupId = $this->input->post('group_id', true);
            if($groupId) {
                $event_list = $this->AgendaGrupoModel->getEventsList($groupId);
            }
            $is_allow_conflicts_calendars = $this->Variables2Model->get_allow_conflicts_calendars();


            echo json_encode(array('data' => $event_list, 'is_allow_conflicts_calendars' => $is_allow_conflicts_calendars));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }


    public function deleteCalendarEvent(){
        if($this->input->is_ajax_request()){
           $result = false;
            $last_first_date = array();
            $events = array();

            $groupId = $this->input->post('group_id', true);
            $events_ids = $this->input->post('events_ids', true);
            $udate_start_end_date = ($this->input->post('udate_start_end_date', true) == 'true' ) ? 1: 0;
            if($groupId && is_array($events_ids) && !empty($events_ids)) {

                $this->load->model('AgendaModel');
//                $Linking_data = $this->AgendaModel->CheckLinkingEventsIds($events_ids);
                $Linking_data = $this->AgendaModel->CheckLinkingEventsIdsById($events_ids);
                $teachers_data = $this->AgendaGrupoModel->getTeachersDataByEvent($events_ids);

                $result = $this->AgendaGrupoModel->deleteEvents($events_ids);
                if($result){
                    if(!empty($Linking_data)){
                        $where_ids = array();
                        foreach($Linking_data as $agenda){
                            $where_ids[] = $agenda->INDICE;
                        }

                        $student_data = $this->AgendaModel->getStudentsDataByEvent($where_ids);
                        if(!empty($student_data)) {
                            foreach ($student_data as $student) {
                                $replace_data = array(
                                    'FIRSTNAME' => $student->first_name,
                                    'SURNAME' => $student->last_name,
                                    'FULLNAME' => $student->full_name,
                                    //'PHONE1' => ,
                                    'MOBILE' => $student->mobile,
                                    'EMAIL1' => $student->email,
                                    'COURSE_NAME' => $student->course_name,
                                    //'GROUP' => $teacher->course_name,
                                    'START_DATE' => date('"F j, Y', strtotime($student->start_date)),
                                    'END_DATE' => date('"F j, Y', strtotime($student->start_date)),
                                );

                                $this->load->model('ErpEmailsAutomatedModel');
                                $template = $this->ErpEmailsAutomatedModel->getByTemplateId('13', array('notify_student' => 1));
//                                if (!empty($template) && !empty($student->email)) {
//                                    $email_subject = replaceTemplateBody($template->Subject, $replace_data);
//                                    $email_body = replaceTemplateBody($template->Body, $replace_data);
//                                    $this->send_automated_email($student->email, $email_subject, $email_body, $template->from_email);
//                                }
                                if(!empty($template) && (!empty($student->email) ||  !empty($student->tut1_email1) || !empty($student->tut2_email2))){
                                    $email_subject = replaceTemplateBody($template->Subject, $replace_data);
                                    $email_body = replaceTemplateBody($template->Body, $replace_data);
                                    if (!empty($template) && !empty($student->email)) {
                                        $this->send_automated_email($student->email, $email_subject, $email_body, $template->from_email);
                                    }
                                    if (!empty($template) && !empty($student->tut1_email1)) {
                                        $this->send_automated_email($student->tut1_email1, $email_subject, $email_body, $template->from_email);
                                    }
                                    if (!empty($template) && !empty($student->tut2_email1)) {
                                        $this->send_automated_email($student->tut2_email1, $email_subject, $email_body, $template->from_email);
                                    }
                                }
                            }
                        }

                        if(!empty($teachers_data)) {
                            foreach ($teachers_data as $teacher) {
                                $replace_data = array(
                                    'FIRSTNAME' => $teacher->first_name,
                                    'SURNAME' => $teacher->last_name,
                                    'FULLNAME' => $teacher->full_name,
                                    //'PHONE1' => ,
                                    'MOBILE' => $teacher->mobile,
                                    'EMAIL1' => $teacher->email,
                                    'COURSE_NAME' => $teacher->course_name,
                                    //'GROUP' => $teacher->course_name,
                                    'START_DATE' => date('"F j, Y', strtotime($teacher->start_date)),
                                    'END_DATE' => date('"F j, Y', strtotime($teacher->start_date)),
                                );

                                $this->load->model('ErpEmailsAutomatedModel');
                                $template = $this->ErpEmailsAutomatedModel->getByTemplateId('13', array('notify_student' => 1));
                                if (!empty($template) && !empty($teacher->email)) {
                                    $email_subject = replaceTemplateBody($template->Subject, $replace_data);
                                    $email_body = replaceTemplateBody($template->Body, $replace_data);
                                    $this->send_automated_email($teacher->email, $email_subject, $email_body, $template->from_email);
                                }
                            }
                        }
                        
                        $this->AgendaModel->deleteEvents($where_ids);
                    }
               }
                if($udate_start_end_date) {
                    $last_first_date = $this->updateGroupDate($groupId, 1);
                }
                $events = $this->AgendaGrupoModel->getEvents($groupId);
            }

            echo json_encode(array('success' => $result, 'last_first_date' => $last_first_date, 'events'=>$events));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getHours(){
        if($this->input->is_ajax_request()){
            $result = false;

            $groupId = $this->input->post('group_id', true);
            $course_id = $this->input->post('course_id', true);
            if($groupId && $course_id) {
                $result = $this->GruposlModel->getHoursByCourse($groupId, $course_id);
            }

            echo json_encode(array('hours' => $result->hours));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function getCourseData(){
        if($this->input->is_ajax_request()){
            $result = false;

            $groupId = $this->input->post('group_id', true);
            $course_id = $this->input->post('course_id', true);
            if($groupId && $course_id) {
                $result = $this->GruposlModel->getCourses($groupId, $course_id);
                $teachers = $this->ProfesorModel->getTeacherForEventsByCourseId($groupId, $course_id);
            }

            echo json_encode(array('result' => $result[0], 'teachers'=>$teachers));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getEventById(){
        if($this->input->is_ajax_request()){
           $result = false;

            $groupId = $this->input->post('group_id', true);
            $events_ids = $this->input->post('events_ids', true);
            if($groupId ) {
                $this->data['classrooms'] = $this->GruposlModel->getClassrooms($groupId);
                var_dump($events_ids);exit;
                //$result = $this->AgendaGrupoModel->deleteEvents($events_ids);
            }

            echo json_encode(array('success' => $result));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function checkHolidays(){
        if($this->input->is_ajax_request()){
            $holidays = array();
            $days_list = $this->input->post('days_list', true);
            if(!empty($days_list) && is_array($days_list)) {
                $this->load->model('FestividadesModel');
                $dats = array();
                foreach($days_list as $list){
                    if($list['date']) {
                        $dats[] = $list['date'];
                    }
                }
               //$where_date_in =  implode(",", $days_list);
                //trim($where_date_in, ',');
                $holidays = $this->FestividadesModel->getHolidaysBydate($dats);
            }

            echo json_encode(array('data' => $holidays));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function saveIntervalsData(){
        if($this->input->is_ajax_request()){
            $this->load->model('FestividadesModel');
            $intrvals_data = $this->input->post('intervals_data');
            $course_id = $this->input->post('course_id', true);
            $group_id = $this->input->post('group_id', true);
            $selected_teachers = $this->input->post('selected_teachers', true);
            $classroom_id = $this->input->post('classroom_id', true);
            $allow_change_date = $this->input->post('allow_change_date', true);

            $allWeekDays = array();//$this->input->post('allWeekDays');
            $response_data = array();
            $insert_data = array();
            $resp_event_data = array();
            $counter = 0;
//            $num_hours = $course_id ? $this->GruposlModel->getHoursByCourse($group_id, $course_id) : null;
            if(!empty($intrvals_data)){
                foreach($intrvals_data as $interval){
                    if($counter > 6){
                        break;
                    }
                    $start_date = isset($interval['start_date']) ? $interval['start_date'] : null;
                    $end_date = isset($interval['end_date']) ? $interval['end_date'] : null;
                    $start_time = isset($interval['start_time']) ? $interval['start_time'] : null;
                    $end_time = isset($interval['end_time']) ? $interval['end_time'] : null;
                    $week_days = isset($interval['week_days']) ? $interval['week_days'] : null;
                    $allow_conflicts = isset($interval['allow_conflicts']) ? $interval['allow_conflicts'] : null;
                    $checking_date = $this->checkingStartEndDate($start_date, $end_date);
                    $checking_time = $this->checkingStartEndTime($start_time, $end_time);
                    $week_days_where_in = $this->getWeekDaysStr($week_days);

                    if(!$checking_date){
                        $error_msg[] = $this->lang->line('groups_start_end_date_not_valid');
                    }

                    if(!$checking_time){
                        $error_msg[] = $this->lang->line('groups_start_end_time_not_valid');
                    }

                    if(empty($week_days_where_in)){
                        $error_msg[] = $this->lang->line('groups_select_week_day');
                    }

                    if(empty($error_msg) && !empty($group_id) ){
                        $exp_start_time = explode(':', $start_time);
                        $exp_end_time = explode(':', $end_time);
                        $start_time_concat = $exp_start_time[0].$exp_start_time[1];
                        $end_time_concat = $exp_end_time[0].$exp_end_time[1];
                        $event_data = (object)array(
                            'group_id' => $group_id,
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'start_time' => $start_time_concat,
                            'end_time' => $end_time_concat,
                            'week_days' => $week_days_where_in,
                        );
                        //solve conflict

                        if(!$allow_conflicts) {
                            $checking_exist_event = $this->checkingExistEvent($event_data);
                            if (!empty($checking_exist_event)) {
                                $response_data = $checking_exist_event;
                                $error_msg[] = $this->lang->line('groups_exist_event');
                            }
                            $checking_availability_teachers = $this->checkingAvailabilityTeachers($selected_teachers, $event_data);

                            if (!empty($checking_availability_teachers)) {
                                $response_data = array_merge($response_data, $checking_availability_teachers);
                                $error_msg[] = $this->lang->line('groups_conflict_teacher');
                            }

                            if ($classroom_id) {
                                $checking_availability_classroom = $this->checkingAvailabilityClassroom($classroom_id, $event_data);
                                if (!empty($checking_availability_classroom)) {
                                    $response_data = array_merge($response_data, $checking_availability_classroom);
                                    $error_msg[] = $this->lang->line('groups_conflict_classroom');
                                }
                            }
                        }
                        // end solve conflict
                        $currentDate = strtotime($start_date);
                        $end = strtotime($end_date);
                    while ($currentDate <= $end) {
                         $week_num = date('w', $currentDate);
                        $week_days_[] = date('w', $currentDate);
                        $date = date('Y-m-d', $currentDate);
                        $is_holidays = $this->FestividadesModel->getHolidaysBydate(array(0 => $date));
                        if(in_array($week_num, $week_days) && empty($is_holidays)) {
                            array_push($allWeekDays, array(
                                'date' => $date,
                                'week_num' => $week_num,
                                'start_time' => $start_time,
                                'end_time' => $end_time,
                            ));
                        }
                        $currentDate = $currentDate + (3600*24);
                    }
                    }
                    $counter ++;

                }

            }
            if(!empty($allWeekDays)) {
                if (!empty($response_data)) {
                    foreach ($allWeekDays as $day) {
                        $conf_exist = false;
                        foreach ($response_data as $conf_day) {
                            $conf_start_h = (int)substr($conf_day->start_time, 0, 2);
                            $conf_end_h = (int)substr($conf_day->end_time, 0, 2);
                            $start_h = (int)substr($day['start_time'], 0, 2);
                            $end_h = (int)substr($day['end_time'], 0, 2);
                            $week_num_ = date('w', strtotime($conf_day->date));
                            if ((($start_h >= $conf_start_h && $start_h <= $conf_end_h) || ($end_h >= $conf_start_h && $end_h <= $end_h)) && $week_num_ == $day['week_num']) {
                                $conf_exist = true;
                                break;
                            }
                        }
                        if (!$conf_exist) {
                            $loc_start_time = explode(':', $day['start_time']);
                            $loc_end_time = explode(':', $day['end_time']);
                            $teacher_min = isset($selected_teachers['min_teacher_id']) ? $selected_teachers['min_teacher_id'] : null;
                            $second_teacher_1_id = isset($selected_teachers['second_teacher_1_id']) ? $selected_teachers['second_teacher_1_id'] : null;
                            $second_teacher_2_id = isset($selected_teachers['second_teacher_2_id']) ? $selected_teachers['second_teacher_2_id'] : null;
                            $second_teacher_3_id = isset($selected_teachers['second_teacher_3_id']) ? $selected_teachers['second_teacher_3_id'] : null;
                            $loc_array = array(
                                'CodigoGrupo' => $group_id,
                                'Fecha' => $day['date'],
                                'Inicio' => $loc_start_time[0] . $loc_start_time[1],
                                'Fin' => $loc_end_time[0] . $loc_end_time[1],
                                'ccurso' => $course_id,
                                'Aula' => $classroom_id ? $classroom_id : null,
                                'IProfesor' => $teacher_min,
                                'idprofesoraux' => $second_teacher_1_id,
                                'idprofesoraux2' => $second_teacher_2_id,
                                'idprofesoraux3' => $second_teacher_3_id,
                                'NumHoras' => $this->getTimeDifference($day['start_time'], $day['end_time']),
                            );

                            array_push($insert_data, $loc_array);
                            array_push($resp_event_data, $day);
                        }
                    }

                } else {
                    foreach ($allWeekDays as $day) {
                        $loc_start_time = explode(':', $day['start_time']);
                        $loc_end_time = explode(':', $day['end_time']);
                        $teacher_min = isset($selected_teachers['min_teacher_id']) ? $selected_teachers['min_teacher_id'] : null;
                        $second_teacher_1_id = isset($selected_teachers['second_teacher_1_id']) ? $selected_teachers['second_teacher_1_id'] : null;
                        $second_teacher_2_id = isset($selected_teachers['second_teacher_2_id']) ? $selected_teachers['second_teacher_2_id'] : null;
                        $second_teacher_3_id = isset($selected_teachers['second_teacher_3_id']) ? $selected_teachers['second_teacher_3_id'] : null;
                        $loc_array = array(
                            'CodigoGrupo' => $group_id,
                            'Fecha' => $day['date'],
                            'Inicio' => $loc_start_time[0] . $loc_start_time[1],
                            'Fin' => $loc_end_time[0] . $loc_end_time[1],
                            'ccurso' => $course_id,
                            'Aula' => $classroom_id ? $classroom_id : null,
                            'IProfesor' => $teacher_min,
                            'idprofesoraux' => $second_teacher_1_id,
                            'idprofesoraux2' => $second_teacher_2_id,
                            'idprofesoraux3' => $second_teacher_3_id,
                            'NumHoras' =>$this->getTimeDifference($day['start_time'], $day['end_time']),
                        );

//                        array_push($insert_data, $loc_array);
                        array_push($resp_event_data, $day);
                        $result = $this->AgendaGrupoModel->addEvent($loc_array);
                        if($result){
                            $this->load->model('AgendaModel');
                            $students_data = $this->AgendaModel->getForGroupByIdForEnroll($group_id, $course_id);
                            if(!empty($students_data)){
                                foreach($students_data as $student){
                                    $loc_array['CALUMNO'] = $student->student_id;
                                    $loc_array['matricula'] = $student->matricula;
                                    $loc_array['agendagrupos_id'] =$result;
                                    $this->AgendaModel->addEvent($loc_array);
                                }
                            }
                        }
                        //OR WE CAN CALL AgendaGrupoModel->addEvents and AgendaModel->addEvents here
                    }
                }
            }
//            if(!empty($insert_data)){
//                $result = $this->AgendaGrupoModel->addEvents($insert_data);
//                if($result){
//                 $agendaId = $result;
//                 $this->load->model('AgendaModel');
//                    $students_data = $this->AgendaModel->getForGroupByIdForEnroll($group_id, $course_id);
//                    if(!empty($students_data)){
//                        foreach($students_data as $student){
//                            foreach($insert_data as &$in_data){
//                                $in_data['CALUMNO'] = $student->student_id;
//                                $in_data['matricula'] = $student->matricula;
//                                $in_data['agendagrupos_id'] =$agendaId;
//                                $agendaId++;
//                            }
//                            $this->AgendaModel->addEvents($insert_data);
//                        }
//                    }
//                }
//            }
            if($allow_change_date) {
              $last_first_date =  $this->updateGroupDate($group_id, 1);
            }
            $events = $this->AgendaGrupoModel->getEvents($group_id);
            
            echo json_encode(array('data' => $resp_event_data, 'last_first_date'=>$last_first_date, 'events'=>$events));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function chackingAddInterval(){
        if($this->input->is_ajax_request()){
            $error_msg = array();
            $response_data = array();
            $used_time_data = array();
            $course_id = $this->input->post('course_id', true);
            $group_id = $this->input->post('group_id', true);
            $selected_teachers = $this->input->post('selected_teachers', true);
            $classroom_id = $this->input->post('classroom_id', true);
            $start_date = $this->input->post('start_date', true);
            $end_date = $this->input->post('end_date', true);
            $start_time = $this->input->post('start_time', true);
            $end_time = $this->input->post('end_time', true);
            $week_days = $this->input->post('week_days', true);

            $checking_date = $this->checkingStartEndDate($start_date, $end_date);
            $checking_time = $this->checkingStartEndTime($start_time, $end_time);
            $week_days_where_in = $this->getWeekDaysStr($week_days);

            if(!$checking_date){
                $error_msg[] = $this->lang->line('groups_start_end_date_not_valid');
            }

            if(!$checking_time){
                $error_msg[] = $this->lang->line('groups_start_end_time_not_valid');
            }

            if(empty($week_days_where_in)){
                $error_msg[] = $this->lang->line('groups_select_week_day');
            }

            if(empty($error_msg) && !empty($group_id) ){
                $exp_start_time = explode(':', $start_time);
                $exp_end_time = explode(':', $end_time);
                $start_time_concat = $exp_start_time[0].$exp_start_time[1];
                $end_time_concat = $exp_end_time[0].$exp_end_time[1];
                $event_data = (object)array(
                    'group_id' => $group_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'start_time' => $start_time_concat,
                    'end_time' => $end_time_concat,
                    'week_days' => $week_days_where_in,
                );
                $checking_exist_event = $this->checkingExistEvent($event_data);
                if(!empty($checking_exist_event)){
                    $response_data = $checking_exist_event;
                    $error_msg[] = $this->lang->line('groups_exist_event');
                }
                $checking_availability_teachers = $this->checkingAvailabilityTeachers($selected_teachers, $event_data);
                if(!empty($checking_availability_teachers)){
                    $response_data = array_merge($response_data, $checking_availability_teachers);
                    $error_msg[] = $this->lang->line('groups_conflict_teacher');
                }

                if($classroom_id) {
                    $checking_availability_classroom = $this->checkingAvailabilityClassroom($classroom_id, $event_data);
                    $used_classroom_time = $this->checkingAvailabilityClassroom($classroom_id, $event_data, true);
                    if(!empty($checking_availability_classroom)){
                        $response_data = array_merge($response_data, $checking_availability_classroom);
                        $error_msg[] = $this->lang->line('groups_conflict_classroom');
                    }

                    if(!empty($used_classroom_time)){
                        $used_time_data = array_merge($used_time_data, $used_classroom_time);
                    }
                }
                $event_used_time = $this->AgendaGrupoModel->getEventUsedTime($event_data);
                if(!empty($event_used_time)){
                    $used_time_data = array_merge($used_time_data, $event_used_time);
                }
                $teachers_used_time = $this->checkingAvailabilityTeachers($selected_teachers, $event_data, true);

                if(!empty($teachers_used_time)){
                    $used_time_data = array_merge($used_time_data, $teachers_used_time);
                }

            }

            echo json_encode(array('error_data' => $error_msg, 'data' => $response_data, 'used_time_data' => $used_time_data));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    private function checkingExistEvent($data){
        $result = $this->AgendaGrupoModel->checkingExistEvent($data);

        return $result;
    }

    private function checkingAvailabilityClassroom($classroom_id, $event_data, $used_time = false, $by_day = false){
        if($used_time && $by_day){
            $result1 = $this->AgendaGrupoModel->checkingAvailabilityClassroomByDay($classroom_id, $event_data);
            $result2 = $this->AgendaGrupoModel->checkingInternalEventClassroomByDay($classroom_id, $event_data);
        }elseif($by_day){
            $result1 = $this->AgendaGrupoModel->getClassroomUsedTimeByDay($classroom_id, $event_data);
            $result2 = $this->AgendaGrupoModel->getInternalEventClassroomUsedTimeByDay($classroom_id, $event_data);
        }elseif($used_time){
            $result1 = $this->AgendaGrupoModel->getClassroomUsedTime($classroom_id, $event_data);
            $result2 = $this->AgendaGrupoModel->getInternalEventClassroomUsedTime($classroom_id, $event_data);

        }else{
            $result1 = $this->AgendaGrupoModel->checkingAvailabilityClassroom($classroom_id, $event_data);
            $result2 = $this->AgendaGrupoModel->checkingInternalEventClassroom($classroom_id, $event_data);

        }


        if(!empty($result1) && !empty($result2)){
            $result = array_merge($result1, $result2);
        }elseif(!empty($result1)){
            $result = $result1;
        }elseif(!empty($result2)){
            $result = $result2;
        }else{
            $result = array();
        }

        return $result;

    }

    private function checkingAvailabilityTeachers($selected_teachers, $event_data, $used_time = false, $by_date = false){
        if(!empty($selected_teachers)){
            $where = '';
            $where_id_in = '';
            $ids = array();
            $ids['teacher_min'] = isset($selected_teachers['min_teacher_id']) && !empty($selected_teachers['min_teacher_id']) ? $selected_teachers['min_teacher_id'] : false;
            $ids['teacher_1'] = isset($selected_teachers['second_teacher_1_id']) && !empty($selected_teachers['second_teacher_1_id']) ? $selected_teachers['second_teacher_1_id'] : false;
            $ids['teacher_2'] = isset($selected_teachers['second_teacher_2_id']) && !empty($selected_teachers['second_teacher_2_id']) ? $selected_teachers['second_teacher_2_id'] : false;
            $ids['teacher_3'] = isset($selected_teachers['second_teacher_3_id']) && !empty($selected_teachers['second_teacher_3_id']) ? $selected_teachers['second_teacher_3_id'] : false;
            $result2 = null;
            $result1 = null;
            foreach($ids as $id){
               if($id){
                   if(!empty($where)){
                       $where .= ' OR ';
                   }
                   $where_id_in .= "'".$id."',";
                   $where .= "iProfesor='".$id."' OR idprofesoraux = '".$id."' OR idprofesoraux2 = '".$id."' OR idprofesoraux3 = '".$id."'";
               }
            }
            if(!empty($where)){
                if($used_time){
                    $result1 = $this->AgendaGrupoModel->getTeachersUsedTime($where, $event_data);
                }elseif($by_date){
                    $result1 = $this->AgendaGrupoModel->availabilityTeachersBydate($where, $event_data);
                }else{
                    $result1 = $this->AgendaGrupoModel->checkAvailabilityTeachers($where, $event_data);
                }

                $where_id_in = trim($where_id_in, ',');
                if(!empty($where_id_in)) {
                    if($used_time){
                        $result2 = $this->AgendaGrupoModel->getPersonalEventTeachersUsedTime($where_id_in, $event_data);
                    }elseif($by_date){
                        if(isset($event_data->event_id)){
                            $result2 = $this->AgendaGrupoModel->personalEventTeachersBydateEventId($where_id_in, $event_data);
                        }else {
                            $result2 = $this->AgendaGrupoModel->personalEventTeachersBydate($where_id_in, $event_data);
                        }

                    }else{
                        $result2 = $this->AgendaGrupoModel->checkPersonalEventTeachers($where_id_in, $event_data);

                    }

                }
            }

            if(!empty($result1) && !empty($result2)){
                $result = array_merge($result1, $result2);
            }elseif(!empty($result1)){
                $result = $result1;
            }elseif(!empty($result2)){
                $result = $result2;
            }else{
                $result = array();
            }

            return $result;
        }

        return null;
    }

    private function getWeekDaysStr($week_days){
        $result = '';
        if(!empty($week_days) && is_array($week_days)){
            foreach($week_days as $week_num){
                if(isset($this->sql_week_days[$week_num])) {
                    $result .= "'" . $this->sql_week_days[$week_num] . "',";
                }
            }
            $result = trim($result, ',');
        }else{
            return null;
        }
        return $result;
    }

    private function checkingStartEndDate($start_date, $end_date){
        if(!empty($start_date) && !empty($end_date)) {
            $format = 'Y-m-d';
            $s_d = DateTime::createFromFormat($format, $start_date);
            $e_d = DateTime::createFromFormat($format, $end_date);
            //Check for valid date in given format
            if ($s_d && $s_d->format($format) == $start_date && $e_d && $e_d->format($format) == $end_date) {
                if (strtotime($start_date) <= strtotime($end_date)) {
                    return true;
                }
            }
        }
        return false;
    }

    private function checkingStartEndTime($start_time, $end_time){
        if(!empty($start_time) && !empty($end_time)) {

            if(preg_match("/(2[0-4]|[01][1-9]|10):([0-5][0-9])/", $start_time)
                && preg_match("/(2[0-4]|[01][1-9]|10):([0-5][0-9])/", $end_time)){
                if (strtotime($start_time) < strtotime($end_time)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getNotSelectedTeachers(){
        if($this->input->is_ajax_request()){
            $teachers = array();
            $group_id = $this->input->post('group_id', true);
            $course_id = $this->input->post('course_id', true) ? $this->input->post('course_id', true) : '';
            $teachers_id= $this->input->post('selected_teachers', true);
            if(!empty($group_id)) {
                $where_not_in = '';
                if(is_array($teachers_id) && !empty($teachers_id))
                 foreach($teachers_id as $teacher){
                     if(!empty($teacher)) {
                         $where_not_in .= "'" . $teacher . "',";
                     }
                 }
                $where_not_in = trim($where_not_in, ',');
                if($course_id) {
                    $teachers = $this->ProfesorModel->getTeacherForEventsByCourseId($group_id, $course_id, $where_not_in);
                }else{
                    $teachers = $this->ProfesorModel->getTeacherForEvents($group_id, $where_not_in);
                }
            }

            echo json_encode(array('data' => $teachers));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function getNotSelectedClassrooms(){
        if($this->input->is_ajax_request()){
            $classrooms = array();
            $group_id = $this->input->post('group_id', true);
            $classrooms_id= $this->input->post('selected_classrooms', true);
            if(!empty($group_id)) {
                $where_not_in = '';
                if(is_array($classrooms_id) && !empty($classrooms_id))
                 foreach($classrooms_id as $classroom){
                     if(!empty($classroom)) {
                         $where_not_in .= "'" . $classroom . "',";
                     }
                 }
                $where_not_in = trim($where_not_in, ',');
                $classrooms = $this->GruposlModel->getClassrooms($group_id, $where_not_in);
            }

            echo json_encode(array('data' => $classrooms));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function getNotSelectedClassroomsForEvent(){
        if($this->input->is_ajax_request()){
            $classrooms = array();
            $event_id= $this->input->get('event_id', true);
            $date = $this->input->get('date', true);
            $start_period = $this->input->get('start', true);
            $end_period = $this->input->get('end', true);
            $start_period_array = explode(':', $start_period);
            $end_period_array = explode(':', $end_period);
            $start = $start_period_array[0].$start_period_array[1];
            $end = $end_period_array[0].$end_period_array[1];
            $classrooms= $this->GruposlModel->getNotSelectedClassrooms($event_id, $date, $start, $end);
            echo json_encode( $classrooms);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function saveEventData(){
        if($this->input->is_ajax_request()){
           $result = false;
           $last_first_date = array();
            $error_msg = array();
//            $response_data = array();

            $groupId = $this->input->post('group_id', true);
            $event_id = $this->input->post('event_id', true);
            $post_data = $this->input->post('post_data', true);
            $udate_start_end_date = (isset($post_data['udate_start_end_date']) && $post_data['udate_start_end_date'] == 'true' ) ? 1: 0;
            $periods = $this->getAvailabilityTimaes(false);
            $start_period = isset($periods[$post_data['start_period']]) ? $periods[$post_data['start_period']] : $periods[0];
            $end_period = isset($periods[$post_data['end_period']]) ? $periods[$post_data['end_period']] : $periods[1];
            $start_period_array = explode(':', $start_period);
            $end_period_array = explode(':', $end_period);

            if($groupId && $post_data && $event_id) {
                $start_time_concat = $start_period_array[0].$start_period_array[1];
                $end_time_concat = $end_period_array[0].$end_period_array[1];

                $event_data = (object)array(
                    'group_id' => $groupId,
                    'event_id' => $event_id,
                    'date' => date("Y-m-d", strtotime($post_data['date'])),
                    'start_time' => $start_time_concat,
                    'end_time' => $end_time_concat
                );
                $selected_teachers = array();
                if($post_data['teacher_id']){
                    $selected_teachers['min_teacher_id'] =$post_data['teacher_id'];
                }
                if($post_data['idprofesoraux1']){
                    $selected_teachers['second_teacher_1_id'] =$post_data['idprofesoraux1'];
                }
                if($post_data['idprofesoraux2']){
                    $selected_teachers['second_teacher_2_id'] =$post_data['idprofesoraux2'];
                }
                if($post_data['idprofesoraux3']){
                    $selected_teachers['second_teacher_3_id'] =$post_data['idprofesoraux3'];
                }
//                $checking_exist_event = $this->checkingExistEvent($event_data);
                $checking_exist_event = $this->AgendaGrupoModel->checkingExistEventThisDay($event_data);
                if (!empty($checking_exist_event)) {
//                    $response_data = $checking_exist_event;
                    $error_msg[] = $this->lang->line('groups_exist_event');
                }
                $checking_availability_teachers = $this->checkingAvailabilityTeachers($selected_teachers, $event_data, false, true);
                if (!empty($checking_availability_teachers)) {
//                    $response_data = array_merge($response_data, $checking_availability_teachers);
                    $error_msg[] = $this->lang->line('groups_conflict_teacher');
                }
                if ($post_data['classroom_id']) {
                    $checking_availability_classroom = $this->checkingAvailabilityClassroom($post_data['classroom_id'], $event_data, true, true);
                    if (!empty($checking_availability_classroom)) {
//                        $response_data = array_merge($response_data, $checking_availability_classroom);
                        $error_msg[] = $this->lang->line('groups_conflict_classroom');
                    }
                }

            if(!empty($error_msg)){
                echo json_encode(array('success' => $result)); exit;
            }
                $update_data = array(
                        'IProfesor' => isset($post_data['teacher_id']) ? $post_data['teacher_id'] : 0,
                        'Aula' => isset($post_data['classroom_id']) ? $post_data['classroom_id'] : 0,
                        'ccurso' => isset($post_data['course']) ? $post_data['course'] : null,
                        'Inicio' =>$start_time_concat,
                        'Fin' => $end_time_concat,
                        'idprofesoraux' => isset($post_data['idprofesoraux1']) ? $post_data['idprofesoraux1'] : 0,
                        'idprofesoraux2' => isset($post_data['idprofesoraux2']) ? $post_data['idprofesoraux2'] : 0,
                        'idprofesoraux3' => isset($post_data['idprofesoraux3']) ? $post_data['idprofesoraux3'] : 0,
                        'NumHoras' => $this->getTimeDifference($start_period, $end_period )
                );
                if(isset($post_data['date']) && !empty($post_data['date'])){
                    $update_data['Fecha'] = date("Y-m-d H:i:s", strtotime($post_data['date']));
                }
                $this->load->model('AgendaModel');
//                $Linking_data = $this->AgendaModel->CheckLinkingEvents($event_id);
                $Linking_data = $this->AgendaModel->CheckLinkingEventsById($event_id);

                $result = $this->AgendaGrupoModel->updateEventData($groupId, $event_id, $update_data);
                if($udate_start_end_date) {
                    $last_first_date = $this->updateGroupDate($groupId, 1);
                }
                if($result){
                    if(!empty($Linking_data)){
                        $where_ids = array();
                        foreach($Linking_data as $agenda){
                            $where_ids[] = $agenda->INDICE;
                        }
                        $this->AgendaModel->updateStudentEvent($where_ids, $update_data);
                        $student_data = $this->AgendaModel->getStudentsDataByEvent($where_ids);
                        if(!empty($student_data)) {
                            foreach ($student_data as $student) {
                                $replace_data = array(
                                    'FIRSTNAME' => $student->first_name,
                                    'SURNAME' => $student->last_name,
                                    'FULLNAME' => $student->full_name,
                                    //'PHONE1' => ,
                                    'MOBILE' => $student->mobile,
                                    'EMAIL1' => $student->email,
                                    'COURSE_NAME' => $student->course_name,
                                    //'GROUP' => $teacher->course_name,
                                    'START_DATE' => date('"F j, Y', strtotime($student->start_date)),
                                    'END_DATE' => date('"F j, Y', strtotime($student->start_date)),
                                );

                                $this->load->model('ErpEmailsAutomatedModel');
                                $template = $this->ErpEmailsAutomatedModel->getByTemplateId('9', array('notify_student' => 1));
//                                if (!empty($template) && !empty($student->email)) {
//                                    $email_subject = replaceTemplateBody($template->Subject, $replace_data);
//                                    $email_body = replaceTemplateBody($template->Body, $replace_data);
//                                    $this->send_automated_email($student->email, $email_subject, $email_body, $template->from_email);
//                                }
                                if(!empty($template) && (!empty($student_data->student_email) ||  !empty($student_data->tut1_email1) || !empty($student_data->tut2_email2))){
                                    $email_subject = replaceTemplateBody($template->Subject, $replace_data);
                                    $email_body = replaceTemplateBody($template->Body, $replace_data);
                                    if (!empty($template) && !empty($student_data->student_email)) {
                                        $this->send_automated_email($student_data->student_email, $email_subject, $email_body, $template->from_email);
                                    }
                                    if (!empty($template) && !empty($student_data->tut1_email1)) {
                                        $this->send_automated_email($student_data->tut1_email1, $email_subject, $email_body, $template->from_email);
                                    }
                                    if (!empty($template) && !empty($student_data->tut2_email1)) {
                                        $this->send_automated_email($student_data->tut2_email1, $email_subject, $email_body, $template->from_email);
                                    }
                                }
                            }
                        }
                    }
                    $teachers_data = $this->AgendaGrupoModel->getTeachersDataByEvent(array($event_id));

                    if(!empty($teachers_data)) {
                        foreach ($teachers_data as $teacher) {
                            $replace_data = array(
                                'FIRSTNAME' => $teacher->first_name,
                                'SURNAME' => $teacher->last_name,
                                'FULLNAME' => $teacher->full_name,
                                //'PHONE1' => ,
                                'MOBILE' => $teacher->mobile,
                                'EMAIL1' => $teacher->email,
                                'COURSE_NAME' => $teacher->course_name,
                                //'GROUP' => $teacher->course_name,
                                'START_DATE' => date('"F j, Y', strtotime($teacher->start_date)),
                                'END_DATE' => date('"F j, Y', strtotime($teacher->start_date)),
                            );

                            $this->load->model('ErpEmailsAutomatedModel');
                            $template = $this->ErpEmailsAutomatedModel->getByTemplateId('17', array('notify_student' => 1));
                            if (!empty($template) && !empty($teacher->email)) {
                                $email_subject = replaceTemplateBody($template->Subject, $replace_data);
                                $email_body = replaceTemplateBody($template->Body, $replace_data);
                                $this->send_automated_email($teacher->email, $email_subject, $email_body, $template->from_email);
                            }
                        }
                    }

                }
            }

            echo json_encode(array('success' => $result, 'last_first_date'=>$last_first_date));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    private function updateGroupDate($id_group, $get_data = ''){
        $start_last_date = $this->AgendaGrupoModel->getGroupStartLastDate($id_group);
        $result = false;
        if(!empty($start_last_date) && isset($start_last_date[0]->first_date)){
            $update_data = array(
                'fechainicio' => $start_last_date[0]->first_date,
                'fechafin' => $start_last_date[0]->last_date
            );
          $result = $this->GrupoModel->updateFirstLastDate($update_data,$id_group);
            if($get_data && $result){
              return $update_data;
            }
        }
        return $result;
    }

    private function send_automated_email($email, $subject, $body, $from_email){
        $this->load->model('ErpEmailModel');
        $this->load->model('UsuarioModel');
        $user_id = $this->session->userdata('userData')[0]->Id;
        $cisess = $this->session->userdata('_cisess');
        $membership_type = $cisess['membership_type'];
        $smtp_data = $this->UsuarioModel->getSmtpSettings($user_id);
        $data_recipient = array(
            'from_userid' => $user_id,
            'from_usertype' => '0',
            'id_campaign' => '',
            'email_recipie' => $email,
            'Subject' => $subject,
            'Body' => $body,
            'date' => date('Y-m-d H:i:s'),
        );
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
            $mail->FromName = '';
            $mail->AddAddress($email);
            $mail->WordWrap = 1000;                                 // set word wrap to 50 characters
            $mail->IsHTML(true);
            // set email format to HTML

            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->AltBody = "";
            if(!$mail->Send()) {
                $response['errors'] = $this->lang->line('enrollments_no_send_email');
            }else {
                $response['success'] = $this->lang->line('enrollments_send_email_success');
                $response['errors'] = false;
                $data_recipient['sucess'] = '1';
                $data_recipient['error_msg'] = ''; ;
            }
            $this->ErpEmailModel->insertEmailData($data_recipient);
        }
        else {
            $emails_limit_daily = $this->_db_details->emails_limit_daily;
            $emails_limit_monthly = $this->_db_details->emails_limit_monthly;
            $count_emails_day = $this->ErpEmailModel->getEmailsCountDay($user_id);

            if ($emails_limit_daily > $count_emails_day->count_daily && $emails_limit_monthly > $count_emails_day->count_monthly) {
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
                $request['Source'] = $from_email . ' <' . $email_from['from'] . '>';
                $request['Destination']['ToAddresses'] = array($email);
                $request['Message']['Subject']['Data'] = $subject;
                $request['Message']['Subject']['Charset'] = "UTF-8";
                $request['Message']['Body']['Html']['Data'] = $body;
                $request['Message']['Body']['Charset'] = "UTF-8";
                try {
                    $result = $client->sendEmail($request);
                    $messageId = $result->get('MessageId');
                    //echo("Email sent! Message ID: $messageId"."\n");
                    if ($messageId) {
                        $response['success'] = $this->lang->line('enrollments_send_email_success');
                        $response['errors'] = false;
                        $data_recipient['sucess'] = '1';
                        $data_recipient['error_msg'] = ''; //$e->getMessage(),
                    } else {
                        $response['errors'] = $this->lang->line('enrollments_no_send_email');
                    }

                } catch (Exception $e) {
                    //echo("The email was not sent. Error message: ");
                    //$response['errors'] = $e->getMessage()."\n";
                    $response['errors'] = $this->lang->line('enrollments_no_send_email');
                    $data_recipient['sucess'] = '0';
                    $data_recipient['error_msg'] = $e->getMessage();
                }
                $added_email_id = $this->ErpEmailModel->insertEmailData($data_recipient);
            } else {
                $response['errors'] = $this->lang->line('emails_limit_daily_msg');
            }
        }
        return $response;
    }

    public function getCheckLinkingEvents(){
        if($this->input->is_ajax_request()){
            $this->load->model('AgendaModel');
            $error_msg = array();
//            $response_data = array();
            $group_id = $this->input->post('group_id', true);
            $event_id = $this->input->post('event_id', true);
            $post_data = $this->input->post('post_data', true);
            $periods = $this->getAvailabilityTimaes(false);
            $start_period = isset($periods[$post_data['start_period']]) ? $periods[$post_data['start_period']] : $periods[0];
            $end_period = isset($periods[$post_data['end_period']]) ? $periods[$post_data['end_period']] : $periods[1];
            $start_period_array = explode(':', $start_period);
            $end_period_array = explode(':', $end_period);

            if($group_id && $post_data && $event_id) {
                $start_time_concat = $start_period_array[0].$start_period_array[1];
                $end_time_concat = $end_period_array[0].$end_period_array[1];

                $event_data = (object)array(
                    'group_id' => $group_id,
                    'event_id'=>$event_id,
                    'date' => date("Y-m-d", strtotime($post_data['date'])),
                    'start_time' => $start_time_concat,
                    'end_time' => $end_time_concat
                );
                $selected_teachers = array();
                if($post_data['teacher_id']){
                    $selected_teachers['min_teacher_id'] =$post_data['teacher_id'];
                }
                if($post_data['idprofesoraux1']){
                    $selected_teachers['second_teacher_1_id'] =$post_data['idprofesoraux1'];
                }
                if($post_data['idprofesoraux2']){
                    $selected_teachers['second_teacher_2_id'] =$post_data['idprofesoraux2'];
                }
                if($post_data['idprofesoraux3']){
                    $selected_teachers['second_teacher_3_id'] =$post_data['idprofesoraux3'];
                }
//                $checking_exist_event = $this->checkingExistEvent($event_data);
                $checking_exist_event = $this->AgendaGrupoModel->checkingExistEventThisDay($event_data);
                if (!empty($checking_exist_event)) {
//                    $response_data = $checking_exist_event;
                    $error_msg[] = $this->lang->line('groups_exist_event');
                }
                $checking_availability_teachers = $this->checkingAvailabilityTeachers($selected_teachers, $event_data, false, true);
                if (!empty($checking_availability_teachers)) {
//                    $response_data = array_merge($response_data, $checking_availability_teachers);
                    $error_msg[] = $this->lang->line('groups_conflict_teacher');
                }
                if ($post_data['classroom_id']) {
                    $checking_availability_classroom = $this->checkingAvailabilityClassroom($post_data['classroom_id'], $event_data, true, true);
                    if (!empty($checking_availability_classroom)) {
//                        $response_data = array_merge($response_data, $checking_availability_classroom);
                        $error_msg[] = $this->lang->line('groups_conflict_classroom');
                    }
                }

                if(!empty($error_msg)){
                    echo json_encode(array('success' => 'false', 'error_msg'=>$error_msg)); exit;
                }
                
                $data = $this->AgendaModel->CheckLinkingEvents($event_id);
                $result = !empty($data)  ? true : false;
            }
            echo json_encode(array('result' => $result));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }


    public function assignTeacher(){
        $this->load->model('AgendaModel');
        if($this->input->is_ajax_request()){
           $group_id = $this->input->post('group_id', true);
           $event_ids = $this->input->post('event_ids', true);
           $teacher_id = $this->input->post('teacher_id', true);
            $conflict = false;
            $success = false;
            if(!empty($event_ids) && is_array($event_ids)){
                $where_ids = '';
                foreach($event_ids as $event_id){
                    $where_ids .= "'".$event_id."',";
                }
                $where_ids = trim($where_ids,',');
                $events_data = $this->AgendaGrupoModel->getEventsByIds($group_id, $where_ids);
                $checked_event_ids = array();
                if(!empty($events_data)){
                    $selected_teachers = array('min_teacher_id' => $teacher_id);
                    foreach($events_data as $event) {
                       // $week_days_where_in = $this->getWeekDaysStr(array(date('w', strtotime($event->event_date))));
                        $event_data = (object)array(
                            'group_id' => $group_id,
                            'date' => $event->event_date,
                            'start_time' => $event->start_time,
                            'end_time' => $event->end_time,
                            //'week_days' => $week_days_where_in,
                        );
                        $result = $this->checkingAvailabilityTeachers($selected_teachers, $event_data, false, true);
                        if(!empty($result)){
                            $conflict = true;
                            $checked_event_ids = null;
                            break;
                        }else {
                            $checked_event_ids[] = $event->keyid;
                        }
                    }
                    if(!empty($checked_event_ids)) {
                        $success = $this->AgendaGrupoModel->assignEventTeacher($checked_event_ids, $teacher_id);
                        $Linking_data = $this->AgendaModel->CheckLinkingEventsIdsById($checked_event_ids);
                        if(!empty($Linking_data)) {
                            $where_ids = array();
                            foreach ($Linking_data as $agenda) {
                                $where_ids[] = $agenda->INDICE;
                            }
                            $this->AgendaModel->assignEventTeacher($where_ids, $teacher_id);
                        }
                    }
                }
            }
            echo json_encode(array('conflict' => $conflict, 'success' => $success));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function assignClassroom(){
        $this->load->model('AgendaModel');
        if($this->input->is_ajax_request()){
           $group_id = $this->input->post('group_id', true);
           $event_ids = $this->input->post('event_ids', true);
           $classroom_id = $this->input->post('classroom_id', true);
            $conflict = false;
            $success = false;
            if(!empty($event_ids) && is_array($event_ids)){
                $where_ids = '';
                foreach($event_ids as $event_id){
                    $where_ids .= "'".$event_id."',";
                }
                $where_ids = trim($where_ids,',');
                $events_data = $this->AgendaGrupoModel->getEventsByIds($group_id, $where_ids);
                $checked_event_ids = array();
                if(!empty($events_data)){
                    //$selected_teachers = array('min_teacher_id' => $classroom_id);

                    foreach($events_data as $event) {
                       // $week_days_where_in = $this->getWeekDaysStr(array(date('w', strtotime($event->event_date))));
                        $event_data = (object)array(
                            'group_id' => $group_id,
                            'date' => $event->event_date,
                            'start_time' => $event->start_time,
                            'end_time' => $event->end_time,
                           // 'week_days' => $week_days_where_in,
                        );
                        //$result = $this->checkingAvailabilityClassroom($classroom_id, $event_data);
                        $result_1 = $this->AgendaGrupoModel->AvailabilityClassroomBydate($classroom_id, $event_data);
                        $result_2 = $this->AgendaGrupoModel->InternalEventClassroomBydate($classroom_id, $event_data);

                        if(!empty($result_1) || !empty($result_2)){
                            $conflict = true;
                            $checked_event_ids = null;
                            break;
                        }else {
                            $checked_event_ids[] = $event->keyid;
                        }
                    }
                    if(!empty($checked_event_ids)) {
                        $success = $this->AgendaGrupoModel->assignEventClassroom($checked_event_ids, $classroom_id);
                        $Linking_data = $this->AgendaModel->CheckLinkingEventsIdsById($checked_event_ids);
                        if(!empty($Linking_data)) {
                            $where_ids = array();
                            foreach ($Linking_data as $agenda) {
                                $where_ids[] = $agenda->INDICE;
                            }
                            $this->AgendaModel->assignEventClassroom($where_ids, $classroom_id);
                        }

                    }
                }
            }
            echo json_encode(array('conflict' => $conflict, 'success' => $success));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    // Calendar  End

    // Documents  Start

    public function getDocumentsTable(){
        if($this->input->is_ajax_request()){
            $html = '';
            $group_id = $this->input->post('group_id', true);
            if(!empty($group_id)) {
                $documents = $this->GruposDocModel->getByGroupId($group_id);
                $this->data['documents'] = $documents;
                $this->data['group_id'] = $group_id;

                $html = $this->load->view('groups/partials/documentsView', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getDocuments(){
        if($this->input->is_ajax_request()){
            $group_id = $this->input->post('group_id', true);
            $documents = array();
            if(!empty($group_id)) {
                $documents = $this->GruposDocModel->getByGroupId($group_id);
                $this->data['documents'] = $documents;
            }
            echo json_encode(array('data' => $documents));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function changeDocumentVisible(){
        if($this->input->is_ajax_request()){
            $group_id = $this->input->post('group_id', true);
            $document_id = (int)$this->input->post('document_id', true);
            $visible = (int)$this->input->post('visible', true);
            if($group_id && $document_id) {
                $_visible = $visible == '1' ? 1 : 0;
                $this->GruposDocModel->update('grupos_doc', array('visible' => $_visible), array('codigogrupo' => $group_id, 'id' => $document_id));

            }

            echo json_encode(array('success' => true));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function downloadDoc($group_id = null, $fid=null){
        if(!empty($fid) && !empty($group_id)){
            $result = (array)$this->DocumentModel->group_download($group_id,$fid);
            $docname=str_replace(" ","_",$result['documento']);
            header ("Content-Disposition: attachment; filename=".$docname." ");
            header ("Content-Type: application/octet-stream");
            header ("Content-Length: ".$result['blob']);
            echo $result['docblob'];
            exit();
        }
    }
    // Documents  End


    // Resources  Start
        // Resources  sub tab Books Start

        public function getResources(){
            if($this->input->is_ajax_request()){
                $html = '';
                $group_id = $this->input->post('group_id', true);
                if(!empty($group_id)) {
                    $books = $this->GmateriallModel->getByGroupId($group_id);
                   // $not_exist_books = $this->ArticulosModel->getByGroupId($group_id);
                    $this->data['books'] = $books;
                   // $this->data['not_exists_books'] = $not_exist_books;
                    $this->data['group_id'] = $group_id;

                    $html = $this->load->view('groups/partials/resourcesView', $this->data, true);
                }
                echo json_encode(array('html' => $html));
                exit;
            }else{
                $this->layouts->view('error_404',$this->data, 'error_404');
            }
        }

        public function addResourcesBook(){
            if($this->input->is_ajax_request()){
                $group_id = $this->input->post('group_id', true);
                $book_id = $this->input->post('book_id', true);
                $title = '';
                $result = false;
                if(!empty($group_id) && !empty($book_id)) {
                    $books_data = $this->ArticulosModel->getById($book_id);
                    if(!empty($books_data)){
                        $title = $books_data->title;
                        $check_exist_id = $this->GmateriallModel->getByGroupId($group_id, $book_id);
                        if(empty($check_exist_id)) {
                            $result = $this->GmateriallModel->insertBookData($group_id, $book_id, $title);
                        }
                    }

                }
                echo json_encode(array('data' => array('book_id' => $book_id, 'title' => $title, 'success' => $result)));
                exit;
            }else{
                $this->layouts->view('error_404',$this->data, 'error_404');
            }
        }

        public function getNotExistBooks(){
                if($this->input->is_ajax_request()){
                    $group_id = $this->input->post('group_id', true);
                    $not_exist_books = array();
                    if(!empty($group_id)) {
                        $not_exist_books = $this->ArticulosModel->getByGroupId($group_id);
                    }
                    echo json_encode(array('data' => $not_exist_books));
                    exit;
                }else{
                    $this->layouts->view('error_404',$this->data, 'error_404');
                }
        }

        public function deleteBook(){
                if($this->input->is_ajax_request()){
                    $group_id = $this->input->post('group_id', true);
                    $book_id = $this->input->post('book_id', true);
                    $result = false;
                    if(!empty($group_id) && !empty($book_id)) {
                        $result = $this->GmateriallModel->deleteBook($group_id, $book_id);
                    }
                    echo json_encode(array('success' => $result));
                    exit;
                }else{
                    $this->layouts->view('error_404',$this->data, 'error_404');
                }
         }

        // Resources  sub tab Books End

    // Resources  End


    // Reports  Start
    public function getReports(){
        if($this->input->is_ajax_request()){
            $html = '';
            $group_id = $this->input->post('group_id', true);
            if(!empty($group_id)) {
                $this->load->model('MatriculalModel');
                $this->data['students'] = $this->MatriculalModel->getForGroupById($group_id);
                $this->data['courses'] = $this->GruposlModel->getCourses($group_id);
                $this->data['group_id'] = $group_id;

                $html = $this->load->view('groups/partials/reportsView', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getAccounting(){
        if($this->input->is_ajax_request()){
            $group_id = $this->input->post('group_id', true);
            $accounting = array();
            if(!empty($group_id)) {
                $this->load->model('ReciboModel');
                $accounting = $this->ReciboModel->getAccountingForGroup($group_id);
                $total_due = $this->ReciboModel->getTotalDue($group_id);
                $total_cashed = $this->ReciboModel->getTotalCashed($group_id);

            }
            echo json_encode(array('data' => $accounting, 'total_due' => $total_due, 'total_cashed' => $total_cashed));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getAttendance(){
        if($this->input->is_ajax_request()){
            $group_id = $this->input->post('group_id', true);
            $course_id = $this->input->post('course_id', true);
            $attendance = array();
            if(!empty($group_id)) {
                $this->load->model('AgendaModel');
                $attendance = $this->AgendaModel->getForGroupById($group_id, $course_id);

            }
            echo json_encode(array('data' => $attendance));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getReportsList(){
        if($this->input->is_ajax_request()){
            $this->load->model('LstInformesGruposModel');
            $reports_list = $this->LstInformesGruposModel->getlist();

            echo json_encode(array('data' => $reports_list));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }

    }
    public function getReportsData(){
        if($this->input->is_ajax_request()){
            $group_id = $this->input->post('group_id', true);
            $report_id = $this->input->post('report_id', true);
            $reports = array();
            if(!empty($group_id) && !empty($report_id)){
                $this->load->model('LstInformesGruposModel');
                $reports = $this->LstInformesGruposModel->report($report_id, $group_id);
            }

            echo json_encode(array('data' => $reports));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    // Reports  End

    public function checkEnrollments(){
        if($this->input->is_ajax_request()){
            $group_id = $this->input->post('group_id', true);
            $this->load->model('AgendaModel');
            $getEnroll = $this->AgendaModel->getEnrollmentsByGroup($group_id);
            echo json_encode($getEnroll); exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    private function getTimeDifference($startime, $endTime){
        $startime = strtotime($startime.':00');
        $endTime = strtotime($endTime.':00');
        $diffHour = intval((abs($endTime - $startime))/3600);
        $diffMinute = intval((abs($endTime - $startime))/60%60);
        return floatval($diffHour.".". $diffMinute);
    }
    public function saveEventCustomField($group_id, $event_id){
        if($this->input->is_ajax_request()){
            $result = false;
            $error = array();
            $validation = false;
            $field_data_json ='';
            $this->lang->load('clientes_form', $this->data['lang']);
            //get custom fields
            $fields = $this->ErpCustomFieldsModel->getFieldsList('events');
            if($this->input->post('custom_fields', true)) {
                $this->config->set_item('language', $this->data['lang']);
                $field_data = $this->input->post('custom_fields', true);
                foreach ($fields as $field) {
                    if($field['required'] && $field['field_type'] != 'checkbox') {
                        $validation = true;
                        $this->form_validation->set_rules('custom_fields[' . $field['id'] . ']', "<b>" . $field['field_name'] . "</b>", "trim|required");
                    }
                }
                if(!$validation || $this->form_validation->run()){
                    if(!array_filter($field_data)){
                        $field_data_json = '';
                    }else{
                        $field_data_json = json_encode($field_data);
                    }
                    $update_data = array('custom_fields'=>$field_data_json);
                    $result = $this->AgendaGrupoModel->updateEventData($group_id, $event_id, $update_data);
                }else{
                    $error = $this->form_validation->error_array();
                }
            }
            echo json_encode(array('success'=>$result, 'update_data'=>$field_data_json,  'error'=>$error));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }


}
