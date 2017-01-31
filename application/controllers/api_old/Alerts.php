<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property ClientesAvisosModel $ClientesAvisosModel
 */
class Alerts extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if(empty($this->_identity['loggedIn'])){
            redirect('/auth/login/', 'refresh');
        }
        $this->load->model('ClientesAvisosModel');
        $this->load->library('form_validation');
    }

    public function index_get() {

        $this->load->view('alerts/indexView', $this->data);
    }

    public function alerts_get() {
        $data['content'] = $this->ClientesAvisosModel->getAlerts();
        echo json_encode($data);
    }

    public function add_get() {
        $this->data['company'] = $this->ClientesAvisosModel->getCompany();
        $this->load->view('alerts/addView', $this->data);
    }

    public function add_post() {
        $config = array(
            array(
                'field'   => 'startdate',
                'label'   => $this->lang->line('alerts_startdate'),
                'rules'   => 'required'
            ),
            array(
                'field'   => 'enddate',
                'label'   => $this->lang->line('alerts_enddate'),
                'rules'   => 'required'
            ),
            array(
                'field'   => 'message',
                'label'   => $this->lang->line('alerts_message'),
                'rules'   => 'required'
            )
        );

        $this->form_validation->set_rules($config);


        if ($this->form_validation->run()){
            $data = array(
                'idcliente' => $this->input->post('idcliente',TRUE),
                'read' =>  $this->input->post('read',TRUE),
                'startdate' => $this->input->post('startdate',TRUE),
                'enddate' => $this->input->post('enddate',TRUE),
                'message' => $this->input->post('message',TRUE)
            );

            if($this->ClientesAvisosModel->addData($data)){
                redirect('/alerts', 'refresh');
            }

        }

        $this->data['company'] = $this->ClientesAvisosModel->getCompany();
        $this->load->view('alerts/addView', $this->data);
    }

    public function edit_get($id=NULL) {
        if($id!=NULL){
            $this->data['data'] = $this->ClientesAvisosModel->getDataById($id);
            $this->data['company'] = $this->ClientesAvisosModel->getCompany();
            var_dump($this->data['data']);
            $this->load->view('alerts/editView', $this->data);
        }else{
            redirect('/alerts', 'refresh');
        }

    }

}
