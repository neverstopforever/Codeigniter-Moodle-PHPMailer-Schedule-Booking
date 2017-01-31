<?php

/**
 * Created by IntelliJ IDEA.
 * User: qasim
 * Date: 11/19/15
 * Time: 7:57 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *@property magaModel $magaModel
 *@property ContactosModel $ContactosModel
 *@property ClientModel $ClientModel
 *@property AlumnoModel $AlumnoModel
 *@property ErpConsultaModel $ErpConsultaModel
 *@property AreasAcademicaModel $AreasAcademicaModel
 *@property ClientesDocModel $ClientesDocModel
 *@property ClientesSeguiModel $ClientesSeguiModel
 *@property ReciboModel $ReciboModel
 *@property MatriculatModel $MatriculatModel
 *@property LstPlantillaModel $LstPlantillaModel
 *@property LstPlantillasCatModel $LstPlantillasCatModel
 */
class Clientes extends MY_Controller {

    public function __construct() {
        parent::__construct();
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
        $this->config->set_item('language', $this->data['lang']);
    }

    public function index_get() {
        if ($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') != '') {
            $lang = $this->session->userdata('lang');
            $details = $this->magaModel->selectAll('clientes');
            $ckeyslang = $this->my_language->load('column_key');
            $data['page'] = 'clientes';
            $data['dataKeys'] = $ckeyslang;
            $field = $lang == 'english' ? 'sql_en' : 'sql_es';
            $query = "SELECT " . $field . " FROM erp_consultas WHERE ref = 'lst_empresas'";
            $sql = $this->magaModel->selectCustom($query);
            // print_r($sql);die;
            $data['content'] = $this->magaModel->selectCustom($lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);
            $this->load->view('ClientesView', $data);
        } else {
            redirect('/auth/login/', 'refresh');
        }
    }

    public function add_get($id = 0) {
        if ($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') != '') {
            if ($id == 0) {
                $newID = $this->magaModel->maxID('clientes', 'CCODCLI');
                $newID = $newID[0]->CCODCLI + 1;
                redirect(site_url('clientes/add/' . $newID));
            }
            $lang = $this->session->userdata('lang');
            $ckeyslang = $this->my_language->load('clientes_form');
            $this->lang->load('clientes_form', $lang);
            $data['page'] = 'Data Records';
            $data['clienteId'] = $id;
            $data['page'] = 'Data Records';
            $data['formaspago'] = $this->magaModel->selectAll('formaspago');
            $data['dataKeys'] = $ckeyslang;
            $this->load->view('clienteAddView', $data);
        } else {
            redirect('/auth/login/', 'refresh');
        }
    }

    public function edit_get($id) {
        if ($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') != '') {

            $lang = $this->session->userdata('lang');
            $this->lang->load('clientes_form', $lang);
            $data['page'] = 'Data Records';

            $data['content'] = $this->ClientModel->getContent($id);
            $data['empleados'] = $this->ClientModel->getEmpleados($id);

            $data['documentos'] = $this->documentos_get($id);
            $data['Seguimiento'] = $this->Seguimiento_get($id);
            $data['clienteId'] = $id;
            $data['historicAccount'] = $this->historicAccount_get($id);
            $data['HistoricFees'] = $this->HistoricFees_get($id);
            $data['Filiales'] = $this->Filiales_get($id);
            $data['clientes_tab_ad'] = $this->clientes_tab_ad_get($id);
            $data['Adicionales'] = $this->Adicionales_get($id);
            $data['document_cat'] = $this->get_documentos("10");
//            $data['plantillas_cat'] = $this->plantillas_cat_get_byId("10");
            $data['plantillas_cat'] = "";
            $data['formaspago'] = $this->magaModel->selectAll('formaspago');
            // echo'<pre>';print_r($data['formaspago']);die;
            $data['clientes'] = $this->magaModel->selectAll('clientes');
            $data['alumnos'] = $this->AlumnoModel->getAlumnos();
            $ckeyslang = $this->my_language->load('column_key');
            $data['dataKeys'] = $ckeyslang;
            $data['clientId'] = $id;
            $this->load->view('clienteEditView', $data);
        } else {
            redirect('/auth/login/', 'refresh');
        }
    }

    public function clientes_get() {
        $lang = $this->session->userdata('lang');
        $data['page'] = 'Data Records';
        // $ckeyslang = $this->my_language->load('contactos_form');
        //$data['dataKeys'] =$ckeyslang;
        $field = $lang == 'english' ? 'sql_en' : 'sql_es';
        $sql = $this->ErpConsultaModel->getField($field);
        $data['content'] = $this->magaModel->selectCustom($lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);
        echo json_encode($data);
    }

    public function cliente_delete($id) {
        $data['status'] = $this->magaModel->deleteClientes($id);
        $this->curl->simple_get(base_url() . 'awsrest/bucketDelete/customer-' . $id);
        echo json_encode($data);
    }

    public function index_post($id) {
        $data['status'] = $this->ContactosModel->update($id, $this->input->post());
        echo json_encode($data);
    }

    public function create_post() {
        $data['status'] = $this->ContactosModel->insert($this->input->post());
        echo json_encode($data);
    }

    public function clientes_tab_ad_get($id) {
        return $this->AreasAcademicaModel->getClientesTabAd();
    }

