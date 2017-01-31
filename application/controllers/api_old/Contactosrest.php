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
        $lang = $this->session->userdata('lang');
        $this->lang->load('column_key', $this->data['lang']);
        $this->load->model('ContactosModel');
        $this->load->model('ErpConsultaModel');
    }

    public function index_get()
    {
        $lang=$this->session->userdata('lang');
        $data['page']='Data Records';
        $ckeyslang = $this->my_language->load('contactos_form');
        //$data['dataKeys'] =$ckeyslang;
        $field = $lang == 'english' ? 'sql_en' : 'sql_es';
        $sql = $this->ErpConsultaModel->getField($field, 'lst_contactos');
        $data['content']=$this->magaModel->selectCustom($lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);
        echo json_encode($data);
    }
    public function Contactos_get(){
        echo json_encode($this->ContactosModel->get_contactos());

    }
    public function index_post($id)
    {
        $data['status'] = boolval($this->ContactosModel->update($id, $this->input->post()));
        echo json_encode($data);
    }

    public function create_post()
    {
        $data['status'] = boolval($this->ContactosModel->insert($this->input->post()));
        echo json_encode($data);
    }
    public function add_post()
    {
        $details = $this->magaModel->insert('contactos',$this->post());
        print_r($details);
    }
    public function update_post($id=0)
    {
        $details = $this->magaModel->update('contactos',$this->post(),array('Id'=>$id));
        print_r($details);
    }

    public function index_delete($id)
    {
        $data['status'] = $this->ContactosModel->delete($id);
        echo json_encode($data);
    }



    //alumnos
    public function alumnos_get()
    {
        $id = $this->post('id');
        $details=$this->magaModel->selectAllWhere('alumnos',array(''));
        print_r(json_encode($details));   
    }

}