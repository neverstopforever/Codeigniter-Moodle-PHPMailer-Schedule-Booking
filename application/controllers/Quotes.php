<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\Ses\SesClient;
class Quotes extends MY_Controller {

    public function __construct() {
        parent::__construct();

        if (empty($this->_identity['loggedIn'])) {
            redirect('/auth/login/', 'refresh');
        }
        $this->load->model('ReciboModel');
        $this->lang->load('quotes', $this->data['lang']);
        $this->load->library('form_validation');
        $this->layouts->add_includes('js', 'app/js/quotes/main.js');
    }


    public function index() {
        $this->lang->load('quicktips', $this->data['lang']);
        $this->layouts->add_includes('js', 'assets/global/plugins/select2/select2.js');
        if($this->data['lang'] == "spanish"){
            $this->layouts->add_includes('js', 'assets/global/plugins/select2/select2_locale_es.js');
        }
        $this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js');
        $this->layouts->add_includes('css', 'assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css');
        $this->layouts->add_includes('js', 'app/js/quotes/index.js');

        $this->data['receipts'] = $this->ReciboModel->getReceiptList();

        $doc_id_data_arr = array();
        $customer_name_data_arr = array();
        $state_data_arr = array();
        if($this->data['receipts']){
            $count_customer_name = 0;
            foreach ($this->data['receipts'] as $k=>$item){
                
                $doc_id_data_arr[$k]['id'] = $item->doc_id;
                $doc_id_data_arr[$k]['text'] = $item->doc_id;

                //customer_name_data
                if (!in_array(array('id'=>$item->client_id, 'text'=>$item->customer_name), $customer_name_data_arr)){
                    if(!empty($item->customer_name)){
                        $customer_name_data_arr[$count_customer_name]['id'] = $item->client_id;
                        $customer_name_data_arr[$count_customer_name]['text'] = $item->customer_name;
                        $count_customer_name++;
                    }
                }
            }
        }

        //State
        $state_data_arr[0]['id'] = "0";
        $state_data_arr[0]['text'] = $this->lang->line('quotes_due');
        $state_data_arr[1]['id'] = "1";
        $state_data_arr[1]['text'] = $this->lang->line('quotes_cashed');
        $state_data_arr[2]['id'] = "2";
        $state_data_arr[2]['text'] = $this->lang->line('quotes_return_receipt');
        $state_data_arr[3]['id'] = "3";
        $state_data_arr[3]['text'] = $this->lang->line('quotes_detained');

        //Payment Type
        $payment_type_data_arr[0]['id'] = "0";
        $payment_type_data_arr[0]['text'] = $this->lang->line('quotes_cash');
        $payment_type_data_arr[1]['id'] = "1";
        $payment_type_data_arr[1]['text'] = $this->lang->line('quotes_credit_card');
        $payment_type_data_arr[2]['id'] = "2";
        $payment_type_data_arr[2]['text'] = $this->lang->line('quotes_direct_debit');
        $payment_type_data_arr[3]['id'] = "3";
        $payment_type_data_arr[3]['text'] = $this->lang->line('quotes_transfer');
        $payment_type_data_arr[4]['id'] = "4";
        $payment_type_data_arr[4]['text'] = $this->lang->line('quotes_check');
        $payment_type_data_arr[5]['id'] = "5";
        $payment_type_data_arr[5]['text'] = $this->lang->line('quotes_financed');
        $payment_type_data_arr[6]['id'] = "6";
        $payment_type_data_arr[6]['text'] = $this->lang->line('quotes_online_payment');

        $this->data['doc_id_data'] = $doc_id_data_arr;
        $this->data['customer_name_data'] = $customer_name_data_arr;
        $this->data['state_data'] = $state_data_arr;
        $this->data['payment_type_data'] = $payment_type_data_arr;

        $this->layouts->view('quotes/indexView', $this->data);
    }

