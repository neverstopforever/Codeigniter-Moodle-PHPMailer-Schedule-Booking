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
        $this->layout = 'alerts';
        $this->layouts->add_includes('js', 'app/js/alerts/main.js');
    }

    public function index() {
        $this->layouts->view('alerts/indexView', $this->data, $this->layout);
    }

    public function alerts() {
        $data['content'] = $this->ClientesAvisosModel->getAlerts();
        echo json_encode($data);
    }

    public function alertMessage() {

        $data['alertMessage'] = array();
        $_cisess = $this->session->userdata('_cisess');
        if(!$_cisess){
            $_cisess_hash = $this->input->cookie('_cisess', TRUE);            
            if($_cisess_hash){
                $key = base64_decode($_cisess_hash);
                $this->load->model('ClientesAkaudModel');
                $res = $this->ClientesAkaudModel->getByKey($key);
                $_cisess = isset($res[0]) ? (array)$res[0] : null;
                $this->session->set_userdata('_cisess', $_cisess);
            }
        }

        if(isset($_cisess['idcliente'])){
            $id_cliente = $_cisess['idcliente'];
            $data['alertMessage'] = $this->ClientesAvisosModel->getAlertMessage($id_cliente);
        }
        echo json_encode($data);
        exit;

    }

    public function readAlertMessage() {

        $data = array(
            'read' => 1
        );
        $where = array(
            'id' => $this->input->post('alert_mes_id',TRUE)
        );
        $response['success'] = $this->ClientesAvisosModel->updateAlert($data, $where);
        echo json_encode($response);
        exit;
    }

    public function readGlobalAlertMessage() {
        $response['success'] = true;
        $alert_mes_id = $this->input->post('alert_mes_id',true);
        $read_alert_mes_ids = $this->session->userdata('read_alert_mes_ids');
        $read_alert_mes_ids[] = $alert_mes_id;
        $read_alert_mes_ids = array_unique($read_alert_mes_ids);
        $this->session->set_userdata('read_alert_mes_ids', $read_alert_mes_ids);

        echo json_encode($response);
        exit;
    }

    public function check_start_end_dates($start_date){
        $end_date = $this->input->post('enddate', TRUE);
        $end_date_time = strtotime($end_date);
        $start_date_time = strtotime($start_date);

        if ($start_date_time > $end_date_time){
            $this->form_validation->set_message('check_start_end_dates', $this->lang->line('alerts_start_end_dates'));
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function check_dates($date){
        $date_time = strtotime($date);
        if (!$date_time){
            $this->form_validation->set_message('check_dates', '%s ' . $this->lang->line('alerts_invalid_date_format'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function add() {
        if($this->input->post(NULL)) {
            $config = array(
                array(
                    'field' => 'startdate',
                    'label' => $this->lang->line('alerts_startdate'),
                    'rules' => 'required|callback_check_dates|callback_check_start_end_dates'
                ),
                array(
                    'field' => 'enddate',
                    'label' => $this->lang->line('alerts_enddate'),
                    'rules' => 'required|callback_check_dates'
                ),
                array(
                    'field' => 'message',
                    'label' => $this->lang->line('alerts_message'),
                    'rules' => 'required'
                ),
                array(
                    'field' => 'toast',
                    'label' => $this->lang->line('alerts_toast'),
                    'rules' => 'required'
                ),
                array(
                    'field' => 'title',
                    'label' => $this->lang->line('alerts_title'),
                    'rules' => 'required'
                )
            );

            $this->form_validation->set_rules($config);
            $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');


            if ($this->form_validation->run()) {
                $data = array(
                    'idcliente' => $this->input->post('idcliente', TRUE),
                    'read' => $this->input->post('read', TRUE),
                    'startdate' => $this->input->post('startdate', TRUE),
                    'enddate' => $this->input->post('enddate', TRUE),
                    'message' => $this->input->post('message', TRUE),
                    'title' => $this->input->post('title', TRUE),
                    'toast' => $this->input->post('toast', TRUE)
                );

                if ($this->ClientesAvisosModel->addAlert($data)) {
                    $this->session->set_flashdata('success', $this->lang->line('alerts_add_msg') );
                }else{
                    $this->session->set_flashdata('errors', array( $this->lang->line('db_err_msg') ) );
                }
                redirect('/alerts', 'refresh');
            }
        }
        $this->data['action'] = 'add';
        $this->data['data'] = new ClientesAvisosModel();
        $this->data['companies'] = $this->ClientesAvisosModel->getCompanies();
        $this->layouts->view('alerts/addView', $this->data, $this->layout);

    }

    public function edit($id = NULL) {
        $this->data['data'] = $this->ClientesAvisosModel->getDataById($id);
        $this->data['action'] = 'edit';
        if( !empty($this->data['data']) ){
            if($this->input->post(NULL)) {
                $config = array(
                    array(
                        'field' => 'startdate',
                        'label' => $this->lang->line('alerts_startdate'),
                        'rules' => 'required|callback_check_dates'
                    ),
                    array(
                        'field' => 'enddate',
                        'label' => $this->lang->line('alerts_enddate'),
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'message',
                        'label' => $this->lang->line('alerts_message'),
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'toast',
                        'label' => $this->lang->line('alerts_toast'),
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'title',
                        'label' => $this->lang->line('alerts_title'),
                        'rules' => 'required'
                    )
                );

                $this->form_validation->set_rules($config);
                $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');

                if ($this->form_validation->run()) {
                    $data = array(
                        'idcliente' => $this->input->post('idcliente', TRUE),
                        'read' => $this->input->post('read', TRUE),
                        'startdate' => $this->input->post('startdate', TRUE),
                        'enddate' => $this->input->post('enddate', TRUE),
                        'message' => $this->input->post('message', TRUE),
                        'title' => $this->input->post('title', TRUE),
                        'toast' => $this->input->post('toast', TRUE)
                    );
                    $where = array(
                        'id' => $id
                    );

                    if ($this->ClientesAvisosModel->updateAlert($data, $where)) {
                        $this->session->set_flashdata('success', $this->lang->line('alerts_update_msg'));
                    }else{
                        $this->session->set_flashdata('errors', array( $this->lang->line('db_err_msg')));
                    }
                    redirect('/alerts', 'refresh');

                }
            }


            $this->data['companies'] = $this->ClientesAvisosModel->getCompanies();
            $this->layouts->view('alerts/editView', $this->data, $this->layout);
        }else{
            redirect('/alerts', 'refresh');
        }
    }

    public function delete($id = NULL) {

        if($this->ClientesAvisosModel->deleteAlert($id)){
            $this->session->set_flashdata('success',  $this->lang->line('alerts_delete_msg'));
        }else{
            $this->session->set_flashdata('errors', array( $this->lang->line('db_err_msg')));

        }
        redirect('/alerts', 'refresh');
    }




}
