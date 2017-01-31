<?php

/**
 * Created by IntelliJ IDEA.
 * User: qasim
 * Date: 11/19/15
 * Time: 7:57 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *@property ClientesTabAdModel $ClientesTabAdModel
 */
class Clientes extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (empty($this->_identity['loggedIn'])) {
            redirect('/auth/login/', 'refresh');
        }
        $this->load->model('ContactosModel');
        $this->load->model('ClientModel');
        $this->load->model('AlumnoModel');
        $this->load->model('ErpConsultaModel');
        $this->load->model('AreasAcademicaModel');
        $this->load->model('ClientesDocModel');
        $this->load->model('ClientesSeguiModel');
        $this->load->model('ReciboModel');
        $this->load->model('MatriculatModel');
        $this->load->model('LstPlantillaModel');
        $this->load->model('LstPlantillasCatModel');
        $this->load->model('ClientesTabAdModel');
        $this->load->model('DocumentModel');
//        $this->config->set_item('language', $this->data['lang']);
        $this->lang->load('clientes_form', $this->data['lang']);
        $this->lang->load('clientes', $this->data['lang']);
        $this->load->library('form_validation');
        $this->layouts->add_includes('js', 'app/js/clientes/main.js');
    }

    public function index($id = null) {
        $this->layouts->add_includes('js', 'app/js/clientes/index.js');
        if($this->input->post()){
            $this->index_post($id);
        }
        if ($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') != '') {
            $lang = $this->session->userdata('lang');
            $details = $this->magaModel->selectAll('clientes');
            $ckeyslang = $this->my_language->load('column_key');
            $this->data['page'] = 'clientes';
            $this->data['dataKeys'] = $ckeyslang;
            $field = $lang == 'english' ? 'sql_en' : 'sql_es';
            $query = "SELECT " . $field . " FROM erp_consultas WHERE ref = 'lst_empresas'";
            $sql = $this->magaModel->selectCustom($query);
            // print_r($sql);die;
            $this->data['content'] = $this->magaModel->selectCustom($lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);
            $this->layouts->view('clientes/indexView', $this->data);
        } else {
            redirect('/auth/login/', 'refresh');
        }
    }

    public function index_post($id) {
        $data = array();
        if($this->input->post()){
            $data['status'] = $this->ContactosModel->update($id, $this->input->post());
        }
        echo json_encode($data);
        exit;
    }

    public function add($id = 0) {
        $this->layouts->add_includes('js', 'app/js/clientes/add.js');
        if ($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') != '') {
            if ($id == 0) {
                $newID = $this->magaModel->maxID('clientes', 'CCODCLI');
                $newID = $newID[0]->CCODCLI + 1;
                redirect(site_url('clientes/add/' . $newID));
            }
            $lang = $this->session->userdata('lang');
            $ckeyslang = $this->my_language->load('clientes_form');
            $this->lang->load('clientes_form', $lang);
            $this->data['page'] = 'Data Records';
            $this->data['clienteId'] = $id;
            $this->data['page'] = 'Data Records';
            $this->data['formaspago'] = $this->magaModel->selectAll('formaspago');
            $this->data['dataKeys'] = $ckeyslang;
            $this->layouts->view('clientes/addView', $this->data);
        } else {
            redirect('/auth/login/', 'refresh');
        }
    }

    public function edit_old($id) {
        $this->layouts->add_includes('js', 'app/js/clientes/edit.js');
        $this->data['add_edit'] = $this->lang->line('edit');

            $this->data['page'] = 'Data Records';
            $check_id = $this->ClientModel->getClientById($id);
            if(!empty($check_id)) {
                $this->data['content'] = $this->ClientModel->getContent($id);
                $this->data['empleados'] = $this->ClientModel->getEmpleados($id);

                $this->data['documentos'] = $this->documentos($id);
                $this->data['Seguimiento'] = $this->Seguimiento($id);
                $this->data['clienteId'] = $id;
                $this->data['historicAccount'] = $this->historicAccount($id);
                $this->data['HistoricFees'] = $this->HistoricFees($id);
                $this->data['Filiales'] = $this->Filiales($id);
                $this->data['area_academica'] = $this->get_area_academica($id);
                $this->data['Adicionales'] = $this->Adicionales($id);


                $plantillas_cat = $this->LstPlantillasCatModel->getPlantillasCatByNumbre(strtolower($this->data['controller_name']));
                $this->data['id_cat'] = isset($plantillas_cat[0]->id) ? $plantillas_cat[0]->id : "10";
                $this->data['document_cat'] = $this->get_documentos($this->data['id_cat']);
//            $this->data['plantillas_cat'] = $this->plantillas_cat_get_byId("10");
                $this->data['plantillas_cat'] = "";
                $this->data['formaspago'] = $this->magaModel->selectAll('formaspago');

                $this->data['clientes'] = $this->magaModel->selectAll('clientes');
                $this->data['alumnos'] = $this->AlumnoModel->getAlumnos();
                $ckeyslang = $this->my_language->load('column_key');
                $this->data['dataKeys'] = $ckeyslang;
                $this->data['clientId'] = $id;
                $this->layouts->view('clientes/editView', $this->data);
            }else{
                redirect('/clientes');
            }
    }
    public function edit($id) {
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
            ->add_includes('js', 'app/js/clientes/add_edit.js');
        $this->data['add_edit'] = $this->lang->line('edit');

            $this->data['page'] = 'clientes_edit';
            $check_id = $this->ClientModel->getClientById($id);
            if(!empty($check_id)) {
                $this->data['content'] = $this->ClientModel->getContent($id);
                $this->data['empleados'] = $this->ClientModel->getEmpleados($id);

                $this->data['documentos'] = $this->documentos($id);
                $this->data['Seguimiento'] = $this->Seguimiento($id);
                $this->data['clienteId'] = $id;
                $this->data['historicAccount'] = $this->historicAccount($id);
                $this->data['HistoricFees'] = $this->HistoricFees($id);
                $this->data['Filiales'] = $this->Filiales($id);
                $this->data['area_academica'] = $this->get_area_academica($id);
                $this->data['Adicionales'] = $this->Adicionales($id);


                $plantillas_cat = $this->LstPlantillasCatModel->getPlantillasCatByNumbre(strtolower($this->data['controller_name']));
                $this->data['id_cat'] = isset($plantillas_cat[0]->id) ? $plantillas_cat[0]->id : "10";
                $this->data['document_cat'] = $this->get_documentos($this->data['id_cat']);
//            $this->data['plantillas_cat'] = $this->plantillas_cat_get_byId("10");
                $this->data['plantillas_cat'] = "";
                $this->data['formaspago'] = $this->magaModel->selectAll('formaspago');

                $this->data['clientes'] = $this->magaModel->selectAll('clientes');
                $this->data['alumnos'] = $this->AlumnoModel->getAlumnos();
                $ckeyslang = $this->my_language->load('column_key');
                $this->data['dataKeys'] = $ckeyslang;
                $this->data['clientId'] = $id;
                $this->layouts->view('clientes/addEditView', $this->data);
            }else{
                redirect('/clientes');
            }
    }

    public function getCommercialData(){
        if($this->input->is_ajax_request()){
            $html = '';
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
//                $this->load->model('ClientModel');
                $this->data['content'] = $this->ClientModel->getContent($client_id);
                $this->data['adicionales'] = $this->Adicionales($client_id);

                $html = $this->load->view('clientes/partials/commercial_data', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    
    public function getBillingData(){
        if($this->input->is_ajax_request()){
            $html = '';
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
//                $this->load->model('ClientModel');
                $this->data['content'] = $this->ClientModel->getContent($client_id);
                $this->data['formaspago'] = $this->magaModel->selectAll('formaspago');

                $html = $this->load->view('clientes/partials/billing_data', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    
    public function getEmployees(){
        if($this->input->is_ajax_request()){
            $html = '';
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
                $this->data['empleados'] = $this->AlumnoModel->getEmployee($client_id);
                $html = $this->load->view('clientes/partials/employees', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    
    public function getDocumentsTable(){
        
        if($this->input->is_ajax_request()){
            $html = '';
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
                $this->data['documents'] = $this->DocumentModel->get_documents($client_id);
                $this->data['client_id'] = $client_id;
                $html = $this->load->view('clientes/partials/documents', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    
    

    public function getDocuments(){
        if($this->input->is_ajax_request()){
            $client_id = $this->input->post('client_id', true);
            $documents = array();
            if(!empty($client_id)) {
                $documents = $this->DocumentModel->get_documents($client_id);
            }
            echo json_encode(array('data' => $documents));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function fileDelete(){
        if($this->input->is_ajax_request()){
            $response = false;
            $client_id = $this->input->post('client_id', true);
            $document_id = $this->input->post('documentId', true);
            if(!empty($client_id) && !empty($document_id)) {
                $response = $this->DocumentModel->deleteDocumentByIdClientId($document_id, $client_id);
            }
            echo json_encode(array('status' => $response));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getFollowUpTable(){

        if($this->input->is_ajax_request()){
            $html = '';
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
                $usuario = $this->data['userData'][0]->Id;
                $this->data['seguimientos'] = $this->ClientesSeguiModel->getSeguimiento($client_id, $usuario);
                $this->data['client_id'] = $client_id;
                $html = $this->load->view('clientes/partials/follow_up', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getFollowUp(){
        if($this->input->is_ajax_request()){
            $client_id = $this->input->post('client_id', true);
            $seguimientos = array();
            if(!empty($client_id)) {
                $usuario = $this->data['userData'][0]->Id;
                $seguimientos = $this->ClientesSeguiModel->getSeguimiento($client_id, $usuario);
            }
            echo json_encode(array('data' => $seguimientos));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function addFollowUp(){

        $response['success'] = false;
        $response['errors'] = array();
        $response['last_id'] = null;
        $response['result'] = false;

        if($this->input->post()){

            $this->config->set_item('language', $this->data['lang']);
            $config = array(
                array(
                    'field' => 'titulo',
                    'label' => $this->lang->line('clientes_followup_titulo'),
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'comentarios',
                    'label' => $this->lang->line('clientes_followup_fecha'),
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'fecha',
                    'label' => $this->lang->line('clientes_followup_comentario'),
                    'rules' => 'trim|required'
                ),
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run()) {
                $post_data = $this->input->post(null, true);
                $usuar_id = isset($this->data['userData'][0]->Id) ? $this->data['userData'][0]->Id : null;
                $client_id = isset($post_data['client_id']) ? $post_data['client_id'] : null;
                if($client_id && $usuar_id) {
                    $dataArray = array(
                        'fecha' => date('Y-m-d', strtotime($post_data['fecha'])),
                        'titulo' => $post_data['titulo'],
                        'comentarios' => $post_data['comentarios'],
                        'id_user' => $usuar_id,
                        'ccodcli' => $client_id
                    );
                    $last_id = $this->ClientesSeguiModel->insertFollowUp($dataArray);
                    if($last_id){
                        $response['result'] = $this->ClientesSeguiModel->getSeguimiento($last_id, $usuar_id);
                        $response['last_id'] = $last_id;
                        $response['success'] = $this->lang->line('clientes_follow_up_added');
                        $response['errors'] = false;
                    }else{
                        $response['errors'][] = $this->lang->line('db_err_msg');
                    }
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }else{
                $response['errors'] =  $this->form_validation->error_array();
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }

        print_r(json_encode($response));
        exit;
    }

    public function editFollowUp(){

        $response['success'] = false;
        $response['errors'] = array();
        $response['result'] = false;

        if($this->input->post()){

            $this->config->set_item('language', $this->data['lang']);
            $config = array(
                array(
                    'field' => 'titulo',
                    'label' => $this->lang->line('clientes_followup_titulo'),
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'comentarios',
                    'label' => $this->lang->line('clientes_followup_fecha'),
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'fecha',
                    'label' => $this->lang->line('clientes_followup_comentario'),
                    'rules' => 'trim|required'
                )
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run()) {
                $post_data = $this->input->post(null, true);
                $usuar_id = isset($this->data['userData'][0]->Id) ? $this->data['userData'][0]->Id : null;
                $client_id = isset($post_data['client_id']) ? $post_data['client_id'] : null;
                $follow_up_id = isset($post_data['follow_up_id']) ? $post_data['follow_up_id'] : null;
                if($follow_up_id && $client_id && $usuar_id) {
                    $dataArray = array(
                        'fecha' => date('Y-m-d', strtotime($post_data['fecha'])),
                        'titulo' => $post_data['titulo'],
                        'comentarios' => $post_data['comentarios']
                    );
                    $where = array(
                        'id' => $follow_up_id,
                        'id_user' => $usuar_id,
                        'ccodcli' => $client_id
                    );
                    
                    $updated = $this->magaModel->update('clientes_segui', $dataArray, $where);
                    if($updated){
                        $response['result'] = $this->ClientesSeguiModel->getSeguimiento($follow_up_id, $usuar_id);                        
                        $response['success'] = $this->lang->line('clientes_follow_up_updated');
                        $response['errors'] = false;
                    }else{
                        $response['errors'][] = $this->lang->line('db_err_msg');
                    }
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }else{
                $response['errors'] =  $this->form_validation->error_array();
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }

        print_r(json_encode($response));
        exit;
    }

    public function delete_follow_up() {
        if($this->input->is_ajax_request()){
            $post_data = $this->input->post(null, true);
            $usuar_id = isset($this->data['userData'][0]->Id) ? $this->data['userData'][0]->Id : null;
            $client_id = isset($post_data['client_id']) ? $post_data['client_id'] : null;
            $follow_up_id = isset($post_data['follow_up_id']) ? $post_data['follow_up_id'] : null;
            $deleted = false;
            if($follow_up_id && $client_id && $usuar_id) {
                $where = array(
                    'id' => $follow_up_id,
                    'id_user' => $usuar_id,
                    'ccodcli' => $client_id
                );
                $deleted = $this->magaModel->delete('clientes_segui', $where);
            }
            echo json_encode(array('status' => $deleted));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getSubsidiariesTable(){
        if($this->input->is_ajax_request()){
            $html = '';
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
                $this->data['subsidiaries'] = $this->ClientModel->getFiliales($client_id);
                $this->data['client_id'] = $client_id;
                $html = $this->load->view('clientes/partials/subsidiaries', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getSubsidiaries(){
        if($this->input->is_ajax_request()){
            $client_id = $this->input->post('client_id', true);
            $subsidiaries = array();
            if(!empty($client_id)) {
                $subsidiaries = $this->ClientModel->getFiliales($client_id);
            }
            echo json_encode(array('data' => $subsidiaries));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getNotExistSubsidiaries(){
        if($this->input->is_ajax_request()){
            $client_id = $this->input->post('client_id', true);
            $not_exist = false;
            if(!empty($client_id)) {
                $not_exist = $this->ClientModel->getNotExistFiliales($client_id);
            }
            echo json_encode(array('data' => $not_exist));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function update_subsidiaries() {       
        if($this->input->is_ajax_request()){
            $response = false;
            $linkFrom = $this->input->post('linkFrom', true);
            $linkTo = $this->input->post('linkTo', true);
            if(!empty($linkTo) && !empty($linkFrom)) {
                $response = $this->magaModel->update('clientes', array('ccodcli_matriz' => $linkFrom), array('ccodcli' => $linkTo));
            }
            echo json_encode(array('status' => $response));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function delete_subsidiaries() {       
        if($this->input->is_ajax_request()){
            $response = false;
            $linkFrom = $this->input->post('linkFrom', true);
            $linkTo = $this->input->post('linkTo', true);
            if(!empty($linkTo) && !empty($linkFrom)) {
                $response = $this->magaModel->update('clientes', array('ccodcli_matriz' => ''), array('ccodcli' => $linkTo));
            }
            echo json_encode(array('status' => $response));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    
    public function getAlumnosNotLinked(){
        if($this->input->is_ajax_request()){
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
//                $this->load->model('AlumnoModel');
                $not_linked_alumnos = $this->AlumnoModel->getAlumnosNotLinked($client_id);
            }
            echo json_encode(array('data' => $not_linked_alumnos));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function update_employee() {
          if($this->input->is_ajax_request()){
            $response = false;
            $client_id = $this->input->post('client_id', true);
            $linkFrom = $this->input->post('linkFrom', true);
            if(!empty($client_id) && !empty($linkFrom)) {
                $linked = $this->AlumnoModel->updateItemById(array('facturara' => $client_id), $linkFrom);
                if($linked){
                    $response = $this->AlumnoModel->get_student_by_id($linkFrom);
                }
            }
            echo json_encode(array('data' => $response));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function unlink_employee() {
        if($this->input->is_ajax_request()){
            $student_id = $this->input->post('student_id', true);
            $result = false;
            if(!empty($student_id)) {
                $result = $this->magaModel->update('alumnos', array('FacturarA' => '0'), array('Id' => $student_id));
            }
            echo json_encode(array('success' => $result));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getHistoricFeesTable(){

        if($this->input->is_ajax_request()){
            $html = '';
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
                $this->data['historic_fees'] = $this->MatriculatModel->getHistoricFees($client_id);
                $this->data['client_id'] = $client_id;
                $html = $this->load->view('clientes/partials/historic_fees', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getHistoricAccountsTable(){

        if($this->input->is_ajax_request()){
            $html = '';
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
                $this->data['historic_accounts'] = $this->ReciboModel->getHistoricAccount($client_id);
                $this->data['client_id'] = $client_id;
                $html = $this->load->view('clientes/partials/historic_accounts', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getTemplates(){

        if($this->input->is_ajax_request()){
            $html = '';
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
                $plantillas_cat = $this->LstPlantillasCatModel->getPlantillasCatByNumbre(strtolower($this->data['controller_name']));
                $this->data['id_cat'] = isset($plantillas_cat[0]->id) ? $plantillas_cat[0]->id : "10";
                $this->data['document_cat'] = $this->get_documentos($this->data['id_cat']);
                $this->data['client_id'] = $client_id;
                $html = $this->load->view('clientes/partials/templates', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    

    public function clientes() {
        $data['page'] = 'Data Records';
        $data['content'] = $this->ClientModel->getList();
        echo json_encode($data);
    }

    public function cliente_delete($id) {
        $data['status'] = $this->magaModel->deleteClientes($id);
        $this->curl->simple_get(base_url() . 'awsrest/bucketDelete/customer-' . $id);
        echo json_encode($data);
    }

    public function create() {
        $data = array();
        if($this->input->post()){
            $data['status'] = $this->ContactosModel->insert($this->input->post());
        }
        echo json_encode($data);
        exit;
    }

    public function get_area_academica($id) {
        return $this->AreasAcademicaModel->getAreaAcademica();
    }

    public function Adicionales($id) {
        $result_data = array();
        $personalized_data = (array)$this->ClientesTabAdModel->getByClientId($id);

        $personalized_fields = $this->ClientesTabAdModel->getFieldList();

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

    public function Adicionales_add_post($id) {
        $details = array();
        if($this->input->post()){
            $areaacademica = $this->input->post('areaacademica');
            $fecha = $this->input->post('fecha');
            $comments = $this->input->post('comments');
            $details = $this->AreasAcademicaModel->adicionalesAdd($id, $areaacademica, $comments, $fecha);
        }
        print_r($details);
        exit;

    }

    public function Adicionales_update($id) {
        if($this->input->post()){
            $res_data = array('status' => false);
            $personalized_form_data = $this->input->post('personalized_data', true);
            $check_client_id = $this->ClientModel->getClientById($id);
            if(!empty($check_client_id)) {
                $form_data = array();
                $fields = array();
                $check_id_exist = $this->ClientesTabAdModel->getByClientId($id);
                $fields_list = $this->ClientesTabAdModel->getFieldList();
                foreach ($fields_list as $field) {
                    $fields[$field->name] = $field->name;
                }
                if (!empty($personalized_form_data) && !empty($fields)) {
                    foreach ($personalized_form_data as $k => $data) {
                        if (isset($fields[$data['name']]) && $data['name'] != 'ccodcli') {
                            $key = $fields[$data['name']];
                            $form_data[$key] = $data['value'];
                        }
                    }
                }
                if (!empty($check_id_exist)) {
                    $result = $this->ClientesTabAdModel->updateFormData($form_data, $id);
                    if ($result) {
                        $res_data['status'] = true;
                    }
                } else {
                    $form_data['ccodcli'] = $id;
                    $result = $this->ClientesTabAdModel->insertFormData($form_data);
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
    public function update_adicionales($id) {
        $response['success'] = false;
        $response['errors'] = true;
        if($this->input->post()){
            $personalized_form_data = $this->input->post(NULL, true);
            $check_client = $this->ClientModel->getClientById($id);
            if(!empty($check_client)) {
                $form_data = array();
                $fields = array();
                $check_id_exist = $this->ClientesTabAdModel->getByClientId($id);
                $fields_list = $this->ClientesTabAdModel->getFieldList();
                foreach ($fields_list as $field) {
                    $fields[$field->name] = $field->name;
                }
                if (!empty($personalized_form_data) && !empty($fields)) {
                    foreach ($personalized_form_data as $k => $value) {
                        if (isset($fields[$k]) && $k != 'ccodcli') {
                            $key = $fields[$k];
                            $form_data[$key] = $value;
                        }
                    }
                }
                
                if (!empty($check_id_exist)) {
                    $result = $this->ClientesTabAdModel->updateFormData($form_data, $id);
                    if ($result) {
                        $response['success'] = $this->lang->line('clientes_personalized_fields_updated');
                        $response['errors'] = false;
                    }else{
                        $response['errors'] = $this->lang->line('db_err_msg');
                    }
                } else {
                    $form_data['ccodcli'] = $id;
                    $result = $this->ClientesTabAdModel->insertFormData($form_data);
                    if ($result) {
                        $response['success'] = $this->lang->line('clientes_personalized_fields_added');
                        $response['errors'] = false;
                    }else{
                        $response['errors'] = $this->lang->line('db_err_msg');
                    }
                }
            }
            print_r(json_encode($response));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function index_delete($id) {
        $data['status'] = $this->ContactosModel->delete($id);
        echo json_encode($data);
    }

    public function filter() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules("column_name", 'ColumnName', "required");
        $this->form_validation->set_rules("operator", 'Operator', "required");
        $this->form_validation->set_rules("value", 'Value', "required");
        $data = array();
        if ($this->form_validation->run() ? FALSE : TRUE) {
            $data['status'] = false;
            $data['error'] = validation_errors();
        } else {
            $value = $this->input->get('value');
            $operator = $this->input->get('operator');
            $column_name = $this->input->get('column_name');
            $data['status'] = True;
            $data['lang'] = $this->lang->language;
            $data['content'] = $this->ContactosModel->filter($value, $operator, $column_name);
        }
        echo json_encode($data);
    }

    public function group() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules("column_name", 'ColumnName', "required");
        $data = array();
        if ($this->form_validation->run() ? FALSE : TRUE) {
            $data['status'] = false;
            $data['error'] = validation_errors();
        } else {
            $column_name = $this->input->get('column_name');
            $data['status'] = True;
            $data['lang'] = $this->lang->language;
            $data['content'] = $this->ContactosModel->group_by($column_name);
        }
        echo json_encode($data);
    }

    //alumnos
    public function alumnos() {
        $details = $this->AlumnoModel->getAll();
        return $details;
    }

    public function documentos($id) {
        return $this->ClientesDocModel->getDocumentos($id);
    }

    public function Seguimiento($id) {
        $userData = $this->session->userdata('userData');
        $usuario = $userData[0]->Id;
        return $this->ClientesSeguiModel->getSeguimiento($id, $usuario);
    }

    public function saveFollowUp($client_id = null){
        if($this->input->is_ajax_request()){
            $post_data = $this->input->post(Null, true);
            $result = false;
            $last_id = false;
            $userData = $this->session->userdata('userData');
            $usuar_id = isset($userData[0]->Id) ? $userData[0]->Id : null;
            if($client_id && $usuar_id) {


                $dataArray = array(
                    'fecha' => $post_data['fecha'],
                    'titulo' => $post_data['titulo'],
                    'comentarios' => $post_data['comentarios'],
                    'id_user' => $usuar_id,
                    'ccodcli' => $client_id
                );
                $last_id = $this->ClientesSeguiModel->insertFollowUp($dataArray);
                if($last_id){
                    $result = true;
                }
            }
            echo json_encode(array('success' => $result, 'last_id' => $last_id, 'post_data' => $dataArray));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function Seguimiento_post($id) {
        $fecha = $this->input->post('fecha');
        $titulo = $this->input->post('titulo');
        $comentarios = $this->input->post('comentarios');
        $userData = $this->session->userdata('userData');
        $usuar_id = $userData[0]->Id;

        $dataArray = array(
            'fecha' => $fecha,
            'titulo' => $titulo,
            'comentarios' => $comentarios,
            'user_id' => $usuar_id,
            'ccodcli' => $id
        );
        $details = $this->magaModel->insert('clientes_segui', $dataArray);
        print_r($details);
    }

    public function Seguimiento_edit($id) {
        $details = array();
        if ($this->input->post()) {

            $fecha = $this->input->post('fecha');
            $titulo = $this->input->post('titulo');
            $comentarios = $this->input->post('comentarios');
            $userData = $this->session->userdata('userData');
            $usuario = $userData[0]->USUARIO;

            $dataArray = array(
                'fecha' => $fecha,
                'titulo' => $titulo,
                'comentarios' => $comentarios
            );
            $details = $this->magaModel->update('clientes_segui', $dataArray, array('id' => $id));
        }
        print_r($details);
        exit;
    }

    public function seguimiento_delete($id) {
        $detail = $this->magaModel->delete('clientes_segui', array('id' => $id));
        print_r($detail);
    }

    public function historicAccount($id) {
        return $this->ReciboModel->getHistoricAccount($id);
    }

    public function HistoricFees($id) {
        return $this->MatriculatModel->getHistoricFees($id);
    }

    public function Filiales($id) {
        return $this->ClientModel->getFiliales($id);
    }

    public function Filiales_post($id) {
        $linkFrom = $this->input->post('linkFrom');
        $linkTo = $this->input->post('linkTo');
        $details = $this->magaModel->update('clientes', array('ccodcli_matriz' => $linkFrom), array('ccodcli' => $linkTo));
        echo $details;
    }

    public function empleados_post($id) {
        $details = array();
        if ($this->input->post()) {
            $linkFrom = $this->input->post('linkFrom');
            $details = $this->magaModel->update('alumnos', array('FacturarA' => $id), array('ccodcli' => $linkFrom));
        }
        print_r($details);
        exit;
    }

    public function Filiales_delete($id) {
        $details = $this->magaModel->update('clientes', array('ccodcli_matriz' => ''), array('ccodcli' => $id));
        echo $details;
    }

    public function empleados_delete($id) {
        $details = $this->magaModel->update('alumnos', array('FacturarA' => '0'), array('Id' => $id));
        echo $details;
    }

    public function datos_comerciales($id) {
        $details = array();
        if ($this->input->post()) {
            $lang = $this->session->userdata('lang');
            $post_data = (array) $this->input->post(NULL, true);
            foreach ($post_data as $key => $list) {
                if ($key === 'FirstUpdate' || $key === 'LastUpdate') {
                    if ($lang == "english") {
                        $post_data[$key] = DateTime::createFromFormat('m/d/Y', $list)->format('Y-m-d');
                    } else {
                        $post_data[$key] = DateTime::createFromFormat('d/m/Y', $list)->format('Y-m-d');
                    }
                }
            }
            $update_data = $this->makeInsertData($post_data);
            $details = $this->magaModel->update('clientes', $update_data, array('CCODCLI' => $id));
        }
        print_r($details);
        exit;
    }
    public function update_commercial_data($id) {
        $response['success'] = false;
        $response['errors'] = true;
        if ($this->input->post() && !empty($id)) {
            $post_data = (array) $this->input->post(NULL, true);
            $update_data = $this->newMakeInsertData($post_data);
            $result = $this->ClientModel->updateItem($update_data, $id);
            if($result){
                $response['success'] = $this->lang->line('clientes_commercial_data_updated');
                $response['errors'] = false;
            }else{
                $response['errors'] = $this->lang->line('db_err_msg');
            }
        }else{
            $response['errors'] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    public function datos_comerciales_add($id) {
        $details = array();
        if ($this->input->post()) {
            $newID = $this->magaModel->maxID('clientes', 'CCODCLI');
            $newID = $newID[0]->CCODCLI + 1;
            $post_data = $this->input->post(NULL, true);
            $insert_data = $this->makeInsertData($post_data);
            $insert_data['ccodcli'] = $newID;
            $details = $this->magaModel->insert('clientes', $insert_data);
        }
        print_r($details);
        exit;
    }

    private function makeInsertData($post_data){
        return array(
            'FirstUpdate' => isset($post_data['FirstUpdate']) ? $post_data['FirstUpdate'] : '',
            'LastUpdate' => isset($post_data['LastUpdate']) ? $post_data['LastUpdate'] : '',
            'cnomcli' => isset($post_data['cnomcli']) ? $post_data['cnomcli'] : '',
            'cnomcom' => isset($post_data['cnomcom']) ? $post_data['cnomcom'] : '',
            'Cpobcli' => isset($post_data['Cpobcli']) ? $post_data['Cpobcli'] : '',
            'Cdomicilio' => isset($post_data['Cdomicilio']) ? $post_data['Cdomicilio'] : '',
            'cprovincia' => isset($post_data['cprovincia']) ? $post_data['cprovincia'] : '',
            'cnaccli' => isset($post_data['cnaccli']) ? $post_data['cnaccli'] : '',
            'cdnicif' => isset($post_data['cdnicif']) ? $post_data['cdnicif'] : '',
            'cobscli' => isset($post_data['cobscli']) ? $post_data['cobscli'] : '',
            'ctfo1cli' => isset($post_data['ctfo1cli']) ? $post_data['ctfo1cli'] : '',
            'Ctfo2cli' => isset($post_data['Ctfo2cli']) ? $post_data['Ctfo2cli'] : '',
            'SkypeEmpresa' => isset($post_data['SkypeEmpresa']) ? $post_data['SkypeEmpresa'] : '',
            'movil' => isset($post_data['movil']) ? $post_data['movil'] : '',
            'cfaxcli' => isset($post_data['cfaxcli']) ? $post_data['cfaxcli'] : '',
            'email' => isset($post_data['email']) ? $post_data['email'] : '',
            'web' => isset($post_data['web']) ? $post_data['web'] : '',
            'ccontacto' => isset($post_data['ccontacto']) ? $post_data['ccontacto'] : '',
            'cargo' => isset($post_data['cargo']) ? $post_data['cargo'] : '',
            'cobserva' => isset($post_data['cobserva']) ? $post_data['cobserva'] : '',
            'idfp' => isset($post_data['idfp']) ? $post_data['idfp'] : '',
            'tarjetanum' => isset($post_data['tarjetanum']) ? $post_data['tarjetanum'] : '',
            'tarjetacadmes' => isset($post_data['tarjetacadmes']) ? $post_data['tarjetacadmes'] : '',
            'tarjetacadano' => isset($post_data['tarjetacadano']) ? $post_data['tarjetacadano'] : '',
            'irpf' => isset($post_data['irpf']) ? $post_data['irpf'] : '',
            'centidad' => isset($post_data['centidad']) ? $post_data['centidad'] : '',
            'cagencia' => isset($post_data['cagencia']) ? $post_data['cagencia'] : '',
            'cctrlbco' => isset($post_data['cctrlbco']) ? $post_data['cctrlbco'] : '',
            'ccuenta' => isset($post_data['ccuenta']) ? $post_data['ccuenta'] : '',
            'iban' => isset($post_data['iban']) ? $post_data['iban'] : '',
            'banco' => isset($post_data['banco']) ? $post_data['banco'] : '',
        );

    }

    private function newMakeInsertData($post_data){
        $update_data = array();
        
        if(isset($post_data['FirstUpdate'])){
            $update_data['FirstUpdate'] = date('Y-m-d H:i:s', strtotime($post_data['FirstUpdate']));
        }
        if(isset($post_data['LastUpdate'])){
            $update_data['LastUpdate'] = date('Y-m-d H:i:s', strtotime($post_data['LastUpdate']));
        }
        if(isset($post_data['cnomcli'])){
            $update_data['cnomcli'] = $post_data['cnomcli'];
        }
        if(isset($post_data['cnomcom'])){
            $update_data['cnomcom'] = $post_data['cnomcom'];
        }
        if(isset($post_data['Cpobcli'])){
            $update_data['Cpobcli'] = $post_data['Cpobcli'];
        }        
        if(isset($post_data['Cdomicilio'])){
            $update_data['Cdomicilio'] = $post_data['Cdomicilio'];
        }       
        if(isset($post_data['cprovincia'])){
            $update_data['cprovincia'] = $post_data['cprovincia'];
        }      
        if(isset($post_data['cnaccli'])){
            $update_data['cnaccli'] = $post_data['cnaccli'];
        }      
        if(isset($post_data['cdnicif'])){
            $update_data['cdnicif'] = $post_data['cdnicif'];
        }      
        if(isset($post_data['cobscli'])){
            $update_data['cobscli'] = $post_data['cobscli'];
        }      
        if(isset($post_data['ctfo1cli'])){
            $update_data['ctfo1cli'] = $post_data['ctfo1cli'];
        }      
        if(isset($post_data['Ctfo2cli'])){
            $update_data['Ctfo2cli'] = $post_data['Ctfo2cli'];
        }      
        if(isset($post_data['SkypeEmpresa'])){
            $update_data['SkypeEmpresa'] = $post_data['SkypeEmpresa'];
        }      
        if(isset($post_data['movil'])){
            $update_data['movil'] = $post_data['movil'];
        }      
        if(isset($post_data['cfaxcli'])){
            $update_data['cfaxcli'] = $post_data['cfaxcli'];
        }      
        if(isset($post_data['email'])){
            $update_data['email'] = $post_data['email'];
        }      
        if(isset($post_data['web'])){
            $update_data['web'] = $post_data['web'];
        }      
        if(isset($post_data['ccontacto'])){
            $update_data['ccontacto'] = $post_data['ccontacto'];
        }            
        if(isset($post_data['cargo'])){
            $update_data['cargo'] = $post_data['cargo'];
        }            
        if(isset($post_data['cobserva'])){
            $update_data['cobserva'] = $post_data['cobserva'];
        }            
        if(isset($post_data['idfp'])){
            $update_data['idfp'] = $post_data['idfp'];
        }            
        if(isset($post_data['tarjetanum'])){
            $update_data['tarjetanum'] = $post_data['tarjetanum'];
        }            
        if(isset($post_data['tarjetacadmes'])){
            $update_data['tarjetacadmes'] = $post_data['tarjetacadmes'];
        }            
        if(isset($post_data['tarjetacadano'])){
            $update_data['tarjetacadano'] = $post_data['tarjetacadano'];
        }            
        if(isset($post_data['irpf'])){
            $update_data['irpf'] = $post_data['irpf'];
        }            
        if(isset($post_data['centidad'])){
            $update_data['centidad'] = $post_data['centidad'];
        }            
        if(isset($post_data['cagencia'])){
            $update_data['cagencia'] = $post_data['cagencia'];
        }            
        if(isset($post_data['cctrlbco'])){
            $update_data['cctrlbco'] = $post_data['cctrlbco'];
        }            
        if(isset($post_data['ccuenta'])){
            $update_data['ccuenta'] = $post_data['ccuenta'];
        }            
        if(isset($post_data['iban'])){
            $update_data['iban'] = $post_data['iban'];
        }            
        if(isset($post_data['banco'])){
            $update_data['banco'] = $post_data['banco'];
        }
        
        return $update_data;

    }

    public function plantillas_add_update() {
        $details = array();
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $data = ['id_cat' => $this->input->post('id_cat'), 'Nombre' => $this->input->post('Nombre'), 'webDocumento' => $this->input->post('webDocumento'), 'DocAsociado' => $this->input->post('DocAsociado')];
            if ($this->input->post('template_option') == 1) {
                $details = $this->magaModel->insert('lst_plantillas', $data);
            } else {
                $details = $this->magaModel->update('lst_plantillas', $data, array('id' => $id));
            }

        }
        return $details;
    }

    public function documentos_post($id) {
        $details = $this->LstPlantillaModel->getDocumentos($id);
        $docAsociado = [];
        if (!empty($details)) {
            $docAsociado[] = ['id' => '0', 'name' => 'select'];
            foreach ($details as $row) {
                $DocAsociado[] = ['id' => $row->id, 'name' => $row->DocAsociado];
            }
        }
        echo json_encode($DocAsociado);
        //return json_encode($DocAsociado);
    }
    
    public function get_documentos($id) {
        return $this->LstPlantillaModel->getDocumentos($id);
        //return json_encode($DocAsociado);
    }

    public function documentodata($id) {
        $webDocumento = array();
        if ($this->input->post()) {
            $clienteId = $this->input->post('clienteId');
            $webDocumentoDetail = $this->LstPlantillaModel->getDocumentoData($id);

            /* $lang = $this->session->userdata('lang');
              $ckeyslang = $this->my_language->load('column_key');
              $data['dataKeys'] =$ckeyslang;
              $field = $lang == 'english' ? 'sql_en' : 'sql_es';
              $query = "SELECT ".$field." FROM erp_consultas WHERE ref = 'lst_empresas'";
              $sql = $this->magaModel->selectCustom($query);
              print_r($sql);die; */
            //$data['content']=$this->magaModel->selectCustom($lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);

            $clientres = $this->ClientModel->getClientes($clienteId);
            $clientarray = json_decode(json_encode($clientres), true);
            $webDocumento = $webDocumentoDetail[0]->webDocumento;
            foreach ($clientarray[0] as $index => $row) {
                $webDocumento = str_replace('[' . $index . ']', $row, $webDocumento);
            }
        }
        print_r($webDocumento);
        exit;

    }

    public function plantillas_cat() {
        $details = $this->LstPlantillasCatModel->getPlantillasCat();
        $plantillas_cat = [];
        $plantillas_cat[''] = 'Select';
        if (!empty($details)) {
            foreach ($details as $row) {
                $plantillas_cat[$row->id] = $row->nombre;
            }
        }
        return $plantillas_cat;
    }
    
    public function plantillas_cat_get_byId($cat_id) {
        $details = $this->LstPlantillasCatModel->getPlantillasCatById($cat_id);
        $plantillas_cat = [];
        $plantillas_cat[''] = 'Select';
        if (!empty($details)) {
            foreach ($details as $row) {
                $plantillas_cat[$row->id] = $row->nombre;
            }
        }
        return $plantillas_cat;
    }

    public function deleteFollowUp($id){
        $result = $this->ClientesSeguiModel->deleteFollowUp($id);
        print_r($result);
        exit;
    }

}
