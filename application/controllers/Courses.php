<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (empty($this->_identity['loggedIn'])) {
            redirect('/auth/login/', 'refresh');
        }
        $this->lang->load('courses', $this->data['lang']);

        $this->load->model('CursoModel');
        $this->load->model('AreasAcademicaModel');
        $this->load->model('CursosModel');
        $this->load->model('CursoTabAdModel');
        $this->load->model('CursoDocModel');
        $this->load->model('CursoArticulosModel');
        $this->load->model('CursoRecursosModel');
        $this->load->model('LstInformesCursoModel');

        $this->load->helper('htmlpurifier');
        $this->load->library('form_validation');
        $this->layouts->add_includes('js', 'app/js/courses/main.js');
    }

    public function index()
    {
        $this->lang->load('quicktips', $this->data['lang']);
        $this->data['page'] = 'courses_index';
        $this->layouts->add_includes('js', 'app/js/courses/index.js');
        $this->data['courses'] = $this->CursoModel->get_courses();

        $this->layouts->view('courses/indexView', $this->data);
    }

    public function delete() {

        $response['success'] = false;
        $response['errors'] = array();
        if ($this->input->is_ajax_request()) {
            $course_id = $this->input->post('course_id', true);
            $check_course = $this->CursoModel->check_course($course_id);
            if(isset($check_course[0]->check_count) ){
                if($check_course[0]->check_count >= 1){
                    $response['errors'][] = $this->lang->line('courses_cannot_delete');
                }else{
                    $deleted = $this->CursoModel->deleteItem($course_id);
                    if($deleted){
                        $response['success'] = $this->lang->line('courses_deleted_success');
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

    public function change_state() {

        $response['success'] = false;
        $response['errors'] = array();
        if ($this->input->is_ajax_request()) {
            $course_id = $this->input->post('course_id', true);
            $new_state = $this->input->post('new_state', true);
            $updated = $this->CursoModel->updateItem($course_id, array('estado'=>$new_state));
            if($updated){
                $response['success'] = $this->lang->line('courses_updated_success');
            }else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    public function add(){

        $this->layouts
            ->add_includes('css', 'assets/global/plugins/spectrum/css/spectrum.css')
            ->add_includes('js', 'assets/global/plugins/spectrum/js/spectrum.js')
            ->add_includes('js', 'app/vendor/ckeditor/ckeditor/ckeditor.js')
            ->add_includes('js', 'app/js/courses/add_edit.js');

//        $id = $this->get_group_id();


        if($this->input->post()) {

            $this->config->set_item('language', $this->data['lang']);
            $config = array(
                array(
                    'field' => 'course_id',
                    'label' => $this->lang->line('courses_reference'),
                    'rules' => 'trim|required|is_unique[curso.codigo]|alpha_numeric'
                ),
                array(
                    'field' => 'title',
                    'label' => $this->lang->line('courses_title_course'),
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'hours',
                    'label' => $this->lang->line('courses_hours'),
                    'rules' => 'trim|is_numeric'
                ),
                array(
                    'field' => 'credits',
                    'label' => $this->lang->line('courses_credits'),
                    'rules' => 'trim|is_numeric'
                )
            );
            $this->form_validation->set_rules($config);
            $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');


            if ($this->form_validation->run()) {
                if($this->input->post('course_id', true) != '0'){
                    $post_data = array();
                    $post_data['course_id'] = $this->input->post('course_id', true);
                    $post_data['color'] = $this->input->post('result_color', true);
                    $post_data['title'] = $this->input->post('title', true);
                    $post_data['course_description'] = $this->input->post('course_description');
                    $post_data['hours'] = $this->input->post('hours', true);
                    $post_data['credits'] = $this->input->post('credits', true);
                    $post_data['custom_fields'] = json_encode($this->input->post('custom_fields', true));
                    $personalized_post_data = $this->input->post(NULL, true);
                    $personalized_data = $this->get_personalized_data();

    //                if($post_data['course_id'] && $post_data['course_id'] != $id){
    //                    $id = $post_data['id'];
    //                }
                    $insert_personalized = array();
                    if (!empty($personalized_data)) {
                        foreach ($personalized_data as $personalized) {
                            if (isset($personalized_post_data[$personalized->name])) {
                                $insert_personalized[$personalized->name] = trim($personalized_post_data[$personalized->name]);
                            }

                        }
                    }

                    $insert_data = $this->makeInsertData($post_data);

                    $insert_data['codigo'] = $post_data['course_id'];
                    $insert_data['estado'] = 1; //active by default
                    $insert_personalized['codigo'] = $post_data['course_id'];

                    $inserted = $this->CursoModel->insertItem($insert_data);

                    if ($inserted) {
                        $this->CursoTabAdModel->insertFormData($insert_personalized);
                        redirect('courses/edit/' . $insert_data['codigo']);
                    }
                }else{
                    $this->data['error_msg'] = $this->lang->line('courses_id_cannot_be_0');
                }
            }
        }
        $this->data['isOwner']=$this->data['userData'][0]->owner;
        $cisess = $this->session->userdata('_cisess');
        $membership_type = $cisess['membership_type'];
        if($membership_type != 'FREE'){
            $this->data['customfields_fields'] = $this->get_customfields_data();
        }
        $this->data['add_edit'] = $this->lang->line('add');
        $this->data['course_id'] = isset($post_data['course_id']) ? $post_data['course_id'] : null;
        $this->data['personalized_fields'] = $this->get_personalized_data();
        $this->layouts->view('courses/addEditView', $this->data);
    }

    public function edit($course_id = null){
        if(!$course_id){
            redirect('courses');
        }
        $this->layouts
            ->add_includes('css', 'assets/global/plugins/typeahead/typeahead.css')
//            ->add_includes('css', 'assets/global/plugins/jquery-ui/jquery-ui.min.css')
//            ->add_includes('js', 'assets/global/plugins/jquery-ui/jquery-ui.min.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/handlebars.min.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.min.js')
            ->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
            ->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
            ->add_includes('css', 'assets/global/plugins/spectrum/css/spectrum.css')
            ->add_includes('js', 'assets/global/plugins/spectrum/js/spectrum.js')
            ->add_includes('js', 'app/vendor/ckeditor/ckeditor/ckeditor.js')
            ->add_includes('js', 'app/js/courses/add_edit.js');
        $course = $this->CursoModel->getById($course_id);

        if(!empty($course[0])) {
            $this->data['course'] = $course[0];
            $this->data['course']->custom_fields = json_decode($this->data['course']->custom_fields);
            if ($this->input->post()) {

                $this->config->set_item('language', $this->data['lang']);
                $config = array(
                    array(
                        'field' => 'title',
                        'label' => $this->lang->line('courses_title_course'),
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'hours',
                        'label' => $this->lang->line('courses_hours'),
                        'rules' => 'trim|is_numeric'
                    ),
                    array(
                        'field' => 'credits',
                        'label' => $this->lang->line('courses_credits'),
                        'rules' => 'trim|is_numeric'
                    )
                );
                $this->form_validation->set_rules($config);
                $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');
                if ($this->form_validation->run()) {
                    $post_data = array();
//                    $post_data['course_id'] = $this->input->post('course_id', true);
                    $post_data['color'] = $this->input->post('result_color', true);
                    $post_data['title'] = $this->input->post('title', true);
                    $post_data['course_description'] = $this->input->post('course_description');
                    $post_data['hours'] = $this->input->post('hours', true);
                    $post_data['credits'] = $this->input->post('credits', true);
                    $post_data['custom_fields'] = json_encode($this->input->post('custom_fields', true));
                    $update_data = $this->makeInsertData($post_data);

                    $personalized_post_data = $this->input->post(NULL, true);
                    $personalized_data = $this->get_personalized_data();
                    $personalized_exist_data = $this->CursoTabAdModel->getByCourseId($course_id);

                    $insert_personalized = array();
                    if(!empty($personalized_data)){
                        foreach($personalized_data as $personalized){
                            if(isset($personalized_post_data[$personalized->name])){
                                $insert_personalized[$personalized->name] =  trim($personalized_post_data[$personalized->name]);
                            }
                        }
                    }

                    $updated = $this->CursoModel->updateItem($course_id, $update_data);
                    if($updated){
                        if(!empty($personalized_exist_data)){
                            $this->CursoTabAdModel->updateFormData($insert_personalized, $course_id);
                        }else{
                            $insert_personalized['codigo'] = $course_id;
                            $this->CursoTabAdModel->insertFormData($insert_personalized);
                        }
                    }

                }
            }
            $course = $this->CursoModel->getById($course_id);
            $this->data['course'] = isset($course[0]) ? $course[0] : $course;
            $this->data['course']->custom_fields = json_decode($this->data['course']->custom_fields);
            $this->data['add_edit'] = $this->lang->line('edit');
            $this->data['course_id'] = $course_id;
            $cisess = $this->session->userdata('_cisess');
            $membership_type = $cisess['membership_type'];
            if($membership_type != 'FREE'){
                $this->data['customfields_fields'] = $this->get_customfields_data();
            }
            $this->data['isOwner']=$this->data['userData'][0]->owner;
            $doc_count = $this->CursoDocModel->get_count($course_id);
            isset($doc_count->doc_count) ? $this->data['doc_count'] = $doc_count->doc_count : $this->data['doc_count'] = 0;
            
            $books_count = $this->CursoArticulosModel->get_count($course_id);
            isset($books_count->books_count) ? $this->data['books_count'] = $books_count->books_count : $this->data['books_count'] = 0;

            $resources_count = $this->CursoRecursosModel->get_count($course_id);
            isset($resources_count->resources_count) ? $this->data['resources_count'] = $resources_count->resources_count : $this->data['resources_count'] = 0;

            $reports_count = $this->LstInformesCursoModel->get_count(); //$course_id
            isset($reports_count->reports_count) ? $this->data['reports_count'] = $reports_count->reports_count : $this->data['reports_count'] = 0;
            
            $this->data['personalized_fields'] = $this->get_personalized_data($course_id);
            $this->layouts->view('courses/addEditView', $this->data);
        }else{
            redirect('courses');
        }

    }

public function get_customfields_data() {
       
        $type = 'course';
        $custom_fields = $this->CursoModel->getFieldsList($type);
        if(count($custom_fields) > 0){
                
            return $custom_fields;

        }else{
            return false;
        }
       
    }

    private function makeInsertData($post_data){
        if(isset($post_data['color'])){
            $color = trim($post_data['color'], '#');
            $color = hexdec($color);
        }else{
            $color = 0;
        }
        return array(
            'custom_fields' => $post_data['custom_fields'],
            'IdColor' => $color,
            'curso' => isset($post_data['title']) ? $post_data['title']: null,
            'horas' => isset($post_data['hours']) ? $post_data['hours']: null,
            'creditos' => isset($post_data['credits']) ? $post_data['credits']: null,
            'contenido' => isset($post_data['course_description']) ? $post_data['course_description']: null
        );
    }


    protected function get_personalized_data($id = null) {
        $result_data = array();
        $personalized_data = array();
        if($id) {
            $personalized_data = (array)$this->CursoTabAdModel->getByCourseId($id);
        }

        $personalized_fields = $this->CursoTabAdModel->getFieldList();

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

    public function getDocumentsTable(){
        if($this->input->is_ajax_request()){
            $html = '';
            $course_id = $this->input->post('course_id', true);
            if(!empty($course_id)) {
                $documents = $this->CursoDocModel->getByCourseId($course_id);
                $this->data['documents'] = $documents;
                $this->data['course_id'] = $course_id;

                $html = $this->load->view('courses/partials/documentsView', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getDocuments(){
        if($this->input->is_ajax_request()){
            $course_id = $this->input->post('course_id', true);
            $documents = array();
            if(!empty($course_id)) {
                $documents = $this->CursoDocModel->getByCourseId($course_id);
                $this->data['documents'] = $documents;
            }
            echo json_encode(array('data' => $documents));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function changeDocumentVisible(){
        $response['success'] = false;
        if($this->input->is_ajax_request()){
            $course_id = $this->input->post('course_id', true);
            $document_id = (int)$this->input->post('document_id', true);
            $visible = (int)$this->input->post('visible', true);
            if($course_id && $document_id) {
                $_visible = $visible == '1' ? 1 : 0;
                $updated = $this->CursoDocModel->update('curso_doc', array('visible' => $_visible), array('codigocurso' => $course_id, 'id' => $document_id));
                if($updated){
                    $response['success'] = true;
                }               
            }
            echo json_encode($response);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    
    //books
    public function getBooksTable(){
        if($this->input->is_ajax_request()){
            $html = '';
            $course_id = $this->input->post('course_id', true);
            if(!empty($course_id)) {
                $books = $this->CursoArticulosModel->getByCourseId($course_id);
                $this->data['books'] = $books;
                $this->data['course_id'] = $course_id;

                $html = $this->load->view('courses/partials/booksView', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getBooks(){
        if($this->input->is_ajax_request()){
            $course_id = $this->input->post('course_id', true);
            $books = array();
            if(!empty($course_id)) {
                $books = $this->CursoArticulosModel->getByCourseId($course_id);
                $this->data['books'] = $books;
            }
            echo json_encode(array('data' => $books));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getNotExistBooks(){
        $this->load->model('ArticulosModel');
        if($this->input->is_ajax_request()){
            $course_id = $this->input->post('course_id', true);
            $not_exist_books = array();
            if(!empty($course_id)) {
                $not_exist_books = $this->ArticulosModel->getByCourseId($course_id);
            }
            echo json_encode(array('data' => $not_exist_books));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function addBook(){
        if($this->input->is_ajax_request()){
            $course_id = $this->input->post('course_id', true);
            $book_id = $this->input->post('book_id', true);
            $response = false;
            if(!empty($course_id) && !empty($book_id)) {
                $this->load->model('ArticulosModel');
                $books_data = $this->ArticulosModel->getById($book_id);
                if(!empty($books_data)){
                    $check_exist_id = $this->CursoArticulosModel->getByCourseId($course_id, $book_id);
                    if(empty($check_exist_id)) {
                        $this->CursoArticulosModel->addBook($course_id, $book_id);
                        $response = $this->CursoArticulosModel->getByCourseId($course_id, $book_id);
                    }
                }

            }
            echo json_encode(array('data' => $response));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function deleteBook(){
        if($this->input->is_ajax_request()){
            $cua_id = $this->input->post('cua_id', true);
            $result = false;
            if(!empty($cua_id)) {
                $this->load->model('ArticulosModel');
                $result = $this->CursoArticulosModel->deleteBookById($cua_id);
            }
            echo json_encode(array('success' => $result));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    //end books

    //resources
    public function getResourcesTable(){
        if($this->input->is_ajax_request()){
            $html = '';
            $course_id = $this->input->post('course_id', true);
            if(!empty($course_id)) {
                $resources = $this->CursoRecursosModel->getByCourseId($course_id);
                $this->data['resources'] = $resources;
                $this->data['course_id'] = $course_id;

                $html = $this->load->view('courses/partials/resourcesView', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getResources(){
        if($this->input->is_ajax_request()){
            $course_id = $this->input->post('course_id', true);
            $books = array();
            if(!empty($course_id)) {
                $books = $this->CursoArticulosModel->getByCourseId($course_id);
                $this->data['books'] = $books;
            }
            echo json_encode(array('data' => $books));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getNotExistResources(){
        $this->load->model('MaterialApoyoModel');
        if($this->input->is_ajax_request()){
            $course_id = $this->input->post('course_id', true);
            $not_exist_resources = array();
            if(!empty($course_id)) {
                $not_exist_resources = $this->MaterialApoyoModel->getByCourseId($course_id);
            }
            echo json_encode(array('data' => $not_exist_resources));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function addResource(){
        if($this->input->is_ajax_request()){
            $course_id = $this->input->post('course_id', true);
            $resource_id = $this->input->post('resource_id', true);
            $response = false;
            if(!empty($course_id) && !empty($resource_id)) {
                $this->load->model('MaterialApoyoModel');
                $resources_data = $this->MaterialApoyoModel->getById($resource_id);
                if(!empty($resources_data)){
                    $check_exist_id = $this->CursoRecursosModel->getByCourseId($course_id, $resource_id);
                    if(empty($check_exist_id)) {
                        $this->CursoRecursosModel->addResource($course_id, $resource_id);
                        $response = $this->CursoRecursosModel->getByCourseId($course_id, $resource_id);
                    }
                }

            }
            echo json_encode(array('data' => $response));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function deleteResource(){
        if($this->input->is_ajax_request()){
            $rec_cu_id = $this->input->post('rec_cu_id', true);
            $result = false;
            if(!empty($rec_cu_id)) {
                $result = $this->CursoRecursosModel->deleteResourceById($rec_cu_id);
            }
            echo json_encode(array('success' => $result));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    //end resources
    
    //reports
    public function getReportsTable(){
        if($this->input->is_ajax_request()){
            $lst_informes = $this->LstInformesCursoModel->getList();

            $html = '';
            $course_id = $this->input->post('course_id', true);
            if(!empty($course_id)) {
                $resources = $this->CursoRecursosModel->getByCourseId($course_id);
                $this->data['resources'] = $resources;
                $this->data['course_id'] = $course_id;
                $this->data['lst_informes'] = $lst_informes;

                $html = $this->load->view('courses/partials/reportsView', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getReportsData(){
        if($this->input->is_ajax_request()){
            $course_id = $this->input->post('course_id', true);
            $report_id = $this->input->post('report_id', true);
            $reports = array();
            if(!empty($course_id) && !empty($report_id)){
                $reports = $this->LstInformesCursoModel->report($report_id, $course_id);
            }
            echo json_encode(array('data' => $reports));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    //end reports

}