    public function Adicionales_get($id) {

        return $this->AreasAcademicaModel->getAdicionales($id);
    }

    public function Adicionales_add_post($id) {
        $areaacademica = $this->post('areaacademica');
        $fecha = $this->post('fecha');
        $comments = $this->post('comments');
        $details = $this->AreasAcademicaModel->adicionalesAdd($id, $areaacademica, $comments, $fecha);
        print_r($details);
    }

    public function Adicionales_update_post($id) {
        $areaacademica = $this->post('areaacademica');
        $fecha = $this->post('fecha');
        $comments = $this->post('comments');

        $details = $this->AreasAcademicaModel->adicionalesUpdate($id, $areaacademica, $comments, $fecha);
        print_r($details);
    }

    public function index_delete($id) {
        $data['status'] = $this->ContactosModel->delete($id);
        echo json_encode($data);
    }

    public function filter_get() {
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

    public function group_get() {
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
    public function alumnos_get() {
        $details = $this->AlumnoModel->getAll();
        return $details;
    }

    public function documentos_get($id) {
        return $this->ClientesDocModel->getDocumentos($id);
    }

    public function Seguimiento_get($id) {
        $userData = $this->session->userdata('userData');
        $usuario = $userData[0]->USUARIO;
        return $this->ClientesSeguiModel->getSeguimiento($id, $usuario);
    }

    public function Seguimiento_post($id) {
        $fecha = $this->post('fecha');
        $titulo = $this->post('titulo');
        $comentarios = $this->post('comentarios');
        $userData = $this->session->userdata('userData');
        $usuario = $userData[0]->USUARIO;

        $dataArray = array(
            'fecha' => $fecha,
            'titulo' => $titulo,
            'comentarios' => $comentarios,
            'usuario' => $usuario,
            'ccodcli' => $id
        );
        $details = $this->magaModel->insert('clientes_segui', $dataArray);
        print_r($details);
    }

    public function Seguimiento_edit_post($id) {
        $fecha = $this->post('fecha');
        $titulo = $this->post('titulo');
        $comentarios = $this->post('comentarios');
        $userData = $this->session->userdata('userData');
        $usuario = $userData[0]->USUARIO;

        $dataArray = array(
            'fecha' => $fecha,
            'titulo' => $titulo,
            'comentarios' => $comentarios
        );
        $details = $this->magaModel->update('clientes_segui', $dataArray, array('id' => $id));
        print_r($details);
    }

    public function seguimiento_delete($id) {
        $detail = $this->magaModel->delete('clientes_segui', array('id' => $id));
        print_r($detail);
    }

    public function historicAccount_get($id) {
        return $this->ReciboModel->getHistoricAccount($id);
    }

    public function HistoricFees_get($id) {
        return $this->MatriculatModel->getHistoricFees($id);
    }

    public function Filiales_get($id) {
        return $this->ClientModel->getFiliales($id);
    }

    public function Filiales_post($id) {
        $linkFrom = $this->post('linkFrom');
        $linkTo = $this->post('linkTo');
        $details = $this->magaModel->update('clientes', array('ccodcli_matriz' => $linkFrom), array('ccodcli' => $linkTo));
        echo $details;
    }

    public function empleados_post($id) {
        $linkFrom = $this->post('linkFrom');
        $details = $this->magaModel->update('alumnos', array('FacturarA' => $id), array('ccodcli' => $linkFrom));
        echo $details;
    }

    public function Filiales_delete($id) {
        $details = $this->magaModel->update('clientes', array('ccodcli_matriz' => ''), array('ccodcli' => $id));
        echo $details;
    }

    public function empleados_delete($id) {
        $details = $this->magaModel->update('alumnos', array('FacturarA' => '0'), array('Id' => $id));
        echo $details;
    }

    public function datos_comerciales_post($id) {
        $lang = $this->session->userdata('lang');
        $data = (array) $this->post();
        foreach ($data as $key => $list) {
            if ($key === 'FirstUpdate' || $key === 'LastUpdate') {
                if ($lang == "english") {
                    $data[$key] = DateTime::createFromFormat('m/d/Y', $list)->format('Y-m-d');
                } else {
                    $data[$key] = DateTime::createFromFormat('d/m/Y', $list)->format('Y-m-d');
                }
            }
        }
        $details = $this->magaModel->update('clientes', $data, array('CCODCLI' => $id));
        print_r($details);
    }

    public function datos_comerciales_add_post($id) {
        $details = $this->magaModel->insert('clientes', $this->post());
        print_r($details);
    }

    public function plantillas_add_update_post() {
        $id = $this->post('id');
        $data = ['id_cat' => $this->post('id_cat'), 'Nombre' => $this->post('Nombre'), 'webDocumento' => $this->post('webDocumento'), 'DocAsociado' => $this->post('DocAsociado')];
        if ($this->post('template_option') == 1) {
            $details = $this->magaModel->insert('lst_plantillas', $data);
        } else {
            $details = $this->magaModel->update('lst_plantillas', $data, array('id' => $id));
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

    public function documentodata_post($id) {
        $clienteId = $this->post('clienteId');
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
        echo $webDocumento;
    }

    public function plantillas_cat_get() {
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

}
