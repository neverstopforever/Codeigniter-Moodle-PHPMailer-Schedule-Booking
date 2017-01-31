<?php

/**
 * Created by IntelliJ IDEA.
 * User: qasim
 * Date: 11/19/15
 * Time: 7:57 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property magaModel $magaModel
 * @property ContactosModel $ContactosModel
 * @property ErpConsultaModel $ErpConsultaModel
 */
class Contactosrest extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('column_key', $this->data['lang']);
        $this->load->model('ContactosModel');
        $this->load->model('ErpConsultaModel');
        $this->load->library('form_validation');
    }

    public function index($id = null)
    {
        if ($this->input->post()) {
            $this->index_post($id);
        }
        $data['page']='Data Records';
//        $data['content']= $this->ContactosModel->getList();
//        $field = $this->data['lang'] == 'english' ? 'sql_en' : 'sql_es';
        $field = 'sql_en';
        $sql = $this->ErpConsultaModel->getField($field, 'lst_contactos');
//        $data['content'] = $this->magaModel->selectCustom(
//            $this->data['lang'] == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es
//        );
        $data['content'] = $this->magaModel->selectCustom(
            $sql[0]->sql_en
        );
        echo json_encode($data);
        exit;
    }
    public function Contactos(){
        echo json_encode($this->ContactosModel->get_contactos());

    }
    public function index_post($id)
    {
        $data['status'] = boolval($this->ContactosModel->update($id, $this->input->post()));
        echo json_encode($data);
        exit;
    }

    public function create()
    {
        $data['status'] = '';
        if ($this->input->post()) {
            $data['status'] = boolval($this->ContactosModel->insert($this->input->post()));
        }
        echo json_encode($data);
        exit;
    }
    public function add()
    {
        $details = array();
        if ($this->input->post()) {
            $newID = $this->magaModel->maxID('contactos', 'Id');
            $newID = $newID[0]->Id + 1;

            $post_data = $this->input->post(NULL, true);

            $insert_data = $this->makeInsertData($post_data);
            $insert_data['FirstUpdate'] = date('Y-m-d');
            $insert_data['LastUpdate'] = date('Y-m-d');
            $insert_data['Id'] = $newID;
            $details = $this->magaModel->insert('contactos',$insert_data);
        }
        print_r($details);
        exit;
    }

    public function update($id = 0)
    {
        $details = array('success' => false);
        if ($this->input->post()) {
            $this->load->model('ErpCustomFieldsModel');
            $post_data = $this->input->post(NULL, true);
            $validation = false;
            $fields = $this->ErpCustomFieldsModel->getFieldsList('contacts');
            $this->config->set_item('language', $this->data['lang']);
            $field_data = $this->input->post('custom_fields', true);
            foreach ($fields as $field) {
                if ($field['required'] && $field['field_type'] != 'checkbox') {
                    $validation = true;
                    $this->form_validation->set_rules('custom_fields[' . $field['id'] . ']', "<b>" . $field['field_name'] . "</b>", "trim|required");
                }
            }
            if (!$validation || $this->form_validation->run()) {
                if (!array_filter($field_data)) {
                    $post_data['custom_fields'] = '';
                } else {
                    $post_data['custom_fields'] = json_encode($field_data);
                }
                $update_data = $this->makeInsertData($post_data);
                $update_data['LastUpdate'] = date('Y-m-d');
                if ($id) {
                    $details['success'] = $this->magaModel->update('contactos', $update_data, array('Id' => $id));
                }
            }else{
                $error = $this->form_validation->error_array();
                print_r(json_encode(array('error' =>$error)));
                exit;
            }
        }
        print_r(json_encode($details));
        exit;
    }

    public function index_delete($id)
    {
        $data['status'] = $this->ContactosModel->delete($id);
        echo json_encode($data);
    }



    //alumnos
    public function alumnos()
    {
        $id = $this->input->post('id');
        $details=$this->magaModel->selectAllWhere('alumnos',array(''));
        print_r(json_encode($details));   
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
            'fnacimiento' => (isset($post_data['fnacimiento']) && strtotime($post_data['fnacimiento']) < strtotime(date("Y-m-d"))) ? $post_data['fnacimiento'] : null,
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

    public function unassignCompany(){
        if($this->input->is_ajax_request()){
            $cliente_id = (int)$this->input->post('cliente_id', true);
            $result = false;
            if($cliente_id) {
                if($this->magaModel->update('contactos', array('facturara' => ''), array('Id' => $cliente_id))){
                    $result = true;
                };

            }

            echo json_encode(array('success' => $result));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function deleteContactos(){
        if($this->input->is_ajax_request()){
            $result = false;
            $contac_id = $this->input->post('contact_id', true);
            if($contac_id){
                if($this->ContactosModel->delete($contac_id)){
                    $result = true;
                }
            }
           echo json_encode(array('success' => $result));
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }


}