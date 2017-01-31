<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\Ses\SesClient;
/**
 *@property ClientesTabAdModel $ClientesTabAdModel
 *@property PresupuestosTabAdModel $PresupuestosTabAdModel
 *@property PresupuestoSeguiModel $PresupuestoSeguiModel
 *@property PresupuestoTagsModel $PresupuestoTagsModel
 */

class Leads extends MY_Controller {

    public function __construct() {
        parent::__construct();

        if (empty($this->_identity['loggedIn'])) {
            redirect('/auth/login/', 'refresh');
        }
        $this->load->model('ContactosModel');
        $this->load->model('ErpConsultaModel');
        $this->load->model('PresupuestotModel');
        $this->load->model('CompanyModel');
        $this->load->model('AlumnoModel');
        $this->load->model('LstPlantillaModel');
        $this->load->model('AreasAcademicaModel');
        $this->load->model('ClientesDocModel');
        $this->load->model('ClientesSeguiModel');
        $this->load->model('ReciboModel');
        $this->load->model('MatriculatModel');
        $this->load->model('ClientModel');
        $this->load->model('LstPlantillasCatModel');
        $this->load->model('PresupuestoRuleModel');
        $this->load->model("LeadsModel");
        $this->load->model("ClientesTabAdModel");
        $this->load->model("PresupuestosTabAdModel");
        $this->load->model("PresupuestoSeguiModel");
        $this->load->model("TemplateModel");

//        $this->config->set_item('language', $this->data['lang']);
        $this->lang->load('leads', $this->data['lang']);
        $this->load->library('form_validation');
        $this->layouts->add_includes('js', 'app/js/leads/main.js');
    }

    public function index() {
        $this->layouts->add_includes('js', 'app/js/leads/index.js');
        $lang = $this->session->userdata('lang');
        $this->lang->load('clientes_form', $lang);
        $details = $this->magaModel->selectAll('clientes');
        $ckeyslang = $this->my_language->load('column_key');
        $this->data['page'] = 'leads';
        $countries = $this->db->get('estado_solicitud');
        $this->data['state'] = $countries->result();
        $this->data['dataKeys'] = $ckeyslang;
        $field = $lang == 'english' ? 'sql_en' : 'sql_es';
        $sql = $this->ErpConsultaModel->getField($field, 'lst_solicitudes');
        $this->data['state'] = $this->magaModel->selectCustom("SELECT hex(color) as color,valor,id from estado_solicitud");
//         print_r($sql);die;
        $this->data['content'] = $this->magaModel->selectCustom($lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);
        $this->layouts->view('leads/indexView', $this->data);
    }

