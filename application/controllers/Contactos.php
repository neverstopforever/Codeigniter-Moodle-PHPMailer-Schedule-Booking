<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contactos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ContactosModel');
        $this->load->model('ErpConsultaModel');
        $this->load->model('ClientModel');
        $this->load->model('Variables2Model');
        $this->lang->load('contactos_form', $this->data['lang']);
        $this->load->library('form_validation');
        $this->output->enable_profiler(false);
        $this->layouts->add_includes('js', 'app/js/contactos/main.js');
    }

    public function index()
    {
        $this->lang->load('quicktips', $this->data['lang']);
        $this->layouts->add_includes('js', 'app/js/contactos/index.js');
        if ($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') != '') {
            $this->data['page'] = 'contactos';
          
            $this->layouts->view('ContactosView', $this->data);
        } else {
            redirect('/auth/login/', 'refresh');
        }
    }

    public function getContactos(){
        $response = array('content' => array());
        if($this->input->is_ajax_request()) {
            $response = array('content' => $this->ContactosModel->getContactosCustom());
        }
        echo json_encode($response);
        exit;
    }

    public function add($id = 0)
    {
        $this->layouts
            ->add_includes('css', 'assets/global/plugins/typeahead/typeahead.css')
            ->add_includes('css', 'assets/global/plugins/typeahead/custom.css')
            ->add_includes('js', 'assets/global/plugins/typeahead/handlebars.min.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.min.js');
        $this->layouts->add_includes('js', 'app/js/contactos/add.js');

        if ($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') != '') {
            if ($id == 0) {
                $newID = $this->magaModel->maxID('contactos', 'Id');
                $newID = $newID[0]->Id + 1;
                redirect(site_url('contactos/add/'.$newID));
            }
            $this->data['formData']= $this->input->post(NULL, true);
            $cisess = $this->session->userdata('_cisess');
            $membership_type = $cisess['membership_type'];
            if($membership_type != 'FREE'){
                $this->data['customfields_fields'] = $this->get_customfields_data();
            }
            if(!empty($this->data['formData'])){
                $this->config->set_item('language', $this->data['lang']);
                $this->form_validation->set_rules('Snombre', $this->lang->line('Snombre'), 'trim|required');
                $this->form_validation->set_rules('Sapellidos', $this->lang->line('Sapellidos'), 'trim|required');
                if(!empty($this->data['customfields_fields'])) {
                    foreach ($this->data['customfields_fields'] as $field) {
                        if ($field['required'] && $field['field_type'] != 'checkbox') {
                            $this->form_validation->set_rules('custom_fields[' . $field['id'] . ']', "<b>" . $field['field_name'] . "</b>", "trim|required");
                        }
                    }
                }
                $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');

                if($this->form_validation->run()){
                    $newID = $this->magaModel->maxID('contactos', 'Id');
                    $newID = $newID[0]->Id + 1;

                    $post_data = $this->input->post(NULL, true);
                    $field_data = $this->input->post('custom_fields', true);
                    if(!array_filter($field_data)){
                        $post_data['custom_fields'] = '';
                    }else{
                        $post_data['custom_fields'] = json_encode($field_data);
                    }
                    $insert_data = $this->makeInsertData($post_data);
                    $insert_data['FirstUpdate'] = date("Y-m-d H:i:s");
                    $insert_data['LastUpdate'] = date("Y-m-d H:i:s");
                    $insert_data['Id'] = $newID;
                    if($this->magaModel->insert('contactos',$insert_data)){
                        redirect('contactos');
                    }
                }
            }
            $lang = $this->session->userdata('lang');
            $this->lang->load('contactos_form', $lang);
            $ckeyslang = $this->my_language->load('contactos_form');
            $this->data['dataKeys'] = $ckeyslang;
            $this->data['page'] = 'Data Records';
            $this->data['clienteId'] = $id;
            $field = $lang == 'english' ? 'sql_en' : 'sql_es';
            $sql = $this->ErpConsultaModel->getField($field, 'lst_empresas');
            $this->data['company_data'] = $this->ClientModel->getInvoicesCompany();
            $this->data['clientes'] = $this->magaModel->selectCustom($lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);
            $this->data['isOwner']=$this->data['userData'][0]->owner;
            $this->layouts->view('ContactosAddView', $this->data);
        } else {
            redirect('/auth/login/', 'refresh');
        }
    }
 public function get_customfields_data() {
       
        $type = 'contacts';
        $custom_fields = $this->ClientModel->getFieldsList($type);
        if(count($custom_fields) > 0){
                
            return $custom_fields;

        }else{
            return false;
        }
       
    }
    private function makeInsertData($post_data){
        return array(
            'custom_fields' => $post_data['custom_fields'],
            'Snombre' => isset($post_data['Snombre']) ? $post_data['Snombre'] : null,
            'Sapellidos' => isset($post_data['Sapellidos']) ? $post_data['Sapellidos'] : null,
            'Domicilio' => isset($post_data['Domicilio']) ? $post_data['Domicilio'] : null,
            'Poblacion' => isset($post_data['Poblacion']) ? $post_data['Poblacion'] : null,
            'Provincia' => isset($post_data['Provincia']) ? $post_data['Provincia'] : null,
            'Distrito' => isset($post_data['Distrito']) ? $post_data['Distrito'] : null,
            'Telefono1' => isset($post_data['Telefono1']) ? $post_data['Telefono1'] : null,
            'Telefono2' => isset($post_data['Telefono2']) ? $post_data['Telefono2'] : null,
            'Movil' => isset($post_data['Movil']) ? $post_data['Movil'] : null,
            'Pais' => isset($post_data['Pais']) ? $post_data['Pais'] : null,
            'email' => isset($post_data['email']) ? $post_data['email'] : null,
            'nif' => isset($post_data['nif']) ? $post_data['nif'] : null,
            'fnacimiento' => isset($post_data['fnacimiento']) ? $post_data['fnacimiento'] : null,
            'skype' => isset($post_data['skype']) ? $post_data['skype'] : null,
            'Idsexo' => isset($post_data['Idsexo']) ? $post_data['Idsexo'] : 1,
            'iban' => isset($post_data['iban']) ? $post_data['iban'] : null,
            'Cc1' => isset($post_data['Cc1']) ? $post_data['Cc1'] : null,
            'Cc2' => isset($post_data['Cc2']) ? $post_data['Cc2'] : null,
            'Cc3' => isset($post_data['Cc3']) ? $post_data['Cc3'] : null,
            'Cc4' => isset($post_data['Cc4']) ? $post_data['Cc4'] : null,
            'facturara' => isset($post_data['company_changed_id']) ? $post_data['company_changed_id'] : 0,
            'seguimiento' => isset($post_data['seguimiento']) ? $post_data['seguimiento'] : '',
        );

    }
    public function edit($id)
    {
        $this->load->model('ErpTagsModel');
        $this->load->model('PresupuestotModel');
        $this->layouts
            ->add_includes('css', 'assets/global/plugins/typeahead/typeahead.css')
            ->add_includes('css', 'assets/global/plugins/typeahead/custom.css')
            ->add_includes('css', 'assets/global/plugins/timeLine/css/animate.css')
            ->add_includes('css', 'assets/global/plugins/timeLine/css/timelify.css')
            ->add_includes('js', 'assets/global/plugins/typeahead/handlebars.min.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.min.js')
            ->add_includes('js', 'assets/global/plugins/timeLine/js/jquery.timelify.js');
//        if($this->data['lang'] == 'spanish'){
//            $this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js');
//        }
        $this->layouts->add_includes('js', 'app/js/contactos/edit.js');
        if ($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') != '') {
            $check_id = $this->ContactosModel->selectContact($id);
            if(!empty($check_id)) {
                $ckeyslang = $this->my_language->load('contactos_form');
                $lang = $this->session->userdata('lang');
                $this->data['page'] = 'Data Records';
                $this->data['clienteId'] = $id;
                $this->data['dataKeys'] = $ckeyslang;
                $content = $check_id;
                $this->data['content'] = $content[0];
                $this->data['company_data'] = $this->ClientModel->getInvoicesCompany();
                $this->data['company_name'] = false;
                $this->data['format'] = 'Y-m-d';
                if($this->data['lang'] == 'spanish'){
                    $this->data['format'] = 'd-m-Y';
                }

                $this->data['tags'] =  $this->ErpTagsModel->getTags();
                $tags_group_by_tag_id = array();
                $tags_for_filter = array();
                if(!empty($this->data['tags'])) {
                    foreach ($this->data['tags'] as $tags){
                        $tags_group_by_tag_id[$tags->id] = $tags;
                        $tags_for_filter[] = array('id' => $tags->id, 'text' => $tags->tag_name,
                            'back_color' => $tags->hex_backcolor, 'text_color' => $tags->hex_forecolor);
                    }
                }
                $this->data['tags_group_by_tag_id'] = $tags_group_by_tag_id;

                //echo '<pre>'; var_dump($this->data['content']);exit;
                foreach ($this->data['company_data'] as $company) {
                    if ($company->Id == $this->data['content']->Facturara) {
                        $this->data['company_name'] = $company->name;
                    }
                }
                // echo '<pre>';print_r($data['content']);die;
                $field = $lang == 'english' ? 'sql_en' : 'sql_es';
                $sql = $this->ErpConsultaModel->getField($field, 'lst_empresas');
                // print_r($sql);die;
                $cisess = $this->session->userdata('_cisess');
                $membership_type = $cisess['membership_type'];
                if($membership_type != 'FREE'){
                    $this->data['content']->custom_fields = json_decode($this->data['content']->custom_fields);
                    $this->data['customfields_fields'] = $this->get_customfields_data();
                }
                $this->data['clientes'] = $this->magaModel->selectCustom(
                    $lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es
                );
                $this->data['prospects'] = $this->PresupuestotModel->getProspectsByContacts($id);
                $this->data['isOwner']=$this->data['userData'][0]->owner;
                $this->layouts->view('ContactosEditView', $this->data);
            }else{
                redirect('contactos/');
            }
        } else {
            redirect('/auth/login/', 'refresh');
        }
    }
    public function convertStudents(){
        if($this->input->is_ajax_request()){
            $result = false;
            $email = $this->input->post('email', true);
            if($email == ''){
                echo json_encode(array('result'=>$result, 'error'=>$this->lang->line('convert_empty_email')));
                exit;
            }
            $result = $this->ContactosModel->convertContactToStudent($email);
            if($result){
                $this->Variables2Model->updateNumStudent();
            }
            echo json_encode(array('result'=>$result));
            exit;
        } else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
}
