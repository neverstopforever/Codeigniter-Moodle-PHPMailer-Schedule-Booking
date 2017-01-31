<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Companies extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (empty($this->_identity['loggedIn'])) {
            redirect('/auth/login/', 'refresh');
        }
        $this->load->model('ClientModel');
        $this->lang->load('clientes_form', $this->data['lang']);
        $this->lang->load('companies', $this->data['lang']);
        $this->lang->load('quotes', $this->data['lang']);
        $this->load->library('form_validation');
        $this->layouts->add_includes('js', 'app/js/companies/main.js');
    }

    public function index($id = null) {
        $this->lang->load('quicktips', $this->data['lang']);
        $this->layouts->add_includes('js', 'app/js/companies/index.js');
        if($this->input->post()){
            $this->index_post($id);
        }
        $this->layouts->view('companies/indexView', $this->data);
    }

    public function index_post($id) {
        $data = array();
        if($this->input->post()){
            $this->load->model('ContactosModel');
            $data['status'] = $this->ContactosModel->update($id, $this->input->post());
        }
        echo json_encode($data);
        exit;
    }

    public function add($id = 0) {
        $this->layouts->add_includes('css', 'assets/global/css/steps.css');
        $this->layouts->add_includes('js', 'app/js/companies/add.js');
        if ($id == 0) {
            $newID = $this->magaModel->maxID('clientes', 'CCODCLI');
            $newID = $newID[0]->CCODCLI + 1;
            redirect(site_url('companies/add/' . $newID));
        }
        $ckeyslang = $this->my_language->load('clientes_form');
        $this->lang->load('clientes_form', $this->data['lang']);
        $this->data['page'] = 'companies_add';
        $this->data['clienteId'] = $id;
        $this->data['clientId'] = $id;
//        $this->data['formaspago'] = $this->magaModel->selectAll('formaspago');
        $this->data['dataKeys'] = $ckeyslang;
        $cisess = $this->session->userdata('_cisess');
        $membership_type = $cisess['membership_type'];
        if($membership_type != 'FREE'){
            $this->data['customfields_fields'] = $this->get_customfields_data();
        }
//        $this->data['content'] = $this->ClientModel->getContent($client_id);
        $this->layouts->view('companies/addView', $this->data);
    }

    public function edit($id) {
        $this->layouts
            ->add_includes('css', 'assets/global/plugins/typeahead/typeahead.css')
//            ->add_includes('css', 'assets/global/plugins/jquery-ui/jquery-ui.min.css')
//            ->add_includes('js', 'assets/global/plugins/jquery-ui/jquery-ui.min.js')
//            ->add_includes('js', 'assets/global/plugins/jquery-ui/ui/i18n/datepicker-es.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/handlebars.min.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.min.js')
            ->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
            ->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
            ->add_includes('css', 'assets/global/plugins/spectrum/css/spectrum.css')
            ->add_includes('js', 'assets/global/plugins/spectrum/js/spectrum.js')
            ->add_includes('js', 'app/js/companies/add_edit.js');
            $this->data['add_edit'] = $this->lang->line('edit');
            $this->data['isOwner']=$this->data['userData'][0]->owner;
            $this->data['customfields_fields'] = array();
            $this->data['customfields_fields'] = array();
            $cisess = $this->session->userdata('_cisess');
            $membership_type = $cisess['membership_type'];
            if($membership_type != 'FREE'){
                $this->data['customfields_fields'] = $this->get_customfields_data();
            }

            $this->data['page'] = 'companies_edit';
            $check_id = $this->ClientModel->getClientById($id);
            if(!empty($check_id)) {
                $this->data['clientId'] = $id;
                $this->layouts->view('companies/addEditView', $this->data);
            }else{
                redirect('/companies');
            }
    }

 public function get_customfields_data() {
       
        $type = 'companies';
        $custom_fields = $this->ClientModel->getFieldsList($type);
        if(count($custom_fields) > 0){
                
            return $custom_fields;

        }else{
            return false;
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
                $this->data['isOwner']=$this->data['userData'][0]->owner;
                $cisess = $this->session->userdata('_cisess');
                $membership_type = $cisess['membership_type'];
                if($membership_type != 'FREE'){
                    $this->data['content'][0]->custom_fields = json_decode($this->data['content'][0]->custom_fields);
                    $this->data['customfields_fields'] = $this->get_customfields_data();
                }
                $html = $this->load->view('companies/partials/commercial_data', $this->data, true);
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
//                $this->data['formaspago'] = $this->magaModel->selectAll('formaspago');
                $this->data['formaspago']  = array(
                    0 => array("Codigo"=>0, "Descripcion"=>$this->lang->line('quotes_cash') ),
                    1 => array("Codigo"=>1, "Descripcion"=>$this->lang->line('quotes_credit_card') ),
                    2 => array("Codigo"=>2, "Descripcion"=>$this->lang->line('quotes_direct_debit') ),
                    3 => array("Codigo"=>3, "Descripcion"=>$this->lang->line('quotes_transfer') ),
                    4 => array("Codigo"=>4, "Descripcion"=>$this->lang->line('quotes_check') ),
                    5 => array("Codigo"=>5, "Descripcion"=>$this->lang->line('quotes_financed') ),
                    6 => array("Codigo"=>6, "Descripcion"=>$this->lang->line('quotes_online_payment') )
                );

                $html = $this->load->view('companies/partials/billing_data', $this->data, true);
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
                $this->load->model('AlumnoModel');
                $this->data['empleados'] = $this->AlumnoModel->getEmployee($client_id);
                $html = $this->load->view('companies/partials/employees', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function getAlumnosNotLinked(){
        if($this->input->is_ajax_request()){
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
                $this->load->model('AlumnoModel');
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
                $this->load->model('AlumnoModel');
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

    public function getDocumentsTable(){
        
        if($this->input->is_ajax_request()){
            $html = '';
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
                $this->load->model('DocumentModel');
                $this->data['documents'] = $this->DocumentModel->get_documents($client_id);
                $this->data['client_id'] = $client_id;
                $html = $this->load->view('companies/partials/documents', $this->data, true);
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
                $this->load->model('DocumentModel');
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
                $this->load->model('DocumentModel');
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
                $this->load->model('ClientesSeguiModel');
                $this->data['seguimientos'] = $this->ClientesSeguiModel->getSeguimiento($client_id, $usuario);
                $this->data['client_id'] = $client_id;
                $html = $this->load->view('companies/partials/follow_up', $this->data, true);
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
                $this->load->model('ClientesSeguiModel');
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
                    'label' => $this->lang->line('companies_followup_titulo'),
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'comentarios',
                    'label' => $this->lang->line('companies_followup_fecha'),
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'fecha',
                    'label' => $this->lang->line('companies_followup_comentario'),
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
                    $this->load->model('ClientesSeguiModel');
                    $last_id = $this->ClientesSeguiModel->insertFollowUp($dataArray);
                    if($last_id){
                        $response['result'] = $this->ClientesSeguiModel->getSeguimiento($last_id, $usuar_id);
                        $response['last_id'] = $last_id;
                        $response['success'] = $this->lang->line('companies_follow_up_added');
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
                    'label' => $this->lang->line('companies_followup_titulo'),
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'comentarios',
                    'label' => $this->lang->line('companies_followup_fecha'),
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'fecha',
                    'label' => $this->lang->line('companies_followup_comentario'),
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
                        $this->load->model('ClientesSeguiModel');
                        $response['result'] = $this->ClientesSeguiModel->getSeguimiento($follow_up_id, $usuar_id);                        
                        $response['success'] = $this->lang->line('companies_follow_up_updated');
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
                $html = $this->load->view('companies/partials/subsidiaries', $this->data, true);
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
    


    public function getHistoricFeesTable(){

        if($this->input->is_ajax_request()){
            $html = '';
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
                $this->load->model('MatriculatModel');
                $this->data['historic_fees'] = $this->MatriculatModel->getHistoricFees($client_id);
                $this->data['client_id'] = $client_id;
                $html = $this->load->view('companies/partials/historic_fees', $this->data, true);
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
                $this->load->model('ReciboModel');
                $this->data['historic_accounts'] = $this->ReciboModel->getHistoricAccount($client_id);
                $this->data['client_id'] = $client_id;
                $html = $this->load->view('companies/partials/historic_accounts', $this->data, true);
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
                $this->load->model('LstPlantillasCatModel');
                $plantillas_cat = $this->LstPlantillasCatModel->getPlantillasCatByNumbre('clientes');
                $this->data['id_cat'] = isset($plantillas_cat[0]->id) ? $plantillas_cat[0]->id : "10";
                $this->data['document_cat'] = $this->get_documentos($this->data['id_cat']);
                $this->data['client_id'] = $client_id;
                $html = $this->load->view('companies/partials/templates', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function Adicionales($id) {
        $result_data = array();
        $this->load->model('ClientesTabAdModel');
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

    public function update_adicionales($id) {
        $response['success'] = false;
        $response['errors'] = true;
        if($this->input->post()){
            $personalized_form_data = $this->input->post(NULL, true);
            $check_client = $this->ClientModel->getClientById($id);
            if(!empty($check_client)) {
                $form_data = array();
                $fields = array();
                $this->load->model('ClientesTabAdModel');
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
                        $response['success'] = $this->lang->line('companies_personalized_fields_updated');
                        $response['errors'] = false;
                    }else{
                        $response['errors'] = $this->lang->line('db_err_msg');
                    }
                } else {
                    $form_data['ccodcli'] = $id;
                    $result = $this->ClientesTabAdModel->insertFormData($form_data);
                    if ($result) {
                        $response['success'] = $this->lang->line('companies_personalized_fields_added');
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

    public function Adicionales_add($id) {
        $details = array();
        if($this->input->post()){
            $areaacademica = $this->input->post('areaacademica');
            $fecha = $this->input->post('fecha');
            $comments = $this->input->post('comments');
            $this->load->model('AreasAcademicaModel');
            $details = $this->AreasAcademicaModel->adicionalesAdd($id, $areaacademica, $comments, $fecha);
        }
        print_r($details);
        exit;
    }

    public function update_commercial_data($id) {
        $response['success'] = false;
        $response['errors'] = true;
        if ($this->input->post() && !empty($id)) {
            $post_data = $this->input->post(NULL, true);
            $post_data['custom_fields'] = json_encode($this->input->post('custom_fields', true));
            $this->config->set_item('language', $this->data['lang']);
            
            if($this->input->post('email_old', true) != $this->input->post('email', true)) {
                $is_unique_email =  '|is_unique[clientes.Email]';
            } else {
                $is_unique_email =  '';
            }
            if($this->input->post('cnomcli_old', true) != $this->input->post('cnomcli', true)) {
                $is_unique_cnomcli =  '|is_unique[clientes.cnomcli]';
            } else {
                $is_unique_cnomcli =  '';
            }

            $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email'.$is_unique_email);
            $this->form_validation->set_rules('cnomcli', $this->lang->line('fiscal_name'), 'trim|required'.$is_unique_cnomcli);
            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $post_data['custom_fields'] = json_encode($this->input->post('custom_fields', true));
                $update_data = $this->ClientModel->makeUpdateData($post_data);
                $result = $this->ClientModel->updateItem($update_data, $id);
                if($result){
                    $response['success'] = $this->lang->line('companies_commercial_data_updated');
                    $response['errors'] = false;
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

    public function add_client() {
        $response['success'] = false;
        $response['errors'] = true;
        if ($this->input->is_ajax_request()) {
            $post_data = $this->input->post(null, true);
            $post_data['custom_fields'] = implode(',',$this->input->post('custom_fields', true));
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|is_unique[clientes.Email]');
            $this->form_validation->set_rules('cnomcli', $this->lang->line('fiscal_name'), 'trim|required');
            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $this->load->model('ClientesTabAdModel');
                $personalized_data = $this->ClientesTabAdModel->get_personalized_data();
                $insert_personalized = array();
                if(!empty($personalized_data)){
                    foreach($personalized_data as $personalized){
                        if(isset($post_data[$personalized->name])){
                            $insert_personalized[$personalized->name] = $post_data[$personalized->name];
                        }

                    }
                }
                $this->load->model('Variables2Model');
                if($this->Variables2Model->updateNumClient()){
                    $id = $this->Variables2Model->getNumClient();
                    $post_data['ccodcli'] = $id[0]->NumCliente;

                    $this->load->model('ClientModel');
                    $insert_data = $this->ClientModel->makeInsertData($post_data);
                    if($this->ClientModel->insertClient($insert_data)){

                        $response['success'] = $this->lang->line('data_success_saved');
                        $insert_personalized['ccodcli'] = $post_data['ccodcli'];
                        try{
                            $this->ClientesTabAdModel->insertFormData($insert_personalized);
                        }catch (\Exception $er){
                            $response['errors'][] = $this->lang->line('db_err_msg');
                        }
                    }else{
                        $response['errors'][] = $this->lang->line('db_err_msg');
                    }
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
    public function cliente_delete($id) {
        $data['status'] = $this->magaModel->deleteClientes($id);
//        $this->curl->simple_get(base_url() . 'awsrest/bucketDelete/customer-' . $id);
        echo json_encode($data);
        exit;
    }

    private function makeInsertData($post_data){
        return array(
            'custom_fields' => $post_data['custom_fields'],
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
        if(isset($post_data['custom_fields'])){
            $update_data['custom_fields'] = $post_data['FirstUpdate'];
        }
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

    private function get_documentos($id) {
        $this->load->model('LstPlantillaModel');
        return $this->LstPlantillaModel->getDocumentos($id);
    }

    public function clientes() {
        $response['content'] = array();
        if($this->input->is_ajax_request()){
            $response['content'] = $this->ClientModel->getList();
           
        }
        echo json_encode($response);
        exit;
    }
    public function add_companies_steps(){
        $html = '';
        $step_id = $this->input->get('step_id', true);
        $ckeyslang = $this->my_language->load('clientes_form');
        $this->lang->load('clientes_form', $this->data['lang']);
        $this->data['page'] = 'companies_add';
        $this->data['clienteId'] = $this->input->get('clienteId', true);
        $this->data['clientId'] = $this->input->get('clienteId', true);
//        $this->data['formaspago'] = $this->magaModel->selectAll('formaspago');
        $this->data['formaspago']  = array(
            0 => array("Codigo"=>0, "Descripcion"=>$this->lang->line('quotes_cash') ),
            1 => array("Codigo"=>1, "Descripcion"=>$this->lang->line('quotes_credit_card') ),
            2 => array("Codigo"=>2, "Descripcion"=>$this->lang->line('quotes_direct_debit') ),
            3 => array("Codigo"=>3, "Descripcion"=>$this->lang->line('quotes_transfer') ),
            4 => array("Codigo"=>4, "Descripcion"=>$this->lang->line('quotes_check') ),
            5 => array("Codigo"=>5, "Descripcion"=>$this->lang->line('quotes_financed') ),
            6 => array("Codigo"=>6, "Descripcion"=>$this->lang->line('quotes_online_payment') )
            );
        $this->data['dataKeys'] = $ckeyslang;
        if(!empty($step_id)){
            switch ($step_id) {
                case 1:
                    $html .= $this->load->view('companies/partials/add_companies_steps/step1.php', $this->data, true);
                    break;
                case 2:
                    $html .= $this->load->view('companies/partials/add_companies_steps/step2.php', $this->data, true);
                    break;
                default:
            }
        }

        print_r(json_encode($html));
        exit;
    }

}