    public function getQuotesData(){
        $start =$this->input->post('start',  true);
        $length =$this->input->post('length', true);
        $draw = $this->input->post('draw', true);
        $search =$this->input->post('search', true);
        $order = $this->input->post('order', true);
        $columns = $this->input->post('columns', true);

        $filter_tags = array(
            'selected_doc_id' => $this->input->post('selected_doc_id', true),
            'selected_customer_name' => $this->input->post('selected_customer_name', true),
            'selected_state' => $this->input->post('selected_state', true),
            'selected_payment_type' => $this->input->post('selected_payment_type', true),
            'selected_appointment_date' => $this->input->post('selected_appointment_date', true),
        );
        
        $column = $order[0]['column'];
        $total_enrollments = $this->ReciboModel->getTotalCount();
        $enrollments_data = $this->ReciboModel->getReceiptListAjax($start, $length, $draw, $search, $order, $columns, $filter_tags);
        $recordsTotal = (int)$enrollments_data->rows;
        $response = array(
            "start"=>$start,
            "length"=>$length,
            "search"=>$search,
            "order"=>$order,
            "column"=>$column,
            "draw"=>$draw,
            "recordsFiltered"=>$recordsTotal,
            "recordsTotal"=>$recordsTotal,
            "data"=>$enrollments_data->items,
            "table_total_rows"=> $total_enrollments
        );
        echo json_encode($response); exit;
    }

    private function check_linked_invoices($quote_ids = null){
        if(empty($quote_ids)){
            return false;
        }
        
        return $this->ReciboModel->check_linked_invoice($quote_ids);
    }

