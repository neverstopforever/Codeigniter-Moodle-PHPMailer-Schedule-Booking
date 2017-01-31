<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_invoices extends MY_Controller {

    public function __construct() {
        parent::__construct();

        if (empty($this->_identity['loggedIn'])) {
            redirect('/auth/login/', 'refresh');
        }
        $this->load->model('FacturaModel');
        $this->load->model('FacturalModel');
        $this->load->model('ReciboModel');
        $this->lang->load('quotes', $this->data['lang']);
        $this->lang->load('manage_invoice', $this->data['lang']);
        $this->load->library('form_validation');
        $this->layouts->add_includes('js', 'app/js/manage_invoices/main.js');
    }


    public function index() {
        $this->lang->load('quicktips', $this->data['lang']);
        $this->data['page'] = "manage_invoices_index";
        $this->layouts
            ->add_includes('css', 'assets/global/plugins/typeahead/typeahead.css')
            ->add_includes('js', 'assets/global/plugins/typeahead/handlebars.min.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.min.js');

        $this->layouts->add_includes('js', 'assets/global/plugins/select2/select2.js');
        if($this->data['lang'] == "spanish"){
            $this->layouts->add_includes('js', 'assets/global/plugins/select2/select2_locale_es.js');
        }
        $this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js');
        $this->layouts->add_includes('css', 'assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css');
        $this->layouts->add_includes('js', 'app/js/manage_invoices/index.js');


        $this->data['invoices'] = $this->FacturaModel->get_for_invoices();
        $filters = $this->select_filter_data($this->data['invoices']);
        $this->data['invoice_id_data'] = isset($filters['invoice_id_data']) ? $filters['invoice_id_data'] : array();
        $this->data['customer_name_data'] = isset($filters['customer_name_data']) ? $filters['customer_name_data'] : array();
        $this->data['doc_type_data'] = isset($filters['doc_type_data']) ? $filters['doc_type_data'] : array();
        $this->data['state_data'] = isset($filters['state_data']) ? $filters['state_data'] : array();

        $this->layouts->view('manage_invoices/indexView', $this->data);
    }

    public function getInvoiceData(){
        $start =$this->input->post('start',  true);
        $length =$this->input->post('length', true);
        $draw = $this->input->post('draw', true);
        $search =$this->input->post('search', true);
        $order = $this->input->post('order', true);
        $columns = $this->input->post('columns', true);

        $filter_tags = array(
            'selected_invoice_id' => $this->input->post('selected_invoice_id', true),
            'selected_customer_name' => $this->input->post('selected_customer_name', true),
            'selected_date' => $this->input->post('selected_date', true),
            'selected_doc_type' => $this->input->post('selected_doc_type', true),
            );

        $column = $order[0]['column'];
        $total_invoices = $this->FacturaModel->getTotalCount();
        $invoices_data = $this->FacturaModel->getInvoicesDataAjax($start, $length, $draw, $search, $order, $columns, $filter_tags);
        $recordsTotal = (int)$invoices_data->rows;
        $response = array(
            "start"=>$start,
            "length"=>$length,
            "search"=>$search,
            "order"=>$order,
            "column"=>$column,
            "draw"=>$draw,
            "recordsFiltered"=>$recordsTotal,
            "recordsTotal"=>$recordsTotal,
            "data"=>$invoices_data->items,
            "table_total_rows"=> $total_invoices
        );
        echo json_encode($response); exit;
    }

    public function edit($invoice_id = null) {
        if(empty($invoice_id)){
            redirect('manage_invoice', 'refresh');
        }
        $this->data['personal_data'] = $this->FacturaModel->get_personal_data($invoice_id);
        if(empty($this->data['personal_data'])){
            redirect('manage_invoice', 'refresh');
        }
        $this->layouts
            ->add_includes('css', 'assets/global/plugins/typeahead/typeahead.css')
            ->add_includes('js', 'assets/global/plugins/typeahead/handlebars.min.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.js')
            ->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.min.js');

        $this->layouts->add_includes('js', 'assets/global/plugins/select2/select2.js');
        if($this->data['lang'] == "spanish"){
            $this->layouts->add_includes('js', 'assets/global/plugins/select2/select2_locale_es.js');
        }
        $this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js');
        $this->layouts->add_includes('css', 'assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css');
        $this->layouts->add_includes('js', 'app/js/manage_invoices/edit.js');


        $this->data['page'] = "manage_invoices_edit";
        
        $this->data['personal_data'] = $this->FacturaModel->get_personal_data($invoice_id);
        $this->data['details'] = $this->FacturaModel->get_details($invoice_id);
        $this->data['services'] = $this->FacturalModel->get_services($invoice_id);
        $this->data['quotes'] = $this->ReciboModel->get_quotes_by_invoiceId($invoice_id);

        $this->data['payment_methods'] = array(
            0 => $this->lang->line('quotes_cash'),
            1 => $this->lang->line('quotes_credit_card'),
            2 => $this->lang->line('quotes_direct_debit'),
            3 => $this->lang->line('quotes_transfer'),
            4 => $this->lang->line('quotes_check'),
            5 => $this->lang->line('quotes_financed'),
            6 => $this->lang->line('quotes_online_payment')
        );
        $this->data['enrollments'] = null;
        if(isset($this->data['personal_data']->role)
            && $this->data['personal_data']->role == "student"){
            $this->load->model('MatriculatModel');
            $this->data['enrollments'] = $this->MatriculatModel->getEnrollmentsByStudentId($this->data['personal_data']->customer_id);
//            $this->data['enrollments'] = $this->MatriculatModel->getStudentEnrollmentsForSelect($this->data['personal_data']->customer_id);
        }
        
        $this->data['invoice_id'] = $invoice_id;

        $this->layouts->view('manage_invoices/editView', $this->data);
    }

    private function check_linked_invoices($quote_ids = null){
        if(empty($quote_ids)){
            return false;
        }

        return $this->ReciboModel->check_linked_invoice($quote_ids);
    }

    public function delete_invoice(){

        $response['success'] = false;
        $response['errors'] = array();
        $response['invoices'] = false;
        $response['filters'] = false;
        if($this->input->is_ajax_request()){
            $invoice_id = $this->input->post('invoice_id', true);
            $delete_invoice_quotes = $this->input->post('delete_invoice_quotes', true);            
            if($this->FacturaModel->deleteItem(array('N_FACTURA'=>$invoice_id))){
                $this->FacturalModel->deleteItem(array('N_FACTURA'=>$invoice_id));
                if($delete_invoice_quotes == "delete"){
                    $this->ReciboModel->delete_by_invoice_id($invoice_id);
                }else{
                    $this->ReciboModel->unlink_by_invoice_id($invoice_id);
                }
                $response['success'] = $this->lang->line('mi_invoice_success_deleted');
                $response['invoices'] = $this->FacturaModel->get_for_invoices();
                $response['filters'] = $this->select_filter_data($response['invoices']);
            }else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }            
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }


    public function edit_details_save() {
        $response['success'] = false;
        $response['errors'] = true;
        if ($this->input->is_ajax_request()) {
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules('invoice_id', $this->lang->line('mi_invoice_id'), 'trim|required|is_natural');
            $this->form_validation->set_rules('payment_method', $this->lang->line('mi_payment_method'), 'trim|required|is_natural');
            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $invoice_id = $this->input->post('invoice_id', true);
                $payment_method = $this->input->post('payment_method', true);
                $enroll_id = $this->input->post('enroll_id', true);
                $old_enroll_id = $this->input->post('old_enroll_id', true);
                $update_data['id_fp'] = $payment_method;
                if(!empty($enroll_id)){
                    $update_data['nummatricula'] = $enroll_id;
                }
                $updated = $this->FacturaModel->updateItem($update_data, array('N_FACTURA'=>$invoice_id));
                if($updated){
                    $response['success'] = $this->lang->line('data_success_saved');
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
    
    private function select_filter_data($invoices){


        $invoice_id_data_arr = array();
        $customer_name_data_arr = array();
        $state_data_arr = array();
        if($invoices){
            $count_customer_name = 0;
            foreach ($invoices as $k=>$item){

                $invoice_id_data_arr[$k]['id'] = $item->invoice_id;
                $invoice_id_data_arr[$k]['text'] = $item->invoice_id;

                //customer_name_data
                if (!in_array(array('id'=>$item->customer_id, 'text'=>$item->customer_name), $customer_name_data_arr)){
                    if(!empty($item->customer_name)){
                        $customer_name_data_arr[$count_customer_name]['id'] = $item->customer_id;
                        $customer_name_data_arr[$count_customer_name]['text'] = $item->customer_name;
                        $count_customer_name++;
                    }
                }
            }
        }

        //DocType
        $doc_type_data_arr[0]['id'] = "F";
        $doc_type_data_arr[0]['text'] = $this->lang->line('mi_doc_type_invoice');
        $doc_type_data_arr[1]['id'] = "1"; //TODO need to be confirm this value
        $doc_type_data_arr[1]['text'] = $this->lang->line('mi_doc_type_negative_invoice');

        //State
        $state_data_arr[0]['id'] = "p";
        $state_data_arr[0]['text'] = $this->lang->line('mi_remaining');
        $state_data_arr[1]['id'] = "c";
        $state_data_arr[1]['text'] = $this->lang->line('mi_cashed');
        $state_data_arr[2]['id'] = "pc";
        $state_data_arr[2]['text'] = $this->lang->line('mi_parcial_cashed');

        $filter['invoice_id_data'] = $invoice_id_data_arr;
        $filter['customer_name_data'] = $customer_name_data_arr;
        $filter['doc_type_data'] = $doc_type_data_arr;
        $filter['state_data'] = $state_data_arr;
        
        return $filter;
    }

    public function add() {
        if($this->input->is_ajax_request()){

            $this->data['roles'] = array(
                'student'=>$this->lang->line('student'),
                'company'=>$this->lang->line('company')
            );
            $this->data['doc_types'] = array(
                "F" => $this->lang->line('mi_doc_type_invoice'),
                "1" => $this->lang->line('mi_doc_type_negative_invoice')
            );
            $this->data['payment_methods'] = array(
                0 => $this->lang->line('quotes_cash'),
                1 => $this->lang->line('quotes_credit_card'),
                2 => $this->lang->line('quotes_direct_debit'),
                3 => $this->lang->line('quotes_transfer'),
                4 => $this->lang->line('quotes_check'),
                5 => $this->lang->line('quotes_financed'),
                6 => $this->lang->line('quotes_online_payment')
            );

            $this->load->model('Variables2Model');
            $invoice_id = $this->Variables2Model->get_new_invoice_id();
            if(!empty($invoice_id)){
                $invoice_id = $invoice_id->invoice_id;
            }
            $this->data['invoice_id'] = $invoice_id;
            $this->data['date'] = date($this->data['datepicker_format']); //current date

            $html = $this->load->view('manage_invoices/partials/add',$this->data,true);
            
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
        
    }

    public function add_service() {
        if($this->input->is_ajax_request()){
            $invoice_id = $this->input->post('invoice_id', true);
            $this->data['invoice_id'] = $invoice_id;
            $this->data['date'] = date($this->data['datepicker_format']); //current date
            $this->load->model('ImpuestoModel');
            $this->data['vats'] = $this->ImpuestoModel->get_all();


            $html = $this->load->view('manage_invoices/partials/edit/add_service',$this->data,true);

            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }

    }
    public function add_service_save() {
        $response['success'] = false;
        $response['errors'] = true;
        $response['services'] = false;
        if ($this->input->is_ajax_request()) {
            $post_data = $this->input->post(null, true);
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules('reference', $this->lang->line('mi_reference'), 'trim|required');
            $this->form_validation->set_rules('description', $this->lang->line('mi_description'), 'trim|required');
            $this->form_validation->set_rules('units', $this->lang->line('mi_units'), 'trim|required|callback_float_number_check');
            $this->form_validation->set_rules('price_by_unit', $this->lang->line('mi_price_by_unit'), 'trim|required|callback_float_number_check');
//            $this->form_validation->set_rules('total_amount', $this->lang->line('mi_total_amount'), 'trim|required|callback_float_number_check');
            $this->form_validation->set_rules('vat', $this->lang->line('mi_vat'), 'trim|required|callback_float_number_check');
            $this->form_validation->set_rules('invoice_id', $this->lang->line('mi_invoice_id'), 'trim|required|is_natural');
            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $invoice_id = $this->input->post('invoice_id', true);
                $price_by_unit = $this->input->post('price_by_unit', true);
                $units = $this->input->post('units', true);
                $reference = $this->input->post('reference', true);
                $description = $this->input->post('description', true);

                $vat = $this->input->post('vat', true);
                $total_amount = (($price_by_unit * $units) * $vat) / 100 + ($price_by_unit * $units);
                $total_amount = round($total_amount, 3);

                $inserted = $this->FacturalModel->insertItem($invoice_id, $reference, $description, $price_by_unit, $units, $vat, $total_amount);
                if ($inserted) {
                    $response['success'] =  $this->lang->line('data_success_saved');
                    $response['services'] = $this->FacturalModel->get_services($invoice_id);
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

    public function edit_service() {
        if($this->input->is_ajax_request()){
            $html = '';
            $service_id = $this->input->post('service_id', true);
            $this->data['service'] = $this->FacturalModel->get_service_by_id($service_id);
            if(!empty($this->data['service'])){
                $this->load->model('ImpuestoModel');
                $this->data['vats'] = $this->ImpuestoModel->get_all();
                $html = $this->load->view('manage_invoices/partials/edit/edit_service',$this->data,true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }

    }
    public function edit_service_save() {
        $response['success'] = false;
        $response['errors'] = true;
        $response['services'] = false;
        if ($this->input->is_ajax_request()) {
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules('reference', $this->lang->line('mi_reference'), 'trim|required');
            $this->form_validation->set_rules('description', $this->lang->line('mi_description'), 'trim|required');
            $this->form_validation->set_rules('units', $this->lang->line('mi_units'), 'trim|required|callback_float_number_check');
            $this->form_validation->set_rules('price_by_unit', $this->lang->line('mi_price_by_unit'), 'trim|required|callback_float_number_check');
//            $this->form_validation->set_rules('total_amount', $this->lang->line('mi_total_amount'), 'trim|required|callback_float_number_check');
            $this->form_validation->set_rules('invoice_id', $this->lang->line('mi_invoice_id'), 'trim|required|is_natural');
            $this->form_validation->set_rules('service_id', $this->lang->line('mi_service_id'), 'trim|required|is_natural');
            $this->form_validation->set_rules('vat', $this->lang->line('mi_vat'), 'trim|required|callback_float_number_check');
            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $service_id = $this->input->post('service_id', true);
                $invoice_id = $this->input->post('invoice_id', true);
                $price_by_unit = $this->input->post('price_by_unit', true);
                $units = $this->input->post('units', true);
                $reference = $this->input->post('reference', true);
                $description = $this->input->post('description', true);
                $vat = $this->input->post('vat', true);
                $total_amount = (($price_by_unit * $units) * $vat) / 100 + ($price_by_unit * $units);
                $total_amount = round($total_amount, 3);
                $update_service = array(
//                    'n_factura' => $invoice_id,
                    'referencia' => $reference,
                    'descripcion' => $description,
                    'precio' => $price_by_unit,
                    'unidades' => $units,
                    'impuesto' => $vat,
                    'importe' => $total_amount,
                    'idcentro' => '0'
                );

                $updated = $this->FacturalModel->updateItem($update_service, array('Num'=>$service_id));
                if ($updated) {
                    $response['success'] =  $this->lang->line('data_success_saved');
                    $response['services'] = $this->FacturalModel->get_services($invoice_id);
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
    public function delete_service(){

        $response['success'] = false;
        $response['errors'] = array();
        $response['services'] = false;
        if($this->input->is_ajax_request()){
            $service_id = $this->input->post('service_id', true);
//            $invoice_id = $this->input->post('invoice_id', true);
            if($this->FacturalModel->deleteItem(array('Num'=>$service_id))){
                $response['success'] = $this->lang->line('mi_service_success_deleted');
//                $response['services'] = $this->FacturalModel->get_services($invoice_id);
            }else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }
    
    //quotes

    public function add_free_quote() {
        if($this->input->is_ajax_request()){
            $response['html'] = '';
            $response['enroll_id'] = 0;
            $invoice_id = $this->input->post('invoice_id', true);
            $student_id = $this->input->post('student_id', true);
            $invoice_linked = $this->FacturaModel->check_linked_invoice($invoice_id);
            if(!empty($invoice_linked) && isset($invoice_linked->invoice_linked)){
                if($invoice_linked->invoice_linked == 1){ //linked
                    $response['enroll_id'] = $invoice_linked->enroll_id;
                }else{ //mot linked
                    $this->data['invoice_id'] = $invoice_id;
                    $this->data['student_id'] = $student_id;
//                    $this->data['enroll_id'] = 0;

                    $this->data['payment_type'][0] = $this->lang->line('quotes_cash');
                    $this->data['payment_type'][1] = $this->lang->line('quotes_credit_card');
                    $this->data['payment_type'][2] = $this->lang->line('quotes_direct_debit');
                    $this->data['payment_type'][3] = $this->lang->line('quotes_transfer');
                    $this->data['payment_type'][4] = $this->lang->line('quotes_check');
                    $this->data['payment_type'][5] = $this->lang->line('quotes_financed');
                    $this->data['payment_type'][6] = $this->lang->line('quotes_online_payment');

                    $response['html'] = $this->load->view('manage_invoices/partials/edit/add_free_quote',$this->data,true);
                }
            }
            echo json_encode($response);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }

    }
    public function add_free_quote_save(){
        $this->load->helper('security');
        $response['success'] = false;
        $response['errors'] = array();
        $response['quotes'] = array();
        if($this->input->is_ajax_request()){
            $appointment_date = $this->input->post('appointment_date', true);
            $amount = $this->input->post('amount', true);
            $service = $this->input->post('service', true);
//            $total = $this->input->post('total', true);
            $payment_type = $this->input->post('payment_type', true);
            $student_id = $this->input->post('student_id', true);
            $enroll_id = $this->input->post('enroll_id', true);
            $invoice_id = $this->input->post('invoice_id', true);
            $discount = $this->input->post('discount', true);
            $reference_of_quote = $this->input->post('reference_of_quote', true);


            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules('payment_type', $this->lang->line('quotes_payment_type'), 'trim|required');
//            $this->form_validation->set_rules('total', $this->lang->line('quotes_total'), 'trim|required|numeric');
            $this->form_validation->set_rules('amount', $this->lang->line('quotes_amount'), 'trim|required|numeric');
            if($this->input->post('discount', true)) {
                $this->form_validation->set_rules('discount', $this->lang->line('quotes_discount_to_apply'), 'trim|numeric');
            }
            $this->form_validation->set_rules('service', $this->lang->line('quotes_service'), 'trim|xss_clean|required');
            $this->form_validation->set_rules('reference_of_quote', $this->lang->line('quotes_reference_of_quote'), 'trim|xss_clean|required|callback_alpha_dash_space');
            $this->form_validation->set_rules('appointment_date', $this->lang->line('quotes_appointment_date'), 'trim|required');
            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $insert_data = array();

                if($appointment_date){
                    $insert_data['fecha_vto'] = date("Y-m-d H:i:s", strtotime($appointment_date));
                }
                if($amount){
                    $insert_data['importe'] = $amount;
                }
                if($service){
                    $insert_data['concepto'] = $service;
                }

                if(isset($amount)){
                    $insert_data['neto'] = $amount - ($amount * $discount) / 100;
                }else{
                    $insert_data['neto'] = 0;
                }

                if(isset($payment_type)){
                    $insert_data['id_fp'] = $payment_type;
                }
                if($reference_of_quote){
                    $insert_data['referencia'] = $reference_of_quote;
                }
                if($student_id){
                    $insert_data['idcliente'] = $student_id;
                }
                if($enroll_id){
                    $insert_data['nummatricula'] = $enroll_id;
                }
                if($invoice_id){
                    $insert_data['n_factura'] = $invoice_id;
                }
                $inserted = $this->ReciboModel->add_free_quote($insert_data);

                if($inserted){
                    $response['success'] = $this->lang->line('data_success_saved');
                    $response['quotes'] = $this->ReciboModel->get_quotes_by_invoiceId($invoice_id);
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


    public function edit_free_quote() {
        if($this->input->is_ajax_request()){
            $response['html'] = '';
            $response['errors'] = array();
            $response['enroll_id'] = 0;
            $invoice_id = $this->input->post('invoice_id', true);
            $quote_id = $this->input->post('quote_id', true);

            $invoice_linked = $this->FacturaModel->check_linked_invoice($invoice_id);
            if(!empty($invoice_linked) && isset($invoice_linked->invoice_linked)){
                if($invoice_linked->invoice_linked == 1){ //linked
                    $response['enroll_id'] = $invoice_linked->enroll_id;
                }else{ //mot linked
                    $this->data['invoice_id'] = $invoice_id;
                    $this->data['quote'] = $this->ReciboModel->findOne(array(
                        'num_recibo'=>$quote_id,
                        'n_factura'=>$invoice_id,
                    ));
                    if(!empty($this->data['quote'])){
                        $this->data['payment_type'][0] = $this->lang->line('quotes_cash');
                        $this->data['payment_type'][1] = $this->lang->line('quotes_credit_card');
                        $this->data['payment_type'][2] = $this->lang->line('quotes_direct_debit');
                        $this->data['payment_type'][3] = $this->lang->line('quotes_transfer');
                        $this->data['payment_type'][4] = $this->lang->line('quotes_check');
                        $this->data['payment_type'][5] = $this->lang->line('quotes_financed');
                        $this->data['payment_type'][6] = $this->lang->line('quotes_online_payment');

                        $response['html'] = $this->load->view('manage_invoices/partials/edit/edit_free_quote',$this->data,true);
                    }else{
                        $response['errors'][] = $this->lang->line('db_err_msg');
                    }

                   
                }
            }
            echo json_encode($response);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }

    }

    public function edit_free_quote_save(){
        $this->load->helper('security');
        $response['success'] = false;
        $response['errors'] = array();
        $response['quotes'] = array();
        if($this->input->is_ajax_request()){

            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules('payment_type', $this->lang->line('quotes_payment_type'), 'trim|required');
//            $this->form_validation->set_rules('total', $this->lang->line('quotes_total'), 'trim|required|numeric');
            $this->form_validation->set_rules('amount', $this->lang->line('quotes_amount'), 'trim|required|numeric');
            if($this->input->post('discount', true)) {
                $this->form_validation->set_rules('discount', $this->lang->line('quotes_discount_to_apply'), 'trim|numeric');
            }
            $this->form_validation->set_rules('edit_service', $this->lang->line('quotes_service'), 'trim|xss_clean|required');
            $this->form_validation->set_rules('reference_of_quote', $this->lang->line('quotes_reference_of_quote'), 'trim|xss_clean|required|callback_alpha_dash_space');
            $this->form_validation->set_rules('appointment_date', $this->lang->line('quotes_appointment_date'), 'trim|required');
            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $quote_id = $this->input->post('quote_id', true);
                $appointment_date = $this->input->post('appointment_date', true);
                $amount = $this->input->post('amount', true);
                $service = $this->input->post('edit_service', true);
//            $total = $this->input->post('total', true);
                $payment_type = $this->input->post('payment_type', true);
                $student_id = $this->input->post('student_id', true);
                $enroll_id = $this->input->post('enroll_id', true);
                $invoice_id = $this->input->post('invoice_id', true);
                $discount = $this->input->post('discount', true);
                $reference_of_quote = $this->input->post('reference_of_quote', true);
                
                $data = array();

                if($appointment_date){
                    $data['fecha_vto'] = date("Y-m-d H:i:s", strtotime($appointment_date));
                }
                if($amount){
                    $data['importe'] = $amount;
                }
                if($service){
                    $data['concepto'] = $service;
                }
                if(isset($amount)){
                    $total = $amount - ($amount * $discount) / 100;
                }else{
                    $total = 0;
                }
//                if($total){
                $data['neto'] = $total;
//                }
                if(isset($payment_type)){
                    $data['id_fp'] = $payment_type;
                }
                if($reference_of_quote){
                    $data['referencia'] = $reference_of_quote;
                }
                if($student_id){
                    $data['idcliente'] = $student_id;
                }
                if($enroll_id){
                    $data['nummatricula'] = $enroll_id;
                }
                if($invoice_id){
                    $data['n_factura'] = $invoice_id;
                }
                $updated = $this->ReciboModel->edit_free_quote($data, $quote_id);

                if($updated){
                    $response['success'] = $this->lang->line('data_success_saved');
                    $response['quotes'] = $this->ReciboModel->get_quotes_by_invoiceId($invoice_id);
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


    public function delete_quote(){
        $response['success'] = false;
        $response['errors'] = array();
        if($this->input->is_ajax_request()){
            $quote_id = $this->input->post('quote_id', true);            
            $invoice_id = $this->input->post('invoice_id', true);
            $delete_where = array(
                'num_recibo'=>$quote_id,
                'n_factura'=>$invoice_id
            );
            $deleted = $this->ReciboModel->deleteItem($delete_where);
            if( $deleted){
                $response['success'] = $this->lang->line('quotes_receipt_deleted');
            }else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }
    
    public function alpha_dash_space($str_in = '')
    {
        if (! preg_match("/^([-a-z0-9_ ])+$/i", $str_in))
        {
            $this->form_validation->set_message('_alpha_dash_space', $this->lang->line('form_validation_alpha_dash_space'));
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function add_save() {
        $response['success'] = false;
        $response['errors'] = true;
        $response['invoices'] = false;
        $response['filters'] = false;
        if ($this->input->is_ajax_request()) {
            $post_data = $this->input->post(null, true);
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules('doc_type', $this->lang->line('mi_type_of_doc'), 'trim|required');
            $this->form_validation->set_rules('role', $this->lang->line('mi_student_company'), 'trim|required');
            $this->form_validation->set_rules('select_name', $this->lang->line('mi_select_name'), 'trim|required');
            $this->form_validation->set_rules('date', $this->lang->line('date'), 'trim|required');
            $this->form_validation->set_rules('payment_method', $this->lang->line('mi_payment_method'), 'trim|required');
            $this->form_validation->set_rules('select_name_id', $this->lang->line('mi_select_name'), 'trim|required|is_natural');
            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $date = $this->input->post('date', true);
                $doc_type = $this->input->post('doc_type', true);
                $select_name_id = $this->input->post('select_name_id', true);
                $payment_method = $this->input->post('payment_method', true);
                $role = $this->input->post('role', true);
                $this->load->model('Variables2Model');
                if($this->Variables2Model->updateInvoiceId()){
                    $invoice_id = $this->Variables2Model->getInvoiceId();
                    if(!empty($invoice_id)){
                        $invoice_id = $invoice_id->invoice_id;
                        $this->load->model('FacturaModel');
                        if($role == "student"){
                            $this->FacturaModel->add_student_item($invoice_id, $date, $doc_type, $select_name_id, $payment_method);
                            $response['success'] = $this->lang->line('data_success_saved');
                            $response['invoices'] = $this->FacturaModel->get_for_invoices();
                            $response['filters'] = $this->select_filter_data($response['invoices']);
                        }elseif($role == "company"){
                            $response['success'] = $this->lang->line('data_success_saved');
                            $response['invoices'] = $this->FacturaModel->get_for_invoices();
                            $response['filters'] = $this->select_filter_data($response['invoices']);
                            $this->FacturaModel->add_company_item($invoice_id, $date, $doc_type, $select_name_id, $payment_method);
                        }else{
                            $response['errors'][] = $this->lang->line('db_err_msg');
                        }
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
    public function get_customers(){
        if($this->input->is_ajax_request()){
            $data = null;
            $role = $this->input->post('role', true);
            if($role == "student"){
                $this->load->model('AlumnoModel');
                $data = $this->AlumnoModel->get_students_for_select();
            }elseif($role == "company"){
                $this->load->model('ClientModel');
                $data = $this->ClientModel->get_companies_for_select();
            }
            echo json_encode(array('data'=>$data));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function filterBytags(){
        if($this->input->is_ajax_request()){

            $selected_invoice_id = $this->input->post('selected_invoice_id', true);
            $selected_customer_name = $this->input->post('selected_customer_name', true);
            $selected_state = $this->input->post('selected_state', true);
            $selected_doc_type = $this->input->post('selected_doc_type', true);
            $selected_date = $this->input->post('selected_date', true);
            $tags = array(
                'selected_invoice_id' => $selected_invoice_id,
                'selected_customer_name' => $selected_customer_name,
                'selected_state' => $selected_state,
                'selected_doc_type' => $selected_doc_type,
                'selected_date' => $selected_date,
            );

            $invoices = $this->FacturaModel->getInvoicesByTags($tags);
            echo json_encode(array('data' => $invoices));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }


    function float_number_check($num)
    {
        if(!is_numeric($num)){
            $this->form_validation->set_message( 'float_number_check', $this->lang->line('form_validation_must_float_type') );
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function print_individual_invoice(){
        if($this->input->is_ajax_request()){
            $response['html'] = '';
            $invoice_id = $this->input->post('invoice_id', true);
            if(!empty($invoice_id)){
                $this->data['page'] = "manage_invoices_edit";

                $this->data['personal_data'] = $this->FacturaModel->get_personal_data($invoice_id);
                $this->data['details'] = $this->FacturaModel->get_details($invoice_id);
                $this->data['services'] = $this->FacturalModel->get_services($invoice_id);

                $this->load->model('MiempresaModel');
                $this->data['fiscal_data'] = $this->MiempresaModel->get_fiscal_data();

                if ($this->_db_details->plan != '1'){
                    $this->load->model('Variables2Model');
                    $logo = $this->Variables2Model->get_logo();
                    $this->data['logo'] = isset($logo->logo) ? $logo->logo : '';
                }else{
                    $this->data['logo'] = '';
                }
//                $this->data['quotes'] = $this->ReciboModel->get_quotes_by_invoiceId($invoice_id);

                $this->data['payment_methods'] = array(
                    0 => $this->lang->line('quotes_cash'),
                    1 => $this->lang->line('quotes_credit_card'),
                    2 => $this->lang->line('quotes_direct_debit'),
                    3 => $this->lang->line('quotes_transfer'),
                    4 => $this->lang->line('quotes_check'),
                    5 => $this->lang->line('quotes_financed'),
                    6 => $this->lang->line('quotes_online_payment')
                );
                $this->data['enrollments'] = null;
                if(isset($this->data['personal_data']->role)
                    && $this->data['personal_data']->role == "student"){
                    $this->load->model('MatriculatModel');
            $this->data['enrollments'] = $this->MatriculatModel->getEnrollmentsByStudentId($this->data['personal_data']->customer_id);
//                    $this->data['enrollments'] = $this->MatriculatModel->getStudentEnrollmentsForSelect();
                }

                $this->data['invoice_id'] = $invoice_id;
                
                $response['html'] = $this->load->view('manage_invoices/partials/edit/print_individual_invoice',$this->data,true);
            }
//            echo json_encode($response);
            echo $response['html'];
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function print_individual_invoice_quote(){
        if($this->input->is_ajax_request()){
            $response['html'] = '';
            $invoice_id = $this->input->post('invoice_id', true);
            $quote_id = $this->input->post('quote_id', true);
            if(!empty($invoice_id)){
                $this->data['page'] = "manage_invoices_edit";

                $this->data['personal_data'] = $this->FacturaModel->get_personal_data($invoice_id);
                $this->data['details'] = $this->FacturaModel->get_details($invoice_id);
//                $this->data['services'] = $this->FacturalModel->get_services($invoice_id);
                $this->data['quotes'] = $this->ReciboModel->get_quotes_by_invoiceId($invoice_id, $quote_id);

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
                $this->data['enrollments'] = null;
                if(isset($this->data['personal_data']->role)
                    && $this->data['personal_data']->role == "student"){
                    $this->load->model('MatriculatModel');
            $this->data['enrollments'] = $this->MatriculatModel->getEnrollmentsByStudentId($this->data['personal_data']->customer_id);
//                    $this->data['enrollments'] = $this->MatriculatModel->getStudentEnrollmentsForSelect();
                }

                $this->data['invoice_id'] = $invoice_id;
                
                $response['html'] = $this->load->view('manage_invoices/partials/edit/print_individual_invoice_quote',$this->data,true);
            }
//            echo json_encode($response);
            echo $response['html'];
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function print_invoices_multy_select(){
        if($this->input->is_ajax_request()){
            $response['html'] = '';
            $invoice_ids = $this->input->post('invoice_ids', true);
            if(!empty($invoice_ids) && is_array($invoice_ids)){
                $this->data['page'] = "manage_invoices_edit";

                $this->data['personal_datas'] = $this->FacturaModel->get_personal_data($invoice_ids);

                $this->data['details'] = $this->FacturaModel->get_details($invoice_ids);
                $this->data['services'] = $this->FacturalModel->get_services($invoice_ids);
                if(!empty($this->data['services'])){ // group services by invoice_id
                    foreach($this->data['services'] as $services){
                        $this->data['services_by_invoce_id'][$services->invoice_id][] =  $services;
                    }
                }
                if(!empty($this->data['details'])){ // group services by invoice_id
                    foreach($this->data['details'] as $details){
                        $this->data['details_by_invoce_id'][$details->invoice_id] =  $details;
                    }
                }
                if(!empty($this->data['personal_datas'] && !empty($this->data['details_by_invoce_id']))) {
                    $this->load->model('MiempresaModel');
                    $this->data['fiscal_data'] = $this->MiempresaModel->get_fiscal_data();

                    if ($this->_db_details->plan != '1') {
                        $this->load->model('Variables2Model');
                        $logo = $this->Variables2Model->get_logo();
                        $this->data['logo'] = isset($logo->logo) ? $logo->logo : '';
                    } else {
                        $this->data['logo'] = '';
                    }
//                $this->data['quotes'] = $this->ReciboModel->get_quotes_by_invoiceId($invoice_id);

                    $this->data['payment_methods'] = array(
                        0 => $this->lang->line('quotes_cash'),
                        1 => $this->lang->line('quotes_credit_card'),
                        2 => $this->lang->line('quotes_direct_debit'),
                        3 => $this->lang->line('quotes_transfer'),
                        4 => $this->lang->line('quotes_check'),
                        5 => $this->lang->line('quotes_financed'),
                        6 => $this->lang->line('quotes_online_payment')
                    );
                    $this->data['enrollments'] = null;
                    if (isset($this->data['personal_data']->role)
                        && $this->data['personal_data']->role == "student"
                    ) {
                        $this->load->model('MatriculatModel');
            $this->data['enrollments'] = $this->MatriculatModel->getEnrollmentsByStudentId($this->data['personal_data']->customer_id);
//                        $this->data['enrollments'] = $this->MatriculatModel->getStudentEnrollmentsForSelect();
                    }

                    $response['html'] = $this->load->view('manage_invoices/partials/index/print_individual_invoice_multy_select', $this->data, true);
                }
             }
            echo json_encode($response);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
}
