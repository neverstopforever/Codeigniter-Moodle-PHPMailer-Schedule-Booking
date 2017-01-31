<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daily_cash extends MY_Controller {

    public function __construct() {
        parent::__construct();

        if (empty($this->_identity['loggedIn'])) {
            redirect('/auth/login/', 'refresh');
        }
        $this->load->model('CajasModel');
        $this->lang->load('daily_cash', $this->data['lang']);
        $this->load->library('form_validation');
        $userData = $this->session->userdata('userData');
        $this->data['user_id'] = $userData[0]->Id;
    }


    public function index() {
        $this->lang->load('quicktips', $this->data['lang']);
        $this->data['page'] = "manage_invoices_index";

        $this->layouts->add_includes('js', 'app/js/daily_cash/index.js');
        $this->layouts->view('daily_cash/indexView', $this->data);
    }

    public function getDailyCashData(){
        $start = $this->input->post('start',  true);
        $length = $this->input->post('length', true);
        $draw = $this->input->post('draw', true);
        $search = $this->input->post('search', true);
        $order = $this->input->post('order', true);
        $columns = $this->input->post('columns', true);

        $column = $order[0]['column'];
        $total_daily_cash = $this->CajasModel->getTotalCount();
        $daily_cash_data = $this->CajasModel->getDailyCashListAjax($start, $length, $draw, $search, $order, $columns);
        $recordsTotal = (int)$daily_cash_data->rows;
        $response = array(
            "start"=>$start,
            "length"=>$length,
            "search"=>$search,
            "order"=>$order,
            "column"=>$column,
            "draw"=>$draw,
            "recordsFiltered"=>$recordsTotal,
            "recordsTotal"=>$recordsTotal,
            "data"=>$daily_cash_data->items,
            "table_total_rows"=> $total_daily_cash
        );
        echo json_encode($response); exit;
    }

    public function getLastEndBalance(){
        $result = false;
        if($this->input->is_ajax_request()){
            $result = $this->CajasModel->getLastEndBalance();
            $result = isset($result->last_end_balance) ? (string)round($result->last_end_balance, 3) : '0';
        }
        echo json_encode(array('result' => $result)); exit;
    }

    public function addNewCash(){
        $result = false;
        $errors = '';
        $insert_data = array();
        if($this->input->is_ajax_request() && $this->input->post()){
            $title = $this->input->post('title', true);
            $cash_date = date('Y-m-d');
            $this->config->set_item('language', $this->data['lang']);
            $started_balance = $this->input->post('started_balance', true);
            $this->form_validation->set_rules('title', $this->lang->line('title'), 'trim|required|max_length[254]');
            if(preg_match('/^\d{0,6}(\,\d{0,6})?$/', $started_balance)) {
                $this->form_validation->set_rules('started_balance', $this->lang->line('cash_started_balance'), 'trim|required|max_length[15]');
            }else{
                $errors = $this->lang->line('cash_started_balance_not_valid');
            }

            $is_cash = $this->CajasModel->getDailyCashByDate($cash_date);
            if($is_cash){
                $errors['close_the_cash'] = true;
            }
            
            if ($this->form_validation->run() && empty($errors)){
                $insert_data = array(
                        'Nombre' => $title,
                        'SaldoInicial' => str_replace(',', '.', $started_balance),
                        'SaldoFinal' => 0,
                        'Fecha' => $cash_date,
                        'Hora' => date('H:i'),
                        'idcentro' => '0',
                        'idestado' => '0',
                        'id_user' => $this->data['user_id'],
                    );
                $result = $this->CajasModel->insertItem($insert_data);
                if($result){
                    $insert_data['cash_id'] = $result;
                }
            }elseif(empty($errors)){
                $errors =  validation_errors();
            }
        }
        echo json_encode(array('success' => $result, 'errors' => $errors, 'insert_data' => $insert_data)); exit;
    }

    public function editCash(){
        $result = false;
        $errors = '';
        if($this->input->is_ajax_request() && $this->input->post()){
            $state_hidden = $this->input->post('cash_state_hidden', true) == '1' ? 1 : 0;
            if($state_hidden == 1) {
                $state = $this->input->post('state', true) == '1' ? 1 : 0;
            }else{
                $state = 0;
            }
            $title = $this->input->post('title', true);
            $cash_id = $this->input->post('cash_id_hidden', true);
            $start_date = $this->input->post('start_date', true);
            $start_date =date('Y-m-d H:i:s',strtotime($start_date));
            $this->config->set_item('language', $this->data['lang']);
            $started_balance = $this->input->post('started_balance', true);
            $this->form_validation->set_rules('title', $this->lang->line('title'), 'trim|required|max_length[254]');
            $this->form_validation->set_rules('cash_id_hidden', 'ID', 'trim|required');
            if (preg_match('/^\d{0,6}(\,\d{0,6})?$/', $started_balance)) {
                $this->form_validation->set_rules('started_balance', $this->lang->line('cash_started_balance'), 'trim|required|max_length[15]');
            } else {
                $errors = $this->lang->line('cash_started_balance_not_valid');
            }
            if($state == '0') {
                $is_cash = $this->CajasModel->getDailyCashByDate($start_date);
                if ($is_cash && $is_cash !=$cash_id) {
                    $errors['close_the_cash'] = true;
                }
            }

            if ($this->form_validation->run() && empty($errors)) {
                $update_data = array(
                    'Nombre' => $title,
                    'SaldoInicial' => str_replace(',', '.', $started_balance),
                    'idestado' => $state
                );
                $result = $this->CajasModel->updateItem($update_data, $cash_id);
            } elseif (empty($errors)) {
                $errors = validation_errors();
            }
            
        }
        echo json_encode(array('success' => $result, 'errors' => $errors)); exit;
    }

    public function deleteCash(){
        $result = false;
        if($this->input->is_ajax_request() && $this->input->post()){
            $cash_id = $this->input->post('delete_data_id', true);
            $cash_state = $this->input->post('cash_state', true) == '1' ? 1 : 0;
            if($cash_state == 0) {
                $result = $this->CajasModel->deleteItem($cash_id);
            }
        }
        echo json_encode(array('success' =>$result)); exit;


    }
    public function openCash(){
        $response = array();
        if($this->input->is_ajax_request() && $this->input->post()) {
            $this->load->model('ReciboModel');
            $this->data['cash_name'] = $this->input->post('cash_name', true);
            $this->data['cash_id'] = $this->input->post('cash_id', true);
            $this->data['started_balance'] = $this->input->post('opening_balance', true);
            $this->data['state'] = $this->input->post('cash_state', true) == '1' ? 1 : 0;
            if( $this->data['state'] == 1){
                $this->data['end_balance'] = $this->CajasModel->getLastEndBalancebyId($this->data['cash_id']);
            }
            $this->data['related_qoutes_data'] = $this->ReciboModel->getQuotesByCashId($this->data['cash_id']);
            $this->data['current_balance'] =$this->CajasModel->getCurrentBalance($this->data['cash_id']);
//            echo json_encode($this->data['current_balance'] ); exit;

            $response['_html'] = $this->load->view('daily_cash/partials/openCash', $this->data, true);
        }
        echo json_encode($response); exit;

    }
    public function deleteOpenCash(){
        $result = false;
        if($this->input->is_ajax_request() && $this->input->post()){
            $state =  $this->input->post('state', true) == '1' ? 1 : 0;
            if($state == 0) {
                $id = $this->input->post('delete_data_id', true);
                $type = $this->input->post('type', true);
                if ($type == 2) {
                    $result = $this->CajasModel->deleteIngresos($id);
                } elseif ($type == 3) {
                    $result = $this->CajasModel->deleteGastos($id);
                }
            }
        }
        echo json_encode(array('success' =>$result)); exit;

    }
    public function addIncomeExpense(){
        $result = false;
        $errors = '';
        $insert_data = array();
        $result_data = array();
        if($this->input->is_ajax_request() && $this->input->post()){
            $state =  $this->input->post('state', true) == '1' ? 1 : 0;
            if($state == 0) {
                $description = $this->input->post('description', true);
                $amount = $this->input->post('amount', true);
                $cash_id = $this->input->post('cash_id', true);
                $type = $this->input->post('quote_type', true);
                $this->config->set_item('language', $this->data['lang']);
                $this->form_validation->set_rules('description', $this->lang->line('description'), 'trim|required|max_length[100]');
                if (preg_match('/^\d{0,6}(\,\d{0,6})?$/', $amount)) {
                    $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required|max_length[15]');
                } else {
                    $errors = $this->lang->line('amount_not_valid');
                }
                if ($this->form_validation->run() && empty($errors)) {
                    $insert_data = array(
                        'IdCaja' => $cash_id,
                        'Descripcion' => $description,
                        'Importe' => str_replace(',', '.', $amount),
                        'IdUsuario' => $this->data['user_id'],
                        'timeorder' => date('Y-m-d')
                    );
                    if ($type == '2') {
                        $result = $this->CajasModel->insertIngresos($insert_data);
                    } elseif ($type == '3') {
                        $result = $this->CajasModel->insertGastos($insert_data);

                    }
                    if ($result) {
                        $current_balance = $this->CajasModel->getCurrentBalance($cash_id);
                        $result_data = array(
                            'amount' => str_replace(',', '.', $amount),
                            'customer' => '',
                            'description' => $description,
                            'id' => $result,
                            'payment_method' => 0,
                            'quote_type' => $type,
                            'current_balance' => $current_balance->amount
                        );
                    }
                } elseif (empty($errors)) {
                    $errors = validation_errors();
                }
            }
            
        }
        echo json_encode(array('success' => $result, 'errors' => $errors, 'result_data' => $result_data)); exit;
    }
    public function editIncomeExpense(){
        $result = false;
        $errors = '';
        $update_data = array();
        if($this->input->is_ajax_request() && $this->input->post()){
            $description = $this->input->post('description', true);
            $amount = $this->input->post('amount', true);
            $type = $this->input->post('quote_type', true);
            $id = $this->input->post('income_expense_id_hidden', true);
            $cash_id = $this->input->post('cash_id', true);
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules('description', $this->lang->line('description'), 'trim|required|max_length[100]');
            if(preg_match('/^\d{0,6}(\,\d{0,6})?$/', $amount)) {
                $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required|max_length[15]');
            }else{
                $errors = $this->lang->line('amount_not_valid');
            }
            if ($this->form_validation->run() && empty($errors)){
                $update_data = array(
                    'Descripcion' => $description,
                    'Importe' => str_replace(',', '.', $amount)
                );
                if($type == '2'){
                    $result = $this->CajasModel->updateIngresos($update_data, $id);
                }elseif($type == '3'){
                    $result = $this->CajasModel->updateGastos($update_data, $id);
                }
                $current_balance = $this->CajasModel->getCurrentBalance($cash_id);
                $update_data['current_balance'] = $current_balance->amount;
            }elseif(empty($errors)){
                $errors =  validation_errors();
            }
        }
        echo json_encode(array('success' => $result, 'errors' => $errors, 'result_data' => $update_data)); exit;
    }
    public function closeCash(){
        $result = false;
        if($this->input->is_ajax_request() && $this->input->post()){
            $closed_cash_id = $this->input->post('closed_cash_id', true);
            $result = $this->CajasModel->closeCurrentCash($closed_cash_id);
        }
        echo json_encode(array('success' => $result));
    }


}