    public function delete_receipt(){

        $response['success'] = false;
        $response['errors'] = array();
        if($this->input->is_ajax_request()){
            $doc_id = $this->input->post('doc_id', true);
            $checked = $this->check_linked_invoices(array($doc_id));

            if(isset($checked[0]) && isset($checked[0]->num)){
                if($checked[0]->num == 0){// there are not invoices
                    $delete_receipt = $this->ReciboModel->delete_item($doc_id);
                    if($delete_receipt){
                        $response['success'] = $this->lang->line('quotes_receipt_deleted');
                    }else{
                        $response['errors'][] = $this->lang->line('db_err_msg');
                    }
                }else if($checked[0]->num == 1){//there are invoices
                    $response['errors'][] = $this->lang->line('quotes_receipt_has_linked_delete');
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    public function cash_receipt(){

        $response['success'] = false;
        $response['errors'] = array();
        $response['receipt'] = null;
        $response['_html'] = '';
        if($this->input->is_ajax_request()){
            $doc_id = $this->input->post('doc_id', true);
            //$checked = $this->check_linked_invoices(array($doc_id));

            //if(isset($checked[0]) && isset($checked[0]->num)){
                //if($checked[0]->num == 0){// there are not invoices
                    $receipt = $this->ReciboModel->getReceiptList($doc_id, true);
                    if(isset($receipt[0]) && !empty($receipt[0])){
                        if($receipt[0]->payment_type == "2" || $receipt[0]->state != "0"){
                            $response['errors'][] = $this->lang->line('quotes_cash_due');
                        }else{
                            $this->data['receipt'] = $receipt[0];
                            $response['receipt'] = $receipt[0];
                            //Payment Type
                            $payment_type_data_arr[0]['id'] = "0";
                            $payment_type_data_arr[0]['text'] = $this->lang->line('quotes_cash');
                            $payment_type_data_arr[1]['id'] = "1";
                            $payment_type_data_arr[1]['text'] = $this->lang->line('quotes_credit_card');
                            $payment_type_data_arr[2]['id'] = "2";
                            $payment_type_data_arr[2]['text'] = $this->lang->line('quotes_direct_debit');
                            $payment_type_data_arr[3]['id'] = "3";
                            $payment_type_data_arr[3]['text'] = $this->lang->line('quotes_transfer');
                            $payment_type_data_arr[4]['id'] = "4";
                            $payment_type_data_arr[4]['text'] = $this->lang->line('quotes_check');
                            $payment_type_data_arr[5]['id'] = "5";
                            $payment_type_data_arr[5]['text'] = $this->lang->line('quotes_financed');
                            $this->data['payment_type_data'] = $payment_type_data_arr;
                            $response['_html'] = $this->load->view('quotes/partials/cash_receipt', $this->data, true);
                            $response['success'] = true;                            
                        }
                    }else{
                        $response['errors'][] = $this->lang->line('db_err_msg');
                    }
                //}else if($checked[0]->num == 1){//there are invoices
                   // $response['errors'][] = $this->lang->line('quotes_receipt_has_linked');
                /*}else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }*/
            /*}else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }*/
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }
    public function cash_receipt_update(){
        $this->load->model('CajasModel');

        $response['success'] = false;
        $response['errors'] = array();
        if($this->input->is_ajax_request()){           
            $doc_id = $this->input->post('doc_id', true);
            $history_date = $this->input->post('history_date', true);
            $memo = $this->input->post('memo', true);
            $payment_type = $this->input->post('payment_type', true);

            if(!empty($doc_id)){
                $search_date =date('Y-m-d H:i:s',strtotime($history_date));
                $cash_id='';
                $cash_id_obj = $this->CajasModel->getDailyCashByDate($search_date);
                if(!empty($cash_id_obj)){
                    $cash_id = $cash_id_obj->cash_id;

                }


                $updated_memo = $this->ReciboModel->updateItem(array('memo'=>$memo, 'ESTADO' => '1', 'IdCaja'=> $cash_id,'ID_FP' =>$payment_type), $doc_id);

                $insert_history_date = false;
                if(!empty($history_date)){
                    $this->load->model('RecibosHistoricoModel');
                    $insert_data['num_recibo'] = $doc_id;
                    $insert_data['fecha'] = $history_date;
                    $insert_history_date = $this->RecibosHistoricoModel->insertItem($insert_data);
                }
                if($updated_memo || $insert_history_date){
                    $response['success'] = $this->lang->line('data_success_saved');
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    public function edit_receipt(){

        $response['success'] = false;
        $response['errors'] = array();
        $response['receipt'] = null;
        $response['invoiced'] = false;
        $response['_html'] = '';
        if($this->input->is_ajax_request()){
            $doc_id = $this->input->post('doc_id', true);
            $checked = $this->check_linked_invoices(array($doc_id));

//            if(isset($checked[0]) && isset($checked[0]->num)){   old version
//                if($checked[0]->num == 0){// there are not invoices
//                    $receipt = $this->ReciboModel->getReceiptList($doc_id, true);
//                    if(isset($receipt[0]) && !empty($receipt[0])){
//                        $this->data['receipt'] = $receipt[0];
//                        $response['receipt'] = $receipt[0];
//                        if($response['receipt']->state == '0') {
//                            $response['_html'] = $this->load->view('quotes/partials/edit_receipt', $this->data, true);
//                            $response['success'] = true;
//                        }else{
//                            $response['_html'] = $this->load->view('quotes/partials/edit_invoiced_receipt', $this->data, true);
//                            $response['invoiced'] = 'Not invoiced';
//                        }
//
//                    }else{
//                        $response['errors'][] = $this->lang->line('db_err_msg');
//                    }
//                }else if($checked[0]->num == 1){//there are invoices
//                    $receipt = $this->ReciboModel->getReceiptList($doc_id, true);
//                    if(isset($receipt[0]) && !empty($receipt[0])){
//                        $this->data['receipt'] = $receipt[0];
//                        $response['receipt'] = $receipt[0];
//                        $response['_html'] = $this->load->view('quotes/partials/edit_invoiced_receipt', $this->data, true);
//                        $response['invoiced'] = true;
//                    }else{
//                        $response['errors'][] = $this->lang->line('db_err_msg');
//                    }
//                }else{
//                    $response['errors'][] = $this->lang->line('db_err_msg');
//                }
//            }else{
//                $response['errors'][] = $this->lang->line('db_err_msg');
//            }
            $receipt = $this->ReciboModel->getReceiptList($doc_id, true);
            if(isset($receipt[0]) && !empty($receipt[0])){
                $this->data['receipt'] = $receipt[0];
                $response['receipt'] = $receipt[0];
                if($response['receipt']->state == '0') {
                    $response['_html'] = $this->load->view('quotes/partials/edit_receipt', $this->data, true);
                    $response['success'] = true;
                }else{
                    $response['_html'] = $this->load->view('quotes/partials/edit_invoiced_receipt', $this->data, true);
                    $response['invoiced'] = 'Not invoiced';
                }

            }else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }
    public function edit_receipt_update(){

        $response['success'] = false;
        $response['errors'] = array();
        if($this->input->is_ajax_request()){
            $doc_id = $this->input->post('doc_id', true);
            $appointment_date = $this->input->post('appointment_date', true);
            $amount = $this->input->post('amount', true);
            $service = $this->input->post('service', true);

            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules('doc_id', $this->lang->line('quotes_doc_id'), 'trim|required|is_natural');
            $this->form_validation->set_rules('amount', $this->lang->line('quotes_amount'), 'trim|required|numeric');
            $this->form_validation->set_rules('service', $this->lang->line('quotes_service'), 'trim|required');
            $this->form_validation->set_rules('appointment_date', $this->lang->line('quotes_appointment_date'), 'trim|required');
            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $update_data = array();
                if($appointment_date){
                    $update_data['fecha_vto'] = date('Y-m-d', strtotime($appointment_date));
                }
                if($amount){
                    $update_data['importe'] = $amount;
                }
                if($service){
                    $update_data['concepto'] = $service;
                }
                if(!empty($update_data) && is_numeric($doc_id)){
                    $updated = $this->ReciboModel->updateItem($update_data, $doc_id);
                    if($updated){
                        $response['success'] = $this->lang->line('data_success_saved');
                    }else{
                        $response['errors'][] = $this->lang->line('db_err_msg');
                    }
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    public function filterBytags(){
        if($this->input->is_ajax_request()){

            $selected_doc_id = $this->input->post('selected_doc_id', true);
            $selected_customer_name = $this->input->post('selected_customer_name', true);
            $selected_state = $this->input->post('selected_state', true);
            $selected_payment_type = $this->input->post('selected_payment_type', true);
            $selected_appointment_date = $this->input->post('selected_appointment_date', true);
            $tags = array(
                'selected_doc_id' => $selected_doc_id,
                'selected_customer_name' => $selected_customer_name,
                'selected_state' => $selected_state,
                'selected_payment_type' => $selected_payment_type,
                'selected_appointment_date' => $selected_appointment_date,
            );

            $quotes = $this->ReciboModel->getQuotesByTags($tags);
            echo json_encode(array('data' => $quotes));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function bulk_operation() {

        $response['success'] = false;
        $response['errors'] = array();
        $response['deleted_ids'] = array();
        if ($this->input->post()) {
            $ids = $this->input->post('ids', true);
            $action = $this->input->post('action', true);

            switch ($action) {
                case 'delete':
                    
                    if(!empty($ids) && is_array($ids)){
                        foreach ($ids as $doc_id){
                            $checked = $this->check_linked_invoices(array($doc_id));
                            if(isset($checked[0]) && isset($checked[0]->num)){
                                if($checked[0]->num == 0){// there are not invoices
                                    $delete_receipt = $this->ReciboModel->delete_item($doc_id);
                                    if($delete_receipt){
                                        $response['deleted_ids'][] = $doc_id;                                        
                                    }else{
                                        if(!in_array($this->lang->line('db_err_msg'), $response['errors'])){
                                            $response['errors'][] = $this->lang->line('db_err_msg');
                                        }
                                    }
                                }else if($checked[0]->num == 1){//there are invoices
                                    if(!in_array($this->lang->line('quotes_receipt_has_linked_delete'), $response['errors'])){
                                        $response['errors'][] = $this->lang->line('quotes_receipt_has_linked_delete');
                                    }
                                }else{
                                    if(!in_array($this->lang->line('db_err_msg'), $response['errors'])){
                                        $response['errors'][] = $this->lang->line('db_err_msg');
                                    }
                                }
                            }else{
                                if(!in_array($this->lang->line('db_err_msg'), $response['errors'])){
                                    $response['errors'][] = $this->lang->line('db_err_msg');
                                }
                            }
                        }
                        if(!empty($response['deleted_ids'])){
                            $response['success'] = $this->lang->line('quotes_receipt_deleted');
                        }
                    }else{
                        if(!in_array($this->lang->line('db_err_msg'), $response['errors'])){
                            $response['errors'][] = $this->lang->line('db_err_msg');
                        }
                    }
                break;
                default:
                    if(!in_array($this->lang->line('db_err_msg'), $response['errors'])){
                        $response['errors'][] = $this->lang->line('db_err_msg');
                    }
            }
        }
        echo json_encode($response);
        exit;
    }

    public function cashQuotePrintAndEmail(){
        if($this->input->post()) {
            $this->load->model('ReciboModel');
            $this->load->model('AlumnoModel');
            $this->load->model('UsuarioModel');
            $this->load->model('ErpEmailModel');
            $this->lang->load('manage_invoice', $this->data['lang']);
            $user_id = $this->data['userData'][0]->Id;
            //$enroll_id = $this->input->post('enroll_id', true);
            $invoiced = $this->input->post('invoiced', true);
            $quote_id = $this->input->post('doc_id', true);
            $client_id = $this->input->post('client_id', true);
            $response = array();
            $response['success'] = false;
            if($quote_id) {
                $status = 1; // paid;
                $receipt = $this->ReciboModel->getQuotesDataPrint($quote_id);
                $this->data['quote'] = $receipt;
                if($invoiced == 1){
                    $this->data['invoice'] = 1;
                }
                $this->load->model('MiempresaModel');
                $this->data['fiscal_data'] = $this->MiempresaModel->get_fiscal_data();
                $scholl_name = $this->MiempresaModel->selectCustom("SELECT nombrecomercial AS company_name FROM miempresa");
                $scholl_name = isset($scholl_name[0]->company_name) ? $scholl_name[0]->company_name : '';
                if ($this->_db_details->plan != '1') {
                    $this->load->model('Variables2Model');
                    $logo = $this->Variables2Model->get_logo();
                    $this->data['logo'] = isset($logo->logo) ? $logo->logo : '';
                }else{
                    $this->data['logo'] = '';
                }
                $this->data['payment_methods'] = array(
                    0 => $this->lang->line('quotes_cash'),
                    1 => $this->lang->line('quotes_credit_card'),
                    2 => $this->lang->line('quotes_direct_debit'),
                    3 => $this->lang->line('quotes_transfer'),
                    4 => $this->lang->line('quotes_check'),
                    5 => $this->lang->line('quotes_financed'),
                    6 => $this->lang->line('quotes_online_payment')
                );

                if(!empty($this->data['quote'])) {
                    $this->html_pdf = $this->load->view('quotes/partials/print_individual_quote', $this->data, true);
                    $file_name = $this->lang->line('quote').' #'.$quote_id;
                    $mpdf = new mPDF('utf-8', 'A4', '', '', 0, 0, 0, 0, 0, 0);
                    $mpdf->list_indent_first_level = 1;  // 1 or 0 - whether to indent the first level of a list

                    // LOAD a stylesheet
                    $stylesheet = file_get_contents('assets/global/plugins/font-awesome/css/font-awesome.min.css');
                    $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
                    $stylesheet = file_get_contents('assets/global/plugins/simple-line-icons/simple-line-icons.min.css');
                    $mpdf->WriteHTML($stylesheet, 1);
                    $stylesheet = file_get_contents('assets/global/plugins/bootstrap/css/bootstrap.min.css');
                    $mpdf->WriteHTML($stylesheet, 1);
                    $stylesheet = file_get_contents('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');
                    $mpdf->WriteHTML($stylesheet, 1);
                    $stylesheet = file_get_contents('assets/global/css/components.min.css');
                    $mpdf->WriteHTML($stylesheet, 1);
                    $stylesheet = file_get_contents('assets/global/css/plugins.min.css');
                    $mpdf->WriteHTML($stylesheet, 1);
                    $stylesheet = file_get_contents('assets/pages/css/invoice.min.css');
                    $mpdf->WriteHTML($stylesheet, 1);
                    $stylesheet = file_get_contents('assets/layouts/layout3/css/layout.min.css');
                    $mpdf->WriteHTML($stylesheet, 1);
                    $stylesheet = file_get_contents('assets/layouts/layout3/css/themes/default.min.css');
                    $mpdf->WriteHTML($stylesheet, 1);
                    $stylesheet = file_get_contents('assets/layouts/layout3/css/custom.min.css');
                    $mpdf->WriteHTML($stylesheet, 1);
                    $stylesheet = file_get_contents('assets/layouts/layout3/css/custom.min.css');
                    $mpdf->WriteHTML($stylesheet, 1);

                    $mpdf->WriteHTML($this->html_pdf, 2);
                    $pdfdoc = $mpdf->Output("", "S");
                    $attachment = chunk_split(base64_encode($pdfdoc));
                    $this->data['attachment'] = $attachment;
                    $this->data['filename'] = $file_name;

                    $email_from = $this->config->item('admin_info1');
                    $from = $email_from['from'];
                    $from_ = 'admin@akaud.com';
                    //$dest_email_id = "miasnikdavtyan@gmail.com";
                    //$source_email_id = "noreply@akaud.com";
                    $student_data = $this->AlumnoModel->get_student_by_id($client_id);
                    $to = !empty($student_data->student_email) ? $student_data->student_email : null;
                    $to2 = !empty($student_data->tut1_email1) ? $student_data->tut1_email1 : null;
                    $to3 = !empty($student_data->tut2_email1) ? $student_data->tut2_email1 : null;
//                    $to = "luis@softaula.com";
//                    $to = "miasnikdavtyan@gmail.com";
// main header
                    if ($to || $to2 || $to3) {
                        $message = '';
                        if($invoiced == 0) {
                            $message .= "<p>" . $this->lang->line('quotes_dear') . "</p>";
                            $message .= "<p>" . $this->lang->line('quotes_print_email_text1') . "</p>";
                            $message .= "<p>" . $this->lang->line('quotes_print_email_text2') . "<a href='https://campus.akaud.com'>campus.akaud.com</a></p>";
                            $message .= "<p>" . $this->lang->line('quotes_print_email_text3') . "</p>";
                        }
                        $message .= "<p>" . $scholl_name . "</p>";
                        $insert_data = array(
                            'from_userid' => $user_id,
                            'id_campaign' => '',
                            'email_recipie' => $to,
                            'Subject' => $this->lang->line('quotes_email_pdf_subject') . '  ' . $scholl_name,
                            'Body' => $message,
                            'date' => date("Y-m-d H:i:s"),
                        );

                        $cisess = $this->session->userdata('_cisess');
                        $membership_type = $cisess['membership_type'];
                        $smtp_data = $this->UsuarioModel->getSmtpSettings($user_id);
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
                            $mail->FromName = $scholl_name;
                            $mail->AddAddress($to);
                            $mail->AddAddress($to2);
                            $mail->AddAddress($to3);
                            $mail->WordWrap = 1000;                                 // set word wrap to 50 characters
                            $mail->IsHTML(true);
                            // set email format to HTML

                            $mail->Subject = $this->lang->line('quotes_email_pdf_subject') . '  ' . $scholl_name;
                            $mail->Body    =$message;
                            $mail->addStringAttachment($pdfdoc, $file_name, 'base64', 'application/x-pdf');

                            $mail->AltBody = "";
                            if(!$mail->Send()) {
                                $insert_data['sucess'] = '0';
                                $insert_data['error_msg'] = null;
                                $response['success'] = true;
                            }else {
                                $response['success'] = true;
                                $insert_data['sucess'] = '1';
                                $insert_data['error_msg'] = null;
                            }
                            $this->ErpEmailModel->insertEmailData($insert_data);
                        }else {
                            $emails_limit_daily = $this->_db_details->emails_limit_daily;
                            $emails_limit_monthly = $this->_db_details->emails_limit_monthly;
                            $count_emails_day = $this->ErpEmailModel->getEmailsCountDay($user_id);
                            if($emails_limit_daily > $count_emails_day->count_daily && $emails_limit_monthly > $count_emails_day->count_monthly  ) {
                                $eol = PHP_EOL;
                                $uid = md5(uniqid(time()));
                                $header = '';
                                $header .= "From: $from " . $eol;
                                $header .= "Return-Path: " . $from_ . $eol;
                                $header .= "To: $to , $to2, $to3 " . $eol;
                                $header .= "Bcc: " . $from_ . $eol;
                                $header .= "Subject: " . $this->lang->line('quotes_email_pdf_subject') . '  ' . $scholl_name . $eol;
                                $header .= "MIME-Version: 1.0 " . $eol;
                                $header .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"" . $eol . $eol;
                                $header .= "This is a multi-part message in MIME format." . $eol;
                                $header .= "--" . $uid . $eol;
                                $header .= "Content-type:text/html; charset=iso-8859-1" . $eol;
                                $header .= "Content-Transfer-Encoding: 7bit" . $eol . $eol;
                                $header .= $message . $eol . $eol;
                                $header .= "--" . $uid . $eol;
                                $header .= "Content-Type: application/x-pdf; name=\"" . $file_name . "\"" . $eol;
                                // attachment file
                                $header .= "Content-Transfer-Encoding: base64\r\n";
                                $header .= "Content-Disposition: attachment; filename=\"" . $file_name . "\"" . $eol . $eol;
                                $header .= $attachment . $eol . $eol;
                                $header .= "--" . $uid . "--";

                                $amazon = $this->config->item('amazon');

                                $admin_info = $this->config->item('admin_info');
                                $client = SesClient::factory(array(
                                    'version' => 'latest',
                                    'region' => $amazon['email_region'],
                                    'credentials' => array(
                                        'key' => $amazon['AWSAccessKeyId'],
                                        'secret' => $amazon['AWSSecretKey'],
                                    ),
                                ));

                                try {
                                    $result = $client->sendRawEmail(array('RawMessage' => array('Data' => $header)));
                                    $messageId = $result->get('MessageId');
                                    $response['result'] = $result;
                                    $response['success'] = true;
                                    $insert_data['sucess'] = '1';
                                    $insert_data['error_msg'] = null;
                                    $this->ErpEmailModel->insertEmailData($insert_data);
                                } catch (Exception $e) {
                                    //echo("The email was not sent. Error message: ");
                                    $response['errors'] = $e->getMessage() . "\n";
                                    $insert_data['sucess'] = '0';
                                    $insert_data['error_msg'] = $e->getMessage();
                                    $this->ErpEmailModel->insertEmailData($insert_data);
//                                                    $response['errors'][] = $this->get_stripe_errors($e);
                                }
                            }else{
                                $response['errors'] = $this->lang->line('emails_limit_daily_msg');
                            }
                        }
                    }else{
                        $response['errors'] = $this->lang->line('webservice_wrong_email');
                    }
                }else{
                    $response['errors'] = $this->lang->line('quotes_have_not_paid');
                }
            }
            echo json_encode($response);exit;
        }

    }
    
    public function print_cashed_quote(){
        $response = array();
        if($this->input->post()) {
            $this->lang->load('manage_invoice', $this->data['lang']);
            $quote_id = $this->input->post('quote_id', true);
            $receipt = $this->ReciboModel->getQuotesDataPrint($quote_id);
            $this->load->model('MiempresaModel');
            $this->data['fiscal_data'] = $this->MiempresaModel->get_fiscal_data();
            if ($this->_db_details->plan != '1') {
                $this->load->model('Variables2Model');
                $logo = $this->Variables2Model->get_logo();
                $this->data['logo'] = isset($logo->logo) ? $logo->logo : '';
            }else{
                $this->data['logo'] = '';
            }
            $this->data['payment_methods'] = array(
                0 => $this->lang->line('quotes_cash'),
                1 => $this->lang->line('quotes_credit_card'),
                2 => $this->lang->line('quotes_direct_debit'),
                3 => $this->lang->line('quotes_transfer'),
                4 => $this->lang->line('quotes_check'),
                5 => $this->lang->line('quotes_financed'),
                6 => $this->lang->line('quotes_online_payment')
            );
            if (isset($receipt)) {
                $this->data['quote'] = $receipt;
                $response['html'] = $this->load->view('quotes/partials/print_cashed_quote', $this->data, true);
            }
        }
        echo json_encode($response);exit;
    }

    public function print_quote_multy_select(){
        $response = array();
        if($this->input->post()) {
            $this->lang->load('manage_invoice', $this->data['lang']);
            $quote_ids = $this->input->post('quote_ids', true);
            $receipt = $this->ReciboModel->getQuotesDataPrint($quote_ids);
            $this->load->model('MiempresaModel');
            $this->data['fiscal_data'] = $this->MiempresaModel->get_fiscal_data();
            if ($this->_db_details->plan != '1') {
                $this->load->model('Variables2Model');
                $logo = $this->Variables2Model->get_logo();
                $this->data['logo'] = isset($logo->logo) ? $logo->logo : '';
            }else{
                $this->data['logo'] = '';
            }
            $this->data['payment_methods'] = array(
                0 => $this->lang->line('quotes_cash'),
                1 => $this->lang->line('quotes_credit_card'),
                2 => $this->lang->line('quotes_direct_debit'),
                3 => $this->lang->line('quotes_transfer'),
                4 => $this->lang->line('quotes_check'),
                5 => $this->lang->line('quotes_financed'),
                6 => $this->lang->line('quotes_online_payment')
            );
            if (!empty($receipt)) {
                $this->data['quotes'] = $receipt;
                $response['html'] = $this->load->view('quotes/partials/print_quotes_multy_select', $this->data, true);
            }
        }
        echo json_encode($response);exit;
    }
    public function invoiceQuote(){
        $this->load->model('FacturaModel');
        $this->load->model('FacturalModel');
        $this->load->model('Variables2Model');
        $result = false;
        if($this->input->is_ajax_request()) {
            $quote_id = $this->input->post('qoute_id',  true);
            $res = $this->FacturaModel->insertNewInvoice($quote_id);
            if($res){
                $result = true;
                $this->FacturalModel->insertInvoiceDetal($quote_id);
                $this->ReciboModel->updateNumFactura($quote_id);
                $this->Variables2Model->updateInvoiceId();
                $inviose_id = $this->Variables2Model->getInvoiceId();
                echo json_encode(array('result'=>$result, 'inviose_id'=>$inviose_id->invoice_id));
                exit;
            }

        }
        echo json_encode(array('result'=>$result));
        exit;
    }

    public function invoice_html_to_Pdf_new($enroll_id = null, $quote_id = null){
        $receipt = $this->ReciboModel->getQuotesDataPrint($quote_id);
        $this->lang->load('manage_invoice', $this->data['lang']);
        $this->data['quote'] = $receipt;
        $this->data['invoice'] = 1;
        $this->load->model('MiempresaModel');
        $this->data['fiscal_data'] = $this->MiempresaModel->get_fiscal_data();
        //$scholl_name = $this->MiempresaModel->selectCustom("SELECT nombrecomercial AS company_name FROM miempresa");
        //$scholl_name = isset($scholl_name[0]->company_name) ? $scholl_name[0]->company_name : '';
        if ($this->_db_details->plan != '1') {
            $this->load->model('Variables2Model');
            $logo = $this->Variables2Model->get_logo();
            $this->data['logo'] = isset($logo->logo) ? $logo->logo : '';
        }else{
            $this->data['logo'] = '';
        }
        $this->data['payment_methods'] = array(
            0 => $this->lang->line('quotes_cash'),
            1 => $this->lang->line('quotes_credit_card'),
            2 => $this->lang->line('quotes_direct_debit'),
            3 => $this->lang->line('quotes_transfer'),
            4 => $this->lang->line('quotes_check'),
            5 => $this->lang->line('quotes_financed'),
            6 => $this->lang->line('quotes_online_payment')
        );
        if(!empty($this->data['quote'])) {
            $this->html_pdf = $this->load->view('quotes/partials/print_individual_quote', $this->data, true);
            $file_name = $this->lang->line('quotes_invoice_a_quote');
            $mpdf = new mPDF('utf-8', 'A4', '', '', 0, 0, 0, 0, 0, 0);
            $mpdf->list_indent_first_level = 1;  // 1 or 0 - whether to indent the first level of a list

            //$mpdf->WriteHTML($this->html_pdf);
            //$this->html_pdf = false;
            // LOAD a stylesheet
            $stylesheet = file_get_contents('assets/global/plugins/font-awesome/css/font-awesome.min.css');
            $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet = file_get_contents('assets/global/plugins/simple-line-icons/simple-line-icons.min.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents('assets/global/plugins/bootstrap/css/bootstrap.min.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents('assets/global/css/components.min.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents('assets/global/css/plugins.min.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents('assets/pages/css/invoice.min.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents('assets/layouts/layout3/css/layout.min.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents('assets/layouts/layout3/css/themes/default.min.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents('assets/layouts/layout3/css/custom.min.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents('assets/layouts/layout3/css/custom.min.css');
            $mpdf->WriteHTML($stylesheet, 1);


            $mpdf->WriteHTML($this->html_pdf);
            $mpdf->Output($file_name . '.pdf', 'D');

        }
    }
}
