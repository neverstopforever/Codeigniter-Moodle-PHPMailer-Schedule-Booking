<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by IntelliJ IDEA.
 * User: qasim
 * Date: 11/18/15
 * Time: 10:31 PM
 * @property magaModel $magaModel
 * @property ContactosModel $ContactosModel
 * @property ErpConsultaModel $ErpConsultaModel
 */
class Contactos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ContactosModel');
        $this->load->model('ErpConsultaModel');
        $lang=$this->session->userdata('lang');
        $color=$this->session->userdata('color') == '' ? 'default' : $this->session->userdata('color');
        $layoutFormat=$this->session->userdata('layoutFormat') == '' ? 'fluid' :$this->session->userdata('layoutFormat');
        $this->lang->load('site',$lang);
        $this->lang->load('contactos_form',$lang);
        $this->output->enable_profiler(false);
    }

    public function index()
    {
         if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
        {
        $lang=$this->session->userdata('lang');
        $data['page']='contactos';
        $ckeyslang = $this->my_language->load('contactos_form');
        //$data['dataKeys'] =$ckeyslang;
        $field = $lang == 'english' ? 'sql_en' : 'sql_es';
        $sql = $this->ErpConsultaModel->getField($field, 'lst_contactos');
        $data['content']=$this->magaModel->selectCustom($lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);
        $this->load->view('ContactosView',$data);
         }
        else
        {
            redirect('/auth/login/', 'refresh');
        }
    }
    public function add($id=0){
          if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
        {
        if($id==0)
        {
            $newID = $this->magaModel->maxID('contactos','Id');
            $newID = $newID[0]->Id+1;
            redirect(site_url('contactos/add/'.$newID));
        }
        $lang=$this->session->userdata('lang');
        $this->lang->load('contactos_form',$lang);
        $ckeyslang = $this->my_language->load('contactos_form');
        $data['dataKeys'] =$ckeyslang;
        $data['page']='Data Records';
        $data['clienteId'] = $id;
        $field = $lang == 'english' ? 'sql_en' : 'sql_es';
        $sql = $this->ErpConsultaModel->getField($field, 'lst_empresas');
        // print_r($sql);die;
        $data['clientes']=$this->magaModel->selectCustom($lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);
        $this->load->view('ContactosAddView',$data);
        }
        else
        {
            redirect('/auth/login/', 'refresh');
        }
    }

    public function edit($id){
         if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
        {
        $ckeyslang = $this->my_language->load('contactos_form');
        $lang=$this->session->userdata('lang');
        $data['page']='Data Records';
        $data['clienteId'] = $id;
        $data['dataKeys'] =$ckeyslang;
        $content = $this->ContactosModel->selectContact($id);
        $data['content']=$content[0];
        // echo '<pre>';print_r($data['content']);die;
        $field = $lang == 'english' ? 'sql_en' : 'sql_es';
        $sql = $this->ErpConsultaModel->getField($field, 'lst_empresas');
        // print_r($sql);die;
        $data['clientes']=$this->magaModel->selectCustom($lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);
        $this->load->view('ContactosEditView',$data);
           }
        else
        {
            redirect('/auth/login/', 'refresh');
        }
    }
}