    public function add() {

        $this->layouts->add_includes('js', 'app/js/leads_view/add_leads.js');
        $this->lang->load('clientes_form', $this->data['lang']);
        $this->data['isOwner']=$this->data['userData'][0]->owner;
        $this->data["flashMsg"] = "";
        if ($this->session->flashdata('editMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('editMsg');
        } else if ($this->session->flashdata('addMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('addMsg');
        } else if ($this->session->flashdata('deleteMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('deleteMsg');
        } else if ($this->session->flashdata('addErrorMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('addErrorMsg');
        }
        $this->data['clienteId'] = $this->session->userdata("userData")[0]->Id;

        $estado_data = $this->LeadsModel->getEstadoData();
        $this->data['estado_data'] = $estado_data;

        $medios_data = $this->LeadsModel->getMediosData();
        $this->data['medios_data'] = $medios_data;


        $this->data['formData']= $this->input->post(NULL, true);

        if(!empty($this->data['formData'])){
            $this->form_validation->set_rules('Nombre', $this->lang->line('leads_first_name'), 'trim|required');
            $this->form_validation->set_rules('sApellidos', $this->lang->line('leads_surname'), 'trim|required');
            $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email');
            $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');

            if($this->form_validation->run()){
                $post_data  = $this->input->post(NULL, true);
//                $post_data['custom_fields'] = implode(',',$this->input->post('custom_fields', true));
                $post_data['custom_fields'] =  json_encode($this->input->post('custom_fields', true));
                $this->data['formData'] =  $post_data;
                $result = $this->LeadsModel->addLeadsRecords($this->data['formData']);
                if ($result) {
                    $this->session->set_flashdata('success', 'The lead successfully added.');
                    $numPresupuesto = trim($this->data['formData']['NumPresupuesto']);
                    $prospect_data = $this->LeadsModel->getProspectDataById($numPresupuesto);
                    $replace_data = array(
                        'FIRSTNAME' => $prospect_data->first_name,
                        'SURNAME' => $prospect_data->last_name,
                        'FULLNAME' => $prospect_data->full_name,
                        //'PHONE1' => $prospect_data->,
                        'MOBILE' => $prospect_data->mobile,
                        'EMAIL1' => $prospect_data->email,
                        //'COURSE_NAME' => $course_data->course_name,
                        'START_DATE' => date('"F j, Y'),
                        'END_DATE' => date('"F j, Y'),
                    );

                    $this->load->model('ErpEmailsAutomatedModel');
                    $template = $this->ErpEmailsAutomatedModel->getByTemplateId('18', array('notify_student' => 1));
                    if (!empty($template) && !empty($prospect_data->email)) {
                        $email_subject = replaceTemplateBody($template->Subject, $replace_data);
                        $email_body = replaceTemplateBody($template->Body, $replace_data);
                        $this->send_automated_email($prospect_data->email, $email_subject, $email_body, $template->from_email);
                    }
                    redirect("leads/edit/$numPresupuesto");
                } else {
                    $this->session->set_flashdata('errors', array('There is an error while adding lead!'));
                }
            }else{
                $this->data['form_error'] = true;
            }

        }

                $cisess = $this->session->userdata('_cisess');
                $membership_type = $cisess['membership_type'];
                if($membership_type != 'FREE'){
                    $this->data['customfields_fields'] = $this->get_customfields_data();
                }
        $this->layouts->view("leads/addView", $this->data);
    }

public function get_customfields_data($id = null) {
       
        $type = 'leads';
        $custom_fields = $this->LeadsModel->getFieldsList($type);
        if(count($custom_fields) > 0){
                
            return $custom_fields;

        }else{
            return false;
        }
       
    }
    public function edit_old($id) {
        $this->layouts->add_includes('js', 'app/js/leads/edit_old.js');
        $lang = $this->session->userdata('lang');
        $this->data['lang'] = $lang;
        $this->lang->load('clientes_form', $lang);
        $this->data['page'] = 'Data Records';
        $field = $lang == 'english' ? 'sql_en' : 'sql_es';
        $sql = $this->ErpConsultaModel->getField($field, 'lst_sol_sol');
        $lsquery = str_replace("@", $id, $lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);
        $this->data['lst_sol_sol'] = $this->magaModel->selectCustom($lsquery);
        $sql2 = $this->ErpConsultaModel->getField($field, 'sel_cursos');
        $this->data['sel_cursos'] = $this->magaModel->selectCustom($lang == 'english' ? $sql2[0]->sql_en : $sql2[0]->sql_es);
        $countries = $this->db->get('estado_solicitud');
        $this->data['countries'] = $countries->result();
        $this->data['content'] = $this->PresupuestotModel->getContent($id);
        $this->data['campaign'] = $this->CompanyModel->getCampaign();

        $this->data['personal_fields'] = $this->get_personalized_data($id);
        $this->data['documentos'] = $this->documentos($id);
        $this->data['Seguimiento'] = $this->Seguimiento($id);
        $this->data['clienteId'] = $id;
        $this->data['historicAccount'] = $this->historicAccount($id);
        $this->data['HistoricFees'] = $this->HistoricFees($id);
        $this->data['Filiales'] = $this->Filiales($id);
        $this->data['clientes_tab_ad'] = $this->get_area_academica($id);
        $this->data['Adicionales'] = $this->Adicionales($id);
        $this->data['formaspago'] = $this->magaModel->selectAll('formaspago');
        $this->data['medios'] = $this->magaModel->selectAll('medios');
        $this->data['plantillas_cat'] = $this->plantillas_cat();
        $sql = $this->ErpConsultaModel->getField($field, 'lst_empresas');
        $this->data['clientes'] = $this->magaModel->selectCustom($lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);

        $this->data['alumnos'] = $this->AlumnoModel->getAlumnos();

        $ckeyslang = $this->my_language->load('column_key');
        $this->data['dataKeys'] = $ckeyslang;
        $this->data['leadId'] = $id;

        $plantillas_cat = $this->LstPlantillasCatModel->getPlantillasCatByNumbre(strtolower($this->data['controller_name']));
        $this->data['id_cat'] = isset($plantillas_cat[0]->id) ? $plantillas_cat[0]->id : "7";
        $this->data['document_cat'] = $this->get_documentos($this->data['id_cat']);


        $this->layouts->view('leads/edit_oldView', $this->data);
    }

    public function edit($id) {
        $this->layouts
            ->add_includes('css', 'assets/global/plugins/typeahead/typeahead.css')
            //->add_includes('css', 'assets/global/plugins/jquery-ui/jquery-ui.min.css')
            //->add_includes('js', 'assets/global/plugins/jquery-ui/jquery-ui.min.js')
            //->add_includes('js', 'assets/global/plugins/jquery-ui/ui/i18n/datepicker-es.js')

            ->add_includes('css', 'assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css')
            ->add_includes('css', 'assets/global/plugins/select2/css/select2.min.css')
            ->add_includes('css', 'assets/global/plugins/fancybox/source/jquery.fancybox.css')

            ->add_includes('js', 'assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js')
            ->add_includes('js', 'assets/global/plugins/select2/js/select2.full.min.js')
            ->add_includes('js', 'assets/global/plugins/fancybox/source/jquery.fancybox.js')

            ->add_includes('js', 'assets/global/plugins/typeahead/handlebars.min.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.min.js')
            ->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
            ->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
            ->add_includes('js', 'assets/global/plugins/select2/select2.js')
            ->add_includes('css', 'assets/global/plugins/spectrum/css/spectrum.css')
            ->add_includes('js', 'assets/global/plugins/spectrum/js/spectrum.js')
            ->add_includes('js', 'app/js/leads/edit.js');
 
        $this->lang->load('clientes_form', $this->data['lang']);
        $this->data['isOwner']=$this->data['userData'][0]->owner;
        $this->data['page'] = 'leads_edit';
        //
        $this->data['clientId'] = $id;
        $this->data['prospect_data'] = $this->PresupuestotModel->getProspectById($id);
        if(empty($this->data['prospect_data'])){
            redirect('prospects');
        }
        $this->data['add_edit'] = $this->lang->line('edit');

        $this->layouts->view('leads/editView', $this->data);
    }

    //tab_personal_data
    public function getPersonalData() {
        if($this->input->is_ajax_request()){
            $html = '';
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
//                $this->load->model('PresupuestotModel');
                $this->data['isOwner']=$this->data['userData'][0]->owner;
                $this->data['content'] = $this->PresupuestotModel->getContent($client_id);
                $this->data['personal_fields'] = $this->get_personalized_data($client_id);
                $cisess = $this->session->userdata('_cisess');
                $membership_type = $cisess['membership_type'];
                if($membership_type != 'FREE'){
                    $this->data['content'][0]->custom_fields = json_decode($this->data['content'][0]->custom_fields);
                    $this->data['customfields_fields'] = $this->get_customfields_data();
                }
                $this->data['companies'] = $this->get_companies($client_id);

                $html = $this->load->view('leads/partials/personal_data', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function getCompanies() {
        if($this->input->is_ajax_request()){
            $companies = false;
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
                $sql = $this->ErpConsultaModel->getField('sql_en', 'lst_empresas');
                if(isset($sql[0]->sql_en)){
                    $companies = $this->magaModel->selectCustom($sql[0]->sql_en);
                }
            }
            echo json_encode(array('data' => $companies));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function get_companies($client_id = null) {
            $companies = false;
            if(!empty($client_id)) {
                $sql = $this->ErpConsultaModel->getField('sql_en', 'lst_empresas');
                if(isset($sql[0]->sql_en)){
                    $companies = $this->magaModel->selectCustom($sql[0]->sql_en);
                }
            }
            return $companies;
    }

    //tab_details
    public function getDetails() {
        if($this->input->is_ajax_request()){
            $this->load->model('PresupuestolModel');
            $this->load->model('ErpTagsModel');
            $this->load->model('PresupuestoTagsModel');
            $html = '';
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
//                $this->load->model('PresupuestotModel');
                $this->data['content'] = $this->PresupuestotModel->getContent($client_id);                
                //$sql = $this->ErpConsultaModel->getField('sql_en', 'lst_sol_sol');
               // vardump($sql);exit;
                //if(isset($sql[0]->sql_en)){
                    //$lsquery = str_replace("@", $client_id, $sql[0]->sql_en);
               // }else{
                    //$this->data['lst_sol_sol'] = array();
               // }
                $this->data['lst_sol_sol'] = $this->PresupuestotModel->getRequestedCourses( $client_id );

                //$sql2 = $this->ErpConsultaModel->getField('sql_en', 'sel_cursos');
//                if(isset($sql2[0]->sql_en)){
//                    //vardump($sql2[0]->sql_en);exit;
//                    $this->data['sel_cursos'] = $this->PresupuestotModel->getCoursesForAdd();
//                }else{
//                    $this->data['sel_cursos'] = array();
//                }
                $this->data['sel_cursos'] = $this->PresupuestotModel->getCoursesForAdd();
                $bookmark = '<span class="span_bookmark"><i class="fa first fa-star'. ($this->data['content'][0]->prospect_priority >= 0 ? '' : '-o') .' bookmark" data-status="true"></i><i class="fa middle fa-star'. ($this->data['content'][0]->prospect_priority >= 1 ? '' : '-o') .' bookmark" data-status="true"></i><i class="fa last fa-star'. ($this->data['content'][0]->prospect_priority == 2 ? '' : '-o') .'  bookmark" data-status="true"></i></span>';
                $this->data['bookmark'] = $bookmark;
                $this->data['offered_courses'] = $this->PresupuestolModel->getCourses($client_id);
                $this->data['prospect_tags'] = $this->PresupuestoTagsModel->getTags($client_id);
                $this->data['prospect_tag_ids'] = array();
                if(!empty($this->data['prospect_tags'])){
                    foreach($this->data['prospect_tags'] as $tag){
                        $this->data['prospect_tag_ids'][] = $tag->tag_id;
                    }
                }
                //$where_not_in = "SELECT id_tag FROM presupuesto_tags WHERE numpresupuesto ='".$client_id."'";
                $this->data['tags'] = $this->ErpTagsModel->getTagsForfilterBytable();
                $html = $this->load->view('leads/partials/details', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    // tagging

    public function add_tags(){ // this is old version not used
        if($this->input->is_ajax_request()){
            $this->load->model('PresupuestoTagsModel');
            $this->load->model('ErpTagsModel');
            $client_id= $this->input->post('client_id', true);
            $tags_ids = $this->input->post('tag_ids', true);
            $result = false;
            $tags_not_added = array();
            $prospect_tags = array();
            if($client_id && $tags_ids){
                $tags_ids_array = explode(',', $tags_ids);
                if(!empty($tags_ids_array)) {
                    $checking_ids = $this->ErpTagsModel->getNotExistTags($tags_ids_array, $client_id, 'presupuesto_tags', 'numpresupuesto'); // presupuesto_tags is table name  and numpresupuesto is foreign key column name
                    $insert_data = array();
                    if(!empty($checking_ids)) {
                        foreach ($checking_ids as $tag) {
                            if(empty($tag->current_table_tag_id) && empty($tag->numpresupuesto)) {
                                $insert_data[] = array('numpresupuesto' => $client_id, 'id_tag' => $tag->tag_id);
                            }
                        }
                    }
                    $result = $this->PresupuestoTagsModel->insertBatch($insert_data);
                }
                if($result) {
                    $prospect_tags = $this->PresupuestoTagsModel->getTags($client_id);
                    $where_not_in = "SELECT id_tag FROM presupuesto_tags WHERE numpresupuesto ='".$client_id."'";
                    $tags_not_added = $this->ErpTagsModel->getTagsForfilterBytable($where_not_in);
                }
            }
            echo json_encode(array('result' => $result, 'tags' => $tags_not_added, 'prospect_tags' => $prospect_tags));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function update_tags(){
        if($this->input->is_ajax_request()){
            $this->load->model('PresupuestoTagsModel');
            $this->load->model('ErpTagsModel');
            $client_id= $this->input->post('client_id', true);
            $tags_ids = $this->input->post('value', true);
            $result = false;
            $tags_ids_array = array();
            if($client_id){
                $this->PresupuestoTagsModel->deleteAllItems($client_id);
                if(!empty($tags_ids) && is_array($tags_ids)) {

                    $checking_ids = $this->ErpTagsModel->getNotExistTags($tags_ids, $client_id, 'presupuesto_tags', 'numpresupuesto'); // presupuesto_tags is table name  and numpresupuesto is foreign key column name
                    $insert_data = array();
                    if(!empty($checking_ids)) {
                        foreach ($checking_ids as $tag) {
                            if(empty($tag->current_table_tag_id) && empty($tag->numpresupuesto)) {
                                $insert_data[] = array('numpresupuesto' => $client_id, 'id_tag' => $tag->tag_id);
                                $tags_ids_array[] = $tag->tag_id;
                            }
                        }
                    }
                    $result = $this->PresupuestoTagsModel->insertBatch($insert_data);
                }
            }
            echo json_encode(array('result' => $result, 'tag_ids' => $tags_ids_array));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function deleteTag(){ // this is old version not used
        if($this->input->is_ajax_request()){
            $this->load->model('PresupuestoTagsModel');
            $this->load->model('ErpTagsModel');
            $client_id = $this->input->post('client_id', true);
            $tag_id = $this->input->post('tag_id', true);
            $result = false;
            $tags_not_added = array();
            if($client_id && $tag_id){
                $result = $this->PresupuestoTagsModel->deleteItem($client_id, $tag_id);
                $where_not_in = "SELECT id_tag FROM presupuesto_tags WHERE numpresupuesto ='".$client_id."'";
                $tags_not_added = $this->ErpTagsModel->getTagsForfilterBytable($where_not_in);
            }
            echo json_encode(array('success' => $result, 'tags' => $tags_not_added));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }


    public function getNotExistMedios(){
        if($this->input->is_ajax_request()){
            $not_exist_medios = false;
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
                $this->load->model('MedioModel');
                $not_exist_medios = $this->MedioModel->getNotExistMedios($client_id);               
            }
            echo json_encode(array('data' => $not_exist_medios));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function unassignExistMedios(){
        if($this->input->is_ajax_request()){
            $unassign_exist_medios = false;
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
                $unassign_exist_medios = $this->PresupuestotModel->unassignExistMedios($client_id);
                if($unassign_exist_medios){
                    $this->syncUpdateEgoi($client_id);
                }
            }
            echo json_encode(array('status' => $unassign_exist_medios));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function getNotExistCampaigns(){
        if($this->input->is_ajax_request()){
            $not_exist_campaign = false;
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
               $not_exist_campaign = $this->CompanyModel->getNotExistCampaigns($client_id);                
            }
            echo json_encode(array('data' => $not_exist_campaign));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }


    public function unassignExistCampaigns(){
        if($this->input->is_ajax_request()){
            $unassign_exist_campana = false;
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
                $unassign_exist_campana = $this->PresupuestotModel->unassignExistCampana($client_id);
                if($unassign_exist_campana){
                    $this->syncUpdateEgoi($client_id);
                }
            }
            echo json_encode(array('status' => $unassign_exist_campana));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function add_courses(){
        $result['status'] = false;
        if($this->input->is_ajax_request()){
            $client_id = $this->input->post('client_id', true);
            $ids = $this->input->post('ids', true);

            if(!empty($client_id) && !empty($ids)) {
                $cid = "";
                foreach($ids as $list){
                    $cid .="'$list'".',';
                }
                $cid = rtrim($cid,',');

                $this->load->model('PresupuestoSolicitudModel');
                $result['status'] =  $this->PresupuestoSolicitudModel->addCourses($client_id, $cid);                
            }
        }
        print_r(json_encode($result));
        exit;
    }    
    public function getLstSolSol(){
        
        if($this->input->is_ajax_request()){
            $lst_sol_sol = false;
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
                /*$sql = $this->ErpConsultaModel->getField('sql_en', 'lst_sol_sol');
                if(isset($sql[0]->sql_en)){
                    $lsquery = str_replace("@", $client_id, $sql[0]->sql_en);
                    $lst_sol_sol = $this->magaModel->selectCustom($lsquery);
                }*/
                $lst_sol_sol = $this->PresupuestotModel->getRequestedCourses( $client_id );
            }
            echo json_encode(array('data' => $lst_sol_sol));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function deleteItemCourse($id = null){
        $result['status'] = false;
        $result['error_msg'] = '';
        if($this->input->is_ajax_request()){
            $this->load->model('PresupuestoSolicitudModel');
            $client_id = $this->input->post('client_id', true);
            $checking_offered_courses = $this->PresupuestoSolicitudModel->getExistOfferedCourses($client_id, $id);
            if(empty($checking_offered_courses)) {
                if (!empty($client_id) && !empty($id)) {
                    $this->load->model('PresupuestoSolicitudModel');
                    $result['status'] = $this->PresupuestoSolicitudModel->deleteItem($id);
                }
            }else{
                $result['error_msg'] = $this->lang->line('leads_delete_requested_course_err_msg');
            }
            echo json_encode($result);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function deleteOfferedCourse($id = null){
        $result['status'] = false;
        if($this->input->is_ajax_request()){
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id) && !empty($id)) {
                $this->load->model('PresupuestolModel');
                $result['status'] =  $this->PresupuestolModel->deleteItem($id);
            }
            echo json_encode($result);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getCoursesForOffered(){
        if($this->input->is_ajax_request()){
            $client_id = $this->input->post('client_id', true);
            $courses = array();
            if(!empty($client_id)) {
                $this->load->model('PresupuestolModel');
                $this->load->model('PresupuestoSolicitudModel');
                $exist_courses =  $this->PresupuestolModel->getExistCourses($client_id);
                $exist_ids = array();
                if(!empty($exist_courses)){
                    foreach($exist_courses as $courses){
                        $exist_ids[] = $courses->course_id;
                    }
                }
                $courses = $this->PresupuestoSolicitudModel->getCoursesOffered($client_id, $exist_ids);
            }
            echo json_encode(array('data' => $courses));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function getCoursesForRequest(){
        if($this->input->is_ajax_request()){
            $client_id = $this->input->post('client_id', true);
            $courses_id = $this->input->post('courses_id', true);
            if($courses_id) {
                $courses_id = '(' . implode(",", $courses_id) . ')';
            }
            $sel_cursos = array();
            if(!empty($client_id)) {
                $this->load->model('PresupuestolModel');
                $sel_cursos = $this->PresupuestotModel->getCoursesForAddWhereIn($courses_id);
            }
            echo json_encode(array('data' => $sel_cursos));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }


    public function addOfferedCourses(){
        if($this->input->is_ajax_request()){
            $client_id = $this->input->post('client_id', true);
            $ids = $this->input->post('ids', true);
            $result = false;
            $courses = array();
            if(!empty($client_id) && !empty($ids)) {
                $this->load->model('PresupuestolModel');
                $this->load->model('PresupuestoSolicitudModel');
                $courses =  $this->PresupuestoSolicitudModel->getCoursesByids($client_id, $ids);
                if(!empty($courses)){
                  $result = $this->PresupuestolModel->insertData($courses);
                    $courses = $this->PresupuestolModel->getCourses($client_id);
                }
            }
            echo json_encode(array('success' => $result, 'data' => $courses));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function update_details($client_id = null){
        if($this->input->is_ajax_request()){
            $response = false;
            if(!empty($client_id)) {
                $post_data = (array)$this->input->post(NULL, true);
                $data = array(
                    'medio' => isset($post_data['medio']) ? $post_data['medio'] : null,
                    'Campaña' => isset($post_data['Campaña']) ? $post_data['Campaña'] : null,
                    'score' => isset($post_data['score']) && $post_data['score'] >=0 &&  $post_data['score'] <= 100 ? $post_data['score'] : 0,
                    'prioridad' => isset($post_data['priority']) && $post_data['priority'] >= 0 && $post_data['priority'] <= 2 ? $post_data['priority'] : 0
                );
                $response = $this->PresupuestotModel->updateItem($data, $client_id);
                if($response){
                    $this->syncUpdateEgoi($client_id);
                }
            }
            echo json_encode(array('status' => $response));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }        
    }

    private function syncUpdateEgoi($client_id){
        $this->load->model('ZapEgoiMappingModel');
        $this->load->model('PresupuestotModel');
        $mappedFields = $this->ZapEgoiMappingModel->getMappedFiledsByTable('1');
        $result_egoi = array();
        $this->load->model('SftConfigEgoiModel');
        $result_e_goi = $this->SftConfigEgoiModel->getEgoiData();
        if (!empty($result_e_goi)) {
            $EgoiList = $this->getEgoiList($result_e_goi->apikey);
            $params = array(
                'apikey' => $result_e_goi->apikey,
                'listID' => $EgoiList[0]['listnum'],
                //'subscriber' => $updated_data['email'],
                'validate_phone' => 0,
                'lang' => 'es',
            );
            //vardump($result_egoi);exit;
        }
        if(!empty($mappedFields)){
            $select_str = 'presupuestot.email,';
            foreach($mappedFields as $field){
                $select_str .= $field->table_name.'.'.$field->field_name.',';
            }
            $select_str = trim($select_str,',');
            if(!empty($select_str)) {
                $updated_data = $this->PresupuestotModel->getExtraFields($select_str, array('NumPresupuesto' => $client_id));
                if (!empty($updated_data)) {
                    foreach ($mappedFields as $fields_) {
                        $params['extra_' . $fields_->egoi_list] = $updated_data[$fields_->field_name];
                    }
                }
            }
            if(!empty($params)) {
                $params['subscriber'] = $updated_data['email'];
                //vardump($params);exit;
                $result_egoi = $this->editSubscriber($params);
            }
        }
       return  $result_egoi;
    }

    //tab_documents start
    public function getDocumentsTable(){

        if($this->input->is_ajax_request()){
            $html = '';
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
                $this->load->model('PresupuestoDocModel');
                $this->data['documents'] = $this->PresupuestoDocModel->getDocuments($client_id);
                $this->data['client_id'] = $client_id;
                $html = $this->load->view('leads/partials/documents', $this->data, true);
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
                $this->load->model('PresupuestoDocModel');
                $documents = $this->PresupuestoDocModel->getDocuments($client_id);
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
                $this->load->model('PresupuestoDocModel');
                $response = $this->PresupuestoDocModel->deleteDocumentByIdClientId($document_id, $client_id);
            }
            echo json_encode(array('status' => $response));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    //tab_documents end
    
    //tab_follow_up start
    public function getFollowUpTable(){

        if($this->input->is_ajax_request()){
            $html = '';
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {
                $usuar_id = isset($this->data['userData'][0]->Id) ? $this->data['userData'][0]->Id : null;
                $this->data['seguimientos'] = $this->PresupuestoSeguiModel->getSeguimiento($client_id, $usuar_id);
                $this->data['client_id'] = $client_id;
                $html = $this->load->view('leads/partials/follow_up', $this->data, true);
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
                $seguimientos = $this->PresupuestoSeguiModel->getSeguimiento($client_id, $usuario);
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
                    'label' => $this->lang->line('leads_followup_titulo'),
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'comentarios',
                    'label' => $this->lang->line('leads_followup_comentario'),
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'fecha',
                    'label' => $this->lang->line('leads_followup_fecha'),
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
                        'NumPresupuesto' => $client_id
                    );
                    $last_id = $this->PresupuestoSeguiModel->insertFollowUp($dataArray);
                    if($last_id){
                        $response['result'] = $this->PresupuestoSeguiModel->getSeguimiento($last_id, $usuar_id);
                        $response['last_id'] = $last_id;
                        $response['success'] = $this->lang->line('leads_follow_up_added');
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
                    'label' => $this->lang->line('leads_followup_titulo'),
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'comentarios',
                    'label' => $this->lang->line('leads_followup_comentario'),
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'fecha',
                    'label' => $this->lang->line('leads_followup_fecha'),
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
                        'NumPresupuesto' => $client_id
                    );

                    $updated = $this->magaModel->update('presupuesto_segui', $dataArray, $where);
                    if($updated){
                        $response['result'] = $this->PresupuestoSeguiModel->getSeguimiento($follow_up_id, $usuar_id);
                        $response['success'] = $this->lang->line('leads_follow_up_updated');
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
                    'NumPresupuesto' => $client_id
                );
                $deleted = $this->magaModel->delete('presupuesto_segui', $where);
            }
            echo json_encode(array('status' => $deleted));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    //tab_follow_up end

    //tab_templates start    
    public function getTemplates(){

        if($this->input->is_ajax_request()){
            $html = '';
            $client_id = $this->input->post('client_id', true);
            if(!empty($client_id)) {

                $plantillas_cat = $this->LstPlantillasCatModel->getPlantillasCatByNumbre(strtolower($this->data['controller_name']));
                $id_cat = isset($plantillas_cat[0]->id) ? $plantillas_cat[0]->id : "7";
                $document_cat = $this->TemplateModel->getAllUsersTemplates($id_cat);//$this->get_documentos($this->data['id_cat']);
            }
            echo json_encode(array('templates'=>$document_cat, 'cat_id'=>$id_cat));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    //tab_templates end
    
    
    public function get_documentos($id) {
        return $this->LstPlantillaModel->getDocumentos($id);
        //return json_encode($DocAsociado);
    }

    public function updateinfo_post() {
        $data['alumnos'] = $this->magaModel->updatedata($_POST);
        redirect(base_url('leads/edit/' . $_POST['id'] . '#personalized_fields'));
    }

    public function leads() {
        $lang = $this->session->userdata('lang');
        $data['page'] = 'Data Records';
        // $ckeyslang = $this->my_language->load('contactos_form');
        //$data['dataKeys'] =$ckeyslang;
        $field = $lang == 'english' ? 'sql_en' : 'sql_es';
        $sql = $this->ErpConsultaModel->getField($field, 'lst_solicitudes');
        $data['content'] = $this->magaModel->selectCustom($lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);
        echo json_encode($data);
    }

    public function cliente_delete($id) {
        $data['status'] = $this->magaModel->deleteClientes($id);
        $this->curl->simple_get(base_url() . 'awsrest/bucketDelete/customer-' . $id);
        echo json_encode($data);
    }

    public function updateBookmark() {
        $data['status'] = $this->magaModel->update('presupuestot', array('bookmark' => $this->input->post('bookmark')), array('NumPresupuesto' => $this->input->post('id')));
        echo json_encode($data);
    }

    public function markAsRead_patch($id) {
        $data['status'] = $this->magaModel->update('presupuestot', array('leido' => 0), array('NumPresupuesto' => $id));
        echo json_encode($data);
    }

    public function create_post() {
        $data['status'] = $this->ContactosModel->insert($this->input->post());
        echo json_encode($data);
    }

    public function get_area_academica($id) {
        return $this->AreasAcademicaModel->getAreaAcademica();
    }

    public function Adicionales($id) {
        return $this->AreasAcademicaModel->getAdicionales($id);
    }

   private function get_personalized_data($id) {
        $result_data = array();
        $personalized_data = (array)$this->PresupuestosTabAdModel->getByPresupuestoId($id);

        $personalized_fields = $this->PresupuestosTabAdModel->getFieldList();

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
        $areaacademica = $this->input->post('areaacademica');
        $fecha = $this->input->post('fecha');
        $comments = $this->input->post('comments');
        $details = $this->AreasAcademicaModel->adicionalesAdd($id, $areaacademica, $comments, $fecha);
        print_r($details);
    }

    public function Adicionales_update_post($id) {
        $areaacademica = $this->input->post('areaacademica');
        $fecha = $this->input->post('fecha');
        $comments = $this->input->post('comments');
        $details = $this->AreasAcademicaModel->adicionalesUpdate($id, $areaacademica, $comments, $fecha);
        print_r($details);
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
        $id = $this->input->post('id');
        $details = $this->magaModel->selectAll('alumnos');
        return $details;
    }

    public function documentos($id) {
        if ($this->input->post()) {
            $this->documentos_post($id);
        }
        return $this->ClientesDocModel->getDocumentos($id);
    }

    public function Seguimiento($id) {
        $userData = $this->session->userdata('userData');
        $usuar_id = isset($userData[0]->Id) ? $userData[0]->Id : null;
        return $this->PresupuestoSeguiModel->getFollowUp($id);
    }

    public function Seguimiento_post($id) {
        $userData=$this->session->userdata('userData');
    	$lang = $this->session->userdata('lang');
    	$data = (array) $this->input->post();
    	foreach($data as $key=>$list){
	    	if($key==='fecha'){
	    		if($lang == "english"){
	    		$data[$key] = DateTime::createFromFormat('m/d/Y', $list)->format('Y-m-d');
	    		}else{
	    		$data[$key]= DateTime::createFromFormat('d/m/Y', $list)->format('Y-m-d');
	    		}
	    	}
    	}
    	$data['usuario'] = $userData[0]->USUARIO;
    	$data['numpresupuesto'] = $id;
        $details = $this->magaModel->insert('presupuesto_segui',$data);
        print_r($details);
    }

    public function Seguimiento_edit($id) {
        $details = array();
        if ($this->input->post()) {
            $lang = $this->session->userdata('lang');
            $userData=$this->session->userdata('userData');
            $data = (array) $this->input->post();
            foreach($data as $key=>$list){
                if($key==='fecha'){
                    if($lang == "english"){
                        $data[$key] = DateTime::createFromFormat('m/d/Y', $list)->format('Y-m-d');
                    }else{
                        $data[$key]= DateTime::createFromFormat('d/m/Y', $list)->format('Y-m-d');
                    }
                }
            }
            $data['usuario'] = $userData[0]->USUARIO;
            $details = $this->magaModel->update('presupuesto_segui',$data,array('id'=>$id));
        }
        print_r($details);
        exit;
    }

    public function seguimiento_delete($id) {
        $detail = $this->magaModel->delete('presupuesto_segui',array('id'=>$id));
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

    public function empleados($id) {
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

    public function update_personal_data($id = null) {
        $response['success'] = false;
        $response['errors'] = true;
        if($this->input->post() && !empty($id)){
            $post_data = (array) $this->input->post(NULL, true);

            $update_data = $this->newMakeInsertData($post_data);

            $result = $this->magaModel->update('presupuestot', $update_data, array('NumPresupuesto' => $id));
            if($result){
                $response['success'] = $this->lang->line('leads_personal_data_updated');
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

    private function newMakeInsertData($post_data){
        $update_data = array();

        if(isset($post_data['custom_fields'])){
            $update_data['custom_fields'] = $post_data['custom_fields'];
        }
        if(isset($post_data['sNombre'])){
            $update_data['sNombre'] = $post_data['sNombre'];
        }
        if(isset($post_data['sApellidos'])){
            $update_data['sApellidos'] = $post_data['sApellidos'];
        }
        if(isset($post_data['Poblacion'])){
            $update_data['Poblacion'] = $post_data['Poblacion'];
        }
        if(isset($post_data['Provincia'])){
            $update_data['Provincia'] = $post_data['Provincia'];
        }
        if(isset($post_data['domicilio'])){
            $update_data['domicilio'] = $post_data['domicilio'];
        }
        if(isset($post_data['Nacimiento']) && strtotime($post_data['Nacimiento']) < strtotime(date("Y-m-d"))){
            $update_data['Nacimiento'] = date('Y-m-d',strtotime($post_data['Nacimiento']));
        }
        if(isset($post_data['pais'])){
            $update_data['pais'] = $post_data['pais'];
        }
        if(isset($post_data['idsexo'])){
            $update_data['idsexo'] = $post_data['idsexo'];
        }
        if(isset($post_data['Telefono'])){
            $update_data['Telefono'] = $post_data['Telefono'];
        }
        if(isset($post_data['Telefono2'])){
            $update_data['Telefono2'] = $post_data['Telefono2'];
        }
        if(isset($post_data['Movil'])){
            $update_data['Movil'] = $post_data['Movil'];
        }
        if(isset($post_data['CDNICIF'])){
            $update_data['CDNICIF'] = $post_data['CDNICIF'];
        }
        if(isset($post_data['email'])){
            $update_data['email'] = $post_data['email'];
        }
        if(isset($post_data['email2'])){
            $update_data['email2'] = $post_data['email2'];
        }
        if(isset($post_data['Fax'])){
            $update_data['Fax'] = $post_data['Fax'];
        }
        if(isset($post_data['iban'])){
            $update_data['iban'] = $post_data['iban'];
        }
        if(isset($post_data['cc1'])){
            $update_data['cc1'] = $post_data['cc1'];
        }
        if(isset($post_data['cc2'])){
            $update_data['cc2'] = $post_data['cc2'];
        }
        if(isset($post_data['cc3'])){
            $update_data['cc3'] = $post_data['cc3'];
        }
        if(isset($post_data['cc4'])){
            $update_data['cc4'] = $post_data['cc4'];
        }
        if(isset($post_data['facturara'])){
            $update_data['facturara'] = $post_data['facturara'];
        }

        return $update_data;

    }

    public function datos_comerciales($id) {
        $details = array();
        if ($this->input->post()) {
            $lang = $this->session->userdata('lang');
            $data = (array) $this->input->post();
            foreach ($data as $key => $list) {
                if ($key === 'Nacimiento') {
                    if ($lang == "english") {
                        $data[$key] = DateTime::createFromFormat('m/d/Y', $list)->format('Y-m-d');
                    } else {
                        $data[$key] = DateTime::createFromFormat('d/m/Y', $list)->format('Y-m-d');
                    }
                }
            }
            $details = $this->magaModel->update('presupuestot', $data, array('NumPresupuesto' => $id));
        }
        print_r($details);
        exit;
    }

	public function datos_fcturation($id){
        $query = '';
        if ($this->input->post()) {
            $query = $this->db->query("UPDATE `presupuestot` SET `medio` = '".$this->input->post('medio')."', `Campaña` = '".$this->input->post('Campaña')."', `Descripcion` = '".$this->input-post('Descripcion')."' WHERE `NumPresupuesto` = '$id'");
        }
        print_r($query);
        exit;
    }

    public function course_add($id){
        $result = array();
        if ($this->input->post()) {

            if(null!=$this->input->post('ids')){
                $ids = $this->input->post('ids');
                $cid = "";
                foreach($ids as $list){
                    $cid .="'$list'".',';
                }
                $cid = rtrim($cid,',');
                $result = $this->db->query("INSERT INTO presupuesto_solicitud (NumPresupuesto, CodigoCurso, Descripcion, Horas, Precio, dto, neto)
			SELECT $id,codigo,curso,horas,precio,0,precio FROM curso WHERE codigo IN ($cid)");
            }
        }
        print_r($result);
        exit;
    }

    public function deletecourse_delete($id){
    	$data = $this->db->query("DELETE FROM presupuesto_solicitud WHERE id='$id'");
        print_r($data);
    }

    public function datos_comerciales_add_post($id) {
        $details = $this->magaModel->insert('clientes', $this->input->post());
        print_r($details);
    }

    public function bulk_operation() {

        if ($this->input->post()) {
            $ids = $this->input->post('ids', true);
            $tasks = $this->input->post('tasks', true);
            $value = $this->input->post('value', true);

            if($ids){
                foreach ($ids as $id) {
                    $update_data[$tasks] = $value;
                    $this->db->where('NumPresupuesto', $id);
                    $this->db->update('presupuestot', $update_data);
                }
                return true;
            }
        }
        return false;
    }

    public function detail_medios_link($id) {
        $details = array();
        if ($this->input->post()) {
            $linkFrom = $this->input->post('linkFrom');
            $details = $this->magaModel->update('presupuestot', array('medio' => $id), array('NumPresupuesto' => $linkFrom));

        }
        print_r($details);
        exit;
    }

    public function documentos_post($id) {
        $details =  $this->LstPlantillaModel->getDocumentos($id);
        $docAsociado = [];
        if (!empty($details)) {
            $docAsociado[] = ['id' => '0', 'name' => 'select'];
            foreach ($details as $row) {
                $DocAsociado[] = ['id' => $row->id, 'name' => $row->DocAsociado];
            }
        }
        echo json_encode($DocAsociado);
        exit;
    }

    public function documentodata($id) {
        $webDocumento = '';
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
            $clientres = $this->magaModel->get_details_leads($clienteId);
            $clientarray = json_decode(json_encode($clientres), true);
            $webDocumento = $webDocumentoDetail[0]->webDocumento;
            foreach ($clientarray[0] as $index => $row) {
                $webDocumento = str_replace('[' . $index . ']', $row, $webDocumento);
            }
        }
        echo $webDocumento;
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

    public function rules() {

        $response = false;
        if ($this->input->post()) {
            $sql_arr = $this->PresupuestoRuleModel->getCsql();
            foreach($sql_arr as $csql_obj){
                if(isset($csql_obj->csql) && !empty($csql_obj->csql)){
                    $this->db->query($csql_obj->csql);
                    $response = true;
                }
            }
        }

        echo json_encode(array('response'=>$response));
        exit;
    }


    public function getIncreasedValue() {
        $leadsCheck = $this->input->post("leadsCheck");
        if ($leadsCheck) {
            if ($leadsCheck == "newAdd") {
                $leadId = $this->LeadsModel->updateVariable();
                echo trim($leadId);
            }
        }
    }

    public function getLeadIncrementedId() {
        $leadId = $this->LeadsModel->updateVariable();
        return trim($leadId);
    }



    public function getCopyUsers() {
        $this->data["users"] = $this->LeadsModel->getCopyContactos();
        $html = $this->load->view("leads/getCopyUsers", $this->data, true);
        echo $html;
        exit;
    }

    public function getCopyStudents() {
        $this->data["users"] = $this->LeadsModel->getCopyStudents();
        $html = $this->load->view("leads/getCopyStudents", $this->data, true);
        echo $html;
        exit;
    }

    public function getCopyUsersArray() {
        $formData = $this->input->post();
        $users = $this->LeadsModel->getCopyUsers($formData);
        $items = array();
        foreach ($users as $user) {
            array_push($items, $user);
        }
        $result["rows"] = $items;

        echo json_encode($result);
    }

    public function addExistUser($userId = false, $profileId = false) {
        $leadId = $this->getLeadIncrementedId();
//        echo $leadId; exit;
        if ($leadId > 0 && $userId > 0) {
            $result = $this->LeadsModel->addExistingUser($leadId, $userId, $profileId);
            if ($result > 0) {
                $this->load->model('SftConfigEgoiModel');
                $result_e_goi = $this->SftConfigEgoiModel->getEgoiData();
                $EgoiList = $this->getEgoiList($result_e_goi->apikey);
                $prospect_data = $this->LeadsModel->getProspectDataById($leadId);
                $params = array(
                    'apikey' => $result_e_goi->apikey,
                    'listID' => $EgoiList[0]['listnum'],
                    'email' => $prospect_data->email,
                    'validate_phone' => 0,
                    'cellphone' => $prospect_data->mobile,
                    'telephone' => $prospect_data->phone,
                    'fax' => $prospect_data->Fax,
                    'first_name' => $prospect_data->first_name,
                    'last_name' => $prospect_data->last_name,
                    'birth_date' => $prospect_data->Nacimiento,
                    'status' => '1',
                    'lang' => 'es',
                );
                $this->load->model('ZapEgoiMappingModel');
                $mappedFields = $this->ZapEgoiMappingModel->getMappedFiledsByTable('1');
                if(!empty($mappedFields)) {
                    $select_str = '';
                    foreach ($mappedFields as $field) {
                        $select_str .= $field->table_name . '.' . $field->field_name . ',';
                    }
                    $select_str = trim($select_str, ',');
                    if (!empty($select_str)) {
                        $updated_data = $this->PresupuestotModel->getExtraFields($select_str, array('NumPresupuesto' => $client_id));
                        if (!empty($updated_data)) {
                            foreach ($mappedFields as $fields_) {
                                $params['extra_' . $fields_->egoi_list] = $updated_data[$fields_->field_name];
                            }
                        }
                    }
                }

                if(!empty($params['email'])) {
                    $result_addSubscriber = $this->addSubscriber($params);
                }

                $replace_data = array(
                    'FIRSTNAME' => $prospect_data->first_name,
                    'SURNAME' => $prospect_data->last_name,
                    'FULLNAME' => $prospect_data->full_name,
                    //'PHONE1' => $prospect_data->,
                    'MOBILE' => $prospect_data->mobile,
                    'EMAIL1' => $prospect_data->email,
                    //'COURSE_NAME' => $course_data->course_name,
                    'START_DATE' => date('"F j, Y'),
                    'END_DATE' => date('"F j, Y'),
                );

                $this->load->model('ErpEmailsAutomatedModel');
                $template = $this->ErpEmailsAutomatedModel->getByTemplateId('18', array('notify_student' => 1));
                if (!empty($template) && !empty($prospect_data->email)) {
                    $email_subject = replaceTemplateBody($template->Subject, $replace_data);
                    $email_body = replaceTemplateBody($template->Body, $replace_data);
                    $this->send_automated_email($prospect_data->email, $email_subject, $email_body, $template->from_email);
                }

                redirect(base_url() . "leads/edit/" . $result);
            } else {
                $this->session->set_flashdata('addMsg', 'There is an error while add user!');
                redirect(base_url() . "leads/add/");
            }
        }
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

    public function deleteLead($leadId = false, $profileId = false) {
        if ($leadId > 0) {
            $result = $this->LeadsModel->deleteLead($leadId, $profileId);
            redirect(base_url() . "leads");
        }
    }

    public function updatePersonalized() {
        if($this->input->post()){
            $res_data['status'] = false;
            $personalized_form_data = $this->input->post('personalized_data', true);
            $id = $this->input->post('id', true);
            if($id && !empty($personalized_form_data)) {
                $form_data = array();
                $fields = array();
                $check_id_exist = $this->PresupuestosTabAdModel->getByPresupuestoId($id);
                $fields_list = $this->PresupuestosTabAdModel->getFieldList();
                foreach ($fields_list as $field) {
                    $fields[$field->name] = $field->name;
                }
                if (!empty($personalized_form_data) && !empty($fields)) {
                    foreach ($personalized_form_data as $k => $data) {
                        if (isset($fields[$data['name']]) && $data['name'] != 'NumPresupuesto') {
                            $key = $fields[$data['name']];
                            $form_data[$key] = $data['value'];
                        }
                    }
                }
                if (!empty($check_id_exist)) {
                    $result = $this->PresupuestosTabAdModel->updateFormData($form_data, $id);
                    if ($result) {
                        $res_data['status'] = true;
                    }
                } else {
                    $form_data['NumPresupuesto'] = $id;
                    $result = $this->PresupuestosTabAdModel->insertFormData($form_data);
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

    public function update_comerciales_personalized($client_id = null) {
        $response['success'] = false;
        $response['errors'] = true;

        if($this->input->post()){
            //datos_comerciales_form
            if(!empty($client_id)){
                $update_datos_comerciales_form = $this->input->post('update_datos_comerciales_form', true);
                $post_data = (array)json_decode($update_datos_comerciales_form);
                $post_data['custom_fields'] = $this->input->post('custom_fields', true);
                $update_data = $this->newMakeInsertData($post_data);

                $result = $this->magaModel->update('presupuestot', $update_data, array('NumPresupuesto' => $client_id));

                $prospect_data = $this->PresupuestotModel->getProspectById($client_id);
                if(!empty($prospect_data) && $prospect_data->perfil == '1') {
                    $result_update_contact = $this->LeadsModel->updateContactosFromProspects($prospect_data->IdAlumno);
                }
                $this->load->model('SftConfigEgoiModel');
                $result_e_goi = $this->SftConfigEgoiModel->getEgoiData();
                if(!empty($result_e_goi)) {
                    $EgoiList = $this->getEgoiList($result_e_goi->apikey);
                    $params = array(
                        'apikey'     => $result_e_goi->apikey,
                        'listID'     =>  $EgoiList[0]['listnum'],
                        'subscriber' => $update_data['email'],
                        'status'     => 1,
                        'validate_phone' => 0,
                        'lang' => 'es',
                        'email'    	 => $update_data['email'],
                        'cellphone'  => $update_data['Movil'],
                        'telephone'  => $update_data['Telefono'],
                        'fax'   	 => $update_data['Fax'],
                        'first_name' => $update_data['sNombre'],
                        'last_name'  => $update_data['sApellidos'],
                        //'tax_id'     => '',
                        //'address'    => $update_data['domicilio'],
                        //'zip_code'   => '',
                        //'city'    	 => $update_data['Poblacion'],
                        'district'   => '',
                        //'state'      => $update_data['Provincia'],
                        //'country'    => $update_data['pais'],
                        //'age'    	 => '30',
                        //'gender'   	 => isset($update_data['idsexo']) && $update_data['idsexo'] == '1' ? 'M' : 'F',
                        //'id_card'    => '',
                        'company'    => $update_data['facturara'],
                        'birth_date' => date('d-m-Y',strtotime($update_data['Nacimiento'])));
                    //vardump($params);exit;
                    $this->load->model('ZapEgoiMappingModel');
                    $mappedFields = $this->ZapEgoiMappingModel->getMappedFiledsByTable('1');
                    if(!empty($mappedFields)) {
                        $select_str = '';
                        foreach ($mappedFields as $field) {
                            $select_str .= $field->table_name . '.' . $field->field_name . ',';
                        }
                        $select_str = trim($select_str, ',');
                        if (!empty($select_str)) {
                            $updated_data = $this->PresupuestotModel->getExtraFields($select_str, array('NumPresupuesto' => $client_id));
                            if (!empty($updated_data)) {
                                foreach ($mappedFields as $fields_) {
                                    $params['extra_' . $fields_->egoi_list] = $updated_data[$fields_->field_name];
                                }
                            }
                        }
                    }
                    $result_egoi = $this->editSubscriber($params);
                }

                if($result){
                    $response['success'][] = $this->lang->line('leads_personal_data_updated');
                    $response['errors'] = false;
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }else{

            }
            //datos_comerciales_form end

            //personalized_fields_form
            $personalized_data = $this->input->post('personalized_data', true);
            $personalized_data = !empty($personalized_data) ? (array)json_decode($personalized_data) : null;
            $id = isset($personalized_data['id']) ? $personalized_data['id'] : null;

            if($id && !empty($personalized_data)) {
                $form_data = array();
                $fields = array();
                $check_id_exist = $this->PresupuestosTabAdModel->getByPresupuestoId($id);
                $fields_list = $this->PresupuestosTabAdModel->getFieldList();
                foreach ($fields_list as $field) {
                    $fields[$field->name] = $field->name;
                    if($field->name != 'NumPresupuesto' && isset($personalized_data[$field->name])){
                        $form_data[$field->name] = $personalized_data[$field->name];
                    }
                }
                if (!empty($check_id_exist)) {
                    $result = $this->PresupuestosTabAdModel->updateFormData($form_data, $id);
                    if ($result) {
                        $response['success'][] = $this->lang->line('data_success_saved');
                    }else{
                        $response['errors'][] = $this->lang->line('data_not_saved');
                    }
                } else {
                    $form_data['NumPresupuesto'] = $id;
                    $result = $this->PresupuestosTabAdModel->insertFormData($form_data);
                    if ($result) {
                        $response['success'][] = $this->lang->line('data_success_saved');
                    }else{
                        $response['errors'][] = $this->lang->line('data_not_saved');
                    }
                }
            }
            //personalized_fields_form end

        }else{
            $response['errors'] = $this->lang->line('db_err_msg');
        }


        print_r(json_encode($response));
        exit;
    }

    private function getEgoiList($apikey){
        if($apikey) {
            $params = array(
                'apikey' => $apikey
            );

// using Soap with SoapClient
            $client = new SoapClient('http://api.e-goi.com/v2/soap.php?wsdl');
            $result = $client->getLists($params);
            return $result;
        }
    }

    private function addSubscriber($params){
        // using Soap with SoapClient
        $client = new SoapClient('http://api.e-goi.com/v2/soap.php?wsdl');
        $result = $client->addSubscriber($params);
        return $result;
    }

    private function editSubscriber($params){
        // using Soap with SoapClient
        $client = new SoapClient('http://api.e-goi.com/v2/soap.php?wsdl');
        $result = $client->editSubscriber($params);
        return $result;
    }

    public function saveFollowUp($client_id = null){
        if($this->input->is_ajax_request()){
            $post_data = $this->input->post(Null, true);
            $result = false;
            $last_id = false;
            $userData = $this->session->userdata('userData');
           // $lang = $this->session->userdata('lang');
            $usuar_id = isset($userData[0]->Id) ? $userData[0]->Id : null;
            if($client_id && $usuar_id) {

                $dataArray = array(
                    'fecha' => $post_data['fecha'],
                    'titulo' => $post_data['titulo'],
                    'comentarios' => $post_data['comentarios'],
                    'id_user' => $usuar_id,
                    'numpresupuesto' => $client_id
                );
                $last_id = $this->PresupuestoSeguiModel->insertFollowUp($dataArray);
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

    public function deleteFollowUp($id){
        $result = $this->PresupuestoSeguiModel->deleteFollowUp($id);
        print_r($result);
        exit;
    }
}
