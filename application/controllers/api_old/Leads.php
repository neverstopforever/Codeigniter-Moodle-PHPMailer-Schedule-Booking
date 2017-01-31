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
 * @property PresupuestotModel $PresupuestotModel
 * @property CompanyModel $CompanyModel
 * @property AlumnoModel $AlumnoModel
 * @property LstPlantillaModel $LstPlantillaModel
 * @property AreasAcademicaModel $AreasAcademicaModel
 * @property ClientesDocModel $ClientesDocModel
 * @property ClientesSeguiModel $ClientesSeguiModel
 * @property ReciboModel $ReciboModel
 * @property MatriculatModel $MatriculatModel
 * @property ClientModel $ClientModel
 * @property LstPlantillasCatModel $LstPlantillasCatModel
 * @property PresupuestoRuleModel $PresupuestoRuleModel
 */
class Leads extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $lang = $this->session->userdata('lang');
        // $this->lang->load('contactos_form',$lang);
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
        $this->config->set_item('language', $this->data['lang']);
        if ($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') != '') {
            
        } else {
            redirect('/auth/login/', 'refresh');
        }
    }

    public function index_get() {
        $lang = $this->session->userdata('lang');
        $this->lang->load('clientes_form', $lang);
        $details = $this->magaModel->selectAll('clientes');
        $ckeyslang = $this->my_language->load('column_key');
        $data['page'] = 'leads';
        $countries = $this->db->get('estado_solicitud');
        $data['state'] = $countries->result();
        $data['dataKeys'] = $ckeyslang;
        $field = $lang == 'english' ? 'sql_en' : 'sql_es';
        $sql = $this->ErpConsultaModel->getField($field, 'lst_solicitudes');
        $data['state'] = $this->magaModel->selectCustom("SELECT hex(color) as color,valor,id from estado_solicitud");
//         print_r($sql);die;
        $data['content'] = $this->magaModel->selectCustom($lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);
        $this->load->view('leadsView', $data);
    }

    public function add_get($id = 0) {
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
    }

    public function edit_get($id) {
        $lang = $this->session->userdata('lang');
        $data['lang'] = $lang;
        $this->lang->load('clientes_form', $lang);
        $data['page'] = 'Data Records';
        $field = $lang == 'english' ? 'sql_en' : 'sql_es';
        $sql = $this->ErpConsultaModel->getField($field, 'lst_sol_sol');
        $lsquery = str_replace("@", $id, $lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);
        $data['lst_sol_sol'] = $this->magaModel->selectCustom($lsquery);
        $sql2 = $this->ErpConsultaModel->getField($field, 'sel_cursos');
        $data['sel_cursos'] = $this->magaModel->selectCustom($lang == 'english' ? $sql2[0]->sql_en : $sql2[0]->sql_es);
        $countries = $this->db->get('estado_solicitud');
        $data['countries'] = $countries->result();
        $data['content'] = $this->PresupuestotModel->getContent($id);
        $data['campaign'] = $this->CompanyModel->getCampaign();

        $data['personal_fields'] = $this->magaModel->get_where('presupuestos_tab_ad', array('NumPresupuesto' => $id));
        $data['documentos'] = $this->documentos_get($id);
        $data['Seguimiento'] = $this->Seguimiento_get($id);
        $data['clienteId'] = $id;
        $data['historicAccount'] = $this->historicAccount_get($id);
        $data['HistoricFees'] = $this->HistoricFees_get($id);
        $data['Filiales'] = $this->Filiales_get($id);
        $data['clientes_tab_ad'] = $this->clientes_tab_ad_get($id);
        $data['Adicionales'] = $this->Adicionales_get($id);
        $data['formaspago'] = $this->magaModel->selectAll('formaspago');
        $data['medios'] = $this->magaModel->selectAll('medios');
        $data['plantillas_cat'] = $this->plantillas_cat_get();
        $sql = $this->ErpConsultaModel->getField($field, 'lst_empresas');
        $data['clientes'] = $this->magaModel->selectCustom($lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);

        $data['alumnos'] = $this->AlumnoModel->getAlumnos();

        $ckeyslang = $this->my_language->load('column_key');
        $data['dataKeys'] = $ckeyslang;
        $data['leadId'] = $id;
        $data['document_cat'] = $this->get_documentos("7");
        $this->load->view('leadsEditView', $data);
    }
    
    public function get_documentos($id) {
        return $this->LstPlantillaModel->getDocumentos($id);
        //return json_encode($DocAsociado);
    }

    public function updateinfo_post() {
        $data['alumnos'] = $this->magaModel->updatedata($_POST);
        redirect(base_url('leads/edit/' . $_POST['id'] . '#personalized_fields'));
    }

    public function leads_get() {
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

    public function updateBookmark_post() {
        $data['status'] = $this->magaModel->update('presupuestot', array('bookmark' => $this->post('bookmark')), array('NumPresupuesto' => $this->post('id')));
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
        $id = $this->post('id');
        $details = $this->magaModel->selectAll('alumnos');
        return $details;
    }

    public function documentos_get($id) {
        return $this->ClientesDocModel->getDocumentos($id);
    }

    public function Seguimiento_get($id) {
        $userData = $this->session->userdata('userData');
        $usuario = $userData[0]->USUARIO;
        return $this->PresupuestotModel->getSeguimiento($id);
    }

    public function Seguimiento_post($id) {
        $userData=$this->session->userdata('userData');
    	$lang = $this->session->userdata('lang');
    	$data = (array) $this->post();
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

    public function Seguimiento_edit_post($id) {
        $lang = $this->session->userdata('lang');
        $userData=$this->session->userdata('userData');
        $data = (array) $this->post();
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
        print_r($details);
    }

    public function seguimiento_delete($id) {
        $detail = $this->magaModel->delete('presupuesto_segui',array('id'=>$id));
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
            if ($key === 'Nacimiento') {
                if ($lang == "english") {
                    $data[$key] = DateTime::createFromFormat('m/d/Y', $list)->format('Y-m-d');
                } else {
                    $data[$key] = DateTime::createFromFormat('d/m/Y', $list)->format('Y-m-d');
                }
            }
        }
        $details = $this->magaModel->update('presupuestot', $data, array('NumPresupuesto' => $id));
        print_r($details);
    }

	public function datos_fcturation_post($id){
    	$query = $this->db->query("UPDATE `presupuestot` SET `medio` = '".$this->post('medio')."', `Campaña` = '".$this->post('Campaña')."', `Descripcion` = '".$this->post('Descripcion')."' WHERE `NumPresupuesto` = '$id'");
        print_r($query);
    }

    public function course_add_post($id){
    	if(null!=$this->post('ids')){
    		$ids = $this->post('ids');
    		$cid = "";
    		foreach($ids as $list){
    			$cid .="'$list'".',';
    		}
    		$cid = rtrim($cid,',');
    		$result = $this->db->query("INSERT INTO presupuesto_solicitud (NumPresupuesto, CodigoCurso, Descripcion, Horas, Precio, dto, neto)
			SELECT $id,codigo,curso,horas,precio,0,precio FROM curso WHERE codigo IN ($cid)");
		print_r($result);
    	}
    }

    public function deletecourse_delete($id){
    	$data = $this->db->query("DELETE FROM presupuesto_solicitud WHERE id='$id'");
        print_r($data);
    }

    public function datos_comerciales_add_post($id) {
        $details = $this->magaModel->insert('clientes', $this->post());
        print_r($details);
    }

    public function bulk_operation_post() {
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

        return false;
    }

    public function detail_medios_link_post($id) {
        $linkFrom = $this->post('linkFrom');
        $details = $this->magaModel->update('presupuestot', array('medio' => $id), array('NumPresupuesto' => $linkFrom));
        echo $details;
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
        $clientres = $this->magaModel->get_details_leads($clienteId);
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

    public function rules_post() {

        $response = false;

        $sql_arr = $this->PresupuestoRuleModel->getCsql();
        foreach($sql_arr as $csql_obj){
            if(isset($csql_obj->csql) && !empty($csql_obj->csql)){
                $this->db->query($csql_obj->csql);
                $response = true;
            }
        }

        echo json_encode(array('response'=>$response));
        exit;
    }

}
